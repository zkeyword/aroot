<?php

/**
 * 标签类
 */
class tagAction extends commonAction{

	/**
	 * 标签列表
	 */
	public function index(){
		$tag        = $this->common->tag;
		$pagination = $this->common->pagination;

		$id   = getPGC('id') ? getPGC('id') : 1; 
		$page = getPGC('page') ? getPGC('page') : 1; 
		
		/*获取数据*/
		$tagList    = $tag->tagList();
		$tagRows    = $tagList['rows'];
		$tagTotal   = $tagList['total'];

		/*重写数据库获取的值*/
		foreach($tagRows as $key => $val){
			foreach ($val as $key2 => $val2) {
				if( $key2 == 'id' ){
					$tagRows[$key]['url'] = U(APP_NAME.'.tag/detail/id/'. $val2);
				}elseif( $key2 == 'slug' ){
					$tagRows[$key]['post_tag_url'] = U(APP_NAME.'.post/tag/slug/'. $val2);

				}
				$tagRows[$key][$key2] = $val2;
			}
		}

		/*分页*/
		$paged      = $pagination->show($page, $tagTotal);

		/*删除*/
		$selected = getPGC('tagID');
		if( getPGC('delete') && $selected ){
			foreach($selected as $id){
				$tag->deleteTag($id);
			}
			echo '<script>location.replace(location.href);</script>';
		}

		$this->assign('tagRows', $tagRows);
		$this->assign('tagTotal', $tagTotal);
		$this->assign('paged', $paged);
		$this->display('tag_list', $id);
	}

	/**
	 * 标签详细
	 */
	public function detail(){
		$tag  = $this->common->tag;
		$id   = getPGC('id') ? getPGC('id') : 1; 

		/*获取数据*/
		$tagDetail   = $tag->tagDetail($id);
		$name        = $tagDetail['name'];
		$slug        = $tagDetail['slug'];
		$description = $tagDetail['description'];

		/*编辑*/
		if( getPGC('rightSubmit') ){
			$tag->editTag($id);
			echo '<script>location.replace(location.href);</script>';
		}

		$this->assign('name', $name);
		$this->assign('slug', $slug);
		$this->assign('description', $description);
		$this->display('tag_detail', $id);
	}

	/**
	 * 添加标签
	 */
	public function add(){
		if( getPGC('rightSubmit') ){
			$tag = $this->common->tag;
			$id  = $tag->addTag();
			echo '<script>location.href = "'. U(APP_NAME.'.tag/detail/id/'.$id) .'"</script>';
		}
		$this->display('tag_detail', 'add');
	}
}