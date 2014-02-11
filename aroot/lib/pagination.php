<?php

class pagination{

	public $setLink = '{str}';

	/*
	 * 获取分页
	 * @param {number} 当前位置
	 * @param {number} 文章总数
	 * @param {number} 每页数量
	 * @param {string}
	 */
	public function show($current, $total, $pageSize=10){
		$str1 = $this->getBtnStr($current, $total, $pageSize);
		$str2 = $this->getCount($current, $total, $pageSize);
		return $str1 . $str2;
	}

	/*
	 * 替换url
	 * @param {string} 当前位置
	 * @param {string} url，必须带{str}
	 */
	private function replaceLink($index){
		$url = $this->setLink;
		$str = preg_replace("/\{str\}/is", $index, $url);
		return $str;
	}


	/*
	 * 获取分页字符串
	 * @param {number} 当前位置
	 * @param {number} 文章总数
	 * @param {number} 每页数量
	 * @param {string}
	 */
	private function getBtnStr($current, $total, $pageSize){
		$str     = '';
		$begin   = 1;
		$end     = 1;
		$i       = 0;
		$itemNum = 2;
		$pageNum = ceil($total / $pageSize);

		if($current > 1){
			$str .= $this->getLink($current - 1, $itemNum, '上一页');
		}else{
			$str .= '<span>上一页</span>';
		}
		if($current - $itemNum > 1){
			$str .= $this->getLink(1, $current) . '<em>...</em>';
			$begin = $current - $itemNum;
		}
		$end = min($pageNum, $begin + $itemNum * 2);
		if($end == $pageNum - 1){
			$end = $pageNum;
		}
		for($i = $begin; $i <= $end; $i++) {
			$str .= $this->getLink($i, $current);
		}
		if($end < $pageNum){
			$str .= '<em>...</em>' . $this->getLink($pageNum, $current);
		}
		if($current < $pageNum){
			$str .= $this->getLink($current + 1, $current, '下一页');
		}else{
			$str .= '<span>下一页</span> ';
		}
		
		return $str;
	}

	/*
	 * 获取连接字符串
	 * @param {number} 当前位置
	 * @param {number} 每页数量
	 * @param {number} 连接文本
	 * @param {string}
	 */
	private function getLink($current, $pageSize, $txt=''){
		$str = ($current == $pageSize) ? ' class="on"' : '';
		$txt = $txt ? $txt : $current;
		$url = $this->replaceLink($current);
		return '<a href="'. $url .'"'. $str . '>'. $txt .'</a>';
	}

	/*
	 * 获取统计字符串
	 * @param {number} 当前位置
	 * @param {number} 文章总数
	 * @param {number} 每页数量
	 * @param {string}
	 */
	private function getCount($current, $total, $pageSize){
		$s = '';		
		$s .= '显示从'. ( ($current-1)*$pageSize + 1 ) .'到'. $current*$pageSize;
		$s .= '，总 '. $total .' 条 。每页显示：'. $pageSize;
		return $s;
	}	
}

?>