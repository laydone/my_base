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

use think\Image;

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
 * @throws \Exception
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
    $string = curl_get($full_url);
    $xml = xml_parser_create();
    xml_parse_into_struct($xml, $string, $values);
    xml_parser_free($xml);
    $status = $values[1]['value'];
    if ($status != 2) {
        return $values[3]['value'];
    } else {
        return $status;
    }

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

/**
 * Describe:下载远程文件
 *
 * @param string $url       远程文件路径
 * @param string $path      本地保存文件路径
 * @param string $file_name 保存后文件地址[引用传递]
 *
 * @return bool
 * @author lidong<947714443@qq.com>
 * @date   2019/9/20 0020
 */
function down_file($url, $path = '', &$file_name = '') {
    if (!@fopen($url, 'r')) {
        return false;
    }
    mkdir_chmod($path);
    $arr = parse_url($url);
    $file_name = basename($arr['path']);
    $file = file_get_contents($url);
    $file_name = $path . $file_name;
    file_put_contents($file_name, $file);

    return true;
}

/**
 * Describe:
 *
 * @param string $image  需要缩略的图片地址
 * @param int    $width  缩略图的最大宽度
 * @param int    $height 缩略图的最大高度
 *
 * @return string
 * @author lidong<947714443@qq.com>
 * @date   2019/9/20 0020
 */
function thumb($image, $width = 200, $height = 200) {
    if (!file_exists($image)) { /* 图片不存在直接返回空 */
        return '';
    }
    $img_info = pathinfo($image);
    $type = $img_info['extension']; /* 获取原图后缀 */
    $ImageResource = Image::open($image); /* 读取原图信息 */
    $NewImgResource = $ImageResource->thumb($width, $height); /* 生成缩略图 */
    $new_img_width = $NewImgResource->width(); /* 获取新图片宽度 */
    $new_img_height = $NewImgResource->height();
    $new_img = $img_info['dirname'] . '/' . $img_info['filename'] . '@' . $new_img_width . 'x' . $new_img_height . '.' . $type;
    $NewImgResource->save($new_img);

    return $new_img;
}

/**
 * Describe: 获取通讯协议类型(get_http_type)
 *
 * @return string
 * @author lidong<947714443@qq.com>
 * @date   2019/9/20 0020
 */
function get_protocol() {
    $http_type = ((isset($_SERVER['HTTPS']) && ($_SERVER['SERVER_PORT'] == 443 || $_SERVER['HTTPS'] == 1 || $_SERVER['HTTPS'] == 'on')) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

    return $http_type;
}