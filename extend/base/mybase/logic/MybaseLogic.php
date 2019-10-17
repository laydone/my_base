<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/9/22 0022
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace base\mybase\logic;

use base\mybase\model\Mybase as MyModel;
use base\mybase\validate\Mybase as MyValidate;
use plugins\tools\ArrTree;

/**
 * Describe:
 * Class MyBaseLogic
 *
 * @package base\mybase\logic
 * @author  lidong<947714443@qq.com>
 * @date    2019/9/22 0022
 */
class MybaseLogic {

    /**
     * Describe:操作模型
     *
     * @var \base\mybase\model\Mybase
     */
    protected $model;

    /**
     * Describe:验证类
     *
     * @var \base\mybase\validate\Mybase
     */
    protected $validate;

    /**
     * Describe:错误信息
     *
     * @var null|string
     */
    protected $error;


    /**
     * 构造方法 初始化基础逻辑类
     * MybaseLogic constructor.
     */
    public function __construct() {
        $this->_init(); /*优先调用子类赋值*/
        if (empty($this->model)) { /*子类赋值未成功,进行默认赋值*/
            $this->model = new MyModel();
        }
        if (empty($this->validate)) { /*子类赋值未成功,进行默认赋值*/
            $this->validate = new MyValidate();
        }
    }


    /**
     * Describe:预留初始化函数
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function _init() {
    }


    /**
     * Describe: 数据表数据更新
     *
     * @param array $data 需要更新的数据
     *
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/10/17 0017
     */
    public function update($data) {
        if (ArrTree::arr_empty($data)) { /*验证数据合法性*/
            $this->error = '';
            return false;
        }
        $time = time();
        if ($this->model->fieldExists('update_time') && !array_key_exists('update_time', $data)) {
            $data['update_time'] = $time;
        }
        if (isset ($data [$this->model->getPk()]) && $data [$this->model->getPk()] > 0) { /* 执行更新操作 */
            try {
                $check = $this->validate->check($data);
                if ($check === false) {
                    throw new \Exception ($this->validate->getError());
                }
                $this->model->allowField(true)->isUpdate(true)->save($data);
            } catch (\Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        } else { /* 执行插入操作 */
            if ($this->model->fieldExists('create_time') && !array_key_exists('create_time', $data)) {
                $data['create_time'] = $time;
            }
            try {
                $check = $this->validate->check($data);
                if ($check === false) {
                    throw new \Exception ($this->validate->getError());
                }
                $this->model->allowField(true)->save($data);
            } catch (\Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }
        return true;
    }


    /**
     * Describe:返回错误信息
     *
     * @return string|null
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function get_error() {
        return $this->error;
    }


}