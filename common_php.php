<?php

/*
 *	公共操作
 *
 */

mysql_connect( PHP_DB_HOST ,PHP_DB_USER,PHP_DB_PWD);
mysql_select_db(PHP_DB_NAMW);//数据库名

function upload_mp3($filePath , $fileName){
	$ret = move_uploaded_file($filePath,UPLOAD_DIR.'/'.$fileName);
	if ($ret) {
		$result['url'] =  WEB_URL.'/'.UPLOAD_DIR.'/'.$fileName;
		$result['success'] = 1 ;
	}else{
		$result['success'] = -1 ;
	}
	return $result;
}

function delete_mp3($fileName){
	$ret = unlink(UPLOAD_DIR.'/'.$fileName);
	if ($ret) {
		$result['success'] = 1 ;
	}else{
		$result['success'] = -1 ;
	}
	return $result;
}
?>