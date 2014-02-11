<?php
/**
 * 注册类
 */
class registerAction extends commonAction{
	private $register = null; 

	public function initialize(){
		session_start();

		/*载入用户登陆类*/
		require(C('APP_GROUP_ROOT') . 'lib/model/userRegister.php');
		$this->register = new register();
	}

	/**
	 * 注册界面
	 */
	public function index(){
		$showCatList = $this->common->getNav();

		$this->isRecompile(true);
		//$this->assign('message', $message);
		$this->assign('showCatList', $showCatList);
		$this->display('register');
	}

	/**
	 * 注册
	 */
	public function registerUser(){
		$userName  = getPGC('user');
		$useremail = getPGC('email');
		$userPwd   = getPGC('pw');
		$userPwd2  = getPGC('pw2');
		$submit    = getPGC('submit');

		/*提交表单*/
		if( $submit ){
			if( $userPwd != $userPwd2 ){
				echo '两次输入的密码不一致';
			}else{
				if( $this->checkCode() ){
					if( !$this->checkUserName($userName) ){
						$this->register->addUser($userName, $useremail, $userPwd);
						echo '注册成功';
					}else{
						echo '用户名已存在';
					}
				}else{
					echo '验证码出错';
				}
			}
		}
	}

	/**
	 * 校验验证码
	 */
	public function checkCode(){
		return ( strtolower(getPGC('randCode')) == strtolower($_SESSION["randCode"]) ) ? true : false;
	}

	
	/**
	 * 校验用户名
	 */
	public function checkUserName($userName){
		$this->register->checkUserName($userName);
	}
}
?>