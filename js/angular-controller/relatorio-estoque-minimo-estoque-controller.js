app.controller('RelatorioProdutosEstoqueMinimoController', function($scope, $http, $window, UserService) {
	var ng = $scope,
		aj = $http;

	ng.userLogged = UserService.getUserLogado();

	ng.itensEstoqueMinimo = [];

	ng.loadProdutosEstoqueMinimo = function() {
		aj.get(baseUrlApi()+"produtos/estoque/minimo?id_empreendimento="+ ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.itensEstoqueMinimo = data;
			})
			.error(function(data, status, headers, config) {
				arr = null;
			});
	}

	ng.loadProdutosEstoqueMinimo();
});
