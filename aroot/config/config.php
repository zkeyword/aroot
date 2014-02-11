<?php
/**
 * @name 基础配置文件
 * @author norion.z
 * @version 1.1
 */
$appConfigPath = ABS_PATH . APP_PATH . 'config/config.php';
$isAppConfig   = file_exists($appConfigPath);
$group         = '';
$theme         = 'default';
$path          =  ABS_PATH . APP_PATH;
if( $isAppConfig ){
	$appConfigArr = require $appConfigPath;
	/*判断是否应用分组*/
	if( isset($appConfigArr['APP_GROUP_PATH']) ){
		$group          = $appConfigArr['APP_GROUP_PATH'];
		$groupAppPath   = $path . $group .'/'. APP_NAME . '/config/config.php';
		if( file_exists($groupAppPath) ){
			$groupConfigArr = require $groupAppPath;
			$appConfigArr   = array_merge($appConfigArr, $groupConfigArr);
		}
	}
	if( isset($appConfigArr['APP_THEME']) ){
		$theme = $appConfigArr['APP_THEME'];
	}
	$path = $path . $group .'/'. APP_NAME . '/';
}

$config = array(

	/*MySQL主机设置*/
	'DB_HOST' => 'localhost',
	'DB_USER' => '',
	'DB_PASSWORD' => '',
	'DB_NAME' => '',
	'TABLE_PREFIX' => 'z_',

	/*页面设置*/
	'LANG' => 'zh_CN',
	'HTTP_CACHE' => 'no-cache',
	'CHARSET' => 'UTF-8',
	'CONTENT_TYPE' => 'text/html',

	/*绝对路径*/
	'APP_PATH_ROOT' => $path,
	'APP_GROUP_ROOT' => ABS_PATH . APP_PATH,
	
	/*公用资源文件夹*/
	'APP_RESOURCES_DIR' => __ROOT__ .'/'. APP_PATH . 'resources/',  

	/*主题设置*/
	'APP_THEME' => $theme,
	'APP_THEME_PATH' => $path . 'resources/themes/'. $theme .'/',
	'APP_THEME_DIR' => __ROOT__ .'/'. APP_PATH . 'resources/themes/'. $theme .'/',
	'APP_GROUP_THEME_DIR' => __ROOT__ .'/'. APP_PATH . $group .'/'. APP_NAME . '/resources/themes/'. $theme .'/',
	'APP_GROUP_SCRIPT_DIR' => __ROOT__ .'/'. APP_PATH . $group .'/'. APP_NAME . '/resources/script/',

	/*缓存设置*/
	'APP_CACHE_PATH' => $path .'data/cache/',

	/*上传目录*/
	'APP_UPLOAD_PATH' => $path . 'data/upload/',

	/*DEBUG模式*/
	'APP_DEBUG' => false, 

	/*url模式*/
	'URL_MODEL' => 0,   //默认0为普通模式，1为伪静态模式，2为静态模式
 
	/*静态化设置*/
	'HTML_PATH' => __ROOT__ . 'html',   //静态化html目录
);

return $isAppConfig ? array_merge($config, $appConfigArr) : $config;
?>