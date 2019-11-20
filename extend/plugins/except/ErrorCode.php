<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/11/20 0020
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace plugins\except;

/*TODO:根据需求统一错误码 */


/**
 * Describe:自定义错误码类
 * Class ErrorCode
 *
 * @package plugins\except
 * @author  lidong<947714443@qq.com>
 * @date    2019/11/20 0020
 */
class ErrorCode {

    /**
     * Describe:请求成功错误码
     *
     * @var int
     */
    static public $Success = 0;

    /**
     * Describe:请求方式错误
     *
     * @var int
     */
    static public $Err_request = 10000;

    /**
     * Describe:参数错误
     *
     * @var int
     */
    static public $Err_params = 10001;

    /**
     * Describe:登录失效
     *
     * @var int
     */
    static public $Err_login_invalid = 10002;

    /**
     * Describe:签名验证失效
     *
     * @var int
     */
    static public $Err_sign = 10003;


}