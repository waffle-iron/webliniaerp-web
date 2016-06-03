app.controller('EstoqueController', function($scope, $http, $window, $dialogs,$filter, UserService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 			   = baseUrl();
	ng.userLogged 		   = UserService.getUserLogado();

	ng.nota			       = {vlr_total_imposto : '', xml_nfe: '', flg_cadastra_produto_nao_encontrado: 0};

	ng.entradaEstoque 	   = [];
	ng.ultimasEntradas	   = [];

	ng.editing             = false;
	ng.paginacao           = {} ;
	ng.busca               = {fornecedores:"",pedidos:""} ;
	ng.valor_total_entrada = 0 ;
	ng.qtd_total_entrada   = 0 ;
	ng.produto 				 = {};
	ng.vlr_frete           = ""

	$("#arquivo-nota").change(function() {
		var filename = $(this).val().split('\\').pop();
		$(this).parent().find('span').attr('data-title',filename);
		$(this).parent().find('label').attr('data-title','Trocar XML');
		$(this).parent().find('label').addClass('selected');
	});

	ng.reset = function() {
		ng.nota 				= {vlr_total_imposto : '', xml_nfe: '', flg_cadastra_produto_nao_encontrado: 0};
		ng.valor_total_entrada 	= 0 ;
		ng.qtd_total_entrada 	= 0 ;
		ng.produto 				= {};
		ng.vlr_frete 			= "";
	}

	ng.addItemNF = function(itemNF) {
		ng.entradaEstoque.push(angular.copy({
			id_pedido: 				(ng.entradaEstoque.length > 0) ? ng.entradaEstoque[0].id_pedido : 0,
			id_produto: 			itemNF.id_produto,
			margem_atacado: 		itemNF.margem_atacado,
			margem_intermediario: 	itemNF.margem_intermediario,
			margem_varejo: 			itemNF.margem_varejo,
			nome_fabricante: 		itemNF.nome_fabricante,
			nome_produto: 			itemNF.nome_produto,
			peso: 					itemNF.peso,
			qtd: 					itemNF.qtd,
			validades: 				[{ qtd: itemNF.qtd }],
			custo: 					itemNF.custo,
			imposto: 				itemNF.imposto,
			flg_localizado: 		itemNF.flg_localizado,
		}));
	}

	ng.loadDataFromXML = function() {
		ng.entradaEstoque = [] ; 
		$('#form-xml').ajaxForm({
		 	url: baseUrlApi()+"estoque/importar/nfe?id_empreendimento="+ng.userLogged.id_empreendimento+'&flg_cpne='+ng.nota.flg_cadastra_produto_nao_encontrado,
		 	type: 'POST',
		 	beforeSend: function() {
		 		$("#loadXMLButton").button('loading');
		 		$("#xml_nfe").removeClass("has-error");
		 		$("#xml_nfe").tooltip('destroy');
		 	},
		 	success:function(data){
		 		$("#loadXMLButton").button('reset');

		 		ng.nota.num_nota_fiscal = data.nNF;

		 		if(data.fornecedor.flg_localizado) {
					ng.nota.id_fornecedor           	= data.fornecedor.dados.id;
					ng.nota.nme_fornecedor          	= data.fornecedor.dados.nome_fornecedor;
					ng.nota.flg_fornecedor_localizado 	= data.fornecedor.flg_localizado;
					ng.nota.id_pedido_fornecedor    	= "" ;
				}

				$.each(data.itensBD, function(i, itemNF){
					if(ng.entradaEstoque.length > 0 && itemNF.flg_localizado) {
						var newObj 				= _.findWhere(ng.entradaEstoque, {id_produto: itemNF.id_produto.toString()});
						
						if(newObj != undefined) {
							newObj.validades 		= [{ qtd: itemNF.qtd }];
							newObj.flg_localizado 	= true;
							newObj.qtd 				= itemNF.qtd;
							newObj.custo 			= itemNF.custo;
							newObj.imposto 			= itemNF.imposto;

							ng.entradaEstoque[0] = angular.copy(newObj);
						}
						else
							ng.addItemNF(itemNF);
					}
					else
						ng.addItemNF(itemNF);
				});

				ng.atualizaValores();
				ng.atualizaValorTotal();
				ng.atualizaQtdValidadeItens();

				setTimeout(function() {
					$scope.$apply();
				}, 500);
		 	},
		 	error: function(data, status, headers, config){
		 		$("#loadXMLButton").button('reset');
		 		
		 		if(data.status == 406) {
		 			$("#xml_nfe").addClass("has-error");

					var formControl = $($("#xml_nfe"))
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", data.responseText)
						.attr("data-original-title", data.responseText);
					formControl.tooltip();
		 		}
		 		else {
		 			defaulErrorHandler(data, status, headers, config);
		 		}
		 	}
		}).submit();
	}

	ng.salvar = function(){
		var btn = $('#btn-salvar-entrada');
		btn.button('loading');
		if(!ng.entradaEstoque.length > 0){
			$dialogs.notify('Atenção!','Nenhum pedido foi adicionado para dar entrada');
			return false;
		}

		$.each(ng.entradaEstoque, function(i, item) {
			if(!item.flg_localizado) {
				$dialogs.notify('Atenção!','Alguns produtos não foram localizados!<br/>Não será possível realizar a entrada da NF.');
				return false;
			}
		});

		if(!ng.validarCusto()){
			$dialogs.notify('Atenção!','Alguns produtos estão sem valor de custo!<br/>Não será possível realizar a entrada da NF.');
			return false;
		}

		var validar_validade = true ;
		$.each(ng.entradaEstoque,function(i,item){
			if(item.validades == undefined){
				validar_validade = false;
				return;
			}
		});

		if(!validar_validade){
			btn.button('reset');
			$dialogs.notify('Atenção!','A quantidade e data de validade de nenhum produto pode ser fazio');
			return;
		}

		var entradaEstoque = [] ;
		$.each(ng.entradaEstoque,function(i,item){
			$.each(item.validades,function(x,validade){
				var item_atual = {} ;
				$.each(item,function(a,val){
					if(a != '$$hashKey' && a != 'validades')
						item_atual[a] = val;
				});
				item_atual.desconto = item_atual.desconto / 100 ;
				item_atual.imposto = item_atual.imposto / 100 ;

				if(validade.validade == undefined)
					validade.validade = "122009";

				var ano       = parseInt(validade.validade.substring(2,6));
				var mes       = parseInt(validade.validade.substring(0,2)) -1;
				var objDate   = new Date(ano, mes , 1);

				item_atual.dta_validade = ano+'-'+(mes+1)+'-'+ultimoDiaDoMes(objDate);
				item_atual.qtd          = validade.qtd;
				entradaEstoque.push(item_atual);
			});
		});

		ng.nota.id_empreendimento = ng.userLogged.id_empreendimento;
		ng.nota.itens             = entradaEstoque;
		ng.nota.dta_entrada       = formatDate($("#pagamentoData").val());
		ng.nota.id_usuario		  = ng.userLogged.id ; 

		$($(".has-error").find(".form-control")).tooltip('destroy');
		$($(".has-error").find("button")).tooltip('destroy');
		$(".has-error").removeClass("has-error");

		var postData = angular.copy( ng.nota );
		postData.vlr_total_imposto 		= parseFloat((postData.vlr_total_imposto != undefined) ? postData.vlr_total_imposto.replace(",", ".") : 0);
		postData.vlr_total_nota_fiscal 	= parseFloat((postData.vlr_total_nota_fiscal != undefined) ? postData.vlr_total_nota_fiscal.replace(",", ".") : 0);
		postData.vlr_frete 				= parseFloat((postData.vlr_frete != undefined) ? postData.vlr_frete.replace(",", ".") : 0);

		$.each(ng.nota,function(i,x){
			ng.nota[i].imposto = $.isNumeric(x.imposto) ? Number(x.imposto)/100 : 0 ;
		});	

		$http.post(baseUrlApi()+'estoque/entrada',ng.nota)
			.success(function(data, status, headers, config) {
				btn.button('reset');
				ng.reset();
				ng.showBoxNovo();
				$('html,body').animate({scrollTop: 0},'slow');
				ng.mensagens('alert-success',
							'<strong>Entrada cadastrada com sucesso</strong>',
							'.alert-entrada-lista');
				ng.loadEntradas(0,20);
				// ng.showModalPrecos(); // Inativado temporariamente
			})
			.error(function(data, status) {
				btn.button('reset');
				if(status == 406) {
					$('html,body').animate({scrollTop: 0},'slow');
					$.each(data, function(i, item) {
						$("#"+i).addClass("has-error");

						var formControl = $($("#"+i))
							.attr("data-toggle", "tooltip")
							.attr("data-placement", "bottom")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();
					});
				}else{
					alert('Desculpe, ocorreu um erro inesperado!');
				}
			});

			ng.precoProduto = [];
		}

		ng.showModalPrecos = function(){
			ng.precoProduto = [];

				$.each(ng.entradaEstoque, function(x, itemEntrada) {
					itemEntrada.margem_intermediario = parseFloat(itemEntrada.margem_intermediario) * 100;
					itemEntrada.margem_atacado       = parseFloat(itemEntrada.margem_atacado) * 100;
					itemEntrada.margem_varejo        = parseFloat(itemEntrada.margem_varejo) * 100;

					if(ng.precoProduto != null && ng.precoProduto.length > 0) {
						var b = true;

						$.each(ng.precoProduto, function(y, itemPreco){
							if(itemEntrada.id_produto === itemPreco.id_produto)
								b = false;
						});

						if(b)
							ng.precoProduto.push(itemEntrada);
					}
					else
						ng.precoProduto.push(itemEntrada);
				});

			$('#list_precos').modal('show');return;
		}

		ng.showDetalhes = function(item){
			ng.current_detalhes = item ;
			ng.loadItensEntrada(item.id,0,10);
			$('#list_detalhes').modal('show');
		}

		ng.loadItensEntrada = function(id_estoque_entrada,offset,limit,divLoadingAjax) {
			offset = offset == null ? 0  : offset;
			limit  = limit  == null ? 20 : limit;

			if(divLoadingAjax == null) ng.detalhes = null;
			else
				$(divLoadingAjax).show();


			aj.get(baseUrlApi()+"estoque/entradas/itens/"+offset+"/"+limit+"?id_estoque_entrada="+id_estoque_entrada)
				.success(function(data, status, headers, config) {
					ng.detalhes    = data.itens ;
					$(divLoadingAjax).hide();
					$.each(data.paginacao,function(i,x){
						data.paginacao[i].id_estoque_entrada = id_estoque_entrada ;
					});
					ng.paginacao.detalhes            = data.paginacao;
				})
				.error(function(data, status, headers, config) {
					ng.detalhes = [];
				});
		 }

		ng.salvarPrecoProduto = function(item){
			var itens = [] ;
			$.each(ng.precoProduto, function(x, itemEntrada) {
				itens = [] ;
				itemEntrada = angular.copy(itemEntrada);
				itemEntrada.margem_intermediario        =  parseFloat(itemEntrada.margem_intermediario) / 100;
				itemEntrada.margem_atacado              =  parseFloat(itemEntrada.margem_atacado)       / 100;
				itemEntrada.margem_varejo               =  parseFloat(itemEntrada.margem_varejo)        / 100;
				itemEntrada.id_empreendimento           =  ng.userLogged.id_empreendimento ;

				itens.push(itemEntrada);
			});

			$($(".has-error")).tooltip('destroy');
			$(".has-error").removeClass("has-error");

			$http.post(baseUrlApi()+'produtos/preco',{precos:itens})
			.success(function(data, status, headers, config) {
				$('#list_precos').modal('hide');
				ng.mensagens('alert-success','<strong>Preços do produto atualizados com sucesso</strong>');
				ng.precoProduto = [] ;
			})
			.error(function(data, status) {
				if(status == 406) {

					$.each(data, function(i, item) {
						$("#"+i).addClass("has-error");
						var formControl = $($("#"+i))
							.attr("data-toggle", "tooltip")
							.attr("data-placement", "bottom")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();
					});
				}else{
					alert('Desculpe, ocorreu um erro inesperado!');
				}
			});
		}

	/* inicio - Ações de Fornecedores */

	ng.fornecedores = [] ;

	ng.showFornecedores = function(){
		$('#list_fornecedores').modal('show');
		ng.busca.fornecedores = "";
		ng.loadFornecedores(0,10);
	}

	ng.loadFornecedores = function(offset,limit) {
		offset = offset == null ? 0  : offset;
		limit  = limit  == null ? 20 : limit;

		var query_string = "?frn->id_empreendimento="+ng.userLogged.id_empreendimento;
		if(ng.busca.fornecedores != ""){
			query_string += "&"+$.param({nome_fornecedor:{exp:"like'%"+ng.busca.fornecedores+"%'"}})+"";
		}

		ng.fornecedores = [];
		aj.get(baseUrlApi()+"fornecedores/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.fornecedores        = data.fornecedores ;
				ng.paginacao.fornecedores = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.fornecedores = [];
			});
	}

	ng.addFornecedor = function(item){
		ng.nota.nme_fornecedor          = item.nome_fornecedor;
		ng.nota.id_fornecedor           = item.id;
		ng.nota.id_pedido_fornecedor    = "" ;
		ng.valor_total_entrada          = 0 ;
		ng.qtd_total_entrada            = 0 ;
		$('#list_fornecedores').modal('hide');
	}


		/* end */

		/* inicio - Ações de pedidos */

		ng.pedidos = [] ;

		ng.showPedidos = function(){
			if(ng.nota.id_fornecedor == null){
				$dialogs.notify('Atenção!','Nenhum fornecedor foi adicionado');
				return ;
			}

			ng.busca.pedidos = "" ;
			$('#list_pedidos').modal('show');
			ng.loadPedidos(0,10);
		}

	ng.loadPedidos = function(offset,limit) {
		offset = offset == null ? 0  : offset;
		limit  = limit  == null ? 20 : limit;

		var query_string = "?entrada->id_pedido_fornecedor[exp]=IS NULL&"+$.param({'frn->id':ng.nota.id_fornecedor});
		if(ng.busca.pedidos != ""){
			query_string += "&"+$.param({'pedido->id':ng.busca.pedidos});
		}

		ng.pedidos = [];
		aj.get(baseUrlApi()+"pedidos/"+offset+"/"+limit+"/"+query_string+"&tpf->id_empreendimento="+ng.userLogged.id_empreendimento+"&tpf->flg_pedido_real=1")
			.success(function(data, status, headers, config) {
				ng.pedidos        = data.pedidos ;
				ng.paginacao.pedidos = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.pedidos          = [];
			})                                    ;
	}

	ng.addPedido = function(item){
		ng.nota.id_pedido_fornecedor = item.id;
		ng.loadItensPedido(item.id);
		$('#list_pedidos').modal('hide');
	}

	ng.validarDataValidade = function(mes_ano,index) {
		var mes = parseInt(mes_ano.substr(0,2),10);
		var ano = parseInt(mes_ano.substr(2,4),10);

		var valid = true;

		var dtaAtual = new Date();
		var mesAtual = dtaAtual.getMonth() + 1;
		var anoAtual = dtaAtual.getFullYear();

		if(mes > 12)
			valid = false;

		if(ano < anoAtual)
			valid = false;

		if(ano < 1900 || ano > 2100)
			valid = false;

		if(!valid) {
			ng.mensagens('alert-danger','<strong>A data informada é inválida</strong>','.alert-itens');
			ng.itemValidade.validade = "";
		}
	}

	ng.showValidades = function(item) {
		ng.produto = item;

		if(ng.produto.validades == null || typeof(ng.produto.validades) == "undefined")
			ng.produto.validades = [];

		$("#list_validades").modal('show');
	}

	ng.addValidadeItem = function() {
		ng.produto.validades.push(ng.itemValidade);
		ng.itemValidade = {};
		ng.atualizaQtdValidadeItens();
	}

	ng.atualizaQtdValidadeItens = function() {
		var qtdTotal = 0;

		$.each(ng.produto.validades, function(i, item) {
			qtdTotal += parseInt(item.qtd,10);
		});

		ng.produto.qtd = qtdTotal;
		ng.atualizaValores();
	}

	ng.deleteValidadeItem = function(index) {
		ng.produto.validades.splice(index,1);
		ng.atualizaQtdValidadeItens();
	}

	ng.loadItensPedido = function(id_pedido) {
		if(ng.entradaEstoque == null || ng.entradaEstoque == "undefined")
			ng.entradaEstoque = [];

		aj.get(baseUrlApi()+"pedido_itens/"+id_pedido)
			.success(function(data, status, headers, config) {
				$.each(data.itens,function(i,item){
					item.qtd 	  = 0;
					item.custo    = null;
					item.imposto  = null;
					item.desconto = null;
					item.total    = 0;

					if(ng.entradaEstoque.length > 0){
						var objNF = _.findWhere(ng.entradaEstoque, {id_produto: parseInt(item.id_produto, 10)});
						if(objNF == undefined)
							ng.entradaEstoque.push(item);
					}
					else
						ng.entradaEstoque.push(item);
				});

				ng.atualizaValores();
			})
			.error(function(data, status, headers, config) {
				ng.entradaEstoque = [];
			});
	}

		/* end */

		/* inicio - Ações de depositos */

		ng.depositos = [] ;

		ng.showDepositos = function(){
			ng.busca.depositos = "" ;
			ng.loadDepositos(0,10);
			$('#list_depositos').modal('show');
		}

		ng.loadDepositos = function(offset,limit) {
		offset = offset == null ? 0  : offset;
			limit  = limit  == null ? 20 : limit;

			var query_string = "?id_empreendimento="+ng.userLogged.id_empreendimento;

			if(ng.busca.depositos != ""){
				query_string += "&"+$.param({'nme_deposito':{exp:"like'%"+ng.busca.depositos+"%'"}});
			}



		ng.depositos = [];
		aj.get(baseUrlApi()+"depositos/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.depositos        = data.depositos ;
				ng.paginacao.depositos = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.depositos = [];
			});
	}

	ng.addDeposito = function(item){
		ng.nota.id_deposito     = item.id;
		ng.nota.nme_deposito    = item.nme_deposito;
		$('#list_depositos').modal('hide');
	}

		/* end */

		/* inicio - Ações dos itens dos entrada */

		ng.deleteItem = function(item){
			if(item == null)
				ng.entradaEstoque = [];

			ng.entradaEstoque = _.without(ng.entradaEstoque, item);

			/*$.each(ng.entradaEstoque, function(x, currentItem){
				if(currentItem.id === item.id && currentItem.validade === item.validade)
					ng.entradaEstoque.splice(x,1);
			});*/

			if(!ng.entradaEstoque.length > 0)
				ng.nota.id_pedido_fornecedor= "";
			ng.atualizaValores();
		}

		ng.atualizaValorTotal = function() {
			 var vlr_frete = (ng.nota.vlr_frete != null && ng.nota.vlr_frete != "") ? parseFloat(ng.nota.vlr_frete) : "";
			 var vlr_frete = parseFloat(ng.nota.vlr_frete);

			if(isNaN(vlr_frete))
				vlr_frete = 0;

			ng.nota.vlr_total_nota_fiscal = vlr_frete + ng.valor_total_entrada;
			ng.nota.vlr_total_nota_fiscal = numberFormat(ng.nota.vlr_total_nota_fiscal, 2, ',', '.');
		}

		ng.atualizaValores = function(){
			ng.nota.vlr_total_imposto = 0 ;
			ng.valor_total_entrada = 0 ;
			ng.qtd_total_entrada   = 0 ;

			$.each(ng.entradaEstoque, function(i,item){
				var qtd          = item.qtd      == null || item.qtd      == "" ? 0 : parseInt(item.qtd);
				var custo        = item.custo    == null || item.custo    == "" ? 0 : parseFloat(item.custo);
				var por_desconto = item.desconto == null || item.desconto == "" ? 0 : parseFloat(item.desconto);
				var por_imposto  = item.imposto  == null || item.imposto  == "" ? 0 : parseFloat(item.imposto);

				
				var vl_imposto   = custo * (por_imposto  / 100) ;
				var vl_desconto  = (custo+vl_imposto) * (por_desconto / 100) ;

				var vl_total     = qtd * ((custo + vl_imposto) - vl_desconto);

				ng.nota.vlr_total_imposto += vl_imposto;
				ng.valor_total_entrada    += vl_total;
				ng.qtd_total_entrada      += qtd ;
				ng.entradaEstoque[i].total = vl_total ;

				ng.atualizaValorTotal();
			});

			ng.nota.vlr_total_imposto = numberFormat(ng.nota.vlr_total_imposto, 2, ',', '.');
		}

		ng.validarCusto = function(){
			var validade = true;
			$.each(ng.entradaEstoque,function(i,item){
				if(item.custo == null || item.custo == ""){
					validade = false;
				}
			});

			return validade
		}

		ng.loadEntradas = function(offset,limit){
			offset = offset == null ? 0  : offset;
			limit  = limit  == null ? 20 : limit;

			query_string = "";
			ng.ultimasEntradas = [] ;

			aj.get(baseUrlApi()+"estoque/entradas/"+ng.userLogged.id_empreendimento+"/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.ultimasEntradas       = data.entradas ;
				ng.paginacao.entradas    = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.depositos = [];
		});
		}

		/* end */

		/* inicio - funções gerais */
		ng.clearForm = function(){
			ng.entradaEstoque = [] ;
		$('#pagamentoData').val('');
		$.each(ng.nota,function(i,item){
				ng.nota[i] = "";
		});
		}

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
					ng.clearForm();
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

	function defaulErrorHandler(data, status, headers, config) {
		ng.mensagens('alert-danger','<strong>'+ data +'</strong>');
	}

	function formatDate(dta) {
		var arr_date = dta.split('/');
		var date= arr_date[2]+'-'+arr_date[1]+'-'+arr_date[0];

		return date;
	}

	ng.Keyup = function(event,valor){
		var val = String.fromCharCode(event.keyCode)

		if(event.keyCode >= 48 && event.keyCode <= 57 ){
			valor = valor.substring(0,valor.length-1) ;
		}

	}



	ng.loadEntradas(0,10);

});

