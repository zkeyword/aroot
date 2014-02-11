<?php
/**
 * 搜索类
 */
class searchAction extends commonAction{

	public function index(){
		$params  = $this->params;
		$keyword = isset($params['search']) ? $params['search'] : '';

		if( $keyword ){
			$keywordArr = explode('+', $keyword );
			print_r($keywordArr);
		}else{

		}

		$showCatList = $this->common->getNav();

		$this->assign('showCatList', $showCatList);

		//$this->isIncludeHtml = false;
		$this->display('search','',false);
	}
}
?>