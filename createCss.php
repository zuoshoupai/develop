<?php 
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
if(!$compress){
	$trans="\r\n";
} 
echo <<<ET
/*fl fr text-r text-l 等等*/$trans
ET;
echo <<<ET
/*固定部分*/$trans
body, h1, h2, h3, h4, h5, h6, hr, p, blockquote, dl, dt, dd, ul, ol, li, pre, form, fieldset, legend, button, input, textarea, th, td {margin:0;padding:0;}$trans
body, button, input, select, textarea {font:12px/1.5tahoma, arial, \5b8b\4f53;}$trans
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
.fl{float:left;}$trans
.fr{float:right;}$trans
.full-width{width:100% !important }$trans
.fly-out{position: absolute;left: -10000px;}$trans
.text-c{text-align:center;}$trans
.text-r{text-align:right;}$trans
.text-l{text-align:left }$trans
.pointer{cursor:pointer;}$trans
.none{display:none;}$trans
.hidden{visibility: hidden;}$trans
.clear{clear:both;}$trans
.position-a{position:absolute }$trans
.position-r{position:relative }$trans
.bold{font-weight:600}$trans
.padding0{padding:0}$trans
.padding-r0{padding-right:0}$trans
.padding-l0{padding-left:0}$trans
.padding-t0{padding-top:0}$trans
.padding-b0{padding-bottom:0}$trans
.margin0{margin:0;}$trans
.margin-r0{margin-right:0}$trans
.margin-l0{margin-left:0}$trans
.margin-t0{margin-top:0}$trans
.margin-b0{margin-bottom:0}$trans
.border0{border:0;}$trans
.border-r0{border-right:0}$trans
.border-l0{border-left:0}$trans
.border-t0{border-top:0}$trans
.border-b0{border-bottom:0}$trans
.left0{left:0;}$trans
.right0{right:0;}$trans
.bottom0{bottom:0;}$trans
.top0{top:0;}$trans
.block{display: block}$trans
.inline-block{display: inline-block}$trans
.index9{z-index:9}$trans
.index99{z-index:99}$trans
.index999{z-index:999}$trans
.index9999{z-index:9999}$trans
.width25{width:25%}$trans
.width50{width:50%}$trans
.width75{width:75%}$trans
.width100{width:100%}$trans
.height100{height: 100%;}$trans
.line-height75{line-height: 75%;}$trans
.line-height100{line-height: 100%;}$trans
.lights:hover{color:#666;}$trans

ET;
if($scene=='web'){
echo <<<ET
.page{max-width: 750px;min-width:320px;margin: 0 auto;}$trans

ET;
}
if($scene=='pc'){
echo <<<ET
@media(min-width:1200px){ $trans
.z-container{width:1200px;margin:0 auto;}
}/$trans
ET;
}
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
	echo ".margin".$i."{margin:".$i*$times.$extra.";}$trans";
	echo ".margin-t".$i."{margin-top:".$i*$times.$extra.";}$trans";
	echo ".margin-r".$i."{margin-right:".$i*$times.$extra.";}$trans";
	echo ".margin-b".$i."{margin-bottom:".$i*$times.$extra.";}$trans";
	echo ".margin-l".$i."{margin-left:".$i*$times.$extra.";}$trans"; 
}
echo "/*枚举部分-内边距*/$trans";  
$s=5;
$step=5;
$e=100;
for($i=$s;$i<=$e;$i=$i+$step){
	echo ".padding".$i."{padding:".$i*$times.$extra.";}$trans";
	echo ".padding-t".$i."{padding-top:".$i*$times.$extra.";}$trans";
	echo ".padding-r".$i."{padding-right:".$i*$times.$extra.";}$trans";
	echo ".padding-b".$i."{padding-bottom:".$i*$times.$extra.";}$trans";
	echo ".padding-l".$i."{padding-left:".$i*$times.$extra.";}$trans"; 
	echo ".side".$i."{padding-left:".$i*$times.$extra.";padding-right:".$i*$times.$extra.";}$trans";  
}
echo "/*枚举部分-倒角*/$trans";  
$s=5;
$step=5;
$e=100;
for($i=$s;$i<=$e;$i=$i+$step){
	echo ".border-radius".$i."{border-radius:".$i*$times.$extra.";}$trans";
} 
echo "/*枚举部分-绝对定位*/$trans";  
$s=2;
$step=2;
$e=100;
for($i=$s;$i<=$e;$i=$i+$step){
	echo ".top".$i."{top:".$i*$times.$extra.";}$trans";
	echo ".right".$i."{right:".$i*$times.$extra.";}$trans";
	echo ".bottom".$i."{bottom:".$i*$times.$extra.";}$trans";
	echo ".left".$i."{left:".$i*$times.$extra.";}$trans";
} 
if($scene=='pc'){
	$times = 0.8;
	echo <<<ET
}$trans
@media(max-width:1199px){ $trans
.z-container{width:960px;margin:0 auto;}
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
		echo ".margin".$i."{margin:".$i*$times.$extra.";}$trans";
		echo ".margin-t".$i."{margin-top:".$i*$times.$extra.";}$trans";
		echo ".margin-r".$i."{margin-right:".$i*$times.$extra.";}$trans";
		echo ".margin-b".$i."{margin-bottom:".$i*$times.$extra.";}$trans";
		echo ".margin-l".$i."{margin-left:".$i*$times.$extra.";}$trans"; 
	}
	echo "/*枚举部分-内边距*/$trans";  
	$s=5;
	$step=5;
	$e=100;
	for($i=$s;$i<=$e;$i=$i+$step){
		echo ".padding".$i."{padding:".$i*$times.$extra.";}$trans";
		echo ".padding-t".$i."{padding-top:".$i*$times.$extra.";}$trans";
		echo ".padding-r".$i."{padding-right:".$i*$times.$extra.";}$trans";
		echo ".padding-b".$i."{padding-bottom:".$i*$times.$extra.";}$trans";
		echo ".padding-l".$i."{padding-left:".$i*$times.$extra.";}$trans"; 
		echo ".side".$i."{padding-left:".$i*$times.$extra.";padding-right:".$i*$times.$extra.";}$trans";  
	}
	echo "/*枚举部分-倒角*/$trans";  
	$s=5;
	$step=5;
	$e=100;
	for($i=$s;$i<=$e;$i=$i+$step){
		echo ".border-radius".$i."{border-radius:".$i*$times.$extra.";}$trans";
	} 
	echo "/*枚举部分-绝对定位*/$trans";  
	$s=2;
	$step=2;
	$e=100;
	for($i=$s;$i<=$e;$i=$i+$step){
		echo ".top".$i."{top:".$i*$times.$extra.";}$trans";
		echo ".right".$i."{right:".$i*$times.$extra.";}$trans";
		echo ".bottom".$i."{bottom:".$i*$times.$extra.";}$trans";
		echo ".left".$i."{left:".$i*$times.$extra.";}$trans";
	} 
	echo "}$trans";
}
echo <<<EOD
/*弹性布局*/$trans
.flex{display:flex;}$trans
.flex-row{flex-direction: row}$trans
.flex-column{flex-direction:column}$trans
.flex-start{justify-content: flex-start}$trans
.flex-end{justify-content:flex-end}$trans
.flex-cente{justify-content:center}$trans
.flex-space-between{justify-content: space-between}$trans
.flex-space-around{justify-content: space-around;}$trans
.flex-align-center{align-items:center;}$trans
.flex-wrap{flex-wrap: wrap;}$trans
$trans/* 拓展设置  需要自定义*/$trans
.color0{color:#000;}$trans
.color3{color:#333;}$trans
.color6{color:#666;}$trans
.color9{color:#999;}$trans
.color-b{color:#50d7da;}$trans
.color-w{color:#fff;}$trans 
.bg-w{background-color:#fff;}$trans
EOD;
echo "/*end*/";
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
