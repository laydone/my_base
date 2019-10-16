<?php
namespace plugins;

/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/9/29 0029
 * +----------------------------------------------------------------------
 * | File Describe:
 */
class ArrTree {

    /**
     * Describe:
     *
     * @var array
     */
    static protected $config = [
        'pk'        => 'id',        /* 需要匹配的键名 */
        'pid'       => 'parent_id', /* 父级键名 [] */
        'child'     => '_child',    /* 子集标记键名[默认为"_child"] */
        'root'      => 0,           /* 起始父级键值[默认为0,从顶级开始] */
        'key'       => '',          /* 树状结构键名字段取值字段[留空表示不设置,默认留空] */
        'depth'     => 1,           /* 深度标记起始值 */
        'depth_key' => '_depth',    /* 深度标记键名 */
    ];


    /**
     * Describe:列表结构二维数组转换为树状结构
     *
     * @param array $list       待转换列表结构二维数组
     * @param array $config     树状结构配置
     *                          [
     *                          'pk'    => 'id', //需要匹配的键名
     *                          'pid'   => 'parent_id', //父级键名 []
     *                          'child' => '_child', // 子集标记键名[默认为"_child"]
     *                          'root'  => 0, // 起始父级键值[默认为0,从顶级开始]
     *                          'key'   => '', // 树状结构键名字段取值字段[留空表示不设置,默认留空]
     *                          'depth' => 1, // 深度标记起始值
     *                          'depth_key'=>'_depth', // 深度标记键名
     *                          ]
     *
     * @return array
     * @author lidong<947714443@qq.com>
     * @date   2019/9/29 0029
     */
    static public function list_to_tree($list, $config = []) {
        $tree = [];
        $new_config = array_merge(self::$config, $config);
        if (!is_array($list) || !is_array($new_config)) return $tree;
        foreach ($list as $key => $row) {
            if ($row[$new_config['pid']] == $new_config['root']) {
                unset($list[$key]);
                $_child = self::list_to_tree($list, ['root' => $row[$new_config['pk']]]);
                if (!empty($_child)) $row[$new_config['child']] = $_child;
                if (!empty($new_config['key']) || array_key_exists($new_config['key'], $row)) {
                    $tree[$new_config['key']] = $row;
                } else {
                    $tree[] = $row;
                }
            }
        }

        return $tree;
    }


    /**
     * Describe:
     *
     * @param array  $arr
     * @param string $pk
     *
     * @throws \Exception
     * @return array
     * @author lidong<947714443@qq.com>
     * @date   2019/9/30 0030
     */
    static public function arr_id_key($arr = [], $pk = 'id') {
        if (empty($arr) || !is_array($arr)) return $arr;
        $new_arr = [];
        try {
            foreach ($arr as $key => $row) {
                if (!array_key_exists($pk, $row)) throw new \Exception('键名' . $pk . '不在数组中');
                $new_arr[$row[$pk]] = $row;
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $new_arr;
    }


}