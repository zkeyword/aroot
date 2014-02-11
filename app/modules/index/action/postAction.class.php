<?php
if(!defined("INC")) exit("Request Error!");

class postAction extends commonAction{

	public function index(){

		$id = getPGC('id');

		if( !$id ){
			die('页面不存在');
		}

		/*获取上下篇*/
		/*function getPostBother($pointer, $post, $id){
			$str = $post->getPostBother($id, $pointer);
			if( $str ){
				$str = '<a href="'. U(APP_NAME.'.post/detail/id/'.$str['post_id']) .'">'. $str['title'] .'</a>';
			}else{
				$str = '<span>没有了</span>';
			}
			return $str;
		}*/




		$isRecompile = false;
		if( getPGC('submit') ){
			$this->common->submitComment($id);
			$isRecompile = true;
		}

		$commonList  = $this->common->getCommentList($id);
		$showCatList = $this->common->getNav();
		$postDetail  = $this->common->getPostDetail($id);

		$this->assign('commonList', $commonList);
		$this->assign('postDetail', $postDetail);
		$this->assign('showCatList', $showCatList);
		//$this->assign('postBother_prev', getPostBother('prev', $post, $params['id']) );
		//$this->assign('postBother_next', getPostBother('next', $post, $params['id']) );
		$this->isRecompile = $isRecompile;
		$this->display('post', $id);
	}
}

?>