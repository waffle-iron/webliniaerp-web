app.controller('NotasFiscaisController', function($scope, $http, $window, $dialogs, UserService,ConfigService,$timeout,NFService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 			= baseUrl();
	ng.userLogged 		= UserService.getUserLogado();
	ng.configuracoes 	= ConfigService.getConfig(ng.userLogged.id_empreendimento);
	ng.notas 			= null;
	ng.paginacao 		= {};
	
	ng.reset = function(){
		ng.Notas = {itens:[]};
	}

	ng.busca = { text: "", numeroo: "", nat_op: "" };
	ng.resetFilter = function() {
		$("#inputDtaEmissao").val("");
		$("#inputDtaSaida").val("");
		ng.busca.text = "" ;
		ng.busca.numeroo = "" ;
		ng.busca.nat_op = "" ;
		ng.reset();
		ng.loadNotas(0,10);
	}

	ng.loadNotas = function(offset,limit) {
		ng.notas = [];
		var query_string = "?cod_empreendimento="+ ng.userLogged.id_empreendimento;

		if(ng.busca.nome != ""){
			query_string += "&("+$.param({nome_destinatario:{exp:"like'%"+ng.busca.text+"%')"}});
		}

		if(ng.busca.numeroo != ""){
			query_string += "&("+$.param({numero:{exp:"like'%"+ng.busca.numeroo+"%')"}});
		}

		if(ng.busca.nat_op != ""){
			query_string += "&("+$.param({natureza_operacao:{exp:"like'%"+ng.busca.nat_op+"%')"}});
		}

		if($("#inputDtaEmissao").val() != ""){
			var data_emissao = moment($("#inputDtaEmissao").val(), 'DD/MM/YYYY').format('YYYY-MM-DD');

			query_string += "&("+$.param({'2':{exp:"=2 AND cast(data_emissao as date) = '"+ data_emissao +"' )"}});
		}

		if($("#inputDtaSaida").val() != ""){
			var data_entrada_saida = moment($("#inputDtaSaida").val(), 'DD/MM/YYYY').format('YYYY-MM-DD');

			query_string += "&("+$.param({'2':{exp:"=2 AND cast(data_entrada_saida as date) = '"+ data_entrada_saida +"' )"}});
		}

		aj.get(baseUrlApi()+"notas/"+ offset +"/"+ limit + query_string)
			.success(function(data, status, headers, config) {
				ng.notas 			= data.notas;
				ng.paginacao.notas 	= data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.notas = null;
			});
	}

	ng.atualzarStatus = function(cod_nota_fiscal,index,event){
		var element = $(event.target);
		event.stopPropagation();
		if(!element.is('a'))
			element = $(event.target).parent();
		element.button('loading');

		aj.get(baseUrlApi()+"nota_fiscal/"+cod_nota_fiscal+"/"+ng.userLogged.id_empreendimento+"/atualizar/status")
			.success(function(data, status, headers, config) {
				element.html('<i class="fa fa-check-circle-o"></i> Atualizado');
				if(!(ng.notas[index].status == data.status))
					ng.notas[index] = data ;
				$timeout(function(){
					element.html('<i class="fa fa-refresh"></i> Atualizar Status');
				}, 2000);	
			})
			.error(function(data, status, headers, config) {
				element.html('<i class="fa fa-times-circle"></i> Erro ao atualizar');
				nota = data;
				$timeout(function(){
					element.html('<i class="fa fa-refresh"></i> Atualizar Status');
				}, 2000);	
		});

	}

	ng.showDANFEModal = function(nota){
		eModal.setEModalOptions({
			loadingHtml: '<div><div style="text-align: center;margin-top:5px;margin-bottom:3px"><span class="fa fa-circle-o-notch fa-spin fa-3x text-primary"></span></div><div style="text-align: center;"><span class="h4">Carregando, aguarde...</span></div></div>'
		});
        eModal
            .iframe({
            	message: nota.caminho_danfe, 
            	title: 'DANFE NF-e Nº '+ nota.numero, 
            	size: 'lg'
            })
            .then(function(){
            	t8.success('iFrame loaded!!!!', title)
        	});
	}

	ng.notaCancelar = null ;
	ng.modalCancelar = function(item){
		aj.get(baseUrlApi()+"nota_fiscal/?cod_empreendimento="+ng.userLogged.id_empreendimento+"&cod_venda="+item.cod_venda)
			.success(function(data, status, headers, config) {
				data.dados_emissao.data_emissao = formatDateBR(data.dados_emissao.data_emissao);
				ng.notaCancelar = data ;
				ng.notaCancelar.dados_emissao.chave_nfe = item.chave_nfe ;
				ng.notaCancelar.dados_emissao.valor_total = item.valor_total ;
				ng.notaCancelar.dados_emissao.id_ref = item.cod_nota_fiscal
				
				$('#modal-cencelar-nota').modal('show');
			})
			.error(function(data, status, headers, config) {
				ng.notaCancelar = [] ;
		});
	}

	ng.cacelarNfe = function(){
		if(ng.configuracoes.flg_ambiente_nfe == 0){
			var server = 'http://homologacao.acrasnfe.acras.com.br/';
			var token  =  ng.configuracoes.token_focus_homologacao ;
		}
		else if(ng.configuracoes.flg_ambiente_nfe == 1){
			var server = 'http://producao.acrasnfe.acras.com.br/';
			var token  =  ng.configuracoes.token_focus_producao ;
		}else{
			return ;
		}
		var btn = $('#btn-cancelar-nota');
		btn.button('loading');
		aj.post(server+'nfe2/cancelar?token='+token+'&ref='+ng.notaCancelar.dados_emissao.id_ref+'&justificativa='+ng.notaCancelar.justificativa)
			.success(function(data, status, headers, config) {
				$('#modal-cencelar-nota').modal('hide');
				ng.mensagens('alert-success','<b>Nota cancelada com Sucesso</b>','.alert-list-notas');
				btn.button('reset');
					/*aj.post(server+'nfe2/consultar.json?token='+token+'&ref='+ng.notaCancelar.dados_emissao.id_ref)
					.success(function(data, status, headers, config) {
						if(data.status == 'cancelado'){
							ng.mensagens('alert-success','<b>Nota cancelada com Sucesso</b>','.alert-list-notas');
						}else if(data.status == 'erro_cancelamento'){
							ng.mensagens('alert-success','<b>'+data.mensagem_sefaz_cancelamento+'</b>','.alert-list-notas');
						}
					})
					.error(function(data, status, headers, config) {});*/
			})
			.error(function(data, status, headers, config) {
				$('#modal-cencelar-nota').modal('hide');
				ng.mensagens('alert-danger','<b>Erro ao cacelar nota</b>','.alert-list-notas');
				btn.button('reset');
		});
	}

	ng.mensagens = function(classe , msg, alertClass){
		alertClass = alertClass != null  ?  alertClass:'.alert-sistema' ;
		$(alertClass).fadeIn().removeClass('alert-success alert-danger alert-warning').addClass(classe).html(msg);
		setTimeout(function(){
			$(alertClass).fadeOut('slow');
		},5000);
	}

	ng.loadNotas(0,10);
});
