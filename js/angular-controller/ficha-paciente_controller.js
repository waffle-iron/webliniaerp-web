app.controller('FichaPacienteController', function($scope, $http, $window, $dialogs, UserService, ConfigService){

	var ng = $scope ,
		aj = $http;
	$scope.userLogged = UserService.getUserLogado();
	ng.configuracoes = ConfigService.getConfig(ng.userLogged.id_empreendimento);
	var params      = getUrlVars();

	ng.procedimentosPaciente = [];
    ng.getProcedimentosPaciente = function(){
    	ng.procedimentosPaciente = null;
    	if( !(typeof params.id_paciente == "undefined") ){
	   		aj.get(baseUrlApi()+"clinica/paciente/"+ params.id_paciente +"/procedimentos")
				.success(function(data, status, headers, config) {
					ng.procedimentosPaciente = data;
					totalizar();
				})
				.error(function(data, status, headers, config) {
					if(status == 404)
						ng.procedimentosPaciente = [];
			});
		}
	}

	ng.paciente = null;
	ng.getDadosPaciente = function(){
		if( !(typeof params.id_paciente == "undefined") ){
			aj.get(baseUrlApi()+"usuario/"+ng.userLogged.id_empreendimento+"/"+params.id_paciente)
	        	.success(function(data, status, headers, config) {
		        	ng.paciente	= data ;
	        		ng.loadCidadesByEstado();
	        	});
        }
	}

	ng.loadCidadesByEstado = function(nome_cidade) {
		ng.cidades = [];

		aj.get(baseUrlApi()+"cidades/"+ ng.paciente.id_estado)
		.success(function(data, status, headers, config) {
			ng.cidades = data;
			if(nome_cidade != null){
				$.each(ng.cidades,function(i, item){
					if(removerAcentos(nome_cidade) == removerAcentos(item.nome)){
						ng.paciente.id_cidade = item.id;
						return false;
					}
				});
			}
		});
	}

	ng.vlrTotalProcedimentos = 0;
	ng.vlrTotalPagamentos = 0;
	function totalizar(){
		ng.vlrTotalProcedimentos = 0 ;
		$.each(ng.procedimentosPaciente,function(index, item){
			ng.vlrTotalProcedimentos += item.valor_real_item;

			if(item.flg_item_pago == 1)
				ng.vlrTotalPagamentos += item.valor_real_item;
		});
	}

	ng.getDadosPaciente();
	ng.getProcedimentosPaciente();
});