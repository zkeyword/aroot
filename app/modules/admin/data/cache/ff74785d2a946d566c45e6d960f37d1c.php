<?php if(!defined("INC")) exit("Request Error!");?><?php include C('APP_THEME_PATH').'header.php';?>
<?php include C('APP_THEME_PATH').'sidebar.php';?>
<div id="right">
	<div id="sl-right" class="fn-clear">
		<form method="post" enctype="multipart/form-data">
			<div id="rightHeader">
				<div id="rightHeaderLine" class="f0"></div>
				<h2>撰写文章</h2>
			</div>
			<?php if( $methodName == 'add' ){?>
				<div class="fn-left">
					<div>
						<label for="">标题:</label>
						<input type="text" name="title" id="">
					</div>
					<div>
						<label for="">简介:</label>
						<input type="text" name="description" id="">
					</div>
					<div>
						<label for="">标签:</label>
						<input type="text" name="tag" id="">
					</div>
					<div>
						<textarea name="content" id="content"></textarea>
					</div>
				</div>
				<div class="fn-right">
					<label for="">分类:</label>
					<?php
						echo $showCategory;
					?>
				</div>
			<?php }else{?>
				<div class="fn-left">
					<div>
						<label for="">标题:</label>
						<input type="text" name="title" id="" value="<?php echo $postDetail['title'];?>">
					</div>
					<div>
						<label for="">缩略图:</label>
						<input type="file" name="post_thumb" id="" />
						<input type="hidden" name="thumb" value="<?php echo isset($fileNewName)?$fileNewName:'';?>" />
						<input type="submit" name="upload" value="upload" />
					</div>
					<div>
						<label for="">简介:</label>
						<input type="text" name="description" id="" value="<?php echo $postDetail['description'];?>">
					</div>
					<div>
						<label for="">标签:</label>
						<input type="text" name="tag" id="" value="<?php echo $postDetail['tag'];?>">
					</div>
					<div>
						<textarea name="content" id="content"><?php echo $postDetail['content'];?></textarea>
					</div>
				</div>
				<div class="fn-right">
					<label for="">分类:</label>
					<?php
						echo $showCategory;
					?>
				</div>
			<?php }?>
			<div class="fn-clear clear"><input type="submit" name="submit" value="提交"></div>
		</form>
	</div>
</div>
<?php include C('APP_THEME_PATH').'footer.php';?>
