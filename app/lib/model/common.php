<?php

class common{
	public $post       = null;
	public $tag        = null;
	public $category   = null;
	public $pagination = null;
	public $comment    = null;
	public $options    = null;
	
	public function __construct(){
		$this->lodingClass();
		$this->pagination = new pagination();
		$this->post       = new post();
		$this->category   = new category();
		$this->tag        = new tag();
		$this->single     = new single();
		$this->media      = new media();
		$this->comment    = new comment();
		$this->options    = new options();
	}

	public function lodingClass(){

		/*载入分页类*/
		require(LIB_PATH . 'pagination.php');	

		/*载入post类*/
		require(C('APP_MODEL_PATH') . 'post.php');

		/*载入category类*/
		require(C('APP_MODEL_PATH') . 'category.php');

		/*载入tag类*/
		require(C('APP_MODEL_PATH') . 'tag.php');

		/*载入single类*/
		require(C('APP_MODEL_PATH') . 'single.php');

		/*载入media类*/
		require(C('APP_MODEL_PATH') . 'media.php');

		/*载入评论类*/
		require(C('APP_MODEL_PATH') . 'comment.php');

		/*载入系统设置类*/
		require(C('APP_MODEL_PATH') . 'options.php');
	}

	/*获取分类*/
	public function getNav(){
		$cat     = $this->category;
		$catList = $cat->catList();
		$tree    = formatTree( $catList['rows'] );


		function showtree($tree, $catID){
			$str = '';
			foreach( $tree as $key => $value ){
				$class = ( $value['id'] == $catID ) ? ' class="on"' : '';
				$str .= '<li'. $class .'><a href="'. U('category/url/'.$value['slug']) .'">'. $value['name'] .'</a></li>'."\n";
				if( isset($value['son']) ){
					$str .= '<ul class="subNav">'."\n";
					$str .= showtree($value['son'], $catID);
					$str .= '</ul>'."\n";
				}
			}
			return $str;
		}

		return showtree($tree, 0);
	}

	/*获取文章列表*/
	public function getPost($catID = null){
		$post = $this->post;
		$tag  = $this->tag;
		$cat  = $this->category;
		$arr  = array();

		$postList   = $post->postList(1, 10);
		$postRows   = $postList['rows'];

		foreach( $postRows as $key => $val ){
			$arr[$key] = array(
				'url'     => U('post/id/'. $val['id']),
				'title'   => $val['title'],
				'author'  => $val['author'],
				'content' => $val['content'],
				'cat'     => $cat->getRelated_cat( $val['id'] ),
				'tag'     => $tag->getRelated_tag( $val['id'] ),
				'time'    => formatTime($val['time'], 3),
			);
		}

		return $arr;
	}

	/*获取文章详细*/
	public function getPostDetail($id){
		$post = $this->post;
		$tag  = $this->tag;
		$cat  = $this->cat;

		$postDetail = $post->postDetail($id);
		$postDetail['tag'] = $tag->getRelated_tag($id);
		
		return $postDetail;
	}

	/*提交评论*/
	public function submitComment($id){
		$comment = $this->comment;
		$comment->addComment($id);
	}

	public function getCommentList($id){
		$comment = $this->comment;
		$commonList = $comment->commentList($id);
		$arr = array();
		foreach ($commonList as $key => $val) {
			//if( $val['status'] ){
				$arr[$key] = array(
					'id'     => $val['id'],
					'author' => $val['author'],
					'email'  => $val['email'],
					'url'    => $val['url'],
					'time'   => formatTime($val['updataTime'], 3),
					'avatar' => getGravatar( $val['email'] ),
					'text'   => $val['text'],
					'pid'    => $val['parent'],
					'uid'    => $val['uid'],
					'ip'     => $val['ip']
				);
			//}
		}
		return formatTree($arr);
	}
}

?>