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
 * Describe:
 * Class Index
 *
 * @package app\admin\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/17 0017
 */
class Index extends Admin {

    public function index() {
        return $this->fetch();
        // return $this->fetch('public:main');
    }


}