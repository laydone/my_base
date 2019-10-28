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
namespace base\mybase\controller;

use think\exception\ClassNotFoundException;

/**
 * Describe:控制器不存在时处理[空控制器]
 * Class MyError
 *
 * @package base\mybase\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/28 0028
 */
class MyError extends Mybase {

    /**
     * Describe:默认处理方法
     *
     * @return mixed|void
     * @author lidong<947714443@qq.com>
     * @date   2019/10/28 0028
     */
    public function index() {
        try {
            /*TODO:控制器不存在时的处理*/
            $Class = $this->request->controller();
            new $Class();
        } catch (ClassNotFoundException $e) {
            throw new HttpException(404, 'controller not exists:' . $e->getClass());
        }
    }


}