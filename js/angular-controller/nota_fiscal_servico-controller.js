app.controller('NotaFiscalServicoController', function($scope, $http, $window, $dialogs, UserService, ConfigService, AsyncAjaxSrvc){
	$scope.userLogged = UserService.getUserLogado()

	$('#sizeToggle').trigger("click");
});
