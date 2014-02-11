<?php

/**
 * 单页类
 */
class singleAction extends commonAction{

	/**
	 * 单页列表
	 */
	public function index(){
		$single = $this->common->single;
		$page = getPGC('page') ? getPGC('page') : 1;

		/*从post表取出single数据*/
		$singleList  = $single->singleList();
		$singleRows  = $singleList['rows'];
		$singleTotal = $singleList['total'];

		/*重写数据库获取的值*/
		foreach($singleRows as $key => $val){
			foreach ($val as $key2 => $val2) {
				if( $key2 == 'time' ){
					$val2 = formatTime($val2, 3);
				}elseif( $key2 == 'id' ){
					$singleRows[$key]['url']      = U(APP_NAME.'.single/detail/id/'. $val2);
				}
				$singleRows[$key][$key2] = $val2;
			}
		}

		if( getPGC('delete') ){
			$deleteArr = getPGC('singleID');
			$post->deleteSingle($deleteArr);
		}

		/*分页*/
		$this->common->pagination->setLink = U(APP_NAME.'.single/page/{str}');
		$paged = $this->common->pagination->show($page, $singleTotal);

		$this->assign('paged', $paged);
		$this->assign('singleRows', $singleRows);
		$this->display('single_list', $page);
	}

	public function detail(){
		$single = $this->common->single;
		$id = getPGC('id') ? getPGC('id') : 1;

		/*从post表取出single数据*/
		$singleDetail = $single->singleDetail($id);
		$title        = $singleDetail['title'];
		$description  = $singleDetail['description'];
		$content      = $singleDetail['content'];

		if( getPGC('submit') ){
			$title       = getPGC('title');
			$description = getPGC('description');
			$content     = getPGC('content');
			$single->modifySingle($id, $title, $description, $content);
			echo '<script>location.replace(location.href);</script>';
		}

		$this->assign('title', $title);
		$this->assign('description', $description);
		$this->assign('content', $content);
		$this->display('single_detail', $id);
	}

	public function add(){
		$single = $this->common->single;
		if( getPGC('submit') ){

			$author      = $this->userID;
			$title       = getPGC('title');
			$description = getPGC('description');
			$content     = getPGC('content');

			$id = $single->addSingle($author, $title, $description, $content);
			if( $id ){
				echo '<script>location.href = "'. U(APP_NAME.'.single/detail/id/'.$id) .'"</script>';
			}else{
				echo '添加出错';
			}
		}
		$this->display('single_detail', 'add');
	}

}
?>