<?php
/**
 * category 类
 */

class categoryAction extends commonAction{

	/**
	 * 分类列表
	 */
	public function index(){
		$category   = $this->common->category;
		$pagination = $this->common->pagination;

		$page     = getPGC('page') ? getPGC('page') : 1;
		$catList  = $category->catList();
		$catRows  = $catList['rows'];
		$catTotal = $catList['total'];
		$catTree  = formatTree($catRows);

		/*递归重写树形*/
		function showTree($tree, $interval = ''){
			global $i, $arr;
			foreach($tree as $key => $val) {
				$arr[] = array(
					'id'          => $val['id'],
					'name'        => $interval.$val['name'],
					'slug'        => $val['slug'],
					'description' => $val['description'],
					'count'       => $val['count'],
					//'pid'         => $val['pid'],
					'url'         => U('admin.category/detail/id/'. $val['id']),
					'slug_url'    => U('admin.category/detail/id/'. $val['id'])
				);
				if( isset($val['son']) ){
					showTree($val['son'], $interval.'--');
				}
			}
			return $arr;
		}

		//考虑删除父id时
		if( getPGC('delete') ){
			$deleteArr = getPGC('catID');

			$category->deleteCat($deleteArr);

			/*删除关联*/			
			echo '<script>location.replace(location.href);</script>';
		}

		$this->assign('catRows', showTree($catTree) );
		$this->display('category_list', $page);
	}


	/**
	 * 分类详细
	 */
	public function detail(){
		$category = $this->common->category;
		$id       = getPGC('id');
		$arr      = array(
						'id'          => $id,
						'name'        => getPGC('name'),
						'slug'        => getPGC('url'),
						'parent'      => getPGC('parent'),
						'description' => getPGC('description')
					);

		/*读取数据*/
		$catList      = $category->catList();
		$catRows      = $catList['rows'];
		$catTree      = formatTree($catRows);
		$catDetail    = $category->catDetail($id);
		$catPid       = $catDetail['pid'];
		$showCategory = $this->showtree($catTree, $id, $catPid);

		if( getPGC('rightSubmit') ){
			if( isset($arr['name']) && isset($arr['slug']) ){
				$id = $category->modifyCat($arr);
				echo '<script>location.replace(location.href);</script>';
			}
		}

		$this->assign('showCategory', $showCategory);
		$this->assign('catDetail', $catDetail);
		$this->display('category_detail', $id);
	}


	/**
	 * 添加分类
	 */
	public function add(){
		$category = $this->common->category;
		$arr      = array(
						'name'        => getPGC('name'),
						'slug'        => getPGC('url'),
						'parent'      => getPGC('parent'),
						'description' => getPGC('description')
					);

		/*获取数据*/
		$catList      = $category->catList();
		$catRows      = $catList['rows'];
		$catTotal     = $catList['total'];
		$catTree      = formatTree($catRows);
		$showCategory = $this->showtree($catTree);

		if( getPGC('rightSubmit') ){
			if( isset($arr['name']) && isset($arr['slug']) ){
				$id = $category->addCat($arr);
				if( $id ){
					echo '<script>location.href = "'. U(APP_NAME.'.category/detail/id/'.$id) .'"</script>';
				}else{
					echo '添加出错';
				}
			}
		}
		
		$this->assign('showCategory', $showCategory);
		$this->display('category_detail', 'add');
	}

	/**
	 * 显示树形数据，并标记已选项
	 * @param {array} 树形数据
	 * @param {number} 已选项
	 */
	private function showtree($tree, $id = '', $pid = ''){
		function showtree($tree, $id = '', $pid = '', $interval = '', $str = ''){
			foreach( $tree as $key => $value ){
				$selected = ( $value['id'] == $pid ) ? ' selected' : '';
				if( $value['id'] != $id  ){
					$str .= '<option value="'. $value['id'] .'"'. $selected .'>'. $interval . $value['name'] .'</option>'."\n";
					if( isset($value['son']) ){
						$str .= showtree($value['son'], $id, $pid, $interval.'&nbsp;&nbsp;');
					}
				}
			}
			return $str;
		}
		return showtree($tree, $id, $pid);
	}
}
?>