<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/17 0017
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace app\admin\controller;

/**
 * Describe:后台登录后操作继承控制器
 * Class admin
 *
 * @package app\admin\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/17 0017
 */
class Admin extends Base {

    /**
     * Describe: 当前登录管理员ID
     *
     * @var int
     */
    protected $admin_id;


    /**
     * Describe:初始化
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/18 0018
     */
    public function _init() {
        parent::_init(); // TODO: Change the autogenerated stub
        $this->admin_id = get_admin_id();
        $this->check_login();
    }


    /**
     * Describe:检查用户登录状态
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/17 0017
     */
    public function check_login() {
        if ($this->get_admin_id() <= 0) {
            $this->redirect('/admin/login');
        }
    }


    /**
     * Describe:获取当前登录管理员ID
     *
     * @return int
     * @author lidong<947714443@qq.com>
     * @date   2019/10/17 0017
     */
    public function get_admin_id() {
        return intval($this->admin_id);
    }


}