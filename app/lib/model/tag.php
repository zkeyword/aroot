<?php
/**
 * 标签类
 * @uses db();
 * @version 1.1
 */
if(!defined("INC")) exit("Request Error!");

class tag{

	private $db = null;
	
	public function __construct(){
		$this->db = new db();
	}
	
	/**
	 * 添加tag
	 * @param {string} 以半角逗号“,”分割开的字符串如：标签1,标签2,标签3,标签4
	 * @param {number} 要添加关联的文章ID
	 */
	public function addTag($str = null, $post_id = null){
		$db     = $this->db;

		if( $str && $str ){
			$str    = preg_replace('/,{2,}/', ',', $str);
			$str    = preg_replace('/(^,)|(,*$)|(\s+)/', '', $str);
			$strArr = $str ? explode(',', $str) : array();
			
			foreach ($strArr as $val) {
				if( !empty($val) ){

					$id = $this->getTagID($val);

					//添加tag和获取tag ID
					if( !$id ){
						$array = array(
							'name' => $val,
							'slug' => $val,
							'type' => 2
						);
						$db->insert('term', $array);
						$term_id = $db->insert_id();
					}else{
						$term_id = $id;
					}
					
					//添加关联
					$this->addRelated($term_id, $post_id);
				}
			}

		}else{

			$name        = getPGC('name');
			$slug        = getPGC('slug');
			$description = getPGC('description');

			if( $name && $slug ){
				$array       = array(
					'name'        => $name,
					'slug'        => $slug,
					'type'        => 2,
					'description' => $description
				);
				$db->insert('term', $array);
				return $db->insert_id();
			}
		}
	}
	
	/**
	 * 删除tag
	 * @param {number} tag ID
	 */
	public function deleteTag($term_id){
		$db   = $this->db;
		$sql  = 'SELECT post_id FROM '. table('relationships') .'  WHERE term_id ='. $term_id .';';
		$rows = $db->fetch_array_all($sql);

		//删除tag
		$db->delete('term', 'term_id = '.$term_id);

		//删除关联
		foreach($rows as $key => $val){
			$this->deleteRelated($term_id, $rows[$key]['post_id']);
		}
	}

	/**
	 * 修改tag
	 * @param {number} tag ID
	 */
	public function editTag($term_id){
		$db    = $this->db;
		$sql   = 'SELECT name, slug, description FROM '. table('term') .' WHERE term_id = '. $term_id .';';
		$rows  = $db->fetch_array($sql);
		if( getPGC('name') || getPGC('slug') ){
			$name        = getPGC('name') ? getPGC('name') : $rows['name'];
			$slug        = getPGC('slug') ? getPGC('slug') : $rows['slug'];
			$description = getPGC('description') ? getPGC('description') : $rows['description'];
			$array       = array(
				'name' => $name,
				'slug' => $slug,
				'description' => $description
			);
			$db->update('term', $array, 'term_id='.$term_id);
		}
	}


	/**
	 * 获取tag ID
	 * @param {string} tag name
	 * @return {number} tag ID
	 */
	public function getTagID($tag){
		$db  = $this->db;
		$sql = 'SELECT term_id FROM ' . table('term') .' WHERE name = "'. $tag .'";';
		$tag = $db->fetch_array($sql);
		return $tag['term_id'];
	}	

	/**
	 * tag列表
	 * @param {number} 当前分页位置索引
	 * @param {number} 列表显示条数
	 * @return {array} tag列表结果集，包含tag列表所有内容，tag总数
	 */
	public function tagList($current = 1, $tagSize = 10){
		$db       = $this->db;
		$find     = 'term_id id,
					 name,
					 slug,
					 description,
					 count';
		$limit    = 'LIMIT ' . ($current - 1) * $tagSize . ',' . $tagSize;
		$allSql   = 'SELECT '. $find .' FROM ' . table('term') .' WHERE type = 2 ';
		$pagedSql = $allSql . $limit;
		$rows     = $db->fetch_array_all($pagedSql);
		$total    = $db->num_rows($allSql);
		return array('rows' => $rows, 'total' => $total);
	}

	/**
	 * tag详细
	 * @param {number} tag ID
	 */
	public function tagDetail($term_id){
		$db   = $this->db;
		$sql  = 'SELECT term_id id, name, slug, description FROM '. table('term') .' WHERE type = 2 AND term_id = '. $term_id;
		$rows = $db->fetch_array($sql);
		return $rows;
	}

	/**
	 * 添加关联
	 * @param {number} tag ID
	 * @param {number} 文章ID
	 */
	private function addRelated($term_id, $post_id){
		if( $post_id && $term_id ){				
			$db    = $this->db;
			$sql   = 'SELECT post_id FROM '. table('relationships') .' WHERE term_id = '. $term_id .';';
			$num   = $db->num_fields($sql);
			$array = array(
				'term_id'  => $term_id,
				'post_id' => $post_id
			);
			$db->insert('relationships', $array);
			$db->update('term', array('count'=> $num), 'term_id = '. $term_id .' AND type = 2');
		}
	}

	/**
	 * 删除关联
	 * @param {number} tag ID
	 * @param {number} 文章id ID
	 */
	public function deleteRelated($term_id, $post_id){
		if( $post_id && $term_id ){
			$db  = $this->db;
			$sql = 'SELECT $post_id FROM '. table('relationships') .' WHERE term_id = '. $term_id .';';
			$num = $db->num_fields($sql);
			$db->delete('relationships', 'term_id = ' . $term_id . ' AND post_id = '. $post_id);
			$db->update('term', array('count'=> $num), 'term_id = '. $term_id .' AND type = 2');
			$db->optimize('relationships');
		}
	}

	/**
	 * 修改关联
	 * @param {string} 以半角逗号“,”分割开的字符串如：标签1,标签2,标签3,标签4
	 * @param {number} 要添加关联的文章ID
	 */
	public function editRelated($str, $post_id){
		$db     = $this->db;
		$str    = preg_replace('/,{2,}/', ',', $str);
		$str    = preg_replace('/(^,)|(,*$)|(\s+)/', '', $str);
		$strArr = $str ? explode(',', $str) : array();
		$sql    = 'SELECT t.name FROM '. table('term') .' t,'. table('relationships') .' r WHERE r.post_id ='. $post_id .' AND t.term_id = r.term_id AND t.type = 2;';
		$rows   = $db->fetch_array_all($sql);
		$dbArr  = array();
		
		foreach($rows as $key => $val){
			$dbArr[$key] = $rows[$key]['name'];
		}

		$addDiff = array_diff($strArr, $dbArr);
		$delDiff = array_diff($dbArr, $strArr);

		/*添加tag及关联关系*/
		foreach ($addDiff as $val) {
			if( !empty($val) ){

				$id = $this->getTagID($val);

				//添加没有的tag
				if( !$id ){
					$array = array(
						'name'  => $val,
						'slug'  => $val,
						'type'  => 2
					);
					$db->insert('term', $array);
					$tag_id = $db->insert_id();
				}else{
					$tag_id = $id;
				}

				//添加关联
				$this->addRelated($tag_id, $post_id);
			}
		}


		/*删除关联关系*/
		foreach($delDiff as $val){
			if( !empty($val) ){
				$tag_id = $this->getTagID($val);
				$this->deleteRelated($tag_id, $post_id);
			}
		}
	}


	/**
	 * 根据文章获取关联的tag
	 * @param {number} 文章 ID
	 * @param {boolean} 是否以字符串形式返回连接
	 * @return {string} 返回的tag列表
	 */
	public function getRelated_tag($post_id, $returnStr = true){
		$db        = $this->db;
		$find      = 't.term_id id,
					  t.name tag,
					  t.slug url';
		$condition = 'WHERE p.post_id = '. $post_id .' AND p.post_id = r.post_id AND t.term_id = r.term_id AND t.type = 2;';
		$sql       = 'SELECT '. $find .' FROM '. table('term') .' t,'. table('relationships') .' r,'. table('post') .' p '. $condition;
		$rows      = $db->fetch_array_all($sql);
		$str       = '';

		if( $returnStr ){
			foreach($rows as $val){
				$str .= '<a href="?post&tag_url='. $val['url'] .'">'. $val['tag'] .'</a>';
			}
			return $str;
		}

		return $rows;
	}

	/**
	 * 根据tag获取关联的文章列表
	 * @param {number} tag 别名
	 * @param {number} 当前页
	 * @param {number} 显示条数
	 * @return {array} 文章列表结果集，包含文章信息
	 */
	public function getRelated_post($slug = null, $current = 1, $tagSize = 10){
		$db        = $this->db;
		$find      = 'p.post_id id,
					  p.title title,
					  p.description description,
					  p.updataTime time,
					  u.displayname author,
					  t.count count';
		$getTag    = $slug ? ' AND t.slug = "'. $slug .'" ' : '';
		$limit     = 'LIMIT ' . ($current - 1) * $tagSize . ',' . $tagSize;
		$condition = 'WHERE p.post_id = r.post_id AND t.term_id = r.term_id AND p.author = u.id AND t.type = 2 ';
		$sql       = 'SELECT '. $find .' FROM '. table('term') .' t,'. table('relationships') .' r,'. table('post') .' p,'. table('user') .' u ' . $condition . $getTag . $limit;
		$rows      = $db->fetch_array_all($sql);
		return $rows;
	}

	/**
	 * @return {array} 所有tag name数据
	 */
	public function getTagData(){
		$db   = $this->db;
		$sql  = 'SELECT name FROM '. table('term') .' WHERE type = 2 ';
		$rows = $db->fetch_array_all($sql);
		return $rows;
	}
}
?>