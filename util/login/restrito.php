<?php
	include_once 'util/constants.php';
    @session_start();
    date_default_timezone_set('America/Sao_Paulo');
	function restrito($perfis = array(),$page=null){
		$pages = getPages($_SESSION['user']['modulos']);
		if(isset($_SESSION['user'])){
			if($_SESSION['user']['flg_teste'] == 1 && $_SESSION['user']['status_teste'] == false){
				include_once('dashboard_static.php');
				die;
			}
			
			if(!in_array(PAGE, $pages)){
				include_once('acesso_negado.php');
				die;
			}
		}else{
			header('location:login.php');
		}
	}

	function getPages($modulos){
		$pages = array();
		foreach ($modulos as $key => $value) {
			$pages[] = $value['url_modulo'] ;
		}
		return $pages ;
	}
?>
