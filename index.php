<?php
  require("common.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MP3音乐盘</title>
<LINK media=screen href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">
<link href="js/skins/default.css" rel="stylesheet" />
<style>
  boby{
    background-color: #EBF0EF;
  }
.hero-unit
  {
    position:absolute;
   
  }
#left-side
  {
    float:left;
    width:500px;
  }
#right-side
  {
    float:right;
    width:300px;
    padding-top:25px;
  }
  </style>
</head>
<body >
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <ul class="nav">
        <li class="active">
          <a href="./">首页</a>
        </li>
        <li><a href="list.php">已上传文件</a></li>
        <li><a href="http://blog.star7th.com" target="_blank">技术博客</a></li>
        <li ><a href="http://weibo.com/n33n" target="_blank">@第七星尘</a></li>
        </ul>
    </div>
  </div>
</div><!--  end navbar-->
<div class="container">
 <div class="hero-unit">
  <div id="left-side">
    <form id="local" enctype="multipart/form-data" method="post" name="form_upFile">
    <span id="uploadImg">
    <input type="file" name="f"  id="upFile"/>
      <input type="hidden" name="MAX_FILE_SIZE" value="10480000" />
     &nbsp;&nbsp;&nbsp;&nbsp;<input name="submit1" type="submit" value="开始上传" class="btn" onclick="form_upFile.submit()"/>
      </span>
    </form>
<?php
  require("upload.php");//上传处理文件
?> 
    <form action="" method="post" name="form_config" >
    <span>你可以在下面手动填写非本空间的MP3网络地址。
    <br>
    若上传文件的请保持系统的自动填写。</span>
      <table>
          <tr>
            <td>mp3网络地址：</td>
                <td><input name="mp3file" type="text" value="<?php if(isset($url)) echo $url?>" size="50"></td>
          </tr>
          <tr>
            <td>默认音量</td>
                <td><input  name="dewvolume" type="text" value="100" size="6">%</td>
          </tr>
          <tr>
            <td>播放控制</td>
                <td>
                  <input name="dewstart" type="radio" id="dewstart" value="1" checked="checked" /> 自动播放
                  <input name="dewstart" type="radio" id="dewstart" value="0" /> 手动播放

                </td>
          </tr>
          <tr>
            <td>是否循环</td>
                <td>
                    <input name="dewreplay" type="radio" value="1" checked="checked">循环播放
                    <input name="dewreplay" type="radio"  value="0" >不循环

                </td>
          </tr>
          <tr>
            <td><strong>播放器样式：</strong></td>
          </tr>
          <tr>
                <td>
                    <input type="radio"  name="dewversion" value="dewplayer" checked="checked"> 经典样式
               </td>
            <td>
                    <object type="application/x-shockwave-flash" data="dewplayer.swf" width="200" height="20" id="dewplayer"><param name="movie" value="dewplayer.swf" /></object>
                    <br>
              </td>

          </tr>
          <tr>
                <td>
                    <input type="radio"  name="dewversion" value="dewplayer_mini"> 迷你样式
               </td>
            <td>
        <object type="application/x-shockwave-flash" data="dewplayer_mini.swf?mp3=<?php echo $bgmusic?>&autostart=1&volume=100" width="160" height="20" id="dewplayer-mini"><param name="movie" value="dewplayer_mini.swf" /></object>
                    <br>
              </td>

          </tr>
          <tr><td><br><input type="button" class="btn" value="生成flash代码" onclick="create_code()"></td></tr>
      </table>
      
    </form>
  </div><!-- end left-side -->
  <div id="right-side">
    <ul class="nav nav-pills nav-stacked">
      <li>已上传的音乐：(可以直接点击使用)</li>
      <?php 
        $sql="select * from mp3  order by datetime desc limit 10";
        $result=mysql_query($sql)OR die("<br>读取数据库错误！<br>");
        if($num=mysql_num_rows($result))
        {
          while($row=mysql_fetch_array($result))
          {
                  echo "<li><a href=\"?url=".$row['url']."\">".$row['name']."</a></li>";
          }
        }
      ?>
      
  </ul>
      <p><a href="list.php">点击此处浏览更多...</a></p>
    </div>
</div>
</div><!--  end container-->
<script src="js/artDialog.min.js"></script>
<script >
function create_code()
{
    var weburl="<?php echo WEB_URL ;?>";
    var Mp3file = document.form_config.mp3file.value;
    var Volume= document.form_config.dewvolume.value;
     for (i = 0; i < document.getElementsByName("dewstart").length; i++)
      {
        if(document.getElementsByName("dewstart")[i].checked)
         {
           Autostart= document.getElementsByName("dewstart")[i].value;
        }
      }
     for (i = 0; i < document.getElementsByName("dewreplay").length; i++)
      {
        if(document.getElementsByName("dewreplay")[i].checked)
         {
           Autoreplay= document.getElementsByName("dewreplay")[i].value;
        }
      }  
     for (i = 0; i < document.getElementsByName("dewversion").length; i++)
      {
        if(document.getElementsByName("dewversion")[i].checked)
         {
           Dewversion = document.getElementsByName("dewversion")[i].value;
        }
      }
    var content=" <textarea cols=\"140\"  rows=\"4\" style=\"margin: 10px 10px 10px; width: 440px; height: 77px;\">"+weburl+"/"+Dewversion+".swf?mp3="+Mp3file+"&autostart="+Autostart+"&autoreplay="+Autoreplay+"&volume="+Volume+"</textarea><br>"+"请复制上面的代码到你所需要插入flash的地方，如论坛等。你也可以用浏览器<a href=\""+weburl+"/"+Dewversion+".swf?mp3="+Mp3file+"&autostart="+Autostart+"&autoreplay="+Autoreplay+"&volume="+Volume+"\" target=\"_bank\" >预览</a>";
        art.dialog({
        title: '成功生成代码！', 
        content: content
    });  
}
</script>
</body>
</html>