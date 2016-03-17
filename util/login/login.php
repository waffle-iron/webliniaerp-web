<?php
	include_once '../constants.php';
	function validaEmpreendimentoPeriodoTeste($id_empreendimento){
		$url = URL_API.'empreendimentos?id'.$id_empreendimento;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output  = curl_exec($ch);
		$info 	 = curl_getinfo($ch);
		curl_close ($ch);

		$saida     = array() ;
		$output    = json_decode($output,true);
		$output    = $output[0];
		$flg_teste = (int)$output['flg_teste'];
		
		if($flg_teste == 1){
			$dias_passados  = is_numeric($output['dias_passados']) && $output['dias_passados']   >= 0  ? (int)$output['dias_passados'] : false;
			$qtd_dias_teste = is_numeric($output['qtd_dias_teste']) && $output['qtd_dias_teste'] >= 0  ? (int)$output['qtd_dias_teste'] : false ;
			if($dias_passados && $qtd_dias_teste){
				if($dias_passados <= $qtd_dias_teste){
					$saida['flg_teste'] 			 = 1 ;
					$saida['status_teste'] 			 = true ;
					$saida['qtd_dias_teste']        = $dias_passados ;
					$saida['dias_passados_em_teste'] = $qtd_dias_teste ;
					$saida['dta_cadastro']           = $output['dta_cadastro'];
				}else{
					$saida['flg_teste'] 			 = 1   ;
					$saida['status_teste'] 			 = false ;
					$saida['qtd_dias_teste']        = $dias_passados ;
					$saida['dias_passados_em_teste'] = $qtd_dias_teste ;
					$saida['dta_cadastro']           = $output['dta_cadastro'] ;
				}
			}else{
				return false ;
			}
		}else{
			$saida['flg_teste'] 			 = 0   ;
			$saida['dta_cadastro']           = $output['dta_cadastro'] ;
		}
		return $saida ;
	}

	session_start();

	$url = URL_API.'logar';

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$senha = isset($_POST['senha']) ? $_POST['senha'] : "" ;
		$login = isset($_POST['login']) ? $_POST['login'] : "" ;

		$ch = curl_init();
		$url = $url;
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&senha=".$senha."");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output  = curl_exec($ch);
		$info 	 = curl_getinfo($ch);
		curl_close ($ch);


		if($info['http_code'] == 200){
			$_SESSION['user_emp'] = json_decode($output);
		}

		if($info['http_code'] == 406)
			header('Content-type: application/json');

		header("HTTP/1.1 ". $info['http_code'] ."");
		//http_response_code($info['http_code']);

		echo $output;
	}else if(isset($_GET['id_empreendimento']) && isset($_GET['nome_empreendimento'])  ){
		$saida = array();
		foreach ($_SESSION['user_emp'] as $key => $value) {
			$saida[$key] = $value;
		}
		$dados_teste = validaEmpreendimentoPeriodoTeste($_GET['id_empreendimento']);

		$saida['id_empreendimento']   = (int)$_GET['id_empreendimento'];
		$saida['nome_empreendimento'] = $_GET['nome_empreendimento'];
		$saida['nickname'] 		      = $_GET['nickname'];
		$saida['nme_logo'] 		      = $_GET['nme_logo'];
		if($dados_teste['flg_teste'] == 1){
			$saida['flg_teste']              = 1 ;
			$saida['status_teste']           = $dados_teste['status_teste'];
			$saida['qtd_dias_teste']         = $dados_teste['qtd_dias_teste'];
			$saida['dias_passados_em_teste'] = $dados_teste['dias_passados_em_teste'];
			$saida['dta_cadastro']           = $dados_teste['dta_cadastro'];
		}elseif ($dados_teste['flg_teste'] == 0) {
			$saida['flg_teste']              = 0 ;
			$saida['dta_cadastro']           = $dados_teste['dta_cadastro'];
		}else{
			header("HTTP/1.1 500");
		}

		$ch = curl_init();
		$url = $url;
		curl_setopt($ch, CURLOPT_URL,URL_API.'modulos/'.$saida['id_empreendimento'].'/'.$saida['id_perfil']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$modulos  = curl_exec($ch);
		$info 	 = curl_getinfo($ch);
		curl_close ($ch);

		if($info['http_code'] == 200) $saida['modulos'] = json_decode($modulos,true);
		else $saida['modulos'] = array();

		unset($_SESSION['user_emp']);
		$_SESSION['user'] = $saida;

	}else{
		header("HTTP/1.1 500");
		//http_response_code(500);
	}

?>
