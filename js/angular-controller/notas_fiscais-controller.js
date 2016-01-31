app.controller('NotasFiscaisController', function($scope, $http, $window, $dialogs, UserService,ConfigService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 		= baseUrl();
	ng.userLogged 	= UserService.getUserLogado();
	ng.configuracoes = ConfigService.getConfig(ng.userLogged.id_empreendimento);
	
});
