<?php if(!defined("INC")) exit("Request Error!");?><?php getAdminHeader();?>
<?php getAdminSidebar();?>
<div id="right">
	<div id="sl-right" class="fn-clear">
		<form method="post" enctype="multipart/form-data">
			<?php if( $action == 'add' ){?>
				<div class="fn-left">
					<div><label for="">标题:</label><input type="text" name="title" id=""></div>
					<div><label for="">简介:</label><input type="text" name="description" id=""></div>
					<div><label for="">标签:</label><input type="text" name="tag" id=""></div>
					<div><label for="">内容:</label><textarea name="content" id=""></textarea></div>
				</div>
			<?php }else{?>
				<div class="fn-left">
					<div><label for="">标题:</label><input type="text" name="title" id="" value="<?php echo $postDetail['title'];?>"></div>
					<div>
						<label for="">缩略图:</label>
						<input type="file" name="_thumb" id="" />
						<input type="submit" name="test" value="test" />
					</div>
					<div><label for="">简介:</label><input type="text" name="description" id="" value="<?php echo $postDetail['description'];?>"></div>
					<div><label for="">标签:</label><input type="text" name="tag" id="" value="<?php echo $postDetail['tag'];?>"></div>
					<div><label for="">内容:</label><textarea name="content" id=""><?php echo $postDetail['content'];?></textarea></div>
				</div>
			<?php }?>
			<div class="fn-clear clear"><input type="submit" name="submit" value="提交"></div>
		</form>
	</div>
</div>
<?php getAdminFooter();?>
<?php
if( getPGC('test') ){
	require(SOURCE_PATH . 'class/upFile.php');
	$fileArr = array('filepath' => UPLOAD_PATH,'israndname'=> false);
	$file = new FileUpload($fileArr);
	$file->uploadfile('post_thumb');
	$file->getErrorMsg();
	echo $file->getNewFileName();
}
?>