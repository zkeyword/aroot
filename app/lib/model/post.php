<?php
/**
 * 文章类
 * @uses db();
 * @version 1.1
 */
if(!defined("INC")) exit("Request Error!");

class post{
	private $db = null;
	
	public function __construct(){
		$this->db = new db();
	}
	
	/**
	 * 添加post
	 * @param {array}
	 * @return {number|boolean} 文章标题存在返回false; 
	 */
	public function addPost($arr){
		$db          = $this->db;
		$author      = $arr['author'];
		$title       = $arr['title'];
		$description = $arr['description'];
		$content     = $arr['content'];
				
		if( !$this->checkPost($title) ){
			$array = array(
				'author'      => $author,
				'title'       => $title,
				'description' => $description,
				'content'     => $content,
				'type'        => 1,
				'updataTime'  => $_SERVER['REQUEST_TIME']
			);
			$db->insert('post', $array);
			return $db->insert_id();
		}
		
		return false;
	}
	
	/**
	 * 删除post
	 * @param {array} 要删除post的id集合
	 */
	public function deletePost($arr = ''){
		if( !$arr ) exit();

		$db = $this->db;

		foreach ($arr as $val) {
			$db->delete('post', 'post_id = '.$val);
		}
		$db->optimize('post');
	}
	
	/**
	 * 修改post
	 * @param {array}
	 */
	public function modifyPost($arr){
		$db          = $this->db;
		$id          = $arr['id'];
		$title       = $arr['title'];
		$description = $arr['description'];
		$content     = $arr['content'];
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
	public function checkPost($title){
		$db       = $this->db;
		$sql      = 'SELECT post_id FROM '. table('post') .' WHERE title = ' . trim($title);
		$isRepeat = $db->num_rows($sql);
		if( $isRepeat ){
			return true;
		}
		return false;
	}

	/**
	 * 文章列表
	 * @param {number} 当前分页位置索引
	 * @param {number} 文章显示条数
	 * @param {string} term类别别名，为null时查找全部
	 * @param {number} term类别分类，1为cat、2为tag
	 * @return {array} 文章列表结果集，包含文章列表所有内容，文章总数
	 */
	public function postList($current = 1,  $pageSize = 10, $slug = null, $type = 1){
		$db        = $this->db;
		$find      = 'p.post_id id,
					  p.title title,
					  p.description description,
					  p.content content,
					  p.updataTime time,
					  u.displayname author';
		$link      = ' p.author = u.id AND t.term_id = p.post_id AND p.type = 1 AND t.type = '. $type;
		$getCat    = $slug ? ' AND t.slug = "'. $slug.'"' : ' ';
		$limit     = 'LIMIT '. ($current - 1) * $pageSize .','. $pageSize;
		$condition = 'WHERE' . $link . $getCat;
		$allSql    = 'SELECT '. $find .' FROM '. table('post') .' p, '. table('user') .' u ,'. table('term') .' t '. $condition;
		$pagedSql  = $allSql . $limit;
		$rows      = $db->fetch_array_all($pagedSql);
		$total     = $db->num_rows($allSql);
		return array('rows' => $rows, 'total' => $total);
	}

	/**
	 * post详细
	 * @param {number} post ID
	 * @return {array} 
	 */
	public function postDetail($id, $type = 1){
		$db        = $this->db;
		$find      = 'p.post_id id,
					  p.title title,
					  p.description description,
					  p.content content,
					  p.updataTime time,
					  u.name author,
					  m.meta_value';
		$condition = 'WHERE p.post_id = '. $id .' AND p.type = '. $type .' AND p.author = u.id;';
		$join      = ( $type == 1 ) ? 'LEFT JOIN '. table('postMeta') .' m ON p.post_id = m.post_id AND m.meta_key = "thumb" ':'';
		$sql       = 'SELECT ' . $find . ' FROM ('. table('post') .' p, '. table('user') .' u) '. $join . $condition;
		$rows      = $db->fetch_array($sql);
		return $rows;
	}

	/**
	 * 文章上下篇
	 * @param {number} 文章ID
	 * @param {string} 文章上下篇类型
	 * @param {string} 文章上下篇类型
	 * @return {array}
	 */
	public function getPostBother($id, $pointer = 'next', $type = 1){
		$db    = $this->db;
		$where = "WHERE type = ". $type .' AND post_id'. ($type == 'next' ?  " > ". $id : " < ". $id .' ORDER BY post_id DESC' );
		$sql   = "SELECT post_id, title FROM ". table("post")  ." $where LIMIT 0,1";
		$rows  = $db->fetch_array($sql);
		return $rows;
	}

}

?>