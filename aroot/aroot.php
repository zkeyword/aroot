<?php
/**
 * @name 公用核心文件
 * @author norion.z
 * @version 1.1
 */

/*版本*/
define('VERSION', '1.1');

/*访问控制*/
define('INC', true);

/*加密设置*/
define('KEY', 'v7FOZgDI');

/*定义资源路径*/
define('ABS_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/'); //系统目录
define('AROOT_PATH', dirname(__FILE__).'/');                  //程序目录
define('LIB_PATH', AROOT_PATH . 'lib/');                      //逻辑源码目录
define('COMMON_PATH', AROOT_PATH . 'common/');                //逻辑源码目录
define('CONFIG_PATH', AROOT_PATH . 'config/');                //逻辑源码目录

if( defined('APP_NAME') ){
	require(COMMON_PATH . 'runtime.php');                     //加载运行时文件
}
?>