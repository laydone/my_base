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

use base\mybase\logic\AdminLogic;

/**
 * Describe:
 * Class Login
 *
 * @package app\admin\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/17 0017
 */
class Login extends Base {

    /**
     * Describe:用户登录验证
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author lidong<947714443@qq.com>
     * @date   2019/10/22 0022
     */
    public function do_login() {
        $username = $this->request->param('username', '', 'trim');
        $password = $this->request->param('password', '', 'trim');
        $verify_code = $this->request->param('verify_code', '', 'trim');
        if (!$this->captcha_check($verify_code)) {
            $this->ajax_error('验证码错误');
        }
        $Logic = new AdminLogic();
        $res = $Logic->do_login_username_unique($username, $password);
        if ($res === false) {
            $this->ajax_error($Logic->get_error());
        }
        $this->ajax_success('登录成功', '', url('index/index'));
    }


    /**
     * Describe:退出登录
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/23 0023
     */
    public function logout() {
        $Logic = new AdminLogic();
        $Logic->logout();
        $this->redirect('index');
    }


}