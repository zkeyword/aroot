<?php
/**
 * 简单的模板引擎
 * @version 1.1
 * @license
 * -支持模板编译缓存
 * -支持模板缓存静态化
 * -支持简单模板标签(可切换成混编)
 */

if(!defined("INC")) exit("Request Error!");

class template{
	
	private $http_cache     = null;    //页面缓存控制
	private $charset        = null;    //页面字符集
	private $contentType    = null;    //页面编码类型
	private $template_dir   = null;    //模板目录
	private $template_c_dir = null;    //模板缓存目录 
	private $isDebug        = null;    //是否开启Debug模式
	public $overtime        = 3600;    //缓存时间
	public $isCacheHtml     = true;    //是否编译存储html静态缓存文件
	public $isSupportTag    = true;    //是否支持模板标签
	public $isRecompile     = false;   //是否重新编译
	public $template_ext    = '.php';  //模板后缀
	private $tVar           = array(); //模板输出变量
	private $file           = null;    //模板文件名
	private $filePath       = null;    //模板文件路径
	private $authFile       = null;    //加密模板文件名
	private $authFilePath   = null;    //加密缓存文件路径
	private $content        = null;    //编译后的内容

	/**
	 * 实例化静态调用
	 */	
	/*public function instance() {
		static $object;
		if( empty($object) ){
			$object = new template();
		}
		return $object;
	}*/

	
	
	/**
	 * 显示页面
	 * @param {string} 模板名
	 * @param {string} 不同的页面，相同的模板
	 */
	public function display($file, $page=''){
		$this->template_dir   = C('APP_THEME_PATH');                       //模板目录
		$this->template_c_dir = C('APP_CACHE_PATH');                       //模板缓存目录 
		$this->isDebug        = C('APP_DEBUG');                            //是否开启Debug模式
		$this->file           = $file . $this->template_ext;               //模板文件名
		$this->filePath       = $this->template_dir . $this->file;         //模板文件路径
		$this->authFile       = auth($file . $page) . $this->template_ext; //加密模板文件名
		$this->authFilePath   = $this->template_c_dir . $this->authFile;   //加密模板文件路径

		if( !file_exists($this->filePath) ){
			exit($this->file . '--模板文件不存在');
		}

		//初始化是否编译模板
		if( !$this->isTimeOut() ){
			$this->complie();
			$this->render(true);
		}else{
			$this->render(false);
		}
	}

	/**
	 * 获取页面内容
	 * @param {boolean} 是否直接获取编译后在内存中的内容
	 * @param {string} 模板输出字符集
	 * @param {string} 输出类型
	 */
	private function render($isReadMemory){
		
		/*载入模板控制函数*/
		//include $this->template_dir . 'functions.php';

		if( !$isReadMemory){
			ob_start();
			include $this->isCacheHtml ? $this->authFilePath .'.html' : $this->authFilePath;
			$this->content = ob_get_contents();
			ob_end_clean();
		}
		
		/*页面设置*/
		header('Content-Type:'. C('CONTENT_TYPE') .'; charset='. C('CHARSET'));
        header('Cache-control: '. C('HTTP_CACHE'));
		header('X-Powered-By:aroot');
		
		echo $this->content;
	}
	
	/**
	 * 分析内容
	 * @param {string} 模板地址
	 */
	private function token(){
		$str = file_get_contents($this->filePath); //获取文件内容
		
		if($this->isSupportTag){
			$str = preg_replace("/\{include\s+(.+)\}/", "<?php include \\1; ?>", $str);
			
			//echo语句
			$str = preg_replace("/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/ies", "\$this->stripvtags('<? echo \\1; ?>')", $str);
			
			//for语句
			$str = preg_replace("/\{for\s+(.+?)\}/","<?php for(\\1) { ?>", $str);
			$str = preg_replace("/\{\/for\}/","<?php } ?>", $str);
			
			//if语句
			$str = preg_replace("/([\n\r\t]*)\{if\s+(.+?)\}([\n\r\t]*)/ies", "\$this->stripvtags('\\1<? if(\\2) { ?>\\3')", $str);
			$str = preg_replace("/([\n\r\t]*)\{elseif\s+(.+?)\}([\n\r\t]*)/ies", "\$this->stripvtags('\\1<? } elseif(\\2) { ?>\\3')", $str);
			$str = preg_replace("/\{else\}/i", "<? } else { ?>", $str);
			$str = preg_replace("/\{\/if\}/i", "<? } ?>", $str);
			
			//foreach
			$str = preg_replace("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r\t]*/ies", "\$this->stripvtags('<? if(is_array(\\1)) foreach(\\1 as \\2) { ?>')", $str);
			$str = preg_replace("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*/ies", "\$this->stripvtags('<? if(is_array(\\1)) foreach(\\1 as \\2 => \\3) { ?>')", $str);
			$str = preg_replace("/\{\/loop\}/i", "<? } ?>", $str);
			
			//解析PHP语句
			$str = preg_replace("/\{php\s+(.+?)\}/is", "<?php \\1?>", $str);			
		}
				
		return '<?php if(!defined("INC")) exit("Request Error!");?>' . $str;
	}
	private function stripvtags($expr, $statement = '') {
		$expr = str_replace("\\\"", "\"", preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr));
		$statement = str_replace("\\\"", "\"", $statement);
		return $expr.$statement;
	}
	
	/**
	 * 判断是否过期
	 * @return {boolen}
	 */
	private function isTimeOut(){

		if( !file_exists($this->authFilePath) ){
			return false;
		}

		$cache_time    = filemtime($this->authFilePath);
		$template_time = filemtime($this->filePath);
		
		if( $_SERVER['REQUEST_TIME'] - $cache_time > $this->overtime || $template_time > $cache_time || $this->isRecompile || $this->isDebug ){
			$this->isRecompile = false;
			return false;
		}
		
		return true;
	}
	
	/**
	 * 编译储存
	 */
	private function complie(){
		$this->content = $this->token(); //解析模板
		file_put_contents($this->authFilePath, $this->content);
		
		if( $this->isCacheHtml ){
			$this->buildHtml();
		}
	}
	
	/**
	 * 生成静态的html
	 * @param {string} 生成文件的位置
	 */
	public function buildHtml($file = null){

		/*模板阵列变量分解成为独立变量*/
		extract($this->tVar, EXTR_OVERWRITE);
		
		if( !$file ){
			$file = $this->authFilePath;
			ob_start();
			include($file);
			$this->content = ob_get_contents();
			ob_end_clean();
		}

		file_put_contents($file . '.html', $this->content);
	}

	/**
	 * 模板变量赋值
	 * @param {string} 变量名
	 * @param {string} 值
	 */
	public function assign($name, $value = ''){
        if(is_array($name)) {
            $this->tVar = array_merge($this->tVar, $name);
        }else {
            $this->tVar[$name] = $value;
        }
    }

	/*public function deleteCache($file = '',$page = ''){
		$file = $file&&$page ? auth($file.$page).$this->template_ext : $this->authFile;
		$phpFile  = $this->template_c_dir . $file;
		$htmlFile = $this->template_c_dir . $file . '.html';

		if( file_exists( $phpFile ) && file_exists( $htmlFile ) ){
			unlink($phpFile);
			unlink($htmlFile);
		}
	}*/
	
}
?>