<?php
/**
 * 文章分类类
 * @uses db();
 * @version 1.1
 */

class category{
	
	private $db = null;
	
	public function __construct(){
		$this->db = new db();
	}
	
	/**
	 * 添加cat
	 * @param {array}
	 */
	public function addCat($arr){
		$db          = $this->db;
		$name        = $arr['name'];
		$slug        = $arr['slug'];
		$name_num    = $this->checkCat_name($name);
		$slug_num    = $this->checkCat_slug($slug);
		$parent      = $arr['parent'];
		$description = $arr['description'];
		$array       = array(
			'name'        => $name_num ? $name.'-'.( $name_num + 1 ) : $name,
			'slug'        => $slug_num ? $slug.'-'.( $slug_num + 1 ) : $slug,
			'parent_id'   => $parent,
			'description' => $description,
			'type'        => 1,
			'count'       => 0
		);
		$db->insert('term', $array);
		return $db->insert_id();
	}

	/**
	 * 删除cat
	 * @param {array} cat ID 数组
	 */
	public function deleteCat($array = ''){
		if( !$array ) exit();

		$db = $this->db;

		foreach($array as $val){
			$parent   = $this->getCatParent($val);
			$children = $this->getCatChildren($val);
			/*将该分类有子分类的父亲指定给其父亲*/
			if( $children ){
				foreach($children as $v){
					$db->update('term',  array('parent_id'=> $parent['pid']), 'term_id = '. $v['id']);
				}
			}
			$db->delete('term', 'term_id = '.$val);
			$db->update('relationships',  array('term_id'=> 1), 'term_id = '. $val); //关联文章的关系指定给默认分类
		}
		$db->optimize('term');
	}
	

	/**
	 * 修改cat 内容
	 * @param {array}
	 */
	public function modifyCat($arr){
		$db          = $this->db;
		$id          = $arr['id'];
		$name        = $arr['name'];
		$slug        = $arr['slug'];
		$parent      = $arr['parent'];
		$description = $arr['description'];
		$array  = array(
			'name'        => $name,
			'slug'        => $slug,
			'parent_id'   => $parent,
			'description' => $description
		);
		$db->update('term', $array, 'term_id='.$id);
	}

	/**
	 * 获取cat 列表
	 * @param {string} cat name
	 * @return {number} cat ID
	 */
	public function catList($page = 1){
		$db = $this->db;
		$sql   = 'SELECT term_id id, name, slug, description, parent_id pid, count FROM '. table('term') .' WHERE type = 1 ORDER BY id;';
		$rows  = $db->fetch_array_all($sql);
		$total = $db->num_rows($sql);
		return array('rows' => $rows, 'total' => $total);
	}

	/**
	 * 获取cat 详细
	 * @param {string} cat name
	 * @return {number} cat ID
	 */
	public function catDetail($cat_id){
		$db   = $this->db;
		$sql  = 'SELECT term_id id, name, slug url, description, parent_id pid FROM '. table('term') .' WHERE type = 1 AND term_id = '. $cat_id;
		$rows = $db->fetch_array($sql);
		return $rows;
	}

	/**
	 * 获取cat name是否存在
	 * @param {string} cat name
	 * @param {number} name 数量
	 */
	public function checkCat_name($cat_name){
		$db  = $this->db;
		$sql = 'SELECT term_id FROM '. table('term') .' WHERE type = 1 AND name = '. trim($cat_name);
		return $db->num_rows($sql);
	}

	/**
	 * 获取cat slug是否存在
	 * @param {string} cat name
	 * @param {number} slug 数量
	 */
	public function checkCat_slug($cat_slug){
		$db  = $this->db;
		$sql = 'SELECT term_id id FROM '. table('term') .' WHERE type = 1 AND slug = '. trim($cat_slug);
		return $db->num_rows($sql);
	}

	/**
	 * 根据name获取cat ID
	 * @param {string} cat name
	 * @return {number} cat ID
	 */
	public function getCatID_name($name){
		$db  = $thit->db;
		$sql = 'SELECT term_id id FROM '. table('term') .' WHERE type = 1 AND name = '. $name .';';
		$cat = $db->fetch_array($sql);
		return $cat['id'];
	}

	/**
	 * 根据slug获取cat ID
	 * @param {string} cat name
	 * @return {number} cat ID
	 */
	public function getCatID_slug($slug){
		$db  = $thit->db;
		$sql = 'SELECT term_id id FROM '. table('term') .' WHERE type = 1 AND slug = '. $slug .';';
		$cat = $db->fetch_array($sql);
		return $cat['id'];
	}

	/**
	 * 获取 cat 父亲
	 * @param {string} cat id
	 * @return {array|boolean}
	 */
	public function getCatParent($cat_id){
		$db = $this->db;
		if( $cat_id ){
			$sql  = 'SELECT name, slug url, parent_id pid FROM '. table('term') .' WHERE type = 1 AND term_id = '. $cat_id;
			$rows = $db->fetch_array($sql);
			return $rows;
		}
		return false;	
	}

	/**
	 * 获取 cat 儿子
	 * @param {string} cat id
	 * @return {array|boolean}
	 */
	public function getCatChildren($cat_id){
		$db = $this->db;
		if( $cat_id ){
			$sql  = 'SELECT term_id id FROM '. table('term') .' WHERE type = 1 AND parent_id = '. $cat_id;
			$rows = $db->fetch_array_all($sql);
			return $rows;
		}
		return false;	
	}

	/**
	 * 添加关联
	 * @param {array} cat ID 数组
	 * @param {number} 文章ID
	 */
	public function addRelated($cat_array, $post_id){
		if( $post_id && $cat_array ){				
			$db = $this->db;
			$array = array();
			foreach($cat_array as $key => $cat_id){
				$array = array(
					'term_id'  => $cat_id,
					'post_id' => $post_id
				);
				$db->insert('relationships', $array);
			}
		}
	}

	/**
	 * 删除关联
	 * @param {number} cat ID
	 * @param {number} 文章ID
	 */
	public function deleteRelated($cat_id, $post_id){
		if( $cat_id && $post_id ){
			$db  = $this->db;
			$sql = 'SELECT $post_id FROM '. table('relationships') .' WHERE term_id = '. $cat_id .';';
			$num = $db->num_fields($sql);
			$db->delete('relationships', 'term_id = ' . $cat_id . ' AND post_id = '. $post_id);
			$db->update('term', array('count'=> $num), 'term_id = '. $cat_id .' AND type = 1');
			$db->optimize('relationships');
		}
	}

	/**
	 * 修改关联
	 * @param {number} cat ID
	 * @param {number} 文章ID
	 */
	public function modifyRelated($cat_array, $post_id){
		$db    = $this->db;
		$sql   = 'SELECT term_id FROM '. table('relationships') .' WHERE post_id = '.$post_id;
		$rows  = $db->fetch_array_all($sql);
		$dbarr = array();

		foreach ($rows as $key => $value) {
			$dbarr[$key] = $value['term_id'];
		}

		$addDiff = array_diff($cat_array, $dbarr);
		$delDiff = array_diff($dbarr, $cat_array);

		/*添加关联*/
		$this->addRelated($addDiff, $post_id);

		/*删除关联*/
		foreach($delDiff as $value){
			$this->deleteRelated($value, $post_id);
		}
	}
	
	/**
	 * 根据文章获取关联的cat
	 * @param {number} 文章 ID
	 * @param {boolean} 是否以字符串形式返回连接
	 * @return {string} 返回的cat列表
	 */
	public function getRelated_cat($post_id, $returnStr = true){
		$db        = $this->db;
		$find      = 't.term_id id,
					  t.name cat,
					  t.slug url';
		$condition = 'WHERE p.post_id = '. $post_id .' AND p.post_id = r.post_id AND t.term_id = r.term_id AND t.type = 1;';
		$sql       = 'SELECT '. $find .' FROM '. table('term') .' t,'. table('relationships') .' r,'. table('post') .' p '. $condition;
		$rows      = $db->fetch_array_all($sql);
		$str       = '';

		if( $returnStr ){
			foreach($rows as $val){
				$str .= '<a href="?post&cat_url='. $val['url'] .'">'. $val['cat'] .'</a>';
			}
			return $str;
		}

		return $rows;
	}

}

?>