<?php
session_start();
require("common.php");
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'] ;
	if (isset($_SESSION['is_login'])) {
		//删除
		$sql="select * from mp3  where id = '$id' limit 1  "; 
		$result=mysql_query($sql)OR die("<br>读取数据库错误！<br>");
		if($row=mysql_fetch_array($result))
		{
			$delurl=$row['url'];
			$delname=basename($delurl);
			$res = delete_mp3($delname);
			if ($res['success'] == 1 ) {
				$sql="delete  from mp3  where id='$id'";
				mysql_query($sql);
				$success =1 ;
				$tips = "删除成功";
			}else{
				$success = 0  ;
				$tips = "删除失败";
			}

		}

	}else{
		$success = -1 ;
		$tips = "尚未登录";
	}

}

elseif ($_REQUEST['name']) {
	$name = $_REQUEST['name'] ; 
	$password = $_REQUEST['password'];
	if ($name == NAME && $password == PASSWORD) {
		$_SESSION['is_login'] = 1 ;
		$success = 1 ; 
		$tips = "验证成功";
	}else{
		$success = -1 ;
		$tips = "验证失败";
	}
}
echo json_encode(array("success"=>$success , "tips"=>$tips));
?>