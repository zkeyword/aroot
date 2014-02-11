<?php
/**
 * 用户类
 * @version 1.1
 */
if(!defined("INC")) exit("Request Error!");

class user{
	private $db = '';

	/*初始化*/
	public function __construct(){
		$this->db = new db();
	}

	/**
	 * tag列表
	 * @param {number} 当前分页位置索引
	 * @param {number} 列表显示条数
	 * @return {array} tag列表结果集，包含tag列表所有内容，tag总数
	 */
	public function userList($current = 1, $tagSize = 10){
		$db       = $this->db;
		$limit    = ' LIMIT ' . ($current - 1) * $tagSize . ',' . $tagSize;
		$allSql   = 'SELECT * FROM ' . table('user');
		$pagedSql = $allSql . $limit;
		$rows     = $db->fetch_array_all($pagedSql);
		$total    = $db->num_rows($allSql);
		return array('rows' => $rows, 'total' => $total);
	}

	public function userDetail(){
		$db       = $this->db;

		$name   = getPGC('name');
		$email  = getPGC('email');
		$pw     = getPGC('pw');
		$type   = getPGC('type');
		$status = getPGC('status');
	}

	public function addUser(){
		$db       = $this->db;
		
		$name   = getPGC('name');
		$email  = getPGC('email');
		$pw     = getPGC('pw');
		$type   = getPGC('type');
		$status = getPGC('status');
	}

	public function modifyUser(){

	}
}
?>