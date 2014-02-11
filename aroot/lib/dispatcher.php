<?php
/**
 * @author norion.z
 * @class url路由
 * @version 1.0
 * 路由规则(控制和方法部分无值是会默认index)：
 * index.php
 * index.php?controller
 * index.php?controller&method
 * //index.php?controller&method&prarme1=value1
 * //index.php?controller&method&param1=value1&param2=value2.....
 */
class dispatcher{

	private $action = null;    //模块名
	private $method = null;    //模块类名
	//private $params = array(); //模块类方法

	public function __construct(){
		if( APP_NAME && APP_NAME ){
			$this->parseUrl();
			$this->getModule();
			$this->getAction();
		}
	}

	/**
	 * 解析url
	 */
	private function parseUrl(){
		$url        = $_SERVER["QUERY_STRING"];                 //获取url信息
		$urlArr     = explode('&', $url);                       //用&分割成数组
		$urlArr     = array_map('htmlspecialchars', $urlArr);   //过滤url
		$urlArr_num = count($urlArr);                           //统计数组长度
		$keyArr     = array();
		$valArr     = array();


		/*用=分割参数名和参数值，值不存在时赋予null*/
		foreach ($urlArr as $key => $value) {
			$arr = explode('=', $value);
			$keyArr[$key] = strtolower($arr[0]);
			$valArr[$key] = isset($arr[1]) ? $arr[1] : null;
		}

		if( $urlArr_num == 1 || $keyArr[0] == '' ){
			$key = $keyArr[0] ? $keyArr[0] :'index';
			$this->action = $key.'Action';
			$this->method = 'index';
			//$this->params = array($keyArr[0] => $valArr[0]);
		}else{
			$this->action = $keyArr[0].'Action';
			/*当第二个参数的值不为空时，默认method为index方法，第二个参数则为params*/
			if( $valArr[1] != '' ){
				$this->method = 'index';
				//$this->params = array($keyArr[1] => $valArr[1]);
			}else{
				$this->method = $keyArr[1];
			}
			/*第三个起参数为params*/
			/*if( $urlArr_num > 2 ){
				for($i = 2; $i < $urlArr_num; $i++){
		            $urlArr_hash  = array( strtolower($keyArr[$i]) => $valArr[$i] );
		            $this->params = array_merge($this->params, $urlArr_hash);
		        }
			}*/
		}
	}

	/**
	 * 获取模块文件
	 */
	protected function getModule(){
		$group = C('APP_GROUP_PATH');
		if( $group ){
			$path = ABS_PATH . APP_PATH . $group .'/'. APP_NAME . '/';
		}else{
			$path = ABS_PATH . APP_PATH;
		}
		$commonActionPath = $path .'action/commonAction.class.php';
		$actionPath       = $path .'action/'. $this->action .'.class.php';
		
		if( !file_exists($actionPath) ){
			exit($this->action .' 模块文件不存在，请检查'. $actionPath .'是否存在。');
		}
		if( file_exists($commonActionPath) ){
			require $commonActionPath;
		}
		require $actionPath;
	}

	/**
	 * 获取模块及方法
	 */
	protected function getAction(){
		$class  = new $this->action();
		$method = $this->method;

		if( $method == '' ){
			$method = 'index';
		}

		/*判断类里面的方法是否定义*/
		if( method_exists( $class, $method ) ){
			/*该方法是否能被调用*/
			if( is_callable(array($class, $method)) ){
				//$class->getParams( $this->params );    //调用action对象中的方法getParams()并传递参数
				$class->$method();                     //调用模块文件的方法
			}else{
				if( C('APP_DEBUG') ){
					die('该方法不能被调用');
		    	}else{
		    		http_404();
		    	}
			}
		}else{
			if( C('APP_DEBUG') ){
				die('方法不存在');
	    	}else{
	    		http_404();
	    	}
		}
	}
}
new dispatcher();

?>