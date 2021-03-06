<?php
	include_once "util/login/restrito.php";
	restrito();
	//setcookie('pth_local', '207.244.177.140' ,time()+3600*24*30*12*5);
	//var_dump($_COOKIE);die;
?>
<!DOCTYPE html>
<html lang="en" ng-app="HageERP">
  <head>
    <meta charset="utf-8">
    <title>WebliniaERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
     <link rel='stylesheet prefetch' href='bootstrap/css/bootstrap.min.css'>

	<!-- Font Awesome -->
	<link href="css/font-awesome-4.1.0.min.css" rel="stylesheet">

	<!-- Pace -->
	<link href="css/pace.css" rel="stylesheet">

	<!-- Chosen -->
	<link href="css/chosen/chosen.min.css" rel="stylesheet"/>

	<!-- Tags Input -->
	<link href="css/ng-tags-input.min.css" rel="stylesheet"/>
	<link href="css/ng-tags-input.bootstrap.min.css" rel="stylesheet"/>
	
	<!-- Endless -->
	<link href="css/endless.min.css" rel="stylesheet">
	<link href="css/endless-skin.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<style type="text/css">
		.tab-content{
			overflow: visible !important;
			padding-bottom: 0 !important;
			border-right: none !important;
		}
		/* Fix for Bootstrap 3 with Angular UI Bootstrap */

		.modal {
			display: block;
		}

		/* Custom dialog/modal headers */

		.dialog-header-error { background-color: #d2322d; }
		.dialog-header-wait { background-color: #428bca; }
		.dialog-header-notify { background-color: #eeeeee; }
		.dialog-header-confirm { background-color: #333333; }
		.dialog-header-error span, .dialog-header-error h4,
		.dialog-header-wait span, .dialog-header-wait h4,
		.dialog-header-confirm span, .dialog-header-confirm h4 { color: #ffffff; }

		/* Ease Display */

		.pad { padding: 25px; }

		/*--------------------------------------*/
		.chosen-choices{
			border-bottom-left-radius: 4px;
			border-bottom-right-radius: 4px;
			border-top-left-radius: 4px;
			border-top-right-radius: 4px;
			font-size: 12px;
			border-color: #ccc;
		}
	</style>
  </head>

  <body class="overflow-hidden" ng-controller="Empreendimento_config-Controller" ng-cloak>
  	<!-- Overlay Div -->
	<div id="overlay" class="transparent"></div>

	<div id="wrapper" class="preload">
		<div id="top-nav" class="fixed skin-1">
			<a href="#" class="brand">
				<span>WebliniaERP</span>
				<span class="text-toggle"> Admin</span>
			</a><!-- /brand -->
			<button type="button" class="navbar-toggle pull-left" id="sidebarToggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<ul class="nav-notification clearfix">
				<?php include("alertas.php"); ?>
				<li class="profile dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<strong>{{ userLogged.nme_usuario }}</strong>
						<span><i class="fa fa-chevron-down"></i></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a class="clearfix" href="#">
								<img src="img/hage.png" alt="User Avatar">
								<div class="detail">
									<strong>{{ userLogged.nme_usuario }}</strong>
									<p class="grey" style="font-size: 7px;">{{ userLogged.end_email }}</p>
								</div>
							</a>
						</li>
						<li><a tabindex="-1" href="#" class="main-link"><i class="fa fa-inbox fa-lg"></i> {{ userLogged.nome_empreendimento }}</a></li>
						<li><a tabindex="-1" href="#" class="main-link"><i class="fa fa-list-alt fa-lg"></i> Meus Pedidos</a></li>
						<li class="divider"></li>
						<li><a tabindex="-1" class="main-link logoutConfirm_open" href="#logoutConfirm"><i class="fa fa-lock fa-lg"></i> Log out</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /top-nav-->

		<aside class="fixed skin-1">
			<div class="sidebar-inner scrollable-sidebar">
				<div class="size-toggle">
					<a class="btn btn-sm" id="sizeToggle">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<?php include("menu-bar-buttons.php"); ?>
				</div><!-- /size-toggle -->
				<div class="user-block clearfix">
					<img src="img/hage.png" alt="User Avatar">
					<div class="detail">
						<strong>{{ userLogged.nme_usuario }}</strong>
						<ul class="list-inline">
							<li><a href="#">{{ userLogged.nome_empreendimento }}</a></li>
						</ul>
					</div>
				</div><!-- /user-block -->

				<?php include_once('menu-modulos.php') ?>
				
			</div><!-- /sidebar-inner -->
		</aside>

		<div id="main-container">
			<div id="breadcrumb">
				<ul class="breadcrumb">
					<li><i class="fa fa-home"></i> <a href="dashboard.php">Home</a></li>
					<li><i class="fa fa-building-o"></i> Empreendimento</li>
					<li class="active"><i class="fa fa-cog"></i> Configurações</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-cog"></i> Configurações</h3>
				</div><!-- /page-title -->

			</div><!-- /main-header -->

			<div class="padding-md">
				<div class="alert alert-sistema" style="display:none"></div>
				<div class="row">
					<div class="col-sm-12">
						<a href="controle_nfe.php" ng-if="userLogged.id_empreendimento == 6" class="btn btn-sm btn-info" type="button">Controle NF-e</a>
						<a href="base_tributaria.php" class="btn btn-sm btn-info" type="button">Base Tributária</a>
						<a href="especializacao_ncm.php" class="btn btn-sm btn-info" type="button">Especialização NCM</a>
						<a href="regime_especial.php" class="btn btn-sm btn-info" type="button">Regime Especial</a>
						<a href="regra_tributos.php" class="btn btn-sm btn-info" type="button">Regra Tributos (NF-e)</a>
						<a href="regra_servico.php" class="btn btn-sm btn-info" type="button">Regra Tributos (NFS-e)</a>
						<a href="situacao_especial.php" class="btn btn-sm btn-info" type="button">Situação Especial</a>
						<a href="zoneamento.php" class="btn btn-sm btn-info" type="button">Zoneamento</a>
						<a href="operacao.php" class="btn btn-sm btn-info" type="button">Operações</a>
					</div>
				</div>
				<br/>
				<div class="panel panel-default" id="box-novo">
					<div class="panel-tab clearfix">
						<ul class="tab-bar">
							<li class="active"><a href="#basico" data-toggle="tab"><i class="fa  fa-star-o"></i> Dados Gerais</a></li>
							<li><a href="#loja" data-toggle="tab"><i class="fa fa-cloud"></i> Vitrine</a></li>
							<li><a href="#estoque" data-toggle="tab"><i class="fa fa-sitemap"></i> Estoque</a></li>
							<li><a href="#pdv" data-toggle="tab"><i class="fa fa-desktop"></i> PDV</a></li>
							<li><a href="#mesas" data-toggle="tab"><i class="fa fa-table"></i> Controle Mesas</a></li>
							<li><a href="#fiscal" data-toggle="tab"><i class="fa fa-barcode"></i> Fiscal</a></li>
							<li><a href="#notificacoes" data-toggle="tab"><i class="fa fa-bell"></i> Notificações</a></li>
							<li><a href="#mod_clinica" ng-if="userLogged.id_empreendimento == 75" data-toggle="tab"><i class="fa fa-list"></i> Controle de Atendimento</a></li>
							<li><a href="#pedido_personalizado" ng-if="userLogged.id_empreendimento == 51" data-toggle="tab"><i class="fa fa-list"></i> Pedidos Personalizados</a></li>
							<li><a href="#integracoes" data-toggle="tab"><i class="fa fa-code-fork"></i> Integrações</a></li>
							<!--<li><a href="#fiscal" data-toggle="tab"><i class="fa fa-barcode"></i> &nbsp;Fiscal</a></li>-->
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="basico">
								<form class="formEmprendimento" role="form" enctype="multipart/form-data">
									<div class="alert alert-basico-loja" style="display:none"></div>	
									
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group" id="nome_empreendimento">
												<label class="control-label">Nome</label>
												<input ng-model="empreendimento.nome_empreendimento" type="text"  class="form-control input-sm">
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group" id="nme_logo">
												<label class="control-label"><i class="fa fa-camera"></i> Logo</label>
												<div class="upload-file">
													<input  id="foto-produto" name="nme_logo"  class="foto-produto" type="file" data-file="produto.foto" accept="image/*" />
													<!-- <input ng-model=""   name="image" type="file" id="foto-produto" class="foto-produto" ng-model="fotoProduto"> -->
													<label data-title="Selecione" for="foto-produto">
														<span data-title="..."></span>
													</label>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-3">
											<div id="cnpj" class="form-group">
												<label class="control-label">CNPJ </label> 
												<input class="form-control" ui-mask="99.999.999/9999-99" ng-model="empreendimento.num_cnpj">
											</div>
										</div>
										<div class="col-sm-3">
											<div id="cnpj" class="form-group">
												<label class="control-label">Inscrição Municipal</label> 
												<input class="form-control" ng-model="empreendimento.num_inscricao_municipal">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6">
											<div id="nme_razao_social" class="form-group">
												<label class="control-label">Razão Social  </label>
												<input class="form-control" ng-model="empreendimento.nme_razao_social">
											</div>
										</div>
										<div class="col-sm-4">
											<div id="nme_fantasia" class="form-group">
												<label class="control-label">Nome Fantasia</label>
												<input class="form-control" ng-model="empreendimento.nme_fantasia">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<div class="table-responsive">
													<table class="table table-bordered table-condensed table-striped table-hover">
														<thead>
															<th width="200">Estado</th>
															<th>I.E.</th>
															<th>I.E ST</th>
															<td width="60" align="center">
																<button class="btn btn-xs btn-primary" ng-click="addIncricaoEstadual()"><i class="fa fa-plus-circle"></i></button>
															</td>
														</thead>
														<tbody>
															<tr ng-repeat="item in empreendimento.inscricoes_estaduais">
																<td>
																	<select chosen
																	    option="plano_contas"
																	    allow-single-deselect="true"
																	    ng-model="item.uf"
																	    ng-options="item.uf as item.nome for item in estados"">
																	</select>
																</td>
																<td><input type="text" ng-model="item.num_inscricao_estadual" class="form-control input-sm"></td>
																<td><input type="text" ng-model="item.num_inscricao_estadual_st" class="form-control input-sm"></td>
																<td class="text-center">
																	<button class="btn btn-xs btn-danger" ng-click="deleteInscricoesEstaduais($index)">
																		<i class="fa fa-trash-o"></i>
																	</button>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-2">
											<div id="cep" class="form-group">
												<label class="control-label">CEP </label>
												<input type="text" class="form-control" ui-mask="99999-999" ng-model="empreendimento.num_cep">
											</div>
										</div>

										<div class="col-sm-6">
											<div id="endereco" class="form-group">
												<label class="control-label">Endereço  </label>
												<input type="text" class="form-control" ng-model="empreendimento.nme_logradouro">
											</div>
										</div>

										<div class="col-sm-1">
											<div id="numero" class="form-group">
												<label class="control-label">N°. </label>
												<input id="num_logradouro" type="text" class="form-control" ng-model="empreendimento.num_logradouro" ng-blur="consultaLatLog()">
											</div>
										</div>

										<div class="col-sm-2">
											<div id="bairro" class="form-group">
												<label class="control-label">Bairro  </label>
												<input type="text" class="form-control" ng-model="empreendimento.nme_bairro_logradouro">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-2">
											<div id="id_estado" class="form-group">
												<label class="control-label">Estado  </label>
												<select id="id_select_estado" class="form-control" 
													ng-options="item.id as item.nome for item in estados"
													ng-model="empreendimento.cod_estado" 
													ng-change="loadCidadesByEstado(empreendimento.cod_estado)"></select>
											</div>
										</div>

										<div class="col-sm-4">
											<div id="id_cidade" class="form-group">
												<label class="control-label">Cidade <span ng-if="cidades.length == 0" style="color:#428bca"><i class='fa fa-refresh fa-spin'></i></span></label>
												<select class="form-control" ng-model="empreendimento.cod_cidade" ng-options="a.id as a.nome for a in cidades"></select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="pull-right">
												<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="update($event)" type="submit" class="btn btn-success btn-sm">
													<i class="fa fa-save"></i> Salvar
												</button>
											</div>
										</div>
									</div>
								</form>
							</div>

							<div class="tab-pane fade" id="loja">
								<form  role="form" enctype="multipart/form-data">
									<div class="alert alert-basico-loja" style="display:none"></div>	

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group" id="nickname">
												<label class="control-label">Nickname</label>
												<input ng-model="empreendimento.nickname"   type="text" class="form-control input-sm">
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group" id="end_email_contato">
												<label class="control-label">E-mail</label>
												<input ng-model="empreendimento.end_email_contato"  type="text" class="form-control input-sm parsley-validated">
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group" id="num_telefone">
												<label class="control-label">Telefone</label>
												<input ng-model="empreendimento.num_telefone"    type="text" class="form-control input-sm parsley-validated maskPorcentagem">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group" id="dsc_empreendimento">
												<label class="control-label">Descrição</label>
												<textarea ng-model="empreendimento.dsc_empreendimento" class="form-control" rows="5"></textarea>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group" id="url_facebook">
												<label class="control-label">Link do facebook</label>
												<input ng-model="empreendimento.url_facebook"  type="text" class="form-control input-sm parsley-validated">
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group" id="url_twitter">
												<label class="control-label">Link do Twitter</label>
												<input ng-model="empreendimento.url_twitter"    type="text" class="form-control input-sm parsley-validated maskPorcentagem">
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group" id="url_google_plus">
												<label class="control-label">Link do Google Plus</label>
												<input ng-model="empreendimento.url_google_plus"    type="text" class="form-control input-sm parsley-validated maskPorcentagem">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group" id="url_linkedin">
												<label class="control-label">Link do Linkedin</label>
												<input ng-model="empreendimento.url_linkedin"  type="text" class="form-control input-sm parsley-validated">
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group" id="url_pinterest">
												<label class="control-label">Link do Pinterest</label>
												<input ng-model="empreendimento.url_pinterest"    type="text" class="form-control input-sm parsley-validated maskPorcentagem">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="pull-right">
												<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="update($event)" type="submit" class="btn btn-success btn-sm">
													<i class="fa fa-save"></i> Salvar
												</button>
											</div>
										</div>
									</div>
								</form>
							</div>

							<div class="tab-pane fade" id="pdv">
								<div class="alert alert-danger alert-error-config" <?php echo isset($_COOKIE['pth_local']) ? 'style="display:none"' :  'style="display:block"' ?>>
									Para que sua <strong>frente de loja(PDV)</strong> possa funcionar correntamente, preencha os campos abaixo, marcados em vermelho
								</div>

								<div class="alert alert-config" style="display:none"></div>

								<div class="row">
									<div class="col-sm-4" id="id_plano_caixa">
										<div class="input-group">
											<label class="control-label">Plano de Contas p/ Mov. de Caixa</label>
							            	<input ng-model="config.nome_plano_movimentacao" type="text" class="form-control input-sm">
							            	<div class="input-group-btn" style="top: 11px;">
							            		<button ng-click="modalPlanoContas('movimentacao')" tabindex="-1" class="btn btn-sm btn-primary" type="button"><i class="fa fa-code-fork"></i></button>
							            	</div>
							        	</div>
									</div>

									<div class="col-sm-4" id="id_plano_fechamento_caixa">
										<div class="input-group">
											<label class="control-label">Plano de Contas p/ Fech. de Caixa</label>
								            <input ng-model="config.nome_plano_fechamento" type="text" class="form-control input-sm">

								            <div class="input-group-btn" style="top: 11px;">
								            	<button ng-click="modalPlanoContas('fechamento')" tabindex="-1" class="btn btn-sm btn-primary" type="button"><i class="fa fa-code-fork"></i></button>
								            </div>
								        </div>
									</div>

									<div class="col-sm-4">
										<div class="form-group" id="pth_local"  >
											<label class="control-label">IP do Caixa</label>
											<input ng-model="config.pth_local"  type="text" class="form-control input-sm parsley-validated">
										</div>
									</div>
								</div>

								<div class="row" ng-show="userLogged.id_empreendimento == 75">
									<div class="col-sm-5">
										<div class="form-group" id="num_modelo_documento_fiscal">
											<label class="control-label">Plano de Conta p/ Pagamento a Profissional</label>
											<select chosen
											    option="plano_contas"
											    allow-single-deselect="true"
											    ng-model="configuracoes.id_plano_conta_pagamento_profissional"
											    ng-options="plano.id as plano.dsc_completa for plano in plano_contas">
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-5">
										<div class="form-group">
											<label for="" class="control-label">Emitir NF-e no PDV?</label>
											<div class="form-group">
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_emitir_nfe_pdv" value="1" name="flg_emitir_nfe_pdv"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Sim</span>
												</label>
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_emitir_nfe_pdv" value="0" name="flg_emitir_nfe_pdv"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Não</span>
												</label>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group" id="patch_socket_sat"  >
											<label class="control-label">URL WebSocket</label>
											<input ng-model="configuracoes.patch_socket_sat"  type="text" class="form-control input-sm parsley-validated">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group" id="num_cnpj_sw"  >
											<label class="control-label">CNPJ Software House</label>
											<input ng-model="configuracoes.num_cnpj_sw"  type="text" class="form-control input-sm parsley-validated">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-5">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label for="" class="control-label">Questionar manutenção dos preços ao concluir orçamentos?</label>
													<div class="form-group">
														<label class="label-radio inline">
															<input ng-model="configuracoes.flg_questionar_manutencao_precos_orcamento" value="1" name="flg_questionar_manutencao_precos_orcamento"   type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Sim</span>
														</label>
														<label class="label-radio inline">
															<input ng-model="configuracoes.flg_questionar_manutencao_precos_orcamento" value="0" name="flg_questionar_manutencao_precos_orcamento"   type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Não</span>
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-7" id="txt_sign_ac">
										<div class="form-group">
										  <label for="txt_sign_ac">Assinatura AC (Hash Base64):</label>
										  <textarea class="form-control" rows="5" ng-model="configuracoes.txt_sign_ac"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-5">
										<div class="form-group">
										 <label for="txt_sign_ac">Formas de Pagamento Disponíveis no PDV:</label>
										 	<div class="clearfix" ng-repeat="item in formas_pagamento_pdv">
												 <label class="label-checkbox inline">
													<input type="checkbox" ng-model="item.value"  ng-true-value="1" ng-false-value="0">
													<span class="custom-checkbox"></span>
													{{ item.descricao_forma_pagamento }}
												</label>
											</div>
										</div>
									</div>

									<div class="col-sm-5">
										<div class="form-group">
										 <label for="txt_sign_ac">Perfis disponíveis no cadastro rapido:</label>
										 	<div class="clearfix" ng-repeat="item in perfis">
												 <label class="label-checkbox inline">
													<input type="checkbox" ng-model="item.value"  ng-true-value="1" ng-false-value="0">
													<span class="custom-checkbox"></span>
													{{ item.nome }}
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group" id="pth_local"  >
											<label class="control-label">Cod. Identificador Balança</label>
											<input ng-model="configuracoes.cod_identificador_balanca"  type="text" class="form-control input-sm parsley-validated">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="pull-right">
											<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfig($event)" type="submit" class="btn btn-success btn-sm">
												<i class="fa fa-save"></i> Salvar
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="fiscal">
								<div class="panel-tab clearfix">
									<ul class="tab-bar">
										<li class="active"><a href="#nf" data-toggle="tab"><i class="fa fa-file-text-o"></i> Produtos</a></li>
										<li><a href="#nfe" data-toggle="tab"><i class="fa fa-columns"></i> Serviços</a></li>
									</ul>
								</div>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="nf">
										<br/>
										<div class="alert alert-config-fiscal" style="display:none"></div>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group" id="regimeTributario">
													<label class="ccontrol-label">Regime Tributario </label> 
													<select chosen ng-change="ClearChosenSelect('cod_regime_tributario')"
												    option="regimeTributario"
												    allow-single-deselect="true"
												    ng-model="empreendimento.cod_regime_tributario"
												    no-results-text="'Nenhum valor encontrado'"
												    ng-options="regimeTributario.cod_controle_item_nfe as regimeTributario.nme_item for regimeTributario in regimeTributario">
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group" id="regimePisCofins">
													<label class="ccontrol-label">Regime Pis Cofins  </label> 
													<select chosen ng-change="ClearChosenSelect('cod_regime_pis_cofins')"
												    option="regimePisCofins"
												    allow-single-deselect="true"
												    no-results-text="'Nenhum valor encontrado'"
												    ng-model="empreendimento.cod_regime_pis_cofins"
												    ng-options="regime.cod_controle_item_nfe as regime.nme_item for regime in regimePisCofins">
													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group" id="tipoEmpresaeso">
													<label class="ccontrol-label">Tipo da Empresa</label> 
													<select chosen ng-change="ClearChosenSelect('cod_tipo_empresa')"
												    option="tipoEmpresa"
												    allow-single-deselect="true"
												    no-results-text="'Nenhum valor encontrado'"
												    ng-model="empreendimento.cod_tipo_empresa"
												    ng-options="regime.cod_controle_item_nfe as regime.nme_item for regime in tipoEmpresa">
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group" id="zoneamento">
													<label class="ccontrol-label">Zoneamento</label> 
													<select chosen ng-change="ClearChosenSelect('cod_zoneamento')"
												    option="zoneamentos"
												    allow-single-deselect="true"
												    no-results-text="'Nenhum valor encontrado'"
												    ng-model="empreendimento.cod_zoneamento"
												    ng-options="zoneamento.cod_zoneamento as zoneamento.dsc_zoneamento for zoneamento in zoneamentos">
													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group" id="vlr_custo">
													<label class="control-label">% Crédito Simples</label>
													<input  ng-model="empreendimento.num_percentual_credito_simples" thousands-formatter class="form-control input-sm">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="" class="control-label">Contribuinte ICMS?</label>
													<div class="form-group">
														<label class="label-radio inline">
															<input ng-model="empreendimento.flg_contribuinte_icms" value="0" type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Não</span>
														</label>

														<label class="label-radio inline">
															<input ng-model="empreendimento.flg_contribuinte_icms" value="1" type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Sim</span>
														</label>
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													<label for="" class="control-label">Contribuinte IPI?</label>
													<div class="form-group">
														<label class="label-radio inline">
															<input ng-model="empreendimento.flg_contribuinte_ipi" value="0" type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Não</span>
														</label>

														<label class="label-radio inline">
															<input ng-model="empreendimento.flg_contribuinte_ipi" value="1" type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Sim</span>
														</label>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-show="editing">
											<div class="col-sm-12">
												<div class="empreendimentos form-group" id="produto_cliente">
													<table class="table table-bordered table-condensed table-striped table-hover">
														<thead>
															<tr>
																<td colspan="3">
																	<strong>Regime Especial</strong> <i ng-click="showModalRegimeEspecial()" style="cursor:pointer;color: #9ad268;" class="fa fa-plus-circle fa-lg"></i>
																</td>
															</tr>
															<tr>
																<td>#</td>
																<td>Descrição</td>
																<td width="60" align="center">
																	
																</td>
															</tr>
														</thead>
														<tbody>
															<tr ng-show="(empreendimento.regime_especial.length == 0 && empreendimento.regime_especial != null)">
																<td colspan="3" align="center">Nenhum Regime Relacionado</td>
															</tr>
															<tr>
																<td colspan="3" class="text-center" ng-if="empreendimento.regime_especial == null">
																	<i class='fa fa-refresh fa-spin'></i> Carregando
																</td>
															</tr>
															<tr ng-repeat="item in empreendimento.regime_especial" bs-tooltip >
																<td>{{ item.cod_regime_especial }}</td>
																<td>{{ item.dsc_regime_especial }}</td>
																<td align="center">
																	<button class="btn btn-xs btn-danger" ng-disabled="itemEditing($index)" ng-click="delRegimeEspecial($index)" tooltip="excluir" title="excluir" data-toggle="tooltip"><i class="fa fa-trash-o"></i></button>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group" id="regimeTributario">
													<label class="ccontrol-label">Operação Padrão</label> 
													<select chosen
												    option="lista_operacao"
												    ng-model="configuracoes.id_operacao_padrao_venda"
												    ng-options="operacao.cod_operacao as operacao.dsc_operacao for operacao in lista_operacao">
													</select>
												</div>
											</div>

											<div class="col-sm-2">
												<div class="form-group" id="regimeTributario">
													<label class="ccontrol-label">Versão Tabela IBPT</label> 
													<select chosen
													    option="lista_versao_ibpt"
													    ng-model="configuracoes.num_versao_ibpt"
													    ng-options="item.versao as item.versao for item in lista_versao_ibpt">
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<form  role="form">
												<div class="col-sm-2">
													<div class="form-group" id="serie_documento_fiscal">
														<label class="control-label">Série</label>
														<input type="text" ng-model="serie_documento_fiscal.serie_documento_fiscal" class="form-control input-sm">
													</div>
												</div>

												<div class="col-sm-5">
													<div class="form-group" id="num_modelo_documento_fiscal">
														<label class="control-label">Modelo</label>
														<select chosen
														    option="chosen_modelo_nota_fiscal"
														    allow-single-deselect="true"
														    ng-model="serie_documento_fiscal.num_modelo_documento_fiscal"
														    ng-options="modelo.num_item as modelo.descricao for modelo in chosen_modelo_nota_fiscal">
														</select>
													</div>
												</div>

												<div class="col-sm-3" id="num_ultimo_documento_fiscal">
													<div class="form-group">
														<label class="control-label">Último Número Utilizado</label>
														<input ng-model="serie_documento_fiscal.num_ultimo_documento_fiscal" type="text" class="form-control input-sm">
													</div>
												</div>

												<div class="col-sm-1">
													<div class="form-group">
														<label class="control-label"><br></label>
														<button  ng-if="edit_serie_documento_fiscal == false" ng-click="incluirSerieDocumentoFiscal($event)" type="button" class="btn btn-sm btn-primary" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde...">
															<i class="fa fa-plus-circle" ></i> Incluir
														</button>
														<button  ng-if="edit_serie_documento_fiscal" ng-click="incluirSerieDocumentoFiscal($event)" type="button" class="btn btn-sm btn-primary" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde...">
															<i class="fa fa-edit"></i> Incluir Alterações
														</button>
													
													</div>
												</div>
											</form>
										</div>

										<div class="row">
											<div class="col-sm-8">
												<div class="form-group">
													<div class="table-responsive">
														<table class="table table-bordered table-condensed table-striped table-hover">
															<thead>
																<th>Série</th>
																<th>Documento</th>
																<th width="30%">Últ. Número Utilizado</th>
																<th width="60"></th>
															</thead>
															<tbody>
																<tr ng-repeat="item in lista_serie_documento_fiscal" ng-if="item.flg_excluido != 1">
																	<td class="text-middle">{{item.serie_documento_fiscal}}</td>
																	<td class="text-middle">{{item.num_modelo_documento_fiscal}} - {{item.dsc_modelo_documento_fiscal}}</td>
																	<td class="text-middle">{{item.num_ultimo_documento_fiscal}}</td>
																	<td class="text-center text-middle">
																		<button ng-disabled="index_edit_serie_documento_fiscal == $index" ng-click="editSerieDocumentoFiscal($index,item)" type="button" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
																		<button ng-disabled="index_edit_serie_documento_fiscal == $index" ng-click="delSerieDocumentoFiscal($index)" type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
																	</td>
																</tr>
																<tr>
																	<td colspan="4" class="text-center" ng-if="lista_serie_documento_fiscal.length == 0">
																		Nenhum item encontrado
																	</td>
																</tr>
																<tr>
																	<td colspan="4" class="text-center" ng-if="lista_serie_documento_fiscal.length == null">
																		<i class='fa fa-refresh fa-spin'></i> Carregando...
																	</td>
																</tr>
																
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-5">
												<div class="form-group">
													<label class="ccontrol-label">Modelo Documento/Série Padrão p/ NFC-e</label> 
													<select chosen
													    option="lista_serie_documento_fiscal"
													    ng-model="configuracoes.id_serie_padrao_nfce"
													    ng-options="serie.id as (serie.serie_documento_fiscal+' - '+serie.dsc_modelo_documento_fiscal) for serie in lista_serie_documento_fiscal">
													</select>
												</div>
											</div>

											<div class="col-sm-5">
												<div class="form-group">
													<label class="ccontrol-label">Modelo Documento/Série Padrão p/ NF-e</label> 
													<select chosen
													    option="lista_serie_documento_fiscal"
													    ng-model="configuracoes.id_serie_padrao_nfe"
													    ng-options="serie.id as (serie.serie_documento_fiscal+' - '+serie.dsc_modelo_documento_fiscal) for serie in lista_serie_documento_fiscal">
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label for="" class="control-label">Ambiente de Emissão da NF-e</label>
													<div class="form-group">
														<label class="label-radio inline">
															<input ng-model="configuracoes.flg_ambiente_nfe" value="1" name="flg_ambiente_nfe"   type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Produção</span>
														</label>
														<label class="label-radio inline">
															<input ng-model="configuracoes.flg_ambiente_nfe" value="0" name="flg_ambiente_nfe"   type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Homologação</span>
														</label>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group" id="serie_documento_fiscal">
													<label class="control-label">Token Produção</label>
													<input type="text" ng-model="configuracoes.token_focus_producao" class="form-control input-sm">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group" id="serie_documento_fiscal">
													<label class="control-label">Token Homologação</label>
													<input type="text" ng-model="configuracoes.token_focus_homologacao" class="form-control input-sm">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="pull-right">
													<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigFiscal($event)" type="submit" class="btn btn-success btn-sm">
														<i class="fa fa-save"></i> Salvar
													</button>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="nfe">
										<br/>
										<div class="alert alert-config-fiscal-servico" style="display:none"></div>
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<div class="table-responsive">
														<table class="table table-bordered table-condensed table-striped table-hover">
															<thead>
																<th width="200">Estado</th>
																<th width="200">Municipio</th>
																<th>Regra</th>
																<td width="60" align="center">
																	<button class="btn btn-xs btn-primary" ng-click="addRegraServico()"><i class="fa fa-plus-circle"></i></button>
																</td>
															</thead>
															<tbody>
																<tr ng-repeat="item in regras_servico_padrao">
																	<td>
																		<select chosen
																		    option="plano_contas"
																		    allow-single-deselect="true"
																		    ng-model="item.cod_estado"
																		    ng-change="loadCidadesByEstado(item.cod_estado,item)"
																		    ng-options="estado.id as estado.nome for estado in estados"">
																		</select>
																	</td>
																	<td>
																		<select chosen
																		    option="plano_contas"
																		    allow-single-deselect="true"
																		    ng-model="item.cod_municipio"
																		    ng-change="loadRegrasServico(item)"
																		    ng-options="municipio.id as municipio.nome for municipio in cidades"">
																		</select>
																	</td>
																	<td>
																		<select chosen
																		    option="plano_contas"
																		    allow-single-deselect="true"
																		    ng-model="item.cod_regra_servico"
																		    ng-options="regra.id as regra.nme_regra_servico for regra in item.regras"">
																		</select>
																	</td>
																	<td class="text-center">
																		<button class="btn btn-xs btn-danger" ng-click="deleteRegraServico($index)">
																			<i class="fa fa-trash-o"></i>
																		</button>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<div class="pull-right">
													<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigFiscalServico($event)" type="submit" class="btn btn-success btn-sm">
														<i class="fa fa-save"></i> Salvar
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="notificacoes">
								<form  role="form">
								<div class="alert alert-config-not" style="display:none"></div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="control-label">Emails para notificações</label>
											<tags-input
											 ng-model="notEmails"
											 allowed-tags-pattern="^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}"
											  placeholder="Add email" >
											</tags-input>
										</div>
									</div>
								</div>
								</form>
								<div class="row">
									<div class="col-sm-12">
										<div class="pull-right">
											<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigNotificacoes($event)" type="submit" class="btn btn-success btn-sm">
												<i class="fa fa-save"></i> Salvar
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="mod_clinica">
								<div class="alert alert-config-atendimento" style="display:none"></div>
								<div class="row" ng-show="userLogged.id_empreendimento == 75">
									<div class="col-sm-5">
										<div class="form-group" id="num_modelo_documento_fiscal">
											<label class="control-label">Plano de conta para pagamento a profissional</label>
											<select chosen
											    option="plano_contas"
											    allow-single-deselect="true"
											    ng-model="configuracoes.id_plano_conta_pagamento_profissional"
											    ng-options="plano.id as plano.dsc_completa for plano in plano_contas">
											</select>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="form-group">
											<label for="" class="control-label">Controlar tempo de atendimento?</label>
											<div class="form-group">
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_controlar_tempo_atendimento" value="1" name="flg_controlar_tempo_atendimento"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Sim</span>
												</label>
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_controlar_tempo_atendimento" value="0" name="flg_controlar_tempo_atendimento"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Não</span>
												</label>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="pull-right">
											<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigAtendimento($event)" type="submit" class="btn btn-success btn-sm">
												<i class="fa fa-save"></i> Salvar
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="mesas">
								<div class="alert alert-config-mesas" style="display:none"></div>
								<div class="row">
									<div class="col-sm-5">
										<div class="form-group">
											<label class="control-label">Modelo de Impressora</label>
											<select chosen
										    	option="impressoras"
										    	ng-model="configuracoes.printer_model_op"
										    	ng-options="item.value as item.dsc for item in impressoras">
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="pull-right">
											<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigControleMesas($event)" type="submit" class="btn btn-success btn-sm">
												<i class="fa fa-save"></i> Salvar
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="pedido_personalizado">
								<div class="alert alert-config-pedido-personalizado" style="display:none"></div>
								<div class="row">
									<div class="col-sm-4">
										<table class="table table-condensed table-bordered">
											<thead>
												<tr>
													<th class="text-center" colspan="3" >INFANTIL</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th class="text-left" colspan="3" style="background: #f9f9f9">
														<table class="table table-condensed table-bordered" style="margin-bottom: 0;">
															<thead>
																<tr>
																	<th class="text-left" colspan="2" >TAMANHOS</th>
																</tr>
																<tr>
																	<th class="text-center">DE</th>
																	<th class="text-center">ATÉ</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th><input ng-model="valoresChinelos.infantil.tamanhos.de" style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center"></th>
																	<th><input ng-model="valoresChinelos.infantil.tamanhos.ate" style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center"></th>
																</tr>
															</tbody>
														</table>
													</th>
												</tr>
												<tr>
													<th class="text-left" colspan="3"  style="background: #f9f9f9">
														<table class="table table-condensed table-bordered" style="margin-bottom: 0;">
															<thead>
																<tr>
																	<th class="text-left" colspan="3" >
																		FAIXAS
																		<i ng-click="incluirFaixa('infantil')"  style="cursor:pointer;color: #9ad268;float: right;margin-top: 4px;" class="fa fa-plus-circle fa-lg"></i>
																	</th>
																</tr>
																<tr>
																	<th class="text-center">DE</th>
																	<th class="text-center">ATÉ</th>
																	<th class="text-center">VALOR</th>
																</tr>
															</thead>
															<tbody>
																<tr class="tr-hover" ng-repeat="item in valoresChinelos.infantil.faixas">
																	<th><input ng-model="item.de" style="width: 60px;margin: 0 auto;" class="form-control input-xs text-center"></th>
																	<th><input ng-model="item.ate" style="width: 60px;margin: 0 auto;" class="form-control input-xs text-center"></th>
																	<th>
																		<input ng-model="item.valor" thousands-formatter style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center">
																		<i ng-click="excluirFaixa('infantil',item)" style="cursor:pointer;position: absolute;position: absolute;margin-top: -18px;margin-left: 106px;display: none" class="fa fa-trash-o fa-xs text-danger"></i>
																	</th>
																</tr>
																<tr ng-if="valoresChinelos.infantil.faixas.length == 0">
																	<td colspan="3" class="text-center">Nenhuma faixa incluida</td>
																</tr>
															</tbody>
														</table>
													</th>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-sm-4">
										<table class="table table-condensed table-bordered">
											<thead>
												<tr>
													<th class="text-center" colspan="3" >ADULTO</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th class="text-left" colspan="3" style="background: #f9f9f9">
														<table class="table table-condensed table-bordered" style="margin-bottom: 0;">
															<thead>
																<tr>
																	<th class="text-left" colspan="2" >TAMANHOS</th>
																</tr>
																<tr>
																	<th class="text-center">DE</th>
																	<th class="text-center">ATÉ</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th><input ng-model="valoresChinelos.adulto.tamanhos.de" style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center"></th>
																	<th><input ng-model="valoresChinelos.adulto.tamanhos.ate" style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center"></th>
																</tr>
															</tbody>
														</table>
													</th>
												</tr>
												<tr>
													<th class="text-left" colspan="3"  style="background: #f9f9f9">
														<table class="table table-condensed table-bordered" style="margin-bottom: 0;">
															<thead>
																<tr>
																	<th class="text-left" colspan="3" >
																		FAIXAS
																		<i ng-click="incluirFaixa('adulto')"  style="cursor:pointer;color: #9ad268;float: right;margin-top: 4px;" class="fa fa-plus-circle fa-lg"></i>
																	</th>
																</tr>
																<tr>
																	<th class="text-center">DE</th>
																	<th class="text-center">ATÉ</th>
																	<th class="text-center">VALOR</th>
																</tr>
															</thead>
															<tbody>
																<tr class="tr-hover" ng-repeat="item in valoresChinelos.adulto.faixas">
																	<th><input ng-model="item.de" style="width: 60px;margin: 0 auto;" class="form-control input-xs text-center"></th>
																	<th><input ng-model="item.ate" style="width: 60px;margin: 0 auto;" class="form-control input-xs text-center"></th>
																	<th>
																		<input ng-model="item.valor" thousands-formatter style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center">
																		<i ng-click="excluirFaixa('adulto',item)" style="cursor:pointer;position: absolute;position: absolute;margin-top: -18px;margin-left: 106px;display: none" class="fa fa-trash-o fa-xs text-danger"></i>
																	</th>
																</tr>
																<tr ng-if="valoresChinelos.adulto.faixas.length == 0">
																	<td colspan="3" class="text-center">Nenhuma faixa incluida</td>
																</tr>
															</tbody>
														</table>
													</th>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-sm-4">
										<table class="table table-condensed table-bordered">
											<thead>
												<tr>
													<th class="text-center" colspan="3" >VALORES ADICIONAIS</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th class="text-left" colspan="3" style="background: #f9f9f9">
														<table class="table table-condensed table-bordered" style="margin-bottom: 0;">
															<tbody>
																<tr>
																	<td class="text-left">COR ADICIONAL (P/ PAR)</td>
																	<td><input ng-model="valoresChinelos.adicionais.cor_adicional" thousands-formatter style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center"></td>
																</tr>
																<tr>
																	<td class="text-left">CHINELO QUADRADO (P/ PAR)</td>
																	<td><input ng-model="valoresChinelos.adicionais.chinelo_quadrado" thousands-formatter style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center"></td>
																</tr>
																<tr>
																	<td class="text-left">ACIMA DO TAM. 41 (P/ PAR)</td>
																	<td><input ng-model="valoresChinelos.adicionais.acima_41" thousands-formatter style="width: 80px;margin: 0 auto;" class="form-control input-xs text-center"></td>
																</tr>
															</tbody>
														</table>
													</th>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="pull-right">
											<button id="btn-pedido-personalizado" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigPedidoPersonalizado(valoresChinelos)" type="submit" class="btn btn-success btn-sm">
												<i class="fa fa-save"></i> Salvar
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="estoque">
								<div class="alert alert-config-estoque" style="display:none"></div>

								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<div class="input-group">
												<label class="control-label">Depósito Padrão</label>
								            	<input ng-model="configuracoes.deposito_padrao.nome_deposito" type="text" class="form-control input-sm">
								            	<div class="input-group-btn" style="top: 11px;">
								            		<button tabindex="-1" class="btn btn-sm btn-primary" type="button" ng-click="modalDepositos()">
								            			<i class="fa fa-sitemap"></i>
							            			</button>
								            	</div>
								        	</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="" class="control-label">Usar depósito padrão p/ estoque da Vitrine?</label>
											<div class="form-group">
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_deposito_padrao_vitrine" value="1" name="flg_deposito_padrao_vitrine"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Sim</span>
												</label>
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_deposito_padrao_vitrine" value="0" name="flg_deposito_padrao_vitrine"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Não</span>
												</label>
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label for="" class="control-label">Exibir produtos sem estoque na Vitrine?</label>
											<div class="form-group">
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_exibir_produtos_sem_estoque" value="1" name="flg_exibir_produtos_sem_estoque"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Sim</span>
												</label>
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_exibir_produtos_sem_estoque" value="0" name="flg_exibir_produtos_sem_estoque"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Não</span>
												</label>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="" class="control-label">Controlar validade nas Transferências entre Depósitos?</label>
											<div class="form-group">
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_controlar_validade_transferencia" value="1" name="flg_controlar_validade_transferencia"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Sim</span>
												</label>
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_controlar_validade_transferencia" value="0" name="flg_controlar_validade_transferencia"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Não</span>
												</label>
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label for="" class="control-label">Permitir realizar venda de produtos sem estoque?</label>
											<div class="form-group">
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_controlar_estoque" value="0" name="flg_controlar_estoque"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Sim</span>
												</label>
												<label class="label-radio inline">
													<input ng-model="configuracoes.flg_controlar_estoque" value="1" name="flg_controlar_estoque"   type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Não</span>
												</label>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<div class="pull-right">
											<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigDepositoPadrao($event)" type="submit" class="btn btn-success btn-sm">
												<i class="fa fa-save"></i> Salvar
											</button>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="integracoes">
								<div class="panel-tab clearfix">
									<ul class="tab-bar">
										<li class="active">
											<a href="#prestashop" data-toggle="tab">
												<i class="fa fa-shopping-cart"></i> PrestaShop
											</a>
										</li>
									</ul>
								</div>

								<div class="tab-content">
									<div class="tab-pane fade active in" id="prestashop">
										<br/>
										<div class="row pull-right">
											<div class="col-sm-2">
												<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="sincronizarDadosPrestaShop()" type="submit" class="btn btn-info btn-sm">
													<i class='fa fa-refresh'></i> Sincronizar
												</button>
											</div>
										</div>
										<div class="alert alert-config-prestashop" style="display:none"></div>
										<br/>
										<div class="row">
											<div class="col-sm-2">
												<div class="form-group">
													<label for="" class="control-label">Ativo</label>
													<div class="form-group">
														<label class="label-radio inline">
															<input ng-model="flg_integrar_prestashop" value="1" name="flg_integrar_prestashop"   type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Sim</span>
														</label>
														<label class="label-radio inline">
															<input ng-model="flg_integrar_prestashop" value="0" name="flg_integrar_prestashop"   type="radio" class="inline-radio">
															<span class="custom-radio"></span>
															<span>Não</span>
														</label>
													</div>
												</div>
											</div>

											<div class="col-sm-5">
												<div class="form-group" id="prestashop_ws_auth_key"  >
													<label class="control-label">WebService Auth Key</label>
													<input ng-model="configuracoes.prestashop_ws_auth_key" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>

											<div class="col-sm-5">
												<div class="form-group" id="prestashop_shop_path"  >
													<label class="control-label">URL Loja Virtual</label>
													<input ng-model="configuracoes.prestashop_shop_path" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group" id="prestashop_id_perfil_padrao"  >
													<label class="control-label">ID Perfil Padrão </label>
													<input ng-model="configuracoes.prestashop_id_perfil_padrao" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group" id="prestashop_depositos"  >
													<label class="control-label">Depositos </label>
													<input ng-model="configuracoes.prestashop_depositos" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group" id="prestashop_id_categoria_inicio"  >
													<label class="control-label">ID Categoria Inicial </label>
													<input ng-model="configuracoes.prestashop_id_categoria_inicio" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group" id="prestashop_id_attribute_group_cor"  >
													<label class="control-label">ID Atributo Cor </label>
													<input ng-model="configuracoes.prestashop_id_attribute_group_cor" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group" id="prestashop_id_attribute_group_tamanho"  >
													<label class="control-label">ID Atributo Tamanho </label>
													<input ng-model="configuracoes.prestashop_id_attribute_group_tamanho" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group" id="prestashop_id_usuario_padrao"  >
													<label class="control-label">ID Usuario Padrão </label>
													<input ng-model="configuracoes.prestashop_id_usuario_padrao" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group" id="prestashop_id_conta_bancaria_padrao"  >
													<label class="control-label">ID Conta Bancaria </label>
													<input ng-model="configuracoes.prestashop_id_conta_bancaria_padrao" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group" id="prestashop_id_plano_conta_padrao"  >
													<label class="control-label">ID Plano Padrão </label>
													<input ng-model="configuracoes.prestashop_id_plano_conta_padrao" 
														type="text" class="form-control input-sm parsley-validated">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<div class="table-responsive">
														<table class="table table-bordered table-condensed table-striped table-hover">
															<thead>
																<th>status webliniaErp</th>
																<th>Referencia PrestaShop</th>
															</thead>
															<tbody>
																<tr ng-repeat="item in status_venda">
																	<td>{{ item.dsc_status }}</td>
																	<td><input type="text" ng-model="item.referencias" 
																		class="form-control input-sm"></td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<div class="pull-right">
											<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigPrestaShop($event)" type="submit" class="btn btn-success btn-sm">
												<i class="fa fa-save"></i> Salvar
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /panel -->
				</div>
			</div>
		</div><!-- /main-container -->

		<!-- Modal plano  -->
		<div class="modal fade" id="modal-plano-contas" style="display:none">
  			<div class="modal-dialog error">
    			<div class="modal-content">
      				<div class="modal-header">
						<h4>Plano de contas</h4>
      				</div>

				    <div class="modal-body">
				    	<div class="alert alert-plano-contas" style="display:none"></div>

				    	<div class="row">
								<div class="col-sm-12" id="id_plano_conta">
									<div class="panel panel-default no-border">
										<div class="panel-body">
											<div id="blockTree" style="width: 100%; height: 100%; position: absolute; background-color: #000; display: none; opacity: 0.1; z-index: 100;"></div>

											<div id="tree"
												data-angular-treeview="true"
												data-tree-model="planoContas"
												data-node-id="id"
												data-node-label="nme_completo"
												data-node-children="children">
											</div>
										</div>
									</div>
								</div>
							</div>
				    	</div>

				    <div class="modal-footer">
				    	<button type="button" ng-disabled="currentNode == null" data-loading-text=" Aguarde..." class="btn btn-block btn-md btn-success"
				    		id="btn-aplicar-sangria" ng-click="escolherPlano()">
				    		<i class="fa fa-check-circle"></i> Escolher
				    	</button>

				    	<button type="button" data-loading-text=" Aguarde..."
				    		class="btn btn-block btn-md btn-default" ng-click="cancelarModal('modal-plano-contas')" id="btn-plano-contas">
				    		<i class="fa fa-times-circle"></i> Cancelar
				    	</button>
				    </div>
			  	</div>
			  	<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal depositos-->
		<div class="modal fade" id="modal-depositos" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Depositos</span></h4>
      				</div>

				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.depositos" ng-enter="loadDepositos(0,10)" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadDepositos(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>

						<br/>

				   		<div class="row">
				   			<div class="col-sm-12">
				   				<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(depositos.length != 0)">
										<tr>
											<th colspan="2">Nome</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(depositos.length == 0)">
											<td colspan="3">{{ busca_vazia.depositos  && 'Não há resultado para a busca' || 'Não há Depositos cadastrados' }}</td>
										</tr>
										<tr ng-repeat="item in depositos">
											<td>{{ item.nme_deposito }}</td>
											<td width="50" align="center">
												<button type="button" class="btn btn-xs btn-success" ng-click="addDeposito(item)">
													<i class="fa fa-check-square-o"></i> Selecionar
												</button>
											</td>
										</tr>
									</tbody>
								</table>
				   			</div>
				   		</div>

				   		<div class="row">
					    	<div class="col-sm-12">
					    		<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.depositos.length > 1">
									<li ng-repeat="item in paginacao.depositos" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadDepositos(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
					    	</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal empreendimento-->
		<div class="modal fade" id="list_empreendimentos" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Empreendimentos</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.empreendimento" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadAllEmpreendimentos(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>

						<br>

						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(empreendimento.length != 0)">
										<tr>
											<th colspan="2">Nome</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(empreendimentos.length == 0)">
											<td colspan="2">Não há empreendimentos cadastrados</td>
										</tr>
										<tr ng-show="(empreendimentos.length == null)" class="text-center">
											<td colspan="2"><i class='fa fa-refresh fa-spin'></i> Carregando...</td>
										</tr>
										<tr ng-repeat="item in empreendimentos">
											<td>{{ item.nome_empreendimento }}</td>
											<td width="50" align="center">
												<button type="button" class="btn btn-xs btn-success" ng-disabled="empreendimentoSelected(item)" ng-click="addEmpreendimento(item)">
													<i class="fa fa-check-square-o"></i> Selecionar
												</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="row">
				    		<div class="col-sm-12">
				    			<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.empreendimentos.length > 1">
									<li ng-repeat="item in paginacao.empreendimentos" ng-class="{'active': item.current}">
										<a href="" ng-click="loadAllEmpreendimentos(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
				    		</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->


		<!-- /Modal Processando Venda-->
		<div class="modal fade" id="modal-sincronizacao-prestashop" style="display:none">
  			<div class="modal-dialog error modal-md">
    			<div class="modal-content">
      				<div class="modal-header">
						<h4>Sincronizando dados com PrestaShop</h4>
      				</div>
				    <div class="modal-body">
				    	<div ng-if="modalSincronizacaoPrestashop.status == 'init'">
					    	<div class="row">
					    		<div class="col-sm-12" id="valor_pagamento">
					    			Iniciando sincronização <i class='fa fa-refresh fa-spin'></i>
								</div>
					    	</div>
				    	</div>
				    	<div ng-if="modalSincronizacaoPrestashop.status == 'in_progress'">
					    	<div class="row">
					    		<div class="col-sm-12" id="valor_pagamento">
					    			{{modalSincronizacaoPrestashop.executando_agora.mensagem}} <i class='fa fa-refresh fa-spin'></i>
								</div>
					    	</div>
					    	<div ng-show="modalSincronizacaoPrestashop.executando_agora.loading!=false" class="progress progress-striped" style="margin-top: 5px;margin-bottom: 5px;">
								<div class="progress-bar" style="width: {{modalSincronizacaoPrestashop.executando_agora.loading}}%;"></div>
							</div>
							<b  ng-show="modalSincronizacaoPrestashop.executando_agora.loading!=false" style="display: block;float: right;"> {{ modalSincronizacaoPrestashop.executando_agora.feito }} de {{ modalSincronizacaoPrestashop.executando_agora.qtd }}</b>
				    	</div>
				    	<div ng-if="modalSincronizacaoPrestashop.status == 'success'&& modalSincronizacaoPrestashop.error_validade == false">
					    	<div class="row">
					    		<div class="col-sm-12" >
					    			<div class="alert alert-success">
										<strong>Sucesso!</strong> todos os dados foram sincronizados.
									</div>
								</div>
					    	</div>
				    	</div>
				    	<div ng-if="modalSincronizacaoPrestashop.status == 'success'&& modalSincronizacaoPrestashop.error_validade == true">
					    	<div class="row">
					    		<div class="col-sm-12" >
					    			<div class="alert alert-warning">
										<strong>Atenção!</strong> Não foi possivel atualizar todos os dados, abaixo segue a lista
									</div>
								</div>
					    	</div>
					    	<div class="row">
					    		<div class="col-sm-12" >
					    			<div ng-repeat="(key, value) in modalSincronizacaoPrestashop.dados_sincronizados">
					    				<div ng-if="value.error_validade">
					    					<h5 class="text-center">------------------------------------------------<b> {{ key | uppercase }}</b> ------------------------------------------------</h5>
					    					<div ng-repeat="item  in value.error_validade"  style=" margin-bottom: 10px;">
					    						#{{ item.id }} - {{ item.nome }}<br/>
					    						<span ng-repeat="erro in item.errors" style="display:block;color:red">&nbsp;&nbsp;&nbsp;&nbsp;* {{ erro[0] }}</span>
					    					</div>
					    				</div>
					    			</div>	
								</div>
					    	</div>
				    	</div>
				    	<div ng-if="modalSincronizacaoPrestashop.status == 'error'">
					    	<div class="row">
					    		<div class="col-sm-12" >
					    			<div class="alert alert-danger">
										<strong>Erro!</strong> ocorreu um erro durante o processo.
									</div>
								</div>
					    	</div>
				    	</div>
				    </div>
			  	</div>
			  	<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->


		<!-- Footer
		================================================== -->
		<footer>
			<div class="row">
				<div class="col-sm-6">
					<span class="footer-brand">
						<strong class="text-danger">WebliniaERP</strong> Admin
					</span>
					<p class="no-margin">
						&copy; 2014 <strong>Weblinia Co.</strong> Todos os Direitos Reservados.
					</p>
				</div><!-- /.col -->
			</div><!-- /.row-->
		</footer>
	</div><!-- /wrapper -->

	<a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>

	<!-- Logout confirmation -->
	<?php include("logoutConfirm.php"); ?>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<!-- Jquery -->
	<script src="js/jquery-1.10.2.min.js"></script>

	<!-- Bootstrap -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

	<!-- Chosen -->
	<script src='js/chosen.jquery.min.js'></script>

	<!-- Jquery Form-->
	<script src='js/jquery.form.js'></script>

	<!-- Mask-input -->
	<script src='js/jquery.maskedinput.min.js'></script>
	<script src='js/jquery.maskMoney.js'></script>

	<!-- Datepicker -->
	<script src='js/bootstrap-datepicker.min.js'></script>

	<!-- Timepicker -->
	<script src='js/bootstrap-timepicker.min.js'></script>

	<!-- Slider -->
	<script src='js/bootstrap-slider.min.js'></script>

	<!-- Tag input -->
	<script src='js/jquery.tagsinput.min.js'></script>

	<!-- WYSIHTML5 -->
	<script src='js/wysihtml5-0.3.0.min.js'></script>
	<script src='js/uncompressed/bootstrap-wysihtml5.js'></script>

	<!-- Dropzone -->
	<script src='js/dropzone.min.js'></script>

	<!-- Modernizr -->
	<script src='js/modernizr.min.js'></script>

	<!-- Pace -->
	<script src='js/pace.min.js'></script>

	<!-- Popup Overlay -->
	<script src='js/jquery.popupoverlay.min.js'></script>

	<!-- Slimscroll -->
	<script src='js/jquery.slimscroll.min.js'></script>

	<!-- Cookie -->
	<script src='js/jquery.cookie.min.js'></script>

	<!-- Endless -->
	<script src="js/endless/endless_form.js"></script>
	<script src="js/endless/endless.js"></script>

	<!-- Mascaras para o formulario de produtos -->
	<script src="js/scripts/mascaras.js"></script>

	<!-- Chosen -->
	<script src='js/chosen.jquery.min.js'></script>

	<!-- UnderscoreJS -->
	<script type="text/javascript" src="bower_components/underscore/underscore.js"></script>

	<!-- Extras -->
	<script src="js/extras.js"></script>

	<!-- AngularJS -->
	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.tpl.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-ui-utils/mask.min.js"></script>
    <script src="js/angular-sanitize.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="js/dialogs.v2.min.js" type="text/javascript"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script src="js/angular-chosen.js"></script>
    <script src="js/ng-tags-input.min.js"></script>
    
    <script type="text/javascript">
    	var addParamModule = ['angular.chosen','ngTagsInput'] ;
    </script>
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js?version=<?php echo date("dmY-His", filemtime("js/angular-services/user-service.js")) ?>"></script>
	<script src="js/angular-controller/empreendimento_config-controller.js?version=<?php echo date("dmY-His", filemtime("js/angular-controller/empreendimento_config-controller.js")) ?>"></script>
	<script type="text/javascript">
		//$(".chzn-select").chosen();
		$('.foto-produto').change(function()	{
			var filename = $(this).val().split('\\').pop();
			$(this).parent().find('span').attr('data-title',filename);
			$(this).parent().find('label').attr('data-title','Trocar foto');
			$(this).parent().find('label').addClass('selected');
		});

		$('table').on('mouseenter','.tr-hover', function() {
			$('.fa-trash-o',this).show();
		});

		$('table').on('mouseleave','.tr-hover', function() {
		 	$('.fa-trash-o',this).hide();
		});
	</script>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
