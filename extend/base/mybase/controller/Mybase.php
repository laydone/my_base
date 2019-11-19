<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/9/22 0022
 * +----------------------------------------------------------------------
 * | File Describe:基础继承控制器
 */
namespace base\mybase\controller;

use base\mybase\logic\MybaseLogic;
use think\captcha\Captcha;
use think\Controller;

/**
 * Describe:
 * Class Mybase
 *
 * @package base\mybase\controller
 * @author  lidong<947714443@qq.com>
 * @date    2019/9/22 0022
 */
class Mybase extends Controller {

    /**
     * Describe:主要操作逻辑类
     *
     * @var \base\mybase\logic\MybaseLogic
     */
    protected $logic;

    /**
     * Describe:每页显示条数
     *
     * @var int
     */
    protected $limit = 15;

    /**
     * 是否允许修改
     */
    protected $is_allow_edit = true;

    /**
     * 是否允许添加
     *
     * @var string
     */
    protected $is_allow_add = true;

    /**
     * 是否允许删除(标记删除)
     *
     * @var string
     */
    protected $is_allow_del = true;

    /**
     * 是否允许启用
     *
     * @var string
     */
    protected $is_allow_enable = true;

    /**
     * 是否允许禁用
     *
     * @var string
     */
    protected $is_allow_disable = true;

    /**
     * 是否允许删除(真实删除)
     *
     * @var string
     */
    protected $is_allow_delete = false;


    /**
     * Describe:初始化方法
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function initialize() {
        parent::initialize();
        $this->logic = new MybaseLogic();
        $limit = $this->request->param('list_limit', 0, 'intval');
        if ($limit > 0) {
            set_page_limit($limit);
        }
        $this->_init();
    }


    /**
     * Describe:预留子类初始化方法
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/17 0017
     */
    public function _init() {
        $limit = get_page_limit();
        $this->limit = $limit ? : $this->limit;
    }


    /**
     * Describe:容错方法[空操作]
     *
     * @return mixed
     * @author lidong<947714443@qq.com>
     * @date   2019/10/28 0028
     */
    public function _empty() {
        try {
            return $this->fetch();
        } catch (TemplateNotFoundException $e) {
            $error = config('http_exception_template');
            return $this->fetch($error['404']);
        }
    }


    /**
     * Describe:首页/列表页默认展示
     *
     * @throws \think\exception\DbException
     * @return mixed
     * @author lidong<947714443@qq.com>
     * @date   2019/10/25 0025
     */
    public function index() {
        $map = [];
        $page = $this->request->param('page', 1, 'intval');
        $data['list'] = $list = $this->logic->html_pages($map, $page, [], '', $this->limit, []);
        $data['page'] = $list->render();
        $data['total_counts'] = $total = $list->total();
        $data['limited'] = $limited = $list->listRows();
        $data['current_page'] = $current_page = $list->currentPage();
        $current_num = $list->count();
        $data['show_start'] = ($limited * ($current_page - 1) + 1);
        $data['show_end'] = ($limited * ($current_page - 1) + $current_num);
        $data['page_length'] = get_page_length();
        $this->assign($data);
        return $this->fetch();
    }


    /**
     * Describe:添加页默认展示
     *
     * @return mixed
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function add() {
        return $this->fetch('operate');
    }


    /**
     * Describe:编辑页默认展示
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function edit() {
        $id = $this->request->param('id', 0, 'intval');
        $info = $this->logic->get_details($id);
        $this->assign('info', $info);
        return $this->fetch('operate');
    }


    /**
     * Describe:禁用
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/16 0016
     */
    public function disable() {
        if (!$this->request->isPost()) { /*TODO:错误提示整合*/
            $this->error('请求方式错误');
        }
        $ids = $this->request->param('id');
        $res = $this->logic->disable($ids);
        if ($res === false) {
            $this->error($this->logic->get_error());
        }
        $this->success('禁用成功');
    }


    /**
     * Describe:启用
     *
     * @throws \Exception
     * @author lidong<947714443@qq.com>
     * @date   2019/11/19 0019
     */
    public function enable() {
        if (!$this->request->isPost()) { /*TODO:错误提示整合*/
            $this->error('请求方式错误');
        }
        $ids = $this->request->param('id');
        $res = $this->logic->enable($ids);
        if ($res === false) {
            $this->error($this->logic->get_error());
        }
        $this->success('禁用成功');
    }


    /**
     * Describe:数据更新操作
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/11/19 0019
     */
    public function update() {
        if (!$this->request->isPost()) {
            $this->error('请求方式错误');
        }
        $data = $this->request->param();
        $res = $this->logic->update($data);
        if ($res === false) {
            $this->error($this->logic->get_error());
        }
        $this->success('保存成功');
    }


    /**
     * Describe:ajax切换验证码请求
     *
     * @return \think\response\Json
     * @author lidong<947714443@qq.com>
     * @date   2019/10/22 0022
     */
    public function change_captcha() {
        $captcha_id = $this->request->param('captcha', '', 'trim');
        $params = ['version' => rand()];
        if (!empty($captcha_id)) {
            $params['captcha_id'] = $captcha_id;
        }
        $url = url('captcha', $params, true, true);
        return json(['code' => 1, 'url' => $url]);
    }


    /**
     * Describe:输出图片验证码
     *
     * @return \think\Response
     * @author lidong<947714443@qq.com>
     * @date   2019/10/22 0022
     */
    public function captcha() {
        $config = [
            /* 默认验证码配置*/
            'fontSize' => '20',
            'imageH'   => '38',
            'imageW'   => '170',
            'length'   => '5',
            'bg'       => [200, 200, 200],
        ];
        $font_size = $this->request->param('font_size', 0, 'intval');
        if ($font_size > 0 && $font_size < 100) { /* 设置验证码字号 */
            $config['fontSize'] = $font_size;
        }
        $height = $this->request->param('height', 0, 'intval');
        if ($height > 0 && $height < 100) { /* 设置验证码图片高度 */
            $config['imageH'] = $height;
        }
        $width = $this->request->param('width', 0, 'intval');
        if ($width > 0 && $width < 200) { /* 设置验证码图片宽度 */
            $config['imageW'] = $width;
        }
        $len = $this->request->param('len', 0, 'intval');
        if ($len > 0 && $len <= 20) { /* 设置验证码长度 */
            $config['length'] = $len;
        }
        $bg = $this->request->param('bg', '', 'trim');
        if (!empty($bg)) {
            $bg_arr = explode(',', $bg);
            array_walk($bg_arr, 'intval');
            if (count($bg_arr) >= 3 && $bg_arr[0] <= 255 && $bg_arr[1] <= 255 && $bg_arr[2] <= 255) {
                $config['bg'] = $bg_arr;
            }
        }
        $id = $this->request->param('captcha_id', '1', 'trim');
        $Captcha = new Captcha($config);
        return $Captcha->entry($id);
    }


    /**
     * Describe:图片验证码验证
     *
     * @param string $value 需要验证的验证码
     * @param string $id    验证码ID
     *
     * @return bool
     * @author lidong<947714443@qq.com>
     * @date   2019/10/22 0022
     */
    public function captcha_check($value = '', $id = '1') {
        $Captcha = new Captcha();
        return $Captcha->check($value, $id);
    }


}