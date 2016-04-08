app.controller('PedidoTransferenciaController', function($scope, $http, $window, $dialogs, UserService){
	var ng = $scope
		aj = $http;

	ng.baseUrl 		= baseUrl();
	ng.userLogged 	= UserService.getUserLogado();
	ng.busca 		= {empreendimento:'',produto:''} ;
	ng.paginacao    = {};
    ng.lista_emp    = [];
    var transferenciaTO = {
    	id : null,
		id_empreendimento_pedido : ng.userLogged.id_empreendimento,
		id_empreendimento_transferencia : null,
		id_usuario_pedido : ng.userLogged.id,
		id_usuario_transferencia : null,
		dta_pedido : null,
		dta_transferencia : null,
		id_status_transferencia : 1,
   		produtos:[]
	};
    ng.transferencia = angular.copy(transferenciaTO);

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

	ng.cancelar = function(){
		ng.showBoxNovo();
		ng.transferencia = angular.copy(transferenciaTO);
	}

	ng.isNumeric = function(vlr){
		return $.isNumeric(vlr);
	}

	ng.mensagens = function(classe , msg, alertClass){
		alertClass = alertClass != null  ?  alertClass:'.alert-sistema' ;
		$(alertClass).fadeIn().addClass(classe).html(msg);
		setTimeout(function(){
			$(alertClass).fadeOut('slow');
		},5000);
	}

	ng.showEmpreendimentos = function() {
		$('#list_empreendimentos').modal('show');
		ng.loadAllEmpreendimentos(0,10);
	}

	ng.loadAllEmpreendimentos = function(offset, limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;

    	var query_string = "?id_usuario="+ng.userLogged.id+"&emp->id[exp]=<>"+ng.userLogged.id_empreendimento;
    	if(ng.busca.empreendimento != ""){
    		query_string = "&" +$.param({nome_empreendimento:{exp:"like'%"+ng.busca.empreendimento+"%'"}});
    	}

    	ng.empreendimentos = [];
		aj.get(baseUrlApi()+"empreendimentos/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.empreendimentos = data.empreendimentos;
				ng.paginacao.empreendimentos = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.empreendimentos = [];
			});
	}
	ng.addEmpreendimento = function(item) {
		ng.transferencia.id_empreendimento_transferencia = item.id;
		ng.transferencia.nome_empreendimento = item.nome_empreendimento ;
		$('#list_empreendimentos').modal('hide');
	}


	ng.showProdutos = function(){
		$('#list_produtos').modal('show');
		ng.busca.produto = "";
		ng.loadProdutos(0,10);
	}

	ng.loadProdutos = function(offset, limit) {
		ng.produtos = null;

		offset = offset == null ? 0  : offset;
		limit  = limit  == null ? 10 : limit;

		var query_string = "?tpe->id_empreendimento="+ng.transferencia.id_empreendimento_transferencia;
		query_string +="&pro->id[exp]= IN(SELECT tp.id FROM tbl_produtos AS tp INNER JOIN tbl_produto_empreendimento AS tpe ON tp.id = tpe.id_produto WHERE tpe.id_empreendimento IN ("+ng.userLogged.id_empreendimento+"))";

		if(ng.busca.produto != ""){
			if(isNaN(Number(ng.busca.produto)))
				query_string += "&("+$.param({nome:{exp:"like '%"+ng.busca.produto+"%' OR codigo_barra like '%"+ng.busca.produto+"%' OR fab.nome_fabricante like '%"+ng.busca.produto+"%'"}})+")";
			else
				query_string += "&("+$.param({nome:{exp:"like '%"+ng.busca.produto+"%' OR codigo_barra like '%"+ng.busca.produto+"%' OR fab.nome_fabricante like '%"+ng.busca.produto+"%' OR pro.id = "+ng.busca.produto+""}})+")";
		}

		aj.get(baseUrlApi()+"produtos/"+ offset +"/"+ limit +"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.produtos = data.produtos;
				ng.paginacao.produtos = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				if(status == 404) {
					ng.produtos = [];
					ng.paginacao.produtos = null;
				}
			});
	}

	ng.produtoSelected = function(id){
		var r = false ;
		$.each(ng.transferencia.produtos,function(i,x){
			if(Number(x.id) == Number(id)){
				r = true ;
				return false ;
			}
		});
		return r ;
	}

	ng.excluirProdutoLista = function(index){
		ng.transferencia.produtos.splice(index,1);
	}

	ng.addProduto = function(item){
		var produto = angular.copy(item) ;
		produto.id_produto = item.id ;
		ng.transferencia.produtos.push(produto);
		item.qtd_pedida = null ;
	}

	ng.salvarTransferencia = function(){
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").removeClass("has-error");
		var btn = $('#salvar-transferencia');
		btn.button('loading');
		var error = 0 ;

		if(!$.isNumeric(ng.transferencia.id_empreendimento_transferencia)){
			$("#id_empreendimento_transferencia").addClass("has-error");
			var formControl = $('#id_empreendimento_transferencia')
				.attr("data-toggle", "tooltip")
				.attr("data-placement", "top")
				.attr("title", 'Informe o empreendimento que está solicitando a transferência')
				.attr("data-original-title", 'Informe o empreendimento que está solicitando a transferência');
			formControl.tooltip();
			if(error == 0) formControl.tooltip('show');

			error ++ ;
		}

		if(ng.transferencia.produtos.length == 0){
			$("#produtos").addClass("has-error");
			var formControl = $('#produtos')
				.attr("data-toggle", "tooltip")
				.attr("data-placement", "top")
				.attr("title", 'Informe os produtos para transferência')
				.attr("data-original-title", 'Informe os produtos para transferência');
			formControl.tooltip();
			if(error == 0) formControl.tooltip('show');
			error ++ ;
		}	

		if(error > 0){
			btn.button('reset'); 
			$('html,body').animate({scrollTop: 0},'slow');
			return ;
		}
		var post = angular.copy(ng.transferencia);
		aj.post(baseUrlApi()+"estoque/pedido/transferencia",post)
		.success(function(data, status, headers, config) {
			btn.button('reset'); 
			ng.transferencia = angular.copy(transferenciaTO);
			ng.showBoxNovo();
			ng.mensagens('alert-success','<b>Pedido de transferência realizado com sucesso</b>','.alert-transferencia-lista');
			$('html,body').animate({scrollTop: 0},'slow');

		})
		.error(function(data, status, headers, config) {
			ng.mensagens('alert-danger','<b>Ocorreu um erro ao realizar o pedido</b>','.alert-transferencia-form');
			$('html,body').animate({scrollTop: 0},'slow');
			btn.button('reset'); 
		});
	}

});
