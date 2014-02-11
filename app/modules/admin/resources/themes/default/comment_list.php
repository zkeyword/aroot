<?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		<form method="post">
			<div id="rightHeader">
				<div id="rightHeaderLine" class="f0"></div>
				<h2>评论列表</h2>
			</div>
			<table>
				<thead>
					<th><input type="checkbox" name="postAll" value="all" /></th>
					<th>名字</th>
					<th>描述</th>
					<th>别名</th>
					<th>文章</th>
				</thead>
				<tbody>
					<?php
						foreach( $commentRows as $arr ){
							echo '<tr>',
									 '<td><input type="checkbox" name="catRows[]" value="'.$arr['id'].'" /></td>',
									 '<td><a href="'. $arr['url'] .'">'.$arr['name'].'</a></td>',
									 '<td>'.$arr['description'].'</td>',
									 '<td>'.$arr['slug'].'</td>',
									 '<td><a href="'. $arr['slug_url'] .'">'.$arr['count'].'</td>',
							     '</tr>';
						}
					?>
				</tbody>
			</table>
			<div>
				<input type="submit" value="删除" name="delete">
				<?php 
					echo $paged;
				?>
			</div>
		</form>
	</div>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>