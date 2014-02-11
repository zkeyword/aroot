<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<form name="login" method="post" id="loginWrap">
	<div class="fn-clear">
		<label class="ui-label" for="user">用户名：</label>
		<input class="ui-input" type="text" name="user" id="user" value="<?php echo $userName; ?>" />
	</div>
	<div class="mt10 fn-clear">
		<label class="ui-label" for="pw">密码：</label>
		<input class="ui-input" type="password" name="pw" id="pw" />
	</div>
	<div class="mt10 fn-clear" id="randCodeWrap"<?php echo ($isLoginErrorNo ? '' : ' style="display:none"');?>>
		<label class="ui-label" for="randCode">验证码：</label>
		<input class="ui-input" type="text" name="randCode" id="randCode" />
		<?php echo randImg();?>
	</div>
	<div class="mt10 fn-clear">
		<label class="ui-label ui-checkbox-label" for="keepLogin">记住我：</label>
		<input class="ui-checkbox" type="checkbox" name="keepLogin" id="keepLogin">
	</div>
	<div class="mt10 fn-clear">
		<div id="loginSubmitWrap">
			<input type="submit" name="submit" id="loginSubmit" value="登陆" />
		</div>
	</div>
</form>
<?php include C('APP_THEME_PATH').'footer.php';?>
<script>
	$(document).ready(function(){
		$('#loginSubmit').click(function(){
			$.ajax({
				type: "POST",
				url: "<?php echo U(APP_NAME.'.login/login');?>",
				data: {
					user:      $("#user").val(),
					pw:        $("#pw").val(),
					randCode:  $("#randCode").val(),
					keepLogin: $("#keepLogin").attr("checked"),
					submit:    $("#loginSubmit").val()
				},
				beforeSend:function(){
					$("#submit").val('登陆中...');
				},
				success: function(json){
					var obj = $.parseJSON(json);
					$("#submit").val('登陆');

					if( obj.isLoginErrorNo ){
						$('#randCodeWrap').show();
					}

					if( obj.msg =='验证码出错' ){

					}else if( obj.msg == '密码错误' ){
						
					}else if( obj.msg == '该用户名不存在' ){
						
					}else if( obj.msg == '登录成功' ){
						document.location.replace(document.location.href);
					}
				}
			});
			return false;
		});
	});
</script>