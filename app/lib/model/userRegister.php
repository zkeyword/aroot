<?php
/**
 * 注册类
 * @version 1.1
 */
if(!defined("INC")) exit("Request Error!");

class register{
	private $db = '';

	/*初始化*/
	public function __construct(){
		$this->db = new db();
	}

	/*注销*/
	public function __destruct(){}

	/**
	 * 添加用户
	 * @param {string} $username 用户名
	 * @param {string} $useremail 邮箱
	 * @param {string} $userpwd 密码
	 */
	public function addUser($username, $useremail, $userpwd){
		//只允许用户名和密码用0-9,a-z,A-Z,'@','_','.','-'这些字符
		$userName = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $username);
		$email    = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $useremail);
		$userPwd  = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $userpwd);
		
		if( $userName && $email && $userPwd ){
			$userPwd = auth( $userPwd );
			$array   = array(
								'name'=>$userName,
								'password'=>$userPwd,
								'displayname'=>$userName,
								'email'=>$email,
								'registeredTime'=>$_SERVER['REQUEST_TIME']
							);
			$db = $this->db;
			$db->insert('user', $array);
		}//end if
	}
	
	/**
	 * 检查用户是否存在
	 * @param {string} $username 用户名
	 * @return {boolean}
	 */
	public function checkUserName($username){
		$userName = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $username);
		$db       = $this->db;
		$sql      = 'SELECT * FROM '. table('user') .' WHERE name = "'. $userName .'"';
		$num      = $db->num_rows($sql);
		if( $num ){
			return true;
		}
		return false;
	}
}

?>