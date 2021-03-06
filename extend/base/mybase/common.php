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

use think\facade\Config;
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
    $status = $values = null;
    $full_url = config('sms.ihuyi.url') . '?' . http_build_query($params);
    try {
        $string = curl_get($full_url);
        $xml = xml_parser_create();
        xml_parse_into_struct($xml, $string, $values);
        xml_parser_free($xml);
        $status = $values[1]['value'];
    } catch (\Exception $e) {
    }
    if ($status != 2) {
        return $values[3]['value'];
    }
    return $status;
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
    $url = (strpos($url, '?') !== false) ? ($url . '&') : ($url . '?');
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
 * Describe:获取管理员ID
 *
 * @return mixed
 * @author lidong<947714443@qq.com>
 * @date   2019/10/17 0017
 */
function get_admin_id() {
    return session('admin_id');
}

/**
 * Describe:
 *
 * @return mixed
 * @author lidong<947714443@qq.com>
 * @date   2019/10/31 0031
 */
function get_admin() {
    return session('admin');
}

/**
 * Describe:设置管理员ID
 *
 * @param $admin_id
 *
 * @author lidong<947714443@qq.com>
 * @date   2019/10/31 0031
 */
function set_admin_id($admin_id) {
    session('admin_id', $admin_id);
}

/**
 * Describe:
 *
 * @param $admin
 *
 * @author lidong<947714443@qq.com>
 * @date   2019/10/31 0031
 */
function set_admin($admin) {
    session('admin', $admin);
}

/**
 * Describe:获取用户ID
 *
 * @return mixed
 * @author lidong<947714443@qq.com>
 * @date   2019/10/17 0017
 */
function get_user_id() {
    return session('user_id');
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

/**
 * Describe:设置每页显示条数可选值
 *
 * @param mixed|int|array $var  可选值
 * @param bool            $flag 是否保留配置文件设定值[当第一个参数为数组时生效]
 *
 * @return bool
 * @author lidong<947714443@qq.com>
 * @date   2019/11/6 0006
 */
function set_page_length($var, $flag = true) {
    if (!is_numeric($var) && !is_array($var)) {
        return false;
    }
    $page_length = config::get('paginate.page_length');
    if ($flag === false) {
        $page_length = [];
    }
    if (is_array($var)) {
        $page_length = array_merge($page_length, $var);
    } else {
        $page_length[] = $var;
    }
    sort($page_length);
    Config::set('paginate.page_length', $page_length);
    return true;
}

/**
 * Describe:获取每页显示条数可选值；
 *
 * @return mixed
 * @author lidong<947714443@qq.com>
 * @date   2019/11/6 0006
 */
function get_page_length() {
    return Config::get('paginate.page_length');
}

/**
 * Describe:设置每页显示条数
 *
 * @param int $num
 *
 * @author lidong<947714443@qq.com>
 * @date   2019/11/6 0006
 */
function set_page_limit($num = 0) {
    if (!is_numeric($num) || $num <= 0) {
        return;
    }
    session('page_limit', $num);
}

/**
 * Describe:获取每页显示条数
 *
 * @return mixed
 * @author lidong<947714443@qq.com>
 * @date   2019/11/6 0006
 */
function get_page_limit() {
    return session('page_limit');
}