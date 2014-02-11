<?php
class userAction extends commonAction{
	public function index(){
		/*载入user类*/
		require(C('APP_GROUP_ROOT') . 'lib/model/user.php');
		$user = new user();

		$userList  = $user->userList();
		$userRows  = $userList['rows'];
		$userTotal = $userList['total'];
		$page      = getPGC('page') ? getPGC('page') : 1;

		/*重写数据库提取的值*/
		foreach($userRows as $key => $val){
			foreach ($val as $key2 => $val2) {
				if( $key2 == 'lastLoginTime' || $key2 == 'registeredTime' ){
					if( $val2 ){
						$val2 = formatTime($val2, 3);
					}else{
						$val2 = '未登陆过';
					}
				}elseif( $key2 == 'type' ){
					if( $val2 == '1' ){
						$val2 = '管理员';
					}elseif($val2 == '2'){
						$val2 = '普通用户';
					}
				}elseif( $key2 == 'id' ){
					$userRows[$key]['url'] = U(APP_NAME.'.user/detail/id/'.$val2);
				}
				$userRows[$key][$key2] = $val2;
			}
		}

		/*分页*/
		$this->common->pagination->setLink = U(APP_NAME.'.user/page/{str}');
		$paged = $this->common->pagination->show($page, $userTotal);

		$this->assign('userRows', $userRows);
		$this->assign('paged', $paged);
		$this->display('user_list', $paged);
	}

	public function detail(){
		$id = getPGC('id') ? getPGC('id') : 1;

		// if( $usertype == 1 ){
			
		// }

		$this->display('user_detail', $id);
	}

	public function add(){
		if( getPGC('rightSubmit') ){
			$userName    = getPGC('name');
			$displayname = getPGC('displayname') ? getPGC('displayname') : $userName;
			$email       = getPGC('email');
			$userPwd     = getPGC('pw');
			if( $userName && $email && $userPwd ){
				$userPwd = auth( $userPwd );
				$array   = array(
									'name'=>$userName,
									'password'=>$userPwd,
									'displayname'=>$displayname,
									'email'=>$email,
									'registeredTime'=>$_SERVER['REQUEST_TIME']
								);
				$db = $this->db;
				$userID = $db->insert('user', $array);
			}
		}
		$this->display('user_detail', 'add');
	}
}
?>