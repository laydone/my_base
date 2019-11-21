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
namespace base\mybase\logic;

use base\mybase\model\AdminMenu as AdminMenuModel;
use base\mybase\validate\AdminMenu as AdminMenuValidate;

/**
 * Describe:
 * Class AdminMenuLogic
 *
 * @package base\mybase\logic
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/25 0025
 */
class AdminMenuLogic extends MybaseLogic {

    /**
     * Describe:管理员菜单模型
     *
     * @var \base\mybase\model\AdminMenu
     */
    protected $model;

    /**
     * Describe:管理员菜单验证器
     *
     * @var \base\mybase\validate\AdminMenu
     */
    protected $validate;


    /**
     * Describe:
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/25 0025
     */
    public function _init() {
        parent::_init();
        $this->model = new AdminMenuModel();
        $this->validate = new AdminMenuValidate();
    }


    /**
     * Describe:管理员菜单列表
     * TODO:管理员菜单树状结构
     *
     * @return mixed
     * @author lidong<947714443@qq.com>
     * @date   2019/11/21 0021
     */
    public function menu_list() {
        $cache_name = config('logic_conf.admin_menu.cache_list');
        if (!cache($cache_name)) {
            $lists = $this->model->setDataType(AdminMenuModel::NO_DISABLED_DATA)->select();
            cache($cache_name, $lists);
        } else {
            $lists = cache($cache_name);
        }
        return $lists;
    }


}