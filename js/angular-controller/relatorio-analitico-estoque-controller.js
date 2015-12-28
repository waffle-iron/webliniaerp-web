app.controller('RelatorioAnaliticoEstoqueController', function($scope, $http, $window, UserService) {
	var ng = $scope,
		aj = $http;
	ng.userLogged = UserService.getUserLogado();
	ng.itensPorPagina = 10;
	ng.deposito = {};
	ng.depositos = [];
	ng.itens = [];
	ng.paginacao = {};

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

		ng.loadItens(0);
	}

	ng.loadItens = function(offset) {
		aj.get(baseUrlApi()+"relatorio/estoque/analitico/"+ offset +"/"+ng.itensPorPagina+"/?id_deposito="+ng.deposito.id+"&id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.reset();
				ng.itens = data.dados;
				ng.paginacao.itens = data.paginacao;
				$(".modal").modal('hide');
			})
			.error(function(data, status, headers, config) {
				ng.reset();
				$(".modal").modal('hide');
			});
	}

	ng.loadDepositos = function() {
		aj.get(baseUrlApi()+"depositos?id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.depositos = data.depositos;
			})
			.error(function(data, status, headers, config) {
				console.log(data, status, headers, config);
			});
	}

	ng.reset();
	ng.loadDepositos();
});
