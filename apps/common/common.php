<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | File Describe:公共应用文件
 */
/*------------------------------------------------------------------------*/
/**
 * Describe:common function test
 *
 * @author lidong<947714443@qq.com>
 * @date   2019/9/17 0017
 */
function test() {
	dump('test function ');
}

/**
 * Describe:互亿无线短信发送
 *
 * @param string $mobile  接收短信的手机号
 * @param string $content 短信内容
 *
 * @return string
 * @author lidong<947714443@qq.com>
 * @date   2019/9/20 0020
 */
function ihuyi_sms($mobile, $content) {
	$params = [
		'method'   => 'Submit',
		'account'  => config('sms.ihuyi.account'),
		'password' => config('sms.ihuyi.pwd'),
		'mobile'   => $mobile,
		'content'  => $content,
	];
	$full_url = config('sms.ihuyi.url') . '?' . http_build_query($params);

	return $full_url;
}

/**
 * Describe:模拟GET请求
 *
 * @param string $url  请求的地址
 * @param array  $data 附加的参数
 * @param bool   $ssl  是否ssl请求(https)
 *
 * @throws \Exception
 * @return bool|string
 * @author lidong<947714443@qq.com>
 * @date   2019/9/20 0020
 */
function curl_get($url, $data = [], $ssl = false) {
	$url = (strpos($url) !== false) ? ($url . '&') : ($url . '?');
	$ext_params = '';
	if (!empty($data)) {
		$ext_params = is_string($data) ? $data : http_build_query($data);
	}
	$full_url = $url . $ext_params;
	/* 设置选项，包括URL */
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $full_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	if ($ssl) {  /* 是否开启SSL */
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	}
	$output = curl_exec($ch); /* 执行并获取返回文档内容 */
	$errno = curl_errno($ch);
	$info = curl_getinfo($ch);
	curl_close($ch); /* 释放curl句柄 */
	if ($errno > 0) { /* CURL 执行出错 则抛出异常 */
		$error = curl_error($ch);
		throw new \Exception($error);
	}
	if ($info['http_code'] == '200') {
		return $output;
	}

	return false;
}

/**
 * Describe:模拟POST请求
 *
 * @param string $url  请求的地址
 * @param array  $data 附加的参数
 * @param bool   $ssl  是否ssl请求(https)
 *
 * @throws \Exception
 * @return bool|string
 * @author lidong<947714443@qq.com>
 * @date   2019/9/20 0020
 */
function curl_post($url, $data = [], $ssl = false) {
	/* 设置选项，包括URL */
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url); /* 设置URL */
	curl_setopt($ch, CURLOPT_POST, 1); /* 设置请求为POST请求 */
	curl_setopt($ch, CURLOPT_HEADER, 0); /* 设置请求头 */
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); /* 设置请求参数*/
	if ($ssl) { /* 是否开启SSL */
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	}
	$output = curl_exec($ch);
	$errno = curl_errno($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	if ($errno > 0) { /* CURL 执行出错 则抛出异常 */
		$error = curl_error($ch);
		throw new \Exception($error);
	}
	if ($info['http_code'] == '200') {
		return $output;
	}

	return false;
}