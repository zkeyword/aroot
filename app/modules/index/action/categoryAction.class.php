<?php
/**
 * 搜索类
 */
class categoryAction extends commonAction{

	public function index(){
		$slug   = getPGC('url');
		$page   = getPGC('page') ? getPGC('page') : 1;

		if( !$slug ){
			die('页面不存在');
		}


		$showCatList = $this->common->getNav();
		$post        = $this->common->getPost();

		$this->assign('post', $post);
		$this->assign('showCatList', $showCatList);
		$this->display('category', $page);
	}
}
?>