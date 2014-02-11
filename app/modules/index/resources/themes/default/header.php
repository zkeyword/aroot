<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit" />
	<title><?php echo $title;?></title>
	<meta name="keywords" content="<?php echo $keywords;?>" />
	<meta name="description" content="<?php echo $description;?>" />
	<?php echo '<link rel="stylesheet" href="'. C('APP_GROUP_THEME_DIR') . 'style.css?' . VERSION .'" type="text/css" media="all" />';?>
</head>
<body>

<!-- <div id="topBar">
	<div id="top">
		<a href="<?php //echo SITEURL . '?register';?>">注册</a>
		<a href="<?php //echo SITEURL . '?login';?>">登陆</a>
		<a href="<?php //echo SITEURL . 'admin';?>">后台</a>
	</div>
</div> -->
<div id="header">
	<div class="navBar">
		<ul id="nav">
			<li><a href="<?php echo __ROOT__;?>">首页</a></li>
			<?php echo $showCatList;?>
		</ul>
		<form method="get" id="searchForm">
			<input type="text" name="search" id="searchTxt" class="inputTxt" placeholder="请输入搜索关键词" x-webkit-speech />
			<input type="submit" value="搜索" id="searchBtn" class="inputBtn" />
		</form>
	</div>
</div>
