<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/11/20 0020
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace base\mybase\event;

/**
 * Describe:后台菜单观察类
 * Class AdminMenu
 *
 * @package base\mybase\event
 * @author  lidong<947714443@qq.com>
 * @date    2019/11/20 0020
 */
class AdminMenu {

    /**
     * Describe:菜单更新之后清除缓存
     *
     * @param $info
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/11/20 0020
     */
    public function afterUpdate($info) {
        cache('admin_menu', null); /* 删除指定缓存 */
    }


}