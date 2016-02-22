<?php
	if($_SERVER['SERVER_NAME'] == 'localhost'){
		define('URL_API','http://localhost:8080/webliniaerp-api/');
		define('URL_BASE','http://localhost:8080/webliniaerp-web/');
	}else{
		define('URL_API','http://'.$_SERVER['SERVER_NAME'].'/api/');
		define('URL_BASE','http://'.$_SERVER['SERVER_NAME'].'/');	
	}

	if(isset($_GET['nickname']))
	    define('NICKNAME',$_GET['nickname']);	
	else
		define('NICKNAME','');

	if(isset($_GET['template']) && $_GET['template'] != "")
	    define('TEMPLATE',$_GET['template']);	
	else
		define('TEMPLATE',"vitrine");	
?>