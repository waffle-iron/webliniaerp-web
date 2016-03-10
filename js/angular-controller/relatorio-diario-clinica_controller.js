app.controller('RelatorioDiarioClinicaController', function($scope, $http, $window, $dialogs, UserService,ConfigService){
	var ng = $scope,
		aj = $http;

	ng.userLogged 	 		= UserService.getUserLogado();
	ng.userLogged.nme_logo 	= "logo-clinicas-inteligentes.png";
});