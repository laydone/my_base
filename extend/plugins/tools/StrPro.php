<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/19 0019
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace plugins\tools;

/**
 * Describe:字符串处理工具类
 * Class StrPro
 *
 * @package plugins\tools
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/19 0019
 */
class StrPro {

    /**
     * 所有大写字母
     */
    const STRING_UPPER_LETTER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * 所有小写字母
     */
    const STRING_LOWER_LETTER = 'abcdefghijklmnopqrstuvwxyz';

    /**
     * 0-9数字
     */
    const STRING_NUMBER = '0123456789';

    /**
     * 1-9数字
     */
    const STRING_NUMBER_EXCEPT_ZERO = '123456789';

    /**
     * 所有数字以及字母混合
     */
    const STRING_MIXED = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * 除易混肴数字字母玩的所有字符[不含I,L,O,i,l,o,0]
     */
    const STRING_MIXED_EXCEPT_EASY_TO_MIX = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789';


    /**
     * Describe:获取指定长度的随机字符串
     *
     * @param int    $num     需要获取的字符串长度
     * @param string $pre_str 预置随机字符串取值字符串
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/19 0019
     */
    static public function rand_salt($num = 6, $pre_str = self::STRING_MIXED_EXCEPT_EASY_TO_MIX) {
        $len = strlen($pre_str);
        $str = '';
        for ($i = 0; $i < $num; $i++) {
            $str .= $pre_str[mt_rand(0, $len - 1)];
        }
        return $str;
    }


    /**
     * Describe: 密码加密
     *
     * @param string $str  待加密明码串
     * @param string $salt 加密附加随机串
     * @param int    $mode 加密模式[
     *                     1:明码串MD5值加随机串之后 再次MD5『默认加密规则』
     *                     2:明码串加随机串之后 两次MD5
     *                     3:明码串两次MD5加上随机串
     *                     4:明码串MD5和随机串MD5相加
     *                     ]
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/21 0021
     */
    static public function password_encrypt($str, $salt = '', $mode = 1) {
        switch ($mode) {
            case 2:
                $encrypt_pwd = md5(md5($str . $salt)); /* 长度32 */
                break;
            case 3:
                $encrypt_pwd = md5(md5($str)) . $salt; /* 长度32+随机串长度 */
                break;
            case 4:
                $encrypt_pwd = md5($str) . md5($salt); /* 长度64 */
                break;
            default:
                $encrypt_pwd = md5(md5($str) . $salt); /* 长度32 */
        }
        return $encrypt_pwd;
    }


    /**
     * Describe:获取密码加密
     *
     * @param string $str 密码明码串
     *
     * @return array
     * @author lidong<947714443@qq.com>
     * @date   2019/10/21 0021
     */
    static public function get_password($str) {
        $salt = self::rand_salt();
        $password = self::password_encrypt($str, $salt);
        return [$password, $salt];
    }


}