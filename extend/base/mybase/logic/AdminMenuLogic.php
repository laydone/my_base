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
use plugins\tools\ArrTree;

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
        $cache_list_name = config('logic_conf.admin_menu.cache_list');
        if (!cache($cache_list_name)) {
            $lists = $this->model->setDataType(AdminMenuModel::NO_DISABLED_DATA)->column(null, $this->model->getPk());
            cache($cache_list_name, $lists);
        } else {
            $lists = cache($cache_list_name);
        }
        return $lists;
    }


    /**
     * Describe: 获取权限菜单树
     *
     * @param int $admin_id 管理员ID
     *
     * @return array
     * @author lidong<947714443@qq.com>
     * @date   2019/11/22 0022
     */
    public function menu_tree($admin_id = 0) {
        $menus_ids = $this->get_admin_menus($admin_id);
        $cache_tree_name = config('logic_conf.admin_menu.cache_tree_pre') . $admin_id;
        $tree = cache($cache_tree_name);
        if ($tree) {
            return $tree;
        }
        $all_menus = $this->menu_list();
        if ($menus_ids === true) { /* 超级管理员拥有所有权限*/
            $menus = array_values($all_menus);
        } else {
            $menus = [];
            foreach ($all_menus as $key => $row) {
                if (in_array($key, $menus_ids)) {
                    $temp[] = $row;
                }
            }
        }
        $tree = ArrTree::list_to_tree($menus);
        cache($cache_tree_name, $tree);
        return $tree;
    }


    /**
     * Describe:
     *
     * @param int $admin_id 获取权限菜单
     *
     * @return array|bool
     * @author lidong<947714443@qq.com>
     * @date   2019/11/22 0022
     */
    public function get_admin_menus($admin_id = 0) {
        $super_admin = config('admin_permission.super_admin') ?? [];
        if (in_array($admin_id, $super_admin)) {
            return true;
        }
        /* $menu_ids = */
        /*TODO:获取对应管理员的权限*/
        return [];
    }


}