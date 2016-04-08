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
					<a class="btn btn-sm pull-right logoutConfirm_open"  href="#logoutConfirm">
						<i class="fa fa-power-off"></i>
					</a>
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

				<div class="main-menu">
					<ul>
						<!-- Dashboard (index) -->
						<li>
							<a href="dashboard.php">
								<span class="menu-icon"><i class="fa fa-dashboard fa-lg"></i></span>
								<span class="text">Dashboard</span>
								<span class="menu-hover"></span>
							</a>
						</li>

						<!-- Módulos -->
						<li class="active openable">
							<a href="#">
								<span class="menu-icon"><i class="fa fa-th fa-lg"></i></span>
								<span class="text">Módulos</span>
								<span class="menu-hover"></span>
							</a>
							<ul class="submenu">
								<?php include("menu-modulos.php") ?>
							</ul>
						</li>

						<!-- Relatórios -->
						<li class="openable">
							<a href="#">
								<span class="menu-icon"><i class="fa fa-copy fa-lg"></i></span>
								<span class="text">Relatórios</span>
								<span class="menu-hover"></span>
							</a>
							<ul class="submenu">
								<?php include("menu-relatorios.php"); ?>
							</ul>
						</li>
					</ul>

					<!-- Exemplos de Alerta -->
					<!-- <div class="alert alert-info">Welcome to Endless Admin. Do not forget to check all my pages.</div>
					<div class="alert alert-danger">Welcome to Endless Admin. Do not forget to check all my pages.</div>
					<div class="alert alert-warning">Welcome to Endless Admin. Do not forget to check all my pages.</div> -->
				</div><!-- /main-menu -->
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
						<a href="regra_tributos.php" class="btn btn-sm btn-info" type="button">Regra Tributos</a>
						<a href="situacao_especial.php" class="btn btn-sm btn-info" type="button">Situação Especial</a>
						<a href="zoneamento.php" class="btn btn-sm btn-info" type="button">Zoneamento</a>
						<a href="operacao.php" class="btn btn-sm btn-info" type="button">Operações</a>
					</div>
				</div>
				<br/>
				<div class="panel panel-default" id="box-novo">
					<div class="panel-tab clearfix">
						<ul class="tab-bar">
							<li class="active"><a href="#basico" data-toggle="tab"><i class="fa  fa-star-o"></i> Dados Empreendimento</a></li>
							<li><a href="#loja" data-toggle="tab"><i class="fa fa-cloud"></i> Vitrine Virtual</a></li>
							<li><a href="#pdv" data-toggle="tab"><i class="fa fa-desktop"></i> PDV</a></li>
							<li><a href="#fiscal" data-toggle="tab"><i class="fa fa-barcode"></i> Fiscal</a></li>
							<li><a href="#notificacoes" data-toggle="tab"><i class="fa fa-bell"></i> Notificações</a></li>
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
											<div id="num_inscricao_estadual" class="form-group">
												<label class="control-label">I.E. </label>
												<input class="form-control" ng-model="empreendimento.num_inscricao_estadual">
											</div>
										</div>
										<div class="col-sm-3">
											<div id="num_inscricao_estadual_st" class="form-group">
												<label class="control-label">I.E ST </label>
												<input class="form-control" ng-model="empreendimento.num_inscricao_estadual_st">
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
												<select id="id_select_estado" class="form-control" ng-change="loadCidadesByEstado()"  ng-model="empreendimento.cod_estado" ng-options="item.id as item.nome for item in estados" ng-change="loadCidadesByEstado()"></select>
											</div>
										</div>

										<div class="col-sm-4">
											<div id="id_cidade" class="form-group">
												<label class="control-label">Cidade   <span ng-if="cidades.length == 0" style="color:#428bca"><i class='fa fa-refresh fa-spin'></i></span></label>
												<select class="form-control"  ng-model="empreendimento.cod_cidade" ng-options="a.id as a.nome for a in cidades"></select>
											</div>
										</div>
									
										
									</div>
									<div style="padding: 10px 15px 10px 0px; margin-bottom:10px" class="panel-heading">
								<i class="fa fa-barcode"></i>&nbsp; Dados Fiscais
							</div>
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
								<div class="col-sm-2">
									<div class="form-group" id="vlr_custo">
										<label class="control-label">% Credito Simples</label>
										<input  ng-model="empreendimento.num_percentual_credito_simples" thousands-formatter class="form-control input-sm">
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="" class="control-label">Contribuinte ICMS</label>
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
										<label for="" class="control-label">Contribuinte IPI</label>
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
											<label class="control-label">Plano para movimentação de caixa</label>
							            	<input ng-model="config.nome_plano_movimentacao" type="text" class="form-control input-sm">
							            	<div class="input-group-btn" style="top: 11px;">
							            		<button ng-click="modalPlanoContas('movimentacao')" tabindex="-1" class="btn btn-sm btn-primary" type="button"><i class="fa fa-code-fork"></i></button>
							            	</div>
							        	</div>
									</div>

									<div class="col-sm-4" id="id_plano_fechamento_caixa">
										<div class="input-group">
											<label class="control-label">Plano para fechamento de caixa</label>
								            <input ng-model="config.nome_plano_fechamento" type="text" class="form-control input-sm">

								            <div class="input-group-btn" style="top: 11px;">
								            	<button ng-click="modalPlanoContas('fechamento')" tabindex="-1" class="btn btn-sm btn-primary" type="button"><i class="fa fa-code-fork"></i></button>
								            </div>
								        </div>
									</div>

									<div class="col-sm-4">
										<div class="form-group" id="pth_local"  >
											<label class="control-label">IP do caixa</label>
											<input ng-model="config.pth_local"  type="text" class="form-control input-sm parsley-validated">
										</div>
									</div>
								</div>

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
								</div>
								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label for="" class="control-label">Emitir NF-e no pdv ?</label>
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
								<div class="alert alert-config-fiscal" style="display:none"></div>
								<div class="row">
									<div class="col-sm-3">
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
									<div class="col-sm-4">
										<div class="form-group" id="serie_documento_fiscal">
											<label class="control-label">Token Produção</label>
											<input type="text" ng-model="configuracoes.token_focus_producao" class="form-control input-sm">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group" id="serie_documento_fiscal">
											<label class="control-label">Token Homologação</label>
											<input type="text" ng-model="configuracoes.token_focus_homologacao" class="form-control input-sm">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group" id="regimeTributario">
											<label class="ccontrol-label">Operacao Padrão</label> 
											<select chosen
										    option="lista_operacao"
										    ng-model="configuracoes.id_operacao_padrao_venda"
										    ng-options="operacao.cod_operacao as operacao.dsc_operacao for operacao in lista_operacao">
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

										<div class="col-sm-2" id="num_ultimo_documento_fiscal">
											<div class="form-group">
												<label class="control-label">Últ. Número Utilizado</label>
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
									<div class="col-sm-4">
										<div class="form-group">
											<label class="ccontrol-label">Modelo Documento/Série Padrão p/ NFC-e</label> 
											<select chosen
											    option="lista_serie_documento_fiscal"
											    ng-model="configuracoes.id_serie_padrao_nfce"
											    ng-options="serie.id as (serie.serie_documento_fiscal+' - '+serie.dsc_modelo_documento_fiscal) for serie in lista_serie_documento_fiscal">
											</select>
										</div>
									</div>

									<div class="col-sm-4">
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
									<div class="col-sm-12">
										<div class="pull-right">
											<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde, salvando..." ng-click="salvarConfigFiscal($event)" type="submit" class="btn btn-success btn-sm">
												<i class="fa fa-save"></i> Salvar
											</button>
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
	</script>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
