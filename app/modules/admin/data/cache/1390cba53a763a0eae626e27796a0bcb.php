<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		<form method="post">
			<div id="rightHeader">
				<div id="rightHeaderLine" class="f0"></div>
				<h2>单页列表</h2>
			</div>
			<div>
				<input type="submit" value="删除" name="delete">
				<?php 
					echo $paged;
				?>
			</div>
			<table>
				<thead>
					<th><input type="checkbox" name="singleAll" value="all" /></th>
					<th>标题</th>
					<th>作者</th>
					<th>日期</th>
				</thead>
				<tbody>
					<?php
						foreach( $singleRows as $arr ){
							echo '<tr>',
									 '<td><input type="checkbox" name="singleID[]" value="'. $arr['id'] .'" /></td>',
									 '<td><a href="'. $arr['url'] .'">'. $arr['title'] .'</a></td>',
									 '<td>'. $arr['author'] .'</td>',
									 '<td>'. $arr['time'] .'</td>',
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