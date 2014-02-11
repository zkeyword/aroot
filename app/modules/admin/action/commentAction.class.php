<?php

/**
 * 单页类
 */
class commentAction extends commonAction{
	public function index(){
		$comment = $this->common->comment;
		$commentRows = array();
		$paged = '';
		$this->assign('commentRows', $commentRows);
		$this->assign('paged', $paged);
		$this->display('comment_list');
	}
}
?>