app.controller('AgendamentoConsultaController', function($scope, $http, $window, $dialogs, UserService,ConfigService){

	var ng = $scope ,
		aj = $http;
	$scope.userLogged = UserService.getUserLogado();
	ng.configuracoes = ConfigService.getConfig(ng.userLogged.id_empreendimento);
	ng.busca 		 = {clientes:"",profissionais:""};
	ng.cliente       = {acao_cliente:'insert'} ;
	$scope.openModal = function(){
		$("#modalFichaPaciente").modal('show');
	}

	ng.showBoxNovo = function(onlyShow){
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

	ng.selProfissionais = function(){
		var offset = 0  ;
    	var limit  =  10 ;;

			ng.loadProfissionais(offset,limit);
			$("#list_profissionais").modal("show");
	}

	ng.id_profissional_atendimento = null ;
	ng.addProfissional = function(item){
		ng.id_profissional_atendimento = item.id
	}

	ng.loadProfissionais= function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;
		ng.profissionais = [];
		query_string = "?(tue->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+" AND usu.id_perfil=9&usu->id[exp]= NOT IN("+ng.configuracoes.id_cliente_movimentacao_caixa+","+ng.configuracoes.id_usuario_venda_vitrine+"))";

		if(ng.busca.profissionais != ""){
			query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+ng.busca.profissionais+"%' OR usu.apelido LIKE '%"+ng.busca.profissionais+"%')"}});
		}

		aj.get(baseUrlApi()+"usuarios/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				$.each(data.usuarios,function(i,item){
					ng.profissionais.push(item);
				});
				ng.paginacao_profissionais = [];
				$.each(data.paginacao,function(i,item){
					ng.paginacao_profissionais.push(item);
				});
			})
			.error(function(data, status, headers, config) {
				ng.profissionais = false ;
			});
	}

	ng.selCliente = function(){
		var offset = 0  ;
    	var limit  =  10 ;;

			ng.loadCliente(offset,limit);
			$("#list_clientes").modal("show");
	}

	ng.addCliente = function(item){
		ng.cliente = item;
		console.log(ng.cliente);
		ng.cliente.acao_cliente = "update"
		$("#list_clientes").modal("hide");
		aj.get(baseUrlApi()+"usuarios/saldodevedor/"+ ng.userLogged.id_empreendimento+"?usu->id="+item.id)
			.success(function(data, status, headers, config) {
				ng.cliente.vlr_saldo_devedor = data.vlr_saldo_devedor;
			})
			.error(function(data, status, headers, config) {
				console.log('erro ao consultar saldo do cliente');
			});
	}

	ng.loadCliente= function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;
		ng.clientes = [];
		query_string = "?(tue->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+" AND usu.id_perfil=10&usu->id[exp]= NOT IN("+ng.configuracoes.id_cliente_movimentacao_caixa+","+ng.configuracoes.id_usuario_venda_vitrine+"))";

		if(ng.busca.clientes != ""){
			query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+ng.busca.clientes+"%' OR usu.apelido LIKE '%"+ng.busca.clientes+"%')"}});
		}

		aj.get(baseUrlApi()+"usuarios/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				$.each(data.usuarios,function(i,item){
					ng.clientes.push(item);
				});
				ng.paginacao_clientes = [];
				$.each(data.paginacao,function(i,item){
					ng.paginacao_clientes.push(item);
				});
			})
			.error(function(data, status, headers, config) {
				ng.clientes = false ;
			});
	}

	ng.btnInsertCliente = function(){
		ng.cliente = {acao_cliente:'insert',indicacao:0} ;
	}

	ng.cancelarCadastroCliente = function(){
		ng.cliente = {acao_cliente:'insert',indicacao:0} ;
		ng.showBoxNovo();
	}

	ng.novoAtendimento = function(){
		var btn = $("#btn-incluir-fila");
		btn.button('loading');
		$('.has-error').tooltip('destroy');
    	$('.has-error').removeClass('has-error');

    	var url = "clinica/atendimento/cliente/save" ;
		if(!empty(ng.cliente.acao_cliente == 'update'))
			url = "clinica/atendimento/cliente/update" ;

		ng.cliente.empreendimentos = [{id:ng.userLogged.id_empreendimento}] ;
		ng.cliente.id_perfil = 10 ;

    	aj.post(baseUrlApi()+url,ng.cliente)
			.success(function(data, status, headers, config) {
				ng.cliente.id = data.id ;
				var atendimento = {
					id_empreendimento : ng.userLogged.id_empreendimento ,
					id_paciente : ng.cliente.id,
					dta_entrada : moment().format('YYYY-MM-DD HH:mm:ss'),
					id_usuario_entrada : ng.userLogged.id,
					id_status  : 1 
				}
				aj.post(baseUrlApi()+"clinica/atendimento/save",atendimento)
					.success(function(data, status, headers, config) {
						ng.cancelarCadastroCliente();
						ng.getListaAtendimento();
						btn.button('reset');
					})
					.error(function(data, status, headers, config) {
						btn.button('reset');
				});	
				
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
				if(data.status == 406) {
		 			var errors = data;
		 			var first  = null ;
		 			$.each(data.responseJSON, function(i, item) {
		 				$("#"+i).addClass("has-error");
		 				first = first == null ? $("#"+i) : first ;
		 				var formControl = $($("#"+i))
		 					.attr("data-toggle", "tooltip")
		 					.attr("data-placement", "bottom")
		 					.attr("title", item)
		 					.attr("data-original-title", item);
		 				formControl.tooltip();
		 			});
		 			$('html,body').animate({scrollTop: 0},100,function(){
		 				first.focus();
		 				first.tooltip('show');
		 			});
			 	}else{
			 		alert('Erro ao Atualizar Cliente')
			 	}
		});
	}

	ng.saveAtendimento = function(){
		var atendimento = {
			id_empreendimento : ng.userLogged.id_empreendimento ,
			id_paciente : ng.cliente.id,
			dta_entrada : moment().format('YYYY-MM-DD HH:mm:ss'),
			id_usuario_entrada : ng.userLogged.id,
			id_status  : 1 
		}

		$.ajax({
		 	url: baseUrlApi()+'clinica/atendimento/save',
		 	async: false,
		 	method: 'POST',
		 	data: atendimento,
		 	success: function(data) {
		 		
		 	},
		 	error: function(data,x) {
		 		console.log(data);
		 		alert('erro ao iniciar atendimento');
		 	}
		});
	}

	ng.saveCliente = function(){
		var url = "clinica/atendimento/cliente/save" ;
		if(!empty(ng.cliente.acao_cliente == 'update'))
			url = "clinica/atendimento/cliente/update" ;
		ng.cliente.empreendimentos = [{id:ng.userLogged.id_empreendimento}] ;
		var saida = true ;
		$.ajax({
		 	url: baseUrlApi()+url,
		 	async: false,
		 	method: 'POST',
		 	data: ng.cliente,
		 	success: function(data) {
		 		ng.cliente.id = data.id ;
		 	},
		 	error: function(data,x) {
		 		console.log(data);
		 		console.log(x);
		 		if(data.status == 406) {
		 			var errors = data;
		 			var first  = null ;
		 			$.each(data.responseJSON, function(i, item) {
		 				$("#"+i).addClass("has-error");
		 				first = first == null ? $("#"+i) : first ;
		 				var formControl = $($("#"+i))
		 					.attr("data-toggle", "tooltip")
		 					.attr("data-placement", "bottom")
		 					.attr("title", item)
		 					.attr("data-original-title", item);
		 				formControl.tooltip();
		 			});
		 			$('html,body').animate({scrollTop: 0},100,function(){
		 				first.focus();
		 				first.tooltip('show');
		 			});
			 	}else{
			 		alert('Erro ao Atualizar Cliente')
			 	}
			 	saida = false ;
		 	}
		});
		return saida ;
	}

	ng.id_paciente_atendimento = null ;
	ng.iniciarAtendimento = function(paciente){
		ng.id_profissional_atendimento = null ;
		ng.selProfissionais();
		ng.id_paciente_atendimento = paciente.id;
	}

	ng.setInitAtendimento = function(){
		var post = {	
			dta_inicio_atendimento:moment().format('YYYY-MM-DD HH:mm:ss'),
			id_profissional_atendimento : ng.id_profissional_atendimento,
			id_status:2,
			where:'id = '+ng.id_paciente_atendimento
		};
		aj.post(baseUrlApi()+"clinica/atendimento/update",post)
			.success(function(data, status, headers, config) {
				ng.getListaAtendimento();
				$('#list_profissionais').modal('hide');
			})
			.error(function(data, status, headers, config) {
				
		});
	}

	ng.cancelarModal = function(id){
		$(id).modal('hide');
	}

	ng.lista_atendimento = [] ;
	ng.getListaAtendimento = function(){
		ng.lista_atendimento = null ;
		aj.get(baseUrlApi()+"clinica/atendimentos?cplSql=ta.id_empreendimento="+ng.userLogged.id_empreendimento+" AND date_format(ta.dta_entrada,'%Y-%m-%d') = '"+moment().format('YYYY-MM-DD')+"' ORDER BY ta.dta_entrada ASC")
			.success(function(data, status, headers, config) {
				ng.lista_atendimento = data ;
			})
			.error(function(data, status, headers, config) {
				ng.lista_atendimento = [] ;
		});
	}
	//$scope.openModal();

	ng.getListaAtendimento();
});