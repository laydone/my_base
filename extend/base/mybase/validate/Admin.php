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
namespace base\mybase\validate;

/**
 * Describe:
 * Class Admin
 *
 * @package base\mybase\validate
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/21 0021
 */
class Admin extends Mybase {

    /**
     * Describe:验证规则
     *
     * @var array
     */
    protected $rule = [
        'username' => 'require',
        'nickname' => 'require',
        'mobile'   => 'require|is_mobile',
        'email'    => 'require|is_email',
        'password' => 'require|min:6|max:18',
    ];

    /**
     * Describe:验证未通过提示信息
     *
     * @var array
     */
    protected $message = [
        'username.require' => '请填写用户名',
        'nickname.require' => '请填写用户昵称',
        'mobile.require'   => '请填写用户手机',
        'mobile.is_mobile' => '手机格式错误',
        'email.require'    => '请填写用户邮箱',
        'email.is_email'   => '邮箱格式错误',
        'password.require' => '请填写密码',
        'password.min'     => '密码最小长度为6',
        'password.max'     => '密码最大长度为18',
    ];

    /**
     * Describe:验证场景
     *
     * @var array
     */
    protected $scene = [
        'add'  => ['username', 'nickname', 'mobile', 'email', 'password',],
        'edit' => ['username', 'nickname', 'mobile', 'email',],
    ];


}