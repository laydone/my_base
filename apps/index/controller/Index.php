<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\facade\Env;

class Index extends Common {

	public function index() {
		return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
	}


	public function hello($name = 'ThinkPHP5') {
		return 'hello,' . $name;
	}


	public function test() {
		dump('think_path=' . Env::get('think_path'));
		dump('root_path=' . Env::get('root_path'));
		dump('app_path=' . Env::get('app_path'));
		dump('config_path=' . Env::get('config_path'));
		dump('route_path=' . Env::get('route_path'));
		dump('runtime_path=' . Env::get('runtime_path'));
		dump('extend_path=' . Env::get('extend_path'));
		dump('vendor_path=' . Env::get('vendor_path'));
		dump(COMMON_FUNCTION_FILE);
		test();
		dump('11');
		dump(config('middleware.default_namespace'));
		dump(ihuyi_sms('13232323232', 'shushushushsu'));
		dump(get_protocol());
	}


}
