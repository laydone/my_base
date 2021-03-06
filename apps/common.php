<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用全局公共文件
use think\facade\Env;

/* 加载应用公共模块function文件 */
if (!defined('COMMON_FUNCTION_FILE')) define('COMMON_FUNCTION_FILE', Env::get('app_path') . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'common.php');/* 定义公共应用文件位置 */
if (file_exists(COMMON_FUNCTION_FILE)) include_once COMMON_FUNCTION_FILE;
/* 加载扩展库function文件*/
if (!defined('EXTEND_FUNCTION_FILE')) define('EXTEND_FUNCTION_FILE', Env::get('extend_path') . DIRECTORY_SEPARATOR . 'base' . DIRECTORY_SEPARATOR . 'mybase' . DIRECTORY_SEPARATOR . 'common.php');/* 定义扩展库应用文件位置 */
if (file_exists(EXTEND_FUNCTION_FILE)) include_once EXTEND_FUNCTION_FILE;