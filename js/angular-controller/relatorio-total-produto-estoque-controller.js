app.controller('RelatorioTotalProdutoEstoque', function($scope, $http, $window, UserService) {
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
	ng.qtd_total_estoque = 0;
	ng.vlr_total_estoque = 0;

	ng.reset = function() {
			ng.busca			= {nome_produto:null,id_produto:null,qtd_produto:null,produto_modal:null,depositos:null,id_deposito:null,nome_deposito:null};
			ng.itensPorPagina   = 10 ;
	}

	ng.resetFilter = function() {
		ng.reset();
		ng.loadProdutos(0,ng.itensPorPagina);
	}
	
	ng.aplicarFiltro = function() {
		$("#modal-aguarde").modal('show');
		ng.loadProdutos(0,ng.itensPorPagina);
	}
	ng.grupo_busca     = '';
	ng.grupo_tabela    = 'produto';
	ng.busca_deposito  = false ; 
	ng. agrupar = false ;
	ng.loadProdutos = function(offset,limit) {
		offset = offset == null ? 0 : offset  ;
		limit  = limit == null ? 10 : limit  ;
		ng.produtos = [] ;
		var queryString = "?tpe->id_empreendimento="+ng.userLogged.id_empreendimento;
		if(!empty(ng.busca.id_produto)){
			queryString += "&pro->id="+ng.busca.id_produto;
		}
		if(!empty(ng.busca.id_deposito)){
			queryString +=  "&dep->id="+ng.busca.id_deposito;
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
					ng.produtos = aux;
				}else{
					ng.grupo_tabela = ng.grupo_busca ;
					ng.busca_deposito = empty(ng.busca.id_deposito) ? false : true ;
					ng.produtos = data.produtos;

					calculaTotais();
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

	function calculaTotais() {
		$.each(ng.produtos, function(i, item) {
			ng.qtd_total_estoque += parseInt(item.qtd_item);
			ng.vlr_total_estoque += (parseFloat(item.vlr_custo_real) * parseInt(item.qtd_item));
		});
	}

	ng.configuracao = null ;


	ng.reset();
	ng.aplicarFiltro();
});