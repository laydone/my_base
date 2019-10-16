<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/9/27 0027
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace plugins\tools;

/**
 * Describe:
 * Class Region
 *
 * @package plugins
 * @author  lidong<947714443@qq.com>
 * @date    2019/9/27 0027
 */
class Region {

    /**
     * Describe:
     *
     * @var string
     */
    const TABLE = 'region';

    /**
     * Describe:地址缓存名称
     *
     * @var string
     */
    const CACHE_NAME = 'region';

    /**
     * Describe:地址信息树缓存名称
     *
     * @var string
     */
    const TREE_CACHE_NAME = 'region_tree';

    /**
     * Describe:地址信息列表
     *
     * @var
     */
    protected static $region;

    /**
     * Describe: 地址信息树
     *
     * @var
     */
    protected static $region_tree = null;


    /**
     * Describe:
     *
     * @param \plugins\Region|null $model
     *
     * @return mixed
     * @author lidong<947714443@qq.com>
     * @date   2019/9/27 0027
     */
    static public function get_region_tree(Region $model = null) {
        if (empty(self::$region_tree)) {
            $model = is_object($model) ? $model : new Region();
            self::$region_tree = $model->cache_region_tree();
        }

        return self::$region_tree;
    }


    /**
     * Describe:
     *
     * @param \plugins\Region|null $model
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array|mixed|\PDOStatement|string|\think\Collection
     * @author lidong<947714443@qq.com>
     * @date   2019/9/27 0027
     */
    static public function get_region(Region $model = null) {
        if (empty(self::$region)) {
            $model = is_object($model) ? $model : new Region();
            self::$region = $model->cache_region();
        }

        return self::$region;
    }


    /**
     * Describe:通过pid获取
     *
     * @param int $pid 父级ID值
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array
     * @author lidong<947714443@qq.com>
     * @date   2019/10/15 0015
     */
    static public function get_region_by_pid($pid = 0) {
        $region = db(self::TABLE)->where('parent_id', 'eq', $pid)->select()->toArray();

        return $region;
    }


    /**
     * Describe:获取键值为ID的地址信息列表
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/9/29 0029
     */
    static public function get_region_id_key() {
        $res = ArrTree::arr_id_key(self::get_region());

        return $res;
    }


    /**
     * Describe:查询地址信息表数据
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @return array|mixed|\PDOStatement|string|\think\Collection
     * @author lidong<947714443@qq.com>
     * @date   2019/9/27 0027
     */
    static public function cache_region() {
        // cache(self::CACHE_NAME,null);
        if (!cache(self::CACHE_NAME)) { /* 优先读取*/
            $region = db(self::TABLE)->select()->toArray();
            cache(self::CACHE_NAME, $region);
        } else {
            $region = cache(self::CACHE_NAME);
        }

        return $region;
    }


    /**
     * Describe:获取地址信息树缓存
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/9/29 0029
     */
    static public function cache_region_tree() {
        if (!cache(self::TREE_CACHE_NAME)) {
            $region = self::get_region();
            $region_tree = (new ArrTree())->list_to_tree($region);
            cache(self::TREE_CACHE_NAME, $region_tree);
        } else {
            $region_tree = cache(self::TREE_CACHE_NAME);
        }

        return $region_tree;
    }


}