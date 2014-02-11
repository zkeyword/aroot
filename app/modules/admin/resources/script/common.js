var admin = {
	init: function(){
		var self = this;
		self.initHeight();
		self.menu();
		self.checkbox();
		//$('#content').ckeditor();
		tinymce.init({
		    selector: "#content",
		    language: "zh_cn"
		 });
	},
	initHeight: function(){
		var docH    = $(document).height(),
			headerH = $('#header').height(),
			footerH = $('#footer').height(),
			leftH   = $('#sl-left').height(),
			diffH   = docH-headerH-footerH;
		
			if( diffH < leftH ){
				$('#sl-left').css({'position':'fixed'});
			}else{
				$('#sl-left').height(diffH);
			}

		$('#loginMain').height(docH-150-footerH);
	},
	menu: function(){
		$('.menuItemCurrent').next('.subMenu').show();
		$('.menuItem').click(function(){
			var subMenu = $(this).next('.subMenu'),
				bother  = subMenu.parent().siblings().find('.subMenu');
			if( subMenu.length ){
				if( $(this).next('.subMenu:visible') ){
					subMenu.show();
					bother.hide();
				}else{
					subMenu.hide();
				}
				return false;
			}
		});
	},
	checkbox: function(){
		$('#sl-right th').find('input').click(function(){
			var inputs = $('#sl-right td').find('input');
			$(this).attr('checked') ? inputs.attr('checked', 'checked') : inputs.removeAttr('checked');
		});
	}
}.init();

$(document).resize(function(){
	admin.initHeight();
});