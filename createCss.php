<?php 
/**
describe:去掉绝对定位的枚举，节省空间；类名向bootstrap靠拢，方便过渡
date:2019-04-24
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
	if($scene=='wechat'){
		$extra = 'rpx';//应用场景单位
		$times = 1;
	}elseif($scene=='web'){
		$extra = 'rem';//应用场景单位
		$times = 0.01;
	}elseif($scene=='pc'){
		$extra = 'px';//应用场景单位
		$times = 1;
	}
	$trans='';

echo "
/*弹性布局*/$trans
.border-box{box-sizing: border-box;}
.d-block{display: block}$trans
.d-inline-block{display: inline-block}$trans
.d-flex{display:flex;}$trans
.flex-row{flex-direction: row}$trans
.flex-column{flex-direction:column}$trans
.justify-content-start{justify-content: flex-start}$trans
.justify-content-end{justify-content:flex-end}$trans
.justify-content-center{justify-content:center}$trans
.justify-content-space-between{justify-content: space-between}$trans
.justify-content-space-around{justify-content: space-around;}$trans
.align-items-center{align-items:center;}$trans
.flex-wrap{flex-wrap: wrap;}$trans
$trans/* 拓展设置  需要自定义*/$trans
.color0{color:#000;}$trans
.color3{color:#333;}$trans
.color6{color:#666;}$trans
.color9{color:#999;}$trans
.color-b{color:#50d7da;}$trans
.color-w{color:#fff;}$trans 
.bg-w{background-color:#fff;}$trans
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
img{max-width: 100%;max-height: 100%;}$trans
.float-left{float:left;}$trans
.float-right{float:right;}$trans
.full-width{width:100% !important }$trans
.fly-out{position: absolute;left: -10000px;}$trans
.text-center{text-align:center;}$trans
.text-right{text-align:right;}$trans
.text-left{text-align:left }$trans
.pointer{cursor:pointer;}$trans
.none{display:none;}$trans
.hidden{visibility: hidden;}$trans
.clear{clear:both;}$trans
.clearfix{overflow:hidden;}$trans
.position-absolute{position:absolute }$trans
.position-relative{position:relative }$trans
.bold{font-weight:600}$trans
.p-0{padding:0}$trans
.p-r0{padding-right:0}$trans
.pl-0{padding-left:0}$trans
.pt-0{padding-top:0}$trans
.pb-0{padding-bottom:0}$trans
.m-0{margin:0;}$trans
.mr-0{margin-right:0}$trans
.ml-0{margin-left:0}$trans
.mt-0{margin-top:0}$trans
.mb-0{margin-bottom:0}$trans
.border0{border:0;}$trans
.t-0{top:0;}$trans
.r-0{right:0}$trans
.l-0{left:0}$trans
.b-0{bottom:0}$trans
.border-r0{border-right:0}$trans
.border-l0{border-left:0}$trans
.border-t0{border-top:0}$trans
.border-b0{border-bottom:0}$trans
.left0{left:0;}$trans
.right0{right:0;}$trans
.bottom0{bottom:0;}$trans
.top0{top:0;}$trans
.index-9{z-index:9}$trans
.index-99{z-index:99}$trans
.index-999{z-index:999}$trans
.index-9999{z-index:9999}$trans
.w-25{width:25%}$trans
.w-50{width:50%}$trans
.w-75{width:75%}$trans
.w-100{width:100%}$trans
.h-100{height: 100%;}$trans
.line-height75{line-height: 75%;}$trans
.line-height100{line-height: 100%;}$trans
.lights:hover{color:#666;}$trans
";
echo "/*end*/\r\n"; 
if($scene=='web'){
echo <<<ET
.page{max-width: 750px;min-width:320px;margin: 0 auto;}$trans

ET;
}
if(!$compress){
	$trans="\r\n";
}
if($scene=='pc'){
echo <<<ET
@media(min-width:1200px){ $trans
.z-container{width:1200px;margin:0 auto;}$trans
.z-min{width:1300px;margin:0 auto;}$trans
ET;
}
echo "/*枚举部分-字号*/$trans"; 
$font_s=5;
$font_e=40;
for ($i=$font_s;$i<=$font_e;$i++) {
	echo ".font".$i."{font-size:".$i*$times.$extra.";}$trans";
}
echo "/*枚举部分-外边距*/$trans";  
$s=5;
$step=5;
$e=100;
for($i=$s;$i<=$e;$i=$i+$step){
	echo ".m-".$i."{margin:".$i*$times.$extra.";}$trans";
	echo ".mt-".$i."{margin-top:".$i*$times.$extra.";}$trans";
	echo ".mt-".$i."{margin-right:".$i*$times.$extra.";}$trans";
	echo ".mb-".$i."{margin-bottom:".$i*$times.$extra.";}$trans";
	echo ".ml-".$i."{margin-left:".$i*$times.$extra.";}$trans"; 
}
echo "/*枚举部分-内边距*/$trans";  
$s=5;
$step=5;
$e=100;
for($i=$s;$i<=$e;$i=$i+$step){
	echo ".p-".$i."{padding:".$i*$times.$extra.";}$trans";
	echo ".pt-".$i."{padding-top:".$i*$times.$extra.";}$trans";
	echo ".pr-".$i."{padding-right:".$i*$times.$extra.";}$trans";
	echo ".pb-".$i."{padding-bottom:".$i*$times.$extra.";}$trans";
	echo ".pl-".$i."{padding-left:".$i*$times.$extra.";}$trans"; 
	echo ".px-".$i."{padding-left:".$i*$times.$extra.";padding-right:".$i*$times.$extra.";}$trans";  
}
echo "/*枚举部分-倒角*/$trans";  
$s=5;
$step=5;
$e=100;
for($i=$s;$i<=$e;$i=$i+$step){
	echo ".border-radius".$i."{border-radius:".$i*$times.$extra.";}$trans";
}  

if($scene=='pc'){
	$times = 0.8;
	echo <<<ET
}$trans
@media(max-width:1199px){ $trans
.z-container{width:960px;margin:0 auto;}
.z-min{width:1000px;margin:0 auto;}
$trans
ET;
	echo "/*枚举部分-字号*/$trans"; 
	$font_s=5;
	$font_e=40;
	for($i=$font_s;$i<=$font_e;$i++){
		echo ".font".$i."{font-size:".$i*$times.$extra.";}$trans";
	}
	echo "/*枚举部分-外边距*/$trans";  
	$s=5;
	$step=5;
	$e=100;
	for($i=$s;$i<=$e;$i=$i+$step){
		echo ".m-".$i."{margin:".$i*$times.$extra.";}$trans";
		echo ".mt-".$i."{margin-top:".$i*$times.$extra.";}$trans";
		echo ".mr-".$i."{margin-right:".$i*$times.$extra.";}$trans";
		echo ".mb-".$i."{margin-bottom:".$i*$times.$extra.";}$trans";
		echo ".ml-".$i."{margin-left:".$i*$times.$extra.";}$trans"; 
	}
	echo "/*枚举部分-内边距*/$trans";  
	$s=5;
	$step=5;
	$e=100;
	for($i=$s;$i<=$e;$i=$i+$step){
		echo ".p-".$i."{padding:".$i*$times.$extra.";}$trans";
		echo ".pt-".$i."{padding-top:".$i*$times.$extra.";}$trans";
		echo ".pr-".$i."{padding-right:".$i*$times.$extra.";}$trans";
		echo ".pb-".$i."{padding-bottom:".$i*$times.$extra.";}$trans";
		echo ".pl-".$i."{padding-left:".$i*$times.$extra.";}$trans"; 
		echo ".px-".$i."{padding-left:".$i*$times.$extra.";padding-right:".$i*$times.$extra.";}$trans";  
	}
	echo "/*枚举部分-倒角*/$trans";  
	$s=5;
	$step=5;
	$e=100;
	for($i=$s;$i<=$e;$i=$i+$step){
		echo ".border-radius".$i."{border-radius:".$i*$times.$extra.";}$trans";
	} 
    echo "}"; 
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

