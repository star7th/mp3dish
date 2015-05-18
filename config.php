<?php
/*
 *	配置信息
 *
 */


define('WEB_URL', 'http://wu.com/mp3dish/' ); //网址，末尾不加 / 
define('NAME', "admin" ) ; // 拥有删除MP3文件权限的管理员账号名
define('PASSWORD', "123456" ) ; // 管理密码


//若是SAE环境，请修改此配置。若不是则忽略。
define('SAE_DOMAIN', "mp3" ) ;//storage的domain名



//若是普通PHP环境，请修改此配置。若不是则忽略。
define('UPLOAD_DIR', "uploads" ) ;//mp3文件存放的目录名
define('PHP_DB_HOST', "localhost" ) ; //数据库地址
define('PHP_DB_USER', "root" ) ; //用户名
define('PHP_DB_PWD', "" ) ; //密码
define('PHP_DB_NAMW', "test" ) ; //数据库名
