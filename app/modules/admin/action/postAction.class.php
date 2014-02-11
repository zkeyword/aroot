<?php
class postAction extends commonAction{   
	
	/**
	 * post列表
	 */
	public function index(){
		$post       = $this->common->post;
		$tag        = $this->common->tag;
		$category   = $this->common->category;
		$pagination = $this->common->pagination;
		$page       = getPGC('page') ? getPGC('page') : 1;
		$deleteArr  = getPGC('postID');
		$postNum    = 100;

		/*获取数据*/
		$postList  = $post->postList($page, $postNum);
		$postRows  = $postList['rows'];
		$postTotal = $postList['total'];

		/*重写数据库获取的值*/
		foreach($postRows as $key => $val){
			foreach ($val as $key2 => $val2) {
				if( $key2 == 'time' ){
					$val2 = formatTime($val2, 3);
				}elseif( $key2 == 'id' ){
					$postRows[$key]['url']      = U(APP_NAME.'.post/detail/id/'. $val2);
					$postRows[$key]['tag']      = $tag->getRelated_tag( $val2 );
					$postRows[$key]['category'] = $category->getRelated_cat( $val2 );
				}
				$postRows[$key][$key2] = $val2;
			}
		}

		/*分页*/
		$pagination->setLink = U(APP_NAME.'.post/page/{str}');
		$paged = $pagination->show($page, $postTotal, $postNum);

		if( getPGC('delete') ){
			$post->deletePost($deleteArr);

			/*删除关联*/
			foreach($deleteArr as $post_id){
				$catArr = $category->getRelated_cat($post_id, false);
				foreach($catArr as $cat_id){
					$category->deleteRelated($cat_id, $post_id);
				}
				$tagArr = $tag->getRelated_tag($post_id, false);
				foreach($tagArr as $tag_id){
					$tag->deleteRelated($tag_id, $post_id);
				}
			}
			
			echo '<script>location.replace(location.href);</script>';
		}

		$this->assign('postRows', $postRows);
		$this->assign('paged', $paged);
		$this->display('post_list', $page.'_'.$postNum);   //考虑条数不一样的情况
	}

	/**
	 * post详细
	 */
	public function detail(){
		$post     = $this->common->post;
		$category = $this->common->category;
		$tag      = $this->common->tag;
		$id       = getPGC('id');

		/*从数据库获取数据*/
		$catList    = $category->catList();                        //获取分类列表
		$catTree    = formatTree($catList['rows']);                //格式分类列表
		$catRelated = $category->getRelated_cat($id, false);       //获取关联的分类列表


		$postDetail = $post->postDetail($id);
		$tagArr     = $tag->getRelated_tag($id, false);
		$str        = '';
		foreach($tagArr as $key => $val){
			$str .= ($key==0 ? $val['tag'] : ','. $val['tag']);
		}
		$postDetail['tag'] = $str;

		/*要修改的数组*/
		$addArr = array(
					'id'          => $id,
					'title'       => getPGC('title'),
					'description' => getPGC('description'),
					'content'     => getPGC('content')
				  );

		/*上传文件*/
		if( getPGC('upload') ){
			require(SOURCE_PATH . 'class/upFile.php');
			$fileArr = array('filepath' => UPLOAD_PATH,'israndname'=> false);
			$file    = new FileUpload($fileArr);
			$file->uploadfile('post_thumb');
			$fileNewName = $file->getNewFileName();
			//echo $post->addPost(3);
		}


		/*修改post*/
		if( getPGC('submit') ){
			$post->modifyPost($addArr);

			/*修改关联category*/
			$category->modifyRelated(getPGC('category'), $id);

			/*修改关联tag*/
			$tag->editRelated(getPGC('tag'), $id);

			//echo '<script>location.replace(location.href);</script>';
		}



		/*显示分类*/
		$showCategory = $this->showTree($catTree, $catRelated);

		$this->assign('showCategory', $showCategory);
		$this->assign('postDetail', $postDetail);
		$this->display('post_detail');
	}

	/**
	 * 新建post
	 */
	public function add(){
		$post     = $this->common->post;
		$category = $this->common->category;
		$tag      = $this->common->tag;

		/*获取数据*/
		$catList  = $category->catList();                        //获取分类列表
		$catTree  = formatTree($catList['rows']);                //格式分类列表

		/*要添加的数组*/
		$addArr   = array(
						'author'      => $this->userID,
						'title'       => getPGC('title'),
						'description' => getPGC('description'),
						'content'     => getPGC('content'),
					);

		if( getPGC('submit') ){
			$id = $post->addPost( $addArr );
			if( $id ){
				/*关联category*/
				$category->addRelated(getPGC('category'), $id);;

				/*关联并添加tag*/
				$tag->addTag(getPGC('tag'), $id);

				/*跳转到新添加的页面*/
				echo '<script>location.href = "'. U(APP_NAME.'.post/detail/id/'.$id) .'"</script>';
			}else{
				$error = '文章标题已存在';
			}
		}

		/*显示分类*/
		$showCategory = $this->showTree($catTree);
		$this->assign('error', isset($error) ? $error : '');
		$this->assign('showCategory', $showCategory);
		$this->display('post_detail', 'add');
	}





	/*分类树方式显示*/
	private function showTree($tree, $catRelated = '', $interval = ''){
		function showTree($tree, $catRelated = '', $interval = '', $str = ''){
			foreach( $tree as $val ){
				if( $catRelated ){
					$checked = '';
					foreach($catRelated as $cat){
						$val['id'] == $cat['id'] && $checked = ' checked' ;
					}
					$str .= '<div>'. $interval .'<input type="checkbox" name="category[]" value="'. $val['id'] .'"'. $checked .'>'. $val['name'] .'</div>'."\n";
				}else{
					$str .= '<div>'. $interval .'<input type="checkbox" name="category[]" value="'. $val['id'] .'">'. $val['name'] .'</div>'."\n";
				}
				if( isset($val['son']) ){
					$str .= showtree($val['son'], $catRelated, '&nbsp;&nbsp;'.$interval);
				}
			}
			return $str;
		}
		return showtree($tree, $catRelated, $interval);
	}

	/**
	 * 搜索post
	 */
	private function search(){

	}
}
?>