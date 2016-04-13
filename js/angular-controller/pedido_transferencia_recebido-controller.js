app.controller('PedidoTransferenciaRecebidoController', function($scope, $http, $window, $dialogs, UserService){
	var ng = $scope
		aj = $http;

	ng.baseUrl 		= baseUrl();
	ng.userLogged 	= UserService.getUserLogado();
	ng.busca 		= {empreendimento:'',produto:'',depositos:''} ;
	ng.paginacao    = {};
    ng.lista_emp    = [];
    var transferenciaTO = {
    	id : null,
		id_empreendimento_pedido : null ,
		id_empreendimento_transferencia : ng.userLogged.id_empreendimento,
		id_usuario_pedido : null,
		id_usuario_transferencia : ng.userLogged.id,
		dta_pedido : null,
		dta_transferencia : null,
		id_status_transferencia : 2,
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
		produto.qtd_pedida = empty(produto.qtd_pedida) ? 0 : produto.qtd_pedida  ;
		produto.add 	   = item.add == 0 ? 0 : 1 ;
		ng.transferencia.produtos.push(produto);
		item.qtd_pedida = null ;
	}

	ng.listaTransferencias = {} ;
	ng.loadtransferencias = function(offset, limit){
		ng.listaTransferencias.transferencias = null 
		aj.get(baseUrlApi()+"transferencias/estoque/"+offset+"/"+limit+"?cplSql=id_empreendimento_transferencia="+ng.userLogged.id_empreendimento+" ORDER BY id  DESC")
		.success(function(data, status, headers, config) {
			ng.listaTransferencias.transferencias = data.transferencias ;
			ng.listaTransferencias.paginacao = data.paginacao ;
		})
		.error(function(data, status, headers, config) {
 			ng.listaTransferencias.transferencias = [] ;
			ng.listaTransferencias.paginacao = [] ;
		});
	}
	ng.view = {};
	ng.viewTransferencia = function(id){
		ng.loadTransferencia(id);
		$('#modal-detalhes-transferencia').modal('show');
	}
	ng.loadTransferencia = function(id){
		ng.view.transferencia  = null 
		aj.get(baseUrlApi()+"transferencia/estoque/"+id)
		.success(function(data, status, headers, config) {
			ng.view.transferencia = data ;
		})
		.error(function(data, status, headers, config) {
 			ng.view.transferencia = []
		});
	}

	ng.selDeposito = function(){
		$('#list_depositos').modal('show');
		ng.loadDepositos(0,10);
	}
	ng.addDeposito = function(item){
		ng.nome_deposito_principal = item.nme_deposito;
		ng.id_deposito_principal = item.id;
		$('#list_depositos').modal('hide');
		$.each(ng.transferencia.produtos,function(i,x){
			ng.transferencia.produtos[i].id_deposito_saida = item.id;
		});
		ng.verificarEstoque();
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


	ng.loadDepositosSelect = function() {
		ng.depositos_chosen = [];
		var query_string = "?id_empreendimento="+ng.userLogged.id_empreendimento ;
    	aj.get(baseUrlApi()+"depositos/"+query_string)
		.success(function(data, status, headers, config) {
			ng.depositos_chosen = ng.depositos_chosen.concat(data.depositos);	
			setTimeout(function(){$("select").trigger("chosen:updated");},300);
		})
		.error(function(data, status, headers, config) {
			ng.depositos = [] ;	
		});
	}

	ng.verificarEstoque = function(){
		$('.tr-out-estoque').find('input').tooltip('destroy');
		$('.tr-out-estoque').removeClass('tr-out-estoque');
		$('.has-error').find('input').tooltip('destroy');

		$('.has-error').find('.chosen-single').attr('style','');
		$('.has-error').find('.chosen-single').find('span').attr('style','');
		$('.has-error').find('.chosen-single').tooltip('destroy');

		$('.has-error').removeClass('has-error');

		var post = angular.copy(ng.transferencia);
		var produtos = angular.copy(ng.transferencia.produtos);
		post.produtos = [];
		$.each(produtos,function(i,v){
			v.qtd_transferida = v.qtd_pedida ;
			post.produtos.push(v);
		});

		aj.post(baseUrlApi()+"estoque/pedido/transferencia/verificar_estoque/",post)
		.success(function(data, status, headers, config) {
			
		})
		.error(function(data, status, headers, config) {
			if(status == 406){
				$.each(data.out_estoque,function(i,x){	
					var msg = 'A quantidade solicitada ( '+x.qtd_transferida+' ) é maior que a em estoque ( '+x.qtd_estoque+' )';			
					$('#tr-prd-'+i).addClass('tr-out-estoque');
					$('#tr-prd-'+i).find('input').eq(0).attr("data-placement", "top").attr("title", msg).attr("data-original-title", msg); 
					$('#tr-prd-'+i).find('input').eq(0).tooltip();
					$.each(ng.transferencia.produtos,function(x,y){
						if(Number(i) == Number(y.id)){
							y.id_deposito_saida = null ;
						}
					});
				});
			}
		});
	}

	ng.salvarTransferencia = function(){
		var btn = $('#salvar-transferencia') ;
		btn.button('loading');
		$('.tr-out-estoque').find('input').tooltip('destroy');
		$('.tr-out-estoque').removeClass('tr-out-estoque');
		$('.has-error').find('input').tooltip('destroy');

		$('.has-error').find('.chosen-single').attr('style','');
		$('.has-error').find('.chosen-single').find('span').attr('style','');
		$('.has-error').find('.chosen-single').tooltip('destroy');

		$('.has-error').removeClass('has-error');
		var error = 0 ;
		if(!$.isNumeric(ng.id_deposito_principal)){
			$('#id_deposito_principal').addClass('has-error');
			$('#id_deposito_principal').find('.input-group').attr("data-placement", "top").attr("title", 'Informe o deposito').attr("data-original-title", 'Informe o deposito'); 
			$('#id_deposito_principal').find('.input-group').tooltip('show');	
			$('html,body').animate({scrollTop: 0},'slow');
			error ++ ;
		}
		$.each(ng.transferencia.produtos,function(key,item){
			if(!($.isNumeric(item.qtd_transferida))){
				$('#td-prd-'+item.id).addClass('has-error');
				$('#td-prd-'+item.id).find('input').attr("data-placement", "top").attr("title", 'A quantidade para transferência não poder ser vazio').attr("data-original-title", 'A quantidade para transferência não poder ser vazia'); 
				if(error == 0) {
					$('#td-prd-'+item.id).find('input').tooltip('show');
					$('html,body').animate({scrollTop: $('#td-prd-'+item.id).offset().top - 100 },'slow');
				}else {
					$('#td-prd-'+item.id).find('input').tooltip();
				}
				error ++ ;
			}
			if(!($.isNumeric(item.id_deposito_saida))){
				$('#td-prd-deposito-saida-'+item.id).addClass('has-error');
				$('#td-prd-deposito-saida-'+item.id).find('.chosen-single').attr("data-placement", "top").attr("title", 'Informe o deposito de saida').attr("data-original-title", 'A quantidade para transferência não poder ser vazia'); 
				$('#td-prd-deposito-saida-'+item.id).find('.chosen-single').attr('style','border: 1px solid #A94442;');
				$('#td-prd-deposito-saida-'+item.id).find('.chosen-single').find('span').attr('style','color:#A94442;');
				if(error == 0) {
					$('#td-prd-deposito-saida-'+item.id).find('.chosen-single').tooltip('show');
					$('html,body').animate({scrollTop: $('#td-prd-deposito-saida-'+item.id).offset().top - 100 },'slow');
				}else {
					$('#td-prd-deposito-saida-'+item.id).find('.chosen-single').tooltip();
				}
				error ++ ;
			}

		});

		if(error > 0){
			btn.button('reset');
			return ;
		}
		ng.transferencia.dta_transferencia = moment().format('YYYY-MM-DD HH:mm:ss');
		aj.post(baseUrlApi()+"estoque/pedido/transferencia/transferir/",ng.transferencia)
		.success(function(data, status, headers, config) {
			aj.get(baseUrlApi()+"transferencias/estoque/?id_empreendimento_transferencia="+ng.userLogged.id_empreendimento+"&tte->id="+ng.transferencia.id)
			.success(function(data, status, headers, config) {
				btn.button('reset');
				ng.transferencia = angular.copy(transferenciaTO);
				ng.showBoxNovo();
				ng.mensagens('alert-success','<b>transferência realizada com sucesso</b>','.alert-transferencia-lista');
				$('html,body').animate({scrollTop: 0},'slow');
				if(data.length == 1) 
					ng.listaTransferencias.transferencias[index_current_edit] = data[0];
				else
					ng.loadtransferencias(0,10);
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
				ng.transferencia = angular.copy(transferenciaTO);
				ng.showBoxNovo();
				ng.mensagens('alert-success','<b>transferência realizada com sucesso</b>','.alert-transferencia-lista');
				$('html,body').animate({scrollTop: 0},'slow');
	 			ng.loadtransferencias(0,10);
			});
		})
		.error(function(data, status, headers, config) {
			btn.button('reset');
			if(status == 406){
				$.each(data.out_estoque,function(i,x){	
					var msg = 'A quantidade a ser transferêncida ( '+x.qtd_transferida+' ) é maior que a em estoque ( '+x.qtd_estoque+' )';			
					$('#tr-prd-'+i).addClass('tr-out-estoque');
					$('#tr-prd-'+i).find('input').eq(0).attr("data-placement", "top").attr("title", msg).attr("data-original-title", msg); 
					$('#tr-prd-'+i).find('input').eq(0).tooltip();
				});
			}
		});
	}

	var index_current_edit = null ;
	ng.editTransferencia = function(index,event){
		var id = ng.listaTransferencias.transferencias[index].id ;
		index_current_edit = index ;
		var btn = $(event.target) ;
		ng.transferencia = angular.copy(transferenciaTO);
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		btn.button('loading');
		ng.view.transferencia  = null 
		aj.get(baseUrlApi()+"transferencia/estoque/"+id)
		.success(function(data, status, headers, config) {
			var prd_in = ''; aux = [];
			$.each(data.itens,function(i,x){
				prd_in += x.id_produto+",";
				aux[x.id_produto] = x.qtd_pedida ;
			});
			prd_in = prd_in.substring(0,prd_in.length-1);	
			aj.get(baseUrlApi()+"produtos?pro->id[exp]=IN("+prd_in+")")
			.success(function(prd, status, headers, config) {
				ng.transferencia.id = data.id ;
				//ng.transferencia.id_empreendimento_pedido = data.id_empreendimento_pedido ;
				ng.transferencia.id_empreendimento_transferencia = data.id_empreendimento_transferencia ;
				//ng.transferencia.id_usuario_pedido = data.id_usuario_pedido ;
				ng.transferencia.id_usuario_transferencia = ng.userLogged.id ;
				//ng.transferencia.dta_pedido = data.dta_pedido ;
				//ng.transferencia.dta_transferencia = data.dta_transferencia ;
				ng.transferencia.id_status_transferencia = 2 ;
				ng.transferencia.produtos = [];
				ng.showBoxNovo(true);
				$.each(prd.produtos,function(x,i){
					i.qtd_pedida = aux[i.id_produto];
					i.add = 0 ;
					ng.addProduto(i);
				});
				btn.button('reset');
				$('html,body').animate({scrollTop: 0},'slow');
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
				alert('Ocorreu um erro ao buscar os dados');
			});

		})
		.error(function(data, status, headers, config) {
 			btn.button('reset');
 			alert('Ocorreu um erro ao buscar os dados');
		});
	}

	ng.detalhesPedido = function(item){
		var caminho = baseUrlApi()+'relPDF?' + $.param({
			dados : {
				id_empreendimento : ng.userLogged.id_empreendimento,
				id_transferencia_estoque : item.id
			},
			template : 		'relatorio_transferencia_estoque'
		});
		
		eModal.setEModalOptions({ loadingHtml: '<div><div style="text-align: center;margin-top:5px;margin-bottom:3px"><span class="fa fa-circle-o-notch fa-spin fa-3x text-primary"></span></div><div style="text-align: center;"><span class="h4">Carregando, aguarde...</span></div></div>'});
		var title = 'Detalhes do Pedido';
        eModal
            .iframe({message:caminho, title:title,size:'lg'})
            .then(function () { t8.success('iFrame loaded!!!!', title) });
	}

	ng.loadtransferencias(0,10);
	ng.loadDepositosSelect();

});

app.directive('bsTooltip', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            $timeout(function () {
                	  element.find("[data-toggle=tooltip]").tooltip();
            });
        }
    }
});

$("body").on("mouseenter","tr.tr-out-estoque",function() {
  $(this).find('input').eq(0).focus();
});

$("body").on("mouseleave","tr.tr-out-estoque",function() {
  $(this).find('input').eq(0).blur();
});
