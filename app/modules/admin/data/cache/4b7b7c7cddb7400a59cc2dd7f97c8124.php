<?php if(!defined("INC")) exit("Request Error!");?><?php getAdminHeader();?>
<?php getAdminSidebar();?>
<div id="right">
	<div id="sl-right">
		<form method="post">
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
						foreach( $tagRows as $arr ){
							echo '<tr>',
									 '<td><input type="checkbox" name="catRows[]" value="'.$arr['id'].'" /></td>',
									 '<td><a href="?tag&action=detail&id='. $arr['id'] .'">'.$arr['name'].'</a></td>',
									 '<td>'.$arr['description'].'</td>',
									 '<td>'.$arr['url'].'</td>',
									 '<td><a href="?post&tag='. $arr['url'] .'">'.$arr['count'].'</td>',
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
<?php getAdminFooter();?>