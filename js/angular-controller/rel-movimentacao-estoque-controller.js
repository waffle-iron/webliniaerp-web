app.controller('RelatorioTotalProdutoEstoque', function($scope, $http, $window, UserService,$dialogs) {
	var ng 				= $scope,
		aj 				= $http;
	ng.userLogged 		= UserService.getUserLogado();
	ng.itensPorPagina 	= 10;
	ng.deposito 		= {};
	ng.depositos 		= [];
	ng.vendas 		   	= [];
	ng.paginacao 	   	= {};
	ng.busca			= {nome_produto:null,id_produto:null,qtd_produto:null,produto_modal:null,depositos:null,id_deposito:null,nome_deposito:null}
	ng.busca.clientes  	= '';
	ng.cliente          = {};
	ng.saldo_anterior   = false ;
	ng.movimentacoes    = false ;

	ng.reset = function() {
			ng.busca			= {nome_produto:null,id_produto:null,qtd_produto:null,produto_modal:null,depositos:null,id_deposito:null,nome_deposito:null};
			ng.itensPorPagina   = 10 ;
	}

	ng.resetFilter = function() {
		ng.busca = {} ;
		ng.movimentacoes = false ;
	}

	ng.lengthObj = function(obj){
		if(typeof obj == 'object' && !empty(obj))
			return Object.keys(obj).length;
	}
	
	ng.aplicarFiltro = function() {
		if(!$.isNumeric(ng.busca.id_produto)){
			ng.movimentacoes    = false ;
			return;
		}
		$("#modal-aguarde").modal('show');
		ng.loadMovimentacao();
	}
	ng.grupo_busca     = '';
	ng.grupo_tabela    = 'produto';
	ng.busca_deposito  = false ; 
	ng. agrupar = false ;
	ng.loadProdutos = function(offset,limit) {
		offset = offset == null ? 0 : offset  ;
		limit  = limit == null ? 10 : limit  ;
		ng.produtos = [] ;
		var queryString = "";
		if(!empty(ng.busca.id_produto)){
			queryString += "?pro->id="+ng.busca.id_produto;
		}
		if(!empty(ng.busca.id_deposito)){
			queryString += empty(queryString) ? "?dep->id="+ng.busca.id_deposito : "&dep->id="+ng.busca.id_deposito;
		}if( (empty(ng.grupo_busca)) && (!empty(ng.busca.id_deposito)) ){
			var url = 'relatorio/produto/estoque/'+ng.userLogged.id_empreendimento+'/produto_deposito';
			ng. agrupar = false ;
		}else if(empty(ng.grupo_busca)){
			var url = 'relatorio/produto/estoque/'+ng.userLogged.id_empreendimento+'/produto';
			ng. agrupar = false ;
		}else if(!empty(ng.busca.id_deposito) && (ng.grupo_busca == 'produto') ){
			var url = 'relatorio/produto/estoque/'+ng.userLogged.id_empreendimento+'/produto_deposito';
			ng. agrupar = true ;
		}else if(!empty(ng.busca.id_deposito) && (ng.grupo_busca == 'deposito')){
			var url = 'relatorio/produto/estoque/'+ng.userLogged.id_empreendimento+'/produto_deposito';
			ng. agrupar = true ;
		}else{
			var url = 'relatorio/produto/estoque/'+ng.userLogged.id_empreendimento+'/deposito';
			ng. agrupar = ng.grupo_busca ;
		}


		url += queryString;


		aj.get(baseUrlApi()+url)
			.success(function(data, status, headers, config) {
				if(ng.agrupar){
					var aux = _.groupBy(data.produtos, ng.grupo_busca == 'produto' ?  "id_produto" : "nome_deposito");
					if(ng.grupo_busca == 'produto'){
						$.each(aux, function(i,v){
							$.each(data.produtos,function(x,y){
								if(Number(i) == y.id_produto ){
									aux[i].nome = y.nome;
									aux[i].nome_fabricante = y.nome_fabricante ;
									aux[i].peso  = y.peso ;
									return;
								}
							});
						});
					}
					ng.produtos = aux ;
					console.log(aux);
				}else{
					ng.grupo_tabela = ng.grupo_busca ;
					ng.busca_deposito = empty(ng.busca.id_deposito) ? false : true ;
					ng.produtos = data.produtos;
					console.log(data.produtos);
				}
				ng.paginacao.produtos = data.paginacao ;
				$("#modal-aguarde").modal('hide');
			})
			.error(function(data, status, headers, config) {
				ng.produtos = [];
				ng.paginacao.produtos = [];
				$("#modal-aguarde").modal('hide');
			});
	}


	ng.modalProdutos = function(){
		ng.busca.produto_modal = '' ;
		$('#list_produtos').modal('show');
		ng.loadProdutosModal(0,10);
	}

	ng.loadProdutosModal = function(offset,limit) {
		offset = offset == null ? 0 : offset  ;
		limit  = limit == null ? 10 : limit  ;
		var queryString = "?tpe->id_empreendimento="+ng.userLogged.id_empreendimento;

		if(!empty(ng.busca.produto_modal)){
			queryString += "&pro->nome[exp]= LIKE '%"+ng.busca.produto_modal+"%'";
		}

		aj.get(baseUrlApi()+"produtos/"+offset+'/'+limit+"/"+queryString)
			.success(function(data, status, headers, config) {
				ng.produtos_modal = data.produtos;
				ng.paginacao.produtos_modal = data.paginacao ;

			})
			.error(function(data, status, headers, config) {
				ng.produtos_modal = [];
				ng.paginacao.produtos_modal = [];
			});
	}

	ng.addProduto = function(item){
		ng.busca.id_produto   = item.id;
		ng.busca.nome_produto = item.nome;
    	$('#list_produtos').modal('hide');
	}	
	ng.modalDepositos = function(){
		$('#modal-depositos').modal('show');
		ng.loadDepositos(0,10);
	}
	ng.busca_vazia = {} ;
	ng.loadDepositos = function(offset, limit) {
		offset = offset == null ? 0  : offset;
		limit  = limit  == null ? 10 : limit;
		ng.busca_vazia.depositos = false ;
		var query_string = "?id_empreendimento="+ng.userLogged.id_empreendimento ;
		if(!empty(ng.busca.depositos))
			query_string  += "&"+$.param({nme_deposito:{exp:"like '%"+ng.busca.depositos+"%'"}});

    	aj.get(baseUrlApi()+"depositos/"+offset+"/"+limit+query_string)
		.success(function(data, status, headers, config) {
			ng.depositos = data.depositos ;	
			ng.paginacao.depositos = data.paginacao ;
		})
		.error(function(data, status, headers, config) {
			if(status != 404)
				alert("ocorreu um erro");
			else{
				ng.paginacao.depositos = [] ;
				ng.depositos = [] ;	
				ng.busca_vazia.depositos = true ;
			}
				
		});
	}

	ng.addDeposito = function(item){
		ng.busca.id_deposito   = item.id;
		ng.busca.nome_deposito = item.nme_deposito;
    	$('#modal-depositos').modal('hide');
	}

	ng.loadMovimentacao= function() {
		ng.saldo_anterior   = false ;
		ng.movimentacoes = null ;
		var query_string = "" ;
		var dta_saldo_anterior = "";
		if(!empty(ng.busca.dta_inicial) && empty(ng.busca.dta_final)){
			dta_saldo_anterior = ng.busca.dta_inicial ;
			query_string = empty(query_string) ? 'WHERE '  : query_string ;
			query_string  += " date_format(dta_movimentacao,'%Y-%m-%d')>='"+ng.busca.dta_inicial+"'";
		}else if(!empty(ng.busca.dta_final) && empty(ng.busca.dta_inicial)){
			query_string = empty(query_string) ? 'WHERE '  : query_string ;
			query_string  += " date_format(dta_movimentacao,'%Y-%m-%d')<='"+ng.busca.dta_final+"'" ;
		}else if(!empty(ng.busca.dta_final) && !empty(ng.busca.dta_inicial)){
			dta_saldo_anterior = ng.busca.dta_inicial ;
			query_string = empty(query_string) ? 'WHERE '  : query_string ;
			query_string  += " dta_movimentacao BETWEEN '"+ng.busca.dta_inicial+" 00:00:00' AND '"+ng.busca.dta_final+" 23:59:59'" ;
		}
		query_string = "?cplSql="+query_string+" ORDER BY dta_movimentacao ASC" ;
    	aj.get(baseUrlApi()+"movimentacao_estoque/produto/"+ng.userLogged.id_empreendimento+"/"+ng.busca.id_produto+"/null"+(empty(dta_saldo_anterior) ? '' : '/'+dta_saldo_anterior )+query_string)
		.success(function(data, status, headers, config) {
			var saldo_anterior = 0 ;
			if(!empty(data.saldo_anterior) || (empty(data.saldo_anterior) && data.movimentacoes == 0)){
				ng.saldo_anterior   =  data.saldo_anterior ;
				saldo_anterior = data.saldo_anterior ;
			}
			$.each(data.movimentacoes,function(i,v){
				var dta = v.dta_movimentacao.split(' ');
				if(v.acao == 'entrada' && v.tipo == 'inventario'){
					saldo_anterior = v.qtd_item;
				}else if(v.acao == 'entrada'){
					saldo_anterior += v.qtd_item ;
				}else if(v.acao == 'saida'){
					saldo_anterior -= v.qtd_item ;
				}
				data.movimentacoes[i].dta = dta[0];
				data.movimentacoes[i].saldo = saldo_anterior;
			});	
			ng.movimentacoes =  _.groupBy(data.movimentacoes, "dta"); 
			console.log(ng.movimentacoes);
			$("#modal-aguarde").modal('hide');
		})
		.error(function(data, status, headers, config) {
			ng.movimentacoes = [] ;
			$("#modal-aguarde").modal('hide');
		});
	}

	ng.configuracao = null ;


	ng.reset();
	//ng.aplicarFiltro();
});