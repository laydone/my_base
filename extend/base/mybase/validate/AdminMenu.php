<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/25 0025
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace base\mybase\validate;

/**
 * Describe:
 * Class AdminMenu
 *
 * @package base\mybase\validate
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/25 0025
 */
class AdminMenu extends Mybase {

    /**
     * Describe:验证规则
     *
     * @var array
     */
    protected $rule = [
        'name'             => 'require',
        'is_display'       => 'require',
        'menu_type'        => 'require',
        'display_position' => 'require',
        'app'              => 'require',
        'controller'       => 'require',
        'action'           => 'require',
        'request_type'     => 'require',
    ];

    /**
     * Describe:验证不通过提示信息
     *
     * @var array
     */
    protected $message = [
        'name.require'             => '请填写菜单名称',
        'is_display.require'       => '请选择是否显示',
        'menu_type.require'        => '请选择菜单类型',
        'display_position.require' => '请选择按钮展示位置',
        'app.require'              => '请填写菜单指向目标应用名',
        'controller.require'       => '请填写菜单指向目标控制器',
        'action.require'           => '请填写菜单指向目标方法',
        'request_type.require'     => '请选择请求方式',
    ];


}