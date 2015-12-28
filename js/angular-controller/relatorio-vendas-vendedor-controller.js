app.controller('RelatorioVendasVendedorController', function($scope, $http, $window, UserService) {
	var ng = $scope,
		aj = $http;
	ng.userLogged 		= UserService.getUserLogado();
	ng.itensPorPagina 	= 10;
	ng.itens 			= [];
	ng.paginacao 		= {};

	var params = getUrlVars();

	ng.reset = function() {
		ng.itens = [];
		$(".has-error").removeClass("has-error");
	}

	ng.resetFilter = function() {
		ng.deposito = {};
		ng.reset();
	}

	ng.aplicarFiltro = function() {
		ng.reset();
		$(".modal").modal('show');
		ng.loadItens(0,10);
	}

	ng.loadVendas = function(offset, limit) {
		var queryString = "?ven->id_empreendimento="+ng.userLogged.id_empreendimento;
			queryString += "&vdd->id="+params.id_vendedor;

		aj.get(baseUrlApi()+"relatorio/vendas/analitico/vendedor/"+offset+'/'+limit+"/"+queryString)
			.success(function(data, status, headers, config) {
				ng.vendas = data.vendas;
				ng.paginacao.vendas = data.paginacao ;
				$("#modal-aguarde").modal('hide');

			})
			.error(function(data, status, headers, config) {
				ng.vendas = [];
				ng.paginacao.vendas = [];
				$("#modal-aguarde").modal('hide');
			});
	}

	ng.loadView= function(id_venda) {
		aj.get(baseUrlApi()+"venda/itens/"+id_venda)
			.success(function(data, status, headers, config) {
				ng.detalhes = data;
			})
			.error(function(data, status, headers, config) {

			});
	}

	ng.view = function(id_venda){
		ng.id_venda = id_venda ;
		ng.loadView(id_venda);
		$('#list_clientes').modal('show');
	}

	ng.loadCliente = function() {
		aj.get(baseUrlApi()+"usuarios?usu->id="+params.id_vendedor)
			.success(function(data, status, headers, config) {
				ng.cliente = data.usuarios[0];
			})
			.error(function(data, status, headers, config) {

			});
	}

	ng.reset();
	ng.loadVendas(0,10);
	ng.loadCliente();
});
