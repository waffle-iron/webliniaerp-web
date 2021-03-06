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

		.panel.panel-default {
		    overflow: visible !important;
		}

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


	</style>
  </head>

  <body class="overflow-hidden" ng-controller="RegraServicoController" ng-cloak>
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

				<!--<div class="search-block">
					<div class="input-group">
						<input type="text" class="form-control input-sm" placeholder="search here...">
						<span class="input-group-btn">
							<button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
						</span>
					</div>--><!-- /input-group -->
				<!--</div>--><!-- /search-block -->

				<?php include_once('menu-modulos.php') ?>
				
			</div><!-- /sidebar-inner -->
		</aside>

		<div id="main-container">
			<div id="breadcrumb">
				<ul class="breadcrumb">
					<li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
					<li><i class="fa fa-building-o"></i> Empreendimento</li>
					<li><i class="fa fa-cog"></i> <a href="empreendimento_config.php">Configurações</a></li>
					<li class="active"><i class="fa fa-tags"></i> Regra de Serviços</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-tags"></i> Regra de Servios</h3>
					<br/>
					<a class="btn btn-info" id="btn-novo" ng-disabled="editing" ng-click="showBoxNovo()"><i class="fa fa-plus-circle"></i> Nova Regra</a>
				</div><!-- /page-title -->
			</div><!-- /main-header -->

			<div class="padding-md">
				<div class="alert alert-top" style="display:none"></div>

				<div class="panel panel-default" id="box-novo" style="display:none">
					<div class="panel-heading"><i class="fa fa-plus-circle"></i> Nova Regra</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-6">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Nome da Regra</label>
									<input type="text" class="form-control input-sm" ng-model="regra_servico.nme_regra_servico">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="" class="control-label">Estado</label>
									<select  chosen 
								    option="estados"
								    ng-model="regra_servico.cod_estado"
								    ng-change="changeEstado(regra_servico.cod_estado)"
								    ng-options="item.id as item.nome for item in estados">
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label for="" class="control-label">Município</label>
									<select  chosen "
								    option="municipios"
								    ng-model="regra_servico.cod_municipio"
								    ng-options="item.id as item.nome for item in municipios">
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Cód. Servico Municipal</label>
									<input type="text" class="form-control input-sm" ng-model="regra_servico.cod_servico_municipio">
								</div>
							</div>

							<div class="col-sm-10">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Descrição Serviço Municipal</label>
									<input type="text" class="form-control input-sm" ng-model="regra_servico.dsc_servico_municipio">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2">
								<div class="form-group" id="flg_cont_ipi_emitente">
									<label for="" class="control-label">Retém ISS PF</label>
									<div class="form-group">
										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_iss_pf" value="0" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Não</span>
										</label>

										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_iss_pf" value="1" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Sim</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group" id="flg_cont_ipi_emitente">
									<label for="" class="control-label">Retém ISS PJ</label>
									<div class="form-group">
										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_iss_pj" value="0" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Não</span>
										</label>

										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_iss_pj" value="1" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Sim</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">% Retenção ISS</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.prc_retencao_iss">
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Valor Mín. Retenção ISS</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.vlr_minimo_retencao_iss">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2">
								<div class="form-group" id="flg_cont_ipi_emitente">
									<label for="" class="control-label">Retém INSS</label>
									<div class="form-group">
										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_inss" value="0" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Não</span>
										</label>

										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_inss" value="1" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Sim</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">% Retenção INSS</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.prc_retencao_inss">
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Valor Mín Ret. INSS</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.vlr_minimo_retencao_inss">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2">
								<div class="form-group" id="flg_cont_ipi_emitente">
									<label for="" class="control-label">Retém PIS</label>
									<div class="form-group">
										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_pis" value="0" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Não</span>
										</label>

										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_pis" value="1" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Sim</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">% Retenção PIS</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.prc_retencao_pis">
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Valor Mín Ret. PIS</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.vlr_minimo_retencao_pis">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2">
								<div class="form-group" id="flg_cont_ipi_emitente">
									<label for="" class="control-label">Retém COFINS</label>
									<div class="form-group">
										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_cofins" value="0" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Não</span>
										</label>

										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_cofins" value="1" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Sim</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">% Retenção COFINS</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.prc_retencao_cofins">
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Valor Mín Ret. COFINS</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.vlr_minimo_retencao_cofins">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2">
								<div class="form-group" id="flg_cont_ipi_emitente">
									<label for="" class="control-label">Retém CSLL</label>
									<div class="form-group">
										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_csll" value="0" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Não</span>
										</label>

										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_csll" value="1" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Sim</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">% Retenção CSLL</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.prc_retencao_csll">
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Valor Mín Ret. CSLL</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.vlr_minimo_retencao_csll">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-2">
								<div class="form-group" id="flg_cont_ipi_emitente">
									<label for="" class="control-label">Retém I.R.</label>
									<div class="form-group">
										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_ir" value="0" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Não</span>
										</label>

										<label class="label-radio inline">
											<input ng-model="regra_servico.flg_retem_ir" value="1" type="radio" class="inline-radio">
											<span class="custom-radio"></span>
											<span>Sim</span>
										</label>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">% Retenção I.R.</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.prc_retencao_ir">
								</div>
							</div>
							<div class="col-sm-2">
								<div id="num_percentual_mva_proprio" class="form-group">
									<label class="control-label">Valor Mín Ret. I.R.</label>
									<input type="text" class="form-control input-sm" mask-moeda ng-model="regra_servico.vlr_minimo_retencao_ir">
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<div class="pull-right">
										<button ng-click="showBoxNovo(); reset();" type="submit" class="btn btn-danger btn-sm">
											<i class="fa fa-times-circle"></i> Cancelar
										</button>
										<button data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde..." id="btn_salvar" ng-click="salvarRegra()" type="submit" class="btn btn-success btn-sm">
											<i class="fa fa-save"></i> Salvar
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /panel -->

				<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-tasks"></i> Regras Cadastradas</div>

					<div class="panel-body">
						<div class="alert alert-lista" style="display:none"></div>
						<div class="row">
							<div class="col-sm-11">
								<div class="input-group">
						            <input ng-model="busca.text" type="text" class="form-control input-sm" ng-enter="loadRegras(0,10)">
						            <div class="input-group-btn">
						            	<button ng-click="loadRegras(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
						            		<i class="fa fa-search"></i> Buscar
						            	</button>
						            </div>
						        </div>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn btn-sm btn-default" ng-click="resetFilter()">Limpar</button>
							</div>
						</div>
						<br>
						<div id="tabelaCategoria"></div>
						<table class="table table-bordered table-condensed table-striped table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th width="200">Nome da Regra</th>
									<th class="text-center" width="100">Cód. Serviço Mun.</th>
									<th>Descrição Serviço Municipal</th>
									<th class="text-center" width="80">UF</th>
									<th width="120">Municipio</th>
									<th width="80" style="text-align: center;">Opções</th>
								</tr>
							</thead>
							<tr>
								<td colspan="4" ng-if="regrasCadastradas.regras == null" class="text-center">
									<i class='fa fa-refresh fa-spin'></i> Carregando
								</td>
							</tr>
							<tr>
								<td colspan="4" ng-if="regrasCadastradas.regras.length == 0" class="text-center">
									Nenhuma regra encontrada
								</td>
							</tr>
							<tbody>
								<tr ng-repeat="item in regrasCadastradas.regras">
									<td class="text-center text-middle" width="80">{{ item.id }}</td>
									<td class="text-middle">{{ item.nme_regra_servico }}</td>
									<td class="text-center text-middle">{{ item.cod_servico_municipio }}</td>
									<td class="text-middle">{{ item.dsc_servico_municipio }}</td>
									<td class="text-center text-middle">{{ item.uf }}</td>
									<td class="text-middle">{{ item.municipio }}</td>
									<td class="text-center text-middle">
										<button type="button" ng-click="editar(item)"  class="btn btn-xs btn-warning" tooltip title="editar">
											<i class="fa fa-edit"></i>
										</button>
										<button type="button" ng-click="delete(item.id)" tooltip class="btn btn-xs btn-danger delete" tooltip title="Excluir">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel-footer clearfix">
						<div class="pull-right">
							<ul class="pagination pagination-sm m-top-none" ng-show="regrasCadastradas.paginacao.length > 1">
								<li ng-repeat="item in regrasCadastradas.paginacao" ng-class="{'active': item.current}">
									<a href="" h ng-click="loadRegras(item.offset,item.limit)">{{ item.index }}</a>
								</li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div><!-- /main-container -->

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
						            <input ng-model="busca.regra" ng-enter="loadRegras(0,10)" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadRegras(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
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
												<button ng-if="empreendimentoIsSelected(item)" type="button" class="btn btn-xs btn-primary">
													<i class="fa fa-check-square-o"></i> Selecionado
												</button>
												<button ng-if="!empreendimentoIsSelected(item)" type="button" class="btn btn-xs btn-success" ng-click="addEmpreendimento(item)">
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
	<script src="js/angular-controller/regra_servico-controller.js"></script>
	<script type="text/javascript"></script>>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
