<?php
/**
 * Action控制器基类 抽象类
 */
abstract class Action{
	private $template = null;  //模板视图实例对象

	public function __construct(){

		//$this->template = template::instance();
		$this->template = new template();

		//公共控制器初始化
        if(method_exists($this, '_initialize'))
            $this->_initialize();

        //私有控制器初始化
        if(method_exists($this, 'initialize'))
            $this->initialize();
	}

	/**
	 * 显示模板
	 * @param {string} 模板名称
	 * @param {number} 分页
	 * @param {boolean} 是否重新编译
	 */
	protected function display($file, $page = ''){
		$this->template->display($file, $page);
	}

	/**
	 * 是否重新编译模板
	 * @param {boolean} 变量的值
	 */
    protected function isRecompile($value){
		$this->template->isRecompile = $value;
    }

    /**
	 * 是否生成html静态缓存文件
	 * @param {boolean} 变量的值
	 */
    protected function isCachehtml($value){
		$this->template->isCachehtml = $value;
    }

	/**
	 * 创建html静态文件
	 * @param {boolean} 变量的值
	 * @param {string} html文件放置的位置
	 */
	protected function buildHtml($file = ''){
		if( $file ){
			$this->template->buildHtml($file);
		}
    }

    /**
	 * 模板变量赋值
	 * @param {string} 要显示的模板变量
	 * @param {number} 变量的值
	 */
    protected function assign($name, $value=''){
		$this->template->assign($name, $value);
    }

    protected function success($message){

    }

    protected function error($message){
    	
    }

	/**
	 * 获取Action名称
	 */
    public function getActionName(){
        return substr(get_class($this),0,-6);
    }

    /**
	 * 获取method名称
	 */
    public function getMethodName(){
        $url        = $_SERVER["QUERY_STRING"];                 //获取url信息
		$urlArr     = explode('&', $url);                       //用&分割成数组
		$urlArr_num = count($urlArr);                           //统计数组长度

		if( $urlArr_num < 2 ){
			$method = 'index';
		}else{
			$method = $urlArr[1];
		}
		return $method;
    }

	/**
	 * 显示模板
	 * @param {string} 模板名称
	 * @param {number} 分页
	 * @param {boolean} 是否重新编译
	 */
    protected function isAjax(){
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
                return true;
        }
        if(!empty($_POST['ajax']) || !empty($_GET['ajax']))
            // 判断Ajax方式提交
            return true;
        return false;
    }

	/**
     * 魔术方法 有不合法或不存在的操作的时候执行
	 * @param {string} 方法名
	 * @param {array} 参数
     */
    public function __call($method, $args){
    	if( C('APP_DEBUG') ){
    		die($method.'方法私有或受保护,不能通过url方式调用');
    	}else{
    		http_404();
    	}
    }

}
?>