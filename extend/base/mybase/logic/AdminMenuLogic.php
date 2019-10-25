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
     * Describe:
     *
     * @var \base\mybase\model\AdminMenu
     */
    protected $model;

    /**
     * Describe:
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


}