app.controller('PDVController', function($scope, $http, $window,$dialogs, UserService,ConfigService) {
	var ng = $scope,
		aj = $http;
	ng.userLogged 	 		= UserService.getUserLogado();
	ng.config  		        = ConfigService.getConfig(ng.userLogged.id_empreendimento);
	ng.busca 		 		= {codigo: "", ok: false,estoqueDep:"",cliente_outo_complete:"",vendedor:''};
	ng.msg 		     		= "";
	ng.itensCarrinho 		= [];
	ng.nome_ultimo_produto 	= null ;
	ng.imgProduto			= 'img/imagem_padrao_produto.gif';
	ng.busca.clientes       = '';
	ng.paginacao            = {produtos:null,estoqueDep:null,vales:null};
	ng.pth_local            = $.cookie('pth_local');
	ng.caixa_aberto         = null ;
	ng.cliente              = {id:""};
	ng.total_pg             = 0 ;
	ng.troco				= 0;
	ng.abrir_pdv			= false;
	ng.receber_pagamento    = false;
	ng.pagamento_fulso      = false;
	ng.cdb_busca            = { status:false, codigo:null } ;
	ng.show_vlr_real          = false ;
	ng.show_aditional_columns = false ;
	ng.orcamento              = false ;
	ng.new_cliente          = {tipo_cadastro: 'pf', id_perfil: '6'} ;
	ng.vendedor             = {};
	ng.modal_senha_vendedor = {id_empreendimento:ng.userLogged.id_empreendimento, id_vendedor:null,nome_vendedor:null,senha_vendedor:null,show:false}
	var params      = getUrlVars();
	ng.emitirNfe = false ;


	ng.reforco             = {} ;
	ng.sangria             = {} ;
	ng.abertura_reforco    = {} ;
	ng.pagamentos          = [];
	ng.caixa_configurado   = true ;

	ng.carrinho = [];
	ng.vlrTotalCompra = 0;
	ng.exists_cookie = null ;

	ng.venda        = null ;
	ng.venda_aberta = false;
	ng.id_venda     = null ;

	ng.cheques					=[{id_banco:null,valor:0,num_conta_corrente:null,num_cheque:null,flg_cheque_predatado:0}];
	ng.boletos					= [{id_banco:null,num_conta_corrente:null,num_cheque:null,status_pagamento:0}];


	ng.formas_pagamento = [
		{nome:"Dinheiro",id:3},
		{nome:"Cheque",id:2},
		{nome:"Boleto Bancário",id:4},
		{nome:"Cartão de Débito",id:5},
		{nome:"Cartão de Crédito",id:6},
		{nome:"Vale Troca",id:7},
		{nome:"Transferência",id:8}
	  ];

	 var controla_error_estoque = 0 ;

	ng.resizeScreen = function() {
		if($("#top-nav").css("display") == "block"){
			$("#map_canvas").css("height", 700);
			$("footer").addClass("hide");
			$("#wrapper").css("min-height", "0px");
			$("#main-container").css("min-height", "0px");
			$("#main-container").css("margin-left", 0).css("padding-top", 0);
			$("#top-nav").toggle();
			$("aside").toggle();
			$("#breadcrumb").toggle();
		}
		else {
			$("#map_canvas").css("height", 600);
			$("footer").removeClass("hide");
			$("#wrapper").css("min-height", "800px");
			$("#main-container").css("min-height", "800px");
			$("#main-container").css("margin-left", 194).css("padding-top", 45);
			$("#top-nav").toggle();
			$("aside").toggle();
			$("#breadcrumb").toggle();
		}
	}

	if(params.id_orcamento == undefined)
		ng.finalizarOrcamento = false ;
	else{
		ng.finalizarOrcamento = true ;
		var id_orcamento = params.id_orcamento;
		if(!isNaN(Number(id_orcamento)) && !empty(id_orcamento)){
			aj.get(baseUrlApi()+"venda/orcamento/"+id_orcamento)
				.success(function(data, status, headers, config) {
					var orcamento = data.orcamento;
					ng.id_orcamento = orcamento.id ;
					if(Number(data.cliente.id) != Number(ng.config.id_cliente_movimentacao_caixa))
						ng.cliente = data.cliente;
					$.each(orcamento.itens,function(i,v){
						v.valor_desconto_real = Number(v.valor_desconto)/100;
						v.flg_desconto        = Number(v.desconto_aplicado);
						v.nome_produto        = v.nome ;
						ng.incluirCarrinho(v);
						/*v.qtd_total = v.qtd;
						v.vlr_unitario    	 = v.valor_real_item;
						v.vlr_real        	 = v.vlr_produto;
						v.valor_desconto     = v.valor_desconto * 100 ;
						v.flg_desconto = v.desconto_aplicado;
						ng.carrinho.push(v);*/
					});
					$.each(ng.carrinho,function(i,item){
						ng.aplicarDesconto(i,null,false,false);
					});
					ng.calcTotalCompra();
					ng.totalPagamento();
					ng.calculaTroco();
					
				})
				.error(function(data, status, headers, config) {
					alert('O ID do orçamento é invalido');
					window.location = "pdv.php";
			});
			}else{
				ng.finalizarOrcamento = false ;
				alert('O ID do orçamento é invalido');
				window.location = "pdv.php";
			}
	}

	ng.total_itens = 0 ;
	ng.calcTotalCompra = function() {
		var total = 0 ;
		var total_itens = 0 ;
		var qtd_total = 0 ;
		$.each(ng.carrinho, function(i, item) {
			total += Number(item.sub_total);
			if(empty(item.qtd_total))
				qtd_total = 1 ;
			else
				qtd_total = item.qtd_total ;
			total_itens += Number(qtd_total);
		});
		ng.vlrTotalCompra = Math.round( total * 100) /100  ;
		ng.total_itens = total_itens ;
	}

	ng.calcSubTotal = function(item){
		var qtd_total = isNaN(Number(item.qtd_total)) || Number(item.qtd_total) == 0  ? 1 : Number(item.qtd_total) ;
		item.sub_total = qtd_total * Number(item.vlr_unitario);
		ng.calcTotalCompra();
	}

	ng.findProductByBarCode = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;
    	var codigo  = ng.busca.codigo ;
		if(ng.busca.codigo != "") {
			ng.msg = "";
			ng.busca.ok = !ng.busca.ok;
			$http.get(baseUrlApi()+"estoque/?group&(prd->codigo_barra[exp]=="+ng.busca.codigo+"%20OR%20prd.id="+ng.busca.codigo+")&emp->id_empreendimento="+ng.userLogged.id_empreendimento+"&prd->flg_excluido=0")
			.success(function(data, status, headers, config) {
				ng.busca.codigo = "" ;
				if(data.produtos.length == 1){
					ng.incluirCarrinho(data.produtos[0]);
				}else if((data.produtos.length > 1)){
					ng.cdb_busca          = { status:true, codigo:codigo } ;
					ng.showProdutos(true);
				}
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
		if(ng.cliente.tp_perc_venda == "perc_venda_atacado"){

			produto.vlr_unitario    	 = produto.vlr_venda_atacado;
			produto.vlr_real        	 = produto.vlr_venda_atacado;
			produto.perc_margem_aplicada = produto.margem_atacado;

		}else if(ng.cliente.tp_perc_venda == "perc_venda_varejo"){

			produto.vlr_unitario		 = produto.vlr_venda_varejo;
			produto.vlr_real       		 = produto.vlr_venda_varejo;
			produto.perc_margem_aplicada = produto.margem_varejo;

		}else if(ng.cliente.tp_perc_venda == "perc_venda_intermediario"){

			produto.vlr_unitario		 = produto.vlr_venda_intermediario;
			produto.vlr_real       		 = produto.vlr_venda_intermediario;
			produto.perc_margem_aplicada = produto.margem_intermediario;

		}else if(ng.cliente.tp_perc_venda == 'vlr_custo'){

			produto.vlr_unitario    	 = produto.vlr_custo_real;
			produto.vlr_real       		 = produto.vlr_custo_real;
			produto.perc_margem_aplicada = 0 ;

		}else{
			produto.vlr_unitario    	 = produto.vlr_venda_varejo;
			produto.vlr_real        	 = produto.vlr_venda_varejo;
			produto.perc_margem_aplicada = produto.margem_varejo;
		}
		produto.valor_desconto = empty(produto.valor_desconto) ?  0 : produto.valor_desconto ; 

		produto.qtd_total = !$.isNumeric(produto.qtd_total) || Number(produto.qtd_total) < 1 ? 1 : Number(produto.qtd_total) ;
		produto.sub_total = produto.qtd_total * produto.vlr_unitario;

		ng.vezes_valor			    = produto.qtd_total+' x R$ '+numberFormat(produto.vlr_unitario,2,',','.');
		ng.nome_ultimo_produto      = produto.nome_produto ;

		if(produto.img != null)
			ng.imgProduto = produto.img ;
		else
			ng.imgProduto = 'img/imagem_padrao_produto.gif';

		ng.carrinho.push(produto) ;

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

	ng.salvarOrcamento = function(){
		ng.orcamento = true ;
		if(ng.finalizarOrcamento) ng.id_venda_ignore = params.id_orcamento ;
		ng.finalizarOrcamento = false
		ng.salvar() ;
	}

	ng.efetivarCompra = function(){
		ng.modalProgressoVenda('show');
		if(ng.orcamento){
			var btn = $('#btn-fazer-orcamento');
		}else{
			var btn = $('#btn-fazer-compra');
		}


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

			if(Number(v.id_forma_pagamento) == 6){

				var valor_parcelas 	 = v.valor/parcelas ;
				var next_date		 = somadias(data_atual,30);
				var itens_prc        = [] ;

				for(var count = 0 ; count < parcelas ; count ++){
					var item 			 = angular.copy(v);
					item.valor_pagamento = valor_parcelas ;
					item.data_pagamento  = formatDate(next_date) ;
					next_date			 = somadias(next_date,30);

					itens_prc.push(item);
				}

				pagamentos.push({id_forma_pagamento : v.id_forma_pagamento ,id_tipo_movimentacao: 3, parcelas:itens_prc});

			}else if(Number(v.id_forma_pagamento) == 2){
				$.each(ng.pg_cheques,function(i_cheque, v_cheque){
					v.id_banco 				= v_cheque.id_banco ;
					v.num_conta_corrente 	= v_cheque.num_conta_corrente ;
					v.num_cheque 			= v_cheque.num_cheque ;
					v.flg_cheque_predatado 	= v_cheque.flg_cheque_predatado ;
					v.data_pagamento 		= v_cheque.data_pagamento ;
					v.valor_pagamento 		= v_cheque.valor_pagamento ;
					v_push = angular.copy(v);
					pagamentos.push(v_push);
				});
			}else if(Number(v.id_forma_pagamento) == 4){
				$.each(ng.pg_boletos,function(i_boleto, v_boleto){
					v.id_banco 				= v_boleto.id_banco ;
					v.data_pagamento 		= v_boleto.data_pagamento ;
					v.valor_pagamento 		= v_boleto.valor_pagamento ;
					v.doc_boleto            = v_boleto.doc_boleto ;
					v.num_boleto            = v_boleto.num_boleto ;
					v.status_pagamento      = v_boleto.status_pagamento ;
					v_push = angular.copy(v);
					pagamentos.push(v_push);
				});
			}else{
				pagamentos.push(v);
			}
		});

		if(ng.troco > 0 && ng.modo_venda == 'pdv'){
			$.each(pagamentos,function(key,value){
				if(Number(value.id_forma_pagamento) == 3){
					pagamentos[key].valor           = pagamentos[key].valor_pagamento - ng.troco ;
					pagamentos[key].valor_pagamento = pagamentos[key].valor_pagamento - ng.troco ;

				}
			});

		}

		if(ng.modo_venda == 'est'){

			var vlr_restante = ng.vlrTotalCompra - ng.total_pg;

			if(vlr_restante > 0){
				item = {
				id_abertura_caixa		:ng.caixa_aberto.id,
				id_plano_conta   		:ng.caixa.id_plano_caixa,
				id_tipo_movimentacao 	: 5,
				valor 					:vlr_restante
				}

			pagamentos.push(item);

			}

		}



		var produtos = angular.copy(ng.carrinho);
		var venda    = {
							id        			: empty(params.id_orcamento) ?  null : params.id_orcamento ,
							id_usuario			: ng.vendedor.id_vendedor,
							id_cliente 			: ng.cliente.id,
							venda_confirmada 	: ng.orcamento ? 0 : 1,
							id_empreendimento	: ng.userLogged.id_empreendimento,
							id_deposito 		: ng.caixa.id_deposito,
							id_status_venda 	: ng.orcamento ? 1 : 4,
							dta_venda           : (empty(params.id_orcamento) ? null : moment().format('YYYY-MM-DD HH:mm:ss') )
						};

		venda.id_cliente = (venda.id_cliente == "" || venda.id_cliente == undefined) ? ng.caixa.id_cliente_movimentacao_caixa : venda.id_cliente;

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

		/*
		* agrupando os produtos de 10 em 10
		*/

		var index_current 	  = 0  ;
		var n_repeat 	  	  = 10 ;
		var repeat_count      = 0  ;
		var produtos_enviar   = [] ;




		$.each(produtos,function(index,obj){
			if(repeat_count >= n_repeat){
					index_current ++ ;
					repeat_count = 0 ;
			}

			if(!(produtos_enviar[index_current] instanceof Array)){
				produtos_enviar[index_current] = [];
			}

			produtos_enviar[index_current].push(obj);
			repeat_count ++ ;
		});

		ng.venda 				  = venda ;
		ng.produtos_enviar 		  = produtos_enviar ;
		ng.pagamentos_enviar      = pagamentos;

		console.log(produtos_enviar);
//		btn.button('reset');
//		return ;


		if(ng.pagamento_fulso){
			ng.id_venda = '';
			$('#text_status_venda').text('Salvando Movimentações');
			ng.gravarMovimentacoes();
		}else{
			controla_error_estoque = 0 ;
			ng.clearOutProdutos();
			ng.out_produtos = [] ;
			ng.out_descontos = [] ;
			if(ng.finalizarOrcamento)
				ng.verificaEstoque(produtos_enviar,0,'efetivar_orcamento');
			else
				ng.verificaEstoque(produtos_enviar,0);
		}
	}

	ng.salvar = function(){
		if(!$.isNumeric(ng.cliente.id) && ng.modo_venda == 'est' && !ng.orcamento ){
				$dialogs.notify('Atenção!','<strong>Para realizar uma veda no modo estoque e necessário selecionar um cliente</strong>');
				return
		  }
		if(ng.orcamento){
			$('#btn-fazer-orcamento').button('loading');
		}else{
			$('#btn-fazer-compra').button('loading');
		}
		aj.get(baseUrlApi()+"caixa/aberto/"+ng.userLogged.id_empreendimento+"/"+ng.pth_local+"/"+ng.userLogged.id)
			.success(function(data, status, headers, config) {
				if(data.open_today){
					ng.efetivarCompra();
				}else{
					$dialogs.notify('Atenção!','<strong>Você está tentando fazer uma operação para um caixa que foi aberto em uma data anterior a hoje, isto  não é possivel. Feche o caixa para que possa continuar.</strong>');
					return;
				}
			})
			.error(function(data, status, headers, config) {
				alert('Caixa fechado');
				window.location = 'pdv.php';
			}); 
	}

	ng.clearOutProdutos = function(){
		$('#tbl_carrinho tr td').css({background:""});
	}
	ng.out_produtos  = [] ;
	ng.out_descontos = [] ;
	ng.verificaEstoque = function(produtos_enviar,init,acao){
		ng.clearOutProdutos();
		var cont_itens  = produtos_enviar.length ;

		init = init == null ? 0 : init ;
		var item_enviar = produtos_enviar[init];


		aj.post(baseUrlApi()+"venda/verificaEstoque",{
														id_empreendimento:ng.userLogged.id_empreendimento,
											        	id_deposito:ng.caixa.id_deposito,
											        	produtos:item_enviar,
											        	venda_confirmada : ng.venda_confirmada,
											        	id_vendedor      : Number(ng.vendedor.id_vendedor),
											        	id_venda_ignore  : (empty(ng.id_venda_ignore) ? null : ng.id_venda_ignore )
	        										 }
	        )
			.success(function(data, status, headers, config) {
				if (init+1 >= cont_itens){
					//console.log(ng.out_produtos);
					if(ng.out_produtos.length > 0 || ng.out_descontos.length > 0){
						ng.modalProgressoVenda('hide');
						if(ng.out_produtos.length > 0)
						$('html,body').animate({scrollTop: 0},'slow');
						if(ng.out_descontos.length > 0){
			         		$dialogs.notify('Atenção!','<strong>'+ng.formatMsgOutDesconto()+'</strong>');
		         		}
						if(ng.orcamento)
							var btn = $('#btn-fazer-orcamento');
						else
							var btn = $('#btn-fazer-compra');

						btn.button('reset');
						return ;
					}else if(acao == null || acao == 'venda'){
						$('#text_status_venda').text('Salvando Venda');
						ng.gravarVenda();
					}else if(acao == 'receber'){
						ng.receber_pagamento = true ;
					}else if(acao == 'efetivar_orcamento'){
						$('#text_status_venda').text('Salvando Venda');
						ng.gravarVenda();
					}
				}else
	           		ng.verificaEstoque(produtos_enviar,init+1,acao);
			})
			.error(function(data, status, headers, config) {
				if(status == 406){
					ng.receber_pagamento = false;
					if(data.out_estoque.length > 0){
						$.each(data.out_estoque,function(i, value){
							ng.out_produtos.push(value);
							/*setTimeout(function(){
								$("#"+value+" td").css({background:"#FF9191"});
							}, 300);*/
							ng.recebidos = [];
							ng.totalPagamento();
						});
					}

					if(data.out_desconto.length > 0){
						$.each(data.out_desconto,function(i, value){
							ng.out_descontos.push(value);
							/*setTimeout(function(){
								$("#"+value+" td").css({background:"#FF9191"});
							}, 300);*/
							ng.recebidos = [];
							ng.totalPagamento();
						});
					}

		         	if (init+1 >= cont_itens){
		         		if(ng.out_produtos.length > 0){
			         		$('html,body').animate({scrollTop: 0},'slow');
		         		}
		         		if(ng.out_descontos.length > 0){
			         		$dialogs.notify('Atenção!','<strong>'+ng.formatMsgOutDesconto()+'</strong>');
		         		}

		         		if(ng.orcamento)
							var btn = $('#btn-fazer-orcamento');
						else
							var btn = $('#btn-fazer-compra');
						btn.button('reset');
						ng.modalProgressoVenda('hide');
					}else{
		           		ng.verificaEstoque(produtos_enviar,init+1,acao);
					}
				}
			});
	};

	ng.formatMsgOutDesconto = function(){
		var ids = [] ;
		var msg_ids = [];
		var msg = '' ;
		$.each(ng.out_descontos,function(i,v){
			if(ids.indexOf(v.vlr_desconto) == -1){
				ids.push(v.vlr_desconto)
				msg_ids.push(v.vlr_desconto*100+"%");
			}
		});

		if(ids.length > 1){
			msg = "Você não tem permissão para dar desconto com os seguintes valores: <b>"+msg_ids.join()+"</b>";
		}else{
			msg = "Você não tem permissão para dar desconto com o valor de <b>"+msg_ids.join()+"</b>";
		}
		return msg;
	}

	ng.verificaOutEstoque = function(item){
		exists = false ;
		$.each(ng.out_produtos,function(i,v){
			if(Number(v[0]) == Number(item.id_produto)){
				exists = true ;
				return ;
			}
		});
		return exists ;
	}

	ng.gravarVenda = function(venda){
		aj.post(baseUrlApi()+"venda/gravarVenda",{venda:ng.venda})
			.success(function(data, status, headers, config) {
				$('#text_status_venda').text('Salvando Itens');
				ng.id_venda = data.id_venda;
				ng.salvarItensVenda(data.id_venda,ng.produtos_enviar,0);
			})
			.error(function(data, status, headers, config) {
				alert('Erro fatal');
			});
	};

	ng.modalProgressoVenda = function(acao){
		if(acao == 'show')
			$('#modal_progresso_venda').modal({ backdrop: 'static',keyboard: false});
		else if (acao == 'hide')
			$('#modal_progresso_venda').modal('hide');
	};

	ng.salvarItensVenda = function(id_venda,produtos_enviar,init){
		var cont_itens  = produtos_enviar.length ;

		if (init >= cont_itens){
			if(ng.orcamento == false){
				$('#text_status_venda').text('Salvando Movimentações');
				ng.gravarMovimentacoes();
				return ;
			}else if(ng.orcamento){
				var btn = $('#btn-fazer-compra');
				btn.button('reset');
				ng.modalProgressoVenda('hide');
				ng.showModalPrint();
				return ;
			}
		}

		init = init == null ? 0 : init ;
		var item_enviar = produtos_enviar[init];

		aj.post(baseUrlApi()+"venda/gravarItensVenda",{	id_venda:id_venda ,
														produtos:item_enviar,
														venda_confirmada 	: ng.orcamento ? 0 : 1,
														id_empreendimento:ng.userLogged.id_empreendimento,
											        	id_deposito:ng.caixa.id_deposito
											          }
			)
			.success(function(data, status, headers, config) {
				ng.salvarItensVenda(id_venda,produtos_enviar,init+1);
			})
			.error(function(data, status, headers, config) {
				alert('Erro fatal');
			});
	};

	ng.efetivarOrcamento = function(id_venda,produtos_enviar,init){
		var cont_itens  = produtos_enviar.length ;

		if (init >= cont_itens){
			if(ng.orcamento == false){
				aj.post(baseUrlApi()+"venda/confirmarOrcamento",{id_venda:id_venda})
				.success(function(data, status, headers, config) {
					$('#text_status_venda').text('Salvando Movimentações');
					ng.gravarMovimentacoes();
				})
				.error(function(data, status, headers, config) {
					alert('Erro fatal ao confirmar o orçamento');
				});
				//$('#text_status_venda').text('Salvando Movimentações');
				//ng.gravarMovimentacoes();
				return ;
			}else if(ng.orcamento){
				var btn = $('#btn-fazer-compra');
				btn.button('reset');
				ng.modalProgressoVenda('hide');
				ng.showModalPrint();
				return ;
			}
		}

		init = init == null ? 0 : init ;
		var item_enviar = produtos_enviar[init];

		aj.post(baseUrlApi()+"venda/efetivarOrcamento",{id_venda:id_venda ,
														produtos:item_enviar,
														id_empreendimento:ng.userLogged.id_empreendimento,
											        	id_deposito:ng.caixa.id_deposito
											          }
			)
			.success(function(data, status, headers, config) {
				ng.efetivarOrcamento(id_venda,produtos_enviar,init+1);
			})
			.error(function(data, status, headers, config) {
				alert('Erro fatal');
			});
	};

	ng.gravarMovimentacoes = function(){
			var id_venda = ng.finalizarOrcamento == true ? ng.id_orcamento : ng.id_venda
			aj.post(baseUrlApi()+"venda/gravarMovimentacoes",{ id_venda:id_venda,
															   pagamentos:ng.pagamentos_enviar,
															   id_cliente:ng.cliente.id,
															   id_empreendimento:ng.userLogged.id_empreendimento
															 }
			).success(function(data, status, headers, config) {
				var btn = $('#btn-fazer-compra');
				
				if(Number(ng.caixa_aberto.flg_imprimir_sat_cfe) == 1){
					ng.showModalSatCfe();
					var post = { 
						id_empreendimento : ng.userLogged.id_empreendimento,
						id_venda          : ng.id_venda,
						cod_operacao      : ng.caixa_aberto.cod_operacao_padrao_sat_cfe
					} ;

					aj.post(baseUrlApi()+"nfe/calcular",post)
					.success(function(data, status, headers, config) {
						data.pdv = {
							cod_pdv      : ng.caixa_aberto.id_caixa,
							cod_operador : ng.caixa_aberto.id_operador,
							nome_operador : ng.caixa_aberto.nome_operador
						}
						data.pagamentos = angular.copy(ng.recebidos) ;
						var dadosWebSocket = {
				 			from 		: ng.caixa_aberto.id_ws_web ,
				 			to  		: ng.caixa_aberto.id_ws_dsk ,
							type 		: 'satcfe_process',
							message 	: JSON.stringify(data)
			 			};
			 			ng.newConnWebSocket(dadosWebSocket);
					})
					.error(function(data, status, headers, config) {
						alert('Erro ao calcular dados do SAT')
					});
			 	}else{
			 		var btn = $('#btn-fazer-compra');
					btn.button('reset');
					ng.loadControleNfe('cfop','lista_operacao');
					ng.modalProgressoVenda('hide');
					ng.vlr_saldo_devedor = data.vlr_saldo_devedor ;
					ng.id_controle_pagamento = data.id_controle_pagamento ;
					ng.showModalPrint();
			 	}
			})
			.error(function(data, status, headers, config) {
				alert('Erro fatal');
			});
	}

	ng.aplicarDesconto = function(index,$event,checkebox,calc){
		if(calc == true){
			var prc_dsc =(ng.carrinho[index].valor_desconto_real * 100)/ng.carrinho[index].vlr_real;
				ng.carrinho[index].valor_desconto = prc_dsc ;
		}else if(checkebox != null){
			ng.carrinho[index].valor_desconto_real = (ng.carrinho[index].vlr_real * (ng.carrinho[index].valor_desconto/100)) ;
		}


		checkebox = checkebox == null ? true : false ;
		/*if(checkebox)
			var element = $event.target ;
		else if(calc != true){
	    	var element = $($event.target).parent().prev().children().children('input');
		}else if(calc == true){
			var element = $($event.target).parent().prev().prev().children().children('input');
		}*/


		var valor_desconto = ng.carrinho[index].valor_desconto/100 ;
		var vlr_real     = ng.carrinho[index].vlr_real ;
		if(Number(ng.carrinho[index].flg_desconto) == 1){
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

	ng.addClienteAutoComplete = function(item){
		ng.addCliente(item);
		ng.clientes_auto_complete_visible = false ;
		ng.busca.cliente_outo_complete = "" ;
	}

	ng.addCliente = function(item){
		ng.cliente = item;
		$("#list_clientes").modal("hide");
		aj.get(baseUrlApi()+"usuarios/saldodevedor/"+ ng.userLogged.id_empreendimento+"?usu->id="+item.id)
			.success(function(data, status, headers, config) {
				ng.cliente.vlr_saldo_devedor = data.vlr_saldo_devedor;
			})
			.error(function(data, status, headers, config) {
				console.log('erro ao consultar saldo do cliente');
			});
	}
	ng.removeCliente = function(){
		ng.cliente = {id:''} ;
	}
	

	ng.loadCliente= function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;
		ng.clientes = null;
		query_string = "?(tue->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+"&usu->id[exp]= NOT IN("+ng.configuracoes.id_cliente_movimentacao_caixa+","+ng.configuracoes.id_usuario_venda_vitrine+"))";

		if(ng.busca.clientes != ""){
			query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+ng.busca.clientes+"%' OR usu.apelido LIKE '%"+ng.busca.clientes+"%')"}});
		}

		aj.get(baseUrlApi()+"usuarios/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.clientes = data.usuarios;
				ng.paginacao_clientes = [];
				$.each(data.paginacao,function(i,item){
					ng.paginacao_clientes.push(item);
				});
			})
			.error(function(data, status, headers, config) {
				ng.clientes = [] ;
			});
	}
	
	ng.delItem = function(index){
		var aux = index ;
		index = ng.out_produtos.indexOf(ng.carrinho[index].id_produto,1);
		//if(index < 0){
			//ng.out_produtos.splice(index,1);
		//}

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
		window.location = "pdv.php";
	}

		ng.produtos = [] ;

   	ng.showProdutos = function(busca_cdb){
   		if(busca_cdb != true)
    		ng.cdb_busca = { status:false, codigo:null } ;

   		ng.busca.produtos = "" ;
   		ng.loadProdutos(0,10);
   		$('#list_produtos').modal('show');
   	}

   	ng.loadProdutos = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;
    	var id_deposito = ng.caixa.id_deposito ;

    	if(ng.cdb_busca.status == false)
    		var query_string = "?group=&emp->id_empreendimento="+ng.userLogged.id_empreendimento+"&prd->flg_excluido=0&qtd->id_deposito="+id_deposito;
    	else{
    		var query_string = "?group=&emp->id_empreendimento="+ng.userLogged.id_empreendimento+"&prd->flg_excluido=0&qtd->id_deposito="+id_deposito+"&prd->codigo_barra="+ng.cdb_busca.codigo;
    	}

    	if(ng.busca.produtos != ""){
    		if(isNaN(Number(ng.busca.produtos)))
    			query_string += "&("+$.param({'prd->nome':{exp:"like'%"+ng.busca.produtos+"%' OR fab.nome_fabricante like'%"+ng.busca.produtos+"%'"}})+")";
    		else
    			query_string += "&("+$.param({'prd->nome':{exp:"like'%"+ng.busca.produtos+"%' OR fab.nome_fabricante like'%"+ng.busca.produtos+"%' OR prd.id = "+ng.busca.produtos+""}})+")";
    	}

		ng.produtos =  null;
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
		ng.incluirCarrinho(angular.copy(item));
		item.qtd_total = "";
		ng.calcTotalCompra();
		ng.totalPagamento();
		ng.calculaTroco();
	}

	ng.addProdutoAutoComplete = function(item){
		ng.addProduto(item);
		ng.produtos_auto_complete_visible = false ;
		ng.busca.produto_outo_complete = "";
	}

	/* end */

	ng.showValeTroca = function(){
   		ng.loadValeTroca(0,10);
   		$('#list_vl_troca').modal('show');
   	}

	ng.vales = null;
	ng.loadValeTroca = function(offset,limit) {
		ng.vales = null;
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;


		ng.vales = [];
		aj.get(baseUrlApi()+"vales/"+offset+"/"+limit+"?td->id_empreendimento="+ng.userLogged.id_empreendimento+"&tv->id_cliente="+ng.cliente.id+"")
			.success(function(data, status, headers, config) {
				ng.vales        = data.vales ;
				ng.paginacao.vales = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.vales = [];
			});
	}

	ng.addValeTroca = function(item){
		ng.pagamento.id_vale_troca = item.id ;
		ng.pagamento.valor         = item.vlr_disponivel;
		$('#list_vl_troca').modal('hide');
	}

	ng.valeTrocaExistis = function(id_vale_troca){
		var exists = false ;
		$.each(ng.recebidos,function(i,v){
			if( Number(v.id_vale_troca) == Number(id_vale_troca) ){
				exists = true ;
				return ;
			}
		});

		return exists ;
	}

	/* funçãoes revorço */

	ng.modalReforco = function(){
		$("#modal-reforco").modal('show');
	}
	var btn_reforco = $('#btn-aplicar-reforco');
	ng.efetivarReforco = function(){
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
								dsc_movimentacao        : 'Reforço de caixa'
						   }

		aj.post(baseUrlApi()+"caixa/reforco",movimentacao)
		.success(function(data, status, headers, config) {
			ng.paginacao.produtos = data.paginacao;
			btn_reforco.button('reset');
			ng.mensagens('alert-success','Entrada efetuada com sucesso','.alert-reforco');
			ng.loadContas();
			ng.reforco.valor = null ;
			ng.reforco.conta_origem = null;
			$('.has-error').removeClass('has-error');

		})
		.error(function(data, status, headers, config) {
			btn_reforco.button('reset');
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

	ng.aplicarReforco = function(){
		btn_reforco.button('loading');
		aj.get(baseUrlApi()+"caixa/aberto/"+ng.userLogged.id_empreendimento+"/"+ng.pth_local+"/"+ng.userLogged.id)
			.success(function(data, status, headers, config) {
				if(data.open_today){
					ng.efetivarReforco() ;
				}else{
					btn_reforco.button('reset');
					$("#modal-reforco").modal('hide');
					$dialogs.notify('Atenção!','<strong>Você está tentando fazer uma operação para um caixa que foi aberto em uma data anterior a hoje, isto  não é possivel. Feche o caixa para que possa continuar.</strong>');
					return;
				}
			})
			.error(function(data, status, headers, config) {
				alert('Caixa fechado');
				window.location = 'pdv.php';
			});
		

	}

	ng.aplicarReforcoEntrada = function(){
		var btn = $('#btn-aplicar-abertura_reforco-entrada');
		btn.button('loading');

		if( ( empty(ng.abertura_reforco.valor) && empty(ng.abertura_reforco.conta_origem) ) ){
			window.location = "pdv.php" ;
			return;
		}


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
								dsc_movimentacao        : 'Entrada de caixa'
						   }

		aj.post(baseUrlApi()+"caixa/reforco",movimentacao)
		.success(function(data, status, headers, config) {
			ng.paginacao.produtos = data.paginacao;
			ng.mensagens('alert-success','Entrada efetuada com sucesso','.alert-reforco');
			ng.loadContas();
			ng.abertura_reforco.valor = null ;
			ng.abertura_reforco.conta_origem = null;
			$('.has-error').removeClass('has-error');
			window.location = "pdv.php" ;

		})
		.error(function(data, status, headers, config) {
			btn.button('reset');
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
	var btn_sangria = $('#btn-aplicar-sangria'); ;
	ng.efetivarSangria = function(){
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
								id_conta_bancaria_destino   : ng.sangria.conta_destino
						   }
		aj.post(baseUrlApi()+"caixa/sangria",movimentacao)
		.success(function(data, status, headers, config) {
			ng.paginacao.produtos = data.paginacao;
			btn_sangria.button('reset');
			ng.mensagens('alert-success','Sangria efetuada com sucesso','.alert-sangria');
			ng.loadContas();
			ng.sangria.valor = null ;
			ng.sangria.conta_destino = null;
			$('.has-error').removeClass('has-error');

		})
		.error(function(data, status, headers, config) {
			btn_sangria.button('reset');
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
	ng.aplicarSangria = function(){
		var error = 0 ;
		btn_sangria.button('loading');
		if(empty(ng.sangria.valor)){
			$("#valor_retirada_sangria").addClass("has-error");

			var formControl = $("#valor_retirada_sangria")
				.attr("data-toggle", "tooltip")
				.attr("data-placement", "top")
				.attr("title", 'Informe o valor da retirada')
				.attr("data-original-title", 'Informe o valor da retirada');
			formControl.tooltip();
			error ++ ;
		}
		if(empty(ng.sangria.conta_destino)){
			$("#conta_destino_sangria").addClass("has-error");

			var formControl = $("#conta_destino_sangria")
				.attr("data-toggle", "tooltip")
				.attr("data-placement", "top")
				.attr("title", 'Informe a conta de destino')
				.attr("data-original-title", 'Informe a conta de destino');
			formControl.tooltip();
			error ++ ;
		}
		if(error > 0){
			btn_sangria.button('reset');
			return false;
		}
		aj.get(baseUrlApi()+"caixa/aberto/"+ng.userLogged.id_empreendimento+"/"+ng.pth_local+"/"+ng.userLogged.id)
			.success(function(data, status, headers, config) {
				if(data.open_today){
					ng.efetivarSangria() ;
				}else{
					btn_sangria.button('reset');
					$("#modal-sangria").modal('hide');
					$dialogs.notify('Atenção!','<strong>Você está tentando fazer uma operação para um caixa que foi aberto em uma data anterior a hoje, isto  não é possivel. Feche o caixa para que possa continuar.</strong>');
					return;
				}
			})
			.error(function(data, status, headers, config) {
				alert('Caixa fechado');
				window.location = 'pdv.php';
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

	ng.operador_other_caixa = false ;
	ng.abrirCaixa = function(){
		var btn = $('#btn-abrir-caixa');
   		btn.button('loading');

   		aj.get(baseUrlApi()+"caixa/abrir/"+ng.caixa.id+"/"+ng.userLogged.id+"/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.abrir_pdv = true;
				ng.caixaAberto();
			})
			.error(function(data, status, headers, config) {
				if(status == 406){
					ng.operador_other_caixa = true ;
					ng.msg_caixa = data.msg ;
					btn.button('reset');
				}else{
					alert('Ocorreu um erro fatal');
					btn.button('reset');
				}
			});
	}

	ng.getCaixa = function(){
		aj.get(baseUrlApi()+"caixa/"+ng.pth_local+"/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.caixa = data;
				ng.loadContas();
			})
			.error(function(data, status, headers, config) {
				ng.caixa = null ;
			});
	}

	ng.caixa_other_operador  = false ;

	ng.caixaAberto = function(){
		aj.get(baseUrlApi()+"caixa/aberto/"+ng.userLogged.id_empreendimento+"/"+ng.pth_local+"/"+ng.userLogged.id)
			.success(function(data, status, headers, config) {
				ng.caixa_aberto = data;
				ng.vendedor.id_vendedor   = data.id_operador;
				ng.vendedor.nome_vendedor = data.nome_operador;
				if(!data.open_today){	
					$dialogs.notify('Atenção!','<strong>Você está utilizando um caixa que foi aberto em uma data anterior a hoje, não será possível realizar nenhuma operação. Feche o caixa para que possa continuar.</strong>');
				}
				ng.newConnWebSocket();
			})
			.error(function(data, status, headers, config) {
				if (status == 406) {
					ng.caixa_other_operador  = true ;
					ng.msg_caixa             = data.msg ;
				};
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
		if(ng.finalizarOrcamento) ng.id_venda_ignore = params.id_orcamento ;
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

		/*
		* agrupando os produtos de 10 em 10
		*/

		var index_current 	  = 0  ;
		var n_repeat 	  	  = 10 ;
		var repeat_count      = 0  ;
		var produtos_enviar   = [] ;


		$.each(produtos,function(index,obj){
			if(repeat_count >= n_repeat){
					index_current ++ ;
					repeat_count = 0 ;
			}

			if(!(produtos_enviar[index_current] instanceof Array)){
				produtos_enviar[index_current] = [];
			}

			produtos_enviar[index_current].push(obj);
			repeat_count ++ ;
		});
		ng.out_produtos = [] ;
		ng.out_descontos = [] ;
		ng.verificaEstoque(produtos_enviar,0,'receber');
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
		ng.total_pg = Math.round( total * 100) /100 ;
	}

	ng.calculaTroco = function(){
		var troco = 0 ;
		troco = ng.total_pg - ng.vlrTotalCompra;
		if(troco > 0)
			ng.troco = troco;
		else
			ng.troco = 0 ;
	}

	ng.pagamento = {};
	ng.pg_cheques = [] ;
	ng.aplicarRecebimento = function(){
		var restante  = Math.round((ng.vlrTotalCompra - ng.total_pg) * 100) /100 ;
		if((ng.pagamento.valor > restante) && (ng.pagamento.id_forma_pagamento != 3) && (ng.modo_venda == 'pdv')){
			ng.mensagens('alert-warning','<strong>o valor do pagamento utrapassa o valor restante à receber</strong>','.alert-pagamento');
			return;
		}

		if(ng.pagamento.id_forma_pagamento == 7 && ng.pagamento.valor > restante && (ng.modo_venda == 'pdv')){ 
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
				.attr("data-original-title", 'A escolha da forma de chequ é obrigatória');
			formControl.tooltip();
		}
		console.log(ng.pagamento);
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

		if(ng.pagamento.id_forma_pagamento == 2){
			$.each(ng.cheques, function(i,v){
				if($('.cheque_data input').eq(i).val() == "" || $('.cheque_data input').eq(i).val() == undefined ){
					$('.cheque_data').eq(i).addClass("has-error");

					var formControl = $('.cheque_data').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'A data do cheque é obrigatória')
						.attr("data-original-title", 'A data do cheque é obrigatória');
					formControl.tooltip();
					error ++ ;
				}

				if(v.valor_pagamento == "" || v.valor_pagamento == 0 || v.valor_pagamento == undefined ){
					$('.cheque_valor').eq(i).addClass("has-error");

					var formControl = $('.cheque_valor').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'O valor do cheque é obrigatório')
						.attr("data-original-title", 'O valor do cheque é obrigatório');
					formControl.tooltip();
					error ++ ;
				}

				if(v.id_banco == "" || v.id_banco == 0 || v.id_banco == undefined ){
					$('.cheque_banco').eq(i).addClass("has-error");

					var formControl = $('.cheque_banco').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'O banco é obrigatório')
						.attr("data-original-title", 'O banco é obrigatório');
					formControl.tooltip();
					error ++ ;
				}

				if(v.num_conta_corrente == "" || v.num_conta_corrente == 0 || v.num_conta_corrente == undefined ){
					$('.cheque_cc').eq(i).addClass("has-error");

					var formControl = $('.cheque_cc').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'O número da C/C é obrigatório')
						.attr("data-original-title", 'O Num. C/C é obrigatório');
					formControl.tooltip();
					error ++ ;
				}

				if(v.num_cheque == "" || v.num_cheque == 0 || v.num_cheque == undefined ){
					$('.cheque_num').eq(i).addClass("has-error");

					var formControl = $('.cheque_num').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'O Núm. Cheque é obrigatório')
						.attr("data-original-title", 'O Núm. Cheque é obrigatório');
					formControl.tooltip();
					error ++ ;
				}
			});

			//ng.calTotalCheque();
		}else if(ng.pagamento.id_forma_pagamento == 4){
			$.each(ng.boletos, function(i,v){
				if($('.boleto_data input').eq(i).val() == "" || $('.boleto_data input').eq(i).val() == undefined ){
					$('.boleto_data').eq(i).addClass("has-error");

					var formControl = $('.boleto_data').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'A data do boleto é obrigatória')
						.attr("data-original-title", 'A data do boleto é obrigatória');
					formControl.tooltip();
					error ++ ;
				}

				if(v.valor_pagamento == "" || v.valor_pagamento == 0 || v.valor_pagamento == undefined ){
					$('.boleto_valor').eq(i).addClass("has-error");

					var formControl = $('.boleto_valor').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'O valor do boleto é obrigatório')
						.attr("data-original-title", 'O valor do boleto é obrigatório');
					formControl.tooltip();
					error ++ ;
				}

				if(v.id_banco == "" || v.id_banco == 0 || v.id_banco == undefined ){
					$('.boleto_banco').eq(i).addClass("has-error");

					var formControl = $('.boleto_banco').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'O banco é obrigatório')
						.attr("data-original-title", 'O banco é obrigatório');
					formControl.tooltip();
					error ++ ;
				}

				if(v.doc_boleto == "" || v.doc_boleto == 0 || v.doc_boleto == undefined ){
					$('.boleto_doc').eq(i).addClass("has-error");

					var formControl = $('.boleto_doc').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'O documento do boleto é obrigatório')
						.attr("data-original-title", 'O documento do boleto é obrigatório');
					formControl.tooltip();
					error ++ ;
				}

				if(v.num_boleto == "" || v.num_boleto == 0 || v.num_boleto == undefined ){
					$('.boleto_num').eq(i).addClass("has-error");

					var formControl = $('.boleto_num').eq(i)
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", 'O Núm. Cheque é obrigatório')
						.attr("data-original-title", 'O Núm. Cheque é obrigatório');
					formControl.tooltip();
					error ++ ;
				}
			});

			//ng.calTotalCheque();
		}else if(ng.pagamento.id_forma_pagamento == 8){
			if(empty(ng.pagamento.id_banco)){
				$("#pagamento_id_banco").addClass("has-error");
				var formControl = $("#pagamento_id_banco")
					.attr("data-toggle", "tooltip")
					.attr("data-placement", "bottom")
					.attr("title", 'Selecione o banco')
					.attr("data-original-title", 'Selecione o banco');
				formControl.tooltip();
			}
			if(empty(ng.pagamento.agencia_transferencia)){
				$("#pagamento_agencia_transferencia").addClass("has-error");
				var formControl = $("#pagamento_agencia_transferencia")
					.attr("data-toggle", "tooltip")
					.attr("data-placement", "bottom")
					.attr("title", 'Informe o número da agência')
					.attr("data-original-title", 'Informe o número da agência');
				formControl.tooltip();
			}
			if(empty(ng.pagamento.conta_transferencia)){
				$("#pagamento_conta_transferencia").addClass("has-error");
				var formControl = $("#pagamento_conta_transferencia")
					.attr("data-toggle", "tooltip")
					.attr("data-placement", "bottom")
					.attr("title", 'Informe o número da conta')
					.attr("data-original-title", 'Informe o número da conta');
				formControl.tooltip();
			}
			if(empty(ng.pagamento.proprietario_conta_transferencia)){
				$("#proprietario_conta_transferencia").addClass("has-error");
				var formControl = $("#proprietario_conta_transferencia")
					.attr("data-toggle", "tooltip")
					.attr("data-placement", "bottom")
					.attr("title", 'Informe o Proprietário da conta')
					.attr("data-original-title", 'Informe o Proprietário da conta');
				formControl.tooltip();
			}
			if(empty(ng.pagamento.id_conta_bancaria)){
				$("#pagamento_id_conta_transferencia_destino").addClass("has-error");
				var formControl = $("#pagamento_id_conta_transferencia_destino")
					.attr("data-toggle", "tooltip")
					.attr("data-placement", "bottom")
					.attr("title", 'Informe a conta de origem')
					.attr("data-original-title", 'Informe a conta de origem');
				formControl.tooltip();
			}
		}

		if(error > 0){
			return;
		}

		if((ng.pagamento.id_forma_pagamento == 6 || ng.pagamento.id_forma_pagamento == 2 || ng.pagamento.id_forma_pagamento == 4 ) && (ng.pagamento.parcelas ==  undefined || ng.pagamento.parcelas ==  '') ){
			ng.pagamento.parcelas = 1 ;
		}

		var push = true ;

		if(ng.pagamento.id_forma_pagamento == 2){


			$.each(ng.recebidos,function(a,b){
				if(Number(b.id_forma_pagamento) == 2){
					ng.recebidos.splice(a,1);
				}
			});


			var valor_parcelas = ng.pagamento.valor / ng.pagamento.parcelas;
			var count = 0 ;
			ng.pg_cheques = [];
			$.each(ng.cheques,function(index,value){
				value.id_forma_pagamento  	= ng.pagamento.id_forma_pagamento;
				value.valor 				= Math.round(valor_parcelas * 100) / 100;
				value.id_maquineta 			= ng.pagamento.id_maquineta;
				value.parcelas 				= 1 ;
				value.data_pagamento		= formatDate($('.chequeData').eq(count).val());
				//value.valor_pagamento		= valor_parcelas;
				ng.pg_cheques.push(value);
				count ++ ;
			});
		}else if(ng.pagamento.id_forma_pagamento == 4){


			$.each(ng.recebidos,function(a,b){
				if(Number(b.id_forma_pagamento) == 4){
					ng.recebidos.splice(a,1);
				}
			});


			var valor_parcelas = ng.pagamento.valor / ng.pagamento.parcelas;
			var count = 0 ;
			ng.pg_boletos = [];
			$.each(ng.boletos,function(index,value){
				value.id_forma_pagamento  	= ng.pagamento.id_forma_pagamento;
				//value.valor 				= Math.round(valor_parcelas * 100) / 100;
				value.id_maquineta 			= ng.pagamento.id_maquineta;
				value.parcelas 				= 1 ;
				value.data_pagamento		= formatDate($('.boletoData').eq(count).val());
			//value.valor_pagamento		= valor_parcelas;
				ng.pg_boletos.push(value);
				count ++ ;
			});
		}

		console.log(ng.pg_boletos);

		if(ng.pagamento.id_forma_pagamento == 3){
			$.each(ng.recebidos,function(x,y){
				if(Number(y.id_forma_pagamento) == 3){
					ng.recebidos[x].valor = ng.recebidos[x].valor + ng.pagamento.valor ;
					push = false ;
				}
			});
		}

		if(push){
			if(ng.pagamento.id_forma_pagamento == 8){
				var item = {
								id_forma_pagamento 				 : ng.pagamento.id_forma_pagamento,
								valor              				 : ng.pagamento.valor,
								id_maquineta	   				 : ng.pagamento.id_maquineta,
								parcelas           				 : ng.pagamento.parcelas,
								id_vale_troca     				 : ng.pagamento.id_vale_troca,
								agencia_transferencia            : ng.pagamento.agencia_transferencia,
								conta_transferencia              : ng.pagamento.conta_transferencia,
								proprietario_conta_transferencia : ng.pagamento.proprietario_conta_transferencia,
								id_conta_transferencia_destino   : ng.pagamento.id_conta_transferencia_destino,
								id_banco                         : ng.pagamento.id_banco
						   };
			}else{
				var item = {
								id_forma_pagamento 				 : ng.pagamento.id_forma_pagamento,
								valor              				 : ng.pagamento.valor,
								id_maquineta	   				 : ng.pagamento.id_maquineta,
								parcelas           				 : ng.pagamento.parcelas,
								id_vale_troca     				 : ng.pagamento.id_vale_troca
						   };
			}

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
		//console.log(ng.recebidos,ng.cheques);
	}

	ng.deleteRecebidos = function(index){
		ng.recebidos.splice(index,1);
		ng.totalPagamento();
		ng.calculaTroco();
	}

	ng.loadMaquinetas = function() {
		ng.maquinetas = [];

		aj.get(baseUrlApi()+"maquinetas/?maq->id_empreendimento="+ng.userLogged.id_empreendimento+"&flg_excluido=0")
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
				ng.formas_pagamento = data;
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
		if(empty(ng.fechamento.id_conta_bancaria)){
			$("#conta_destino").addClass("has-error");
				var formControl = $("#conta_destino")
					.attr("data-toggle", "tooltip")
					.attr("data-placement", "bottom")
					.attr("title", 'Informe a conta de destino')
					.attr("data-original-title", 'Informe a conta de destino');
				formControl.tooltip();
				btn.button('reset');
			return false ;
		}

		aj.get(baseUrlApi()+"caixa/aberto/"+ng.userLogged.id_empreendimento+"/"+ng.pth_local+"/"+ng.userLogged.id)
			.success(function(data, status, headers, config) {
				if(data.open_today)
					var url = baseUrlApi()+"caixa/fechamento/"+ng.caixa_aberto.id+"/"+ng.fechamento.id_conta_bancaria+"";
				else{
					dta_fechamento = data.dta_abertura ;
					dta_fechamento = dta_fechamento.split(' ');
					dta_fechamento = dta_fechamento[0]+' 23:59:59';
					var url = baseUrlApi()+"caixa/fechamento/"+ng.caixa_aberto.id+"/"+ng.fechamento.id_conta_bancaria+"/"+dta_fechamento;
				}

		   		aj.get(url)
					.success(function(data, status, headers, config) {
						window.location = "rel_movimentacao_caixa.php?id="+ng.caixa_aberto.id;
					})
					.error(function(data, status, headers, config) {
						alert('Ocorreu um erro');
				});
			})
			.error(function(data, status, headers, config) {
				alert('Caixa não encontrado');
				window.location = 'pdv.php';
			});
	}

	ng.cancelarModal = function(id){
		$('#'+id).modal('hide');
	}

	ng.cancelarPagamento = function(){
		if(ng.pagamento_fulso == true){
			window.location = "pdv.php";
		}else{
			ng.receber_pagamento = false;
			ng.recebidos = [];
			ng.totalPagamento();
			ng.calculaTroco();
		}
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

	ng.abrirVenda = function(tipo){
		if(tipo == 'pdv'){
			ng.modo_venda = 'pdv' ;
			ng.venda_aberta = true ;

			setTimeout(function(){
				var txtBox = document.getElementById("buscaCodigo");
					txtBox.focus();
			}, 500);
		}else if (tipo == 'est'){
			/*if(ng.cliente.id == undefined || ng.cliente.id == ""){
				$dialogs.notify('Atenção!','<strong>Para realizar uma veda no modo estoque e necessário selecionar um cliente</strong>');
				return
			}*/
			ng.modo_venda = 'est';
			ng.venda_aberta = true ;
			setTimeout(function(){
				var txtBox = document.getElementById("buscaCodigo");
					txtBox.focus();
			}, 500);
		}
	}
	ng.configuracoes = {} ;
	ng.loadConfig = function(){
		var error = 0 ;
		aj.get(baseUrlApi()+"configuracoes/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.configuracoes = data ;
				ng.loadOperacaoCombo();
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
	ng.pg_ant = {};
	ng.modalTraferencia = function(){
		$('#modal-transferencia').modal('show');
		ng.loadEstoqueDep(0,10);
	}

	ng.loadEstoqueDep = function(offset,limit,clear) {
		clear = clear == null ? true : clear ; 
		if(clear === true){
			ng.paginacao_estoqueDep = [];
			ng.estoqueDep = null ;
		}
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;
    	ng.pg_ant    = {offset:offset,limit:limit};
    	query_string = "";
    	if(ng.busca.estoqueDep != ""){
    		query_string += "?"+$.param(
	    									{
	    										'pro->nome':{exp:"like'%"+ng.busca.estoqueDep+"%' OR fab.nome_fabricante like'%"+ng.busca.estoqueDep+"%' OR dep.nme_deposito LIKE '%"+ng.busca.estoqueDep+"%'"}
	    									}
    									);
    	}

		ng.produtos = [];
		aj.get(baseUrlApi()+"estoque/deposito/"+ng.userLogged.id_empreendimento+"/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.estoqueDep        = data.produtos ;
				ng.paginacao_estoqueDep = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.estoqueDep = [];
				ng.paginacao_estoqueDep = [];
			});
	}

	ng.loadDepositos = function(offset,limit) {
	   ng.depositos = [];
		aj.get(baseUrlApi()+"depositos?id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.depositos = data.depositos ;
			})
			.error(function(data, status, headers, config) {
				ng.depositos = [];
			});
	}

	ng.transferenciaEst = function(item,event){
		var btn = $(event.target) ;
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));

		if((item.qtd_transferencia == undefined || item.qtd_transferencia == '') || (item.id_deposito_trasferencia == undefined || item.id_deposito_trasferencia == '')){
			$dialogs.notify('Atenção!','<strong>Informe a quantidade e o deposito para a transferência</strong>');
			return;
		}

		if(Number(item.qtd_transferencia) > item.qtd_item ){
			$dialogs.notify('Atenção!','<strong>A quantidade da transferência utrapassa o que a em estoque</strong>');
			return;
		}

		item.id_empreendimento = ng.userLogged.id_empreendimento ;
		item.id_usuario = ng.userLogged.id ;
		btn.button('loading');
		btn.removeClass('btn-success').addClass('btn-primary');

		aj.post(baseUrlApi()+"estoque/transferir",item)
			.success(function(data, status, headers, config) {
		    	var query_string = "";
		    	if(ng.busca.estoqueDep != ""){
		    		query_string += "?"+$.param(
			    									{
			    										'pro->nome':{exp:"like'%"+ng.busca.estoqueDep+"%' OR fab.nome_fabricante like'%"+ng.busca.estoqueDep+"%' OR dep.nme_deposito LIKE '%"+ng.busca.estoqueDep+"%'"}
			    									}
		    									);
		    	}
				ng.produtos = [];
				aj.get(baseUrlApi()+"estoque/deposito/"+ng.userLogged.id_empreendimento+"/"+ng.pg_ant.offset+"/"+ng.pg_ant.limit+"/"+query_string)
					.success(function(data, status, headers, config) {
						$.gritter.add({title: '<i class="fa fa-check-circle"></i> <b style="font-size:12px">Transferência realizada com sucesso.<b>',text: '',sticky: false,time: '',class_name: 'gritter-success'});
						ng.estoqueDep        = data.produtos ;
						ng.paginacao_estoqueDep = data.paginacao;
					})
					.error(function(data, status, headers, config) {
						btn.button('reset');
						btn.removeClass('btn-primary').addClass('btn-success');
						$.gritter.add({title: '<i class="fa fa-check-circle"></i> <b style="font-size:12px">Transferência realizada com sucesso, Porem ocorreu um erro ao atualizar a lista.<b>',text: '',sticky: false,time: '',class_name: 'gritter-warning'});
						ng.estoqueDep = [];
						ng.paginacao_estoqueDep = [];
					});
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
				btn.removeClass('btn-primary').addClass('btn-success');
				$.gritter.add({title: '<i class="fa fa-check-circle"></i> <b style="font-size:12px">Erro ao realizar transferência<b>',text: '',sticky: false,time: '',class_name: 'gritter-danger'});
			});

	}

	ng.showModalPrint = function(){
		$('#modal-print').modal({
		  backdrop: 'static',
		  keyboard: false
		});
		$('.modal-backdrop.in').css({opacity:1,'background-color':'#C7C7C7'});
	}

	ng.showModalSatCfe = function(){
		$('#modal-sat-cfe').modal({
		  backdrop: 'static',
		  keyboard: false
		});
	}

	ng.printTermic = function() {
		alert("Ao abrir o aplicativo, informe o ID da venda: "+ ng.id_venda);
		ng.cancelar();
	}

	ng.printDiv = function(id,pg) {

		var contentToPrint, printWindow;

		contentToPrint = '<div class="col-sm-12" style="margin-bottom: 30px;">'+$('#topo_print').html()+'</div><br/><br/>';
		contentToPrint = contentToPrint+' '+$('#tbl_print').html() + '' + $('#tbl_print_pg').html() ;
		printWindow = window.open(pg);

	    printWindow.document.write("<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet'>");
		printWindow.document.write("<link href='css/font-awesome.min.css' rel='stylesheet'>");
		printWindow.document.write("<link href='css/pace.css' rel='stylesheet'>");
		printWindow.document.write("<link href='css/endless.min.css' rel='stylesheet'>");
		printWindow.document.write("<link href='css/endless-skin.css' rel='stylesheet'>");

		printWindow.document.write("<style type='text/css' media='print'>@page { size: landscape; padding: 10px; }</style>");
		printWindow.document.write("<style type='text/css'>body{  padding-top: 20px;padding-bottom: 20px; }</style>");


		printWindow.document.write(contentToPrint);

		printWindow.window.print();
		printWindow.document.close();
		printWindow.focus();
	}

	var nParcelasAntCheque = 1 ;
	var nParcelasAntBoleto = 1 ;
	ng.pagamento.parcelas  = 1 ;

	ng.pushCheques = function(){
		if(ng.pagamento.id_forma_pagamento == 2){
			ng.pagamento.parcelas = empty(ng.pagamento.parcelas) ? 1 : ng.pagamento.parcelas ;
			ng.pagamento.parcelas = ng.pagamento.parcelas == "" ?  1 : ng.pagamento.parcelas ;
			if(ng.pagamento.parcelas > nParcelasAntCheque){
				var repeat = parseInt(ng.pagamento.parcelas) - parseInt(nParcelasAntCheque) ;
				while(repeat > 0){
					var item = {id_banco:null,valor_pagamento:0,num_conta_corrente:null,num_cheque:null,flg_cheque_predatado:0};
					ng.cheques.push(item);
					repeat -- ;
				}
			}else if(ng.pagamento.parcelas < nParcelasAntCheque){
				var repeat = parseInt(nParcelasAntCheque) - parseInt(ng.pagamento.parcelas) ;
				while(repeat > 0){
					var index = ng.cheques.length - 1;
					ng.cheques.splice(index,1);
					repeat -- ;
				}
			}
			nParcelasAntCheque = ng.pagamento.parcelas;
			ng.calTotalCheque();
			setTimeout(function(){ ng.loadDatapicker();}, 1000);
		}else if(ng.pagamento.id_forma_pagamento == 4){
			ng.pagamento.parcelas = empty(ng.pagamento.parcelas) ? 1 : ng.pagamento.parcelas ;
			ng.pagamento.parcelas = ng.pagamento.parcelas == "" ?  1 : ng.pagamento.parcelas ;
			if(ng.pagamento.parcelas > nParcelasAntBoleto){
				var repeat = parseInt(ng.pagamento.parcelas) - parseInt(nParcelasAntBoleto) ;
				while(repeat > 0){
					var item = {id_banco:null,valor_pagamento:0,num_conta_corrente:null,num_cheque:null,status_pagamento:0};
					ng.boletos.push(item);
					repeat -- ;
				}
			}else if(ng.pagamento.parcelas < nParcelasAntBoleto){
				var repeat = parseInt(nParcelasAntBoleto) - parseInt(ng.pagamento.parcelas) ;
				while(repeat > 0){
					var index = ng.cheques.length - 1;
					ng.boletos.splice(index,1);
					repeat -- ;
				}
			}
			nParcelasAntBoleto = ng.pagamento.parcelas;
			ng.calTotalBoleto();
			setTimeout(function(){ ng.loadDatapicker();}, 1000);
		}
	}


	ng.loadDatapicker = function(){
		$(".chequeData").datepicker();
		$('.datepicker').on('changeDate', function(ev){$(this).datepicker('hide');});
		$(".dropdown-menu").mouseleave(function(){$('.dropdown-menu').hide();$('input.datepicker').blur()});

		$(".boletoData").datepicker();
		$('.datepicker').on('changeDate', function(ev){$(this).datepicker('hide');});
		$(".dropdown-menu").mouseleave(function(){$('.dropdown-menu').hide();$('input.datepicker').blur()});
	}

	ng.selectChange = function(){
		if(ng.pagamento.id_forma_pagamento == 2){
			ng.pagamento.valor = 0 ;
			ng.pagamento.parcelas = ng.cheques.length  > 0 ? ng.cheques.length : 1 ;
			if(ng.cheques.length > 0)
				ng.calTotalCheque();
		}else if(ng.pagamento.id_forma_pagamento == 6){
			ng.pagamento.parcelas = 1 ;
		}else if(ng.pagamento.id_forma_pagamento == 4){
			ng.pagamento.valor = 0 ;
			ng.pagamento.parcelas = ng.boletos.length  > 0 ? ng.boletos.length : 1 ;
			if(ng.boletos.length > 0)
				ng.calTotalBoleto();
		}	

		ng.loadDatapicker();
	}

	ng.delItemCheque = function($index){
		ng.cheques.splice($index,1);
		ng.pagamento.parcelas = ng.cheques.length ;
		nParcelasAnt  = ng.pagamento.parcelas
	}

	ng.focusData  = function($index){
		if(ng.pagamento.id_forma_pagamento == 2)
			$(".chequeData").eq($index).trigger("focus");
		if(ng.pagamento.id_forma_pagamento == 4)
			$(".boletoData").eq($index).trigger("focus");
	}

	ng.bancos = [] ;
	ng.loadBancos = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;

		ng.bancos = [];

		aj.get(baseUrlApi()+"bancos")
			.success(function(data, status, headers, config) {
				ng.bancos = data.bancos;
			})
			.error(function(data, status, headers, config) {

			});
	}

	ng.calTotalCheque = function(){
		var valor = 0 ;
		$.each(ng.cheques,function(i,v){
			valor += Number(v.valor_pagamento);
		});

		ng.pagamento.valor = valor;

	}

	ng.calTotalBoleto = function(){
		var valor = 0 ;
		$.each(ng.boletos,function(i,v){
			valor += Number(v.valor_pagamento);
		});

		ng.pagamento.valor = valor;

	}

	ng.qtdCheque = function(){
		if(ng.pagamento.id_forma_pagamento == 2){
			ng.pagamento.parcelas = ng.cheques.length  > 0 ? ng.cheques.length : 1 ;
		}

	}

	ng.pagamentoFulso = function (){
		ng.receber_pagamento = true ;
		ng.venda_aberta 	 = true ;
		ng.pagamento_fulso   = true ;
	}

	ng.showVlrReal = function(){
		ng.show_vlr_real = !ng.show_vlr_real ;
	}

	ng.showAditionalColumns = function(){
		ng.show_aditional_columns = !ng.show_aditional_columns ;
	}

	//cadastro rapido de cliente
	ng.loadPerfil = function () {
		ng.perfis = [];

		aj.get(baseUrlApi()+"perfis")
		.success(function(data, status, headers, config) {
			ng.perfis = data;
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.showCadastroRapido = function(){
		$("#modal_cadastro_rapido_cliente").modal({
		  backdrop: 'static',
		  keyboard: false
		});

		$('#modal_cadastro_rapido_cliente').on('shown.bs.modal', function (e) {
			$('#modal_cadastro_rapido_cliente input#nome').focus();
		});
	}

	ng.salvarCliente = function(){
		$(".has-error").removeClass('has-error');
		ng.new_cliente.empreendimentos = [{id:ng.userLogged.id_empreendimento}];
		ng.new_cliente.id_empreendimento = ng.userLogged.id_empreendimento;
		var btn = $('#btn-salvar-cliente');
		btn.button('loading');
		aj.post(baseUrlApi()+"cliente/cadastro/rapido",ng.new_cliente)
		.success(function(data, status, headers, config) {
			btn.button('reset');
			ng.new_cliente          = {tipo_cadastro:'pf'} ;
			ng.mensagens('alert-success','<strong>Cliente cadastrado com sucesso</strong>','.alert-cadastro-rapido');
		})
		.error(function(data, status, headers, config) {
			btn.button('reset');
			if(status == 406) {
		 			var errors = data;

		 			$.each(errors, function(i, item) {
		 				$("#"+i).addClass("has-error");

		 				var formControl = $($("#"+i))
		 					.attr("data-toggle", "tooltip")
		 					.attr("data-placement", "bottom")
		 					.attr("title", item)
		 					.attr("data-original-title", item);
		 				formControl.tooltip();

		 				if(i == "email_marketing" || i == "indicacao"){
		 					$("#"+i).parent().css({'background':'#E9D8D7'});
		 					$("#"+i).parent().attr("data-toggle", "tooltip")
		 					.attr("data-placement", "bottom")
		 					.attr("title", item)
		 					.attr("data-original-title", item);
		 					$("#"+i).parent().tooltip();
		 				}
		 			});
		 	}else{
		 		ng.mensagens('alert-danger','<strong>Ocorreu um erro fatal</strong>','.alert-cadastro-rapido');
		 	}
		});
	}

	//

	ng.produtos_auto_complete = [] ;
	ng.produtos_auto_complete_visible = true ;

	var interval_produto = 0 ;

	ng.outoCompleteProduto = function(busca,$event){
		if($event != null){
			if(($event.type) == 'focus'){
				var div_extender = $('#col-sm-auto-complete-produto'); 
				var div_contrair = $('#col-sm-auto-complete-cliente');
				div_extender.removeClass('col-sm-2').addClass('col-sm-10');
				div_contrair.removeClass('col-sm-10').addClass('col-sm-2');
				ng.esconder_cliente = false ;
			}
		}
		console.log(busca);
		ng.produtos_auto_complete_visible = true ;
        clearInterval(interval_produto);
        if(empty(busca)){
        	ng.produtos_auto_complete = [] ;
        	return ;
        }
        interval_produto = window.setTimeout(function(){  

    		var query_string = "?group=&emp->id_empreendimento="+ng.userLogged.id_empreendimento+"&prd->flg_excluido=0";  	

	    	if(busca != ""){
	    		if(isNaN(Number(busca)))
	    			query_string += "&("+$.param({'prd->nome':{exp:"like'%"+busca+"%' OR fab.nome_fabricante like'%"+busca+"%' OR prd.codigo_barra like '%"+busca+"%' OR prd.peso like '%"+busca+"%' "}})+")";
	    		else
	    			query_string += "&("+$.param({'prd->nome':{exp:"like'%"+busca+"%' OR fab.nome_fabricante like'%"+busca+"%' OR prd.id = "+busca+" OR prd.codigo_barra like '%"+busca+"%' OR prd.peso like '%"+busca+"%' "}})+")";
	    	}

			aj.get(baseUrlApi()+"estoque/"+query_string)
				.success(function(data, status, headers, config) {
					
					ng.produtos_auto_complete = data.produtos;

				})
				.error(function(data, status, headers, config) {
					ng.produtos_auto_complete = [] ;
				});

        }, 500);  	
	}

	ng.selVendedor = function(){
		var offset = 0  ;
    	var limit  =  10 ;;
    	ng.modal_senha_vendedor.show = false ;
    	ng.modal_senha_vendedor.senha_vendedor = null;
		ng.loadVendedor(offset,limit);
		$("#list-vendedor").modal("show");
	}

	ng.loadVendedor= function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;
		ng.clientes = [];
		query_string = "?(tue->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+")";
		query_string += "&"+$.param({'usu->id_perfil':{exp:" IN(1,4,5,8)"}});

		if(ng.busca.vendedor != ""){
			query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+ng.busca.vendedor+"%' OR usu.apelido LIKE '%"+ng.busca.vendedor+"%')"}});
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
	ng.modalSenhaVendedor = function(item){
		ng.modal_senha_vendedor.show = true ;
		ng.modal_senha_vendedor.nome_vendedor = item.nome ;
		ng.modal_senha_vendedor.id_vendedor   = item.id ;
	}

	ng.mudarVendedor =function (){
		$("#senha_vendedor").removeClass("has-error");
		$("#senha_vendedor").tooltip("destroy");
		if(empty(ng.modal_senha_vendedor.senha_vendedor)){
			$("#senha_vendedor").addClass("has-error");
			var formControl = $($("#senha_vendedor"))
				.attr("data-toggle", "tooltip")
				.attr("data-placement", "top")
				.attr("title", 'Informe a senha')
			formControl.tooltip();
			return false ;
		}

		aj.post(baseUrlApi()+"venda/vendedor/change",ng.modal_senha_vendedor)
			.success(function(data, status, headers, config) {
				ng.vendedor.id_vendedor   = ng.modal_senha_vendedor.id_vendedor;
				ng.vendedor.nome_vendedor = ng.modal_senha_vendedor.nome_vendedor;
				$("#list-vendedor").modal("hide");
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.mensagens('alert-danger','Senha incorreta','.alert-vendedor');
			});
	}

	/*--------------------------------------------*/
	ng.esconder_cliente = true ;
	ng.clientes_auto_complete = [] ;
	ng.clientes_auto_complete_visible = true ;

	var interval_cliente = 0 ;
	ng.outoCompleteCliente = function(busca,$event){
		if($event != null){
			if(($event.type) == 'focus'){
				var div_extender = $('#col-sm-auto-complete-cliente'); 
				var div_contrair = $('#col-sm-auto-complete-produto');
				div_extender.removeClass('col-sm-2').addClass('col-sm-10');
				div_contrair.removeClass('col-sm-10').addClass('col-sm-2');
				ng.esconder_cliente = true ;
			}
		}
		ng.clientes_auto_complete_visible = true ;
        clearInterval(interval_cliente);
        if(empty(busca)){
        	ng.clientes_auto_complete = [] ;
        	return ;
        }
        interval_cliente = window.setTimeout(function(){  
	        query_string = "?(tue->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+")";

	        if(!isNaN(Number(busca)) && Number(busca) != 0){
	        	query_string += "&"+$.param({'(cpf':{exp:" LIKE '%"+busca+"%' OR cnpj LIKE '%"+busca+"%')"}});
	        }else if(!empty(busca)){
				query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+busca+"%' OR usu.apelido LIKE '%"+busca+"%')"}});
			}
			aj.get(baseUrlApi()+"usuarios/"+query_string)
				.success(function(data, status, headers, config) {
					
					ng.clientes_auto_complete = data.usuarios;

				})
				.error(function(data, status, headers, config) {
					ng.clientes_auto_complete = [] ;
				});

        }, 500);  	
	}

	ng.closeAutoComplete = function(e){
	    var arr = [
	    			{"class":".content-outo-complete-cliente-pdv","visible":"clientes_auto_complete_visible"},
	    		   	{"class":".content-outo-complete-produto-pdv","visible":"produtos_auto_complete_visible"}
	    		  ];
	    $.each(arr,function(i,v){
	    	if($(""+v.class+"").is(':visible')){
				 var element = $(""+v.class+"").offset();
				 var input_prev = $(""+v.class+"").prev('input');
				 element.right = element.left + $(""+v.class+"").outerWidth();
				 element.bottom = element.top + $(""+v.class+"").outerHeight();

				 if(e.pageY < (element.top - input_prev.outerHeight() )){
				 	ng[""+v.visible+""] = false ;
				 }else if(e.pageY > element.bottom){
				 	ng[""+v.visible+""] = false ;
				 }

				 if(e.pageX < element.left){
				 	ng[""+v.visible+""] = false ;
				 }else if (e.pageX > element.right){
				 	ng[""+v.visible+""] = false ;
				 }
	    	}
	    });
	}
 	
   ng.loadOperacaoCombo = function() {
		ng.lista_operacao  = [{cod_operacao:'',dsc_operacao:'--- Selecione ---'}] ;
		aj.get(baseUrlApi()+"operacao/get/?cod_empreendimento="+ng.userLogged.id_empreendimento+"&flg_excluido=0")
			.success(function(data, status, headers, config) {
				ng.lista_operacao = ng.lista_operacao.concat(data.operacao);
				setTimeout(function(){
					$("select").trigger("chosen:updated");
				},300);
			})
			.error(function(data, status, headers, config) {
					
			});
	}

	ng.loadControleNfe = function(ctr,key) {
		aj.get(baseUrlApi()+"nfe/controles/null/"+ctr)
			.success(function(data, status, headers, config) {
				ng[key] = ng[key].concat(data) ;
				setTimeout(function(){ $("select").trigger("chosen:updated"); }, 300);
			})
			.error(function(data, status, headers, config) {
				
		});
	}

	ng.set = function(key,vlr){
		ng[key] = vlr ;
	}

	// Funções de comunicação com o WebSocket
	ng.newConnWebSocket = function(data){
		ng.conn = new WebSocket('ws://localhost:8080');
		console.log(ng.conn);
		ng.conn.onopen = function(e) {
			console.log('Conexão com WebSocket estabelecida!!!')
			console.log(e);
			if(typeof data == 'object')
	    		ng.sendMessageWebSocket(data);
		};

		ng.conn.onmessage = function(e) {
			var data = JSON.parse(e.data);
			data.message = parseJSON(data.message);
			console.log(data);
			switch(data.type){
				case 'session_id':
					ng.caixa_aberto.id_ws_web = data.to ;
					console.log(ng.caixa_aberto);
					break;
				case 'satcfe_success':
					window.location = "pdv.php";
					break;
				case 'satcfe_error':
					$scope.$apply(function () {
			           ng.erro_sat =  data.message ;
			        });
					$('#modal-erro-sat').modal({ backdrop: 'static',keyboard: false});
					break;
			}			
		};
	}
	ng.sendMessageWebSocket = function(data){
		ng.conn.send(JSON.stringify(data));
	}
	var dadosWebSocket = {

	};
	
	// fim
	//ng.sendMessageWebSocket(ng.caixa_aberto);
	ng.existsCookie();
	ng.loadConfig();
	ng.calcTotalCompra();
	ng.caixaAberto();
	ng.getCaixa();
	ng.loadMaquinetas();
	ng.loadDepositos();
	ng.loadBancos();
	ng.loadPerfil();
	ng.loadContas();
	ng.loadFormasPagamento();

	ng.resizeScreen(); // by default, set fullscreen
	//ng.abrirVenda('pdv'); // by default, set 'Modo Loja' mode
});
