<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/21 0021
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace base\mybase\logic;

/**
 * Describe:
 * Class AdminLogic
 *
 * @package base\mybase\logic
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/21 0021
 */
class AdminLogic extends MybaseLogic {

    /**
     * Describe:
     *
     * @var \base\mybase\model\Admin
     */
    protected $model;

    /**
     * Describe:
     *
     * @var \base\mybase\validate\Admin
     */
    protected $validate;


    public function do_login($username, $password) {
    }


}