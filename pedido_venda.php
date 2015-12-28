<?php
	include_once "util/login/restrito.php";
	restrito();
	date_default_timezone_set('America/Sao_Paulo');
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

	<!-- Datepicker -->
	<link href="css/datepicker.css" rel="stylesheet"/>

	<!-- Timepicker -->
	<link href="css/bootstrap-timepicker.css" rel="stylesheet"/>

	<!-- Endless -->
	<link href="css/endless.min.css" rel="stylesheet">
	<link href="css/endless-skin.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<style type="text/css">
		/*Redimencionando PopOver*/
		.popover-content {
			width: 200px;
		}
		/* Fix for Bootstrap 3 with Angular UI Bootstrap */

		.has-error-plano{
			border: 1px solid #b94a48;
			background: #E5CDCD;
		}

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

		@media screen and (min-width: 768px) {

			#list_proodutos.modal-dialog  {width:900px;}

		}

		#list_produtos .modal-dialog  {width:70%;}

		#list_produtos .modal-content {min-height: 640px;;}

		tr.tr-acessorio td {
   			 background-color: rgba(80, 79, 99, 0.23);
		}
		tr.tr-tira td {
   			 background-color: rgba(154, 210, 104, 0.54);
		}

		.tr-error-estoque{
			background-color: #FFB1B1;
		}		


	</style>
  </head>

  <body class="overflow-hidden" ng-controller="PedidoVendaController" ng-cloak>

	<div id="wrapper" class="preload">
		<div id="top-nav" class="fixed skin-6">
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

		<aside class="fixed skin-6">
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

				<!--<div class="search-block">
					<div class="input-group">
						<input type="text" class="form-control input-sm" placeholder="search here...">
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
						</span>
					</div>--><!-- /input-group -->
				<!--</div>--><!-- /search-block -->

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
					 <li class="active"><i class="fa fa-tag"></i> Pedidos Customizados</li>
				</ul>
			</div>
			<!-- breadcrumb -->
			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-tag"></i> Pedidos Customizados</h3>
					<br>
					<a class="btn btn-info" id="btn-novo" ng-if="receber_pagamento==false"  ng-click="showBoxNovo()"><i class="fa fa-plus-circle"></i> Novo Pedido</a>
				</div>
			</div>
			<!-- /main-header -->

			<div class="padding-md">
				<div class="alert alert-sistema" style="display:none"></div>

				<div class="panel panel-default" id="box-novo" style="display:none">
					<div class="panel-heading"><i class="fa fa-plus-circle"></i> {{ receber_pagamento == false && 'Novo Pedido' || 'Pagamento' }}</div>

					<div class="panel-body" ng-if="receber_pagamento==false">
						<form id="formProdutos" role="form" enctype="multipart/form-data">
								<div class="row">
						    			<div class="col-sm-12">
						    				<div class="form-group" id="id_cliente">
													<label class="control-label">Cliente</label>
													<div class="input-group">
														<input ng-click="selCliente(0,10)"  type="text" class="form-control" ng-model="cliente.nome" readonly="readonly" style="cursor: pointer;" />
														<span class="input-group-btn">
															<button ng-click="selCliente(0,10)" type="button" class="btn btn-info"><i class="fa fa-users"></i></button>
														</span>
													</div>
													
											</div>
						    			</div>
					    			</div>
							<div class="panel panel-default" ng-if="tela=='escolher_bases'">
								<div class="panel-heading">Base</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12">
											<table class="table table-condensed">
													<thead>
														<tr>
															<th width="80" style="background: #E8E8E8;">Cor</th>
															<th ng-repeat="tamanho in base.tamanhos" style="background: #E8E8E8;" class="text-center">
																{{ tamanho.nome_tamanho }}
															</th>														
														</tr>
													</thead>
												<tbody>
													<tr ng-repeat="produto in base.produtos">
														<td>{{ produto.nome_cor }}</td>
														<th ng-repeat="tamanho in produto.tamanhos" id="input-base-{{ produto.id_cor }}-{{tamanho.id_tamanho}}" >
															<input ng-keyup="calcularValorBase()" ng-disabled="tamanho.status==false"  onkeypress="return SomenteNumero(event);" ng-model="tamanho.qtd" type="text" style="width: 70px;margin: 0 auto;" align="center" class="text-center form-control input-xs ng-pristine ng-valid ng-touched" width="50">
														</th>	
													</tr>
												</tbody>
											</table>
										</div>	
									</div>	
								</div>
							</div>
							<!-- acessórios : background-color: rgba(80, 79, 99, 0.23) / tiras background-color: rgba(154, 210, 104, 0.54) -->
							<div class="panel panel-default" ng-if="tela == 'escolher_tiras'">
								<div class="panel-heading">Tiras</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12">
											<table class="table table-condensed">
												<tbody>	
													<tr ng-repeat-start="(key,item) in base_selecionadas" ng-if="item.qtd > 0">
														<td style="background: #E8E8E8;width: 90%;">
															{{item.nome_produto}} {{ item.nome_tamanho }} {{ item.nome_cor }} 
															<button class="btn btn-xs btn-success" ng-click="addTira($index,item)" type="button">Add Tiras</button>
															<button class="btn btn-xs btn-primary" ng-click="addAcessorio($index,item)" type="button">Add Acessórios</button>
														</td>	
														<td style="background: #E8E8E8;" class="text-center">{{item.qtd}}</td>
													</tr>
													<tr>
														<td ng-if=" item.tiras_acessorios.length == 0" class="text-center" colspan="2">Nenhuma tira selecionada</td>
													</tr>
													<tr ng-repeat-end ng-repeat="tira in item.tiras_acessorios" bs-tooltip>
														<td colspan="2">
															<table class="table table-condensed" style="margin-bottom: 0;">
																<tbody>	
																	<tr ng-class="{'tr-tira':tira.tipo_produto == 'tira', 'tr-acessorio': tira.tipo_produto == 'acessorio'}">
																		<td style="width: 35px;" class="text-center">
																			<button class="btn btn-xs btn-danger" ng-click="DeltiraAcessorio(key,$index)" type="button">
																				<i class="fa fa-trash-o fa-xs"></i>
																			</button>
																		</td>
																		<td style="width:87.5%;padding-left: 20px;">{{tira.nome_produto}} {{ tira.nome_tamanho }} {{ tira.nome_cor }}</td>	
																		<td style="" class="text-center">{{ tira.qtd }}</td>
																	</tr>
																</tbody>
															</table>
														</td>	
													</tr>							
												</tbody>
											</table>
										</div>	
									</div>
								</div>
							</div>
							<div class="panel panel-default" ng-if="tela == 'definir_valores'">
								<div class="panel-heading">Definir Valores</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-1">
											<div class="form-group">
												<label for="inputEmail1" class="col-lg-1 control-label">Desconto</label>
											</div>
										</div>
										<div class="col-md-2" style="width: 98px;padding-left: 0;">
											<div class="form-group" id="desconto-all">					
												<input thousands-formatter ng-model="view.desconto_all" class="form-control input-xs text-center">
											</div><!-- /form-group -->
										</div>	
										<div class="col-md-2" style="padding-left: 0;">
											<button  ng-click="aplicarDescontoAll()"type="submit" id="btn-salvar" class="btn btn-success btn-xs">
												Aplicar Desconto
											</button>
										</div>	
									</div>

									<div class="row">
										<div class="col-sm-12">
											<table class="table table-condensed">
												<tbody>	
													<thead>
														<tr>
															<th class="text-left" >Chinelo</th>
															<th class="text-center" >Qtd</th>
															<th class="text-center" style="width:100px">Desconto(%)</th>
															<th class="text-center" style="width:100px">Valor</th>
														</tr>
													</thead>
													<tr ng-repeat="item in chinelos_gerados">
														<td>{{ item.nome }}</td>
														<td class="text-center" >{{ item.qtd }}</td>
														<td class="text-center" >
															<input ng-keyUp="calcSubTotal('desconto')"  thousands-formatter ng-model="item.valor_desconto_cal" type="text" class="form-control text-center input-xs" />
														</td>	
														<td class="text-center" >
															<input   thousands-formatter ng-model="item.valor_real_item" type="text" class="form-control text-center input-xs" />
														</td>	
													</tr>	
													<tr>
														<td class="text-right" colspan="3"><strong>Total</strong></td>
														<td class="text-center" ng-bind-html="calTotalChinelos()">
															
														</td>
													</tr>			
												</tbody>
											</table>
										</div>	
									</div>
								</div>
							</div>


							<div class="row"  ng-if="tela=='escolher_bases'">
								<div class="col-sm-12">
									<div class="pull-right">
										<button ng-click="showBoxNovo(); reset();" type="submit" class="btn btn-danger btn-sm">
											<i class="fa fa-times-circle"></i> Cancelar
										</button>
										<button  ng-click="telaTiras(true)"type="submit" id="btn-salvar" class="btn btn-success btn-sm">
											<i class="fa fa-random"></i> Escolher Tiras
										</button>
									</div>
								</div>
							</div>

							<div class="row"  ng-if="tela == 'escolher_tiras'">
								<div class="col-sm-12">
									<div class="pull-right">
										<button ng-click="telaTiras(false)" type="submit" class="btn btn-warning btn-sm">
											<i class="fa fa-reply"></i> voltar
										</button>
										<button data-loading-text="Aguarde ... " ng-click="TelaDefinirPreco()"type="submit" id="btn-salvar" class="btn btn-success btn-sm">
											<i class="fa fa-save"></i> Definir Valores
										</button>
									</div>
								</div>
							</div>

							<div class="row"  ng-if="tela == 'definir_valores'">
								<div class="col-sm-12">
									<div class="pull-right">
										<button ng-click="telaTiras(true)" type="submit" class="btn btn-warning btn-sm">
											<i class="fa fa-reply"></i> voltar
										</button>
										<button type="button" class="btn btn-primary btn-sm" ng-if="receber_pagamento == false" ng-disabled="carrinho.length == 0" ng-click="telaPagamento()" disabled="disabled">
											<i class="fa fa-money"></i> Receber
										</button>
										<button data-loading-text="Aguarde ... " ng-click="salvar()"type="submit" id="btn-salvar" class="btn btn-success btn-sm">
											<i class="fa fa-save"></i> Salvar
										</button>
									</div>
								</div>
							</div>
						</form>
						</div>
					<div class="panel-body" ng-if="tela == 'receber_pagamento'">
							<div class="alert alert-pagamento" style="display:none"></div>
					    	<div class="row">
					    		<div class="col-sm-9">
					    		<div class="row" ng-if="pagamento_fulso">
					    			<div class="col-sm-12">
					    				<div class="form-group">
												<label class="control-label">Cliente</label>
												<div class="input-group">
													<input ng-click="selCliente(0,10)"  type="text" class="form-control" ng-model="cliente.nome" readonly="readonly" style="cursor: pointer;" />
													<span class="input-group-btn">
														<button ng-click="selCliente(0,10)" type="button" class="btn btn-info"><i class="fa fa-users"></i></button>
													</span>
												</div>
												
										</div>
					    			</div>
					    		</div>
					    		<div class="row">
					    			<div class="col-sm-12">
					    				<div class="form-group">
											<div style="font-weight: bold;font-size: 15px;" ng-if="cliente.vlr_saldo_devedor>0">
												<span style="color:#000">Saldo Devedor :</span> <span style="color:green">R$ {{ cliente.vlr_saldo_devedor | numberFormat:2:',':'.' }}</span>
											</div>
											<div style="font-weight: bold;font-size: 15px;" ng-if="cliente.vlr_saldo_devedor<0">
												<span style="color:#000">Saldo Devedor :</span> <span style="color:red">R$ {{ cliente.vlr_saldo_devedor | numberFormat:2:',':'.' }}</span>
											</div>
											<div style="font-weight: bold;font-size: 15px;" ng-if="cliente.vlr_saldo_devedor==0">
												<span style="color:#000">Saldo Devedor :</span> <span style="color:blue">R$ {{ cliente.vlr_saldo_devedor | numberFormat:2:',':'.' }}</span>
											</div>
											</div>
										</div>
					    		</div>
						    	<div class="row">
						    		<div class="col-sm-6" id="pagamento_forma_pagamento">
						    			<label class="control-label">Forma de Pagamento</label>
										<select ng-model="pagamento.id_forma_pagamento" ng-change="selectChange()" class="form-control input-sm">
											<option ng-if="pagamento.id_forma_pagamento != null" value=""></option>
											<option ng-repeat="item in formas_pagamento"  value="{{ item.id }}">{{ item.nome }}</option>
										</select>
									</div>
									<div class="col-sm-6" id="pagamento_valor" ng-if="pagamento.id_forma_pagamento == 7" >
										<label class="control-label">Vale troca</label>
										<div class="input-group">
											<input ng-click="showValeTroca()" thousands-formatter type="text" class="form-control input-sm" ng-model="pagamento.valor" readonly="readonly" style="cursor: pointer;" />
											<span class="input-group-btn">
												<button ng-click="showValeTroca()" type="button" class="btn btn-info btn-sm"><i class="fa fa-exchange"></i></button>
											</span>
										</div>
									</div>

									<div class="col-sm-2" id="pagamento_id_banco" ng-if="pagamento.id_forma_pagamento == 8">
										<div class="form-group" >
											<label class="control-label">Banco</label>
											<select ng-model="pagamento.id_banco" class="form-control">
												<option ng-repeat="banco in bancos" value="{{ banco.id }}">{{ banco.nome }}</option>
											</select>
										</div>
									</div>

									<div class="col-sm-2" id="pagamento_agencia_transferencia" ng-if="pagamento.id_forma_pagamento == 8">
						    			<label class="control-label">Agência</label>
						    			<div class="form-group ">
						    					<input ng-model="pagamento.agencia_transferencia"  type="text" class="form-control input-sm" />
						    			</div>
						    		</div>

						    		<div class="col-sm-2" id="pagamento_conta_transferencia" ng-if="pagamento.id_forma_pagamento == 8">
						    			<label class="control-label">Conta</label>
						    			<div class="form-group ">
						    					<input ng-model="pagamento.conta_transferencia"  type="text" class="form-control input-sm" />
						    			</div>
						    		</div>

						    		<div class="col-sm-6" id="pagamento_valor" ng-if="pagamento.id_forma_pagamento != 7 && pagamento.id_forma_pagamento != 8">
						    			<label class="control-label">Valor</label>
						    			<div class="form-group ">
						    					<input ng-disabled="pagamento.id_forma_pagamento == 2 || pagamento.id_forma_pagamento == 4" ng-model="pagamento.valor" thousands-formatter type="text" class="form-control input-sm" />
						    			</div>
						    		</div>
						    	</div>

						    	<div class="row">
						    		<div class="col-sm-6" id="pagamento_maquineta" ng-if="pagamento.id_forma_pagamento == 5 || pagamento.id_forma_pagamento == 6 ">
						    			<label class="control-label">Maquineta</label>
										<select ng-model="pagamento.id_maquineta" class="form-control input-sm">
											<option ng-repeat="item in maquinetas" value="{{ item.id_maquineta }}">#{{ item.id_maquineta }} - {{ item.dsc_conta_bancaria }}</option>
										</select>
									</div>
						    		<div class="col-sm-6" id="numero_parcelas" ng-if="pagamento.id_forma_pagamento == 6 || pagamento.id_forma_pagamento == 2 || pagamento.id_forma_pagamento == 4">
						    			<label class="control-label">parcelas</label>
						    			<div class="form-group ">
						    					<input ng-blur="pushCheques()" ng-focus="qtdCheque()" ng-model="pagamento.parcelas" type="text" class="form-control input-sm" >
						    			</div>
						    		</div>
						    		<div class="col-sm-4" id="proprietario_conta_transferencia" ng-if="pagamento.id_forma_pagamento == 8">
						    			<label class="control-label">Proprietário</label>
						    			<div class="form-group ">
						    					<input ng-model="pagamento.proprietario_conta_transferencia" type="text" class="form-control input-sm" />
						    			</div>
						    		</div>
						    		<div class="col-sm-4" id="pagamento_id_conta_transferencia_destino" ng-if="pagamento.id_forma_pagamento == 8 ">
						    			<label class="control-label">Conta de Destino</label>
										<select ng-model="pagamento.id_conta_transferencia_destino" class="form-control input-sm">
											<option ng-repeat="item in contas" value="{{ item.id }}">#{{ item.id }} - {{ item.dsc_conta_bancaria }}</option>
										</select>
									</div>
						    		<div class="col-sm-4" id="pagamento_valor" ng-if="pagamento.id_forma_pagamento == 8">
						    			<label class="control-label">Valor</label>
						    			<div class="form-group ">
						    					<input ng-model="pagamento.valor" thousands-formatter type="text" class="form-control input-sm" />
						    			</div>
						    		</div>
						    	</div>
						    	<div class="alert error-cheque" style="display:none"></div>
									<div class="row" ng-show="pagamento.id_forma_pagamento == 2" ng-repeat="item in cheques">
										<div class="col-sm-3">
											<div class="form-group cheque_data">
												<label class="control-label">Data</label>
												<div class="input-group">
													<input readonly="readonly" style="background:#FFF;cursor:pointer" ng-model="pagamento.data" type="text" id="pagamentoData" class="datepicker form-control chequeData">
													<span class="input-group-addon" class="cld_pagameto" ng-click="focusData($index)"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group cheque_valor">
												<label class="control-label">valor</label>
												<div class="form-group ">
						    						<input ng-blur="pushCheques()" ng-keyUp="calTotalCheque()"  thousands-formatter ng-model="item.valor_pagamento" type="text" class="form-control" >
						    					</div>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group cheque_banco" >
												<label class="control-label">Banco</label>
												<select ng-model="item.id_banco" class="form-control">
													<option ng-repeat="banco in bancos" value="{{ banco.id }}">{{ banco.nome }}</option>
												</select>
											</div>
										</div>

										<div class="col-sm-2">
											<div class="form-group cheque_cc">
												<label class="control-label">Núm. C/C</label>
												<input ng-model="item.num_conta_corrente" type="text" class="form-control">
											</div>
										</div>

										<div class="col-sm-2">
											<div class="form-group cheque_num">
												<label class="control-label">Núm. Cheque</label>
												<input ng-model="item.num_cheque" type="text" class="form-control">
											</div>
										</div>

										<div class="col-sm-1">
											<div class="row">
					    						<div class="col-sm-6">
													<label class="control-label"><br></label>
													<label class="label-checkbox">
														<input ng-model="item.flg_cheque_predatado" value="1" type="checkbox" id="toggleLine" ng-true-value="1" ng-false-value="0">
														<span class="custom-checkbox"></span>
														Pré?
													</label>
												</div>
												<div class="col-sm-6" ng-if="cheques.length > 1">
													<div class="form-group">
														<label class="control-label"><br></label>
														<label class="control-label">
															<i ng-click="delItemCheque($index)" class="fa fa-times-circle-o fa-lg" style="color: red;cursor:pointer"></i>
														</label>
													</div>
												</div>
											</div>
										</div>

									</div>
									<div class="row" ng-show="pagamento.id_forma_pagamento == 4" ng-repeat="item in boletos">
										<div class="col-sm-3">
											<div class="form-group boleto_data">
												<label class="control-label">Data</label>
												<div class="input-group">
													<input readonly="readonly" style="background:#FFF;cursor:pointer" ng-model="pagamento.data" type="text" id="pagamentoData" class="datepicker form-control boletoData">
													<span class="input-group-addon" class="cld_pagameto" ng-click="focusData($index)"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group boleto_valor">
												<label class="control-label">valor</label>
												<div class="form-group ">
						    						<input ng-blur="pushCheques()" ng-keyUp="calTotalBoleto()"  thousands-formatter ng-model="item.valor_pagamento" type="text" class="form-control" >
						    					</div>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group boleto_banco" >
												<label class="control-label">Banco</label>
												<select ng-model="item.id_banco" class="form-control">
													<option ng-repeat="banco in bancos" value="{{ banco.id }}">{{ banco.nome }}</option>
												</select>
											</div>
										</div>

										<div class="col-sm-2">
											<div class="form-group boleto_doc">
												<label class="control-label">Doc. Boleto</label>
												<input ng-model="item.doc_boleto" type="text" class="form-control">
											</div>
										</div>

										<div class="col-sm-2">
											<div class="form-group boleto_num">
												<label class="control-label">Núm. Boleto</label>
												<input ng-model="item.num_boleto" type="text" class="form-control">
											</div>
										</div>

										<div class="col-sm-1">
											<div class="row">
					    						<div class="col-sm-6">
													<label class="control-label"><br></label>
													<label class="label-checkbox">
														<input ng-model="item.status_pagamento" value="1" type="checkbox" id="toggleLine" ng-true-value="1" ng-false-value="0">
														<span class="custom-checkbox"></span>
														Pago?
													</label>
												</div>
												<div class="col-sm-6" ng-if="boletos.length > 1">
													<div class="form-group">
														<label class="control-label"><br></label>
														<label class="control-label">
															<i ng-click="delItemBoleto($index)" class="fa fa-times-circle-o fa-lg" style="color: red;cursor:pointer"></i>
														</label>
													</div>
												</div>
											</div>
										</div>

									</div>
					    		<div class="row">
					    			<div class="col-sm-12 text-center">
					    				<label class="control-label">&nbsp</label>
						    			<div class="form-group ">
						    				<button type="button" class="btn btn-md btn-success btn-block"   ng-click="aplicarRecebimento()">Receber</button>
						    			</div>
						    		</div>
								</div>
							</div>
							<div class="col-sm-3">
								<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(clientes.length != 0)">
										<tr>
											<th colspan="2" class="text-center">Recebidos</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-if="(recebidos.length == 0)">
											<td colspan="2">Não há nenhum pagamento recebido</td>
										</tr>
										<tr ng-repeat="item in recebidos">
											<td ng-if="item.id_forma_pagamento != 6 && item.id_forma_pagamento != 2 ">{{ item.forma_pagamento  }} <strong class="pull-right">R$ {{ item.valor | numberFormat:2:',':'.' }}</strong></td>
											<td ng-if="item.id_forma_pagamento == 6">C/C em {{item.parcelas}}x <strong class="pull-right">R$ {{ item.valor | numberFormat:2:',':'.' }}</strong></td>
											<td ng-if="item.id_forma_pagamento == 2">Cheque em {{ cheques.length }}x <strong class="pull-right">R$ {{ item.valor | numberFormat:2:',':'.' }}</strong></td>
											<td width="50" align="center">
												<button type="button" class="btn btn-xs btn-danger" ng-click="deleteRecebidos($index)">
													<i class="fa fa-times"></i>
												</button>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="background: #A2A2A2;">

											</td>
										</tr>
										<tr>
											<td colspan="2">
												Total Recebido <strong class="pull-right">R$ {{ total_pg | numberFormat:2:',':'.' }}</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" ng-if="total_pg <= vlrTotalCompra">
												Total a Receber <strong class="pull-right">R$ {{ vlrTotalCompra - total_pg | numberFormat:2:',':'.' }}</strong>
											</td>
											<td colspan="2" ng-if="total_pg > vlrTotalCompra" >
												Total a Receber <strong class="pull-right">R$ 0,00</strong>
											</td>
										</tr>
										<tr ng-if="modo_venda == 'pdv'">
											<td colspan="2">
												Troco <strong class="pull-right">R$ {{ troco | numberFormat:2:',':'.' }}</strong>
											</td>
										</tr>
										<tr ng-if="modo_venda == 'est' && (total_pg > vlrTotalCompra)">
											<td colspan="2">
												Troco sugerido<strong class="pull-right">R$ {{ ((vlrTotalCompra - total_pg) * (-1)) | numberFormat:2:',':'.' }}</strong>
											</td>
										</tr>
										<tr ng-if="modo_venda == 'est' && (total_pg > vlrTotalCompra)">
											<td colspan="2">
												<div class="row">
													<div class="col-sm-10">
														Troco
													</div>
													<div class="col-sm-2">
														  <input ng-model="troco_opcional" thousands-formatter class="form-control input-sm" >
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
								<div class="col-sm-12">
									<div class="pull-right">
										<button type="button" class="btn btn-sm btn-warning"  ng-click="cancelarPagamento()"><i class="fa fa-times-circle"></i> Cancelar Pagamento</button>
										<button ng-disabled="total_pg == 0 || total_pg < vlrTotalCompra" data-loading-text="Aguarde ... " ng-click="salvar()"type="submit" id="btn-salvar" class="btn btn-success btn-sm">
											<i class="fa fa-save"></i> Salvar
										</button>
												
									</div>
								</div>
						</div>
					</div>
					</div><!-- /panel -->
				<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-tasks"></i> Pedidos</div>
					<div class="panel-body">
						<div class="row" ng-if="false">
							<div class="col-sm-2">
								<div class="form-group">
									<label class="control-label">Data</label>
									<div class="input-group">
										<input readonly="readonly" style="background:#FFF;cursor:pointer" type="text" id="dtaInicial" class="datepicker form-control text-center">
										<span class="input-group-addon" id="cld_dtaInicial"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<label class="control-label">Vendedor</label>
								<div class="input-group">
									<input ng-click="selUsuario('vendedor')" type="text" class="form-control" ng-model="busca.ven_nome_vendedor" readonly="readonly" style="cursor: pointer;" />
									<span class="input-group-btn">
										<button ng-click="selUsuario('vendedor')"  type="button" class="btn"><i class="fa fa-user-md"></i></button>
									</span>
								</div>
							</div>
								<div class="col-sm-3">
								<label class="control-label">Cliente</label>
								<div class="input-group">
									<input ng-click="selUsuario('vendedor')" type="text" class="form-control" ng-model="busca.ven_nome_cliente" readonly="readonly" style="cursor: pointer;" />
									<span class="input-group-btn">
										<button ng-click="selUsuario('cliente')"  type="button" class="btn"><i class="fa fa-user"></i></button>
									</span>
								</div>
							</div>
							<div class="col-sm-1">
								<div class="form-group">
									<label class="control-label"><br></label>
									<button type="button" class="btn btn-sm btn-primary" ng-click="loadVendas(0,10)"><i class="fa fa-filter"></i> Filtrar</button>
								</div>
							</div>

							<div class="col-sm-1">
								<div class="form-group">
									<label class="control-label"><br></label>
									<button type="button" class="btn btn-sm btn-default" ng-click="limparBusca()">Limpar</button>
								</div>
							</div>

							<div class="col-sm-1" ng-if="false">
								<div class="form-group">
									<label class="control-label"><br></label>
								<buttom ng-click="buscaAvancada()" class="btn btn-sm btn-primary">Pequisa Avançada <i ng-show="busca_avancada==false" class="fa fa-sort-down"></i><i ng-show="busca_avancada" class="fa fa-sort-up"></i></buttom>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="alert alert-listagem" style="display:none"></div>
							</div>
							<div class="col-sm-12">
								<table class="table table-condensed table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th class="text-center" width="160">ID</th>
											<th class="text-center" width="160">Data</th>
											<th class="text-center">Vendedor</th>
											<th class="text-center">Cliente</th>
											<th class="text-center" width="160">status</th>
											<th class="text-center" width="100">Total</th>
											<th class="text-center" width="160">Ações</th>
										</tr>
									</thead>
									<tbody> 
										<tr ng-if="vendas.length == 0">
											<td colspan="7" class="text-center">
												Nenhum pedido encontrado	
											</td>
										</tr>
										<tr ng-repeat="item in vendas" bs-tooltip>
											<td class="text-center">{{ item.id }}</td>
											<td class="text-center">{{ item.dta_venda }}</td>
											<td>{{ item.nme_vendedor }}</td>
											<td>{{ item.nme_cliente }}</td>
											<td class="text-center">
												{{ item.pedido_finalizado == 1 &&  'Pedido Finalizado' || item.dsc_status }}
											</td>
											<td class="text-right">R$ {{ item.vlr_total_venda | numberFormat : '2' : ',' : '.'}}</td>
											<td class="text-center">

												<!--<a href="separar_venda.php?id_venda={{ item.id }}" ng-if="item.id_status_venda == 1" type="button" tooltip="Separar venda no estoque" data-toggle="tooltip" class="btn btn-xs btn-info">
													<i class="fa fa-th"></i>
												</a>-->

							
												<button type="button" ng-click="loadDetalhesPedido(item)" tooltip="Detalhes" data-toggle="tooltip" class="btn btn-xs btn-primary"  data-toggle="tooltip" title="Detalhes">
													<i class="fa fa-tasks"></i>
												</button>
												<button data-loading-text="<i class='fa fa-refresh fa-spin'>" type="button" ng-click="finalizaPedido($index,$event)" ng-if="item.pedido_finalizado == 0"  tooltip="Detalhes" data-toggle="tooltip" class="btn btn-xs btn-success"  data-toggle="tooltip" title="Finalizar Pedido">
													<i class="fa fa-check"></i>
												</button>
												<a href="vendas.php?id_venda={{ item.id_venda }}" target="_blank" type="button" ng-if="item.pedido_finalizado == 1"  tooltip="Ver venda" data-toggle="tooltip" class="btn btn-xs btn-info"  data-toggle="tooltip" title="Ver Venda Gerada">
													<i class="fa fa-shopping-cart"></i>
												</a>
												<button type="button" ng-click="excluirOrcamento(item)" ng-disabled="item.venda_confirmada == 1" ng-if="false" tooltip="Detalhes" data-toggle="tooltip" class="btn btn-xs btn-danger">
													<i class="fa fa-trash-o"></i>
												</button>

											</td>
										</tr>
									</tbody>
								</table>
								<div class="panel-footer clearfix" ng-if="paginacao.vendas.length > 1">
									<div class="pull-right">
										<ul class="pagination pagination-sm m-top-none">
											<li ng-repeat="item in paginacao.vendas" ng-class="{'active': item.current}">
												<a href="" h ng-click="loadVendas(item.offset,item.limit)">{{ item.index }}</a>
											</li>
										</ul>
									</div>
								</div>
							</div>	
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /main-container -->

		<!-- /Modal Clientes-->
		<div class="modal fade" id="list_clientes" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Clientes</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.clientes"  ng-enter="loadCliente(0,10)" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadCliente(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>
						<br />
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-condensed table-striped table-hover">
									<tr ng-if="clientes != false && (clientes.length <= 0 || clientes == null)">
										<th class="text-center" colspan="9" style="text-align:center"><strong>Carregando</strong><img src="assets/imagens/progresso_venda.gif"></th>
									</tr>
									<tr ng-if="clientes == false">
										<th colspan="4" class="text-center">Não a resultados para a busca</th>
									</tr>
									<thead ng-show="(clientes.length != 0)">
										<tr>
											<th >Nome</th>
											<th >Apelido</th>
											<th >Perfil</th>
											<th colspan="2">selecionar</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="item in clientes">
											<td>{{ item.nome }}</td>
											<td>{{ item.apelido }}</td>
											<td>{{ item.nome_perfil }}</td>
											<td width="50" align="center">
												<button type="button" class="btn btn-xs btn-success" ng-click="addCliente(item)">
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
				    			<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao_clientes.length > 1">
									<li ng-repeat="item in paginacao_clientes" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadCliente(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
				    		</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal Tiras-->
		<div class="modal fade" id="list_tiras" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Tiras</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.tiras"  ng-enter="loadCliente(0,10)" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadTiras(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>
						<br />
						<div class="row">

							<div class="col-sm-12">
								<div class="alert" id="alert-tiras" style="margin-bottom: 9px;display: none;">
									
								</div>
								<table class="table table-bordered table-condensed table-striped table-hover">
									<tr ng-if="tiras.length == 0">
										<th class="text-center" colspan="9" style="text-align:center"><strong>Carregando</strong><img src="assets/imagens/progresso_venda.gif"></th>
									</tr>
									<tr ng-if="tiras == null">
										<th colspan="5" class="text-center">Não a resultados para a busca</th>
									</tr>
									<thead ng-show="(tiras.length > 0)">
										<tr>
											<th class="text-center">ID</th>
											<th>Nome</th>
											<th>Tamanho</th>
											<th>Cor</th>
											<td width="80">Qtd</td>
											<th colspan="2">selecionar</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="item in tiras">
											<td>{{ item.id_produto }}</td>
											<td>{{ item.nome }}</td>
											<td>{{ item.nome_tamanho }}</td>
											<td>{{ item.nome_cor }}</td>
											<td><input ng-model="item.qtd" type="text" class="form-control input-xs text-center" /></td>
											<td width="50" align="center">
												<button type="button" ng-disabled="empty(item.qtd)" class="btn btn-xs btn-success" ng-click="selTira(item)">
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
				    			<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.tiras.length > 1">
									<li ng-repeat="item in paginacao.tiras" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadTiras(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
				    		</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal Acessorios-->
		<div class="modal fade" id="list_acessorios" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Acessórios</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.tiras"  ng-enter="loadAcessorios(0,10)" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadAcessorios(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>
						<br />
						<div class="row">

							<div class="col-sm-12">
								<div class="alert" id="alert-acessorios" style="margin-bottom: 9px;display: none;">
									
								</div>
								<table class="table table-bordered table-condensed table-striped table-hover">
									<tr ng-if="acessorios.length == 0">
										<th class="text-center" colspan="9" style="text-align:center"><strong>Carregando</strong><img src="assets/imagens/progresso_venda.gif"></th>
									</tr>
									<tr ng-if="acessorios == null">
										<th colspan="5" class="text-center">Não a resultados para a busca</th>
									</tr>
									<thead ng-show="(acessorios.length > 0)">
										<tr>
											<th class="text-center">ID</th>
											<th>Nome</th>
											<th>Tamanho</th>
											<th>Cor</th>
											<td width="80">Qtd</td>
											<th colspan="2">selecionar</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="item in acessorios">
											<td>{{ item.id_produto }}</td>
											<td>{{ item.nome }}</td>
											<td>{{ item.nome_tamanho }}</td>
											<td>{{ item.nome_cor }}</td>
											<td><input ng-model="item.qtd" type="text" class="form-control input-xs text-center" /></td>
											<td width="50" align="center">
												<button type="button" ng-disabled="empty(item.qtd)" class="btn btn-xs btn-success" ng-click="selAcessorio(item)">
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
				    			<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.acessorios.length > 1">
									<li ng-repeat="item in paginacao.acessorios" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadAcessorios(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
				    		</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal detalhes da venda-->
		<div class="modal fade" id="list_detalhes" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Detalhes do Pedido</h4>
						<p class="muted" style="margin: 0px 0 1px;" ng-if="pedido.nme_cliente != null">Cliente : {{ pedido.nme_cliente }}</p>
						<p class="muted" style="margin: 0px 0 1px;">ID pedido #{{ pedido.id }}</p>
						<p class="muted" style="margin: 0px 0 1px;" ng-if=" pedido.pedido_finalizado == 1 ">ID venda  <a href="vendas.php?id_venda={{ pedido.id_venda }}" target="_blank">#{{ pedido.id_venda }}</a></p>
      					<p class="muted" style="margin: 0px 0 1px;">Total Pedido : R$ {{ pedido.vlr_total_venda | numberFormat : '2' : ',' : '.'}}</p>
      				</div>
				    <div class="modal-body">
				   		<div class="row">
				   			<div class="col-sm-12">
				   				<div class="alert alert-detalhes-pedido" style="display:none">
				   					
				   				</div>
				   				<table class="table table-bordered table-condensed">
									<thead ng-show="(clientes.length != 0)">
										<tr>
											<th class="text-center"  width="100">ID</th>
											<th class="text-center">Produto</th>
											<th class="text-center" width="50">Tamanho</th>
											<th class="text-center" width="70">Cor</th>
											<th class="text-center" width="60">qtd</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="item in detalhes" ng-class="{'tr-error-estoque':outEstoque(item)}">
											<td class="text-center">{{ item.id_produto }}</td>
											<td>{{ item.nome_produto }}</td>
											<td>{{ item.nome_tamanho }}</td>
											<td>{{ item.nome_cor }}</td>
											<td class="text-center">{{ item.qtd }}</td>
										</tr>
									</tbody>
								</table>



				   			</div>
				   		</div>
				   		<div class="row">
				   			<div class="col-sm-12">
				   				<ul class="pagination pagination-xs m-top-none pull-right" ng-if="paginacao.detalhes.length > 1">
									<li ng-repeat="item in paginacao.detalhes" ng-class="{'active': item.current}">
										<a href="" ng-click="loadDetalhesPedido(venda,item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
				   			</div>
				   		</div>
				    </div>
				    <div class="modal-footer">
				 
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
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

	<!-- Extras -->
	<script src="js/extras.js"></script>

	<!-- Mascaras para o formulario de produtos -->
	<script src="js/scripts/mascaras.js"></script>

	<!-- UnderscoreJS -->
	<script type="text/javascript" src="bower_components/underscore/underscore.js"></script>

	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script type="text/javascript" src="bower_components/angular-ui-utils/mask.min.js"></script>
    <script src="js/angular-sanitize.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="js/dialogs.v2.min.js" type="text/javascript"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js"></script>
	<script src="js/angular-controller/pedido_venda-controller.js?<?php echo filemtime('js/angular-controller/pedido_venda-controller.js') ?>"></script>
	<script type="text/javascript">
		$("#cld_dtaInicial").on("click", function(){ $("#dtaInicial").trigger("focus"); });


		$('.datepicker').on('changeDate', function(ev){$(this).datepicker('hide');});
		// $(".dropdown-menu").mouseleave(function(){$('.dropdown-menu').hide();$('input.datepicker').blur()});
	</script>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
