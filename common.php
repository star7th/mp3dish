<?php

require 'config.php';

//获得当前服务器环境
function get_environment(){
	if (defined('SAE_ACCESSKEY')) {
		return "sae";
	}
	elseif (defined('BAE')) {
		return "bae";
	}
	return "php";
}

require 'common_'.get_environment().".php";
