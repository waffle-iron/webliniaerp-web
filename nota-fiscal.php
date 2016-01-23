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

  <body class="overflow-hidden" ng-controller="DepositosController" ng-cloak>
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
					 <li class="active"><i class="fa fa-file"></i> Consulta/Visualização de Nota Fiscal</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-file"></i> Consulta/Visualização de Nota Fiscal</h3>
				</div><!-- /page-title -->
			</div><!-- /main-header -->

			<div class="padding-md">
				<div class="alert alert-sistema alert-info">
					<p>
						<strong><i class="fa fa-info-circle"></i> Atenção!</strong>
						<br/>
						Abaixo constam informações do emitente, destinatário e dos produtos, conforme os dados cadastrais.
						<br/>
						Caso alguma informação esteja incorreta, você deve realizar as alterações em seus respectivos cadastros e ao voltar a esta tela, solicitar a atualização dos dados da NF-e.
					</p>
				</div>

				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Nota Fiscal Eletrônica Nº 482364234</h3>
					</div>

					<div class="panel-tab clearfix">
						<ul class="tab-bar">
							<li class="active"><a href="#emitente" data-toggle="tab"><i class="fa fa-building-o"></i> Dados do Emitente</a></li>
							<li><a href="#destinatario" data-toggle="tab"><i class="fa fa-user"></i> Dados do Destinatário</a></li>
							<li><a href="#transportadora" data-toggle="tab"><i class="fa fa-truck"></i> Dados da Transportadora</a></li>
							<li><a href="#produtos" data-toggle="tab"><i class="fa fa-list"></i> Produtos</a></li>
							<li><a href="#resumo" data-toggle="tab"><i class="fa fa-bars"></i> Resumo da NF-e</a></li>
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="emitente">
								<div class="alert" style="display:none"></div>

								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">CPF / CNPJ</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">I.E.</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">I.E. Sub. Tributária</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label class="control-label">Regime Tributário</label> 
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group" data-toggle="tooltip" title="Apenas Simples Nacional">
											<label class="control-label">% Crédito</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-5">
										<div class="form-group">
											<label class="control-label">Razão Social</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Nome Fantasia</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade in" id="destinatario">
								<div class="alert" style="display:none"></div>

								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">CPF / CNPJ</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">I.E.</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">ID Sub. Tributária</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">Inscrição Municipal</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">ID Estrangeiro</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-5">
										<div class="form-group">
											<label class="control-label">Nome Fantasia</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">E-mail</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade in" id="transportadora">
								<div class="alert" style="display:none"></div>

								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">CNPJ</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-5">
										<div class="form-group">
											<label class="control-label">Nome Fantasia</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-3">
										<div class="form-group">
											<label class="control-label">Modalidade de Frete</label> 
											<select chosen
											    option="lista_operacao"
											    ng-model="configuracoes.id_operacao_padrao_venda"
											    ng-options="operacao.cod_operacao as operacao.dsc_operacao for operacao in lista_operacao">
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade in" id="produtos">
								<div class="table-responsive">
									<table class="table table-bordered table-condensed table-striped table-hover">
										<thead>
											<tr>
												<th class="text-middle text-center" rowspan="2">Cód. EAN</th>
												<th class="text-middle" rowspan="2">Descrição</th>
												<th class="text-middle text-center" rowspan="2">Cód. NCM</th>
												<th class="text-middle text-center" rowspan="2">CST</th>
												<th class="text-middle text-center" rowspan="2">CFOP</th>
												<th class="text-middle text-center" rowspan="2">Un. Medida</th>
												<th class="text-middle text-center" rowspan="2">Qtd.</th>
												<th class="text-middle" rowspan="2">Valor Unit.</th>
												<th class="text-middle" rowspan="2">Valor Total</th>
												<th class="text-middle" rowspan="2">B.Calc. ICMS</th>
												<th class="text-middle" rowspan="2">Valor ICMS</th>
												<th class="text-middle" rowspan="2">Valor IPI</th>
												<th class="text-middle text-center" colspan="2">Aliquotas</th>
											</tr>
											<tr>
												<th class="text-middle text-center">ICMS</th>
												<th class="text-middle text-center">IPI</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-middle text-center">7.06.0006.07</td>
												<td class="text-middle">CHINELO PERSONALIZADO CPT. S+P</td>
												<td class="text-middle text-center">64022000</td>
												<td class="text-middle text-center">0101</td>
												<td class="text-middle text-center">6102</td>
												<td class="text-middle text-center">PAR</td>
												<td class="text-middle text-center">56</td>
												<td class="text-middle text-right">R$ 2,81</td>
												<td class="text-middle text-right">R$ 157,36</td>
												<td class="text-middle text-right">R$ 0,00</td>
												<td class="text-middle text-right">R$ 0,00</td>
												<td class="text-middle text-right">R$ 0,00</td>
												<td class="text-middle text-center">0%</td>
												<td class="text-middle text-center">0%</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="tab-pane fade in" id="resumo">
								<div class="alert" style="display:none"></div>

								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">B. Cálc. ICMS</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total ICMS</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total ICMS Deson.</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">B. Cálc. ICMS ST</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total ICMS ST</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total IPI</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total COFINS</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Outros</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total Produtos</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total Frete</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total Seguros</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total Descontos</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total do II</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Total NF</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>

									<div class="col-sm-2">
										<div class="form-group">
											<label class="control-label">V. Aprox. Tributos</label>
											<input type="text" class="form-control input-sm" readonly="readonly">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer clearfix">
						<div class="pull-right">
							<button type="button" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i> Atualizar Informações e Recalcular Impostos</button>
							<button type="button" class="btn btn-sm btn-success"><i class="fa fa-send"></i> Transmitir NF-e</button>
							<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-file-text-o"></i> Emitir DANFE (PDF)</button>
							<button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i> Cancelar NF-e</button>
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

	<!-- Cookie -->
	<script src='js/jquery.cookie.min.js'></script>

	<!-- Endless -->
	<script src="js/endless/endless.js"></script>

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
    <script type="text/javascript">
    	var addParamModule = ['angular.chosen'] ;
    </script>
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js"></script>
	<script src="js/angular-controller/depositos-controller.js"></script>
	<script type="text/javascript"></script>>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
