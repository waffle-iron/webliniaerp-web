<?php
    @session_start();
    date_default_timezone_set('America/Sao_Paulo');
	function restrito($perfis = array(),$page=null){
		if(isset($_SESSION['user'])){
			if($_SESSION['user']['flg_teste'] == 1 && $_SESSION['user']['status_teste'] == false){
				include_once('dashboard_static.php');
				die;
			}
			
			if(!in_array($_SESSION['user']['id_perfil'], $perfis) && count($perfis) > 0){
				if($_SESSION['user']['id_perfil'] == 1)
					header('location:index.php');
				elseif($_SESSION['user']['id_perfil'] == 4 ||
						$_SESSION['user']['id_perfil'] == 5 ||
						$_SESSION['user']['id_perfil'] == 6 ||
						$_SESSION['user']['id_perfil'] == 7)
					header('location:'.$_SESSION['user']['nickname']);
				else
					header('location:produtos.php');
			}
		}else{
			header('location:login.php');
		}
	}
?>
