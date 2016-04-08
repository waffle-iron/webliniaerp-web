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

		.tr-out-estoque td {
			background: #FA8072 !important ;
			color: black;
		}


	</style>
  </head>

  <body class="overflow-hidden" ng-controller="PedidoTransferenciaRecebidoController" ng-cloak>
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
					 <li class="active"><i class="fa fa-sitemap"></i> Depósitos</li>
					 <li class="active"><i class="fa fa-sitemap"></i> Transferência</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-tags"></i> Transferência</h3>
					<!--<br/>
					<a class="btn btn-info" id="btn-novo" ng-disabled="editing" ng-click="showBoxNovo()"><i class="fa fa-plus-circle"></i> Nova Transferência</a>-->
				</div><!-- /page-title -->
			</div><!-- /main-header -->

			<div class="padding-md">
				<div class="alert alert-sistema" style="display:none"></div>

				<div class="panel panel-default" id="box-novo" style="display:none">
					<div class="panel-heading"><i class="fa fa-plus-circle"></i> Nova Transferência</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-sm-12"><div style="display: none" class="alert alert-transferencia-form"></div></div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label">Deposito</label>
									<div class="input-group">
										<input ng-click="selDeposito()" type="text" class="form-control" ng-model="nome_deposito_principal" readonly="readonly" style="cursor: pointer;" />
										<span class="input-group-btn">
											<button ng-click="selDeposito()" type="button"  class="btn"><i class="fa fa-sitemap"></i></button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group" id="produtos">
										<table class="table table-bordered table-condensed table-striped table-hover">
											<thead>
												<tr>
													<td colspan="7"><i class="fa fa-archive"></i> Produtos</td>
													<td width="60" align="center">
													<button class="btn btn-xs btn-primary" ng-disabled="!isNumeric(transferencia.id_empreendimento_transferencia)" ng-click="showProdutos()"><i class="fa fa-plus-circle"></i></button>
													</td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th>ID</th>
													<th>Produto</th>
													<th>Peso</th>
													<th>sabor</th>
													<th>Qtd.Pedida</th>
													<th>Qtd. transferir</th>
													<th width="250">Deposito</th>
													<th></th>
												</tr>
												<tr ng-repeat="item in transferencia.produtos" id="tr-prd-{{ item.id }}">
													<td>{{ item.id	 }}</td>
													<td>{{ item.nome }}</td>
													<td>{{ item.peso }}</td>
													<td>{{ item.sabor }}</td>
													<td width="80" class="text-center">{{ item.qtd_pedida }}</td>
													<td  width="100" align="center"><input style="width: 75px"  ng-model="item.qtd_transferida" type="text" class="form-control input-xs" /></td>
													<td>
														<select ng-change="changeTipoProduto(produto.campo_extra_selected,'sub_tipo')" chosen ng-change="ClearChosenSelect('produto')"
													    option="depositos_chosen"
													    ng-model="item.id_deposito_saida"
													    ng-options="deposito.id as deposito.nme_deposito for deposito in depositos_chosen">
														</select>
													</td>
													<td align="center">
														<button class="btn btn-xs btn-danger" ng-click="excluirProdutoLista($index)"><i class="fa fa-trash-o"></i></button>
													</td>
												</tr>
											</tbody>
										</table>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="pull-right">
							<button ng-click="cancelar()" class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i> Cancelar</button>
							<button ng-click="salvarTransferencia()" class="btn btn-success btn-sm" id="salvar-transferencia" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde...">
								<i class="fa fa-save"></i> Salvar
							</button>

						</div>
						<div style="clear: both;"></div>
					</div>
				</div><!-- /panel -->

				<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-tasks"></i> Pedidos de Transferência Recebidos</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-sm-12"><div style="display: none" class="alert alert-transferencia-lista"></div></div>
						</div>
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Dta. Pedido</th>
									<th>Usuario</th>
									<th>Empreendimento</th>
									<th>Status</th>
									<th width="80" style="text-align: center;">Opções</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="item in listaTransferencias.transferencias" bs-tooltip>
									<td width="80">{{ item.id }}</td>
									<td>{{ item.dta_pedido | dateFormat : 'dateTime' }}</td>
									<td>{{ item.nome_usuario_pedido }}</td>
									<td>{{ item.nome_empreendimento_pedido }}</td>
									<td>{{ item.dsc_status_transferencia_estoque }}</td>
									<td align="center">
										<button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i>" ng-click="editTransferencia(item.id,$event)" title="Realizar Transferência" class="btn btn-xs btn-warning" data-toggle="tooltip">
											<i class="fa fa-edit"></i>
										</button>
										<button type="button"  ng-click="viewTransferencia(item.id)" title="Detalhes" class="btn btn-xs btn-primary" data-toggle="tooltip">
											<i class="fa fa-tasks"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-sm-12">
								<ul class="pagination pagination-xs m-top-none pull-right" ng-show="listaTransferencias.paginacao.length > 1">
									<li ng-repeat="item in listaTransferencias.paginacao" ng-class="{'active': item.current}">
										<a href="" ng-click="loadtransferencias(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /main-container -->

		<!-- Modais
		================================================== -->

		<!-- /Modal empreendimento-->
		<div class="modal fade" id="list_empreendimentos" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Empreendimentos</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.empreendimento" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadAllEmpreendimentos(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>

						<br>

						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(empreendimento.length != 0)">
										<tr>
											<th colspan="2">Nome</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(empreendimento.length == 0)">
											<td colspan="2">Não há empreendimentos cadastrados</td>
										</tr>
										<tr ng-repeat="item in empreendimentos">
											<td>{{ item.nome_empreendimento }}</td>
											<td width="50" align="center">
												<button ng-show="transferencia.id_empreendimento != item.id" type="button" class="btn btn-xs btn-success" ng-click="addEmpreendimento(item)">
													<i class="fa fa-check-square-o"></i> Selecionar
												</button>
												<button ng-show="transferencia.id_empreendimento == item.id" ng-show="existsAcessorio(item)" ng-disabled="true" class="btn btn-primary btn-xs" type="button">
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
				    			<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.empreendimentos.length > 1">
									<li ng-repeat="item in paginacao.empreendimentos" ng-class="{'active': item.current}">
										<a href="" ng-click="loadAllEmpreendimentos(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
				    		</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal produtos-->
		<div class="modal fade" id="list_produtos" style="display:none">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Produtos</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.produto" ng-enter="loadProdutos(0,10)" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadProdutos(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>

						<br/>

				   		<div class="row">
				   			<div class="col-sm-12">
				   				<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(produtos.length != 0)">
										<tr>
											<th >ID</th>
											<th >Nome</th>
											<th >Fabricante</th>
											<th >Tamanho</th>
											<th >Sabor/cor</th>
											<th >qtd</th>
											<th ></th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(produtos.length == 0)" class="text-center">
											<td colspan="7">Nenhum produto encontrado</td>
										</tr>
										<tr ng-show="produtos == null" class="text-center">
											<td colspan="7" ><i class='fa fa-refresh fa-spin'></i> Carregando...</td>
										</tr>
										<tr ng-repeat="item in produtos">
											<td>{{ item.id }}</td>
											<td>{{ item.nome }}</td>
											<td>{{ item.nome_fabricante }}</td>
											<td>{{ item.peso }}</td>
											<td>{{ item.sabor }}</td>
											<td  width="50"><input  ng-model="item.qtd_pedida" type="text" class="form-control input-xs" /></td>
											<td width="50" align="center">
												<button ng-show="!produtoSelected(item.id)" type="button" class="btn btn-xs btn-success" ng-click="addProduto(item)">
													<i class="fa fa-check-square-o"></i> Selecionar
												</button>
												<button ng-show="produtoSelected(item.id)" ng-show="existsAcessorio(item)" ng-disabled="true" class="btn btn-primary btn-xs" type="button">
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
					    		<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.produtos.length > 1">
									<li ng-repeat="item in paginacao.produtos" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadProdutos(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
					    	</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal Detalhes transferencia -->
		<div class="modal fade" id="modal-detalhes-transferencia" style="display:none">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Detalhes da Transferência</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<b>ID: </b> {{view.transferencia.id}}<br/>
								<b>Dta. Pedido: </b> {{view.transferencia.dta_pedido | dateFormat : 'dateTime'}}<br/>
								<b>Usuario: </b> {{view.transferencia.nome_usuario_pedido}}<br/>
								<b>Empreendimento: </b> {{view.transferencia.nome_empreendimento_pedido}}<br/>
								<b>Status: </b> {{view.transferencia.dsc_status_transferencia_estoque}}<br/><br/>
							</div>
						</div>
				   		<div class="row">
				   			<div class="col-sm-12">
				   				<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(view.transferencia.itens.length != 0)">
										<tr>
											<th >ID produto</th>
											<th >Produto</th>
											<th class="text-center" >Qtd. Pedida</th>
											<th ng-show="item.id_status_transferencia == 2" class="text-center">Qtd. Transferida</th>
											<th ng-show="item.id_status_transferencia == 3" class="text-center">Qtd. Entregue</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="item in view.transferencia.itens">
											<td>{{ item.id_produto }}</td>
											<td>{{ item.nome_produto }}</td>
											<td class="text-center">{{ item.qtd_pedida }}</td>
											<td ng-show="item.id_status_transferencia == 2" class="text-center">{{ item.qtd_transferida }}</td>
											<td ng-show="item.id_status_transferencia == 3" class="text-center">{{ item.qtd_entregeue }}</td>
										</tr>
									</tbody>
								</table>
				   			</div>
				   		</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal depositos-->
		<div class="modal fade" id="list_depositos" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Depositos</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.depositos" ng-enter="loadDepositos(0,10)" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadDepositos(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div> <!-- /input-group-btn -->
						        </div> <!-- /input-group -->
							</div><!-- /.col -->
						</div>

						<br/>

				   		<div class="row">
				   			<div class="col-sm-12">
				   				<table class="table table-bordered table-condensed table-striped table-hover">
									<thead ng-show="(depositos.length != 0)">
										<tr>
											<th colspan="2">Nome</th>
										</tr>
									</thead>
									<tbody>
									<tr ng-show="depositos == null">
                                        <th class="text-center" colspan="9" style="text-align:center"><i class='fa fa-refresh fa-spin'></i> Carregando ...</th>
                                    </tr>
                                    <tr ng-show="depositos.length == 0">
                                        <th colspan="4" class="text-center">Não a resultados para a busca</th>
                                    </tr>
										<tr ng-repeat="item in depositos">
											<td>{{ item.nme_deposito }}</td>
											<td width="50" align="center">
												<button type="button" class="btn btn-xs btn-success" ng-click="addDeposito(item)">
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
					    		<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao_depositos.length > 1">
									<li ng-repeat="item in paginacao_depositos" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadDepositos(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
					    	</div>
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
	<script src="js/angular-controller/pedido_transferencia_recebido-controller.js"></script>
	<script type="text/javascript"></script>>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
