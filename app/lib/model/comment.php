<?php
/**
 * 评论类
 * @uses db();
 * @version 1.1
 */

class comment{
	
	private $db = null;
	
	public function __construct(){
		$this->db = new db();
	}

	public function addComment($id){
		global $userID;
		$db      = $this->db;
		$uid     = $userID ? $userID : 0;
		$email   = getPGC('email');
		$author  = getPGC('name');
		$url     = getPGC('url');
		$text    = getPGC('comment');
		$status  = $uid ? 1 : 0;

		$array = array(
			'post_id'    => $id,
			'author'     => $author,
			'email'      => $email,
			'url'        => $url,
			'text'       => $text,
			'status'     => $status,
			//'parent'     => $parent,
			'uid'        => $uid,
			'updataTime' => $_SERVER['REQUEST_TIME'],
			'ip'         => getIp()
		);

		if( $author && $text ){
			$db->insert('comments', $array);
			return $db->insert_id();
		}
		return false;
	}

	public function delComment($array = ''){
		if( !$array ) exit();

		$db = $this->db;

		foreach ($array as $val) {
			$db->delete('comments', 'id = '.$val);
		}
		$db->optimize('comments');
	}

	public function modifyComment($id){
		if( !$id ) exit();
		$db      = $this->db;
		$title   = getPGC('author');
		$url     = getPGC('url');
		$email   = getPGC('email');
		$content = getPGC('content');
		$status = getPGC('status');
		$array   = array(
			'author'     => $author,
			'email'      => $email,
			'url'        => $url,
			'text'       => $content,
			'status'     => $status,
			'updataTime' => $_SERVER['REQUEST_TIME']
		);
		$db->update('comments', $array, 'id='.$id);
	}

	public function commentList($post_id){
		$db   = $this->db;
		$sql  = 'SELECT * FROM '. table('comments') .' WHERE post_id='.$post_id;
		$rows = $db->fetch_array_all($sql);
		return $rows;
	}

	public function commentDetail($id){
		$db        = $this->db;
		$sql       = 'SELECT * FROM '. table('comments') .' WHERE id = '.$id;
		$rows      = $db->fetch_array($sql);
		return $rows;
	}

}

?>