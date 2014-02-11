<?php

/**
 * 媒体类
 */
class mediaAction extends commonAction{
	public function index(){
		$media      = $this->common->media;
		$pagination = $this->common->pagination;
		$page       = getPGC('page') ? getPGC('page') : 1;
		$deleteArr  = getPGC('mediaID');
		$mediaNum   = 10;

		/*获取数据*/
		$mediaList  = $media->mediaList($page, $mediaNum);
		$mediaRows  = $mediaList['rows'];
		$mediaTotal = $mediaList['total'];

		/*重写数据库获取的值*/
		foreach($mediaRows as $key => $val){
			foreach ($val as $key2 => $val2) {
				if( $key2 == 'time' ){
					$val2 = formatTime($val2, 3);
				}elseif( $key2 == 'id' ){
					$mediaRows[$key]['url'] = U(APP_NAME.'.media/detail/id/'. $val2);
				}
				$mediaRows[$key][$key2] = $val2;
			}
		}

		/*分页*/
		$pagination->setLink = U(APP_NAME.'.media/page/{str}');
		$paged = $pagination->show($page, $mediaTotal, $mediaNum);

		$this->assign('mediaRows', $mediaRows);
		$this->assign('paged', $paged);
		$this->display('media_list', $page.'_'.$mediaNum);
	}

	public function detail(){
		$this->display('media_detail', $id);
	}

	public function add(){
		$this->display('media_detail', 'add');
	}

}
?>