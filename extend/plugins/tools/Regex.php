<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/9/30 0030
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace plugins\tools;

/**
 * Describe:正则工具类
 * Class Regex
 *
 * @package plugins
 * @author  lidong<947714443@qq.com>
 * @date    2019/9/30 0030
 */
class Regex {

    /**
     * 国内手机正则[中国]
     */
    const MOBILE = '/^1[3456789]\d{9}$/';

    /**
     * 常规邮箱正则[允许英文字母/数字/下划线/英文句号/以及中划线]
     */
    const EMAIL_NORMAL = '/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/';

    /**
     * 包含中文字节的邮箱[@符号前有中文字节]
     */
    const EMAIL_MB_NAME = '/^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/';


    /**
     * Describe:普通国内手机号正则验证
     *
     * @param string $mobile 待检测字符串
     * @param string $regex  手机验证规则
     *                       [
     *                       Regex::MOBILE 国内手机正则
     *                       ]
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/9/30 0030
     */
    static public function check_mobile($mobile, $regex = self::MOBILE) {
        try {
            $res = preg_match($regex, $mobile);
            if ($res == 0) {
                return false;
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }


    /**
     * Describe:
     *
     * @param string $email 待检测字符串
     * @param string $regex 邮箱验证规则
     *                      [
     *                      Regex::EMAIL_NORMAL 通用邮箱正则
     *                      Regex::EMAIL_MB_NAME 带中文字符的邮箱正则
     *                      ]
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/9/30 0030
     */
    static public function check_email($email, $regex = self::EMAIL_NORMAL) {
        try {
            $res = preg_match($email, $regex);
            if ($res == 0) {
                return false;
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }


}