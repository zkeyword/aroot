<?php
if(!defined("INC")) exit("Request Error!");

/*
 * 随机字符
 * @param {number}
 * @return {string}
 */
function random($num){
	$str = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ');
	return substr($str, 0, $num);
}

/*
 * 验证码
 * @return {string} img图片
 */
function randImg(){
	return '<img src="'. __ROOT__ .'?login&code" id="randImg" onclick="document.getElementById(\'randImg\').src=\''. __ROOT__ .'?login&code&v=\'+Math.random()" />';
}

/*
 * 加密
 * @param {string}
 * @return {string}
 */
function auth($text){
	return md5(md5($text).KEY);
}

/*
 * 中转信息
 * @param {string}
 * @return {string}
 */
function showMsg($text){
	echo $text;
}

/*
 * 格式化时间
 * @param {string} 时间戳
 * @param {number} 显示类型
 * @param {string}
 */
function formatTime($timestr = NULL, $type = 0){  
    //获取周几  
    $arr = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');  
    $i = date("w", $timestr);  
      
    //设置北京时间并获取时间戳  
    date_default_timezone_set('PRC');   
  
    //设置时间显示格式  
    $str1 = date("Y年m月d日 H:m:s", $timestr) . " " . $arr[$i];  
    $str2 = date("Y-m-d H:m:s", $timestr) . " " . $arr[$i];  
    $str3 = date("Y-m-d", $timestr);
	
	switch( $type ){
		case 2:
			$str = $str2;
			break;
		case 3:
			$str = $str3;
			break;
		default:
			$str = $str1;
	}
	return $str;
}

/*
 * 数据表前缀
 * @param {string}
 * @return {string}
 */
function table($table){
	return C('TABLE_PREFIX') . $table;
}

/**
 * 获取用户ip地址
 * @param {number} $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return {string} 
 */
/*function getIp() {
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if (!ip2long($ip)) {
		$ip = '';
	}
	return $ip;
}*/
function getIp($type = 0) {
	$type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 获取Gravatar头像
 * http://en.gravatar.com/site/implement/images/
 * @param $email
 * @param $s size
 * @param $d default avatar
 * @param $g
 */
function getGravatar($email, $s = 40, $d = 'mm', $g = 'g') {
	$hash = md5($email);
	$avatar = "http://www.gravatar.com/avatar/$hash?s=$s&d=$d&r=$g";
	return $avatar;
}

/**
 * 获取$_GET、$_POST、$_COOKIE变量
 * @param {string} 变量
 * @param {string} 类型G、P、C，分别代表$_GET、$_POST、$_COOKIE
 */
function getPGC($k, $type='GP', $filter='') {
	$type = strtoupper($type);
	switch($type) {
		case 'G': $var = &$_GET; break;
		case 'P': $var = &$_POST; break;
		case 'C': $var = &$_COOKIE; break;
		default:
			if(isset($_GET[$k])) {
				$var = &$_GET;
			} else {
				$var = &$_POST;
			}
			break;
	}
	return isset($var[$k]) ? (
		empty($filter) ? (
			is_array($var[$k]) ? array_map('htmlspecialchars', $var[$k]) : htmlspecialchars($var[$k]) 
		) : $var[$k]
	) : NULL;
}

/**
 * 该函数在插件中调用,挂载插件函数到预留的钩子上
 *
 * @param {string} 挂钩名称
 * @param {string} 要挂函数，支持带参
 * @return {boolean}
 */
function addAction($hook, $actionFunc) {
	global $emHooks;
	if (!@in_array($actionFunc, $emHooks[$hook])) {
		$emHooks[$hook][] = $actionFunc;
	}
	return true;
}

/**
 * 执行挂在钩子上的函数,支持多参数 
 * @param string $hook
 * eg:doAction('post_comment', $author, $email, $url, $comment);
 */
function doAction($hook) {
	global $emHooks;
	$args = array_slice(func_get_args(), 1);
	if (isset($emHooks[$hook])) {
		foreach ($emHooks[$hook] as $function) {
			$string = call_user_func_array($function, $args);
		}
	}
}


/**
 * 载入头模板
 */
/*function getHeader(){
	$file = THEMES_PATH . 'header.php';
	if(!file_exists($file)){
		exit($file . '--模板header.php文件不存在');
	}
	$str = file_get_contents($file);
	$str = preg_replace("/([\n\r\t]*)<\/head>/is",
						"<?php doAction('after_setup_theme'); ?></head>",
						$str);
	eval('?>' . $str);
}*/

/**
 * 载入尾模板
 */
/*function getFooter(){
	$file = THEMES_PATH . 'footer.php';
	if(!file_exists($file)){
		exit($file . '--模板footer.php文件不存在');
	}
	include($file);
}*/

/**
 * 将页面属性设置成404
 */
function http_404(){
	header("HTTP/1.1 404 Not Found");
	exit();
}

/**
 * 树形数化无限分类 
 *
 * @param {array} 数据
 * @param {string} id
 * @param {string} 父id的名称
 * @param {string} 子的名称
 * @return {array}
 * $items = array(
 *				array('id' => 1, 'pid' => 0, 'name' => '一级11' ),
 *				array('id' => 11, 'pid' => 0, 'name' => '一级12' ),
 *				array('id' => 2, 'pid' => 1, 'name' => '二级21' ),
 *				array('id' => 10, 'pid' => 11, 'name' => '二级22' ),
 *				array('id' => 3, 'pid' => 1, 'name' => '二级23' ),
 *				array('id' => 12, 'pid' => 11, 'name' => '二级24' ),
 *				array('id' => 9, 'pid' => 1, 'name' => '二级25' ),
 *			);
 */
/*function formatTree($items, $id='id', $pid='pid', $son='son'){
	$tree = array(); //格式化的树
	$tmpMap = array();  //临时扁平数据
	
	foreach ($items as $item) {
		$tmpMap[$item[$id]] = $item;
	}
	
	foreach ($items as $item) {
		if (isset($tmpMap[$item[$pid]])) {
			$tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
		} else {
			$tree[] = &$tmpMap[$item[$id]];
		}
	}
	unset($tmpMap);
	return $tree;
}*/
function formatTree($array, $pid = 0){
	$arr = array();
	$tem = array();
	foreach ($array as $v) {
		if ($v['pid'] == $pid) {
			$tem = formatTree($array, $v['id']);
			$tem && $v['son'] = $tem;
			$arr[] = $v;
		}
	}
	return $arr;
}

/**
 * 获取和设置配置参数
 * @param {string} 配置变量
 * @param {mixed} 配置值
*/
function C($name = '', $val = ''){
	if( array_key_exists($name, $GLOBALS['config']) ){
		if( !empty($val) ){
			$GLOBALS['config'][$name] = $val;
		}
		return $GLOBALS['config'][$name];
	}elseif( empty($name) ){
		return $GLOBALS['config'];
	}
}

function U($url=''){
	$url = strtolower($url);

	if( strpos($url, '.') ){
		list($module, $url) = explode('.', $url, 2);
		$module = '/'.$module;
	}else{
		$module = '';
	}
	
	if( C('URL_MODEL') == 0 ){
		$arr    = explode('/', $url);
		$len    = count($arr); 
		$str    = '';
		$module = $module ? $module.'.php' : '';

		foreach($arr as $key => $value){
			if( $key == 0 ){
				$str .= '';
			}elseif( $key == 1 ){
				$str .= '&';
			}else{
				if( $len % 2 == 0 ){
					if( $key % 2 != 0 ){
						$str .= '=';
					}else{
						$str .= '&';
					}
				}else{
					if( $key % 2 == 0 ){
						$str .= '=';
					}else{
						$str .= '&';
					}
				}
			}
			$str .= $value;
		}
		return  __ROOT__ . $module.'?'.$str;
	}elseif( C('URL_MODEL') == 1 ){
		$url = str_replace('/', '-', $url);
		return __ROOT__ . $module.'/'.$url.'.html';
	}
}


/*function onError($errCode, $errMesg, $errFile, $errLine) {        
	echo "Error Occurred\n";        
	throw new Exception($errMesg);    
}     
function onException($e) {        
	echo $e->getMessage();    
}     
set_error_handler("onError");     
set_exception_handler("onException"); */

?>