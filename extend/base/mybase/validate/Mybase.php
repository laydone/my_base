<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/9/22 0022
 * +----------------------------------------------------------------------
 * | File Describe:基础继承验证器
 */
namespace base\mybase\validate;

use plugins\tools\Regex;
use think\Validate;

/**
 * Describe:
 * Class mybase
 *
 * @package base\mybase\validate
 * @author  lidong<947714443@qq.com>
 * @date    2019/9/22 0022
 */
class Mybase extends Validate {

    /**
     * Describe:验证手机格式
     *
     * @param string $value 需要验证的字段值
     * @param string $rule  验证规则
     * @param array  $data  所有验证数据数组
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/10/15 0015
     */
    public function is_mobile($value, $rule, $data) {
        if (Regex::check_mobile($value)) {
            return true;
        }
        return false;
    }


    /**
     * Describe:验证邮箱格式
     *
     * @param string $value 需要验证的字段值
     * @param string $rule  验证规则
     * @param array  $data  所有验证数据数组
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/10/21 0021
     */
    public function is_email($value, $rule, $data) {
        if (Regex::check_email($value)) {
            return true;
        }
        return false;
    }


}