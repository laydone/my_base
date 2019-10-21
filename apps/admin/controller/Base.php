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

use base\mybase\controller\Mybase as MyController;

/**
 * Describe:管理后台继承总类
 * Class base
 *
 * @package app\admin\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/17 0017
 */
class base extends MyController {

    /**
     * Describe:默认初始化
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/17 0017
     */
    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->_init();
    }


    /**
     * Describe:预留子类初始化方法
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/17 0017
     */
    public function _init() { }





}