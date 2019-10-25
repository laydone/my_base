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
    public function html_pages($map, $page = 1, $query = [], $sort = ['id' => 'desc'], $limit = 10, $config = []) {
        $D_config = [
            'page'      => $page,
            'query'     => $query,
            'list_rows' => $limit,
        ];
        $final_config = array_merge($D_config, $config);
        /*TODO:加配置判断默认查询的数据类型*/
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