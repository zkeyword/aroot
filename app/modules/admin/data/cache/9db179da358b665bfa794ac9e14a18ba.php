<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		概况：
		<div>文章 <?php echo $postNum?></div>
		<div>分类 <?php echo $categoryNum?></div>
		<div>标签 <?php echo $tagNum?></div>
		<div>页面 <?php echo $pageNum?></div>
		<div>评论 <?php echo $commentNum?></div>
		<div>近期评论</div>
	</div>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>