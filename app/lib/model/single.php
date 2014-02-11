<?php
/**
 * 单页类
 * @uses db();
 * @version 1.1
 */

class single{
	private $db = null;
	
	public function __construct(){
		$this->db = new db();
	}
	
	public function addSingle($author, $title, $description, $content){
		$db = $this->db;
				
		if( !$this->checkSingle($title) ){
			$array = array(
				'author'      => $author,
				'title'       => $title,
				'description' => $description,
				'content'     => $content,
				'type'        => 2,
				'updataTime'  => $_SERVER['REQUEST_TIME']
			);
			$db->insert('post', $array);
			return $db->insert_id();
		}

		return false;
	}

	public function deleteSingle($array = ''){
		if( !$array ) exit();

		$db = $this->db;

		foreach ($array as $val) {
			$db->delete('post', 'post_id = '.$val);
		}
		$db->optimize('post');
	}

	public function modifySingle($id, $title, $description, $content){
		if( !$id ) exit();
		$db          = $this->db;
		$array       = array(
			'title'       => $title,
			'description' => $description,
			'content'     => $content,
			'updataTime'  => $_SERVER['REQUEST_TIME']
		);
		$db->update('post', $array, 'post_id='.$id);
	}

	/**
	 * 检查post标题是否存在
	 * @param {number} post标题
	 * @param {boolean} 
	 */
	public function checkSingle($title){
		$db  = $this->db;
		$sql = 'SELECT post_title FROM '. table('post') .' WHERE post_title = ' . trim($title);
		$isRepeat = $db->num_rows($sql);
		if( $isRepeat ){
			return true;
		}
		return false;
	}

	public function singleList($current = 1,  $pageSize = 10){
		$db = $this->db;
		$find      = 'p.post_id id,
					  p.title title,
					  p.description description,
					  p.content content,
					  p.updataTime time,
					  u.displayname author';
		$link      = ' p.author = u.id AND p.type = 2 ';
		$limit     = 'LIMIT '. ($current - 1) * $pageSize .','. $pageSize;
		$condition = 'WHERE' . $link;
		$allSql    = 'SELECT '. $find .' FROM '. table('post') .' p, '. table('user') .' u '. $condition;
		$pagedSql  = $allSql . $limit;
		$rows      = $db->fetch_array_all($pagedSql);
		$total     = $db->num_rows($allSql);
		return array('rows' => $rows, 'total' => $total);
	}

	public function singleDetail($id){
		$db        = $this->db;
		$find      = 'p.post_id id,
					  p.title title,
					  p.description description,
					  p.content content,
					  p.updataTime time,
					  u.name author,
					  m.meta_value';
		$condition = 'WHERE p.post_id = '. $id .' AND p.type = 2 AND p.author = u.id;';
		$join      = 'LEFT JOIN '. table('postMeta') .' m ON p.post_id = m.post_id AND m.meta_key = "thumb" ';
		$sql       = 'SELECT ' . $find . ' FROM ('. table('post') .' p, '. table('user') .' u) '. $join . $condition;
		$rows      = $db->fetch_array($sql);
		return $rows;
	}
}

?>