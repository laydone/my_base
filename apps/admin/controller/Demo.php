<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/28 0028
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace app\admin\controller;

/**
 * Describe:
 * Class Demo
 *
 * @package app\admin\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/28 0028
 */
class Demo extends Admin {

    /**
     * Describe:初始化Demo类[设定显示UI元素demo菜单]
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/28 0028
     */
    public function _init() {
        parent::_init(); // TODO: Change the autogenerated stub
        $this->assign('is_demo', true);
    }


}