<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		<form method="post">
			<?php if( $methodName == 'add' ){?>
				<div id="rightHeader">
					<div id="rightHeaderLine" class="f0"></div>
					<h2>添加用户</h2>
				</div>
				<ul id="rightWrap">
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">用户名:</label>
						<input class="ui-input" type="text" name="name" id="">
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">昵称:</label>
						<input class="ui-input" type="text" name="name" id="">
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">邮箱:</label>
						<input class="ui-input" type="text" name="name" id="">
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">密码:</label>
						<input class="ui-input" type="text" name="slug" id="" />
						<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
					</li>
				</ul>
			<?php }else{?>
				<div id="rightHeader">
					<div id="rightHeaderLine" class="f0"></div>
					<h2>编辑用户</h2>
				</div>
				<ul id="rightWrap">
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">用户名:</label>
						<input class="ui-input" type="text" name="name" id="" value="<?php echo $userType;?>" />
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">昵称:</label>
						<input class="ui-input" type="text" name="name" id="">
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">邮箱:</label>
						<input class="ui-input" type="text" name="name" id="">
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<?php if( $userType == 1 ){?>
						<li class="rightItem fn-clear">
							<label class="ui-label" for="">密码:</label>
							<input class="ui-input" type="text" name="slug" id="" />
							<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
						</li>
						<li class="rightItem fn-clear">
							<label class="ui-label" for="">用户类型:</label>
							<select name="type">
								<option value="1">管理员</option>
								<option value="2">普通用户</option>
							</select>	
						</li>
						<li class="rightItem fn-clear">
							<label class="ui-label" for="">是否启用:</label>
							<select name="status">
								<option value="1">是</option>
								<option value="2">否</option>
							</select>	
						</li>
					<?php }elseif( 0 ){?>
						<li class="rightItem fn-clear">
							<label class="ui-label" for="">原密码:</label>
							<input class="ui-input" type="text" name="slug" id="" />
							<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
						</li>
						<li class="rightItem fn-clear">
							<label class="ui-label" for="">新密码:</label>
							<input class="ui-input" type="text" name="slug" id="" />
							<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
						</li>
						<li class="rightItem fn-clear">
							<label class="ui-label" for="">重复新密码:</label>
							<input class="ui-input" type="text" name="slug" id="" />
							<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
						</li>
					<?php }?>
				</ul>
			<?php }?>
			<div id="rightBtnWrap">
				<input type="submit" value="提交" name="rightSubmit" id="rightSubmit" />
			</div>
		</form>
	</div>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>