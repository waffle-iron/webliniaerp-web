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
		.panel.panel-default {
		    overflow: visible !important;
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

  <body class="overflow-hidden" ng-controller="ProdutosController" ng-cloak>
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
					 <li class="active"><i class="fa fa-archive"></i> Produtos</li>
				</ul>
			</div><!-- breadcrumb -->

			<div class="main-header clearfix">
				<div class="page-title">
					<h3 class="no-margin"><i class="fa fa-archive"></i> Produtos</h3>
					<br/>
					<a class="btn btn-info" id="btn-novo"  ng-click="showBoxNovo()"><i class="fa fa-plus-circle"></i> Novo Produto</a>
				</div><!-- /page-title -->
			</div><!-- /main-header -->

			<div class="padding-md">
				<div class="alert alert-sistema" style="display:none"></div>

				<div class="panel panel-default" id="box-novo" style="display:none">
					<div class="panel-heading"><i class="fa fa-plus-circle"></i> Novo Produto</div>

					<div class="panel-body">
						<form id="formProdutos" role="form" enctype="multipart/form-data">
						    <div class="row">
								<div class="col-sm-2">
									<div class="form-group">
										<label for="" class="control-label">Tipo do produto</label>
										<div class="form-group">
											<label class="label-radio inline">
												<input ng-model="produto.flg_produto_composto" ng-click="changeTipoProduto(null,'tipo')" name="tipo_produto" value="0" type="radio" class="inline-radio">
												<span class="custom-radio"></span>
												<span>Normal</span>
											</label>
											<label class="label-radio inline">
												<input ng-model="produto.flg_produto_composto" ng-click="changeTipoProduto('flg_produto_composto','tipo')" name="tipo_produto" value="1" type="radio" class="inline-radio">
												<span class="custom-radio"></span>
												<span>Composto</span>
											</label>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="" class="control-label">Sub Tipo do produto</label>
										<select ng-change="changeTipoProduto(produto.campo_extra_selected,'sub_tipo')" chosen ng-change="ClearChosenSelect('produto')"
									    option="chosen_campo_extra"
									    ng-model="produto.campo_extra_selected"
									    ng-options="campo.nome_campo as campo.label for campo in chosen_campo_extra">
										</select>
										<!--
										<label for="" class="control-label">Sub Tipo do produto</label>
										<div class="form-group">
											<label class="label-radio inline" ng-if="produto.valor_campo_extra.flg_base != undefined">
												<input ng-model="produto.valor_campo_extra.flg_base" ng-click="changeTipoProduto('flg_base','sub_tipo')" name="sub_tipo_produto" value="1" type="radio" class="inline-radio">
												<span class="custom-radio"></span>
												<span>Base</span>
											</label>
											<label class="label-radio inline" ng-if="produto.valor_campo_extra.flg_base_personalizada != undefined">
												<input ng-model="produto.valor_campo_extra.flg_base_personalizada" ng-click="changeTipoProduto('flg_base_personalizada','sub_tipo')" name="sub_tipo_produto" value="1" type="radio" class="inline-radio">
												<span class="custom-radio"></span>
												<span>Base Personalizada</span>
											</label>
											<label class="label-radio inline" ng-if="produto.valor_campo_extra.flg_tira != undefined">
												<input ng-model="produto.valor_campo_extra.flg_tira" ng-click="changeTipoProduto('flg_tira','sub_tipo')" name="sub_tipo_produto" value="1" type="radio" class="inline-radio">
												<span class="custom-radio"></span>
												<span>Tira</span>
											</label>
											<label class="label-radio inline" ng-if="produto.valor_campo_extra.flg_tira_personalizada_masculina != undefined">
												<input ng-model="produto.valor_campo_extra.flg_tira_personalizada_masculina" ng-click="changeTipoProduto('flg_tira_personalizada_masculina','sub_tipo')" name="sub_tipo_produto" value="1" type="radio" class="inline-radio">
												<span class="custom-radio"></span>
												<span>Tira Personalizada Masculina</span>
											</label>
											<label class="label-radio inline" ng-if="produto.valor_campo_extra.flg_tira_personalizada_feminina != undefined">
												<input ng-model="produto.valor_campo_extra.flg_tira_personalizada_feminina" ng-click="changeTipoProduto('flg_tira_personalizada_feminina','sub_tipo')" name="sub_tipo_produto" value="1" type="radio" class="inline-radio">
												<span class="custom-radio"></span>
												<span>Tira Personalizada feminina</span>
											</label>
											<label class="label-radio inline" ng-if="produto.valor_campo_extra.flg_acessorio != undefined">
												<input ng-model="produto.valor_campo_extra.flg_acessorio" ng-click="changeTipoProduto('flg_acessorio','sub_tipo')" name="sub_tipo_produto" value="1" type="radio" class="inline-radio">
												<span class="custom-radio"></span>
												<span>Acessório</span>
											</label>
										</div>
										-->
									</div>
								</div>
							</div>
							<div class="row" >
								<div class="col-sm-2">
									<div class="form-group" id="codigo_barra">
										<label class="control-label"><i class="fa fa-barcode"></i> Código de Barras</label>
										<input ng-disabled="configuracao.id_produto_debito_anterior_cliente == produto.id_produto"  ng-model="produto.codigo_barra" type="text"  class="form-control input-sm" onKeyPress="return SomenteNumero(event);">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group" id="nome">
										<label class="control-label">Descrição do Produto <span style="color:red;font-weight: bold;">*</span></label>
										<input ng-disabled="configuracao.id_produto_debito_anterior_cliente == produto.id_produto" ng-model="produto.nome" ng-enter="salvar()" type="text" class="form-control input-sm">
									</div>
								</div>

								<div class="col-sm-4">
									<div class="form-group" id="img">
										<label class="control-label" ng-show="editing == false || (produto.img == '' || produto.img == null)" ><i class="fa fa-camera"></i> Foto do Produto</label>
										<a href="assets/imagens/produtos/{{ produto.img }}"  target="_blanck">
											<label style="cursor:pointer" class="control-label" ng-hide="editing == false || (produto.img == '' || produto.img == null)" ><i class="fa fa-camera"></i> Foto do Produto</label>
										</a>
										<div class="upload-file">
											<input  id="foto-produto" ng-disabled="configuracao.id_produto_debito_anterior_cliente == produto.id_produto" name="img"  class="foto-produto" type="file" data-file="produto.foto" accept="image/*" />
											<!-- <input ng-model=""   name="image" type="file" id="foto-produto" class="foto-produto" ng-model="fotoProduto"> -->
												<label ng-disabled="configuracao.id_produto_debito_anterior_cliente == produto.id_produto" data-title="Selecione" for="foto-produto">
													<span data-title="{{ produto.img }}"></span>
												</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-2">
									<div class="form-group" id="peso">
											<label class="ccontrol-label">Tamanho </label> <i ng-click="showModalNovoTamanho()" style="cursor:pointer;color: #9ad268;" class="fa fa-plus-circle fa-lg"></i>
											<select chosen ng-change="ClearChosenSelect('produto')"
										    option="tamanhos"
										    ng-model="produto.id_tamanho"
										    ng-options="tamanho.id as tamanho.nome_tamanho for tamanho in tamanhos">
											</select>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group" id="peso">
											<label class="ccontrol-label">Cor/sabor</label> <i ng-click="showModalNovaCor()" style="cursor:pointer;color: #9ad268;" class="fa fa-plus-circle fa-lg"></i>
											<select chosen ng-change="ClearChosenSelect('cor')"
										    option="cores"
										    ng-model="produto.id_cor"
										    ng-options="cor.id as cor.nome_cor for cor in cores">
											</select>
									</div>
								</div>

								<div class="col-sm-2">
									<div class="form-group" id="qtd_minima_estoque">
										<label class="control-label">Estoque Mínimo</label>
										<input ng-disabled="configuracao.id_produto_debito_anterior_cliente == produto.id_produto" ng-model="produto.qtd_minima_estoque" type="text" class="form-control input-sm" onKeyPress="return SomenteNumero(event);">
									</div>
								</div>

								
							</div>

							<div class="row">
								<div class="col-sm-4">
									<div class="form-group" id="peso">
											<label class="ccontrol-label">Fabricante</label> <i ng-click="modal('show','modal-novo-fabricante')" style="cursor:pointer;color: #9ad268;" class="fa fa-plus-circle fa-lg"></i>
											<select chosen ng-change="ClearChosenSelect('fabricante')"
										    option="fabricantes"
										    ng-model="produto.id_fabricante"
										    ng-options="fabricante.id as fabricante.nome_fabricante for fabricante in fabricantes">
											</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group" id="peso">
											<label class="ccontrol-label">Importador</label> <i ng-click="modal('show','modal-novo-importador')" style="cursor:pointer;color: #9ad268;" class="fa fa-plus-circle fa-lg"></i>
											<select chosen ng-change="ClearChosenSelect('importador')"
										    option="importadores"
										    ng-model="produto.id_importador"
										    ng-options="importador.id as importador.nome_importador for importador in importadores">
											</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group" id="peso">
											<label class="ccontrol-label">Categoria</label> <i ng-click="modal('show','modal-nova-categoria')" style="cursor:pointer;color: #9ad268;" class="fa fa-plus-circle fa-lg"></i>
											<select chosen ng-change="ClearChosenSelect('categoria')"
										    option="categorias"
										    ng-model="produto.id_categoria"
										    ng-options="categoria.id as categoria.descricao_categoria for categoria in categorias">
											</select>
									</div>
								</div>
							</div>

							<div class="row" ng-if="produto.flg_produto_composto == 1">
								<div class="col-sm-12">
									<div class="empreendimentos form-group" id="insumos">
										
											<table class="table table-bordered table-condensed table-striped table-hover">
												<thead>
													<tr>
														<td colspan="7"><i class="fa fa fa-th fa-lg"></i> Insumos</td>
														<td width="60" align="center">
															<button class="btn btn-xs btn-primary" ng-click="showInsumos()"><i class="fa fa-plus-circle"></i></button>
														</td>
													</tr>
												</thead>
												<tbody>
													<tr ng-show="(insumos.length == 0)">
														<td colspan="8" align="center">Nenhum insumo selecionado</td>
													</tr>
													<tr ng-show="(insumos.length > 0)">
														<td>#</td>
														<td class="text-center">Produto</td>
														<td class="text-center">Fabricante</td>
														<td class="text-center">Tamanho</td>
														<td class="text-center">Sabor/Cor</td>
														<td class="text-center">Custo</td>
														<td class="text-center" width="50">Qtd.</td>
														<td class="text-center" align="center"></td>
													</tr>
													<tr ng-repeat="item in insumos">
														<td>{{ item.id }}</td>
														<td>{{ item.nome }}</td>
														<td>{{ item.nome_fabricante }}</td>
														<td>{{ item.peso }}</td>
														<td>{{ item.sabor }}</td>
														<td class="text-right">R$ {{ item.vlr_custo_real | numberFormat:2:',':'.' }}</td>
														<td  width="50"><input  ng-model="item.qtd" ng-keyup="calVlrCustoInsumos()" type="text" class="form-control input-xs" /></td>
														<td align="center">
															<button class="btn btn-xs btn-danger" ng-click="delInsumo($index,item)"><i class="fa fa-trash-o"></i></button>
														</td>
													</tr>
												</tbody>
											</table>
								
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="empreendimentos form-group" id="empreendimentos">
										
											<table class="table table-bordered table-condensed table-striped table-hover">
												<thead>
													<tr>
														<td><i class="fa fa-building-o"></i> Empreendimentos</td>
														<td width="60" align="center">
															<button class="btn btn-xs btn-primary" ng-click="showEmpreendimentos()"><i class="fa fa-plus-circle"></i></button>
														</td>
													</tr>
												</thead>
												<tbody>
													<tr ng-show="(empreendimentosAssociados.length == 0)">
														<td colspan="2" align="center">Nenhum empreendimento selecionado</td>
													</tr>
													<tr ng-repeat="item in empreendimentosAssociados">
														<td>{{ item.nome_empreendimento }}</td>
														<td align="center">
															<button class="btn btn-xs btn-danger" ng-click="delEmpreendimento($index,item)"><i class="fa fa-trash-o"></i></button>
														</td>
													</tr>
												</tbody>
											</table>
								
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group" id="fornecedores">
										<table class="table table-bordered table-condensed table-striped table-hover">
											<thead>
												<tr>
													<td><i class="fa fa-truck"></i> Fornecedores <!--<i ng-click="modal('show','modal-novo-fornecedor')" style="cursor:pointer;color: #9ad268;" class="fa fa-plus-circle fa-lg"></i>--></td>
													<td width="60" align="center">
														<button ng-disabled="configuracao.id_produto_debito_anterior_cliente == produto.id_produto" ng-click="showFornecedores()"  class="btn btn-xs btn-primary"><i class="fa fa-plus-circle"></i></button>
													</td>
												</tr>
											</thead>
											<tbody>
												<tr ng-show="(produto.fornecedores.length == 0)">
														<td colspan="2" align="center">Nenhum fornecedor selecionado</td>
													</tr>
												<tr ng-repeat="item in produto.fornecedores" >
													<td>{{ item.nome_fornecedor }}</td>
													<td align="center">
														<button ng-click="delFornecedor($index)" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div ng-show="!(userLogged.id_perfil == 8)" class="row">
								<div class="col-sm-2">
									<div class="form-group" id="vlr_custo">
										<label class="control-label">Valor de Tabela</label>
										<input ng-disabled="produto.flg_produto_composto == 1" ng-model="produto.preco.vlr_custo" ng-keyup="calcularAllMargens()" ng-enter="salvar()" thousands-formatter type="text" class="form-control input-sm parsley-validated">
									</div>
								</div>

								<div class="col-sm-2">
									<div class="form-group" id="perc_imposto_compra">
										<label class="control-label">Imposto</label>
										<input ng-model="produto.preco.perc_imposto_compra" ng-keyup="calcularAllMargens()" ng-enter="salvar()" thousands-formatter  type="text" class="form-control input-sm parsley-validated maskPorcentagem">
									</div>
								</div>

								<div class="col-sm-2">
									<div class="form-group" id="perc_desconto_compra">
										<label class="control-label">Desconto/compra</label>
										<input ng-model="produto.preco.perc_desconto_compra" ng-keyup="calcularAllMargens()" ng-enter="salvar()" thousands-formatter type="text" class="form-control input-sm parsley-validated maskPorcentagem">
									</div>
								</div>

								<div class="col-sm-2">
									<div class="form-group">
										<label class="control-label">Custo Efetivo</label>
										<input thousands-formatter type="text" class="form-control input-sm parsley-validated maskPorcentagem" disabled="disabled" ng-model="produto.preco.valor_custo_real">
									</div>
								</div>

								<div class="col-sm-2">
									<div class="form-group" id="valor_desconto_cliente">
										<label class="control-label">Desconto p/ Cliente</label>
										<input ng-model="produto.valor_desconto_cliente" ng-enter="salvar()" thousands-formatter type="text" class="form-control input-sm parsley-validated maskPorcentagem">
									</div>
								</div>

							</div>

							<div ng-show="!(userLogged.id_perfil == 8)" class="row">
								<div class="col-sm-4" style="margin-bottom:8px;">
									<div class="control-label text-center" style="font-weight: 700;background: #D6D5D5;">Valor de Atacado</div>
								</div>
								<div class="col-sm-4 text-center" style="margin-bottom:8px">
									<div class="control-label" style="font-weight: 700;background: #D6D5D5;">Valor Intermed.</div>
								</div>
								<div class="col-sm-4" style="margin-bottom:8px">
									<div class="control-label text-center" style="font-weight: 700;background: #D6D5D5;">Valor Varejo</div>
								</div>

							</div>
							<div ng-show="!(userLogged.id_perfil == 8)" class="row">
								<div class="col-sm-2"
									<div class="form-group" id="perc_venda_varejo">
										<div class="control-label text-center">Margem(%)</div>
										<input ng-model="produto.preco.perc_venda_atacado" ng-keyup="calculaMargens('atacado','margem')" ng-enter="salvar()" ng-disabled="produto.preco.vlr_custo == null || produto.preco.vlr_custo == ''"  thousands-formatter   type="text" class="form-control input-sm parsley-validated maskPorcentagem">
									</div>
									<div class="col-sm-2"
									<div class="form-group" id="perc_venda_varejo">
										<div class="control-label text-center">valor(R$)</div>
										<input ng-model="produto.preco.valor_venda_atacado" ng-keyup="calculaMargens('atacado','valor')" ng-enter="salvar()" ng-disabled="produto.preco.vlr_custo == null || produto.preco.vlr_custo == ''"  thousands-formatter   type="text" class="form-control input-sm parsley-validated maskPorcentagem">
								</div>

								<div class="col-sm-2"
									<div class="form-group" id="perc_venda_varejo">
										<div class="control-label text-center">Margem(%)</div>
										<input ng-model="produto.preco.perc_venda_intermediario" ng-keyup="calculaMargens('intermediario','margem')" ng-enter="salvar()" ng-disabled="produto.preco.vlr_custo == null || produto.preco.vlr_custo == ''"  thousands-formatter   type="text" class="form-control input-sm parsley-validated maskPorcentagem">
									</div>
									<div class="col-sm-2"
									<div class="form-group" id="perc_venda_varejo">
										<div class="control-label text-center">valor(R$)</div>
										<input ng-model="produto.preco.valor_venda_intermediario" ng-keyup="calculaMargens('intermediario','valor')" ng-enter="salvar()" ng-disabled="produto.preco.vlr_custo == null || produto.preco.vlr_custo == ''"  thousands-formatter   type="text" class="form-control input-sm parsley-validated maskPorcentagem">
								</div>

								<div class="col-sm-2"
									<div class="form-group" id="perc_venda_varejo">
										<div class="control-label text-center">Margem(%)</div>
										<input ng-model="produto.preco.perc_venda_varejo" ng-keyup="calculaMargens('varejo','margem')" ng-enter="salvar()" ng-disabled="produto.preco.vlr_custo == null || produto.preco.vlr_custo == ''"  thousands-formatter   type="text" class="form-control input-sm parsley-validated maskPorcentagem">
									</div>
									<div class="col-sm-2"
									<div class="form-group" id="perc_venda_varejo">
										<div class="control-label text-center">valor(R$)</div>
										<input ng-model="produto.preco.valor_venda_varejo" ng-keyup="calculaMargens('varejo','valor')" ng-enter="salvar()" ng-disabled="produto.preco.vlr_custo == null || produto.preco.vlr_custo == ''"  thousands-formatter   type="text" class="form-control input-sm parsley-validated maskPorcentagem">
								</div>

							</div>
							<br/>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group" id="nme_arquivo_nutricional">
										<label class="control-label" ng-show="editing == false || (produto.nme_arquivo_nutricional == '' || produto.nme_arquivo_nutricional == null)"><i class="fa fa-camera"></i> Arquivo nutricional</label>
										<a href="assets/arquivos/produtos/{{ produto.nme_arquivo_nutricional }}"  target="_blanck">
											<label style="cursor:pointer" class="control-label" ng-hide="editing == false || (produto.nme_arquivo_nutricional == '' || produto.nme_arquivo_nutricional == null)"><i class="fa fa-camera"></i> Arquivo nutricional</label>
										</a>
										<div class="upload-file">
											<input ng-disabled="configuracao.id_produto_debito_anterior_cliente == produto.id_produto"  id="arquivo-produto" name="arquivo-produto"  class="foto-produto" type="file" data-file="produto.foto" accept="image/*" />
											<!-- <input ng-model=""   name="image" type="file" id="foto-produto" class="foto-produto" ng-model="fotoProduto"> -->
											<label data-title="Selecione" for="arquivo-produto">
												<span data-title="{{ produto.nme_arquivo_nutricional }}"></span>
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group" id="descricao">
										<label class="control-label">Descrição</label>
										<textarea ng-disabled="configuracao.id_produto_debito_anterior_cliente == produto.id_produto" ng-model="produto.descricao" class="form-control" rows="5"></textarea>
									</div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading"><i class="fa fa-list-ol"></i> Estoque</div>
								<div class="panel-body painel-estoque">
									<div ng-show="userLogged.id_perfil==1" class="row">
										<div class="col-sm-5" id="inventario_novo_deposito">
											<label class="control-label">Deposito</label>
											<div class="input-group">
									            <input ng-model="inventario_novo.nome_deposito" ng-disabled="true" type="text" class="form-control input-xs" ng-enter="loadDepositos(0,10)">
									            <div class="input-group-btn">
									            	<button ng-click="modalDepositos()" tabindex="-2" class="btn btn-xs btn-primary" type="button">
									            		<i class="fa fa-sitemap"></i>
									            	</button>
									            </div>
									        </div>
										</div>
										<div class="col-sm-2">
											<div class="form-group" id="inventario_novo_validade">
												<label class="control-label" >Data de Validade</label>
												<input ng-model="inventario_novo.dta_validade" ui-mask="99/99/9999"  type="text" class="form-control input-xs">
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group" id="inventario_novo_qtd">
												<label class="control-label">Qtd</label>
												<input ng-model="inventario_novo.qtd_ivn" onkeypress="return SomenteNumero(event);" type="text" class="form-control input-xs">
											</div>
										</div>
										<div class="col-sm-2">
											<label class="control-label">&nbsp;</label>
											<div class="form-group" >
												<button data-loading-text="Aguarde..." ng-click="addNovoInventario()"type="submit" id="btn-novo_inventario" class="btn btn-success btn-xs">
													Adicionar
												</button>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-10">
											<table class="table table-bordered table-condensed table-striped table-hover">
												<thead>
													<tr>
														<th class="text-center">Deposito</th>
														<th class="text-center">validade</th>
														<th class="text-center" width="100">Quantidade</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="(key, value) in produto.estoque | orderBy:'+nome_deposito'">
														<td>{{ value.nome_deposito }}</td>
														<td class="text-center" ng-if="value.dta_validade != '2099-12-31'">{{ value.dta_validade | dateFormat:'date' }}</td>
														<td class="text-center" ng-if="value.dta_validade == '2099-12-31'"></td>
														<td ng-show="(userLogged.id_perfil == 1)" class="text-center" ><input type="text"  onkeypress="return SomenteNumero(event);"   class="form-control input-xs text-center" ng-model="value.qtd_ivn" ></td>
														<td ng-show="!(userLogged.id_perfil == 1)" class="text-center">{{ value.qtd_ivn }} </td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4" id="cod_ncm">
									<label class="control-label">NCM</label>
									<div class="input-group">
										<input ng-click="selNcm()" type="text" class="form-control input-sm" ng-model="produto.ncm_view" readonly="readonly" style="cursor: pointer;" />
										<span class="input-group-btn">
											<button ng-click="selNcm()"  type="button" class="btn btn-sm"><i class="fa-search fa"></i></button>
										</span>
									</div>
								</div>
								<div class="col-sm-1" id="ex_tipi">
									<div class="form-group">
										<label class="ccontrol-label">EX TIPI</label> 
											<input  ng-model="produto.ex_tipi" type="text" class="form-control input-sm">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group" id="cod_especializacao_ncm">
										<label class="control-label">Especialização NCM</label> 
										<select chosen ng-change="ClearChosenSelect('cod_especializacao_ncm')"
									    option="chosen_especializacao_ncm"
									    ng-model="produto.cod_especializacao_ncm"
									    ng-options="especializacao_ncm.cod_especializacao_ncm as especializacao_ncm.dsc_especializacao_ncm for especializacao_ncm in chosen_especializacao_ncm">
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group" id="cod_forma_aquisicao">
										<label class="ccontrol-label">Forma Aquisição</label> 
										<select chosen ng-change="ClearChosenSelect('cod_forma_aquisicao')"
									    option="chosen_forma_aquisicao"
									    ng-model="produto.cod_forma_aquisicao"
									    ng-options="forma_aquisicao.num_item as forma_aquisicao.nme_item for forma_aquisicao in chosen_forma_aquisicao">
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-5">
									<div class="form-group" id="cod_origem_mercadoria">
										<label class="ccontrol-label">Origem Mercadoria</label> 
										<select chosen ng-change="ClearChosenSelect('cod_origem_mercadoria')"
									    option="chosen_origem_mercadoria"
									    ng-model="produto.cod_origem_mercadoria"
									    ng-options="origem_mercadoria.num_item as origem_mercadoria.nme_item for origem_mercadoria in chosen_origem_mercadoria">
										</select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group" id="cod_tipo_tributacao_ipi">
										<label class="ccontrol-label">Tipo Tributação IPI</label> 
										<select chosen ng-change="ClearChosenSelect('cod_tipo_tributacao_ipi')"
									    option="chosen_tipo_tributacao_ipi"
									    ng-model="produto.cod_tipo_tributacao_ipi"
									    ng-options="tipo_tributacao_ipi.num_item as tipo_tributacao_ipi.nme_item for tipo_tributacao_ipi in chosen_tipo_tributacao_ipi">
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="pull-right">
										<button ng-click="showBoxNovo(); reset();" type="submit" class="btn btn-danger btn-sm">
											<i class="fa fa-times-circle"></i> Cancelar
										</button>
										<button data-loading-text="Aguarde..." ng-click="salvar()"type="submit" id="btn-salvar" class="btn btn-success btn-sm">
											<i class="fa fa-save"></i> Salvar
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div><!-- /panel -->

				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-tasks"></i> Produtos Cadastrados
						<a href="util/export.php?c=produtos&id_empreendimento={{ userLogged.id_empreendimento }}" target="_blank" class="btn btn-xs btn-success pull-right"  type="button">
							<i class="fa fa-download"></i>
							Exportar
						</a>
					</div>


					<div class="panel-body">
						<div class="row">
							<div class="col-sm-11">
								<div class="input-group">
						            <input ng-model="busca.produtos" type="text" class="form-control input-sm" ng-enter="loadProdutos(0,10)">
						            <div class="input-group-btn">
						            	<button ng-click="loadProdutos(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
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

						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-condensed table-striped table-hover">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th>Código</th>
											<th class="text-center">Descrição</th>
											<th class="text-center">Fabricante</th>
											<th class="text-center" width="80">Tamanho</th>
											<th class="text-center" width="100">Sabor/Cor</th>
											<th class="text-center" width="60">Estoque</th>
											<th class="text-center" width="100">Vlr. Atacado</th>
											<th class="text-center" width="100">Vlr. Interm.</th>
											<th class="text-center" width="100">Vlr. Varejo</th>
											<th width="80" style="text-align: center;">Opções</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-if="produtos != null && produtos.length == 0">
											<td class="text-center" colspan="11">
												<i class="fa fa-refresh fa-spin"></i> Aguarde, carregando itens...
											</td>
										</tr>
										<tr ng-if="produtos == null">
											<td class="text-center" colspan="11">
												Nenhum produto encontrado.
											</td>
										</tr>
										<tr ng-repeat="item in produtos" title="{{ configuracao.id_produto_debito_anterior_cliente == item.id_produto && 'este produto não pode ser deletado, ele faz parte das confurações internas do sistema' || '' }}">
											<td class="text-center" width="80">{{ item.id_produto }}</td>
											<td class="text-center">{{ item.codigo_barra }}</td>
											<td>{{ item.nome }}</td>
											<td>{{ item.nome_fabricante }}</td>
											<td class="text-center">{{ item.peso }}</td> 
											<td class="text-center">{{ item.sabor }}</td>
											<td class="text-center"><a href="#"  ng-click="qtdDepostito($event)">{{ configuracao.id_produto_debito_anterior_cliente == item.id_produto && ' ' || item.qtd_item }}</a></td>
											<td class="text-right">R$ {{ item.vlr_venda_atacado | numberFormat: 2 : ',' : '.' }}</td>
											<td class="text-right">R$ {{ item.vlr_venda_intermediario | numberFormat: 2 : ',' : '.' }}</td>
											<td class="text-right">R$ {{ item.vlr_venda_varejo | numberFormat: 2 : ',' : '.' }}</td>
											<td align="center">
												<button type="button" ng-click="editar(item)" class="btn btn-xs btn-warning" title="editar" data-toggle="tooltip">
													<i class="fa fa-edit"></i>
												</button>
												<button type="button" ng-click="delete(item)"  ng-disabled="configuracao.id_produto_debito_anterior_cliente == item.id_produto" class="btn btn-xs btn-danger delete">
													<i class="fa fa-trash-o"></i>
												</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="panel-footer clearfix">
						<div class="pull-right">
							<ul class="pagination pagination-sm m-top-none" ng-show="paginacao.itens.length > 1">
								<li ng-repeat="item in paginacao.itens" ng-class="{'active': item.current}">
									<a href="" h ng-click="loadProdutos(item.offset,item.limit)">{{ item.index }}</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /main-container -->

		<!-- /Modal NCM -->
		<div class="modal fade" id="list-ncm" style="display:none">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>NCM</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.ncm"  ng-enter="loadNcm(0,10)" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadNcm(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
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
									<tr ng-if="lista_ncm != false && (lista_ncm.length <= 0 || lista_ncm == null)">
										<th class="text-center" colspan="9" style="text-align:center"><strong>Carregando</strong><img src="assets/imagens/progresso_venda.gif"></th>
									</tr>
									<tr ng-if="lista_ncm == false">
										<th class="text-center" colspan="9" colspan="9" style="text-align:center">Não a resultados para a busca</th>
									</tr>
									<thead ng-show="(lista_ncm.length != 0)">
										<tr>
											<th >NCM</th>
											<th  width="56">EX TIPI</th>
											<th >Descrição</th>
											<th >Perc. IPI</th>
											<th colspan="2">selecionar</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="item in lista_ncm">
											<td>{{ item.cod_ncm }}</td>
											<td ng-if="item.ex_tipi == 0"></td>
											<td ng-if="item.ex_tipi > 0">{{ item.ex_tipi  }}</td>
											<td>{{ item.dsc_ncm | limitTo : 95 : 0 }} <a href="" style="text-decoration: underline;color: #000;" ng-if="item.dsc_ncm.length > 95">...</a></td>
											<td ng-if="item.num_percentual_ipi !=null">{{ item.num_percentual_ipi | numberFormat:2:',':'.' }}%</td>
											<td ng-if="item.num_percentual_ipi ==null">NT</td>
											<td width="50" align="center">
												<button type="button" class="btn btn-xs btn-success" ng-click="changeNcm(item)">
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
				    			<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.especializacao_ncm.length > 1">
									<li ng-repeat="item in paginacao.especializacao_ncm" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadNcm(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
				    		</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal fornecedor-->
		<div class="modal fade" id="list_fornecedores" style="display:none">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Fornecedores</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.fornecedores" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadFornecedores(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
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
									<thead ng-show="(fornecedores.length != 0)">
										<tr>
											<th colspan="2">Nome</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(fornecedores.length == 0)">
											<td colspan="3">Não há fornecedores cadastrados</td>
										</tr>
										<tr ng-repeat="item in fornecedores">
											<td>{{ item.nome_fornecedor }}</td>
											<td width="50" align="center">
												<button type="button" class="btn btn-xs btn-success" ng-click="addFornecedor(item)">
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
					    		<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.fornecedores.length > 1">
									<li ng-repeat="item in paginacao.fornecedores" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadFornecedores(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
					    	</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal Insumos-->
		<div class="modal fade" id="list_insumos" style="display:none">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Insumos</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="input-group">
						            <input ng-model="busca.insumos" type="text" class="form-control input-sm">
						            <div class="input-group-btn">
						            	<button ng-click="loadInsumos(0,10)" tabindex="-1" class="btn btn-sm btn-primary" type="button">
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
									<thead ng-show="(modal_insumos.length != 0)">
										<tr>
											<th >ID</th>
											<th >Nome</th>
											<th >Fabricante</th>
											<th >Tamanho</th>
											<th >Sabor/cor</th>
											<th >Vlr. Custo</th>
											<th >qtd</th>
											<th ></th>
										</tr>
									</thead>
									<tbody>
										<tr ng-show="(modal_insumos.length == 0)">
											<td colspan="4">Nenhum Produto Encontrado</td>
										</tr>
										<tr ng-repeat="item in modal_insumos">
											<td>{{ item.id }}</td>
											<td>{{ item.nome }}</td>
											<td>{{ item.nome_fabricante }}</td>
											<td>{{ item.peso }}</td>
											<td>{{ item.sabor }}</td>
											<td>{{ item.vlr_custo_real | numberFormat:2:',':'.' }}</td>
											<td  width="50"><input  ng-model="item.qtd" type="text" class="form-control input-xs" /></td>
											<td width="50" align="center">
												<button type="button" class="btn btn-xs btn-success" ng-disabled="" ng-click="addInsumo(item)">
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
					    		<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.modal_insumos.length > 1">
									<li ng-repeat="item in paginacao.modal_insumos" ng-class="{'active': item.current}">
										<a href="" h ng-click="loadInsumos(item.offset,item.limit)">{{ item.index }}</a>
									</li>
								</ul>
					    	</div>
				    	</div>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

			<!-- /Modal depositos-->
		<div class="modal fade" id="modal-depositos" style="display:none">
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
										<tr ng-show="(depositos.length == 0)">
											<td colspan="3">{{ busca_vazia.depositos  && 'Não há resultado para a busca' || 'Não há Depositos cadastrados' }}</td>
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
					    		<ul class="pagination pagination-xs m-top-none pull-right" ng-show="paginacao.depositos.length > 1">
									<li ng-repeat="item in paginacao.depositos" ng-class="{'active': item.current}">
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
												<button type="button" class="btn btn-xs btn-success" ng-disabled="empreendimentoSelected(item)" ng-click="addEmpreendimento(item)">
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
		<!-- /Modal novo importador-->
		<div class="modal fade" id="modal-novo-importador" style="display:none">
  			<div class="modal-dialog modal-sm">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Novo Importador</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
						    		<div class="col-sm-12" id="nome_importador">
						    			<label class="control-label">importador:</label>
						    			<div class="form-group ">
						    					<input ng-model="importador.nome_importador" type="text"  class="form-control input-sm" >
						    			</div>
						    		</div>
						    	</div>
							</div>
						</div>
				    </div>
				    <div class="modal-footer">
				    	<button type="button" data-loading-text=" Aguarde..." class="btn btn-block btn-md btn-success"
				    		id="btn-salvar-importador" ng-click="salvarImportador()">
				    		<i class="fa fa-save"></i> Salvar
				    	</button>

				    	<button type="button" data-loading-text=" Aguarde..."
				    		class="btn btn-block btn-md btn-default" ng-click="cancelarModal('modal-novo-importador')" id="btn-aplicar-sangria">
				    		<i class="fa fa-times-circle"></i> Cancelar
				    	</button>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- /Modal novo tamanho-->
		<div class="modal fade" id="modal-novo-tamanho" style="display:none">
  			<div class="modal-dialog modal-sm">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Novo Tamanho</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
						    		<div class="col-sm-12" id="nome_tamanho">
						    			<label class="control-label">tamanho:</label>
						    			<div class="form-group ">
						    					<input ng-model="tamanho.nome_tamanho" type="text"  class="form-control input-sm" >
						    			</div>
						    		</div>
						    	</div>
							</div>
						</div>
				    </div>
				    <div class="modal-footer">
				    	<button type="button" data-loading-text=" Aguarde..." class="btn btn-block btn-md btn-success"
				    		id="btn-salvar-tamanho" ng-click="salvarTamanho()">
				    		<i class="fa fa-save"></i> Salvar
				    	</button>

				    	<button type="button" data-loading-text=" Aguarde..."
				    		class="btn btn-block btn-md btn-default" ng-click="cancelarModal('modal-novo-tamanho')" id="btn-aplicar-sangria">
				    		<i class="fa fa-times-circle"></i> Cancelar
				    	</button>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- /Modal novo fabricante-->
		<div class="modal fade" id="modal-novo-fabricante" style="display:none">
  			<div class="modal-dialog modal-sm">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Novo Fabricante</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
						    		<div class="col-sm-12" id="nome_fabricante">
						    			<label class="control-label">Fabricante:</label>
						    			<div class="form-group ">
						    					<input ng-model="fabricante.nome_fabricante" type="text"  class="form-control input-sm" >
						    			</div>
						    		</div>
						    	</div>
							</div>
						</div>
				    </div>
				    <div class="modal-footer">
				    	<button type="button" data-loading-text=" Aguarde..." class="btn btn-block btn-md btn-success"
				    		id="btn-salvar-fabricante" ng-click="salvarFabricante()">
				    		<i class="fa fa-save"></i> Salvar
				    	</button>

				    	<button type="button" data-loading-text=" Aguarde..."
				    		class="btn btn-block btn-md btn-default" ng-click="cancelarModal('modal-novo-fabricante')" id="btn-aplicar-sangria">
				    		<i class="fa fa-times-circle"></i> Cancelar
				    	</button>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<!-- /Modal novo cor/sabor-->
		<div class="modal fade" id="modal-nova-cor" style="display:none">
  			<div class="modal-dialog modal-sm">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Nova Cor/Sabor</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
						    		<div class="col-sm-12" id="nome_cor">
						    			<label class="control-label">Cor/Sabor:</label>
						    			<div class="form-group ">
						    					<input ng-model="cor_produto.nome_cor" type="text"  class="form-control input-sm" >
						    			</div>
						    		</div>
						    	</div>
							</div>
						</div>
				    </div>
				    <div class="modal-footer">
				    	<button type="button" data-loading-text=" Aguarde..." class="btn btn-block btn-md btn-success"
				    		id="btn-salvar-cor" ng-click="salvarCorProduto()">
				    		<i class="fa fa-save"></i> Salvar
				    	</button>

				    	<button type="button" data-loading-text=" Aguarde..."
				    		class="btn btn-block btn-md btn-default" ng-click="cancelarModal('modal-nova-cor')" id="btn-aplicar-sangria">
				    		<i class="fa fa-times-circle"></i> Cancelar
				    	</button>
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- /Modal novo categoria-->
		<div class="modal fade" id="modal-nova-categoria" style="display:none">
  			<div class="modal-dialog modal-sm">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Nova Categoria</span></h4>
      				</div>
				    <div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
						    		<div class="col-sm-12" id="descricao_categoria">
						    			<label class="control-label">Categoria:</label>
						    			<div class="form-group ">
						    					<input ng-model="categoria.descricao_categoria" type="text"  class="form-control input-sm" >
						    			</div>
						    		</div>
						    	</div>
							</div>
						</div>
				    </div>
				    <div class="modal-footer">
				    	<button type="button" data-loading-text=" Aguarde..." class="btn btn-block btn-md btn-success"
				    		id="btn-salvar-categoria" ng-click="salvarCategoria()">
				    		<i class="fa fa-save"></i> Salvar
				    	</button>

				    	<button type="button" data-loading-text=" Aguarde..."
				    		class="btn btn-block btn-md btn-default" ng-click="cancelarModal('modal-novo-categoria')" id="btn-aplicar-sangria">
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

	<!-- Bootstrap -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

	<!-- Chosen -->
	<script src='js/chosen.jquery.min.js'></script>

	<!-- Jquery Form-->
	<script src='js/jquery.form.js'></script>

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

	<!-- Slimscroll -->
	<script src='js/jquery.slimscroll.min.js'></script>

	<!-- Cookie -->
	<script src='js/jquery.cookie.min.js'></script>

	<!-- Endless -->
	<script src="js/endless/endless_form.js"></script>
	<script src="js/endless/endless.js"></script>

	<!-- Mascaras para o formulario de produtos -->
	<script src="js/scripts/mascaras.js"></script>

	<!-- Extras -->
	<script src="js/extras.js"></script>

	<!-- UnderscoreJS -->
	<script type="text/javascript" src="bower_components/underscore/underscore.js"></script>


	 <!-- Fix for old browsers -->
        <script src="http://nervgh.github.io/js/es5-shim.min.js"></script>
        <script src="http://nervgh.github.io/js/es5-sham.min.js"></script>
        <script src="../console-sham.js"></script>
	

	<!-- AngularJS -->
	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.tpl.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-ui-utils/mask.min.js"></script>
    <script src="js/angular-sanitize.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="js/dialogs.v2.min.js" type="text/javascript"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script src="js/angular-chosen.js"></script>
    <script type="text/javascript">
    	var addParamModule = ['angular.chosen'] ;
    </script>
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js"></script>
    <script src="js/angular-services/user-service.js"></script>
	<script src="js/angular-controller/produtos-controller.js?<?php echo filemtime('js/angular-controller/produtos-controller.js')?>"></script>
	<script type="text/javascript">
		//$(".chzn-select").chosen();
		 $('[data-toggle="tooltip"]').tooltip()
		$('.foto-produto').change(function()	{
			var filename = $(this).val().split('\\').pop();
			$(this).parent().find('span').attr('data-title',filename);
			$(this).parent().find('label').attr('data-title','Trocar foto');
			$(this).parent().find('label').addClass('selected');
		});
	</script>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
