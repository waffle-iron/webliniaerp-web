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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

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

	<!-- Agenda -->
    <link href='js/agenda/fullcalendar.css' rel='stylesheet' />
    <link href='js/agenda/fullcalendar.print.css' rel='stylesheet' media='print' />

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

  <body class="overflow-hidden" ng-controller="RelatorioDiarioClinicaController" ng-cloak>
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
			<div class="padding-md">
				<div class="clearfix">
					<div class="pull-left">
						<span class="img-demo">
							<img src="assets/imagens/logos/{{ userLogged.nme_logo }}">
						</span>

						<div class="pull-left m-left-sm">
							<h3 class="m-bottom-xs m-top-xs">Relatório Diário de Atendimento</h3>
							<span class="text-muted"><strong>COSB II - Alagoinhas</strong></span>
						</div>
					</div>

					<div class="pull-right text-right">
						<h5><strong>#<?php echo rand(); ?></strong></h5>
						<strong><?php echo date("d/m/Y"); ?></strong>
					</div>
				</div>

				<hr>

				<div class="panel panel-default">
					<div class="panel-body clearfix">
						<div class="col-lg-9">
							<form role="form" class="form form-horizontal">
								<div class="form-group no-margin">
									<label class="control-label col-lg-2">Data Apuração:</label>
									<div class="col-lg-3">
										<div class="input-group">
											<input class="form-control input-sm"/>
											<span class="input-group-btn">
												<button class="btn btn-default btn-sm" type="button">
													<i class="fa fa-calendar"></i>
												</button>
											</span>
										</div>
									</div>

									<div class="col-lg-3">
										<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-filter"></i> Gerar Relatório</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-lg-3 clearfix">
							<button type="button" class="btn btn-sm btn-success pull-right"><i class="fa fa-print"></i> Imprimir</button>
						</div>
					</div>
				</div>

				<h3>Despesas Gerais</h3>
				<hr/>

				<h5>Comissionados</h5>
				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<th>Sacado</th>
						<th class="text-center">Valor</th>
						<th>Referente a</th>
						<th>Forma de Pagamento</th>
						<th width="400">Assinatura</th>
					</thead>
					<tbody>
						<tr>
							<td>Dr. Gustavo Ribeiro</td>
							<td class="text-right">R$ 459,19</td>
							<td>10%</td>
							<td>Dinheiro</td>
							<td></td>
						</tr>
					</tbody>
				</table>

				<h5>Outras Despesas</h5>
				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<th>Sacado</th>
						<th class="text-center">Valor</th>
						<th>Referente a</th>
						<th>Forma de Pagamento</th>
						<th width="400">Assinatura</th>
					</thead>
					<tbody>
						<tr>
							<td class="text-center" colspan="5">Nenhum registro encontrado</td>
						</tr>
					</tbody>
				</table>

				<h3>Controle de Atendimento</h3>
				<hr/>

				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<th>Matricula</th>
						<th>Nome</th>
						<th>Valor Pago</th>
						<th>Forma de Pagamento</th>
						<th>Profissional</th>
					</thead>
					<tbody>
						<tr>
							<td>H14123</td>
							<td>José Bezerra da Silva</td>
							<td class="text-right">R$ 1.423,12</td>
							<td>Dinheiro</td>
							<td>Dr. Gustavo Ribeiro</td>
						</tr>
					</tbody>
				</table>

				<h3>Recebimentos por Forma de Pagamento</h3>
				<hr/>

				<h5>Cartão de Crédito</h5>
				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<th>Matricula</th>
						<th>Nome</th>
						<th>Telefone</th>
						<th class="text-center">Valor</th>
					</thead>
					<tbody>
						<tr>
							<td>H23753</td>
							<td>Marisa da Silva Souza</td>
							<td>(11) 93762-3413</td>
							<td class="text-right">R$ 1.373,23</td>
						</tr>
					</tbody>
				</table>

				<h5>Cartão de Débito</h5>
				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<th>Matricula</th>
						<th>Nome</th>
						<th>Telefone</th>
						<th class="text-center">Valor</th>
					</thead>
					<tbody>
						<tr>
							<td>H23753</td>
							<td>Marisa da Silva Souza</td>
							<td>(11) 93762-3413</td>
							<td class="text-right">R$ 1.373,23</td>
						</tr>
					</tbody>
				</table>

				<h5>Cheque</h5>
				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<th>Matricula</th>
						<th>Nome</th>
						<th>Telefone</th>
						<th class="text-center">Valor</th>
					</thead>
					<tbody>
						<tr>
							<td>H23753</td>
							<td>Roberto da Silva Rocha</td>
							<td>(11) 95435-4122</td>
							<td class="text-right">R$ 4.826,23</td>
						</tr>
						<tr>
							<td>H23753</td>
							<td>Roberto da Silva Rocha</td>
							<td>(11) 95435-4122</td>
							<td class="text-right">R$ 246,86</td>
						</tr>
					</tbody>
				</table>

				<h5>Dinheiro</h5>
				<table class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<th>Matricula</th>
						<th>Nome</th>
						<th>Telefone</th>
						<th class="text-center">Valor</th>
					</thead>
					<tbody>
						<tr>
							<td>H23753</td>
							<td>Roberto da Silva Rocha</td>
							<td>(11) 95435-4122</td>
							<td class="text-right">R$ 4.826,23</td>
						</tr>
						<tr>
							<td>H23753</td>
							<td>Roberto da Silva Rocha</td>
							<td>(11) 95435-4122</td>
							<td class="text-right">R$ 246,86</td>
						</tr>
					</tbody>
				</table>

				<h3>Consolidado Geral</h3>
				<hr/>

				<div class="row">
					<div class="col-lg-5">
						<table class="table table-bordered table-hover table-striped table-condensed">
							<tbody>
								<tr>
									<th>Total Recebimentos (bruto) <span class="badge badge-primary pull-right">A</span></th>
									<th class="text-right">R$ 1486,37</th>
								</tr>
								<tr>
									<th>Total Despesas <span class="badge badge-primary pull-right">B</span></th>
									<th class="text-right">R$ 1486,37</th>
								</tr>
								<tr>
									<th>Total Líquido <span class="badge badge-primary pull-right">C=(A-B)</span></th>
									<th class="text-right">R$ 1486,37</th>
								</tr>
								<tr>
									<th>Total a Receber (C.Crédito/Cheques) <span class="badge badge-primary pull-right">D</span></th>
									<th class="text-right">R$ 1486,37</th>
								</tr>
								<tr>
									<th>Mapa Real (saldo) <span class="badge badge-primary pull-right">E=(C-D)</span></th>
									<th class="text-right">R$ 1486,37</th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<h3>Estatística por Profissional</h3>
				<hr/>

				<div class="row">
					<div class="col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h5 class="panel-title">Dra. Ana Paula da Silva Pereira</h5>
							</div>
							<div class="panel-body">
								<table class="table table-bordered table-hover table-striped table-condensed">
									<tbody>
										<tr>
											<th>Total de Fichas Atendidas</th>
											<th class="text-right">12</th>
										</tr>
										<tr>
											<th>Total de Fichas c/ Acréscimo</th>
											<th class="text-right">0</th>
										</tr>
										<tr>
											<th>Total de Orçamentos</th>
											<th class="text-right">0</th>
										</tr>
										<tr>
											<th>Total de Orçamentos Contratados</th>
											<th class="text-right">4</th>
										</tr>
										<tr>
											<th>Total de Orçamentos Não Contratados</th>
											<th class="text-right">4</th>
										</tr>
										<tr>
											<th>Porcentagem (%) de Contratação</th>
											<th class="text-right">70%</th>
										</tr>
										<tr>
											<th>Média de Pagamentos por Orçamento</th>
											<th class="text-right">R$ 137,87</th>
										</tr>
										<tr>
											<th>Total de Pacientes</th>
											<th class="text-right">42</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h5 class="panel-title">Dr. Bento Rodrigues Silveira</h5>
							</div>
							<div class="panel-body">
								<table class="table table-bordered table-hover table-striped table-condensed">
									<tbody>
										<tr>
											<th>Total de Fichas Atendidas</th>
											<th class="text-right">12</th>
										</tr>
										<tr>
											<th>Total de Fichas c/ Acréscimo</th>
											<th class="text-right">0</th>
										</tr>
										<tr>
											<th>Total de Orçamentos</th>
											<th class="text-right">0</th>
										</tr>
										<tr>
											<th>Total de Orçamentos Contratados</th>
											<th class="text-right">4</th>
										</tr>
										<tr>
											<th>Total de Orçamentos Não Contratados</th>
											<th class="text-right">4</th>
										</tr>
										<tr>
											<th>Porcentagem (%) de Contratação</th>
											<th class="text-right">70%</th>
										</tr>
										<tr>
											<th>Média de Pagamentos por Orçamento</th>
											<th class="text-right">R$ 137,87</th>
										</tr>
										<tr>
											<th>Total de Pacientes</th>
											<th class="text-right">42</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h5 class="panel-title">Dra. Grasiela Nicolaci</h5>
							</div>
							<div class="panel-body">
								<table class="table table-bordered table-hover table-striped table-condensed">
									<tbody>
										<tr>
											<th>Total de Fichas Atendidas</th>
											<th class="text-right">12</th>
										</tr>
										<tr>
											<th>Total de Fichas c/ Acréscimo</th>
											<th class="text-right">0</th>
										</tr>
										<tr>
											<th>Total de Orçamentos</th>
											<th class="text-right">0</th>
										</tr>
										<tr>
											<th>Total de Orçamentos Contratados</th>
											<th class="text-right">4</th>
										</tr>
										<tr>
											<th>Total de Orçamentos Não Contratados</th>
											<th class="text-right">4</th>
										</tr>
										<tr>
											<th>Porcentagem (%) de Contratação</th>
											<th class="text-right">70%</th>
										</tr>
										<tr>
											<th>Média de Pagamentos por Orçamento</th>
											<th class="text-right">R$ 137,87</th>
										</tr>
										<tr>
											<th>Total de Pacientes</th>
											<th class="text-right">42</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h5 class="panel-title">Dr. Paulo Barreto da Silva</h5>
							</div>
							<div class="panel-body">
								<table class="table table-bordered table-hover table-striped table-condensed">
									<tbody>
										<tr>
											<th>Total de Fichas Atendidas</th>
											<th class="text-right">12</th>
										</tr>
										<tr>
											<th>Total de Fichas c/ Acréscimo</th>
											<th class="text-right">0</th>
										</tr>
										<tr>
											<th>Total de Orçamentos</th>
											<th class="text-right">0</th>
										</tr>
										<tr>
											<th>Total de Orçamentos Contratados</th>
											<th class="text-right">4</th>
										</tr>
										<tr>
											<th>Total de Orçamentos Não Contratados</th>
											<th class="text-right">4</th>
										</tr>
										<tr>
											<th>Porcentagem (%) de Contratação</th>
											<th class="text-right">70%</th>
										</tr>
										<tr>
											<th>Média de Pagamentos por Orçamento</th>
											<th class="text-right">R$ 137,87</th>
										</tr>
										<tr>
											<th>Total de Pacientes</th>
											<th class="text-right">42</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<h3>Estatística Geral da Clínica</h3>
				<hr/>

				<div class="row">
					<div class="col-lg-4">
						<table class="table table-bordered table-hover table-striped table-condensed">
							<tbody>
								<tr>
									<th>Total de Pacientes</th>
									<th class="text-right">486</th>
								</tr>
								<tr>
									<th>Total de Pacientes Atendidos</th>
									<th class="text-right">375</th>
								</tr>
								<tr>
									<th>Pacientes sem Orçamento</th>
									<th class="text-right">86</th>
								</tr>
								<tr>
									<th>Total de Pagantes</th>
									<th class="text-right">265</th>
								</tr>
								<tr>
									<th>Média de Pagamentos por Paciente</th>
									<th class="text-right">R$ 184,76</th>
								</tr>
								<tr>
									<th>Total de Orçamentos</th>
									<th class="text-right">R$ 2.633,37</th>
								</tr>
								<tr>
									<th>Total de Orçamentos Contratados</th>
									<th class="text-right">R$ 2.289,07</th>
								</tr>
								<tr>
									<th>Total de Orçamentos Não Contratados</th>
									<th class="text-right">R$ 1.231,76</th>
								</tr>
								<tr>
									<th>Porcentagem (%) de Contratação</th>
									<th class="text-right">76%</th>
								</tr>
								<tr>
									<th>Média de Pagamento por Contratação</th>
									<th class="text-right">R$ 363,76</th>
								</tr>
								<tr>
									<th>Total de Fichas Liquidadas</th>
									<th class="text-right">85</th>
								</tr>
							</tbody>
						</table>
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

	<!-- Agenda -->
	<script src='js/agenda/lib/moment.min.js'></script>
	<script src='js/agenda/lib/jquery.min.js'></script>
	<script src='js/agenda/fullcalendar.min.js'></script>
	<script src='js/agenda/lang-all.js'></script> 

	<!-- Bootstrap -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Easy Modal -->
    <script src="js/eModal.js"></script>

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
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js"></script>
	<script src="js/angular-controller/relatorio-diario-clinica_controller.js"></script>
	<script type="text/javascript"></script>>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
