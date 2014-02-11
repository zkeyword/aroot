<?php
class commonAction extends action{
	
	public $common = null;
	public function _initialize(){
		require C('APP_GROUP_ROOT') . 'lib/model/common.php';
		$this->common = new common();

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
		
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
	}
}
?>