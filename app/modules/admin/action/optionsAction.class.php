<?php
class optionsAction extends commonAction{
	
	public function index(){
		$options = $this->common->options;
		$siteInfo = $options->siteInfo();

		foreach($siteInfo as $arr){
			foreach ($arr as $key => $val) {
				if( $arr['options_key'] == 'siteurl' ){
					$siteUrl = $val;
				}elseif($arr['options_key'] == 'title'){
					$title = $val;
				}elseif($arr['options_key'] == 'description'){
					$description = $val;
				}elseif($arr['options_key'] == 'keywords'){
					$keywords = $val;
				}
			}
		}

		if( getPGC('rightSubmit') ){
			$options->modifySiteInfo();
			echo '<script>location.replace(location.href);</script>';
		}


		$this->assign('siteUrl', $siteUrl);
		$this->assign('title', $title);
		$this->assign('description', $description);
		$this->assign('keywords', $keywords);
		$this->display('options_index');
	}

	public function post(){
		$this->display('options_post');
	}

	public function comment(){
		$this->display('options_comment');
	}

	public function media(){
		$this->display('options_media');
	}

	public function link(){
		$this->display('options_link');
	}
}
?>