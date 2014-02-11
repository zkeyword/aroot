<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right">
		<form method="post">
			<?php if( $methodName == 'add' ){?>
				<div id="rightHeader">
					<div id="rightHeaderLine" class="f0"></div>
					<h2>添加分类</h2>
				</div>
				<ul id="rightWrap">
					<li class="rightItem fn-clear">
						<label class="ui-label" for="categoryName">名称:</label>
						<input type="text" name="name" id="categoryName" class="ui-input" />
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="categoryUrl">别名:</label>
						<input type="text" name="url" id="categoryUrl" class="ui-input" />
						<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="categoryParent">父级:</label>
						<select name="parent" id="categoryParent">
							<option value="0">无</option>
							<?php
								echo $showCategory;
							?>
						</select>
						<p>分类目录和标签不同，它可以有层级关系。您可以有一个“音乐”分类目录，在这个目录下可以有叫做“流行”和“古典”的子目录.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="categoryDescription">简介:</label>
						<textarea name="description" id="categoryDescription" class="ui-textarea"></textarea>
						<p>描述只会在一部分主题中显示.</p>
					</li>
				</ul>
			<?php }else{?>
				<div id="rightHeader">
					<div id="rightHeaderLine" class="f0"></div>
					<h2>分类编辑</h2>
				</div>
				<ul id="rightWrap">
					<li class="rightItem fn-clear">
						<label class="ui-label" for="categoryName">名称:</label>
						<input type="text" name="name" id="categoryName" class="ui-input"  value="<?php echo $catDetail['name'];?>" />
						<p>这将是它在站点上显示的名字.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="categoryUrl">别名:</label>
						<input type="text" name="url" id="categoryUrl" class="ui-input" value="<?php echo $catDetail['url'];?>" />
						<p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="categoryParent">父级:</label>
						<select name="parent" id="categoryParent">
							<option value="0">无</option>
							<?php
								echo $showCategory;
							?>
						</select>
						<p>分类目录和标签不同，它可以有层级关系。您可以有一个“音乐”分类目录，在这个目录下可以有叫做“流行”和“古典”的子目录.</p>
					</li>
					<li class="rightItem fn-clear">
						<label class="ui-label" for="categoryDescription">简介:</label>
						<textarea name="description" id="categoryDescription" class="ui-textarea"><?php echo $catDetail['description'];?></textarea>
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