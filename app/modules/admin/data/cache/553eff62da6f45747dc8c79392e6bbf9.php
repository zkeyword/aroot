<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		<form method="post">
			<div id="rightHeader">
				<div id="rightHeaderLine" class="f0"></div>
				<h2>基本设置</h2>
			</div>
			<ul id="rightWrap">
				<li class="rightItem fn-clear">
					<label class="ui-label" for="title">站点名称</label>
					<input id="title" name="title" type="text" class="ui-input" value="<?php echo $title;?>" />
					<p>站点的名称将显示在网页的标题处.</p>
				</li>
				<li class="rightItem fn-clear">
					<label class="ui-label" for="description">站点描述</label>
					<textarea id="description" name="description" class="ui-textarea"><?php echo $description;?></textarea>
					<p>站点描述将显示在网页代码的头部.</p>
				</li>
				<li class="rightItem fn-clear">
					<label class="ui-label" for="keywords">关键词</label>
					<input id="keywords" name="keywords" type="text" class="ui-input" value="<?php echo $keywords;?>" />
					<p>请以半角逗号","分割多个关键字.</p>
				</li>
			</ul>
			<div id="rightBtnWrap">
				<input type="submit" value="提交" name="rightSubmit" id="rightSubmit" />
			</div>
		</form>
	</div>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>