app.controller('Empreendimento_config-Controller', function($scope, $http, $window, $dialogs, UserService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 		 = baseUrl();
	ng.userLogged 	 = UserService.getUserLogado();
	ng.currentNode 	 = null;
	ng.exists_cookie = null ; 

	 ng.loadPlanoContas = function() {
	 	ng.currentNode 	= null;
		aj.get(baseUrlApi()+"planocontas?tpc->id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.planoContas = data;
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.planoContas = [];
			});
	}

	ng.mensagens = function(classe , msg, alertClass){
		alertClass = alertClass != null  ?  alertClass:'.alert-sistema' ;
		$(alertClass).fadeIn().addClass(classe).html(msg);
		setTimeout(function(){
			$(alertClass).fadeOut('slow');
		},5000);
	}

	ng.reset = function() {
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").removeClass("has-error");
	}

	ng.loadEmpreendimento = function(id_empreendimento) {
		aj.get(baseUrlApi()+"empreendimento/"+id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.empreendimento = data;
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.empreendimento = [];
			});
	}

	ng.update = function() {
		ng.reset();
		$('#formEmprendimento').ajaxForm({
		 	url: baseUrlApi()+"empreendimento/config/update",
		 	type: 'post',
		 	data: ng.empreendimento,
		 	success:function(data){
		 		ng.mensagens('alert-success', 'Configurações atualizadas com sucesso');
		 	},
		 	error:function(data){
		 		if(data.status == 406){
		 			$.each(data.responseJSON, function(i, item) {
						$("#"+i).addClass("has-error");

						var formControl = $($("#"+i))
							.attr("data-toggle", "tooltip")
							.attr("data-placement", "bottom")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();
					});
		 		}
		 	}
		}).submit(); 
	}
	ng.tipo_plano = null ;
	ng.config     = {} ;
	ng.modalPlanoContas = function(tipo){
		ng.tipo_plano = tipo;
		ng.loadPlanoContas();
		$('#modal-plano-contas').modal('show');
	}

	ng.escolherPlano = function(){
		console.log(ng.tipo_plano,ng.currentNode);
		if(ng.tipo_plano =='movimentacao'){
			ng.config.nome_plano_movimentacao = ng.currentNode.dsc_plano ;
			ng.id_plano_movimentacao_caixa    = ng.currentNode.id;
		}
		else if(ng.tipo_plano =='fechamento'){
			ng.config.nome_plano_fechamento = ng.currentNode.dsc_plano ;
			ng.id_plano_fechamento_caixa    = ng.currentNode.id;
		}
		$('#modal-plano-contas').modal('hide');
	}

	ng.existsCookie = function(){
		 $.ajax({
		 	url: "setup_caixa.php?exists=true",
		 	async: false,
		 	success: function(data) {
		 		ng.exists_cookie = data;
		 		ng.config.pth_local = data.pth_local;
		 	},
		 	error: function(error) {
		 		ng.exists_cookie = false
		 	}
		 });
	}

	ng.loadConfig = function(){
		var error = 0 ;
		aj.get(baseUrlApi()+"configuracoes/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.configuracoes = data;
				if(data.id_plano_caixa == undefined){
					$('#id_plano_caixa').addClass('has-error');
					error++ ;
				}else{
					ng.loadPlanoConta(data.id_plano_caixa,'movimentacao');
					$('#id_plano_caixa').removeClass('has-error');
				}

				if(!ng.exists_cookie){
					$('#pth_local').addClass('has-error');
					error++ ;
				}else{
					$('#pth_local').removeClass('has-error')
				}

				if(data.id_plano_fechamento_caixa == undefined){
					$('#id_plano_fechamento_caixa').addClass('has-error');
					error++;
				}else{
					ng.loadPlanoConta(data.id_plano_fechamento_caixa,'fechamento');
					$('#id_plano_fechamento_caixa').removeClass('has-error');
				}

				if(error > 0)
					$('.alert-error-config').show();
				else{
					$('.alert-error-config').hide();
				}

			})
			.error(function(data, status, headers, config) {
				if(status == 404){
					ng.configuracoes = [];
					$('#id_plano_caixa').addClass('has-error');
					$('#id_plano_fechamento_caixa').addClass('has-error');
					$('.alert-error-config').show();
					if(!ng.exists_cookie){
						$('#pth_local').addClass('has-error');
					}
				}
			});	
	}

	ng.loadPlanoConta = function(id,tipo) {
		var r  = false ;
		aj.get(baseUrlApi()+"planoconta/"+id)
			.success(function(data, status, headers, config) {
				console.log(data);
				if(tipo == 'movimentacao'){
					ng.config.nome_plano_movimentacao = data.dsc_plano;
					ng.id_plano_movimentacao_caixa = data.id;
				}else if(tipo == 'fechamento'){
					ng.config.nome_plano_fechamento = data.dsc_plano ;
					ng.id_plano_fechamento_caixa = data.id;
				}
			})
			.error(function(data, status, headers, config) {
			});
	}
	ng.config = {} ;
	ng.salvarConfig = function(){
		var chaves = [];
		if(ng.id_plano_fechamento_caixa != undefined){
			var item1 = {
							nome 				:'id_plano_fechamento_caixa',
							valor 				:ng.id_plano_fechamento_caixa , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item1);
		}


		if(ng.id_plano_movimentacao_caixa != undefined){
			var item2 = {
							nome 				:'id_plano_caixa',
							valor 				:ng.id_plano_movimentacao_caixa , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item2);
		}
		var pth_local_sucess = false ;
		if(ng.config.pth_local != undefined){

			aj.post("setup_caixa.php",{pth_local: ng.config.pth_local } )
				.success(function(data, status, headers, config) {
					ng.exists_cookie = true ;
				})
				.error(function(data, status, headers, config) {

				});
		}

		aj.post(baseUrlApi()+"configuracao/save/",{ chaves:chaves, pth_local: ng.config.pth_local } )
			.success(function(data, status, headers, config) {
				ng.mensagens('alert-success', 'Configurações atualizadas com sucesso','.alert-config');
				ng.loadConfig();
			})
			.error(function(data, status, headers, config) {
			});
	}

	ng.cancelarModal = function(id){
		$('#'+id).modal('hide');
	}


	function defaulErrorHandler(data, status, headers, config) {
		ng.mensagens('alert-danger','<strong>'+ data +'</strong>');
	}

	ng.loadEmpreendimento(ng.userLogged.id_empreendimento);
	ng.existsCookie();
	ng.loadConfig();

	
});
