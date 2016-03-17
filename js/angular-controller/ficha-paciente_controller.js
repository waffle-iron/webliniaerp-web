app.controller('FichaPacienteController', function($scope, $http, $window, $dialogs, UserService, ConfigService){

	var ng = $scope ,
		aj = $http;
	$scope.userLogged = UserService.getUserLogado();
	ng.configuracoes = ConfigService.getConfig(ng.userLogged.id_empreendimento);
});