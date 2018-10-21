(function ($) {
      $.fn.spaceme = function (options) { //定义插件方法名
            options = $.extend({
              name: 'Steven Zhu'
              },options); 
           var old_str = this.val(),old_str_arr = old_str.split(','),old_width=this.css('width'),old_paading=this.parent().css('padding-right');
           var container = '<div class="zane-spaceme zane-spaceme-multi" style="width: '+old_width+'px;position: relative;" ><ul class="zane-spaceme-choices" style="overflow:hidden;position: absolute;z-index: 10;left: 10px;top: 5px;">';
           for(var i=0;i<old_str_arr.length;i++)
           {
			    if (old_str_arr[i].replace(/(^s*)|(s*$)/g, "").length >0) 
				{ 
					container+='<li class="search-choice" style="float:left;position:relative;position: relative;padding: 2px 16px;margin-right: 10px;background-color:#78a5f1;color: #fff;margin-bottom: 10px;"><span>'+old_str_arr[i]+'</span><a class="search-choice-close" style="position: absolute;color: #f13d3d;top: -6px;right: 0px;font-weight: bold;">Χ</a></li>'; 
				} 
           	}
           container+='<li class="search-field" style="float:left"><input  style="width: 70px;margin-bottom: 10px;"  type="text"></li></ul></div>';
		   this.css({'position': 'absolute','top': '0','z-index': '1','width':(old_width-15)+'px','text-indent':'999999999999px'}); 
		   this.focus(function(){
				$(".zane-spaceme .search-field input").focus();
		   })
           this.before(container);
           var obj = this;
          //this.hide();
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
			         	var html = '<li class="search-choice" style="float:left;position:relative;position: relative;padding: 2px 16px;margin-right: 10px;background-color:#78a5f1;color: #fff;margin-bottom: 10px;"><span>'+str+'</span><a class="search-choice-close" style="position: absolute;color: #f13d3d;top: -6px;right: 0px;font-weight: bold;">Χ</a></li>';
				         $(this).parent().before(html);
				         
			         }  
					 
			        var consume = '';
			        $(this).parent().prevAll().children("span").each(function(){
			        	consume+=$(this).text()+',';
					}); 
					obj.val(consume);
					var height_u = $(".zane-spaceme-choices").height();
					obj.height((height_u-10)+'px');
					obj.parent().height((height_u-10)+'px');
					
			    }
			 });  
            $(".zane-spaceme").on("click",".search-choice-close",function(){
            	obj_par = $(this).parent().parent();
            	$(this).parent().remove(); 
            	var consume = '';   
            	obj_par.find("span").each(function(){
			        	consume+=$(this).text()+',';
				}); 
				var height_u = $(".zane-spaceme-choices").height();
					obj.height((height_u-10)+'px');
					obj.parent().height((height_u-10)+'px');
				obj.val(consume); 
            });
            return this;
        }
})(window.jQuery);
