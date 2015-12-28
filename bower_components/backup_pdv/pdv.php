<?php
	include_once "util/login/restrito.php";
	restrito(array(8));
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

	<!-- Endless -->
	<link href="css/endless.min.css" rel="stylesheet">
	<link href="css/endless-skin.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<link  href="js/auto-complete/AutoComplete.css" rel="stylesheet" type="text/css"></link>
	<style type="text/css">

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

		/*@media screen and (min-width: 768px) {

			#list_validades.modal-dialog  {width:900px;}

		}

		#list_validades .modal-dialog  {width:70%;}

		#list_validades .modal-content {min-height: 640px;}*/


	</style>
  </head>

  <body class="overflow-hidden" ng-controller="PDVController" ng-cloak>

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
					 <li><i class="fa fa-signal"></i> <a href="vendas.php">Vendas</a></li>
					 <li class="active"><i class="fa fa-desktop"></i> Frente de Caixa (PDV)</li>
				</ul>
			</div>
			<!-- breadcrumb -->

			<div class="padding-md" ng-if="caixa_aberto == false && abrir_pdv ==false && caixa_configurado == true">

				<div class="panel panel-primary" style="width:500px;margin:0 auto">
					<div class="panel-heading">
						<i class="fa fa-desktop"></i> Frente de Caixa | PDV - {{ caixa.dsc_conta_bancaria }}
					</div>

					<div class="panel-body">
						<h1 class="text-center">Caixa Fechado</h1>
					</div>

					<div class="panel-footer clearfix">
						<div class="text-center">
							<button data-loading-text=" Aguarde..." ng-click="abrirCaixa()"  id="btn-abrir-caixa" type="button" class="btn btn-lg btn-success" ng-click="salvar()"><i class="fa fa-unlock "></i> Abrir Caixa</button>
						</div>
					</div>
				</div>
			</div>

			<div class="padding-md" ng-if="caixa_configurado == false">

				<div class="panel panel-danger" style="width:500px;margin:0 auto">
					<div class="panel-heading">
						<i class="fa fa-desktop"></i> Frente de Caixa
					</div>

					<div class="panel-body">
						<h1 class="text-center">Caixa não configurado</h1>
						<div class="row">
							<div class="col-sm-12">
								<p>
									As configuraçãoes necessarias para que o caixa funcione corretamente ainda não foram efetuadas.
									<br/>
									Solicite que seu administrador as faça.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="padding-md" ng-if="abrir_pdv">
				<div class="panel panel-primary" style="width:500px;margin:0 auto">
					<div class="panel-heading">
						<i class="fa fa-desktop"></i> Frente de Caixa | PDV - {{ caixa.dsc_conta_bancaria }}
					</div>

					<div class="panel-body">
						<div class="row text-center">
						    <div class="col-sm-12">
								<div class="form-group text-center">
									<div>
										<h3>Entrada</h3>
									</div>
								</div>
							</div>
						</div>
						<div class="row text-center">
							 <div class="col-sm-2">
							 </div>
						    <div class="col-sm-4">
						    	<label class="control-label">Valor</label>
								<div class="form-group text-center" id="entrada_valor_pagamento">
									<input ng-model="abertura_reforco.valor" thousands-formatter type="text" class="form-control input-md">
								</div>
							</div>
							<div class="col-sm-4" id="entrada_conta_origem">
						    			<label class="control-label">Conta de origem</label>
							    		<select class="form-control input-md" ng-model="abertura_reforco.conta_origem">
							    					<option value=""></option>
													<option ng-repeat="item in contas" value="{{ item.id }}">{{ item.dsc_conta_bancaria }}</option>
										</select>
							</div>
							 <div class="col-sm-2">
							 </div>
						</div>
					</div>

					<div class="panel-footer clearfix">
						<div class="text-center">
							<button data-loading-text=" Aguarde..." ng-click="aplicarReforcoEntrada()"  id="btn-abrir-caixa" type="button" class="btn btn-lg btn-success" ng-click="salvar()"><i class="fa fa-unlock "></i> Abrir PDV</button>
						</div>
					</div>
				</div>
			</div>

			<div class="padding-md" id="content-pdv" ng-if="caixa_aberto && abrir_pdv == false && caixa_configurado == true">

				<div class="panel panel-primary">
					<div class="panel-heading">
						<i class="fa fa-desktop"></i> Frente de Caixa | PDV - {{ caixa.dsc_conta_bancaria }}
						<div class="btn-group pull-right">
							<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-chevron-down"></i>
							</button>
							<ul class="dropdown-menu slidedown">
								<li><a id="fullscreen"><i class="fa fa-arrows-alt"></i> Tela Inteira</a></li>
								<li><a href="#" ng-click="modalSangria()"><i class="fa fa-upload"></i> Efetuar Sangria</a></li>
								<li><a href="#" ng-click="modalReforco()"><i class="fa fa-download"></i> Incluir Reforço</a></li>
								<li><a href="#" ng-click="modalFechar()"><i class="fa fa-sign-out"></i> Fechar Caixa</a></li>
							</ul>
						</div>
					</div>

					<div class="panel-body" ng-if="receber_pagamento">
							<div class="alert alert-pagamento" style="display:none"></div>
					    	<div class="row">
					    		<div class="col-sm-6">
						    	<div class="row">
						    		<div class="col-sm-6" id="pagamento_forma_pagamento">
						    			<label class="control-label">Forma de Pagamento</label>
										<select ng-model="pagamento.id_forma_pagamento" class="form-control input-sm">
											<option ng-if="pagamento.id_forma_pagamento != null" value=""></option>
											<option ng-repeat="item in formas_pagamento" value="{{ item.id }}">{{ item.nome }}</option>
										</select>
									</div>

						    		<div class="col-sm-6" id="pagamento_valor">
						    			<label class="control-label">Valor</label>
						    			<div class="form-group ">
						    					<input ng-model="pagamento.valor" thousands-formatter type="text" class="form-control input-sm" >
						    			</div>
						    		</div>
						    	</div>

						    	<div class="row">
						    		<div class="col-sm-6" id="pagamento_maquineta" ng-if="pagamento.id_forma_pagamento == 5 || pagamento.id_forma_pagamento == 6 ">
						    			<label class="control-label">Maquineta</label>
										<select ng-model="pagamento.id_maquineta" class="form-control input-sm">
											<option ng-repeat="item in maquinetas" value="{{ item.id_maquineta }}">{{ item.num_serie_maquineta }}</option>
										</select>
									</div>
						    		<div class="col-sm-6" id="numero_parcelas" ng-if="pagamento.id_forma_pagamento == 6">
						    			<label class="control-label">parcelas</label>
						    			<div class="form-group ">
						    					<input ng-model="pagamento.parcelas" type="text" class="form-control input-sm" >
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
							<div class="col-sm-6">
								<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(clientes.length != 0)">
										<tr>
											<th colspan="2" class="text-center">Recebidos</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(recebidos.length == 0)">
											<td colspan="2">Não há nenhum pagamento recebido</td>
										</tr>
										<tr ng-repeat="item in recebidos">
											<td ng-if="item.id_forma_pagamento != 6">{{ item.forma_pagamento  }} <strong class="pull-right">R$ {{ item.valor | numberFormat:2:',':'.' }}</strong></td>
											<td ng-if="item.id_forma_pagamento == 6">{{ item.forma_pagamento  }} em {{item.parcelas}}x <strong class="pull-right">R$ {{ item.valor | numberFormat:2:',':'.' }}</strong></td>
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
											<td colspan="2" ng-if="troco <= 0">
												Total a Receber <strong class="pull-right">R$ {{ vlrTotalCompra - total_pg | numberFormat:2:',':'.' }}</strong>
											</td>
											<td colspan="2" ng-if="troco > 0">
												Total a Receber <strong class="pull-right">R$ 0,00</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												Troco <strong class="pull-right">R$ {{ troco | numberFormat:2:',':'.' }}</strong>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>



					<div class="panel-body" ng-if="receber_pagamento == false" >
						<form role="form">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<input type="text" class="text-center form-control input-xg" readonly="readonly" ng-model="nome_ultimo_produto">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-3">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<input type="text" class="text-center form-control input-xg" readonly="readonly" ng-value="vezes_valor">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group text-center">
												<img src="{{ imgProduto }}" style="max-height: 50%;">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label class="control-label"><i class="fa fa-barcode"></i> Pesquisa por Cód. Barras</label>
												<div class="input-group">
													<input id="buscaCodigo" type="text" class="form-control input-lg" ng-model="busca.codigo" sync-focus-with="!busca.ok" ng-enter="findProductByBarCode();">
													<span class="input-group-btn">
														<button type="button" class="btn btn-lg btn-primary" ng-click="findProductByBarCode();"><i class="fa fa-search"></i></button>
													</span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="alert alert-warning" ng-if="msg != ''">{{ msg }}</div>
										</div>
									</div>
								</div>

								<div class="col-sm-9">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label class="control-label"><h4>Cliente</h4></label>
												<div class="form-group">
														<label class="label-radio inline">
															<input type="radio" name="radio-busca-cliente" ng-model="tipo_busca_cliente" value="cpf"  ng-checked="tipo_busca_cliente == cpf" id="radio-busca-cpf">
															<span class="custom-radio"></span>
															CPF - <span id="id_cliente_auto"></span>
														</label>
														<label class="label-radio inline">
															<input type="radio" name="radio-busca-cliente" ng-model="tipo_busca_cliente" value="cnpj"  ng-checked="tipo_busca_cliente == cnpj" id="radio-busca-cnpj">
															<span class="custom-radio"></span>
															CNPJ
														</label>

												</div><!-- /form-group -->

													<div class="row">
														<div class="col-sm-9">
															<div class="input-group">
															<div  ng-if="tipo_busca_cliente == 'nome'" ng-model="busca.clientes" nz-auto-complete get-results-fn="searchFunctionStaticData" min-char="0" silent-period="0" selection-required="true"></div>
															<input  type="text" class="form-control" ng-if="tipo_busca_cliente == 'cpf'" ng-model="busca.cpf" ng.busca ui-mask="999.999.999-99"  />
															<input  type="text" class="form-control" ng-if="tipo_busca_cliente == 'cnpj'"  ng-model="busca.cnpj" ui-mask="99.999.999/9999-99"/>
															<span class="input-group-btn">
																<button ng-click="selCliente(0,10)" type="button" class="btn btn-info"><i class="fa fa-users"></i></button>
															</span>
															</div>
														</div>
														<div class="col-sm-1">
															<button class="btn btn-success">Buscar</button >
														</div>
														<div class="col-sm-1">
															<button ng-click="tipo_busca_cliente = 'nome';busca.cpf = '';busca.cnpj=''" class="btn btn-default">limpar</button >
														</div>
													</div>
												</div>


										</div>
									</div>

									<div class="row" ng-if="out_produtos.length > 0">
										<div class="col-sm-12">
											<div class="alert alert-out alert-warning">
												Desculpe, os produtos marcados em <span style="color:#FF9191">vermelho</span>,
											    não estão mais disponivel em nosso estoque, para continuar a venda basta
											    retira-los do carrinho.
											</div>
										</div>
									</div>

									<div class="row" style="min-height:200px">
										<div class="col-sm-12">
											<div class="form-group">
												<table class="table table-condensed table-striped table-hover table-bordered">
													<tr ng-hide="carrinho.length > 0">
														<td colspan="4">
															Não há Produtos para a venda
														</td>
													</tr>
													<thead ng-show="carrinho.length  > 0">
														<tr>
															<th>Produto</th>
															<th class="text-center" style="width: 80px;" >Quantidade</th>
															<th class="text-center" style="width: 100px;">Valor Unitário</th>
															<th class="text-center" style="width: 100px;" colspan="2">Desconto</th>
															<th class="text-center" style="width: 100px;">Subtotal</th>
															<th class="text-center" style="width: 20px;"></th>
														</tr>
													</thead>
													<tbody>
														<tr ng-repeat="item in carrinho" id="{{ item.id_produto }}">
															<td>{{ item.nome_produto }}</td>
															<td class="text-center" width="20">
																<input ng-keyUp="calcSubTotal(item)" ng-model="item.qtd_total" type="text" class="form-control input-xs"></input>
															</td>

															<td class="text-right">R$ {{ item.vlr_unitario | numberFormat : 2 : ',' : '.' }}</td>
															<td class="text-center" style="width: 30px;">
																<label class="label-checkbox">
																	<input ng-model="item.flg_desconto" type="checkbox" id="toggleLine" ng-true-value="1" ng-false-value="0" ng-click="aplicarDesconto($index,$event)" >
																	<span class="custom-checkbox"></span>
																</label>
															</td>
															<td class="text-right" style="width:70px;">
																<input ng-keyUp="aplicarDesconto($index,$event,false)" ng-if="item.flg_desconto == 1" thousands-formatter ng-model="item.valor_desconto" type="text" class="form-control input-xs"></input>
															</td>
															<td class="text-right">R$ {{ item.sub_total    | numberFormat : 2 : ',' : '.' }}</td>
															<td class="text-center">
																<button type="button" class="btn btn-xs btn-danger" ng-click="delItem($index)"><i class="fa fa-trash-o"></i></button>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<div class="pull-right" ng-show="carrinho.length > 0">
													<h2>R$ {{ vlrTotalCompra | numberFormat : 2 : ',' : '.' }}</h2>
												</div>
											</div>
										</div>
									</div>
									<!--
									<div class="row" ng-show="carrinho.length > 0">
									    <div class="col-sm-6">
											<div class="form-group">
												<div class="pull-right" >
													<h3>Valor Pago</h3>
												</div>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<div class="pull-right">
													<h3>R$ {{ total_pg | numberFormat : 2 : ',' : '.' }}</h3>
												</div>
											</div>
										</div>

									</div>
									<div class="row" ng-show="troco > 0">
									    <div class="col-sm-6">
											<div class="form-group">
												<div class="pull-right" >
													<h3>Troco</h3>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="pull-right">
													<h3>R$ {{ troco | numberFormat : 2 : ',' : '.' }}</h3>
												</div>
											</div>
										</div>
									</div>
									-->
								</div>
							</div>
						</form>
			</div>

					<div class="panel-footer clearfix">
						<!--<div class="pull-left" ng-if="receber_pagamento == false">
							<button type="button" class="btn btn-lg btn-primary" ng-click="modalReforco()"> Reforço</button>
							<button type="button" class="btn btn-lg btn-primary" ng-click="modalSangria()"> Sangria</button>
							<button type="button" class="btn btn-lg btn-primary" ng-click="modalFechar()"> Fechar</button>
						</div>-->
						<div class="pull-right">
							<button type="button" class="btn btn-lg btn-danger" ng-if="receber_pagamento == false" ng-click="cancelar()"><i class="fa fa-times-circle"></i> Cancelar Venda</button>
							<button type="button" class="btn btn-lg btn-warning" ng-if="receber_pagamento" ng-click="cancelarPagamento()"><i class="fa fa-times-circle"></i> Cancelar Pagamento</button>
							<button type="button" class="btn btn-lg btn-success" ng-if="receber_pagamento" data-loading-text=" Aguarde..." id="btn-fazer-compra" ng-click="salvar()" ng-disabled="total_pg == 0 || total_pg < vlrTotalCompra"><i class="fa fa-save"></i> Finalizar</button>
							<button type="button" class="btn btn-lg btn-primary" ng-if="receber_pagamento == false" ng-disabled="carrinho.length == 0" ng-click="receberPagamento()"><i class="fa fa-money"></i> Receber</button>

						</div>
					</div>
				</div>
			</div>
		</div><!-- /main-container -->



		<!-- Modal Pagamento  -->
		<div class="modal fade" id="modal-receber" style="display:none">
  			<div class="modal-dialog error modal-lg">
    			<div class="modal-content">
      				<div class="modal-header">
						<h4>Pagamento</h4>
      				</div>

				    <div class="modal-body">
				    	<div class="alert alert-pagamento" style="display:none"></div>
					    	<div class="row">
					    		<div class="col-sm-6">
						    	<div class="row">
						    		<div class="col-sm-6" id="pagamento_forma_pagamento">
						    			<label class="control-label">Forma de Pagamento</label>
										<select ng-model="pagamento.id_forma_pagamento" class="form-control input-sm">
											<option ng-if="pagamento.id_forma_pagamento != null" value=""></option>
											<option ng-repeat="item in formas_pagamento" value="{{ item.id }}">{{ item.nome }}</option>
										</select>
									</div>

						    		<div class="col-sm-6" id="pagamento_valor">
						    			<label class="control-label">Valor</label>
						    			<div class="form-group ">
						    					<input ng-model="pagamento.valor" thousands-formatter type="text" class="form-control input-sm" >
						    			</div>
						    		</div>
						    	</div>

						    	<div class="row">
						    		<div class="col-sm-6" id="pagamento_maquineta" ng-if="pagamento.id_forma_pagamento == 5 || pagamento.id_forma_pagamento == 6 ">
						    			<label class="control-label">Maquineta</label>
										<select ng-model="pagamento.id_maquineta" class="form-control input-sm">
											<option ng-repeat="item in maquinetas" value="{{ item.id_maquineta }}">{{ item.num_serie_maquineta }}</option>
										</select>
									</div>
						    		<div class="col-sm-6" id="numero_parcelas" ng-if="pagamento.id_forma_pagamento == 6">
						    			<label class="control-label">parcelas</label>
						    			<div class="form-group ">
						    					<input ng-model="pagamento.parcelas" type="text" class="form-control input-sm" >
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
							<div class="col-sm-6">
								<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(clientes.length != 0)">
										<tr>
											<th colspan="2" class="text-center">Recebidos</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(recebidos.length == 0)">
											<td colspan="2">Não há nenhum pagamento recebido</td>
										</tr>
										<tr ng-repeat="item in recebidos">
											<td ng-if="item.id_forma_pagamento != 6">{{ item.forma_pagamento  }} <strong class="pull-right">R$ {{ item.valor | numberFormat:2:',':'.' }}</strong></td>
											<td ng-if="item.id_forma_pagamento == 6">{{ item.forma_pagamento  }} em {{item.parcelas}}x <strong class="pull-right">R$ {{ item.valor | numberFormat:2:',':'.' }}</strong></td>
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
												total Recebido <strong class="pull-right">R$ {{ total_pg | numberFormat:2:',':'.' }}</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" ng-if="troco <= 0">
												total à receber <strong class="pull-right">R$ {{ vlrTotalCompra - total_pg | numberFormat:2:',':'.' }}</strong>
											</td>
											<td colspan="2" ng-if="troco > 0">
												total à receber <strong class="pull-right">R$ 0,00</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												troco <strong class="pull-right">R$ {{ troco | numberFormat:2:',':'.' }}</strong>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
				    </div>
			  	</div>
			  	<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal reforço-->
				<div class="modal fade" id="modal-reforco" style="display:none">
		  			<div class="modal-dialog error modal-sm">
		    			<div class="modal-content">
		      				<div class="modal-header">
								<h4>Reforço</h4>
		      				</div>

						    <div class="modal-body">
						    	<div class="alert alert-reforco" style="display:none"></div>

						    	<div class="row">
						    		<div class="col-sm-6" id="valor_pagamento">
						    			<label class="control-label">Valor</label>
						    			<div class="form-group ">
						    					<input ng-model="reforco.valor" thousands-formatter type="text"  class="form-control input-sm" >
						    			</div>
						    		</div>
						    		<div class="col-sm-6" id="conta_origem">
						    			<label class="control-label">Conta de origem</label>
							    		<select class="form-control input-sm" ng-model="reforco.conta_origem">
													<option ng-repeat="item in contas" value="{{ item.id }}">{{ item.dsc_conta_bancaria }}</option>
										</select>
									</div>
						    	</div>
						    </div>

						    <div class="modal-footer">
						    	<button type="button" data-loading-text=" Aguarde..." id="btn-aplicar-reforco"
						    		class="btn btn-md btn-block btn-success" ng-click="aplicarReforco()">
						    		<i class="fa fa-plus-circle"></i> Aplicar reforço
						    	</button>
						    	<button type="button" data-loading-text=" Aguarde..." ng-click="cancelarModal('modal-reforco')" id="btn-aplicar-reforco"
						    		class="btn btn-md btn-block btn-default fechar-modal">
						    		<i class="fa fa-times-circle"></i> Cancelar
						    	</button>
						    </div>
					  	</div>
					  	<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->

				<!-- /Modal de Fechamento de caixa-->
				<div class="modal fade" id="modal-fechamento" style="display:none">
		  			<div class="modal-dialog error modal-sm">
		    			<div class="modal-content">
		      				<div class="modal-header">
								<h4>Fechar PDV</h4>
		      				</div>

						    <div class="modal-body">
						    	<div class="alert alert-reforco" style="display:none"></div>

						    	<div class="row">
						    		<div class="col-sm-12">
						    				<table class="table table-bordered table-condensed table-striped table-hover">
												<thead>
													<tr>
														<th  class="text-center">Forma de Pagamento</th>
														<th  class="text-center">Valor</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="item in lacamentos_formas_pagamento">
														<td class="text-center"><strong>{{ item.forma_pagamento }}</strong></td>
														<td class="text-center"><strong>R$ {{ item.total| numberFormat:2:',':'.' }}</strong></td>
													</tr>
												</tbody>
											</table>
						    		</div>
						    		<div class="col-sm-12" id="conta_destino">
						    			<label class="control-label text-center">Conta de destino dos valores em dinheiro</label>
							    		<select class="form-control input-sm" ng-model="fechamento.id_conta_bancaria">
											<option ng-repeat="item in contas" value="{{ item.id }}">{{ item.dsc_conta_bancaria }}</option>
										</select>
									</div>
						    	</div>
						    </div>
						    <div class="modal-footer">
						  		<button type="button" data-loading-text=" Aguarde..." id="btn-fechar-caixa"
			    					class="btn btn-md btn-success btn-block" ng-click="fecharPDV()">
			    					<i class="fa fa-lock"></i> Fechar PDV
			    				</button>

			    				<button type="button" data-loading-text=" Aguarde..." ng-click="cancelarModal('modal-fechamento')" id="btn-fechar-caixa"
			    					class="btn btn-md btn-default btn-block fechar-modal">
			    					<i class="fa fa-times-circle"></i> Cancelar
			    				</button>
						  	</div>
					  	</div>
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->

		<!-- Modal Sangria  -->
		<div class="modal fade" id="modal-sangria" style="display:none">
  			<div class="modal-dialog error modal-sm">
    			<div class="modal-content">
      				<div class="modal-header">
						<h4>Sangria</h4>
      				</div>

				    <div class="modal-body">
				    	<div class="alert alert-sangria" style="display:none"></div>

				    	<div class="row">
				    		<div class="col-sm-6" id="valor_retirada">
				    			<label class="control-label">Valor</label>
				    			<div class="form-group ">
				    					<input ng-model="sangria.valor" thousands-formatter type="text" placeholder="Valor" class="form-control input-sm" >
				    			</div>
				    		</div>
				    		<div class="col-sm-6" id="conta_destino">
				    			<label class="control-label">Conta de destino</label>
					    		<select class="form-control input-sm" ng-model="sangria.conta_destino">
											<option ng-repeat="item in contas" value="{{ item.id }}">{{ item.dsc_conta_bancaria }}</option>
								</select>
							</div>

				    	</div>
				    </div>

				    <div class="modal-footer">
				    	<button type="button" data-loading-text=" Aguarde..." class="btn btn-block btn-md btn-success"
				    		id="btn-aplicar-sangria" ng-click="aplicarSangria()">
				    		<i class="fa fa-minus-circle"></i> Aplicar sangria
				    	</button>

				    	<button type="button" data-loading-text=" Aguarde..."
				    		class="btn btn-block btn-md btn-default" ng-click="cancelarModal('modal-sangria')" id="btn-aplicar-sangria">
				    		<i class="fa fa-times-circle"></i> Cancelar
				    	</button>
				    </div>
			  	</div>
			  	<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

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
						            <input ng-model="busca.clientes" type="text" class="form-control input-sm">
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
									<thead ng-show="(clientes.length != 0)">
										<tr>
											<th >Nome</th>
											<th >perfil</th>
											<th colspan="2">selecionar</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(clientes.length == 0)">
											<td colspan="2">Não há clientes cadastrados</td>
										</tr>
										<tr ng-repeat="item in clientes">
											<td>{{ item.nome }}</td>
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
		<!-- /.modal --><!-- /Modal Produtos-->
		<div class="modal fade" id="list_produtos" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Produtos</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.produtos" type="text" class="form-control input-sm">

						            <div class="input-group-btn">
						            	<button ng-click="loadProdutos(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button"><i class="fa fa-search"></i> Buscar</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>

						<br>

						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-produtos" style="display:none"></div>
						   		<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(produtos.length != 0)">
										<tr>
											<th>#</th>
											<th>Nome</th>
											<th>Fabricante</th>
											<th>Tamanho</th>
											<th width="80"></th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(produtos.length == 0)">
											<td colspan="3">Não a Produtos cadastrados</td>
										</tr>
										<tr ng-repeat="item in produtos">
											<td>{{ item.id_produto }}</td>
											<td>{{ item.nome_produto }}</td>
											<td>{{ item.nome_fabricante }}</td>
											<td>{{ item.peso }}</td>
											<td>
											<button ng-click="addProduto(item)" class="btn btn-success btn-xs" type="button">
												<i class="fa fa-check-square-o"></i> Selecionar
											</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

					    <div class="row">
					    	<div class="col-md-12">
								<div class="input-group pull-right">
						             <ul class="pagination pagination-xs m-top-none" ng-show="paginacao.produtos.length > 1">
										<li ng-repeat="item in paginacao.produtos" ng-class="{'active': item.current}">
											<a href="" ng-click="loadProdutos(item.offset,item.limit)">{{ item.index }}</a>
										</li>
									</ul>
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>
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
	<script src="js/endless/endless.js"></script>

	<!-- Extras -->
	<script src="js/extras.js"></script>

	<!-- UnderscoreJS -->
	<script type="text/javascript" src="bower_components/underscore/underscore.js"></script>


	<!-- ScrennFull  -->
	<script type="text/javascript" src="js/screenfull/screenfull.js"></script>

	<!-- AngularJS -->
	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script type="text/javascript" src="bower_components/angular-ui-utils/mask.min.js"></script>
    <script src="js/angular-sanitize.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="js/dialogs.v2.min.js" type="text/javascript"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js"></script>
	<script src="js/angular-controller/pdv-controller.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#buscaCodigo").focus();
			$('#sizeToggle').trigger("click");

			$("#fullscreen").on("click", function() {
				if($("#top-nav").css("display") == "block"){
					$("footer").css("margin-left", 0);
					$("#main-container").css("margin-left", 0).css("padding-top", 0);
					$("#top-nav").toggle();
					$("aside").toggle();
					$("#breadcrumb").toggle();
				}
				else {
					$("footer").css("margin-left", 90);
					$("#main-container").css("margin-left", 90).css("padding-top", 45);
					$("#top-nav").toggle();
					$("aside").toggle();
					$("#breadcrumb").toggle();
				}

				$("#buscaCodigo").focus();
			});
		});
	</script>

  </body>
</html>
