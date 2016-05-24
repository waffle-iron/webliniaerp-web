app.controller('PDVController', function($scope, $http, $window,$dialogs, UserService,$q) {
	var ng = $scope,
		aj = $http;

	ng.userLogged 	 		= UserService.getUserLogado();
	ng.busca 		 		= {codigo: "", ok: false};
	ng.msg 		     		= "";
	ng.itensCarrinho 		= [];
	ng.nome_ultimo_produto 	= null ;
	ng.imgProduto			= 'img/imagem_padrao_produto.gif';
	ng.busca.clientes       = '';
	ng.paginacao            = {produtos:null};
	ng.pth_local            = $.cookie('pth_local');
	ng.caixa_aberto         = null ;
	ng.cliente              = {id:""};
	ng.total_pg             = 0 ;
	ng.troco				= 0;
	ng.abrir_pdv			= false;
	ng.receber_pagamento    = false;
	ng.tipo_busca_cliente   = 'nome';

	ng.reforco             = {} ;
	ng.sangria             = {} ;
	ng.abertura_reforco    = {} ;
	ng.pagamentos          = [];
	ng.caixa_configurado   = true ;

	ng.carrinho = [];
	ng.vlrTotalCompra = 0;
	ng.exists_cookie = null ;

	ng.formas_pagamento = [
		{nome:"Dinheiro",id:3},
		{nome:"Cheque",id:2},
		/*{nome:"Boleto Bancário",id:4},*/
		{nome:"Cartão de Débito",id:5},
		{nome:"Cartão de Crédito",id:6},
	  ];

	ng.resizeScreen = function() {
		if($("#top-nav").css("display") == "block"){
			$("#map_canvas").css("height", 700);
			$("footer").css("margin-left", 0);
			$("#main-container").css("margin-left", 0).css("padding-top", 0);
			$("#top-nav").toggle();
			$("aside").toggle();
			$("#breadcrumb").toggle();
		}
		else {
			$("#map_canvas").css("height", 600);
			$("footer").css("margin-left", 194);
			$("#main-container").css("margin-left", 194).css("padding-top", 45);
			$("#top-nav").toggle();
			$("aside").toggle();
			$("#breadcrumb").toggle();
		}
	}

	ng.calcTotalCompra = function() {
		var total = 0 ;
		$.each(ng.carrinho, function(i, item) {
			total += Number(item.sub_total);
		});
		ng.vlrTotalCompra = Math.round( total * 100) /100  ;
	}

	ng.calcSubTotal = function(item){
		var qtd_total = isNaN(Number(item.qtd_total)) || Number(item.qtd_total) == 0  ? 1 : Number(item.qtd_total) ;
		item.sub_total = qtd_total * Number(item.vlr_unitario);
		ng.calcTotalCompra();
	}

	ng.findProductByBarCode = function() {
		/*if(ng.cliente == null){
			$dialogs.notify('Atenção!','Antes de adicionar um produto, selecione um cliente');
			return;
		}
		*/
		if(ng.busca.codigo != "") {
			ng.msg = "";
			ng.busca.ok = !ng.busca.ok;
			$http.get(baseUrlApi()+'estoque/?prd->codigo_barra='+ng.busca.codigo+"&emp->id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.busca.codigo = "" ;
				ng.incluirCarrinho(data.produtos[0]);
				ng.calcTotalCompra();
				//ng.verificarCarrinho(data.produtos);
	        }).error(function(data, status) {
	        	ng.busca.ok = false;
				ng.msg = "O código de barra não existe ou o produto não está disponivel em estoque!";
	   	    });

		}
		else {
			ng.showProdutos();
			//ng.busca.ok = false;
			//ng.msg = "O código de barras é obrigatório!";
		}
	}

	ng.indexItensEstoque = null ;
	ng.showModal = function(produtos,nome_produto,index){
		if(index == null){
			ng.itensEstoque 		 = _.groupBy(produtos, "nome_deposito");
			ng.nome_produto_modal    = produtos[0].nome_produto ;
			ng.indexItensEstoque 	 = null;
		}else{
			ng.itensEstoque 		 = angular.copy(produtos) ;
			ng.indexItensEstoque	 = index ;
			ng.nome_produto_modal	 = nome_produto;
		}
		$("#list_validades").modal("show");
	}

	ng.verificarCarrinho = function(item){
		var id_produto = item[0].id_produto;
		var saida = true ;
		var estoques = item;
		var index    = null ;
		$.each(ng.carrinho,function(i,value){
			console.log(id_produto, value.id_produto);
			if(parseInt(id_produto) == parseInt(value.id_produto)){
				saida     = false ;
				estoques  = value.estoques;
				index     = i ;
				return;
			}
		});
		if(saida){
			//ng.showModal(estoques);
			ng.itensEstoque
		}else{
			ng.showModal(estoques, estoques.nome_produto, index);
		}
	}

	ng.incluirCarrinho = function(produto){
		produto = angular.copy(produto);
		if(ng.cliente.nome_perfil == "atacado"){
			produto.vlr_unitario    = produto.vlr_venda_atacado;
			produto.vlr_real        = produto.vlr_venda_atacado;
		}else if(ng.cliente.nome_perfil == "varejo"){
			produto.vlr_unitario	= produto.vlr_venda_varejo;
			produto.vlr_real        = produto.vlr_venda_varejo;
		}else if(ng.cliente.nome_perfil == "vendedor Externo"){
			produto.vlr_unitario	= produto.vlr_venda_intermediario;
			produto.vlr_real        = produto.vlr_venda_intermediario;
		}else{
			produto.vlr_unitario    = produto.vlr_venda_varejo;
			produto.vlr_real        = produto.vlr_venda_varejo;
		}
		produto.valor_desconto = 0;
		produto.qtd_total = 1 ;
		produto.sub_total = produto.qtd_total * produto.vlr_unitario;

		ng.vezes_valor			    = produto.qtd_total+' x R$ '+numberFormat(produto.vlr_unitario,2,',','.');
		ng.nome_ultimo_produto      = produto.nome_produto ;

		if(produto.img != null)
			ng.imgProduto = produto.img ;
		else
			ng.imgProduto = 'img/imagem_padrao_produto.gif';

		ng.carrinho.push(produto) ;
		//var produto  = {nome_produto:null,qtd_total:0/*,estoques:ng.itensEstoque*/} ;
		/*var cont     = 0;
		$.each(ng.itensEstoque,function(index,value){
			$.each(value,function(i,item){
				if(cont == 0){
					produto.nome_produto            = item.nome_produto;
					produto.id_produto 				= item.id_produto;
					produto.img						= baseUrl() + item.img;
					produto.valor_desconto          = item.vlr_desconto_cliente * 100 ;
					produto.flg_desconto			= "0" ;

					if(ng.cliente.nome_perfil == "atacado"){
						produto.vlr_unitario = item.vlr_venda_atacado;
						produto.vlr_real     = item.vlr_venda_atacado;
					}else if(ng.cliente.nome_perfil == "varejo"){
						produto.vlr_unitario	= item.vlr_venda_varejo;
						produto.vlr_real     = item.vlr_venda_varejo;
					}else if(ng.cliente.nome_perfil == "vendedor Externo"){
						produto.vlr_unitario	= item.vlr_venda_intermediario;
						produto.vlr_real     = item.vlr_venda_intermediario;
					}
				}
				if(item.qtd_saida != null && !isNaN(parseInt(item.qtd_saida))){
					produto.qtd_total += parseInt(item.qtd_saida);
				}
				cont ++ ;
			});
		});

		if(produto.qtd_total == 0){
			ng.mensagens('alert-warning','Informe a quantidade desejada','.alert-validades');
			return;
		}
		console.log(ng.indexItensEstoque);
		produto.sub_total = produto.qtd_total * produto.vlr_unitario ;
		if(ng.indexItensEstoque != null){
			produto.valor_desconto = ng.carrinho[ng.indexItensEstoque].valor_desconto ;
			produto.flg_desconto   = ng.carrinho[ng.indexItensEstoque].flg_desconto ;
			produto.vlr_unitario   = ng.carrinho[ng.indexItensEstoque].vlr_unitario ;
			produto.sub_total      = produto.qtd_total * produto.vlr_unitario;
			ng.carrinho[ng.indexItensEstoque] = produto ;
		}else{
			ng.carrinho.push(produto);
			ng.vezes_valor			= produto.qtd_total+' x R$ '+numberFormat(produto.vlr_unitario,2,',','.');
			ng.nome_ultimo_produto  = produto.nome_produto ;

			if(produto.img != null)
				ng.imgProduto = produto.img ;
			else
				ng.imgProduto = 'img/imagem_padrao_produto.gif';
		}
		ng.indexItensEstoque = null ;
		ng.calcTotalCompra();
		$("#list_validades").modal("hide");
		*/
	}

	ng.virificarQuantidade = function(key,index , $event){
		var qtd_max = parseInt(ng.itensEstoque[key][index].qtd_item);
		var qtd     = ng.itensEstoque[key][index].qtd_saida == "" ? 0 : parseInt(ng.itensEstoque[key][index].qtd_saida) ;
		var input = $($event.target);
		if(qtd  > qtd_max){
			ng.itensEstoque[key][index].qtd_saida = "" ;
				input.attr("data-toggle", "tooltip")
				.attr("title", 'A quantidade desejada ('+qtd+') é maior que à em estoque ('+qtd_max+')')
				.attr("data-original-title", 'A quantidade desejada ('+qtd+') é maior que à em estoque');
				input.addClass("has-error")
			input.tooltip("show");
			setTimeout(function(){
				input.tooltip('destroy');
				input.removeClass("has-error");

			},5000);
		}else{
			input.tooltip('destroy');
			input.removeClass("has-error");
		}
	}

	ng.salvar = function(){
		var btn = $('#btn-fazer-compra');
		btn.button('loading');
		var pagamentos   = [] ;

		var Today        = new Date();
		var data_atual   = Today.getDate()+"/"+(Today.getMonth()+1)+"/"+Today.getFullYear();

		$.each(ng.recebidos, function(i,v){
			var parcelas = Number(v.parcelas);

			v.data_pagamento 			= formatDate(data_atual);
			v.id_abertura_caixa 		= ng.caixa_aberto.id ;
			v.id_plano_conta    		= ng.caixa.id_plano_caixa;
			v.id_tipo_movimentacao		= 3;
			v.id_cliente				= ng.cliente.id;
			v.id_forma_pagamento		= v.id_forma_pagamento;
			v.valor_pagamento			= v.valor;
			v.status_pagamento			= 1;
			v.id_empreendimento			= ng.userLogged.id_empreendimento;
			v.id_conta_bancaria       	= ng.caixa.id;
			v.id_cliente_lancamento		= ng.caixa.id_cliente_movimentacao_caixa;

			if(Number(v.id_forma_pagamento) == 3 && ng.troco > 0){
				v.valor_pagamento = v.valor_pagamento - ng.troco ;
			}

			if(Number(v.id_forma_pagamento) == 6 && parcelas > 1){
				var valor_parcelas 	 = v.valor/parcelas ;
				var next_date		 = data_atual;
				for(var count = 0 ; count < parcelas ; count ++){
					var item 			 = angular.copy(v);
					item.valor_pagamento = valor_parcelas ;
					item.data_pagamento  = formatDate(next_date) ;
					next_date			 = somadias(next_date,30);

					pagamentos.push(item);
				}
			}else{
				pagamentos.push(v);
			}
		});

		if(ng.troco > 0){
			$.each(pagamentos,function(key,value){
				if(Number(value.id_forma_pagamento) == 3){
					pagamentos[key].valor = pagamentos[key].valor - ng.troco ;
				}
			});

		}



		var produtos = angular.copy(ng.carrinho);
		var venda    = {
							id_usuario:ng.userLogged.id,
							id_cliente:parseInt(ng.cliente.id),
							venda_confirmada:1,
							id_empreendimento:ng.userLogged.id_empreendimento,
							id_deposito : ng.caixa.id_deposito
						};

		venda.id_cliente = isNaN(venda.id_cliente) ? "" : venda.id_cliente;

		$.each(produtos,function(index,value){
			produtos[index].venda_confirmada 	= 1 ;
			produtos[index].valor_produto 		= value.vlr_unitario;
			produtos[index].qtd           		= value.qtd_total;

			if(value.flg_desconto != null && Number(value.valor_desconto) > 0 && !isNaN(Number(value.valor_desconto))){
				produtos[index].desconto_aplicado	= parseInt(value.flg_desconto) != 1 && isNaN(parseInt(value.flg_desconto)) ? 0 : 1 ;
				produtos[index].valor_desconto      = parseInt(value.flg_desconto) == 1 ? value.valor_desconto/100 : 0 ;
			} else {
				produtos[index].desconto_aplicado	= 0 ;
				produtos[index].valor_desconto      = 0 ;
			}
		});

		aj.post(baseUrlApi()+"venda",{ produtos: produtos, venda: venda, pagamentos: pagamentos })
			.success(function(data, status, headers, config) {

				window.location = "pdv.php";
			})
			.error(function(data, status, headers, config) {
				btn.button('loading');
				ng.out_produtos = data ;
				ng.receber_pagamento = false;
				if(status == 406){
					$.each(data,function(i, value){
						setTimeout(function(){
							$("#"+value+" td").css({background:"#FF9191"});
						}, 300);

						console.log($("#"+value+" td"));
						ng.recebidos = [];
						ng.totalPagamento();
					});
				}
			});

		//console.log(produtos);
		/*
		if(ng.carrinho.length <= 0){
			$dialogs.notify('Atenção!','Nenhum produto foi selecionado');
			return;
		}

		var venda = {
				venda:{
					id_usuario:ng.userLogged.id,id_cliente:parseInt(ng.cliente.id),venda_confirmada:1,
					id_empreendimento:ng.userLogged.id_empreendimento
				},
				itens:[]
			};
		var push_saida = [] ;
		$.each(ng.carrinho,function(i,value){
			var valor_real_item  = value.vlr_unitario;
			var flg_desconto     = parseInt(value.flg_desconto);
			var valor_desconto   = value.valor_desconto / 100;
			var vlr_real         = value.vlr_real;
			var itens_saida      = [];
			var item_venda 		 = {
					id_produto 			:value.id_produto,
					desconto_aplicado	:flg_desconto,
					valor_desconto		:flg_desconto == 1 ? valor_desconto : 0,
					qtd 				:value.qtd_total,
					valor_real_item     :vlr_real
			}
			$.each(value.estoques,function(index,estoque){
				$.each(estoque,function(indexPro,produto){
					var qtd_saida = (produto.qtd_saida != "" && !isNaN(parseInt(produto.qtd_saida))) ? produto.qtd_saida : 0 ;
					if(qtd_saida> 0){
						var item_saida = {
							id_produto 			:parseInt(produto.id_produto),
							id_deposito			:parseInt(produto.id_deposito),
							dta_validade		:produto.dta_validade ,
							valor_desconto		:flg_desconto == 1 ? valor_desconto : 0,
							qtd 				:value.qtd_total,
							qtd_item			:parseInt(produto.qtd_saida),
							valor_real_item 	:valor_real_item
						}
						itens_saida.push(item_saida);
					}
				});
			});
		push_saida.push({itens_venda:item_venda,itens_saida:itens_saida});
		itens_saida = [];
		});
		venda.itens = push_saida;
		aj.post(baseUrlApi()+"venda", venda)
			.success(function(data, status, headers, config) {
				ng.cancelar();

				dlg = $dialogs.confirm('Venda Realizada!!!' ,'<strong>A venda foi realizada com sucesso. Deseja ser efetuar lançamentos de pagamento deste cliente?</strong>');
				dlg.result.then(function(btn){
					window.location.href = baseUrl()+"vendas.php";
				}, undefined);
			})
			.error(function(data, status, headers, config) {

			});
		console.log(venda);
		*/
	}


	ng.aplicarDesconto = function(index,$event,checkebox){
		checkebox = checkebox == null ? true : false ;
		if(checkebox)
		var element = $event.target ;
		else{
	    var element = $($event.target).parent().prev().children().children('input');
		}

		var valor_desconto = ng.carrinho[index].valor_desconto/100 ;
		var vlr_real     = ng.carrinho[index].vlr_real ;
		if($(element).is(':checked')){
			if(checkebox)
			ng.carrinho[index].vlr_unitario =  vlr_real - (vlr_real * valor_desconto) ;
			else{
	            ng.carrinho[index].vlr_unitario =  vlr_real - (vlr_real * valor_desconto) ;
			}
		}else{
			ng.carrinho[index].vlr_unitario =  vlr_real ;
		}
		ng.carrinho[index].sub_total = ng.carrinho[index].qtd_total * ng.carrinho[index].vlr_unitario ;
		ng.calcTotalCompra();
	}

	ng.selCliente = function(){
		var offset = 0  ;
    	var limit  =  10 ;;

			ng.loadCliente(offset,limit);
			$("#list_clientes").modal("show");
	}


	ng.addCliente = function(item){
    	ng.cliente = item;
    	$("#list_clientes").modal("hide");
	}

	ng.loadCliente= function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;
		ng.clientes = [];
		query_string = "?(usu_emp->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+")";
		if(ng.busca.clientes != ""){
			query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+ng.busca.clientes+"%'  AND (per.nome='atacado' OR per.nome='varejo' OR per.nome = 'vendedor Externo')"}});
		}else{
			query_string += "&"+$.param({'(per->nome':{exp:"='atacado' OR per.nome='varejo' OR per.nome = 'vendedor Externo')"}});
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

			});
	}
	ng.out_produtos = [] ;
	ng.delItem = function(index){
		var aux = index ;
		index = ng.out_produtos.indexOf(ng.carrinho[index].id_produto,1);
		if(index < 0)
			ng.out_produtos.splice(index,1);

		ng.carrinho.splice(aux,1);
		ng.calcTotalCompra();
		if(ng.carrinho.length == 0){
			ng.imgProduto  = 'img/imagem_padrao_produto.gif';
			ng.vezes_valor = null ;
			ng.nome_ultimo_produto = null ;
			ng.recebidos = []
			ng.totalPagamento();
			ng.calculaTroco();
		}

	}

	ng.cancelar = function(){
		if(ng.receber_pagamento){
			window.location = "pdv.php";
		}
		ng.carrinho    			= [];
		ng.cliente     			= {};
		ng.vezes_valor 			= null;
		ng.nome_ultimo_produto 	= null;
		ng.imgProduto 			= 'img/imagem_padrao_produto.gif';
		//window.location.href = baseUrl()+"lancamentos.php";
	}

		ng.produtos = [] ;

   	ng.showProdutos = function(){
   		ng.busca.produtos = "" ;
   		ng.loadProdutos(0,10);
   		$('#list_produtos').modal('show');
   	}

   	ng.loadProdutos = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;

    	var query_string = "?group=&emp->id_empreendimento="+ng.userLogged.id_empreendimento;

    	if(ng.busca.produtos != ""){
    		query_string += "&"+$.param({'prd->nome':{exp:"like'%"+ng.busca.produtos+"%' OR fab.nome_fabricante like'%"+ng.busca.produtos+"%'"}});
    	}

		ng.produtos = [];
		aj.get(baseUrlApi()+"estoque/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.produtos        = data.produtos ;
				ng.paginacao.produtos = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.produtos = [];
			});
	}

	ng.addProduto = function(item){
		ng.incluirCarrinho(item);
		ng.calcTotalCompra();
		ng.totalPagamento();
		ng.calculaTroco();
	}

	/* end */

	/* funçãoes revorço */

	ng.modalReforco = function(){
		$("#modal-reforco").modal('show');
	}

	ng.aplicarReforco = function(){
		var btn = $('#btn-aplicar-reforco');
		btn.button('loading');

		var movimentacao = {
								id_abertura_caixa 		: ng.caixa_aberto.id,
								id_plano_conta    		: ng.caixa.id_plano_caixa,
								id_tipo_movimentacao	: 1,
								id_cliente				: ng.caixa.id_cliente_movimentacao_caixa,
								id_fornecedor			: ng.caixa.id_fornecedor_movimentacao_caixa,
								id_forma_pagamento		: 3,
								valor_pagamento			: ng.reforco.valor,
								status_pagamento		: 1,
								id_empreendimento		: ng.userLogged.id_empreendimento,
								id_conta_bancaria       : ng.caixa.id,
								id_conta_bancaria_baixa : ng.reforco.conta_origem,
								dsc_movimentacao		: 'Entrada de caixa p/ cofre'
						   }

		aj.post(baseUrlApi()+"caixa/reforco",movimentacao)
		.success(function(data, status, headers, config) {
			ng.paginacao.produtos = data.paginacao;
			btn.button('reset');
			ng.mensagens('alert-success','Entrada efetuada com sucesso','.alert-reforco');
			ng.loadContas();
			ng.reforco.valor = null ;
			ng.reforco.conta_origem = null;
			$('.has-error').removeClass('has-error');

		})
		.error(function(data, status, headers, config) {
			btn.button('reset');
			if(status == 406){
		 			$.each(data, function(i, item) {
						$("#"+i).addClass("has-error");

						var formControl = $($("#"+i))
							.attr("data-toggle", "tooltip")
							.attr("data-placement", "top")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();
					});
		 		}
		});

	}

	ng.aplicarReforcoEntrada = function(){
		var btn = $('#btn-aplicar-abertura_reforco-entrada');
		btn.button('loading');

		var movimentacao = {
								id_abertura_caixa 		: ng.caixa_aberto.id,
								id_plano_conta    		: ng.caixa.id_plano_caixa,
								id_tipo_movimentacao	: 1,
								id_cliente				: ng.caixa.id_cliente_movimentacao_caixa,
								id_fornecedor			: ng.caixa.id_fornecedor_movimentacao_caixa,
								id_forma_pagamento		: 3,
								valor_pagamento			: ng.abertura_reforco.valor,
								status_pagamento		: 1,
								id_empreendimento		: ng.userLogged.id_empreendimento,
								id_conta_bancaria       : ng.caixa.id,
								id_conta_bancaria_baixa : ng.abertura_reforco.conta_origem,
								dsc_movimentacao		: 'Entrada de fundo de caixa'
						   }

		aj.post(baseUrlApi()+"caixa/reforco",movimentacao)
		.success(function(data, status, headers, config) {
			ng.paginacao.produtos = data.paginacao;
			btn.button('reset');
			ng.mensagens('alert-success','Entrada efetuada com sucesso','.alert-reforco');
			ng.loadContas();
			ng.abertura_reforco.valor = null ;
			ng.abertura_reforco.conta_origem = null;
			$('.has-error').removeClass('has-error');
			window.location = "pdv.php" ;

		})
		.error(function(data, status, headers, config) {
			var element_count = 0;
			for (e in data) { element_count++; }
			if(status == 406 && element_count == 1){
		 			$.each(data, function(i, item) {
						$("#entrada_"+i).addClass("has-error");

						var formControl = $($("#entrada_"+i))
							.attr("data-toggle", "tooltip")
							.attr("data-placement", "top")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();
					});
		 	}else{
		 		window.location = "pdv.php" ;
		 	}
		});

	}

	/*end*/

	/*funcões Sangria*/
	ng.modalSangria = function(){
		$("#modal-sangria").modal('show');
	}

	ng.aplicarSangria = function(){
		var btn = $('#btn-aplicar-sangria');
		btn.button('loading');
		$('.has-error').removeClass('has-error');

		var movimentacao = {
								id_abertura_caixa 			: ng.caixa_aberto.id,
								id_plano_conta    			: ng.caixa.id_plano_caixa,
								id_tipo_movimentacao		: 2,
								id_cliente					: ng.caixa.id_cliente_movimentacao_caixa,
								id_fornecedor				: ng.caixa.id_fornecedor_movimentacao_caixa,
								id_forma_pagamento			: 3,
								valor_pagamento				: ng.sangria.valor,
								status_pagamento			: 1,
								id_empreendimento			: ng.userLogged.id_empreendimento,
								id_conta_bancaria       	: ng.caixa.id,
								id_conta_bancaria_destino   : ng.sangria.conta_destino,
								dsc_movimentacao			: 'Saida de caixa p/ cofre'
						   }
		aj.post(baseUrlApi()+"caixa/sangria",movimentacao)
		.success(function(data, status, headers, config) {
			ng.paginacao.produtos = data.paginacao;
			btn.button('reset');
			ng.mensagens('alert-success','Sangria efetuada com sucesso','.alert-sangria');
			ng.loadContas();
			ng.sangria.valor = null ;
			ng.sangria.conta_destino = null;
			$('.has-error').removeClass('has-error');

		})
		.error(function(data, status, headers, config) {
			btn.button('reset');
			var valor_nao_permitido = false ;
			if(status == 406){
	 			$.each(data, function(i, item) {
	 				if(i != 'valor_nao_permitido'){
						$("#"+i).addClass("has-error");

						var formControl = $($("#"+i))
							.attr("data-toggle", "tooltip")
							.attr("data-placement", "top")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();
					}else{
						valor_nao_permitido = true ;
						var msg = item;
					}
				if(valor_nao_permitido)
					ng.mensagens('alert-danger',msg,'.alert-sangria');
			});

		 	}
		});

	}
	/* end */

	ng.mensagens = function(classe , msg, alertClass){
		alertClass = alertClass != null  ?  alertClass:'.alert-sistema' ;
		$(alertClass).fadeIn().addClass(classe).html(msg);
		setTimeout(function(){
			$(alertClass).fadeOut('slow');
		},5000);
	}

	ng.abrirCaixa = function(){
		var btn = $('#btn-abrir-caixa');
   		btn.button('loading');

   		aj.get(baseUrlApi()+"caixa/abrir/"+ng.caixa.id+"/"+ng.userLogged.id+"/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.abrir_pdv = true;
				ng.caixaAberto();
			})
			.error(function(data, status, headers, config) {
				alert(data);
			});
	}

	ng.getCaixa = function(){
		aj.get(baseUrlApi()+"caixa/"+ng.pth_local)
			.success(function(data, status, headers, config) {
				ng.caixa = data;
				ng.loadContas();
			})
			.error(function(data, status, headers, config) {
				ng.caixa = null ;
			});
	}

	ng.caixaAberto = function(){
		aj.get(baseUrlApi()+"caixa/aberto?pth_local="+ng.pth_local+"&abt->id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.caixa_aberto = data;
			})
			.error(function(data, status, headers, config) {
				ng.caixa_aberto = false;
			});
	}

	ng.loadContas = function() {
		aj.get(baseUrlApi()+"contas_bancarias?cnt->id_tipo_conta[exp]=!=5&id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.contas = data.contas;
			})
			.error(function(data, status, headers, config) {
				ng.contas = [] ;
			});
	}

	ng.receberPagamento = function(){
		ng.receber_pagamento = true ;
	}

	ng.receber = function(){
		if(!ng.vlrTotalCompra > 0){
			$dialogs.notify('Atenção!','<strong>Não há nenhum valor à receber</strong>');
			return;
		}
		$('#modal-receber').modal('show');
	}

	ng.recebidos = [] ;

	ng.totalPagamento = function(){
		var total = 0 ;
		$.each(ng.recebidos,function(i,v){
			total += Number(v.valor);
		});
		console.log(total);
		ng.total_pg = Math.round( total * 100) /100 ;
	}

	ng.calculaTroco = function(){
		var troco = 0 ;
		troco = ng.total_pg - ng.vlrTotalCompra;
		console.log(ng.total_pg,ng.vlrTotalCompra);
		if(troco > 0)
			ng.troco = troco;
		else
			ng.troco = 0 ;
	}

	ng.pagamento = {}

	ng.aplicarRecebimento = function(){
		var restante  = Math.round((ng.vlrTotalCompra - ng.total_pg) * 100) /100 ;
		if((ng.pagamento.valor > restante) && (ng.pagamento.id_forma_pagamento != 3)){
			ng.mensagens('alert-warning','<strong>o valor do pagamento utrapassa o valor restante à receber</strong>','.alert-pagamento');
			return;
		}
		var error = 0 ;
		$('.has-error').tooltip('destroy');
		$('.has-error').removeClass('has-error');
		if(ng.pagamento.id_forma_pagamento ==  undefined || ng.pagamento.id_forma_pagamento ==  ''){
			error ++ ;
			$("#pagamento_forma_pagamento").addClass("has-error");

			var formControl = $("#pagamento_forma_pagamento")
				.attr("data-toggle", "tooltip")
				.attr("data-placement", "bottom")
				.attr("title", 'A escolha da forma de pagamento é obrigatória')
				.attr("data-original-title", 'A escolha da forma de pagamento é obrigatória');
			formControl.tooltip();
		}

		if(ng.pagamento.valor ==  undefined || ng.pagamento.valor ==  ''){
			error ++ ;
			$("#pagamento_valor").addClass("has-error");

			var formControl = $("#pagamento_valor")
				.attr("data-toggle", "tooltip")
				.attr("data-placement", "bottom")
				.attr("title", 'O valor é obrigatório')
				.attr("data-original-title", 'O valor é obrigatório');
			formControl.tooltip();
		}

		if((ng.pagamento.id_maquineta ==  undefined || ng.pagamento.id_maquineta ==  '') && (ng.pagamento.id_forma_pagamento == 5 || ng.pagamento.id_forma_pagamento == 6 ) ){
			error ++ ;
			$("#pagamento_maquineta").addClass("has-error");

			var formControl = $("#pagamento_maquineta")
				.attr("data-toggle", "tooltip")
				.attr("data-placement", "bottom")
				.attr("title", 'O escolha da maquineta é obrigatório')
				.attr("data-original-title", 'O escolha da maquineta é obrigatório');
			formControl.tooltip();
		}


		if(error > 0)
			return;

		if(ng.pagamento.id_forma_pagamento == 6 && (ng.pagamento.parcelas ==  undefined || ng.pagamento.parcelas ==  '') ){
			ng.pagamento.parcelas = 1 ;
		}

		var push = true ;
		if(ng.pagamento.id_forma_pagamento == 3){
			$.each(ng.recebidos,function(x,y){
				if(Number(y.id_forma_pagamento) == 3){
					ng.recebidos[x].valor = ng.recebidos[x].valor + ng.pagamento.valor ;
					push = false ;
				}
			});
		}

		if(push){
			var item = {
							id_forma_pagamento : ng.pagamento.id_forma_pagamento,
							valor              : ng.pagamento.valor,
							id_maquineta	   : ng.pagamento.id_maquineta,
							parcelas           : ng.pagamento.parcelas
					   };
			$.each(ng.formas_pagamento,function(i,v){
				if(v.id == ng.pagamento.id_forma_pagamento){
					item.forma_pagamento = v.nome ;
					return;
				}
			});
			ng.recebidos.push(item);
		}
		ng.totalPagamento();
		ng.calculaTroco();
		ng.pagamento = {} ;
	}

	ng.deleteRecebidos = function(index){
		ng.recebidos.splice(index,1);
		ng.totalPagamento();
		ng.calculaTroco();
	}

	ng.loadMaquinetas = function() {
		ng.maquinetas = [];

		aj.get(baseUrlApi()+"maquinetas")
			.success(function(data, status, headers, config) {
				ng.maquinetas 			= data.maquinetas;
				ng.paginacao.maquinetas = [] ;
			})
			.error(function(data, status, headers, config) {
				ng.paginacao.maquinetas = [] ;
			});
	}

	ng.loadFormasPagamento = function() {
		ng.formas_pagamento = [];
		aj.get(baseUrlApi()+"formas_pagamento")
			.success(function(data, status, headers, config) {
				//ng.formas_pagamento = data;
				var aux = typeof parseJSON(ng.config.formas_pagamento_pdv) == 'object' ?  parseJSON(ng.config.formas_pagamento_pdv) : [] ;
				var count = 0 ;
				var group = 0 ;
				$.each(data,function(i,x){ 
					var exists = false ;
					$.each(aux,function(y,z){ 
						if(x.id == z.id && Number(z.value) == 1){
							exists = true
							return ;
						}
					});
				if(exists){
					if(ng.formas_pagamento[group] == undefined)
						ng.formas_pagamento[group] = [] ;
					x.icon = empty(x.icon) ? 'fa-file-text-o' : x.icon ;
					ng.formas_pagamento[group].push(x);
					if(count == 3) {
						count = 0 ;
						group ++ ;
					}
					else count ++ ;
				}	
				});
				ng.console.log(ng.formas_pagamento);
			});

	}

	ng.modalFechar = function(){

		aj.get(baseUrlApi()+"caixa/lancamentos/formas_pagamento/"+ng.caixa_aberto.id)
			.success(function(data, status, headers, config) {
				ng.lacamentos_formas_pagamento = data;
			})
			.error(function(data, status, headers, config) {

		});

		$('#modal-fechamento').modal('show');
	}

	ng.fechamento = {};
	ng.fecharPDV = function(){
		var btn = $('#btn-fechar-caixa');
   		btn.button('loading');

   		aj.get(baseUrlApi()+"caixa/fechamento/"+ng.caixa_aberto.id+"/"+ng.fechamento.id_conta_bancaria+"")
			.success(function(data, status, headers, config) {
				window.location = "pdv.php" ;
			})
			.error(function(data, status, headers, config) {
				alert('Ocorreu um erro');
		});
	}

	ng.cancelarModal = function(id){
		$('#'+id).modal('hide');
	}

	ng.cancelarPagamento = function(){
		ng.receber_pagamento = false;
		ng.recebidos = [];
		ng.totalPagamento();
		ng.calculaTroco();
	}

	ng.existsCookie = function(){
		 $.ajax({
		 	url: "setup_caixa.php?exists=true",
		 	async: false,
		 	success: function(data) {
		 		ng.exists_cookie = true;
		 	},
		 	error: function(error) {
		 		ng.exists_cookie = false
		 	}
		 });
	}

	ng.change_teste = 'jheizer';
	ng.change_btn  = function() {
			console.log(ng.change_teste);
	}


	ng.loadConfig = function(){
		var error = 0 ;
		aj.get(baseUrlApi()+"configuracoes/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {

				if(data.id_plano_caixa == undefined){
					error++ ;
				}

				if(!ng.exists_cookie){
					error++ ;
				}

				if(data.id_plano_fechamento_caixa == undefined){
					error++;
				}

				if(error > 0)
					ng.caixa_configurado = false ;
				else{
					ng.caixa_configurado = true ;
				}

			})
			.error(function(data, status, headers, config) {
				if(status == 404){
					ng.caixa_configurado = false ;
				}
			});
	}

	// Auto Complete

	var arrayOfStuff = [];
	var arrayOfObjs = [];
	arrayOfStuff.forEach(function(text) {
		arrayOfObjs.push({foo: {bar: text}});
	});

	$scope.searchFunctionStaticData = function (inputText) {
		var arrayOfStuff
		$.ajax({
		 	url: "get_arr.php",
		 	async: false,
		 	success: function(data) {
		 		 arrayOfStuff = data;
		 	},
		 	error: function(error) {
		 		console.log(error);
	 		}
		});

		var deferredFn = $q.defer();
		if (!inputText || inputText.length < 1) {
			deferredFn.resolve(arrayOfStuff);
			return deferredFn.promise;
		}

		var regex = new RegExp(inputText, 'i');
		var results = [];
		arrayOfStuff.forEach(function(text) {
			if (regex.test(text)) {results.push(text);}
		});

		deferredFn.resolve(results);
		return deferredFn.promise;
	}






	var arrayOfStuff = [];
		var arrayOfObjs = [];
		arrayOfStuff.forEach(function(text) {
			arrayOfObjs.push({foo: {bar: text}});
		});

		$scope.searchFunctionStaticData = function (inputText) {
			var arrayOfStuff
			$.ajax({
			 	url: "get_arr.php",
			 	async: false,
			 	success: function(data) {
			 		 arrayOfStuff = data;
			 	},
			 	error: function(error) {
			 		console.log(error);
		 		}
			});

			var deferredFn = $q.defer();
			if (!inputText || inputText.length < 1) {
				deferredFn.resolve(arrayOfStuff);
				return deferredFn.promise;
			}

			var regex = new RegExp(inputText, 'i');
			var results = [];
			arrayOfStuff.forEach(function(text) {
				if (regex.test(text)) {results.push(text);}
			});

			deferredFn.resolve(results);
			return deferredFn.promise;
		}










	ng.existsCookie();
	ng.loadConfig();
	ng.calcTotalCompra();
	ng.caixaAberto();
	ng.getCaixa();
	ng.loadMaquinetas();
});
