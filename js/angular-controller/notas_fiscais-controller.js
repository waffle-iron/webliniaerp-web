app.controller('NotasFiscaisController', function($scope, $http, $window, $dialogs, UserService,ConfigService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 			= baseUrl();
	ng.userLogged 		= UserService.getUserLogado();
	ng.configuracoes 	= ConfigService.getConfig(ng.userLogged.id_empreendimento);
	ng.notas 			= null;
	ng.paginacao 		= {};
	
	ng.loadNotas = function(offset,limit) {
		ng.notas = [];
		var query_string = "?cod_empreendimento="+ ng.userLogged.id_empreendimento;

		aj.get(baseUrlApi()+"notas/"+ offset +"/"+ limit + query_string)
			.success(function(data, status, headers, config) {
				ng.notas 			= data.notas;
				ng.paginacao.notas 	= data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.notas = null;
			});
	}

	ng.showDANFEModal = function(nota){
		eModal.setEModalOptions({
			loadingHtml: '<div><div style="text-align: center;margin-top:5px;margin-bottom:3px"><span class="fa fa-circle-o-notch fa-spin fa-3x text-primary"></span></div><div style="text-align: center;"><span class="h4">Carregando, aguarde...</span></div></div>'
		});
        eModal
            .iframe({
            	message: nota.caminho_danfe, 
            	title: 'DANFE NF-e Nº '+ nota.numero, 
            	size: 'lg'
            })
            .then(function(){
            	t8.success('iFrame loaded!!!!', title)
        	});
	}

	ng.loadNotas(0,10);
});
