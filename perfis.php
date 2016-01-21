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

    <!-- ui treeview -->
    <link rel="stylesheet" href="css/bootstrap-treeview.css"/>

    <!-- ui switch -->
    <link rel="stylesheet" href="css/angular-ui-switch.min.css"/>

	<!-- Font Awesome -->
	<link href="css/font-awesome-4.1.0.min.css" rel="stylesheet">

	<!-- Pace -->
	<link href="css/pace.css" rel="stylesheet">

	<!-- Endless -->
	<link href="css/endless.min.css" rel="stylesheet">
	<link href="css/endless-skin.css" rel="stylesheet">

	<link href="css/custom.css" rel="stylesheet">

	<style type="text/css">

		/* Fix for Bootstrap 3 with Angular UI Bootstrap */

		.modal {
			display: block;
		}
		.panel-error {
		  border-color: #a94442 !important;
  		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
           border-color: #843534 !important;
		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483 !important;
		          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483 !important;
		}

		.panel-error .panel-heading {
			 background: rgb(255, 234, 234) !important;
			  border-color: #a94442 !important;
  		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
          color: #a94442 !important ;
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

		#list_produtos .modal-content {min-height: 640px;}

		.switch{
			background: #de3c3c;
    		border: 1px solid #de3c3c;
    		height: 20px;
    		width: 33px;
		}

		.switch small{
    		height: 20px;
    		width: 20px;
		}
		.switch.checked small {
		    left: 13px;
		}


	</style>
  </head>

  <body class="overflow-hidden" ng-controller="PerfisController" ng-cloak>
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
					 <li class="active"><i class="fa  fa-user"></i> Perfis</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa  fa-user"></i> Perfis</h3>
					<br/>
					<a class="btn btn-info" id="btn-novo" ng-disabled="editing" ng-click="showBoxNovo()"><i class="fa fa-plus-circle"></i> Novo Perfil</a>
				</div><!-- /page-title -->
			</div><!-- /main-header -->

			<div class="padding-md">
				<div class="alert alert-sistema" style="display:none"></div>
				<div class="panel panel-default" id="box-novo" style="display:none">
					<div class="panel-heading"><i class="fa fa-plus-circle"></i> Novo Perfil</div>
					<div class="panel-body">
						<form name="myForm">
							<div class="row">
								<div class="col-sm-6">
									<div id="nome" class="form-group">
										<label for="descricao" class="control-label">Descrição</label>
										<input type="text" class="form-control input sm" ng-model="perfil.nome">

									</div>
								</div>
								<div class="col-sm-1">
									<label for="descricao" class="control-label">&nbsp&nbsp</label>
									<div class="control-label">
										<switch id="enabled" name="enabled" ng-model="perfil.status" class="small"></switch>
									</div> 	
									
								</div>
								<div class="col-sm-5">
									<div class="padding-md">
										<div class="panel panel-default" id="modulos">
											<div class="panel-heading"><i class="fa fa-th fa-lg"></i> Módulos
													<span ng-show="perfil.modulos.length > 0" class="pull-right">Selecionados: <span style="background:#504f63" class="badge badge-primary">{{ perfil.modulos.length }}</span></span>
											</div>
											<div style="max-height:305px;min-height:305px;overflow:auto" class="panel-body" id="treeview-modulos">
												
									        </div>
									    </div>
									</div>
								</div>		
							</div>
						</form>
					</div>
					<div class="panel-footer clearfix">
						<div class="pull-right">
							<button ng-click="showBoxNovo(); reset();" type="submit" class="btn btn-danger btn-sm">
								<i class="fa fa-times-circle"></i> Cancelar
							</button>
							<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde " ng-click="salvar($event)" type="submit" class="btn btn-success btn-sm">
								<i class="fa fa-save"></i> Salvar
							</button>
						</div>
					</div>
				</div><!-- /panel -->

				<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-tasks"></i> Perfis cadastradas</div>

					<div class="panel-body" id="panel-listagem">
						<div id="alert" class="alert" style="display:none"></div>
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Descrição</th>
									<th width="46" class="text-center">Status</th>
									<th width="80" style="text-align: center;">Opções</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-show="perfis.perfis == null">
									<td colspan="4" class="text-center">
										<i class='fa fa-refresh fa-spin'></i> Carregando ...
									</td>
								</tr>
								<tr ng-show="perfis.length == 0">
									<td colspan="4" class="text-center">
										Nunhum perfil encontrado
									</td>
								</tr>
								<tr ng-repeat="item in perfis.perfis" bs-tooltip>
									<td width="80">{{ item.id }}</td>
									<td>{{ item.nome }}</td>
									<td ng-if="item.status == 0" class="text-center"><i data-toggle="tooltip" title="Inativo" style="color: #EF3232;" class="fa fa-circle fa-lg"></i></td>
									<td ng-if="item.status == 1" class="text-center"><i  data-toggle="tooltip" style="color: #27A719;" title="Ativo" class="fa fa-circle fa-lg"></i></td>
									<td align="center">
										<button type="button" ng-click="editar(item)" title="Editar" class="btn btn-xs btn-warning" data-toggle="tooltip">
											<i class="fa fa-edit"></i>
										</button>
										<button ng-if="false" type="button" ng-click="delete(item)" title="Excluir" class="btn btn-xs btn-danger delete" data-toggle="tooltip">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="pull-right">
							<ul class="pagination pagination-sm m-top-none" ng-show="perfis.paginacao.length > 1">
								<li ng-repeat="item in perfis.paginacao" ng-class="{'active': item.current}">
									<a href="" h ng-click="loadPerfis(item.offset,item.limit)">{{ item.index }}</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="panel-footer clearfix">
						
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

	<!-- Extras -->
	<script src="js/extras.js"></script>

	<!-- AngularJS -->
	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.min.js"></script>
	<script src="js/bootstrap-treeview.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.tpl.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-ui-utils/mask.min.js"></script>
    <script src="js/angular-sanitize.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="js/angular-ui-switch.min.js"></script>
    <script src="js/dialogs.v2.min.js" type="text/javascript"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script type="text/javascript">
    	var addParamModule = ['uiSwitch'] ;
    </script>
    <script src="js/app.js?version=<?php echo date("dmY-His", filemtime("js/app.js")) ?>"></script>
    <script src="js/auto-complete/AutoComplete.js?version=<?php echo date("dmY-His", filemtime("js/auto-complete/AutoComplete.js")) ?>"></script>
    <script src="js/angular-services/user-service.js?version=<?php echo date("dmY-His", filemtime("js/angular-services/user-service.js")) ?>"></script>
	<script src="js/angular-controller/perfis-controller.js?version=<?php echo date("dmY-His", filemtime("js/angular-controller/Perfis-controller.js")) ?>"></script>
	<script type="text/javascript"></script>>
	<?php include("google_analytics.php"); ?>
  </body>
</html>