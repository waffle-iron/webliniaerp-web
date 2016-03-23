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

		.datepicker {
			z-index: 10000
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


		.custom-table th, .custom-table td {
			height: 28px !important;
			min-height: 28px !important;
			border: 1px solid #999 !important;
			white-space: nowrap;
			overflow: hidden;
			-o-text-overflow: ellipsis;
			   text-overflow: ellipsis;
			-moz-binding: url('xml/ellipsis.xml#ellipsis');
		}

		.custom-table th.border-right, .custom-table td.border-right {
			border-right: 2px solid #999 !important;
		}

		.custom-table th.border-left, .custom-table td.border-left {
			border-left: 2px solid #999 !important;
		}
	</style>
  </head>

  <body class="overflow-hidden" ng-controller="FichaPacienteController" ng-cloak>
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
			<div id="breadcrumb">
				<ul class="breadcrumb">
					 <li><i class="fa fa-home"></i> <a href="dashboard.php">Home</a></li>
					 <li class="active"><i class="fa fa-file-text-o"></i> Ficha do Paciente</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="padding-md">
				<div class="clearfix">
					<div class="pull-left">
						<span class="img-demo">
							<img src="assets/imagens/logos/{{ userLogged.nme_logo }}">
						</span>

						<div class="pull-left m-left-sm">
							<h3 class="m-bottom-xs m-top-xs">Ficha do Paciente</h3>
							<span class="text-muted">Detalhes dos tratamentos e pagamentos realizados</span>
						</div>
					</div>

					<div class="pull-right text-right">
						<h5><strong>#<?php echo rand(); ?></strong></h5>
						<strong><?php echo date("d/m/Y H:i:s"); ?></strong>
					</div>
				</div>

				<hr>

				<div class="panel panel-default">
					<div class="panel-body clearfix">
						<div class="row">
							<div class="col-lg-8">
								<form class="form form-horizontal hide" role="form">
									<div class="form-group no-margin">
										<label class="control-label col-lg-1 text-right">Paciente:</label>
										<div class="controls col-lg-8">
											<div class="input-group">
                        						<input class="form-control input-sm"/>
                        						<span class="input-group-btn">
													<button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" title="">
														<i class="fa fa-search"></i>
													</button>
												</span>
                        					</div>
										</div>
									</div>
								</form>
								<h4 class="m-bottom-xs">Paciente: {{ paciente.nome | uppercase }}</h4>
							</div>

							<div class="col-lg-4 clearfix">
								<div class="pull-right">
									<button type="button" id="printButton" class="btn btn-sm btn-success"><i class="fa fa-print"></i> Imprimir</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="printLayer" class="clearfix">
					<table class="table table-condensed table-hover table-striped table-bordered custom-table">
						<!-- THEAD -->
						<thead>
							<tr>
								<th class="text-center border-right" colspan="5">
									{{ userLogged.nome_empreendimento | uppercase }}
								</th>
								<th class="text-center border-left" colspan="5">
									
								</th>
								<th class="text-center" colspan="3">
									
								</th>
							</tr>
							<tr>
								<th class="text-center border-right" colspan="5">CONTROLE DE ATENDIMENTO</th>
								<th class="text-center border-left" colspan="4">CONTROLE DE PAGAMENTO</th>
								<th class="text-center" colspan="3">ASSINATURA</th>
							</tr>
							<tr>
								<th class="text-center text-middle" style="width: 100px; max-width: 100px;">Data</th>
								<th class="text-center text-middle" style="width: 100px; max-width: 100px;">Dente/Região</th>
								<th class="text-center text-middle" style="width: 100px; max-width: 100px;">Cod. Proc.</th>
								<th class="text-center text-middle" style="width: 100px; max-width: 100px;">Profissional</th>
								<th class="text-center text-middle" style="width: 100px; max-width: 100px;">Valor</th>
								<th class="text-center text-middle border-left" style="width: 100px; max-width: 100px;">Data</th>
								<!--<th class="text-center text-middle" style="width: 100px; max-width: 100px;">Pagou</th>-->
								<th class="text-center text-middle" style="width: 100px; max-width: 100px;">F.Pgto.</th>
								<th class="text-center text-middle" style="width: 100px; max-width: 100px;">Valor</th>
								<th class="text-center text-middle" style="width: 200px; max-width: 200px;">Recep.</th>
								<th class="text-center text-middle" style="width: 200px; max-width: 200px;">Dentista</th>
								<th class="text-center text-middle" style="width: 200px; max-width: 200px;">Paciente</th>
							</tr>
						</thead>
						<!-- END - THEAD -->

						<!-- TBODY -->
						<tbody>
							<tr ng-repeat="item in fichaPaciente">
								<td class="text-center text-middle">{{ item.dta_venda | dateFormat: 'dateTime' }}</td>
								<td class="text-center text-middle">{{ item.cod_dente }}</td>
								<td class="text-center text-middle">{{ item.cod_procedimento }}</td>
								<td class="text-middle">{{ item.nome_profissional }}</td>
								<td class="text-right text-middle border-right">{{ item.valor_real_item == null &&  ' ' || "R$"+( item.valor_real_item | numberFormat: 2 : ',' : '.' ) }}</td>
								<td class="text-center text-middle border-left">{{ item.dta_entrada | dateFormat: 'date' }}</td>
								<!--<td class="text-center text-middle">{{ (item.flg_item_pago == 1) ? 'SIM' : 'NÃO' }}</td>-->
								<td class="text-center text-middle">
									{{ 
										 item.id_forma_pagamento == 6 &&  (item.descricao_forma_pagamento+' em '+ item.num_parcelas+'x') || item.descricao_forma_pagamento 
									}}
								</td>
								<td class="text-right text-middle"> {{ item.valor_pagamento == null && ' ' || "R$"+( item.valor_pagamento | numberFormat: 2 : ',' : '.' ) }}</td>
								<td class="text-middle"></td>
								<td class="text-middle"></td>
								<td class="text-middle"></td>
							</tr>
						</tbody>
						<!-- END - TBODY -->

						<!-- TFOOT -->
						<tfoot>
							<tr>
								<th class="text-right" colspan="4">Total Procedimentos</th>
								<th class="text-right border-right">R$ {{ vlrTotalProcedimentos | numberFormat: 2 : ',' : '.' }}</th>
								<th class="text-right border-left" colspan="2">Total Pago</th>
								<th class="text-right">R$ {{ vlrTotalPagamentos | numberFormat: 2 : ',' : '.' }}</th>
								<th colspan="3"></th>
							</tr>
							<tr>
								<th colspan="3">NOME: <span class="pull-right">{{ paciente.nome | uppercase }}</span></th>
								<th class="border-right" colspan="2">CPF: <span class="pull-right">{{ paciente.cpf }}</span></th>
								<th class="border-left" colspan="3">RG: <span class="pull-right">{{ paciente.rg }}</span></th>
								<th colspan="4">DATA DE NASCIMENTO: <span class="pull-right">{{ paciente.dta_nacimento}}</span></th>
							</tr>
							<tr>
								<th colspan="3">ENDEREÇO: <span class="pull-right">{{ paciente.endereco | uppercase }}, {{ paciente.numero }}</span></th>
								<th class="border-right" colspan="2">CEL.: <span class="pull-right">{{ paciente.celular | phoneFormat }}</span></th>
								<th class="border-left" colspan="3">TEL.: <span class="pull-right">{{ paciente.tel_fixo | phoneFormat }}</span></th>
								<th colspan="4">E-MAIL: <span class="pull-right">{{ paciente.email }}</span></th>
							</tr>
							<tr>
								<th colspan="8"></th>
								<th colspan="4">ASSINATURA: __________________________________________________</th>
							</tr>
						</tfoot>
						<!-- END - TFOOT -->
					</table>
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
	<script src="js/angular-controller/ficha-paciente_controller.js"></script>
	<script type="text/javascript">
		function printDiv(id, pg) {
			var contentToPrint, printWindow;

			contentToPrint = window.document.getElementById(id).innerHTML;
			printWindow = window.open(pg);

		    printWindow.document.write("<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet'>");
			printWindow.document.write("<link href='css/font-awesome.min.css' rel='stylesheet'>");
			printWindow.document.write("<link href='css/pace.css' rel='stylesheet'>");
			printWindow.document.write("<link href='css/endless.min.css' rel='stylesheet'>");
			printWindow.document.write("<link href='css/endless-skin.css' rel='stylesheet'>");

			printWindow.document.write("<style type='text/css' media='print'>@page { size: landscape; } th, td { font-size: 8pt; }</style><style type='text/css'>#printButton{ display:none }.custom-table th, .custom-table td { height: 28px !important; min-height: 28px !important; border: 1px solid #999 !important; white-space: nowrap; overflow: hidden; -o-text-overflow: ellipsis; text-overflow: ellipsis; -moz-binding: url('xml/ellipsis.xml#ellipsis'); } .custom-table th.border-right, .custom-table td.border-right { border-right: 2px solid #999 !important; } .custom-table th.border-left, .custom-table td.border-left { border-left: 2px solid #999 !important; }</style>");

			printWindow.document.write(contentToPrint);
			printWindow.window.print();
		}

		$(function()	{
			$('#printButton').click(function()	{
				printDiv("printLayer", "");
			});
		});
	</script>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
