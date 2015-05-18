<?php
//判断是否有GET传送地址过来
if(isset($_GET['url']))
{
   $url = $_GET['url'];
   echo "<p><font color=#009933><b>你使用的是已上传的MP3的地址。接着请设置播放器。<br>建议保留默认，直接点击最下方的生成按钮即可！</b></font></p>";
  }else{
  echo "<br><br>";
}
//上传文件
 if(isset($_FILES['f'])){
    $Filetype = substr(strrchr($_FILES['f']['name'],"."),1);      //获得扩展名。因考虑到不同浏览器问题，所以这里不严格地按照扩展名来判断了
    if($Filetype == "mp3" || $Filetype == "MP3" || $Filetype == "Mp3"){
		$onlyname = date('Ymj_His');
		$fileName = $onlyname.".".$Filetype;    //重新命名
		$filePath = $_FILES['f']['tmp_name'];
		//开始上传
		$mes = upload_mp3($filePath,$fileName);
		if($mes['success'] > 0 ){
			//写数据库
			$url= $mes['url'];
			$sql="insert into mp3 set name='".$_FILES['f']['name']."',size='".$_FILES['f']['size']."',datetime=NOW(),url='".$url."' ";
			mysql_query($sql)OR die("<br>写入数据库错误！<br>");
		}else{
			if (isset($mes['tips'])) {
				echo $mes['tips'] ;
			}else{
				echo '<font color=#FF0000>上传文件失败</font>';
			}
			
		}
	}else{
     	echo "<font color=#FF0000>只允许上传MP3文件</font>";
	 }
}

//设置背景音乐
if(isset($url))
{
	$bgmusic = $url;
}

?>