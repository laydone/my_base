<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/21 0021
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace base\mybase\model;

/**
 * Describe:管理员信息表操作模型
 * Class Admin
 *
 * @package base\mybase\model
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/21 0021
 */
class Admin extends Mybase {

    /**
     * Describe:密码字段
     *
     * @var string
     */
    public $field_password = 'password';

    /**
     * Describe:登录用户名字段
     *
     * @var string
     */
    public $field_username = 'username';

    /**
     * Describe:密码加密随机串字段
     *
     * @var string
     */
    public $field_salt = 'salt';


}