<?php include C('APP_THEME_PATH').'header.php';?>
<form name="login" method="post">
	<div>用户名：<input type="text" name="user" id="user" value="<?php echo getPGC('username', 'C'); ?>" /></div>
	<div>密码：<input type="password" name="pw" id="pw" /></div>
	<div>验证码：<input type="text" name="randCode" id="randCode" /><?php echo randImg();?></div>
	<input type="submit" name="submit" id="submit" value="登陆" />
</form>
<?php include C('APP_THEME_PATH').'footer.php';?>
<script>
	$(document).ready(function(){
		/*$('#user').focusout(function(){
			$.ajax({
				type: "POST",
				url: "source/page/ajax.php?do=login&logintype=checkusername",
				data: {
					user: $("#user").val()
				},
				success: function(isRegister){
					if( isRegister ){
						$("#user").val('用户名b存在');
					}else{
						$("#user").val('用户名b存在');
					}
				}
			});
		});*/
		$('#submit').click(function(){
			$.ajax({
				type: "POST",
				url: "source/page/ajax.php?do=login",
				data: {
					user:     $("#user").val(),
					pw:       $("#pw").val(),
					randCode: $("#randCode").val(),
					submit:   $("#submit").val()
				},
				beforeSend:function(){
					$("#submit").val('登陆中...');
				},
				success: function(msg){
					console.log(msg);
					$("#submit").val('登陆');
				}
			});
			return false;
		});
	});
</script>