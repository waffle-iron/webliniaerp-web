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

  <body class="overflow-hidden" ng-controller="AgendamentoConsultaController" ng-cloak>
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
					 <li class="active"><i class="fa fa-list"></i> Controle de Atendimento</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-list"></i> Controle de Atendimento</h3>
					<br/>
					<button class="btn btn-info" id="btn-novo" ng-click="showBoxNovo()"><i class="fa fa-plus-circle"></i> Novo Atendimento</button>
				</div><!-- /page-title -->
			</div><!-- /main-header -->

			<div class="padding-md">
				<div class="panel panel-primary"  id="box-novo">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-plus-circle"></i> Novo Atendimento</h3>
					</div>
					<div class="panel-body">
						<fieldset>
							<legend class="clearfix">
								<span class="">Dados do Cliente</span>
								<div class="pull-right">
									<button type="button" class="btn btn-xs btn-default" ng-click="selCliente()"><i class="fa fa-users"></i> Selecionar Cliente Existente</button>
									<button type="button" class="btn btn-xs btn-primary" ng-click="btnInsertCliente()"><i class="fa fa-plus-circle"></i> Cadastrar Novo Cliente</button>
								</div>
							</legend>

							<form class="form form-horizontal" role="form">
								<div class="form-group">
									<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">Nome:</label> 
									<div class="col-xs-12 col-sm-7 col-md-7 col-lg-6" id="nome">
										<input type="text" class="form-control input-sm" ng-model="cliente.nome">
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">E-mail:</label> 
									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" id="email">
										<input type="text" class="form-control input-sm" ng-model="cliente.email">
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" style="padding-top: 0;">Telefone<br class="hidden-xs"/><span class="hidden-sm hidden-md hidden-lg"> </span>(Fixo):</label> 
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2" id="tel_fixo">
										<input ui-mask="(99) 99999999" ng-model="cliente.tel_fixo" type="text" class="form-control input-sm">
									</div>

									<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label" style="padding-top: 0;">Telefone<br class="hidden-xs"/><span class="hidden-sm hidden-md hidden-lg"> </span>(Celular):</label> 
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2" id="celular">
										<input ui-mask="(99) 99999999?9" ng-model="cliente.celular" type="text" class="form-control input-sm">
									</div>
								</div>
							</form>
						</fieldset>
					</div>

					<div class="panel-footer clearfix">
						<div class="pull-right">
							<button class="btn btn-success" id="btn-incluir-fila"  data-loading-text="<i class='fa fa-refresh fa-spin'></i> Incluindo na fila de atendimento" ng-click="novoAtendimento()"><i class="fa fa-indent"></i> Incluir na fila de atendimento</button>
							<button class="btn btn-danger" ng-click="cancelarCadastroCliente()"><i class="fa fa-times-circle"></i> Cancelar</button>
						</div>
					</div>
				</div>


				<div class="panel panel-default">
					<div class="panel-body">
						<table class="table table-bordered table-hover table-striped table-condensed">
							<thead>
								<th>Chegada</th>
								<th>Ficha</th>
								<th>Paciente</th>
								<th>Status</th>
								<th>Valor</th>
								<th>Principal</th>
								<th>Ações</th>
							</thead>
							<tbody>
								<tr ng-repeat="paciente in lista_atendimento">
									<td>{{ paciente.dta_entrada | dateFormat:'time' }}</td>
									<td>{{ null }}</td>
									<td>{{ paciente.nome_paciente }}</td>
									<td>{{paciente.dsc_status}}</td>
									<td>{{ null }}</td>
									<td>{{ paciente.nome_profissional }}</td>
									<td>
										<button class="btn btn-xs btn-success" ng-click="iniciarAtendimento(paciente)" data-toggle="tooltip" title="Iniciar Atendimento">
											<i class="fa fa-play"></i>
										</button>
										<button class="btn btn-xs btn-danger" data-toggle="tooltip" title="Finalizar Atendimento">
											<i class="fa fa-stop"></i>
										</button>
										<button class="btn btn-xs btn-primary" data-toggle="tooltip" title="Abrir Fichar do Paciente">
											<i class="fa fa-user"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div><!-- /main-container -->

		<!-- /Modal Processando Venda-->
		<div class="modal fade" id="modalFichaPaciente" style="display:none">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Ficha do Paciente</h4>
      				</div>
				    <div class="modal-body bg-trans-dark">
				    	<div class="panel-tab clearfix">
							<ul class="tab-bar">
								<li class="active"><a href="#dados" data-toggle="tab"><i class="fa fa-user"></i> Dados Cadastrais</a></li>
								<li><a href="#procedimentos" data-toggle="tab"><i class="fa fa-list-alt"></i> Procedimentos</a></li>
							</ul>
						</div>

						<div class="tab-content">
							<div class="tab-pane fade in active" id="dados">
								<form class="form form-horizontal" role="form">
									<div class="form-group">
										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label">Nome:</label> 
										<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7" id="nome">
											<input type="text" class="form-control input-sm" ng-model="cliente.nome">
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label">E-mail:</label> 
										<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5" id="email">
											<input type="text" class="form-control input-sm" ng-model="cliente.email">
										</div>

										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label" style="padding-top: 0;">Telefone<br class="hidden-xs"/><span class="hidden-sm hidden-md hidden-lg"> </span>(Fixo):</label> 
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2" id="tel_fixo">
											<input ui-mask="(99) 99999999" ng-model="cliente.tel_fixo" type="text" class="form-control input-sm">
										</div>

										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label" style="padding-top: 0;">Telefone<br class="hidden-xs"/><span class="hidden-sm hidden-md hidden-lg"> </span>(Celular):</label> 
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2" id="celular">
											<input ui-mask="(99) 99999999?9" ng-model="cliente.celular" type="text" class="form-control input-sm">
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label">CEP:</label> 
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" id="nome">
											<input type="text" class="form-control input-sm" ng-model="cliente.nome">
										</div>

										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label">Endereço:</label> 
										<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5" id="nome">
											<input type="text" class="form-control input-sm" ng-model="cliente.nome">
										</div>

										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label">No:</label> 
										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" id="nome">
											<input type="text" class="form-control input-sm" ng-model="cliente.nome">
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label">Bairro:</label> 
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="nome">
											<input type="text" class="form-control input-sm" ng-model="cliente.nome">
										</div>

										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label">Estado:</label> 
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="nome">
											<input type="text" class="form-control input-sm" ng-model="cliente.nome">
										</div>

										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label">Cidade:</label> 
										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="nome">
											<input type="text" class="form-control input-sm" ng-model="cliente.nome">
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 control-label sr-only"></label> 
										<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11" id="nome">
											<button class="btn btn-success pull-right"><i class="fa fa-save"></i> Salvar Informações</button>
										</div>
						    		</div>
								</form>
							</div>

							<div class="tab-pane fade" id="procedimentos">
								<form class="form" role="form">
									<div class="row">
										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Procedimento</label>
												<div class="controls">
													<div class="input-group">
														<input type="text" class="form-control input-sm">
														<span class="input-group-btn">
															<button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Dente/Região</label>
												<div class="controls">
													<div class="input-group">
														<input type="text" class="form-control input-sm">
														<span class="input-group-btn">
															<button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label class="control-label">Face</label>
												<div class="controls">
													<div class="input-group">
														<input type="text" class="form-control input-sm">
														<span class="input-group-btn">
															<button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="col-lg-2">
											<div class="form-group">
												<label class="control-label">Valor</label>
												<div class="controls">
													<input class="form-control"/>
												</div>
											</div>
										</div>

										<div class="col-lg-1">
											<div class="form-group">
												<label class="control-label"><br/></label>
												<div class="controls">
													<button class="btn btn-sm btn-primary" data-toggle="tooltip" title="Incluir procedimento"><i class="fa fa-plus-square"></i></button>
												</div>
											</div>
										</div>
									</div>
								</form>

								<table class="table table-bordered table-hover table-striped table-condensed">
									<thead>
										<th>Procedimento</th>
										<th>Dente/Região</th>
										<th>Face</th>
										<th>Status</th>
										<th>Agendamento</th>
										<th>Valor</th>
										<th>Ações</th>
									</thead>
									<tbody>
										<tr>
											<td>EIXO LATIDUNINAL</td>
											<td>Dente 1</td>
											<td>Todo o Dente</td>
											<td><i class="fa fa-circle text-danger"></i> Pendente</td>
											<td>25/04/2016</td>
											<td class="text-right"><i class="fa fa-circle text-danger"></i> R$ 2.424,42</td>
											<td>
												<button class="btn btn-xs btn-primary" data-toggle="tooltip" title="Efetuar pagamento">
													<i class="fa fa-money"></i>
												</button>
												<button class="btn btn-xs btn-primary" data-toggle="tooltip" title="Agendar realização">
													<i class="fa fa-calendar"></i>
												</button>
												<button class="btn btn-xs btn-danger" data-toggle="tooltip" title="Cancelar agendamento">
													<i class="fa fa-times-circle"></i>
												</button>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<th class="text-right" colspan="5">Total</th>
										<th class="text-right">R$ 13.423,93</th>
										<th></th>
									</tfoot>
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

		<!-- /Modal Clientes-->
        <div class="modal fade" id="list_clientes" style="display:none">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Pacientes</span></h4>
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
                                    <tr ng-show="clientes != false && (clientes.length <= 0 || clientes == null)">
                                        <th class="text-center" colspan="9" style="text-align:center"><strong>Carregando</strong><img src="assets/imagens/progresso_venda.gif"></th>
                                    </tr>
                                    <tr ng-show="clientes == false">
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

        <!-- /Modal Clientes-->
        <div class="modal fade" id="list_profissionais" style="display:none">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Profissionais</span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input ng-model="busca.profissionais"  ng-enter="loadProfissionais(0,10)" type="text" class="form-control input-sm">
                                    <div class="input-group-btn">
                                        <button ng-click="loadProfissionais(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
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
                                    <tr ng-show="profissionais != false && (profissionais.length <= 0 || profissionais == null)">
                                        <th class="text-center" colspan="9" style="text-align:center"><strong>Carregando</strong><img src="assets/imagens/progresso_venda.gif"></th>
                                    </tr>
                                    <tr ng-show="profissionais == false">
                                        <th colspan="4" class="text-center">Não a resultados para a busca</th>
                                    </tr>
                                    <thead ng-show="(profissionais.length != 0)">
                                        <tr>
                                            <th >Nome</th>
                                            <th >Apelido</th>
                                            <th >Perfil</th>
                                            <th colspan="2">selecionar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in profissionais">
                                            <td>{{ item.nome }}</td>
                                            <td>{{ item.apelido }}</td>
                                            <td>{{ item.nome_perfil }}</td>
                                            <td width="50" align="center">
                                                <button ng-show="id_profissional_atendimento != item.id" type="button" class="btn btn-xs btn-success" ng-click="addProfissional(item)">
                                                    <i class="fa fa-check-square-o"></i> Selecionar
                                                </button>
                                                <button ng-show="id_profissional_atendimento == item.id" ng-disabled="true" class="btn btn-primary btn-xs" type="button">
                                               		 <i class="fa fa-check-circle-o"></i> Selecionado
                                           		 </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao_profissionais.length > 1">
                                    <li ng-repeat="item in paginacao_profissionais" ng-class="{'active': item.current}">
                                        <a href="" h ng-click="loadProfissionais(item.offset,item.limit)">{{ item.index }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
				    	<button type="button" ng-disabled="id_profissional_atendimento == null" data-loading-text=" Aguarde..." class="btn btn-block btn-md btn-success"
				    		id="btn-aplicar-sangria" ng-click="setInitAtendimento()">
				    		<i class="fa fa-minus-circle"></i> Finalizar
				    	</button>

				    	<button type="button" data-loading-text=" Aguarde..."
				    		class="btn btn-block btn-md btn-default" ng-click="cancelarModal('#list_profissionais')" id="btn-aplicar-sangria">
				    		<i class="fa fa-times-circle"></i> Cancelar
				    	</button>
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
	<script src="js/angular-controller/agendamento_consulta-controller.js"></script>
	<script type="text/javascript"></script>>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
