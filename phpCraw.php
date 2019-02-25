<?php 
class craw{
	private $root_url;
	private $root_dir ;
	private $root_path;
	private $host_path;
	private $root_http = 'http';
	public $_js = 'js';
	public $_css = 'css';
	public $_image = 'images';
	public $_picture = 'picture';
	public $_web_down = false;
	public function __construct($root_url){
		$this->root_url = $root_url; 
		$root_url=trim($root_url,'/');
		if(substr_count($root_url,'/')>2){
			$fileinfo = pathinfo($root_url); 
			$this->root_path = $fileinfo['dirname']; //网站文件目录
		}else{
			$this->root_path = $root_url; //网站文件目录
		} 
		$url_info = explode('/',$root_url); 
		if(strpos($url_info[0],'https')!==false){
			$this->root_http = 'https';
		}
		$this->host_path = $url_info[0].'//'.$url_info[2];
		$this->root_dir = time();
	}
	public function run(){
		$data = $this->parseDom($this->root_url); 
		$this->downloadFile($data['js'],1);
		$this->downloadFile($data['css'],2);
		$this->downloadFile($data['img'],3);  
		//解析css图片并下截 
		$this->parseCssFile($data['css']); 
		$content = $data['content'];
		$content = $this->parseloadFile($data['js'],1,$content);
		$content = $this->parseloadFile($data['css'],2,$content);
		$content = $this->parseloadFile($data['img'],3,$content);
		$content = $this->extra_parse($content); 
		//写入index.html
		$file_dir = $this->root_dir;
		if(!is_dir($file_dir)){
			mkdir($file_dir,0777,true);
			chmod($file_dir,0777); 
		}
		file_put_contents($file_dir.'/index.html',$content);
		return $this->creatzip();
		
	}
	//其它匹配规则
	private function extra_parse($content){ 
		$root_http = $this->root_http;
		$rule_ex = "/img[\'\"]?\:[\'\"]?\/\/(.*?)[\'\"]/"; 
		$replace_ex = "img':'".$root_http."://\${1}'";  
		$content =  Preg_replace($rule_ex,$replace_ex,$content);  
		//$rule_ex = "/image[\'\"]?\:[\'\"]?[\\]?\/[\\]?\/(.*?)[\'\"]/"; 
		//$replace_ex = "image\":\"".$root_http.":\${1}";  
		//$content =  Preg_replace($rule_ex,$replace_ex,$content); 
		return $content;
	}
	private function parseDom($root_url){
  
		$data =  $this->_get_contents($root_url,2); 
		$encoding = mb_detect_encoding($data, array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
		$keytitle = iconv($encoding,"UTF-8",$data); 
		//js  <script type="text/javascript" src="js/artTemplate_d6facd8.js"></script>
		$rule_js = "/<[\s]*script[^>]+src=[\s]*[\'\"](.*?)\.js/";
		preg_match_all($rule_js,$data,$result_js); 
		$js_arr = $result_js[1];  
		//css
		$rule_css = "/<[\s]*link[^>]+href=[\s]*[\'\"](.*?)\.css/";
		preg_match_all($rule_css,$data,$result_css); 
		$css_arr = $result_css[1]; 
		//image
		$rule_image = "/<[\s]*img[^>]+[\s]{0,4}src=[\s]{0,4}[\'\"](.*?)[\'\"]/";
		preg_match_all($rule_image,$data,$result_image);
		$img_arr = $this->_filter_array($result_image[1]); 
	
		//picture
		$rule_picture = "/[\s]*background(-image)?[\s]*:[\s]*url\([\'\"]?(.*?)[\'\"]?\)/";
		preg_match_all($rule_picture,$data,$result_picture);
		$data_images_arr = $this->_filter_array($result_picture[2]); 
		$img_arr=array_merge($img_arr,$data_images_arr); 
		$datas = array();
		$datas['js'] = array_unique($js_arr);
		$datas['css'] = array_unique($css_arr); 
		$datas['img'] = array_unique($img_arr); 	
		$datas['content'] = $data;
		return $datas;
	}
	/**
	*** 解析并下载css中的图片
	*** $url_arr 文件数组，不带拓展名
	*** $type 文件类型 1：js 2: css 3: image
	*/
	private function parseCssFile($url_arr)
	{ 
		$host_path = $this->host_path;
		$root_path = $this->root_path;
		$Dir = $this->root_dir;
		$root_http = $this->root_http;
		$extension_name = '.css'; 
		$extension_pic = ''; 
		$file_dir = $Dir.'/'.$this->_picture;
		$file_css = $Dir.'/'.$this->_css;
		$file_picture = '../'.$this->_picture;
		if(!is_dir($file_dir)){
			mkdir($file_dir,0777,true);
			chmod($file_dir,0777); 
		} 
		foreach($url_arr as $url)
		{ 
			if(strpos($url,'http')!==false){
				$file_target = $url.$extension_name;
			}elseif(substr($url,0,2)=='//'){
				$file_target = $root_http.':'.$url.$extension_name;
			}elseif(substr($url,0,1)=='/'){
				$file_target = $host_path.$url.$extension_name;
			}else{ 
				$file_target = $root_path.'/'.$url.$extension_name;
			}
			$fileinfo = pathinfo($url);
			$fileName = $fileinfo['basename']; 
			$file = $this->_get_contents($file_target); 
			$rule_images = "/[\s]*background(-image)?[\s]*:[\s]*url\([\'\"]?(.*?)[\'\"]?\)/";
			preg_match_all($rule_images,$file,$result_images);
			$data_images_arr = $this->_filter_array($result_images[2]);   
			$max_count=50;
			$j=0;
			foreach($data_images_arr as $vv){
				if($j>$max_count){
					break;
				}
				if(strpos($vv,'data:image')!==false){
					continue;
				}
				if(strpos($vv,'http')!==false){
					$file_target1 = $vv;
				}elseif(substr($vv,0,2)=='//'){
					$file_target1 = $root_http.':'.$vv;
				}elseif(substr($vv,0,1)=='/'){
					$file_target1 = $host_path.$vv;
				}else{
					$file_target1 = dirname($file_target).'/'.$vv; 
				}  
				$fileinfo1 = pathinfo($vv);
				$fileName1 = $fileinfo1['basename'];
				try{
					$file1 = $this->_get_contents($file_target1); 
					file_put_contents($file_dir.'/'.$fileName1,$file1); 
					
				}catch(Exception $e){
					//echo $e->getMessage();
				}  
				$file = str_replace($vv,$file_picture.'/'.$fileName1,$file);
				$j++;
			}  
			if(!is_dir($file_css)){
				mkdir($file_css,0777,true);
				chmod($file_dir,0777); 
			}
			file_put_contents($file_css.'/'.$fileName.$extension_name,$file); 
		}  
	}
	private function _filter_array($arr){ 
		if(!is_array($arr)){
			return $arr;
		}
		$arr_new = array();
		foreach($arr as $v){
			if(empty($v)){
				continue;
			} 
			if(strpos($v,'#')!==false){
				continue;
			}
			if(strpos($v,'{')!==false){
				continue;
			}
			if(strpos($v,'}')!==false){
				continue;
			}
			if(strpos($v,'?')!==false){
				$v=substr($v,0,strpos($v,'?'));
			}
			$arr_new[] = $v;
		}
		return $arr_new;
	}
	/**
	*** 获取远程文件内容
	*** $url_arr 文件地址
	*** $op 可选参数，2表示强制curl获取
	*/
	private function _get_contents($root_url,$op=1){  
		if(strpos($root_url,'https')!==false || $op==2){
			$ch = curl_init();//初始化一个资源
			$headers = array(); 
			$headers[] = 'User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11';
			$headers[]='X-FORWARDED-FOR:111.222.333.9';
			$headers[] = 'CLIENT-IP:111.222.333.9';
			curl_setopt($ch,CURLOPT_URL,$root_url);//设置我们要获取的网页
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//关闭直接输出
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER  , $headers);  
			curl_setopt( $ch , CURLOPT_SSL_VERIFYPEER, false); //关闭ssl
			curl_setopt($ch, CURLOPT_REFERER, "http://www.test.com");   
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}else{
			return	file_get_contents($root_url); 
			
		}
	}
	/**
	*** 下载文件函数
	*** $url_arr 文件数组，不带拓展名
	*** $type 文件类型 1：js 2: css 3: image
	*/
	private function downloadFile($url_arr,$type)
	{
		$host_path = $this->host_path;
		$root_path = $this->root_path;
		$root_http = $this->root_http;
		$Dir = $this->root_dir; 
		$max_count=100;
		$op_true = false;
		if($type == 1){
			$extension_name = '.js';
			$file_dir = $Dir.'/'.$this->_js;
			$op_true=true;
		}elseif($type==2){
			$extension_name = '.css';
			$file_dir = $Dir.'/'.$this->_css;
			$op_true=true;
		}elseif($type ==3){
			$extension_name = '';
			$file_dir = $Dir.'/'.$this->_image;;
			$max_count=100;
		} 
		$j=0;
		foreach($url_arr as $url)
		{ 
			$op = false;
			if($j>$max_count){
				break;
			}
			if(strpos($url,'http')!==false){
				$file_target = $url.$extension_name;
				$op = false;
			}elseif(substr($url,0,2)=='//'){
				$file_target =$root_http.':'.$url.$extension_name;
				$op = false;
			}elseif(substr($url,0,1)=='/'){
				$file_target = $host_path.$url.$extension_name;
			}else{ 
				$file_target = $host_path.'/'.$url.$extension_name;
			}
			if($this->_web_down || $op || $op_true){  
				$fileinfo = pathinfo($file_target);
				$fileName = $fileinfo['basename'];   
				$file = $this->_get_contents($file_target); 
				if(!is_dir($file_dir)){
					mkdir($file_dir,0777,true);
					chmod($file_dir,0777); 
				} 
				file_put_contents($file_dir.'/'.$fileName,$file);
			//return $file_dir.'/'.$fileName; 
				$j++;
			} 
		} 
	}
	/**
	*** 解析文件函数
	*** $url_arr 文件数组，不带拓展名
	*** $type 文件类型 1：js 2: css 3: image
	*** 解析文件内容
	*/
	private function parseloadFile($url_arr,$type,$content)
	{
		
		$host_path = $this->host_path;
		$root_path = $this->root_path;
		$Dir = $this->root_dir;
		$root_http = $this->root_http;
		$op_true = false;
		if($type == 1){
			$extension_name = '.js';
			$file_dir = $this->_js;
			$op_true  = true;
		}elseif($type==2){
			$extension_name = '.css';
			$file_dir = $this->_css;
			$op_true  = true;
		}elseif($type ==3){
			$extension_name = '';
			$file_dir = $this->_image;
		}
		foreach($url_arr as $url)
		{
			
			$op = true;
			if(strpos($url,'http')!==false){
				$file_target = $url.$extension_name;
				$op = false;
				$front_web='';
			}elseif(substr($url,0,2)=='//'){
				$file_target =$root_http.':'.$url.$extension_name;
				$op = false;
				$front_web=$root_http.':';
			}else{
				$front_web=$root_path.'/';
			} 
			if($this->_web_down || $op_true){ 
				$fileinfo = pathinfo($url.$extension_name);
				$fileName = $fileinfo['basename'];
				$content = str_replace($url.$extension_name,$file_dir.'/'.$fileName,$content);
			}elseif($type ==3 && $op){  
				
				$content = str_replace($url.$extension_name,$front_web.$url.$extension_name,$content);
			} 
		}   
		return $content;
	}
	private function creatzip()
	{
		$Dir = $this->root_dir;
		$files = $this->list_dir($Dir.'/');
		$filename = $Dir.".zip"; //最终生成的文件名（含路径）   
		if(!file_exists($filename)){   
		//重新生成文件   
			$zip = new ZipArchive();//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释   
			if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) 
			{   
				exit('无法打开文件，或者文件创建失败');
			}   
			foreach( $files as $val){   
				if(file_exists($val)){   
					$zip->addFile( $val, str_replace($Dir.'/','',$val));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下   
				}   
			}   
			$zip->close();//关闭
		}
		return $filename;
	}
	//获取文件列表
	private function list_dir($dir){
			$result = array();
			if (is_dir($dir)){
				$file_dir = scandir($dir);
				foreach($file_dir as $file){
					if ($file == '.' || $file == '..'){
						continue;
					}
					elseif (is_dir($dir.$file)){
						$result = array_merge($result, $this->list_dir($dir.$file.'/'));
					}
					else{
						array_push($result, $dir.$file);
					}
				}
			}
			return $result;
	}	
   
}   
ini_set('max_execution_time', '500');
if(isset($_POST['url'])){
	$data['_css'] = $_POST['css'];
	$data['_js'] = $_POST['js'];
	$data['_image'] = $_POST['image'];
	$data['_picture'] = $_POST['picture'];
	
	$wrong = false; 
	foreach($data as $k=>$v){
		if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$v)){   
			$wrong=true;
		}
		if(empty(trim($v))){   
			$wrong=true;
		}
		
	}
	if(empty(trim($_POST['url']))){   
		$wrong=true;
	} 
	if(!preg_match('/^((http|ftp|https):\/\/)[\w-_\/\.%=\?]+(\/[\w-_%=\?]+)*\/?/',trim($_POST['url']))){ 
		$wrong=true; 
	} 
	if(!$wrong){
		$craw = new craw(trim($_POST['url']));
		
		foreach($data as $k=>$v){
			$craw->$k = $v;
		}
		if(isset($_POST['web_down']) && $_POST['web_down']){
			$craw->_web_down=true;
		}   
		$download = $craw->run();
		header('Location: ?file='.$download);
	}else{
		unset($_GET['file']);
	}
}
if(isset($_GET['file'])){
	$download = $_GET['file'];
	if(file_exists($download)){
		$first=1;
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
	<h4>webpage crawler</h4>
	<div class="contain">
		<form method="post">
			<div style="border-right:4px solid #fff;">
				<input name="url" type="text" placeholder="please input your the website" />
			</div>
			<input class="group" type="submit" value="submit"/>
			 <fieldset>
				<legend>default config</legend>
				<div class="form-group">
					<label>css Dir</label>
					<input name="css" type="text" placeholder="" value="css"/>
				</div>
				<div class="form-group">
					<label>js Dir</label>
					<input name="js" type="text" placeholder="" value="js"/>
				</div>
				<div class="form-group">
					<label>image Dir</label>
					<input name="image" type="text" placeholder="" value="image"/>
				</div>
				<div class="form-group">
					<label>css background Dir</label>
					<input name="picture" type="text" placeholder="" value="picture"/>
				</div>
				<label for="web_down" class="web_down">
					<input type="checkbox" id="web_down" name="web_down"  /><span>download web image</span>
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
