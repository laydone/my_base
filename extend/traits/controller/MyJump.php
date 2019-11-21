<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/11/21 0021
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace traits\controller;

use think\exception\HttpResponseException;
use think\facade\Response;

/**
 * Describe:
 * Trait MyJump
 *
 * @package traits\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/11/21 0021
 */
trait MyJump {
    /**
     * Describe:ajax成功返回
     *
     * @param string $msg    返回提示消息
     * @param string $data   返回数据
     * @param string $url    跳转url
     * @param array  $header 返回头信息
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/22 0022
     */
    public function ajax_success($msg = '', $data = '', $url = '', $header = []) {
        $code = 1;
        return $this->format_return($msg, $data, $code, $url, $header);
    }


    /**
     * Describe:ajax错误返回
     *
     * @param string $msg    返回提示消息
     * @param string $data   返回数据
     * @param string $url    跳转链接
     * @param array  $header 返回头信息
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/22 0022
     */
    public function ajax_error($msg = '', $data = '', $url = '', $header = []) {
        $code = 0;
        return $this->format_return($msg, $data, $code, $url, $header);
    }


    /**
     * Describe:格式化返回数据
     *
     * @param string $msg    返回提示消息
     * @param string $data   返回数据
     * @param int    $code   返回状态码
     * @param string $url    跳转链接
     * @param array  $header 返回头信息
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/22 0022
     */
    public function format_return($msg = '', $data = '', $code = 0, $url = '', $header = []) {
        if (is_array($msg)) {
            $code = isset($msg['code']) ? $msg['code'] : $code;
            $msg = isset($msg['msg']) ? $msg['msg'] : $msg;
            $url = isset($msg['url']) ? $msg['url'] : $url;
        }
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
        ];
        $type = $this->getResponseType();
        $header['Access-Control-Allow-Origin'] = '*';
        $header['Access-Control-Allow-Headers'] = 'X-Requested-With,Content-Type,XX-Device-Type,XX-Token,XX-Api-Version,XX-Wxapp-AppId';
        $header['Access-Control-Allow-Origin'] = 'GET,POST,PATCH,PUT,DELETE,OPTIONS';
        $response = Response::create($result, $type)->header($header);
        throw new HttpResponseException($response);
    }
}