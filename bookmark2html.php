<?php  
	if(!isset($_FILES['file'])){
?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width">
<title>Bookmark To Html</title>
<style>
	h4{text-align:center}
	.contain{width: 99%;margin: 20px auto;max-width: 700px;}
	div,form{font-size:20px;}
	form{width:99%;margin:0 auto}
	form  input{width:100%;height: 40px;margin:0;padding:0}
	.group{margin-bottom:20px;}
	.form-group{margin-bottom: 10px;overflow: hidden;font-size: 15px;}
	.form-group label{width:160px;display: block;float: left;}
	.form-group input{width: 180px;float: left;height: 20px;}
	.web_down{font-size:15px;.height: 20px;line-height: 20px;}
	.web_down input{width:15px;height: 20px;float:left}
	.web_down span{height:20px;line-height:20px;}
</style>
</head>
<body>
<div>
	<h4>Bookmark To Html</h4>
	<div class="contain">
		<form method="post" enctype="multipart/form-data">
			<div style="border-right:4px solid #fff;">
				<input name="file" type="file" placeholder="please input your the website" />
			</div>
			<input class="group" type="submit" value="submit"/> 
			<fieldset>
				<legend>Ps:</legend>
				<div class="form-group">
					1.打开浏览器书签管理<br>
					2.导出为html<br>
					3.使用本页面上传提交即生成html源码<br>
					4.测试兼容火狐与谷歌浏览器<br>
				</div> 
			</fieldset>
			<?php
		 
		?>
		</form>
		
	</div>
</div>


</body>
</html> 
<?php
	exit();
	}
	
	$filename = $_FILES['file']['name']; 
	$temp_name = $_FILES['file']['tmp_name']; 
	$size = $_FILES['file']['size']; 
	$error = $_FILES['file']['error']; 
	if ($size > 2*1024*1024){
		
		echo "<script>alert('文件大小超过2M大小');window.history.go(-1);</script>";
		exit();
	}else{
		$con=file_get_contents($temp_name);
	}
	
	//$file='bookmarks_2019_9_29.html';
	//$ftp=fopen($file,'r');
	//$con=fread($ftp,filesize($file));
	$rule_mean ="/\s{4}<DL>([\s\S]*)\n\s{4}<\/DL>/";
	if(preg_match_all($rule_mean,$con,$list_str)){
		$con=$list_str[1];
    }else{
	    echo 'mean not found';
		exit();
    }
	$data=array();
	$con1=$con[0]; 
	$rule_mean1 ="/\s{8}<DT><H3 \s{0,4}ADD_DATE=\"\d{10}\"\s{0,4}LAST_MODIFIED=\"\d{10}\">(.*?)<\/H3>([\s\S]*?)\n\s{8}<\/DL>/";
	
	if(preg_match_all($rule_mean1,$con1,$list_str)){
		foreach($list_str[1] as $k=>$v){
			$data[$k]['title']=$v;
		}   
		$rule_mean2 ="/\s{12}<DT><H3 \s{0,4}ADD_DATE=\"\d{10}\"\s{0,4}LAST_MODIFIED=\"\d{10}\">(.*?)<\/H3>([\s\S]*?)\n\s{12}<\/DL>/"; 
		foreach($list_str[2] as $k=>$v){
			$num=0;
			if(preg_match_all($rule_mean2,$v,$list_str2)){
				foreach($list_str2[1] as $kk=>$vv){
					$num++;
					$data[$k]['child'][$kk]['title']=$vv;
				} 
				$rule_mean3 ="/<DT><A HREF=\"(.*?)\"\s{0,4}ADD_DATE=\"(.*?)>(.*?)<\/A>/";
				foreach($list_str2[2] as $kk=>$vv){ 
					if(preg_match_all($rule_mean3,$vv,$list_str3)){
						foreach($list_str3[3] as $kkk=>$vvv){
							$data[$k]['child'][$kk]['child'][$kkk]=array('title'=>$vvv,'href'=>$list_str3[1][$kkk]);
						}
					}else{
						//echo 'mean3 not found';
					}
				} 
			}
			//echo 'mean2 not found';
			$rule_mean3 ="/[\n\r]\s{12}<DT><A HREF=\"(.*?)\"\s{0,4}ADD_DATE=\"(.*?)>(.*?)<\/A>/";
			if(preg_match_all($rule_mean3,$v,$list_str3)){
				$data[$k]['child'][$num]['title']='其它';
				//var_dump($list_str3);die;
				foreach($list_str3[3] as $kkk=>$vvv){
					$data[$k]['child'][$num]['child'][$kkk]=array('title'=>$vvv,'href'=>$list_str3[1][$kkk]);
				} 
			}else{
				//echo 'mean3 not found'; 
			} 
		}
    }else{
	    echo 'mean not found';
		exit();
    }
	//echo "<pre>";
	//var_dump($data);
	ob_start();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>个人站点导航</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />   
   <link rel="stylesheet" href="https://at.alicdn.com/t/font_1448571_rgv0bihhav.css"> 
</head>  
 <body class="page-body">
    <!-- skin-white -->
    <div class="page-container">
<style>
a{color:#373e4a;text-decoration:none}html,body{height:100%;margin:0;padding:0;border:none}.box2{height:66px;cursor:pointer;border-radius:4px;padding:0 30px 0 30px;background-color:#fff;border-radius:4px;border:1px solid #e4ecf3;margin:20px 0 0 0;-webkit-transition:all .3s ease;-moz-transition:all .3s ease;-o-transition:all .3s ease;transition:all .3s ease}.box2:hover{transform:translateY(-6px);-webkit-transform:translateY(-6px);-moz-transform:translateY(-6px);box-shadow:0 26px 40px -24px rgba(0, 36, 100, .3);-webkit-box-shadow:0 26px 40px -24px rgba(0, 36, 100, .3);-moz-box-shadow:0 26px 40px -24px rgba(0, 36, 100, .3);-webkit-transition:all .3s ease;-moz-transition:all .3s ease;-o-transition:all .3s ease;transition:all .3s ease}.xe-comment-entry img{float:left;display:block;margin-right:10px}.xe-comment p{}.overflowClip_1{overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;font-size:14px}.overflowClip_2{overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;margin:10px;font-size:14px}.xe-widget.xe-conversations{padding:15px}.sidebar-menu{width:240px}.sidebar-menu .main-menu a{color:#979898;text-decoration:none;display:block;padding:13px 5px;border-bottom:1px solid #313437}.sidebar-menu .main-menu ul li.is-shown{left:0;zoom:1;filter:alpha(opacity=100);-webkit-opacity:1;-moz-opacity:1;opacity:1;-webkit-transition:all 200ms ease-in-out;-moz-transition:all 200ms ease-in-out;-o-transition:all 200ms ease-in-out;transition:all 200ms ease-in-out}.sidebar-menu .main-menu ul li.is-shown+.is-shown{-webkit-transition-delay:80ms;-moz-transition-delay:80ms;-o-transition-delay:80ms;transition-delay:80ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown{-webkit-transition-delay:120ms;-moz-transition-delay:120ms;-o-transition-delay:120ms;transition-delay:120ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown+.is-shown{-webkit-transition-delay:160ms;-moz-transition-delay:160ms;-o-transition-delay:160ms;transition-delay:160ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown+.is-shown+.is-shown{-webkit-transition-delay:200ms;-moz-transition-delay:200ms;-o-transition-delay:200ms;transition-delay:200ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown{-webkit-transition-delay:240ms;-moz-transition-delay:240ms;-o-transition-delay:240ms;transition-delay:240ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown{-webkit-transition-delay:280ms;-moz-transition-delay:280ms;-o-transition-delay:280ms;transition-delay:280ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown{-webkit-transition-delay:320ms;-moz-transition-delay:320ms;-o-transition-delay:320ms;transition-delay:320ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown{-webkit-transition-delay:360ms;-moz-transition-delay:360ms;-o-transition-delay:360ms;transition-delay:360ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown{-webkit-transition-delay:400ms;-moz-transition-delay:400ms;-o-transition-delay:400ms;transition-delay:400ms}.sidebar-menu .main-menu ul li.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown+.is-shown{-webkit-transition-delay:440ms;-moz-transition-delay:440ms;-o-transition-delay:440ms;transition-delay:440ms}.sidebar-menu .main-menu ul li.hidden-item{visibility:hidden;zoom:1;filter:alpha(opacity=0);-webkit-opacity:0;-moz-opacity:0;opacity:0;-webkit-transition:all 250ms ease-in-out;-moz-transition:all 250ms ease-in-out;-o-transition:all 250ms ease-in-out;transition:all 250ms ease-in-out}.sidebar-menu .main-menu ul li a{padding-left:35px}.sidebar-menu .main-menu ul li ul li a{padding-left:60px}.sidebar-menu .main-menu ul li ul li ul li a{padding-left:85px}.sidebar-menu .main-menu ul li ul li ul li ul li a{padding-left:110px}.sidebar-menu .ps-scrollbar-x-rail .ps-scrollbar-x,.sidebar-menu .ps-scrollbar-y-rail .ps-scrollbar-y{background-color:rgba(255, 255, 255, .6)}.sidebar-menu.fixed{height:100%}.sidebar-menu.fixed .sidebar-menu-inner{position:fixed;left:0;top:0;bottom:0;width:inherit;overflow:hidden}.page-body.right-sidebar .sidebar-menu.fixed .sidebar-menu-inner{left:auto;right:0}@media screen and (min-width:768px){.sidebar-menu.collapsed{width:80px;z-index:9999;overflow:visible}.sidebar-menu.collapsed .hidden-collapsed{display:none!important}.sidebar-menu.collapsed+.main-content .user-info-navbar .user-info-menu a[data-toggle=sidebar]{color:#606161}.sidebar-menu.collapsed+.main-content .main-footer{left:80px}.sidebar-menu.collapsed .sidebar-menu-inner{overflow:visible}.sidebar-menu.collapsed .logo-env{padding:18px 0}.sidebar-menu.collapsed .logo-env .logo-collapsed{display:block;text-align:center}.sidebar-menu.collapsed .logo-env .logo-collapsed img{display:inline-block}.sidebar-menu.collapsed .logo-env .logo-expanded,.sidebar-menu.collapsed .logo-env .settings-icon{display:none}.sidebar-menu.collapsed .logo-env .logo{float:none}.sidebar-menu.collapsed .main-menu{padding-left:0;padding-right:0}.sidebar-menu.collapsed .main-menu>li{text-align:center;position:relative}.sidebar-menu.collapsed .main-menu>li.active,.sidebar-menu.collapsed .main-menu>li li.active{background-color:#252627}.sidebar-menu.collapsed .main-menu>li>a>i{margin-right:0;font-size:16px}.sidebar-menu.collapsed .main-menu>li>a>span{display:none}.sidebar-menu.collapsed .main-menu>li>a>span.label{display:block;position:absolute;right:0;top:0}.sidebar-menu.collapsed .main-menu>li.has-sub>a:before{display:none}.sidebar-menu.collapsed .main-menu>li.opened>ul{display:none}.sidebar-menu.collapsed .main-menu>li>ul{position:absolute;background:#2c2e2f;width:250px;top:0;left:100%;text-align:left}.page-body.right-sidebar .sidebar-menu.collapsed .main-menu>li>ul{left:auto;right:100%}.sidebar-menu.collapsed .main-menu>li>ul>li>a{padding-left:20px}.sidebar-menu.collapsed .main-menu>li>ul>li>ul>li>a{padding-left:35px}.sidebar-menu.collapsed .main-menu>li>ul>li>ul>li>ul>li>a{padding-left:50px}.sidebar-menu.collapsed .main-menu>li>ul>li>ul>li>ul>li>ul>li>a{padding-left:65px}.sidebar-menu.collapsed .main-menu>li>ul>li>ul>li>ul>li>ul>li>ul>li>a{padding-left:80px}.sidebar-menu.collapsed .main-menu>li>ul li.has-sub>a:before{margin-right:10px}.sidebar-menu.collapsed .main-menu>li:hover>ul{display:block}}.sidebar-menu{display:table-cell;position:relative;width:280px;background:#2c2e2f;z-index:1}.page-container .main-content{display:table-cell;position:relative;z-index:1;padding:30px;padding-bottom:0;vertical-align:top;word-break:break-word;width:100%;-webkit-transition:opacity 100ms ease-in-out;-moz-transition:opacity 100ms ease-in-out;-o-transition:opacity 100ms ease-in-out;transition:opacity 100ms ease-in-out}.page-container{display:table;width:100%;height:100%;vertical-align:top;border-collapse:collapse;border-spacing:0;table-layout:fixed}.row{overflow:hidden}@media (min-width: 768px){.col-sm-3{width:20%;float:left;padding:0 15px;box-sizing:border-box}}h4{margin-bottom:0;text-indent:15px}h3{margin-bottom:0}.tag{float:left;display:block;margin-right:10px;font-size:25px;font-weight:600;background-color:#eee;padding:15px}
</style>        <div class="sidebar-menu toggle-others fixed">
            <div class="sidebar-menu-inner">
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="#" class="logo-expanded">
                            <img src=""    />
                        </a>
                    </div>
                    <div class="mobile-menu-toggle visible-xs">
                        <a href="#" data-toggle="mobile-menu">
                            <i class="fa-bars"></i>
                        </a>
                    </div>
                </header>
                <ul id="main-menu" class="main-menu">
                    <?php     
						foreach($data as $k=>$v){
							echo '<li><a href="#path'.$k.'" class="smooth"><i class="iconfont icon-Starlarge"></i><span class="title">'.$v['title'].'</span></a></li>'; 
						}							
                    ?>
                </ul>
            </div>
        </div>
		<div class="main-content"> 
		<?php     
			foreach($data as $k=>$v){
				echo '<h3 class="text-gray"><i class="iconfont icon-shuqian_yel" style="margin-right: 7px;" id="path'.$k.'"></i>'.$v['title'].'</h4>'; 
				echo '<div class="row">';
				if($v['child']){
					foreach($v['child'] as $kk=>$vv){
						if(isset($vv['child'])){
							echo '<h4 class="text-gray"><i class="iconfont icon-dengpao" style="margin-right: 7px;"></i>'.$vv['title'].'</h4>';
							echo '<div class="row">';
							foreach($vv['child'] as $kkk=>$vvv){
								echo '<div class="col-sm-3"><div class="xe-widget xe-conversations box2 label-info"><div class="xe-comment-entry"><a class="xe-user-img"><span class="tag">'.mb_substr($vvv['title'],0,1,'utf-8').'</span></a><div class="xe-comment"><a href="'.$vvv['href'].'" class="xe-user-name overflowClip_1"><strong>'.$vvv['title'].'</strong></a><p class="overflowClip_2">'.$vvv['title'].'</p></div></div></div></div>';
								
							}
							echo '</div>';
						}else{
							echo '<div class="col-sm-3"><div class="xe-widget xe-conversations box2 label-info"><div class="xe-comment-entry"><a class="xe-user-img"><span class="tag">'.mb_substr($vvv['title'],0,1,'utf-8').'</span></a><div class="xe-comment"><a href="'.$vvv['href'].'" class="xe-user-name overflowClip_1"><strong>'.$vv['title'].'</strong></a><p class="overflowClip_2">'.$vvv['title'].'</p></div></div></div></div>';
						}
						
					}
				}
				echo '</div>';
			}							
		?>  
		<div style="height:40px;"></div>
        </div>
		
</div>
</body>
</html>
<?php
header("Content-type:application/octet-stream"); 
header("Content-Disposition:attachment;filename = ".time().'.html'); 
?>