<?php
/**
 * 登陆类
 */
class loginAction extends commonAction{
	private $userLogin = null;

	public function initialize(){
		session_start();

		/*载入用户登陆类*/
		require(C('APP_GROUP_ROOT') . 'lib/model/userLogin.php');
		$this->userLogin = new login();
	}

	/**
	 *登陆页面
	 */
	public function index(){

		/*登陆检查*/
		if( $this->userLogin->isCheckLogin() ){
			// header('Location:index.php');
		}

		$showCatList = $this->common->getNav();
		$this->assign('showCatList', $showCatList);
	}

	/**
	 *登陆提交
	 */
	public function login(){


		//if( $this->isAjax() ){
			$userName   = getPGC('user');
			$userPwd    = getPGC('pw');
			$keepLogin  = getPGC('keepLogin');
			$submit     = getPGC('submit');
			

			/*提交表单*/
			if( $submit ){
				if( $this->checkCode() ){
					$this->userLogin->checkUser($userName, $userPwd, $keepLogin);
				}else{
					echo '验证码出错';
				}
			}
		//}
	}

	/**
	 *验证码
	 */
	public function code(){
		require(LIB_PATH . 'checkcode.class.php');
		$checkcode = new checkcode();
		$_SESSION['randCode'] = $checkcode->get_code();
	}

	/**
	 *校验验证码
	 */
	public function checkCode(){
		return ( strtolower(getPGC('randCode')) == strtolower($_SESSION["randCode"]) ) ? true : false;
	}
}
?>