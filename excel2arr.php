<?php
$first=false;
if(isset($_FILES['file']['name'])){
   $temp_name=$_FILES['file']['tmp_name'];
   $size=$_FILES['file']['size'];
   if($size>2*1024*1024){
       echo "<script>alert('The post file is too large!');</script>";
       exit();
   }
   require_once('./Classes/PHPExcel/IOFactory.php'); 
   $excel_path=$temp_name;
 
$objPHPExcelReader= PHPExcel_IOFactory::load($excel_path);     
$sheetArr = $objPHPExcelReader->getSheet(0)->toArray(); 
$output=<<<EOF
/**
    * key1:{$sheetArr[0][0]}
    * key2:{$sheetArr[0][1]}
    * key3:{$sheetArr[0][2]}
    * key4:{$sheetArr[0][3]}
    * key5:{$sheetArr[0][4]}
    * key6:{$sheetArr[0][5]}
    * key7:{$sheetArr[0][6]}
    * key8:{$sheetArr[0][7]}
    * key9:{$sheetArr[0][8]}
    * key10:{$sheetArr[0][9]}
    * key11:{$sheetArr[0][10]}
    * key12:{$sheetArr[0][11]}
    * key13:{$sheetArr[0][12]}
*/\n\n
EOF;
for ($i = 1;$i < count($sheetArr);$i ++)
{
    if(!empty($sheetArr[$i][3])){
        $row['DATA_'.$sheetArr[$i][3]]=array(
            'key1'=>$sheetArr[$i][0],
            'key2'=>$sheetArr[$i][1],
            'key3'=>$sheetArr[$i][2],
            'key4'=>'DATA_'.$sheetArr[$i][3],
            'key5'=>$sheetArr[$i][4],
            'key6'=>$sheetArr[$i][5],
            'key7'=>$sheetArr[$i][6],
            'key8'=>$sheetArr[$i][7],
            'key9'=>$sheetArr[$i][8],
            'key10'=>$sheetArr[$i][9],
            'key11'=>$sheetArr[$i][10],
            'key12'=>$sheetArr[$i][11],
            'key13'=>$sheetArr[$i][12],
        );
    }
}   
$output.='$return=array('."\n";
foreach($row as $k=>$v){ 
    $output.="'$k'=>array(";
    foreach($v as $kk=>$vv){ 
        $output.='\''.$kk."'=>'".$vv.'\','; 
    }
    $output=trim($output,',');
    $output.="),\n"; 
}
$output=trim($output,",\n");
$output.="\n);";
$first=true;
}
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
    .code{font-size: 12px;margin-top: 20px;}
    .code textarea{width: 100%; padding: 20px;box-sizing: border-box;border:none;}
</style>
</head>
<body>
<div>
	<h4>excel coverTo array</h4>
	<div class="contain">
		<form method="post" enctype="multipart/form-data">
			<div style="border-right:4px solid #fff;">
				<input name="file" type="file" placeholder="please input your the website" />
			</div>
			<input class="group" type="submit" value="submit"/> 
			<fieldset>
				<legend>Ps:</legend>
				<div class="form-group">
					1.<a href="./democode/demo.xlsx" target="_blank">excel样本</a><br>
				</div> 
			</fieldset>
        </form>
        <div class="code">
        <?php
        if($first){ 
            echo "<fieldset><legend>转换结果:<button id=\"copyBtn\">copy</button></legend>";
           echo "<form><textarea id=\"result\">$output</textarea></form></fieldset>"; 
        }
        ?>
        </div>
	</div>
</div>
<script>
window.onload=function(){ 
const s=document.querySelector('#result');
s.style.height="auto";
s.style.height=(s.scrollHeight+0)+'px'; 
}
document.querySelector('#copyBtn').onclick=function(e){
    var input = document.querySelector('#result'); 
    input.select();
    document.execCommand("copy");
    alert("复制成功");
}
</script>

</body>
</html>
