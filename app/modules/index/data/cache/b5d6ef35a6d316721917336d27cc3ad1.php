<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<div id="content">
	<form name="register" method="post" action="?register&registerUser">
		<div class="fn-clear">
			<label for="user" class="ui-label">用户名：</label>
			<input type="text" class="ui-input" name="user" id="user" />
		</div>
		<div class="fn-clear">
			<label for="email" class="ui-label">邮箱：</label>
			<input type="text" class="ui-input" name="email" id="email" />
		</div>
		<div class="fn-clear">
			<label for="pw" class="ui-label">密码：</label>
			<input type="password" name="pw" id="pw" />
		</div>
		<div class="fn-clear">
			<label for="pw2" class="ui-label">重复密码：</label>
			<input type="password" class="ui-input" name="pw2" id="pw2" />
		</div>
		<div class="fn-clear">
			<label for="randCode" class="ui-label">验证码：</label>
			<input type="text" class="ui-input" name="randCode" id="randCode" />
			<?php echo randImg();?>
		</div>
		<div class="fn-clear">
			<input type="submit" name="submit" value="注册" />
		</div>
	</form>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>