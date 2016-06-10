app.controller('ControleMesasController', function($scope, $http, $window, UserService,ConfigService,$dialogs) {
	var ng = $scope,
		aj = $http;
	ng.userLogged = UserService.getUserLogado();
	ng.configuracao  = ConfigService.getConfig(ng.userLogged.id_empreendimento);
	ng.layout = { 
		mesas:true,
		detMesa:false,
		SelCliente:false,
		cadCliente:false,
		detComanda:false,
		detItemComanda:false,
		escTipoProduto:false,
		selTipoProduto:false,
		escProduto:false
	} ;
	ng.telaAnterior = null ;
	ng.mesas = [];
	ng.mesaSelecioada = {mesa:{},comandas:[]} ;
	ng.comandaSelecionada = {};
	ng.busca = {} ;
	ng.buscaTipoProduto = {} ;
	ng.categoriasProduto = [];
	ng.loadingMoreProdutos = false ;
	ng.produtos = {itens:[],paginacao:[]};
	ng.produto = {} ;
	ng.EditProduto = false ;
	$('#sizeToggle').trigger("click");

	ng.changeTela = function(tela){
		if(!empty(tela)){
			$.each(ng.layout,function(i,x){
				if(x) ng.telaAnterior = i ;
				ng.layout[i] = false ;
			});
			ng.layout[tela] = true ;
			$('html,body').animate({scrollTop: 0});
			if(tela=='mesas')
				ng.loadMesas();
			else if(tela=='detMesa')
				ng.loadComandasByMesa();
		}
	}

	ng.loadMesas = function(offset,limit){
		offset = offset ==  null ? 0 : offset ; 
		limit  = limit  ==  null ? 10 : limit ;
		ng.mesas = null ;
		aj.get(baseUrlApi()+"mesas/resumo/?tm->id_empreendimento="+ng.userLogged.id_empreendimento)
		.success(function(data, status, headers, config) {
			ng.mesas = data;
		})
		.error(function(data, status, headers, config) {
			ng.mesas = [] ;
		}); 
	}

	ng.abrirMesa = function(mesa){
		ng.mesaSelecioada.mesa = angular.copy(mesa);
		ng.changeTela('detMesa');
	}

	var interval_busca_clientes = null ;
	ng.autoCompleteCliente = function(busca){
		 clearInterval(interval_busca_clientes);
		 if(!empty(busca)){
			 interval_busca_clientes = setTimeout(function(){
			 	ng.loadClientes(busca);
			 },500);
		}else
			ng.clientes = [] ;
	}

	ng.loadClientes = function(busca){
		ng.clientes = null ;
		busca = angular.copy(busca);
		var url = "usuarios?tue->id_empreendimento="+ng.userLogged.id_empreendimento;
		var query_string = "";
		if(!empty(busca)){
			var buscaCpf  = busca.replace(/\./g, '').replace(/\-/g, '');
			var buscaCnpj = busca.replace(/\./g, '').replace(/\-/g, '').replace(/\//g,'');
			busca = busca.replace(/\s/g, '%');
			query_string += "&"+$.param({"(usu->nome":{exp:"like'%"+busca+"%' OR usu.apelido like '%"+busca+"%' OR tpj.cnpj like '%"+buscaCnpj+"%' OR tpf.cpf like '%"+buscaCpf+"%')"}})+"";
		}
		aj.get(baseUrlApi()+url+query_string)
		.success(function(data, status, headers, config) {
			ng.clientes = data.usuarios ;
		})
		.error(function(data, status, headers, config) {
			ng.clientes = [];
		}); 
	}

	ng.abrirComanda = function(cliente,event){
		var btn = $(event.target);
		if(!btn.is(':button')) btn = $(event.target).parent();
		btn.button('loading');
		var post = {
			id_usuario : ng.userLogged.id,
			id_cliente : cliente.id,
			id_empreendimento : ng.userLogged.id_empreendimento,
			dta_venda : moment().format('YYYY-MM-DD HH:mm:ss'),
			id_mesa : ng.mesaSelecioada.mesa.id_mesa 
		}

		aj.post(baseUrlApi()+'mesa',post)
		.success(function(data, status, headers, config) {
			btn.button('reset');
			ng.changeTela('detMesa');
		})
		.error(function(data, status, headers, config) {
			console.log('Não foi possivel abrir a comanda');
		}); 
	}

	ng.loadComandasByMesa = function(){
		ng.mesaSelecioada.comandas = null ;
		aj.get(baseUrlApi()+'mesa/comandas/'+ng.mesaSelecioada.mesa.id_mesa)
		.success(function(data, status, headers, config) {
			ng.mesaSelecioada.comandas = data ;
		})
		.error(function(data, status, headers, config) {
			ng.mesaSelecioada.comandas = [] ;
			if(status != 406)
			console.log('Não foi possivel buscar as comandas');
		}); 
	}

	ng.qtdTotalComandas = function(){
		var qtd_total = 0 ;
		if(ng.mesaSelecioada.comandas != null){
			$.each(ng.mesaSelecioada.comandas,function(i,x){
				qtd_total += x.qtd_total ;
			});
		}

		return qtd_total ;
	}

	ng.vlrTotalComanda = function(){
		var valor_total = 0 ;
		if(ng.mesaSelecioada.comandas != null){
			$.each(ng.mesaSelecioada.comandas,function(i,x){
				valor_total += x.valor_total ;
			});
		}

		return valor_total ;
	}

	ng.loadComanda = function(id_comanda){
		ng.comandaSelecionada = null ;
		aj.get(baseUrlApi()+'comanda/'+id_comanda)
		.success(function(data, status, headers, config) {
			ng.comandaSelecionada = data ;
		})
		.error(function(data, status, headers, config) {
			ng.comandaSelecionada = {} ;
			if(status != 406)
			console.log('Não foi possivel buscar a comanda');
		}); 
	}

	ng.abrirDetalhesComanda = function(id_comanda){
		ng.changeTela('detComanda');
		ng.loadComanda(id_comanda);
	}

	ng.bucaTipoProduto = function(tipo){
		if(tipo != null){
			ng.buscaTipoProduto = {};
			ng.buscaTipoProduto[tipo] = null ;
			ng.changeTela('selTipoProduto');
		}else{
			ng.buscaTipoProduto = {};
			ng.changeTela('escProduto');
			ng.loadProdutos();
		}
	}

	ng.getTipoBuscaProduto = function(){
		if(typeof ng.buscaTipoProduto.categoria != 'undefined' ){
			return 'categoria';
		}else if(typeof ng.buscaTipoProduto.fabricante != 'undefined' ){
			return 'fabricante';
		}else{
			return null ;
		}
	}

	ng.loadCategorias = function(){
		ng.categoriasProduto = null ;
		aj.get(baseUrlApi()+'categorias?id_empreendimento='+ng.userLogged.id_empreendimento)
		.success(function(data, status, headers, config) {
			ng.categoriasProduto = data.categorias ;
		})
		.error(function(data, status, headers, config) {
			ng.categoriasProduto = [] ;
			if(status != 406)
			console.log('Não foi possivel buscar as categorias');
		}); 
	}

	ng.loadFabricantes = function(){
		ng.fabricantesProduto = null ;
		aj.get(baseUrlApi()+'fabricantes?id_empreendimento='+ng.userLogged.id_empreendimento)
		.success(function(data, status, headers, config) {
			ng.fabricantesProduto = data.fabricantes ;
		})
		.error(function(data, status, headers, config) {
			ng.fabricantesProduto = [] ;
			if(status != 406)
			console.log('Não foi possivel buscar os fabricantes');
		}); 
	}

	ng.setBuscaCategoria = function(categoria){
		ng.buscaTipoProduto.categoria = categoria ;
		ng.changeTela('escProduto');
		ng.loadProdutos();
	}

	ng.setBuscaFabricante = function(fabricante){
		ng.buscaTipoProduto.fabricante = fabricante ;
		ng.changeTela('escProduto');
		ng.loadProdutos();
	}

	var interval_busca_produtos = null ;
	ng.autoCompleteProdutos = function(busca){
		 clearInterval(interval_busca_produtos);
		 interval_busca_produtos = setTimeout(function(){
		 	ng.loadProdutos();
		 },500);
	}


	ng.loadProdutos = function(offset, limit,concat) {
		concat = concat == null ? false : true ;
		
		if(!concat) ng.produtos.itens = null;

		offset = offset == null ? 0  : offset;
		limit  = limit  == null ? 10 : limit;

		var query_string = "?tpe->id_empreendimento="+ng.userLogged.id_empreendimento;

		if(!empty(ng.busca.produtos)){
			var busca = ng.busca.produtos.replace(/\s/g, '%');
			if(isNaN(Number(ng.busca.produtos)))
				query_string += "&("+$.param({nome:{exp:"like '%"+busca+"%' OR codigo_barra like '%"+busca+"%'"}})+")";
			else
				query_string += "&("+$.param({nome:{exp:"like '%"+busca+"%' OR codigo_barra like '%"+busca+"%' OR pro.id = "+busca+""}})+")";
		}

		if(ng.getTipoBuscaProduto() == 'categoria'){
			query_string += '&pro->id_categoria='+ng.buscaTipoProduto.categoria.id; 
		}else if(ng.getTipoBuscaProduto() == 'fabricante'){
			query_string += '&pro->id_fabricante='+ng.buscaTipoProduto.fabricante.id; 
		}

		aj.get(baseUrlApi()+"produtos/"+ offset +"/"+ limit +"/"+query_string)
			.success(function(data, status, headers, config) {
				if(!concat){
					var aux = {itens:data.produtos,paginacao:ng.getNextPage(data.paginacao)}
					ng.produtos = aux;
				}else{
					ng.produtos.itens = ng.produtos.itens.concat(data.produtos);
					ng.produtos.paginacao = ng.getNextPage(data.paginacao);
					ng.loadingMoreProdutos = false ; 
				}
			})
			.error(function(data, status, headers, config) {
				if(status == 404) {
					ng.produtos.itens = [];
					ng.produtos.paginacao = [];
				}
			});
	}

	ng.getNextPage = function(paginacao){
		var indexNext ;
		var pages = [];
		$.each(paginacao,function(i,x){
			if(x.current)
				indexNext = (x.index + 1) ;
			pages[x.index] = x ;
		});
		
		if(typeof pages[indexNext] == 'undefined')
			return false ;
		else
			return pages[indexNext];
	}

	ng.paginacaoProdutos = function(){
		$(window).scroll(function() {
		    if( ( $(document).height() == ($(window).scrollTop() + $(window).height()) ) && ng.layout.escProduto ){
		    	if(ng.produtos.paginacao != false && !ng.loadingMoreProdutos){
		    		ng.loadingMoreProdutos = true ;
		    		ng.loadProdutos(ng.produtos.paginacao.offset,ng.produtos.paginacao.limit,true);
		    	}
		    }

		});
	}

	ng.selProduto = function(produto,edit){
		edit = edit == null ? false : edit ;
		ng.EditProduto = edit ;
		ng.produto = angular.copy(produto);
		if(!edit)
			ng.produto.qtd = 1 ;
		else
			ng.produto.qtd = ng.produto.qtd_total ; 
		ng.changeTela('detItemComanda');
	}

	ng.getPermission = function(str){
		return _in(ng.userLogged.id_perfil,str);
	}

	ng.cancelarProduto = function(){
		ng.produto = {} ;
		if(ng.EditProduto)
			ng.changeTela('detComanda');
		else
			ng.changeTela('escProduto');
	}

	ng.incluirItemComanda = function(event){
		var btn = $(event.target);
		if(!btn.is(':button')) btn = $(event.target).parent();
		btn.button('loading');
		var post = {
			id_venda : ng.comandaSelecionada.comanda.id,
			id_produto : ng.produto.id ,
			desconto_aplicado : 0 ,
			valor_desconto : 0 ,
			qtd : ng.produto.qtd,
			valor_real_item : round(ng.produto.vlr_venda_varejo,2) ,
			vlr_custo : ng.produto.vlr_custo_real,
			perc_imposto_compra : ng.produto.perc_imposto_compra ,
			perc_desconto_compra : ng.produto.perc_desconto_compra,
			perc_margem_aplicada : ng.produto.perc_venda_varejo,
			id_empreendimento : ng.userLogged.id_empreendimento,
			id_deposito : ng.configuracao.id_deposito_padrao
		}

		aj.post(baseUrlApi()+"item_comanda/add",post)
		.success(function(data, status, headers, config) {
			btn.button('reset');
			ng.produto = {} ;
			ng.abrirDetalhesComanda(ng.comandaSelecionada.comanda.id);
		})
		.error(function(data, status, headers, config) {
			btn.button('reset');
			if(status == 406){
				$dialogs.notify('Atenção!','<strong>Produto com estoque insuficiente</strong>');
			}else
				$dialogs.notify('Atenção!','<strong>Erro ao incluir produto</strong>');
		});
	}

	ng.editItemComanda = function(event){
		var btn = $(event.target);
		if(!btn.is(':button')) btn = $(event.target).parent();
		btn.button('loading');
		var post = {
			campos:{
				id_venda : ng.comandaSelecionada.comanda.id,
				id_produto : ng.produto.id ,
				desconto_aplicado : 0 ,
				valor_desconto : 0 ,
				qtd : ng.produto.qtd,
				valor_real_item : round(ng.produto.vlr_venda_varejo,2) ,
				vlr_custo : ng.produto.vlr_custo_real,
				perc_imposto_compra : ng.produto.perc_imposto_compra ,
				perc_desconto_compra : ng.produto.perc_desconto_compra,
				perc_margem_aplicada : ng.produto.perc_venda_varejo,
				id_empreendimento : ng.userLogged.id_empreendimento,
				id_deposito : ng.configuracao.id_deposito_padrao
			},
			where : 'id='+ng.produto.id_item_venda
		}

		aj.post(baseUrlApi()+"item_comanda/edit",post)
		.success(function(data, status, headers, config) {
			btn.button('reset');
			ng.produto = {} ;
			ng.abrirDetalhesComanda(ng.comandaSelecionada.comanda.id);
		})
		.error(function(data, status, headers, config) {
			btn.button('reset');
			if(status == 406){
				$dialogs.notify('Atenção!','<strong>Produto com estoque insuficiente</strong>');
			}else
				$dialogs.notify('Atenção!','<strong>Erro ao incluir produto</strong>');
		});
	}

	ng.excluirItemComanda = function(event){
		var btn = $(event.target);
		if(!btn.is(':button')) btn = $(event.target).parent();
		btn.button('loading');

		aj.get(baseUrlApi()+"item_comanda/delete/"+ng.produto.id_item_venda)
		.success(function(data, status, headers, config) {
			btn.button('reset');
			ng.produto = {} ;
			ng.abrirDetalhesComanda(ng.comandaSelecionada.comanda.id);
		})
		.error(function(data, status, headers, config) {
			btn.button('reset');
			$dialogs.notify('Atenção!','<strong>Erro ao excluir produto</strong>');
		});
	}

	ng.vlrTotalItensComanda = function(){
		var total = 0 ;
		if(!empty(ng.comandaSelecionada) && typeof ng.comandaSelecionada.comanda == 'object'){
			$.each(ng.comandaSelecionada.comanda.itens,function(i,x){
				var vlr = $.isNumeric(Number(x.vlr_venda_varejo)) ? x.vlr_venda_varejo : 0 ;
				var qtd = $.isNumeric(Number(x.qtd_total)) ? x.qtd_total : 0 ;
				total += (qtd*vlr);
			});
		}
		return total ;
	}

	ng.totalItensComanda = function(){
		var total = 0 ;
		if(!empty(ng.comandaSelecionada) && typeof ng.comandaSelecionada.comanda == 'object'){
			$.each(ng.comandaSelecionada.comanda.itens,function(i,x){
				var qtd = $.isNumeric(Number(x.qtd_total)) ? x.qtd_total : 0 ;
				total += qtd;
			});
		}
		return total ;
	}

	ng.loadMesas();
	ng.loadCategorias();
	ng.loadFabricantes();
	ng.paginacaoProdutos();

});