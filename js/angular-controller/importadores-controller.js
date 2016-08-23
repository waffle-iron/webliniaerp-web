app.controller('ImportadoresController', function($scope, $http, $window, $dialogs, UserService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 		= baseUrl();
	ng.userLogged 	= UserService.getUserLogado();
	ng.importador 	= {};
    ng.importadores	= [];

    ng.editing = false;

    ng.showBoxNovo = function(onlyShow){
    	ng.editing = !ng.editing;

    	if(onlyShow) {
			$('i','#btn-novo').removeClass("fa-plus-circle").addClass("fa-minus-circle");
			$('#box-novo').show();
		}
		else {
			$('#box-novo').toggle(400, function(){
				if($(this).is(':visible')){
					$('i','#btn-novo').removeClass("fa-plus-circle").addClass("fa-minus-circle");
				}else{
					$('i','#btn-novo').removeClass("fa-minus-circle").addClass("fa-plus-circle");
				}
			});
		}
	}

	ng.mensagens = function(classe , msg){
		$('.alert-sistema').fadeIn().addClass(classe).html(msg);

		setTimeout(function(){
			$('.alert-sistema').fadeOut('slow');
		},5000);
	}

	ng.reset = function() {
		ng.importador = {};
		ng.editing = false;
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").removeClass("has-error");
	}

	ng.load = function() {
		aj.get(baseUrlApi()+"importadores?tie->id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.importadores = data.importadores;
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.importadores = [];
			});
	}

	ng.salvar = function() {
		var url = 'importador';
		var itemPost = {};

		if(ng.importador.id != null && ng.importador.id > 0) {
			itemPost.id = ng.importador.id;
			url += '/update';
		}

		itemPost.id_empreendimento 	= ng.userLogged.id_empreendimento;
		itemPost.nome_importador 	= ng.importador.nome_importador;

		aj.post(baseUrlApi()+url, itemPost)
			.success(function(data, status, headers, config) {
				ng.mensagens('alert-success','<strong>Importador salvo com sucesso!</strong>');
				ng.showBoxNovo();
				ng.reset();
				ng.load();
			})
			.error(function(data, status, headers, config) {
				if(status == 406) {
					var errors = data;

					$.each(errors, function(i, item) {
						$("#"+i).addClass("has-error");

						var formControl = $($("#"+i).find(".form-control")[0])
							.attr("data-toggle", "tooltip")
							.attr("data-placement", "bottom")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();
					});
				}
			});
	}

	ng.editar = function(item) {
		ng.importador = angular.copy(item);
		ng.showBoxNovo(true);
	}

	ng.delete = function(item){
		dlg = $dialogs.confirm('Atenção!!!' ,'<strong>Tem certeza que deseja excluir este importador?</strong>');

		dlg.result.then(function(btn){
			aj.get(baseUrlApi()+"importador/delete/"+item.id)
				.success(function(data, status, headers, config) {
					ng.mensagens('alert-success','<strong>Importador excluido com sucesso</strong>');
					ng.reset();
					ng.load();
				})
				.error(defaulErrorHandler);
		}, undefined);
	}

	function defaulErrorHandler(data, status, headers, config) {
		ng.mensagens('alert-danger','<strong>'+ data +'</strong>');
	}

	ng.load();
});
