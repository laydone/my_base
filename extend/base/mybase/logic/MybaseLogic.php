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
     * Describe: 查询的数据类型
     *
     * @var string 可选值['all','no_del','no_disable' ]
     */
    protected $data_type;


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
     * Describe:查询所有数据
     *
     * @param mixed|array|string $map  查询条件数组
     * @param mixed|array|string $sort 排序条件
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array|\PDOStatement|string|\think\Collection
     * @author lidong<947714443@qq.com>
     * @date   2019/10/25 0025
     */
    public function lists($map, $sort) {
        $lists = $this->model->where($map)->order($sort)->select();
        return $lists;
    }


    /**
     * Describe:HTML翻页列表
     *
     * @param array $map    查询条件
     * @param int   $page   页码
     * @param array $query  翻页链接
     * @param array $sort   排序条件
     * @param int   $limit  每页显示条数
     * @param array $config 翻页配置
     *                      page:当前页,
     *                      path:url路径,
     *                      query:url额外参数,
     *                      fragment:url锚点,
     *                      var_page:分页变量,
     *                      list_rows:每页数量
     *                      type:分页类名
     *
     * @throws \think\exception\DbException
     * @return \think\Paginator
     * @author lidong<947714443@qq.com>
     * @date   2019/10/25 0025
     */
    public function html_pages($map, $page = 1, array $query = [], $sort = ['id' => 'desc'], $limit = 10, array $config = []) {
        $D_config = [
            'page'      => $page,
            'query'     => $query,
            'list_rows' => $limit,
        ];
        $final_config = array_merge($D_config, $config);
        /*TODO:加配置判断默认查询的数据类型*/
        $this->get_date_type();
        $lists = $this->model->where($map)->order($sort)->paginate($final_config);
        return $lists;
    }


    /**
     * Describe:获取详情
     *
     * @param int $id
     *
     * @return mixed
     * @author lidong<947714443@qq.com>
     * @date   2019/10/25 0025
     */
    public function get_details($id) {
        $info = $this->model->get($id);
        return $info;
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
     * Describe:数据启用
     *
     * @param mixed|array|string $ids 需要操作数据的ID数组或者ID串
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/11/19 0019
     */
    public function enable($ids) {
        $res = $this->change_field($ids, $this->model->field_disable, 0);
        return $res;
    }


    /**
     * Describe:数据禁用
     *
     * @param mixed|array|string $ids 需要操作数据的ID数组或者ID串
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/11/19 0019
     */
    public function disable($ids) {
        $res = $this->change_field($ids, $this->model->field_disable, 1);
        return $res;
    }


    /**
     * Describe:数据删除
     *
     * @param mixed|array|string $ids 需要操作数据的ID数组或者ID串
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/11/19 0019
     */
    public function del($ids) {
        $res = $this->change_field($ids, $this->model->field_del, 1);
        return $res;
    }


    /**
     * Describe:数据还原
     *
     * @param mixed|array|string $ids 需要操作数据的ID数组或者ID串
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/11/19 0019
     */
    public function restore($ids) {
        $res = $this->change_field($ids, $this->model->field_del, 0);
        return $res;
    }


    /**
     * Describe:批量修改数据单个字段的值
     *
     * @param mixed|array|string $ids   需要修改字段值的数据ID数组或ID串
     * @param string             $field 需要修改的字段
     * @param int                $val   修改的值
     *
     * @throws \Exception
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/11/19 0019
     */
    public function change_field($ids, $field, $val) {
        if (empty ($field) || (is_string($val) && strlen($val) == 0) || (!is_string($val) && empty ($val))) { /* 判断参数合法性 */
            $this->error = '请选定需要设置的字段以及值';
        }
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_values(array_filter($ids)); /* 去掉空值 */
        if (empty ($ids)) {
            $this->error = '请选定需要设置的数据';
        }
        $map = [];
        $pk = $this->model->getPk(); /* 获取当前模型主键 */
        $map [$pk] = [ /* 构建更新数据范围 */
                       'in',
                       $ids,
        ];
        try {
            $this->model->where($map)->setField($field, $val); /* */
        } catch (\Exception $e) {
            throw $e; /* TODO:上线删除或者注释掉本行 */
            // $this->error = $e->getMessage();
            return false;
        }
        return true;
    }


    /**
     * Describe:获取查询数据类型
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/11/8 0008
     */
    public function get_date_type() {
        $module = request()->module();
        $admin_modules = config('module_set.admin_modules');
        switch ($this->data_type) {
            case 'all':
                $this->model->setDataType(MyModel::ALL_DATA);
                break;
            case 'no_del':
                $this->model->setDataType(MyModel::NO_DEL_DATA);
                break;
            case 'no_disable':
                $this->model->setDataType(MyModel::NO_DISABLED_DATA);
                break;
            default:
                if (in_array($module, $admin_modules)) {
                    $this->model->setDataType(MyModel::NO_DEL_DATA);
                }
        }
    }


    /**
     * Describe:设置查询数据类型
     *
     * @param null $val
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/11/8 0008
     */
    public function set_data_type($val = null) {
        $data_type_range = config('logic_range.date_type');
        if (in_array($val, $data_type_range)) {
            $this->data_type = $val;
        }
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