<?php
class commonAction extends action{
	
	public $common     = null;
	public $userLogin  = null;
	public $userName   = null;
	public $userID     = null;
	public $userType   = null; 
	public function _initialize(){
		session_start();

		/*载入登陆模块*/
		require(C('APP_GROUP_ROOT') . 'lib/model/userLogin.php');
		$this->userLogin = new login();

		$this->cleckLogin();

		/*公用模块模块*/
		require C('APP_GROUP_ROOT') . 'lib/model/common.php';
		$this->common = new common();

		$actionName = $this->getActionName();
		$methodName = $this->getMethodName();
		$this->assign('actionName', $actionName);
		$this->assign('methodName', $methodName);
	}

	/*登陆检查*/
	private function cleckLogin(){
		$this->userName = isset($_SESSION['username']) ? $_SESSION['username'] : getPGC(auth('username'), 'C');
		$this->userID   = isset($_SESSION['userid']) ? $_SESSION['userid'] : getPGC(auth('userid'), 'C');
		$this->userType = isset($_SESSION['usertype']) ? $_SESSION['usertype'] : getPGC(auth('usertype'), 'C');

		$this->assign('userName', $this->userName);
		$this->assign('userID', $this->userID);
		$this->assign('userType', $this->userType);

		if( !$this->userLogin->isCheckLogin() ){
			$this->assign('username', '');
			$this->assign('userID', '');
			$this->assign('usertype', '');
			if( $this->getActionName() != 'login' ){
				header('Location:' . U('admin.login'));
			}
		}
	}

	/*菜单控制*/
	private function menu(){
		$actionName = $this->getActionName();
		$methodName = $this->getMethodName();
		
	}
}
?>