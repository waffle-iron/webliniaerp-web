app.controller('BaixaEstoqueController', function($scope, $http, $window, $dialogs, UserService,ConfigService){
	var ng = $scope
		aj = $http;

	ng.baseUrl 		 = baseUrl();
	ng.userLogged 	 = UserService.getUserLogado();
	ng.configuracoes = ConfigService.getConfig(ng.userLogged.id_empreendimento);
	ng.pacientes     = null;
	ng.profissionais = null ;
	ng.estoqueSaida   = {} ;
	ng.busca         = {'pacientes':"",'profissionais':"",'produtos':"",'depositos':""};

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

	ng.mensagens = function(classe , msg, alertClass){
		alertClass = alertClass != null  ?  alertClass:'.alert-sistema' ;
		$(alertClass).fadeIn().addClass(classe).html(msg);
		setTimeout(function(){
			$(alertClass).fadeOut('slow');
		},5000);
	}

	ng.reset = function() {
	}

	ng.loadPacientes= function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;
		ng.pacientes = null;
		query_string = "?(tue->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+" AND usu.id_perfil=10&usu->id[exp]= NOT IN("+ng.configuracoes.id_cliente_movimentacao_caixa+","+ng.configuracoes.id_usuario_venda_vitrine+"))";

		if(ng.busca.pacientes != ""){
			query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+ng.busca.pacientes+"%' OR usu.apelido LIKE '%"+ng.busca.pacientes+"%')"}});
		}

		aj.get(baseUrlApi()+"usuarios/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.pacientes = data.usuarios;
				ng.paginacao_pacientes = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.pacientes = [] ;
			});
	}

	ng.selPaciente = function(){
		ng.loadPacientes();
		$("#list_pacientes").modal('show');
	}

	ng.addPaciente = function(item){
		ng.estoqueSaida.nome_paciente = item.nome ;
		ng.estoqueSaida.id_cliente    = item.id ;
		$("#list_pacientes").modal('hide');
	}

	ng.loadProfissionais= function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;
		ng.profissionais = null;
		query_string = "?(tue->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+" AND usu.id_perfil=9&usu->id[exp]= NOT IN("+ng.configuracoes.id_cliente_movimentacao_caixa+","+ng.configuracoes.id_usuario_venda_vitrine+"))";

		if(ng.busca.profissionais != ""){
			query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+ng.busca.profissionais+"%' OR usu.apelido LIKE '%"+ng.busca.profissionais+"%')"}});
		}

		aj.get(baseUrlApi()+"usuarios/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.profissionais = data.usuarios;
				ng.paginacao_profissionais = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.profissionais = [] ;
			});
	}
	ng.selProfissionais = function(){
		ng.loadProfissionais();
		$("#list_profissioanais").modal('show');
	}

	ng.addProfissional = function(item){
		ng.estoqueSaida.nome_profissional = item.nome ;
		ng.estoqueSaida.id_profissional   = item.id ;
		$("#list_profissioanais").modal('hide');
	}

	ng.selProduto = function(){
   		ng.busca.produtos = "" ;
   		ng.loadProdutos(0,10);
   		$('#list_produtos').modal('show');
   	}

   	ng.loadProdutos = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;
    	ng.produtos = null ;
    	var query_string = "?tpe->id_empreendimento="+ng.userLogged.id_empreendimento;
    	if(ng.busca.produtos != ""){
    		if(isNaN(Number(ng.busca.produtos)))
    			query_string += "&("+$.param({'pro->nome':{exp:"like'%"+ng.busca.produtos+"%' OR fab.nome_fabricante like'%"+ng.busca.produtos+"%'"}})+")";
    		else
    			query_string += "&("+$.param({'pro->nome':{exp:"like'%"+ng.busca.produtos+"%' OR fab.nome_fabricante like'%"+ng.busca.produtos+"%' OR pro.id = "+ng.busca.produtos+""}})+")";
    	}

		ng.produtos =  null;
		aj.get(baseUrlApi()+"produtos/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.produtos           = data.produtos ;
				ng.paginacao_produtos = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.produtos = [];
			});
	}
	ng.estoqueSaida.produtos = [] ;
	ng.addProduto = function(item){
		var item = angular.copy(item);
		item.qtd_saida = $.isNumeric(item.qtd_saida) ? item.qtd_saida : 1 ;
		ng.estoqueSaida.produtos.push(item) ;
		$("#list_produtos").modal('hide');
	}

	ng.selDeposito = function(){
		$('#list_depositos').modal('show');
		ng.loadDepositos(0,10);
	}
	ng.addDeposito = function(item){
		ng.estoqueSaida.nome_deposito = item.nme_deposito;
		ng.estoqueSaida.id_deposito   = item.id;
		$('#list_depositos').modal('hide');
	}

	ng.loadDepositos = function(offset, limit) {
		offset = offset == null ? 0  : offset;
		limit  = limit  == null ? 10 : limit;
		ng.depositos = null ;
		var query_string = "?id_empreendimento="+ng.userLogged.id_empreendimento ;
		if(!empty(ng.busca.depositos))
			query_string  += "&"+$.param({nme_deposito:{exp:"like '%"+ng.busca.depositos+"%'"}});

    	aj.get(baseUrlApi()+"depositos/"+offset+"/"+limit+query_string)
		.success(function(data, status, headers, config) {
			ng.depositos = data.depositos ;
			ng.paginacao_depositos = data.paginacao ;
			if(ng.depositos.length == 1){
				ng.estoqueSaida.nome_deposito = ng.depositos[0].nme_deposito;
				ng.estoqueSaida.id_deposito   = ng.depositos[0].id;
			}
			
		})
		.error(function(data, status, headers, config) {
			ng.depositos = [] ;	
		});
	}

	ng.salvar = function(){
		var btn = $('#salvar-baixa-estoque');
		btn.button('loading');
		if(!$.isNumeric(ng.estoqueSaida.id_profissional) || !$.isNumeric(ng.estoqueSaida.id_deposito) || ng.estoqueSaida.produtos.length == 0){
			$dialogs.notify('Atenção!','Preencha todos os campos');
			btn.button('reset');
		}
		var produtos = [] ;
		$.each(ng.estoqueSaida.produtos,function(i,v){
			produtos.push({id:v.id,qtd_saida:( $.isNumeric(v.qtd_saida) ? v.qtd_saida : 1 )});
		});
		var post = {
			id_empreendimento : ng.userLogged.id_empreendimento ,
			id_deposito : ng.estoqueSaida.id_deposito,
			id_profissional : ng.estoqueSaida.id_profissional,
			id_usuario : ng.userLogged.id,
			produtos: produtos 
		}
		aj.post(baseUrlApi()+"clinica/produto/baixa",post)
		.success(function(data, status, headers, config) {
			ng.mensagens('alert-success','Baixa realizada com sucesso','.alert-success-baixa');
			btn.button('reset');
			ng.estoqueSaida = {} ;
		})
		.error(function(data, status, headers, config) {
			ng.depositos = [] ;	
		});
	}

	ng.loadDepositos();
});
