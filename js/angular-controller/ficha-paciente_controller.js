app.controller('FichaPacienteController', function($scope, $http, $window, $dialogs, UserService, ConfigService){

	var ng = $scope ,
		aj = $http;
	$scope.userLogged = UserService.getUserLogado();
	ng.userLogged.nme_logo 	= "logo-clinicas-inteligentes.png";
	ng.configuracoes = ConfigService.getConfig(ng.userLogged.id_empreendimento);
});