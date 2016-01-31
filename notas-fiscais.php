<?php
	include_once "util/login/restrito.php";
	restrito();
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

	<!-- Chosen -->
	<link href="css/chosen/chosen.min.css" rel="stylesheet"/>

	<!-- Endless -->
	<link href="css/endless.min.css" rel="stylesheet">
	<link href="css/endless-skin.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
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

		@media screen and (min-width: 768px) {

			#list_proodutos.modal-dialog  {width:900px;}

		}

		#list_produtos .modal-dialog  {width:70%;}

		#list_produtos .modal-content {min-height: 640px;;}

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

  <body class="overflow-hidden" ng-controller="NotasFiscaisController" ng-cloak>
  	<!-- Overlay Div -->
	<div id="overlay" class="transparent"></div>

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
					 <li class="active"><i class="fa fa-barcode"></i> Notas Fiscais</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-barcode"></i> Notas Fiscais</h3>
				</div><!-- /page-title -->
			</div><!-- /main-header -->

			<div class="padding-md">
				<div class="panel panel-default">
					<div class="panel-tab clearfix">
						<ul class="tab-bar">
							<li class="active"><a href="#emitidas" data-toggle="tab"><i class="fa fa-send"></i> Emitidas</a></li>
							<li><a href="#canceladas" data-toggle="tab"><i class="fa fa-times-circle"></i> Canceladas</a></li>
							<li><a href="#inutilizadas" data-toggle="tab"><i class="fa fa-ban"></i> Inútilizads</a></li>
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="emitidas">
								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">De</label>
											<div class="input-group">
												<input id="inputDtaEmissao" readonly="readonly" style="background:#FFF;cursor:pointer" type="text" class="datepicker form-control input-sm">
												<span  id="btnDtaEmissao" class="input-group-addon"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">Até</label>
											<div class="input-group">
												<input id="inputDtaEmissao" readonly="readonly" style="background:#FFF;cursor:pointer" type="text" class="datepicker form-control input-sm">
												<span  id="btnDtaEmissao" class="input-group-addon"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label for="" class="control-label">Tipo de Cadastro</label>
											<div class="form-group">
												<label class="label-radio inline">
													<input ng-model="empreendimento.flg_contribuinte_icms" value="0" type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Pessoa Física</span>
												</label>
												<label class="label-radio inline">
													<input ng-model="empreendimento.flg_contribuinte_icms" value="1" type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Pessoa Jurídica</span>
												</label>
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label class="control-label">Destinatário</label> 
											<select chosen
											    option="lista_finalidade_emissao"
											    ng-model="NF.dados_emissao.finalidade_emissao"
											    ng-options="item.num_item as item.nme_item for item in lista_finalidade_emissao">
											</select>
										</div>
									</div>

									<div class="col-sm-1">
										<div class="form-group">
											<label class="control-label"><br></label>
											<button type="button" class="btn btn-sm btn-primary" ng-click="load(0,20)"><i class="fa fa-filter"></i> Filtrar</button>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="table table-bordered table-condensed table-striped table-hover">
												<thead>
													<th class="text-middle text-center" width="50"></th>
													<th class="text-middle text-center">Nº NF-e</th>
													<th class="text-middle text-center">Nº Série</th>
													<th class="text-middle">Natureza da Operação</th>
													<th class="text-middle">Destinatário</th>
													<th class="text-middle text-center">Data de Emissão</th>
													<th class="text-middle text-center">Data de Saída</th>
													<th class="text-middle text-center">Status</th>
												</thead>
												<tbody>
													<tr>
														<td class="text-middle">
															<div class="btn-group">
																<button type="button" class="btn btn-sm btn-default dropdown-toggle" 
																	data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Ações <span class="caret"></span>
																</button>
																<ul class="dropdown-menu">
																	<li><a href="nota-fiscal.php"><i class="fa fa-file-pdf-o"></i> Visualizar DANFE (PDF)</a></li>
																	<li role="separator" class="divider"></li>
																	<li><a href="#"><i class="fa fa-times-circle"></i> Cancelar NF-e</a></li>
																	<li><a href="#"><i class="fa fa-list-alt"></i> Visualizar Detalhes</a></li>
																</ul>
															</div>
														</td>
														<td class="text-center text-middle">13443</td>
														<td class="text-center text-middle">1</td>
														<td class="text-middle">VENDA PARA CONSUMIDOR FINAL</td>
														<td class="text-middle">FILIPE MENDONÇA COELHO</td>
														<td class="text-center text-middle">05/04/1991 09:42</td>
														<td class="text-center text-middle">05/04/1991 10:30</td>
														<td class="text-middle">
															<span class="label label-success">Autorizado o Uso da NF-e</span>
														</td>
													</tr>
													<tr>
														<td class="text-middle">
															<div class="btn-group">
																<button type="button" class="btn btn-sm btn-default dropdown-toggle" 
																	data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Ações <span class="caret"></span>
																</button>
																<ul class="dropdown-menu">
																	<li><a href="#"><i class="fa fa-send"></i> Retransmitir NF-E</a></li>
																	<li role="separator" class="divider"></li>
																	<li><a href="#"><i class="fa fa-times-circle"></i> Cancelar NF-e</a></li>
																	<li><a href="#"><i class="fa fa-list-alt"></i> Visualizar Detalhes</a></li>
																</ul>
															</div>
														</td>
														<td class="text-center text-middle">13443</td>
														<td class="text-center text-middle">1</td>
														<td class="text-middle">VENDA PARA CONSUMIDOR FINAL</td>
														<td class="text-middle">FILIPE MENDONÇA COELHO</td>
														<td class="text-center text-middle">05/04/1991 09:42</td>
														<td class="text-center text-middle">05/04/1991 10:30</td>
														<td class="text-middle">
															<span class="label label-danger" data-toggle="tooltip" title="Rejeição: CNPJ inválido!">Erro de Autorização</span>
														</td>
													</tr>
													<tr>
														<td class="text-middle">
															<div class="btn-group">
																<button type="button" class="btn btn-sm btn-default dropdown-toggle" 
																	data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Ações <span class="caret"></span>
																</button>
																<ul class="dropdown-menu">
																	<li><a href="#"><i class="fa fa-times-circle"></i> Cancelar NF-e</a></li>
																	<li><a href="#"><i class="fa fa-list-alt"></i> Visualizar Detalhes</a></li>
																</ul>
															</div>
														</td>
														<td class="text-center text-middle">13443</td>
														<td class="text-center text-middle">1</td>
														<td class="text-middle">VENDA PARA CONSUMIDOR FINAL</td>
														<td class="text-middle">FILIPE MENDONÇA COELHO</td>
														<td class="text-center text-middle">05/04/1991 09:42</td>
														<td class="text-center text-middle">05/04/1991 10:30</td>
														<td class="text-middle">
															<span class="label label-warning">Processando Autorização</span>
														</td>
													</tr>
													<tr>
														<td class="text-middle">
															<div class="btn-group">
																<button type="button" class="btn btn-sm btn-default dropdown-toggle" 
																	data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Ações <span class="caret"></span>
																</button>
																<ul class="dropdown-menu">
																	<li><a href="#"><i class="fa fa-times-circle"></i> Cancelar NF-e</a></li>
																	<li><a href="#"><i class="fa fa-list-alt"></i> Visualizar Detalhes</a></li>
																</ul>
															</div>
														</td>
														<td class="text-center text-middle">13443</td>
														<td class="text-center text-middle">1</td>
														<td class="text-middle">VENDA PARA CONSUMIDOR FINAL</td>
														<td class="text-middle">FILIPE MENDONÇA COELHO</td>
														<td class="text-center text-middle">05/04/1991 09:42</td>
														<td class="text-center text-middle">05/04/1991 10:30</td>
														<td class="text-middle">
															<span class="label label-warning">Lote Processado</span>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade in" id="canceladas">
								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">De</label>
											<div class="input-group">
												<input id="inputDtaEmissao" readonly="readonly" style="background:#FFF;cursor:pointer" type="text" class="datepicker form-control input-sm">
												<span  id="btnDtaEmissao" class="input-group-addon"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">Até</label>
											<div class="input-group">
												<input id="inputDtaEmissao" readonly="readonly" style="background:#FFF;cursor:pointer" type="text" class="datepicker form-control input-sm">
												<span  id="btnDtaEmissao" class="input-group-addon"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label for="" class="control-label">Tipo de Cadastro</label>
											<div class="form-group">
												<label class="label-radio inline">
													<input ng-model="empreendimento.flg_contribuinte_icms" value="0" type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Pessoa Física</span>
												</label>
												<label class="label-radio inline">
													<input ng-model="empreendimento.flg_contribuinte_icms" value="1" type="radio" class="inline-radio">
													<span class="custom-radio"></span>
													<span>Pessoa Jurídica</span>
												</label>
											</div>
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label class="control-label">Destinatário</label> 
											<select chosen
											    option="lista_finalidade_emissao"
											    ng-model="NF.dados_emissao.finalidade_emissao"
											    ng-options="item.num_item as item.nme_item for item in lista_finalidade_emissao">
											</select>
										</div>
									</div>

									<div class="col-sm-1">
										<div class="form-group">
											<label class="control-label"><br></label>
											<button type="button" class="btn btn-sm btn-primary" ng-click="load(0,20)"><i class="fa fa-filter"></i> Filtrar</button>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="table table-bordered table-condensed table-striped table-hover">
												<thead>
													<th class="text-middle text-center" width="50"></th>
													<th class="text-middle text-center">Nº NF-e</th>
													<th class="text-middle text-center">Nº Série</th>
													<th class="text-middle">Natureza da Operação</th>
													<th class="text-middle">Destinatário</th>
													<th class="text-middle">E-mail Destinatário</th>
													<th class="text-middle text-center">Data de Emissão</th>
													<th class="text-middle text-center">Data de Saída</th>
												</thead>
												<tbody>
													<tr>
														<td class="text-middle">
															<div class="btn-group">
																<button type="button" class="btn btn-sm btn-default dropdown-toggle" 
																	data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Ações <span class="caret"></span>
																</button>
																<ul class="dropdown-menu">
																	<li><a href="nota-fiscal.php"><i class="fa fa-file-pdf-o"></i> Visualizar DANFE (PDF)</a></li>
																	<li role="separator" class="divider"></li>
																	<li><a href="#"><i class="fa fa-list-alt"></i> Visualizar Detalhes</a></li>
																</ul>
															</div>
														</td>
														<td class="text-center text-middle">13443</td>
														<td class="text-center text-middle">1</td>
														<td class="text-middle">VENDA PARA CONSUMIDOR FINAL</td>
														<td class="text-middle">FILIPE MENDONÇA COELHO</td>
														<td class="text-middle">filipe.mendonca.coelho@gmail.com</td>
														<td class="text-center text-middle">05/04/1991 09:42</td>
														<td class="text-center text-middle">05/04/1991 10:30</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade in" id="inutilizadas">
								
							</div>
						</div>
					</div>
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

	<!-- Modernizr -->
	<script src='js/modernizr.min.js'></script>

    <!-- Pace -->
	<script src='js/pace.min.js'></script>

	<!-- Popup Overlay -->
	<script src='js/jquery.popupoverlay.min.js'></script>

    <!-- Slimscroll -->
	<script src='js/jquery.slimscroll.min.js'></script>

	<!-- Datepicker -->
	<script src='js/bootstrap-datepicker.min.js'></script>

	<!-- Cookie -->
	<script src='js/jquery.cookie.min.js'></script>

	<!-- Endless -->
	<script src="js/endless/endless.js"></script>

	<!-- Chosen -->
	<script src='js/chosen.jquery.min.js'></script>

	<!-- Extras -->
	<script src="js/extras.js"></script>

	<!-- Moment -->
	<script src="js/moment/moment.min.js"></script>

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
    <script type="text/javascript">
    	$('.datepicker').datepicker();
    	$("#btnDtaEmissao").on("click", function(){ $("#inputDtaEmissao").trigger("focus"); });
		$("#btnDtaSaida").on("click", function(){ $("#inputDtaSaida").trigger("focus"); });

		$('.datepicker').on('changeDate', function(ev){$(this).datepicker('hide');});
    	var addParamModule = ['angular.chosen'] ;
    </script>
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js"></script>
	<script src="js/angular-controller/notas_fiscais-controller.js"></script>
	<script type="text/javascript"></script>>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
