<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/24 0024
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace app\admin\controller;

use base\mybase\logic\AdminMenuLogic;

/**
 * Describe:
 * Class AdminMenu
 *
 * @package app\admin\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/24 0024
 */
class AdminMenu extends Admin {

    /**
     * Describe:
     *
     * @var \base\mybase\logic\AdminMenuLogic;
     */
    protected $logic;

    /**
     * Describe:
     *
     * @var int
     */
    protected $limit = 10;


    /**
     * Describe:初始化
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/25 0025
     */
    public function _init() {
        parent::_init(); // TODO: Change the autogenerated stub
        $this->logic = new AdminMenuLogic();
        set_page_length([15, 20, 45, 65]);
    }


    public function test() {
        $res = $this->logic->menu_tree($this->get_admin_id());
        dump($res);
    }


}