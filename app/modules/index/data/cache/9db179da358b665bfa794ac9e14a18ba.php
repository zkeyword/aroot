<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<div id="content">
	<div id="left">
		<ul id="catList" class="ui-list fn-right">
		<?php
			foreach ($post as $key => $val){
				echo '<li>',
					     '<article class="ui-listBg">',
							 '<div class="ui-listDetail">',
								 '<h2 class="ui-listTitle"><a href="'. $val['url'] .'">'. $val['title'] .'</a></h2>',
								 '<div class="ui-listAside">作者：'. $val['author'] .' 发表于：'. $val['time'] .' <a href="'. $val['url'] .'" title="《'. $val['title'] .'》上的评论">0 条评论</a></div>',
								 '<p>'. $val['content'] .'</p>',
								 '<a href="'. $val['url'] .'" rel="nofollow" class="ui-fullArt">继续阅读&nbsp;&gt;</a></div>',
					 			 '<div class="ui-moveTag clear">标签：'. $val['tag'] .'</div>',
					     '</article>',
				 	 '</li>';
			}
		?>
		</ul>
	</div>
	<div id="right"></div>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>
