<?php
/**
 * 登陆类
 * @version 1.1
 */
if(!defined("INC")) exit("Request Error!");

class login{
	private $userName       = '';
	private $userPwd        = '';
	private $db             = '';
	public $sessionOvertime = 3600;    // session过期时间1小时
	public $cookieOvertime  = 604800;  // cookie过期时间7天
	
	/*初始化*/
	public function __construct(){
		$this->db = new db();
	}

	/*注销*/
	public function __destruct(){}

	/**
	 * 检验用户是否需要登录
	 * @param {string} $username 用户名
	 * @param {string} $userpwd 密码
	 * @param {string} $keepLogin 记住登录状态
	 */
	public function checkUser($username, $userpwd, $keepLogin){
		$db   = $this->db;
		$time = $_SERVER['REQUEST_TIME'];

		//只允许用户名和密码用0-9,a-z,A-Z,'@','_','.','-'这些字符
		$this->userName = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $username);
		$this->userPwd  = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $userpwd);
		$this->userPwd  = auth( $this->userPwd );
		setcookie(auth('username'), $this->userName, $time+$this->cookieOvertime, '/');

		/*对比数据*/
		$sql     = 'SELECT * FROM '. table('user') .' WHERE name = "'. $this->userName .'"';
		$obj     = $db->fetch_object($sql);
		$errorNo = isset($_SESSION['loginErrorNo']) ? $_SESSION['loginErrorNo'] : 0;
		if( $obj ){
			if( $obj->password != $this->userPwd ){
				$_SESSION['loginErrorNo'] = $errorNo +1;
				return '密码错误';
			}else{
				if( $this->isKeepLogin($keepLogin) ){
					setcookie(auth('userid'), $obj->id, $time+$this->cookieOvertime, '/');
					setcookie(auth('usertype'), $obj->type, $time+$this->cookieOvertime, '/');
					setcookie(auth('userip'), auth(getIp()), $time+$this->cookieOvertime, '/');
				}else{
					$_SESSION['username'] = $this->userName;
					$_SESSION['userid']   = $obj->id;
					$_SESSION['usertype'] = $obj->type;
					$_SESSION['time']     = $time;
					$db->update('user', array('lastLoginTime' => $time), 'name = "'. $this->userName .'"');
				}
				unset($_SESSION['loginErrorNo']);
				return '登录成功';
			}
		}else{
			$_SESSION['loginErrorNo'] = $errorNo +1;
			return '该用户名不存在';
		}
	}

	/**
	 * 检查是否登陆
	 * @return {boolean}
	 */
	public function isCheckLogin(){
		if( isset($_SESSION['userid']) && !$this->timeOut() ){
			return true;
		}elseif( getPGC(auth('userid'), 'C') && getPGC(auth('userip'), 'C') == auth(getIp()) ){
			return true;
		}
		return false;
	}

	/**
	 * 退出
	 */
	public function loginOut(){
		if( isset($_SESSION['userid']) ){
			unset($_SESSION['username'], $_SESSION['userid'], $_SESSION['usertype'], $_SESSION['time']);
		}else{
			$time = $_SERVER['REQUEST_TIME'];
			setcookie(auth('userid'), '', $time-1, '/');
			setcookie(auth('usertype'), '', $time-1, '/');
			setcookie(auth('userip'), '', $time-1, '/');
		}
	}

	/**
	 * 保持会话
	 * @return {boolean}
	 */
	private function isKeepLogin( $keepLogin ){
		if( $keepLogin ){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 超时
	 * @return {boolean} 超时后返回false;
	 */
	private function timeOut(){
		if( $_SERVER['REQUEST_TIME'] - $_SESSION['time'] > $this->sessionOvertime ){
			$this->loginOut();
			return false;
		}else{
			$_SESSION['time'] = $_SERVER['REQUEST_TIME'];
		}
	}
}
?>