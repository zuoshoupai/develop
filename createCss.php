<?php 
/**
describe:去掉绝对定位的枚举，节省空间；类名向bootstrap靠拢，方便过渡
date:2019-06-03
author:zane
**/
if(!isset($_POST['scene'])){
	
}else{
	if(empty($_POST['scene']) || !in_array($_POST['scene'],array('pc','web','wechat'))){
		$wrong = true;
	}else{
		$compress = false;
		$compress_str = '';
		if(isset($_POST['compress']) && $_POST['compress']){
			$compress = true;
			$compress_str='_min'; 
		}  
		if($_POST['scene']=='wechat'){
			$fileName="zane_".$_POST['scene'].$compress_str.".wxss"; 
		}else{
			$fileName="zane_".$_POST['scene'].$compress_str.".css"; 
		}
		
		header("Content-type:application/octet-stream"); 
		header("Content-Disposition:attachment;filename = ".$fileName); 
		create_css($_POST['scene'],$compress);
	}
	die;
}
function create_css($scene,$compress){
	//$compress=false;//是否压缩
	//$scene = 'pc';
	$add=1;
	if($scene=='wechat'){
		$extra = 'rpx';//应用场景单位
		$times = 2;
		$add=2;
	}elseif($scene=='web'){
		$extra = 'rem';//应用场景单位
		$times = 0.01;
	}elseif($scene=='pc'){
		$extra = 'px';//应用场景单位
		$times = 1;
	}
	$trans='';
if($scene=='pc'){
echo <<<ET
.container-fluid{width:100% !important;}$trans
.z-container{width:1200px;margin:0 auto;min-width:1300px !important;}
ET;
}
echo "/*弹性布局*/$trans
.border-box{box-sizing: border-box !important;}
.d-none{display:none !important;}$trans
.d-block{display: block}$trans
.d-inline-block{display: inline-block !important}$trans
.d-flex{display:flex !important;}$trans
.flex-1{flex:1}$trans
.flex-row{flex-direction: row !important}$trans
.flex-column{flex-direction:column !important}$trans
.justify-content-start{justify-content: flex-start !important}$trans
.justify-content-end{justify-content:flex-end !important}$trans
.justify-content-center{justify-content:center !important}$trans
.justify-content-between{justify-content: space-between !important}$trans
.justify-content-around{justify-content: space-around !important;}$trans
.align-items-center{align-items:center !important;}$trans
.align-items-center{align-items:center !important;}$trans
.align-items-start{align-items: flex-start !important;}$trans
.align-items-end{align-items: flex-end !important;}$trans
.flex-wrap{flex-wrap: wrap !important;}$trans
$trans/* 拓展设置  需要自定义*/$trans
.color0{color:#000 !important;}$trans
.color3{color:#333 !important;}$trans
.color6{color:#666 !important;}$trans
.color9{color:#999 !important;}$trans
.color-b{color:#50d7da !important;}$trans
.color-w{color:#fff !important;}$trans 
.bg-w{background-color:#fff !important;}$trans
";

echo "
/*初始化*/$trans
body, h1, h2, h3, h4, h5, h6, hr, p, blockquote, dl, dt, dd, ul, ol, li, pre, form, fieldset, legend, button, input, textarea, th, td {margin:0;padding:0;}$trans
body, button, input, select, textarea {outline: none;font:12px/1.5tahoma, arial, \5b8b\4f53;}$trans
h1, h2, h3, h4, h5, h6{font-size:100%;}$trans
address, cite, dfn, em, var {font-style:normal;}$trans
code, kbd, pre, samp {font-family:couriernew, courier, monospace;}$trans
small{font-size:12px;}$trans
ul, ol {list-style:none;}$trans
a {text-decoration:none;}$trans
a:hover {text-decoration:none;}$trans
sup {vertical-align:text-top;}$trans
sub{vertical-align:text-bottom;}$trans
legend {color:#000;}$trans
fieldset, img {border:0;}$trans
button, input, select, textarea {font-size:100%;}$trans
table {border-collapse:collapse;border-spacing:0;}$trans
img,image{max-width: 100%;max-height: 100%;}$trans
.float-left{float:left !important;}$trans
.float-right{float:right !important;}$trans
.full-width{width:100% !important }$trans
.fly-out{position: absolute;left: -10000px !important;}$trans
.text-center{text-align:center !important;}$trans
.text-right{text-align:right !important;}$trans
.text-left{text-align:left !important}$trans
.pointer{cursor:pointer !important;}$trans 
.hidden{visibility: hidden !important;}$trans
.clear{clear:both !important;}$trans
.clearfix{overflow:hidden !important;}$trans
.position-absolute{position:absolute !important}$trans
.position-relative{position:relative !important}$trans
.bold{font-weight:600 !important}$trans
.p-0{padding:0 !important}$trans
.p-r0,.px-0{padding-right:0 !important}$trans
.pl-0,.px-0{padding-left:0 !important}$trans
.pt-0,.py-0{padding-top:0 !important}$trans
.pb-0,py-0{padding-bottom:0 !important}$trans
.m-0{margin:0 !important;}$trans
.mx-auto{margin-right:auto !important;margin-left:auto !important;}$trans
.mr-0,.mx-0{margin-right:0 !important}$trans
.ml-0,.mx-0{margin-left:0 !important}$trans
.mt-0,.my-0{margin-top:0 !important}$trans
.mb-0,.my-0{margin-bottom:0 !important}$trans
.border0{border:0 !important;}$trans
.t-0{top:0 !important;}$trans
.r-0{right:0 !important}$trans
.l-0{left:0 !important}$trans
.b-0{bottom:0 !important}$trans
.border-r0{border-right:0 !important}$trans
.border-l0{border-left:0 !important}$trans
.border-t0{border-top:0 !important}$trans
.border-b0{border-bottom:0 !important}$trans
.left0{left:0 !important;}$trans
.right0{right:0 !important;}$trans
.bottom0{bottom:0;}$trans
.top0{top:0 !important;}$trans
.index-9{z-index:9 !important}$trans
.index-99{z-index:99 !important}$trans
.index-999{z-index:999 !important}$trans
.index-9999{z-index:9999 !important}$trans
.w-25{width:25% !important}$trans
.w-50{width:50% !important}$trans
.w-75{width:75% !important}$trans
.w-100{width:100% !important}$trans
.h-100{height: 100% !important;}$trans
.line-height75{line-height: 75% !important;}$trans
.line-height100{line-height: 100% !important;}$trans
.lights:hover{color:#666 !important;}$trans
";
echo "/*end*/\r\n"; 
if($scene=='web'){
echo <<<ET
.page{max-width: 750px !important;min-width:320px !important;margin: 0 auto !important;}$trans

ET;
}
if(!$compress){
	$trans="\r\n";
} 
echo "/*枚举部分-字号*/$trans"; 
$font_s=10;
$font_e=30;
for ($i=$font_s;$i<=$font_e;$i=$i+1) {
	echo ".font-".$i."{font-size:".$i."px !important;}$trans";
}
echo "/*枚举部分-外边距*/$trans";  
$s=2;
$step=2/$add;
$e=50;
for($i=$s;$i<=$e;$i=$i+$step){
	echo ".m-".$i*$add."{margin:".$i*$times.$extra." !important;}$trans";
	echo ".mt-".$i*$add.",.my-".$i*$add."{margin-top:".$i*$times.$extra." !important;}$trans";
	echo ".mr-".$i*$add.",.mx-".$i*$add."{margin-right:".$i*$times.$extra." !important;}$trans";
	echo ".mb-".$i*$add.",.my-".$i*$add."{margin-bottom:".$i*$times.$extra." !important;}$trans";
	echo ".ml-".$i*$add.",.mx-".$i*$add."{margin-left:".$i*$times.$extra." !important;}$trans";   
}
echo "/*枚举部分-内边距*/$trans";  
$s=2;
$step=2;
$e=50;
for($i=$s;$i<=$e;$i=$i+$step){
	echo ".p-".$i*$add."{padding:".$i*$times.$extra." !important;}$trans";
	echo ".pt-".$i*$add.",.py-".$i*$add."{padding-top:".$i*$times.$extra." !important;}$trans";
	echo ".pr-".$i*$add.",.px-".$i*$add."{padding-right:".$i*$times.$extra." !important;}$trans";
	echo ".pb-".$i*$add.",.py-".$i*$add."{padding-bottom:".$i*$times.$extra." !important;}$trans";
	echo ".pl-".$i*$add.",.px-".$i*$add."{padding-left:".$i*$times.$extra." !important;}$trans";   	
} 
}


?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width">
<title>webpage crawler</title>
<style>
	h4{text-align:center}
	.contain{width: 99%;margin: 20px auto;max-width: 700px;}
	div,form{font-size:20px;}
	form{width:99%;margin:0 auto}
	form  select,form input{width:100%;height: 40px;margin:0;padding:0}
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
	<h4>webpage BaseStyle file</h4>
	<div class="contain">
		<form method="post">
			<div style="border-right:4px solid #fff;">
				<select name="scene" >
					<option value="">please select one
					<option value="pc">pc
					<option value="web">web
					<option value="wechat">wechat
				</select>
			</div>
			<input class="group" type="submit" value="submit"/>
			 <fieldset>
				<legend>default config</legend>
				<label for="web_down" class="web_down">
					<input type="checkbox" id="web_down" name="compress"  /><span>compress</span>
				</label>
			</fieldset>
			<?php
		if(isset($first)&&$first==1){
			echo "<div style=\"text-align: center; margin-top: 20px;}\"><a href=".$download.">下载地址</div>";
		}
		if(isset($wrong)&& $wrong){
			echo "<h5 style='color:red'>Please fill in the correct information!</h5>";
		}
		?>
		</form>
		
	</div>
</div>


</body>
</html> 

