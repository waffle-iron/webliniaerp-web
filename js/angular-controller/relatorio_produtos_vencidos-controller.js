app.controller('RelatorioProdutosVencidosController', function($scope, $http, $window, UserService) {
	var ng = $scope,
		aj = $http;
	ng.userLogged = UserService.getUserLogado();
	ng.itens = [];
	ng.paginacao = {};

	ng.loadProdutosVencidos = function() {
		aj.get(baseUrlApi()+"produtos/vencidos/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.itens = data.produtos;
			})
			.error(function(data, status, headers, config) {
				arr = null;
			});
	}

	ng.loadProdutosVencidos();
});
