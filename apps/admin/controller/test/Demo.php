<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/18 0018
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace app\admin\controller\test;

use app\admin\controller\Base;
use plugins\tools\StrPro;

/**
 * Describe:
 * Class Demo
 *
 * @package app\admin\controller\test
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/18 0018
 */
class Demo extends Base {

    public function index() {
        dump(url('index'));
        dump(url(''));
        dump(url('/admin/test/index'));
        dump(url('/admin/test.demo/index'));
        dump(url('/admin/test/'));
        dump(url('/admin/test.demo/index', [], true, true));
        dump(url('/admin/test/', ['id'=>'1'], true, true));
        dump(url('/admin/test.demo/index', [], true, true));
    }

    public function test(){
        dump(StrPro::rand_salt(88));
    }


}