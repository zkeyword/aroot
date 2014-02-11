<?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		<form method="post">
			<div id="rightHeader">
				<div id="rightHeaderLine" class="f0"></div>
				<h2>分类列表</h2>
			</div>
			<table>
				<thead>
					<th><input type="checkbox" name="catIDAll" value="all" /></th>
					<th>名字</th>
					<th>描述</th>
					<th>别名</th>
					<th>文章</th>
				</thead>
				<tbody>
					<?php
						foreach( $catRows as $arr ){
							echo '<tr>',
									 $arr['id'] == 1 ? '<td></td>' : '<td><input type="checkbox" name="catID[]" value="'.$arr['id'].'" /></td>',
									 '<td><a href="'. $arr['url'] .'">'.$arr['name'].'</a></td>',
									 '<td>'.$arr['description'].'</td>',
									 '<td>'.$arr['slug'].'</td>',
									 '<td><a href="'. $arr['slug_url'] .'">'.$arr['count'].'</a></td>',
							     '</tr>';
						}
					?>
				</tbody>
			</table>
			<div>
				<input type="submit" value="删除" name="delete">
			</div>
			<div>
				注意：
				删除分类目录不会把该分类目录下的文章一并删除。文章会被归入“未分类”分类目录。
			</div>
		</form>
	</div>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>
