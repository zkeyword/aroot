<?php
class indexAction extends commonAction{
	public function index(){
		$post = $this->common->post;
		$postList  = $post->postList();

		$category = $this->common->category;
		$catList  = $category->catList();

		$tag = $this->common->tag;
		$tagList  = $tag->tagList();


		$postNum = $postList['total'];
		$categoryNum = $catList['total'];
		$tagNum = $tagList['total'];
		$pageNum = 1;
		$commentNum = 1;
		$this->assign('postNum',$postNum);
		$this->assign('categoryNum',$categoryNum);
		$this->assign('tagNum',$tagNum);
		$this->assign('pageNum',$pageNum);
		$this->assign('commentNum',$commentNum);
		$this->display('index');
	}
}
?>