<?php
/*
 *	公共操作
 *
 */

//连接数据库

mysql_connect(SAE_MYSQL_HOST_M.":".SAE_MYSQL_PORT, SAE_MYSQL_USER,SAE_MYSQL_PASS)or die("无法连接到服务器: " . mysql_error());
mysql_select_db(SAE_MYSQL_DB) or die ('无法使用数据库 : ' . mysql_error());

function upload_mp3($filePath , $fileName){
	$stor = new SaeStorage();
    $stor->upload(SAE_DOMAIN ,$fileName,$filePath);
    $errmsg=$stor->errmsg();
    //var_export($errmsg);
    if($errmsg == 0){
    	$result['success'] = 1 ;
        $result['url'] =$stor->getUrl(SAE_DOMAIN,$fileName); 
    }else{
    	$result['success'] = -1 ;
    }
	return $result;
}

function delete_mp3($fileName){
	$stor = new SaeStorage();
	$stor->delete(SAE_DOMAIN ,$fileName);
    if($errmsg==0){
    	$result['success'] = 1 ;
    }else{
    	$result['success'] = -1 ;
    }
	return $result;
}
?>