<?php

class indexAction extends commonAction{
	public function index(){
		$showCatList = $this->common->getNav();
		$post = $this->common->getPost();

		$this->assign('post', $post);
		$this->assign('showCatList', $showCatList);
		$this->display('index');
	}
}

?>