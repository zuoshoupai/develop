;(function ($) {
    $.fn.spaceme = function (options) { //定义插件方法名
		options = $.extend({
		id: '',
		skin:'blue'
		  },options); 
		var old_str = this.val(),old_str_arr = old_str.split(','),old_width=this.css('width'),old_paading=this.parent().css('padding-right'),id=options.id,skin=options.skin;
	   if(id.replace(/\s/g,'').length>0){
			id = 'id="'+id.replace(/\s/g,'')+'"';
	   }
	   if(skin.replace(/\s/g,'').length>0){
			skin = skin.replace(/\s/g,'')+'"';;
	   }
	   var container = '<div '+id+' class="zane-spaceme zane-spaceme-multi '+skin+'" ><ul class="zane-spaceme-choices" >';
	   for(var i=0;i<old_str_arr.length;i++)
	   {
			if (old_str_arr[i].replace(/(^s*)|(s*$)/g, "").length >0) 
			{ 
				container+='<li class="search-choice" ><span>'+old_str_arr[i]+'</span><a class="search-choice-close">Χ</a></li>'; 
			} 
		}
	   container+='<li class="search-field"><input  type="text"></li></ul></div>';
	   this.css({'position': 'absolute','top': '0','z-index': '1','width':(old_width-15)+'px','text-indent':'999999999999px'}); 
	   this.focus(function(){
			$(".zane-spaceme .search-field input").focus();
	   })
	   this.before(container);
	   var obj = this;
	   this.hide();
		$(".zane-spaceme:not(.search-choice)").click(function(){
			$(this).find("input").focus();
		});
		$(".zane-spaceme input").keydown(function(e){
			if(!e) var e = window.event; 
			if(e.keyCode==32||e.keyCode==188){  
				 var str = $(this).val(); 
				 $(this).val('  ');
				 if(/^ *$/.test(str)!=true)
				 {
					str = str.replace(/(^\s*)/g,'');
					var html = '<li class="search-choice"><span>'+str+'</span><a class="search-choice-close">Χ</a></li>';
					 $(this).parent().before(html);
				}  
				var consume = '';
				$(this).parent().prevAll().children("span").each(function(){
					consume+=$(this).text()+',';
				});  
				obj.val(consume.replace(/(,$)/g,'')); 
			}
		 })
		$(".zane-spaceme").on('click','.search-choice-close',function(){
			obj_par = $(this).parent().parent();
			$(this).parent().remove(); 
			var consume = '';   
			obj_par.find("span").each(function(){
					consume+=$(this).text()+',';
			}); 
			obj.val(consume.replace(/(,$)/g,'')); 
			return false;
		});
		var space_css='<style>.zane-spaceme{position: relative;border: 1px solid #eee;padding: 5px 15px;border-radius: 20px;}.zane-spaceme-choices{overflow:hidden;list-style:none;z-index: 10;padding: 0;margin: 0;display: flex;align-items: center;}.zane-spaceme-choices .search-choice{float:left;position:relative;position: relative;padding: 2px 16px;margin-right: 10px;background-color:#009688;color: #fff;border-radius: 10px;}.zane-spaceme-choices .search-choice-close{position: absolute;color: #f13d3d;top: -6px;right: 0px;font-weight: bold}.zane-spaceme-choices .search-field{float:left}.zane-spaceme-choices .search-field input {width: 70px;}.normal .search-choice{background-color:#1E9FFF;color: #fff;}.warm .search-choice{background-color:#FFB800;color: #fff;}.danger .search-choice{background-color:#FF5722;color: #fff;}.danger .zane-spaceme-choices .search-choice-close{color: #666;}</style>';
	   $('head').append(space_css);
		return this;
	}
})(window.jQuery);