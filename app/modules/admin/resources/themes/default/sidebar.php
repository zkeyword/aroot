<div id="left">
	<div id="sl-left">
		<ul id="menu">
			<li>
				<a class="menuItem<?php echo $actionName == 'index' ? ' menuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.index');?>">首页</a>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'post' ? ' menuItemCurrent' : ''?>" href="#">文章</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'post' && $methodName == 'index' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.post');?>">文章列表</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'post' && $methodName == 'add' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.post/add');?>">写文章</a></li>
				</ul>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'category' ? ' menuItemCurrent' : ''?>" href="#">分类</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'category' && $methodName == 'index' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.category');?>">分类列表</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'category' && $methodName == 'add' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.category/add');?>">添加分类</a></li>
				</ul>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'tag' ? ' menuItemCurrent' : ''?>" href="#">标签</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'tag' && $methodName == 'index' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.tag');?>">标签列表</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'tag' && $methodName == 'add' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.tag/add');?>">添加标签</a></li>
				</ul>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'single' ? ' menuItemCurrent' : ''?>" href="#">页面</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'single' && $methodName == 'index' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.single');?>">页面列表</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'single' && $methodName == 'add' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.single/add');?>">添加页面</a></li>
				</ul>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'media' ? ' menuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.media');?>">富文本</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'media' && $methodName == 'index' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.media');?>">富文本列表</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'media' && $methodName == 'add' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.media/add');?>">添加富文本</a></li>
				</ul>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'comment' ? ' menuItemCurrent' : ''?>" href="#">评论</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'comment' && $methodName == 'index' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.comment');?>">评论列表</a></li>
				</ul>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'user' ? ' menuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.user');?>">用户</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'user' && $methodName == 'index' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.user');?>">用户列表</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'user' && $methodName == 'add' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.user/add');?>">添加用户</a></li>
				</ul>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'options' ? ' menuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.options');?>">设置</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'options' && $methodName == 'index' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.options');?>">基本设置</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'options' && $methodName == 'post' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.options/post');?>">撰写设置</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'options' && $methodName == 'comment' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.options/comment');?>">评论设置</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'options' && $methodName == 'media' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.options/media');?>">富文本设置</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'options' && $methodName == 'link' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.options/link');?>">友情链接</a></li>
				</ul>
			</li>
			<li>
				<a class="menuItem<?php echo $actionName == 'rabc' ? ' menuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.rabc');?>">权限管理</a>
				<ul class="subMenu">
					<li><a class="subMenuItem<?php echo $actionName == 'rabc' && $methodName == 'addNode' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.rabc/addNode');?>">添加节点</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'rabc' && $methodName == 'addRole' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.rabc/addRole');?>">添加角色</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'rabc' && $methodName == 'nodeList' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.rabc/nodeList');?>">节点列表</a></li>
					<li><a class="subMenuItem<?php echo $actionName == 'rabc' && $methodName == 'roleList' ? ' subMenuItemCurrent' : ''?>" href="<?php echo U(APP_NAME.'.rabc/roleList');?>">角色列表</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>