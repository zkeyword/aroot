<?php
/**
 * 文章类
 * @uses db();
 * @version 1.1
 */
if(!defined("INC")) exit("Request Error!");

class options{
	private $db = null;
	
	public function __construct(){
		$this->db = new db();
	}
	
	public function siteInfo(){
		$db   = $this->db;
		$sql  = 'SELECT * FROM '. table('options');
		$rows = $db->fetch_array_all($sql);
		return $rows;
	}

	public function modifySiteInfo(){
		$db          = $this->db;
		$title       = getPGC('title');
		$description = getPGC('description');
		$keywords    = getPGC('keywords');

		$array = array(
			'options_value' => $title
		);
		$db->update('options', $array, 'options_key = \'title\'');

		$array = array(
			'options_value' => $description
		);
		$db->update('options', $array, 'options_key = \'description\'');

		$array = array(
			'options_value' => $keywords
		);
		$db->update('options', $array, 'options_key = \'keywords\'');
	}
}

?>