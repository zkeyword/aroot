<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit" />
	<title>aroot - Powered by aroot</title>
	<?php echo '<link rel="stylesheet" href="'. C('APP_GROUP_THEME_DIR') . 'style.css?' . VERSION .'" type="text/css" media="all" />';?>
</head>
<body id="wrap">
	<?php if( $actionName != 'login' ){?>
	<div id="header" class="fn-clear">
		<div class="fn-left">
			<a href="<?php echo __ROOT__;?>" id="loginOut">网站</a>
			<a href="#">新建文章</a>
			<a href="#">新建页面</a>
			<a href="#">新建用户</a>
		</div>
		<div class="fn-right">
			<a href="#" id="loginOut"><?php echo $userName;?>欢迎您，</a>
			<a href="#" id="loginOut">设置</a>
			<a href="<?php echo U(APP_NAME.'.login/loginOut')?>" id="loginOut">登出</a>
		</div>
	</div>
	<div id="main" class="fn-clear">
	<?php }else{?>
	<div id="loginMain" class="fn-clear">
	<?php }?>
