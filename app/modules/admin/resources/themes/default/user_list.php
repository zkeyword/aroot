<?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		<form method="post">
			<div id="rightHeader">
				<div id="rightHeaderLine" class="f0"></div>
				<h2>用户列表</h2>
			</div>
			<table>
				<thead>
					<th><input type="checkbox" name="postAll" value="all" /></th>
					<th>用户名</th>
					<th>昵称</th>
					<th>邮箱</th>
					<th>用户类型</th>
					<th>最近一次登陆时间</th>
					<th>注册时间</th>
				</thead>
				<tbody>
					<?php
						foreach( $userRows as $arr ){
							echo '<tr>',
									 '<td><input type="checkbox" name="postrows[]" value="'. $arr['id'] .'" /></td>',
									 '<td><a href="'. $arr['url'] .'">'. $arr['name'] .'</a></td>',
									 '<td>'. $arr['displayName'] .'</td>',
									 '<td>'. $arr['email'] .'</td>',
									 '<td>'. $arr['type'] .'</td>',
									 '<td>'. $arr['lastLoginTime'] .'</td>',
									 '<td>'. $arr['registeredTime'] .'</td>',
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