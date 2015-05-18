<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>音乐列表</title>
</head>
<LINK media=screen href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">
<link href="js/skins/default.css" rel="stylesheet" />
<body>
<div class="navbar">
<div class="navbar-inner">
<div class="container">
  <ul class="nav">
    <li ><a href="./">首页</a></li>
    <li class="active"><a href="list.php">已上传文件</a></li>
    <li><a href="http://blog.star7th.com" target="_blank">技术博客</a></li>
    <li ><a href="http://weibo.com/n33n" target="_blank">@第七星尘</a></li>
    </ul>
</div>
</div>
</div><!--  end navbar-->
<div class="container">
  <div class="hero-unit">
	<div id="content_list">
	  <p><a href="./">回到首页</a></p>
	  
	    <?php 
			require("common.php");
			$sql="select count(*) from mp3 ";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$mp3_num = $row['count(*)'];

			$sql="select sum(size) from mp3 ";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$allsize = $row['sum(size)'];			

		?>
		<!--  搜索框-->
		<form class="well form-search" action="">
		  <input type="text" class="input-medium search-query" name="key_word">
		  <button type="submit" class="btn">Search</button>
		</form>
		<?php 
			//显示音乐列表.从数据库读取。
			$page_size=10;//每页显示记录数
			$current_page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;//第几页
			$from_record = ($current_page-1) * $page_size;
			$key_word = isset($_REQUEST['key_word']) ? $_REQUEST['key_word'] : '' ;
		    if($key_word)
		    	{
		    		$sql="select * from mp3  where name like '%$key_word%' order by datetime desc limit $from_record,$page_size";
		    	}else{

		    		$sql="select * from mp3  order by datetime desc limit $from_record,$page_size";
		    	}
			$result=mysql_query($sql)OR die("<br>读取数据库错误！<br>");
			if($num=mysql_num_rows($result))
			{
			   echo "<div id='list'><table class='table'><tr>";
			   echo "<td>序号</td><td>操作</td><td>文件名</td><td>文件大小</td><td>&nbsp;上传日期&nbsp;上传时间&nbsp;&nbsp;</td></tr>";
			   $id = 0 ;
			   while($row=mysql_fetch_array($result))
			   {
			   	  $size = number_format($row['size']/(1024*1024),2) ;
                  echo "<tr id='row_".$row['id']."'><td>".++$id."</td>";
                  echo '<td><a href='.$row['url'].'>下载</a>&nbsp;|<a href="javascript:delete_mp3('.$row['id'].')">&nbsp;删除</a>&nbsp;&nbsp;</td>';
				  echo "<td><a href=\"./?url=".$row['url']."\">".$row['name']."</a>&nbsp;&nbsp;</td>";
				  echo "<td>".$size."MB&nbsp;&nbsp;</td>";
				  echo "<td>".$row['datetime']."&nbsp;&nbsp;</td>";
				  echo "</tr>";
			  }
	 		 echo "本空间目前有".$mp3_num."首音乐，使用了".number_format($allsize/(1024*1024),2)."MB空间";
			  echo '<div>';
			 }
		?>
	  </p>
	</div>
<p>
<div class="page" >
<?php 
echo '<a href="?page='.($current_page+1).'" ><strong >下一页</strong></a>';
if($current_page>=2)
{
  echo '<a href="?page='.($current_page-1).'"style="margin-left:40px;"><strong>上一页</strong></a>';
  echo '<a href="?page=1" style="margin-left:40px;"><strong>返回第一页</strong></a>';
}

?>
</p>
</div>
   </div>
</div>
<div id="dialogContent" style="display:none">
	<p>账号：<input type="text" id="name"></p>
	<p>密码：<input type="text" id="password"></p>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id = "close_dialog">关闭</button>
    <button class="btn btn-primary" id="submit_dialog">确认</button>
  </div>
</div>
</body>
</html>
<script src="js/artDialog.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script>
function delete_mp3(id){
	$.post(
		"delete.php",
		{"id":id },
		function(data){
			if (data.success == 1 ) {
				alert("删除成功！");
				$("#row_"+id).hide();

			}
			else if (data.success == -1 ){
				art.dialog({
					title: '请先验证', 
					content: document.getElementById('dialogContent'),
				}); 
			}
		},
		"json"
	);


}

//关闭对话框
$("#close_dialog").click(function(){
	var list = art.dialog.list;
	for (var i in list) {
	    list[i].close();
	};
});

$("#submit_dialog").click(function(){
	var name = $("#name").val();
	var password = $("#password").val();
	$.post(
		"delete.php",
		{"name":name , "password":password },
		function(data){
			if (data.success == 1) {
				$("#dialogContent").html("验证成功，3秒后将关闭此对话框");
					setTimeout(function() {
					var list = art.dialog.list;
					for (var i in list) {
					    list[i].close();
					};

				}, 3000 );
			}
			else{
				alert(data.tips);
			}

		},
		"json"
	);

});
</script>