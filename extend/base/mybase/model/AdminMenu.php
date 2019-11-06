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
namespace base\mybase\model;

/**
 * Describe:
 * Class AdminMenu
 *
 * @package base\mybase\model
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/25 0025
 */
class AdminMenu extends Mybase {

    /**
     * 启用状态文字
     *
     * @var array
     */
    protected $is_display_type = [
        '0' => '隐藏',
        '1' => '显示',
    ];


    /**
     * Describe:生成菜单链接
     *
     * @param string $value 对应字段值
     * @param array  $data  对应整条数据
     *
     * @return string
     */
    public function getUrlAttr($value, $data) {
        parse_str($data['params'], $params);
        $url = url($data['app'] . '/' . $data['controller'] . '/' . $data['action'], $params);
        return $url;
    }


    /**
     * Describe:生成菜单显示状态文字
     *
     * @param $value
     * @param $data
     *
     * @return mixed|string
     * @author lidong<947714443@qq.com>
     * @date   2019/11/6 0006
     */
    public function getIsDisplayTextAttr($value, $data) {
        return (isset ($data ['is_display']) && isset ($this->is_display_type [$data ['is_display']]) ? $this->is_display_type [$data ['is_display']] : '');
    }


}