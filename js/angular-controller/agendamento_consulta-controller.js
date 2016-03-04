app.controller('AgendamentoConsultaController', function($scope, $http, $window, $dialogs, UserService){

	$scope.userLogged = UserService.getUserLogado();
	
	$scope.openModal = function(){
		$("#modalFichaPaciente").modal('show');
	}

	$scope.openModal();
});