<?php

defined('INC') or exit();

/*定义系统信息*/
define('IS_CGI',substr(PHP_SAPI, 0,3)=='cgi' ? 1 : 0 );
define('IS_WIN',strstr(PHP_OS, 'WIN') ? 1 : 0 );
define('IS_CLI',PHP_SAPI=='cli'? 1   :   0);

if(!IS_CLI) {
    // 当前文件名
    if(!defined('_PHP_FILE_')){
        if(IS_CGI) {
            //CGI/FASTCGI模式下
            $_temp  = explode('.php',$_SERVER['PHP_SELF']);
            define('_PHP_FILE_',    rtrim(str_replace($_SERVER['HTTP_HOST'],'',$_temp[0].'.php'),'/'));
        }else {
            define('_PHP_FILE_',    rtrim($_SERVER['SCRIPT_NAME'],'/'));
        }
    }
    if(!defined('__ROOT__')){
        // 网站URL根目录
        if( strtoupper(APP_NAME) == strtoupper(basename(dirname(_PHP_FILE_))) ) {
            $_root = dirname(dirname(_PHP_FILE_));
        }else {
            $_root = dirname(_PHP_FILE_);
        }
        define('__ROOT__',   (($_root=='/' || $_root=='\\')?'':$_root));
    }

    //支持的URL模式
    /*define('URL_COMMON',      0);   //普通模式
    define('URL_PATHINFO',    1);   //PATHINFO模式
    define('URL_REWRITE',     2);   //REWRITE模式
    define('URL_COMPAT',      3);   // 兼容模式*/
}

/*载入配置文件*/
$GLOBALS['config'] = require(CONFIG_PATH . 'config.php');

/*载入公用功能*/
require(COMMON_PATH . 'common.php');                          //载入基本函数
require(LIB_PATH . 'mysql.php');                              //载入数据库类
require(LIB_PATH . 'template.php');                           //载入模板类
require(LIB_PATH . 'action.php');                             //载入action类
require(LIB_PATH . 'dispatcher.php');                         //载入路由类
?>