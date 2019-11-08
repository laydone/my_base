<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/9/22 0022
 * +----------------------------------------------------------------------
 * | File Describe:基础继承模型
 */
namespace base\mybase\model;

use think\Model;

/**
 * Describe:
 * Class Mybase
 *
 * @package base\mybase\model
 * @author  lidong<947714443@qq.com>
 * @date    2019/9/22 0022
 */
class Mybase extends Model {

    /**
     * 查询所有数据
     */
    const ALL_DATA = 1;
    /**
     * 查询所有未删除数据
     */
    const NO_DEL_DATA = 2;
    /**
     * 查询所有未禁用和未删除数据
     */
    const NO_DISABLED_DATA = 3;

    /**
     * Describe:删除标记字段
     *
     * @var string
     */
    public $field_del = 'is_del';

    /**
     * Describe:禁用标记字段
     *
     * @var string
     */
    public $field_disable = 'is_disable';

    /**
     * Describe:查询数据格式
     *
     * @var string
     */
    protected $dataType = 3;

    /**
     * 启用状态文字
     *
     * @var array
     */
    protected $is_disable_type = [
        '0' => '启用',
        '1' => '禁用',
    ];

    /**
     * 保存自动完成列表
     *
     * @var array
     */
    protected $auto = [
        'update_time',
    ];

    /**
     * 新增自动完成列表
     *
     * @var array
     */
    protected $insert = [
        'create_time',
    ];

    /**
     * 更新自动完成列表
     *
     * @var array
     */
    protected $update = [];


    /**
     * Describe:模型初始化
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/9/22 0022
     */
    public function initialize() {
        parent::initialize(); // TODO: Change the autogenerated stub
        // $name = substr(__CLASS__,'','');
        // $this->table = $name;
        // $this->name = '';
        $this->_init(); /*子类模型赋值预留*/
        $this->get_append();
    }


    /**
     * Describe:合并追加字段并验证表中是否存在对应字段
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function get_append() {
        $append = [
            'create_time_text',
            'update_time_text',
        ];
        $pre_append = array_merge($this->append, $append);
        $new_append = [];
        $query = $this->buildQuery();
        $fields = $query->getTableFields();
        foreach ($pre_append as $val) {
            if (strpos('_text', $val)) {
                $temp = explode('_', $val);
                array_pop($temp);
                $field = implode('_', $temp);
                if (in_array($field, $fields)) {
                    $new_append[] = $val;
                }
            } else {
                $new_append[] = $val;
            }
        }
        $this->append = $new_append;
    }


    /**
     * Describe:子类模型赋值初始化预留
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function _init() {
    }

    /******************************************************************************************************************/
    /**
     * Describe:设置默认查询条件
     *
     * @param object $query
     */
    public function base($query) {
        $fields = $query->getTableFields();
        switch ($this->dataType) {
            case ($this->dataType == self::NO_DISABLED_DATA):
                if (in_array($this->field_disable, $fields)) { /* 如果存在删除标记,则默认查询未被删除的数据 */
                    $query->where($this->field_disable, 'eq', 0);
                }
            case ($this->dataType == self::NO_DEL_DATA):
                if (in_array($this->field_del, $fields)) { /* 如果存在删除标记,则默认查询未被删除的数据 */
                    $query->where($this->field_del, 'eq', 0);
                }
            default:
                ;
        }
    }



    /******************************************************************************************************************/
    /**
     * Describe:创建时间
     *
     * @param string $value 对应修改的字段原始值
     * @param array  $data  对应的整条数据
     *
     * @return number
     */
    public function setCreatTimeAttr($value, $data) {
        return time();
    }


    /**
     * Describe:更新时间
     *
     * @param string $value 对应修改的字段原始值
     * @param array  $data  对应的整条数据
     *
     * @return number
     */
    public function setUpdateTimeAttr($value, $data) {
        return time();
    }


    /**
     * Describe:创建时间格式化输出
     *
     * @param string $value 对应字段值
     * @param array  $data  对应整条数据
     *
     * @return string
     */
    public function getCreateTimeTextAttr($value, $data) {
        return (isset ($data ['create_time']) && $data ['create_time'] > 0 ? date('Y-m-d H:i:s', $data ['create_time']) : '-');
    }


    /**
     * Describe:更新时间格式化输出
     *
     * @param string $value 对应字段值
     * @param array  $data  对应整条数据
     *
     * @return string
     */
    public function getUpdateTimeTextAttr($value, $data) {
        return (isset ($data ['update_time']) && $data ['update_time'] > 0 ? date('Y-m-d H:i:s', $data ['update_time']) : '-');
    }


    /**
     * Describe:状态标记转汉字显示
     *
     * @param string $value 对应字段值
     * @param array  $data  对应整条数据
     *
     * @return string
     */
    public function getIsDisableTextAttr($value, $data) {
        return (isset ($data [$this->field_disable]) && isset ($this->is_disable_type [$data [$this->field_disable]]) ? $this->is_disable_type [$data [$this->field_disable]] : '');
    }
    /******************************************************************************************************************/
    /**
     * Describe:判断字段是否存在
     *
     * @param string $field
     *
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function fieldExists($field) {
        $query = $this->buildQuery();
        $fields = $query->getTableFields();
        if (in_array($field, $fields)) {
            return true;
        }
        return false;
    }


    /**
     * Describe:设置查询数据类型
     *
     * @param int $type 数据类型：
     *                  [self::ALL_DATA/1]所有数据
     *                  [self::NO_DEL_DATA/]未删除数据
     *                  [self::NO_DEL_DATA/]未禁用且未删除数据
     *
     * @return $this
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function setDataType($type = self::NO_DISABLED_DATA) {
        $this->dataType = $type;
        return $this;
    }


}