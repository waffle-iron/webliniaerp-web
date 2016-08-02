app.controller('LancamentosController', function($scope, $http, $window, $dialogs, UserService){
	$scope.userLogged = UserService.getUserLogado();

	$scope.editing = false;

	$scope.showBoxNovo = function(clearData){
    	$scope.editing = !$scope.editing;
		$('#box-novo').toggle(0,function(){$("select").trigger("chosen:updated");});
		if(clearData)
			clearObject();
	}

	$scope.buscaAvancada = function(){
		$("select").trigger("chosen:updated");
		$scope.busca_avancada = !$scope.busca_avancada;
	}

	function clearObject() {
		$scope.status_servicos = [{
			cod_status_servico: 2,
			dsc_status_servico: 'Entregue/Concluído'
		},{
			cod_status_servico: 1,
			dsc_status_servico: 'Em andamento'
		},{
			cod_status_servico: 0,
			dsc_status_servico: 'Pendente'
		}];

		$scope.objectModel = {
			cod_status_servico: 0
		};

		$scope.busca_avancada = false;
	}

	clearObject();

	$('#sizeToggle').trigger("click");
});
