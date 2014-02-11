<?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		<form method="post">
			<?php if( $methodName == 'add' ){?>
				<div id="rightHeader">
					<div id="rightHeaderLine" class="f0"></div>
					<h2>添加标签</h2>
				</div>
				<ul id="rightWrap">
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">名称:</label>
						<input class="ui-input" type="text" name="name" id="">
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">别名:</label>
						<input class="ui-input" type="text" name="slug" id="" />
						<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">简介:</label>
						<textarea class="ui-textarea" name="description" id=""></textarea>
						<p>描述只会在一部分主题中显示.</p>
					</li>
				</ul>
			<?php }else{?>
				<div id="rightHeader">
					<div id="rightHeaderLine" class="f0"></div>
					<h2>编辑标签</h2>
				</div>
				<ul id="rightWrap">
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">名称:</label>
						<input class="ui-input" type="text" name="name" id="" value="<?php echo $name;?>" />
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">别名:</label>
						<input class="ui-input" type="text" name="slug" id="" value="<?php echo $slug;?>" />
						<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="">简介:</label>
						<textarea class="ui-textarea" name="description" id=""><?php echo $description;?></textarea>
						<p>描述只会在一部分主题中显示.</p>
					</li>
				</ul>
			<?php }?>
			<div id="rightBtnWrap">
				<input type="submit" value="提交" name="rightSubmit" id="rightSubmit" />
			</div>
		</form>
	</div>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>