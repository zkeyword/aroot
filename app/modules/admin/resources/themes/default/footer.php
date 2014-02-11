	</div>
	<div id="footer">
		<div id="sl-footer" class="fn-clear">
			<p>基于 aroot 构建</p>
			<p>
				<a href="#">文档支持</a>
				<a href="#">论坛</a>
				<a href="#">报告错误</a>
				<a href="#">其他资源</a>
			</p>
		</div>
	</div>
</body>
</html>
<?php 
	echo '<script src="'. C('APP_RESOURCES_DIR') . 'script/jquery.min.js?' .VERSION.'"></script>' . "\n",
		 //'<script src="'. C('APP_GROUP_SCRIPT_DIR') . 'ckeditor/ckeditor.js?' .VERSION.'"></script>' . "\n",
		 //'<script src="'. C('APP_GROUP_SCRIPT_DIR') . 'ckeditor/adapters/jquery.js?' .VERSION.'"></script>' . "\n",
		 '<script src="'. C('APP_GROUP_SCRIPT_DIR') . 'tinymce/tinymce.min.js?' .VERSION.'"></script>' . "\n",
		 '<script src="'. C('APP_GROUP_SCRIPT_DIR') . 'tinymce/jquery.tinymce.min.js?' .VERSION.'"></script>' . "\n",
		 '<script src="'. C('APP_GROUP_SCRIPT_DIR') . 'common.js?' .VERSION.'"></script>' . "\n";
?>