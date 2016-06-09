<?php
	/*include_once "util/login/restrito.php";
	restrito(array(1));*/
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

	<!-- Datepicker -->
	<link href="css/datepicker.css" rel="stylesheet"/>

	<!-- Timepicker -->
	<link href="css/bootstrap-timepicker.css" rel="stylesheet"/>

	<!-- Chosen -->
	<link href="css/chosen/chosen.min.css" rel="stylesheet"/>

	<!-- Endless -->
	<link href="css/endless.min.css" rel="stylesheet">
	<link href="css/endless-skin.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">

	<style type="text/css">
		.panel.panel-default {
		    overflow: visible !important;
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

		.datepicker {
  		  z-index: 100000;
		}


		.mesa-container {
			padding: 20px !important;
		}

		@media (max-width: 768px) {
			.mesa-container .panel-body {
				padding: 5px !important;
			}

			.mesa-container {
				padding: 5px !important;
			}

			.mesa-container .total table {
				font-size: 1.2em;
			}

			caption.mesa-caption {
				padding-left: 8px;
			}
		}

		@media (min-width: 769px){
			.mesa-container {
				padding: 15px !important;
			}
		}

		.mesa>.panel-heading {
			color: #FFF !important;
    		text-shadow: 1px 1px 1px rgba(150, 150, 150, 1);
		}

		.mesa.panel-warning {
			border-color: #F5C561 !important;
		}

		.mesa.panel-warning>.panel-heading {
			background-color: #F5E076 !important;
    		border-color: #F5C561 !important;
		}

		.mesa.panel-warning>.panel-footer {
			background-color: #FCF8E3 !important;
    		border-top: 1px solid #F5C561 !important;
		}

		.mesa.panel-success {
			border-color: #91B970 !important;
		}

		.mesa.panel-success>.panel-heading {
			background-color: #9BD483 !important;
    		border-color: #91B970 !important;
		}

		.mesa.panel-success>.panel-footer {
			background-color: #DFF0D8 !important;
    		border-top: 1px solid #91B970 !important;
		}

		.mesa .btn-xs {
			padding-top: 5px !important;
			padding-bottom: 5px !important;
		}

		.mesa-container .total {
			padding-left: 0px !important;
			padding-right: 0px !important;
		}

		.mesa-container .total table {
			margin-bottom: 0px !important;
			border-collapse: inherit;
			font-weight: bold;
		}

		caption.mesa-caption {
    		padding-bottom: 5px;
		}

		legend {
			font-size: 1.2em;
			margin-bottom: 10px !important;
		}

		.client-list {
			margin-top: 10px;
		}
	</style>
  </head>

  <body class="overflow-hidden" ng-controller="ControleMesasController" ng-cloak>
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
				</div><!-- /main-menu -->
			</div><!-- /sidebar-inner -->
		</aside>

		<div id="main-container">
			<div id="breadcrumb">
				<ul class="breadcrumb">
					 <li><i class="fa fa-home"></i> <a href="dashboard.php">Home</a></li>
					 <li class="active"><i class="fa fa-table"></i> Controle de Mesas</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix hidden-xs">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-table"></i> Controle de Mesas</h3>
				</div><!-- /page-title -->
			</div><!-- /main-header -->

			<div class="mesa-container">
				<div class="alert alert-sistema" style="display:none"></div>

				<div class="panel panel-default"> <!-- SE ESTIVER NA VISUALIZAÇÃO DA MESA OU COMANDA TROCAR POR 'panel-warning' --> 
					<!-- INICIO - EXIBIR APENAS NA VISUALIZAÇÃO DE TODAS AS MESAS -->
					<div class="panel-body" ng-show="layout.mesas">
						<div class="row">
							<div ng-repeat="(index, mesa) in mesas" class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
								<div class="panel panel-{{ (mesa.flg_livre) ? 'success' : 'warning' }} mesa">
									<div class="panel-heading text-center">
										<h3 class="panel-title">{{ mesa.dsc_mesa }}</h3>
									</div>
									<div class="panel-body text-center">
										<span class="unlocked text-bold {{ (!mesa.flg_livre) ? 'hide' : '' }}">LIVRE</span>
										<span class="vlr_total_mesa text-bold {{ (mesa.flg_livre) ? 'hide' : '' }}">
											R$ {{ mesa.vlr_total_mesa | numberFormat : 2 : ',' : '.' }}
										</span>
										<div class="clearfix"></div>
										<span class="qtd_comandas">{{ mesa.qtd_comandas_abertas }} Comanda(s)</span>
									</div>
									<div class="panel-footer text-center">
										<button ng-if="mesa.flg_livre" type="button" class="btn btn-xs btn-block btn-success" ng-click="abrirMesa(mesa)">
											ABRIR MESA
										</button>
										<button ng-if="!mesa.flg_livre" type="button" class="btn btn-xs btn-block btn-warning" ng-click="changeTela('detMesa')">
											VISUALIZAR
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- FIM - EXIBIR APENAS NA VISUALIZAÇÃO DE TODAS AS MESAS -->

					<!-- INICIO - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A MESA SELECIONADA -->
					<div ng-show="layout.detMesa">
						<div class="panel-heading ">
							<h3 class="panel-title">
								{{ mesaSelecioada.dsc_mesa }}
								<div class="pull-right">
									<button ng-click="changeTela('mesas')" type="button" class="btn btn-xs btn-primary">
									<i class="fa fa-chevron-circle-left fa-2 yexy" aria-hidden="true"></i> Voltar</button>
									
									<button ng-click="changeTela('SelCliente')" type="button" class="btn btn-xs btn-info"><i class="fa fa-plus-circle"></i> Abrir Comanda</button>
								</div>
							</h3>
						</div>

						<div class="panel-body ">
							<table class="table table-bordered table-hover mesa">
								<caption class="text-left text-bold mesa-caption">Comandas da Mesa</caption>
								<thead>
									<th>Cliente</th>
									<th class="text-center">Itens</th>
									<th class="text-center">Subtotal</th>
								</thead>
								<tbody>
									<tr>
										<td>FILIPE COELHO</td>
										<td class="text-center">006</td>
										<td class="text-right">R$ 387,93</td>
									</tr>
									<tr>
										<td>JHEIZER WANDEL</td>
										<td class="text-center">002</td>
										<td class="text-right">R$ 100,00</td>
									</tr>
									<tr>
										<td>MARCIO TRISTAO</td>
										<td class="text-center">001</td>
										<td class="text-right">R$ 37,53</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="panel-footer total ">
							<div class="row">
								<div class="col-xs-12">
									<table class="table">
										<thead>
											<tr>
												<td>Total de Comandas</td>
												<td class="text-right">3</td>
											</tr>
											<tr>
												<td>Total da Mesa</td>
												<td class="text-right">R$ 248,87</td>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- FIM - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A MESA SELECIONADA -->

					<!-- INICIO - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A TELA DE SELECIONAR O CLIENTE -->
					<div ng-show="layout.SelCliente">
						<div class="panel-heading">
							<h3 class="panel-title clearfix">
								Informe o Cliente
								<div class="pull-right hidden-xs">
									<button ng-click="changeTela('detMesa')" type="button" class="btn btn-xs btn-primary">
									<i class="fa fa-chevron-circle-left fa-2 yexy" aria-hidden="true"></i> Voltar</button>
									<button type="button" class="btn btn-xs btn-success">
										<i class="fa fa-plus-circle"></i>
										Cadastrar Novo
									</button>
									<button type="button" class="btn btn-xs btn-default">
										<i class="fa fa-times-circle"></i>
										Não Informar
									</button>
								</div>
							</h3>
						</div>

						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<input ng-keyup="autoCompleteCliente(busca.cliente)" ng-model="busca.cliente" type="text" class="form-control" placeholder="Pesquisar">
								</div>
							</div>

							<div class="row client-list">
								<div class="col-lg-12">
									<table class="table">
										<tbody>
											<tr ng-repeat="item in clientes">
												<td class="text-middle">{{ item.nome | uppercase }}</td>
												<td ng-if="item.tipo_cadastro=='pf'" class="text-middle text-center hidden-xs" width="120">{{ item.cpf | cpfFormat }}</td>
												<td ng-if="item.tipo_cadastro=='pj'"  class="text-middle text-center hidden-xs" width="120">{{ item.cpf | cnpjFormat }}</td>
												<td class="text-middle text-center" width="50">
													<button type="button" class="btn btn-sm btn-info">
														<i class="fa fa-check-square-o"></i>
														<span class="hidden-xs">Selecionar</span>
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="panel-footer clearfix hidden-sm hidden-md hidden-lg">
							<button type="button" class="btn btn-md btn-block btn-success">
								<i class="fa fa-plus-circle"></i>
								Cadastrar Novo
							</button>
							<button type="button" class="btn btn-md btn-block btn-default">
								<i class="fa fa-times-circle"></i>
								Não Informar
							</button>
						</div>
					</div>
					<!-- FIM - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A TELA DE SELECIONAR O CLIENTE -->

					<!-- INICIO - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A TELA DE CADASTRAR O CLIENTE -->
					<div ng-show="layout.cadCliente">
						<div class="panel-heading">
							<h3 class="panel-title clearfix">Cadastro de Cliente</h3>
						</div>

						<div class="panel-body">
							<div class="row">
								<div class="col-sm-12 col-md-1 col-lg-1"></div>
								<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Nome">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-1 col-lg-1"></div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="CPF">
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="E-mail">
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Telefone/Celular">
									</div>
								</div>
							</div>
						</div>

						<div class="panel-footer clearfix hidden-sm hidden-md hidden-lg">
							<button type="button" class="btn btn-md btn-block btn-primary">
								<i class="fa fa-save"></i>
								Salvar
							</button>
						</div>

						<div class="panel-footer clearfix hidden-xs">
							<button type="button" class="btn btn-md btn-primary pull-right">
								<i class="fa fa-save"></i>
								Salvar
							</button>
						</div>
					</div>
					<!-- FIM - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A TELA DE CADASTRAR O CLIENTE -->

					<!-- INICIO - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A TELA DE ITENS DA COMANDA -->
					<div ng-show="layout.detComanda">
						<div class="panel-heading">
							<h3 class="panel-title clearfix">
								Comanda #42975
								<div class="pull-right">
									<button type="button" class="btn btn-xs btn-default">
										<i class="fa fa-user"></i>
										<span class="hidden-xs">Informar Cliente</span>
									</button>
									<button type="button" class="btn btn-xs btn-info">
										<i class="fa fa-plus-circle"></i>
										Adicionar Produto
									</button>
								</div>
							</h3>
						</div>

						<div class="panel-body">
							<div class="row client-list">
								<div class="col-lg-12">
									<table class="table">
										<caption class="text-bold text-left mesa-caption">Cliente: Filipe Mendonça Coelho</caption>

										<tbody>
											<tr>
												<td class="text-middle">PRODUTO ABCDEFGHI</td>
												<td class="text-middle text-center hidden-xs" width="200">FABRICANTE A</td>
												<td class="text-middle text-center hidden-xs" width="200">TAMANHO 736</td>
												<td class="text-middle text-center hidden-xs" width="200">SABOR XYZ</td>
												<td class="text-middle text-center" width="100">
													<button type="button" class="btn btn-sm btn-warning">
														<i class="fa fa-edit"></i>
														<span class="hidden-xs">Alterar item</span>
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="panel-footer total">
							<div class="row">
								<div class="col-xs-12">
									<table class="table">
										<thead>
											<tr>
												<td>Total de Itens</td>
												<td class="text-right">8</td>
											</tr>
											<tr>
												<td>Total da Comanda</td>
												<td class="text-right">R$ 124,07</td>
											</tr>
										</thead>
									</table>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 hidden-sm hidden-md hidden-lg"> <!-- EXIBIR APENAS AO PERFIL DE CAIXA -->
									<button type="button" class="btn btn-danger btn-block"><i class="fa fa-dollar"></i> Fechar Comanda</button>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 hidden-xs clearfix"> <!-- EXIBIR APENAS AO PERFIL DE CAIXA -->
									<button type="button" class="btn btn-danger pull-right"><i class="fa fa-dollar"></i> Fechar Comanda</button>
								</div>
							</div>
						</div>
					</div>
					<!-- FIM - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A TELA DE CADASTRAR O CLIENTE -->

					<!-- INICIO - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A TELA DE DETALHES DO PRODUTO -->
					<div ng-show="layout.detItemComanda">
						<div class="panel-heading">
							<h3 class="panel-title">ESSÊNCIA ADALYA COCO 100G</h3>
						</div>

						<div class="panel-body">
							<fieldset>
								<legend>Informe a quantidade</legend>

								<div class="row">
									<div class="col-lg-12">
										<input type="number" class="form-control" placeholder="Pesquisar">
									</div>
								</div>
							</fieldset>
						</div>

						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 hidden-sm hidden-md hidden-lg"> <!-- EXIBIR APENAS AO PERFIL DE CAIXA -->
									<button type="button" class="btn btn-primary btn-block"><i class="fa fa-trash-o"></i> Atualizar Item</button>
									<button type="button" class="btn btn-danger btn-block"><i class="fa fa-trash-o"></i> Excluir Item</button>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 hidden-xs clearfix"> <!-- EXIBIR APENAS AO PERFIL DE CAIXA -->
									<div class="pull-right">
										<button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Excluir Item</button>
										<button type="button" class="btn btn-primary"><i class="fa fa-trash-o"></i> Atualizar Item</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- FIM - EXIBIR APENAS QUANDO ESTIVER VISUALIZANDO A TELA DE DETALHES DO PRODUTO -->
				</div>
			</div>
		</div><!-- /main-container -->

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

	<!-- Datepicker -->
	<script src='js/bootstrap-datepicker.min.js'></script>

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

	<!-- fixedHeadTable -->
	<script type="text/javascript" src="js/fixedHeadTable/fixedHeadTable.js"></script>

	<!-- AngularJS -->
	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script type="text/javascript" src="bower_components/angular-ui-utils/mask.min.js"></script>
    <script src="js/angular-sanitize.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="js/dialogs.v2.min.js" type="text/javascript"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script src="js/angular-chosen.js"></script>
    <script type="text/javascript">
    	var addParamModule = ['angular.chosen'] ;
    </script>
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js"></script>
	<script src="js/angular-controller/controle-mesas_controller.js?<?php echo filemtime('js/angular-controller/controle-mesas_controller.js')?>"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.tpl.min.js"></script>
	<script type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#cld_pagameto").on("click", function(){ $("#pagamentoData").trigger("focus"); });
			$("#cld_dtaInicial").on("click", function(){ $("#dtaInicial").trigger("focus"); });
			$("#cld_dtaFinal").on("click", function(){ $("#dtaFinal").trigger("focus"); });
			$('.datepicker').on('changeDate', function(ev){$(this).datepicker('hide');});
			$(".dropdown-menu").mouseleave(function(){$('.dropdown-menu').hide();$('input.datepicker').blur()});
		});
	</script>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
