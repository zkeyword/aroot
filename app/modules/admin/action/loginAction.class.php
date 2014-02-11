<?php
/**
 * 登陆类
 */
class loginAction extends commonAction{

	/**
	 *登陆页面
	 */
	public function index(){
		if( $this->userLogin->isCheckLogin() ){
			header('Location:' . U(APP_NAME.'.index'));
		}else{
			$isLoginErrorNo = isset($_SESSION['loginErrorNo']) ? $_SESSION['loginErrorNo'] > 2 : 0;
			$this->assign('isLoginErrorNo', $isLoginErrorNo);
			$this->display('login');
		}
	}

	/**
	 *登出
	 */
	public function loginout(){
		$this->userLogin->loginOut();
		header('Location:' . U(APP_NAME.'.login'));
	}

	/**
	 *登陆提交
	 */
	public function login(){
		if( $this->isAjax() ){
			$userName   = getPGC('user');
			$userPwd    = getPGC('pw');
			$keepLogin  = getPGC('keepLogin');
			$submit     = getPGC('submit');

			/*登陆出错次数，其中次数要加1*/
			$isLoginErrorNo = isset($_SESSION['loginErrorNo']) ? $_SESSION['loginErrorNo'] > 2 : 0;

			/*提交表单*/
			if( $submit ){
				if( $isLoginErrorNo ){
					if( $this->checkCode() ){
						$msg = $this->userLogin->checkUser($userName, $userPwd, $keepLogin);
					}else{
						$msg = '验证码出错';
					}
				}else{
					$msg = $this->userLogin->checkUser($userName, $userPwd, $keepLogin);
				}
				$arr = array('msg'=>$msg,'isLoginErrorNo'=>$isLoginErrorNo);
				echo json_encode($arr);
			}
		}
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