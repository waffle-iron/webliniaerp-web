app.controller('NotaFiscalController', function($scope, $http, $window, $dialogs,$interval, UserService,ConfigService,NFService){
	var ng = $scope
		aj = $http;
	var params       = getUrlVars();
	ng.baseUrl 		 = baseUrl();
	ng.userLogged 	 = UserService.getUserLogado();
	ng.configuracoes = ConfigService.getConfig(ng.userLogged.id_empreendimento);
	
	if($.isNumeric(params.id_venda))
		ng.nota  = NFService.getNota(ng.userLogged.id_empreendimento,params.id_venda);
    
    ng.editing 		= false;
    var nfTO        = {
    	dados_emissao : {
    			tipo_documento : '',
				local_destino : '',
				finalidade_emissao : '',
				consumidor_final : '',
				forma_pagamento :'',
				presenca_comprador:''
			},
		transportadora : {
			modalidade_frete : '' 
		}

    } ;
    ng.NF = ng.nota == false ? angular.copy(nfTO) : ng.nota  ;
    ng.NF.dados_emissao.cod_operacao = null ;
    ng.processando_autorizacao =  (ng.NF.dados_emissao.status  == 'processando_autorizacao');
    ng.autorizado              =  (ng.NF.dados_emissao.status  == 'autorizado');
    if(!empty(ng.NF.dados_emissao.data_emissao)) $('#inputDtaEmissao').val(moment(ng.NF.dados_emissao.data_emissao).format('DD/MM/YYYY')) ;
    if(!empty(ng.NF.dados_emissao.data_entrada_saida)){ 
    	$('#inputDtaSaida').val(moment(ng.NF.dados_emissao.data_entrada_saida).format('DD/MM/YYYY')) ;
    	$('#InputhrsSaida').val(moment(ng.NF.dados_emissao.data_entrada_saida).format('HH:mm')) ;
    }
    ng.NF.id_empreendimento = ng.userLogged.id_empreendimento ;

    ng.id_transportadora;
    ng.disableSendNf = false ;

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

	ng.nfeCalculada = false ;
	ng.calcularNfe = function(event,id_venda,cod_operacao) {
		var formControl = $('#cod_operacao')
		formControl.removeClass("has-error");
		formControl.tooltip('destroy');
		if(empty(cod_operacao)){
			formControl.addClass("has-error");
			formControl.attr("data-toggle", "tooltip").attr("data-placement", "top").attr("title", 'Selecione a operação').attr("data-original-title", 'Selecione a operação');
			formControl.tooltip('show');
			$('html,body').animate({scrollTop: 0},'slow');
			return ;
		}
		if(event != null){
			var btn = $(event.target) ;
			if(!(btn.is(':button')))
				btn = $(btn.parent('button'));
			btn.button('loading');
		}else
			$('#modal-calculando').modal({ backdrop: 'static',keyboard: false});
		var post = { 
			id_empreendimento : ng.userLogged.id_empreendimento,
			id_venda          : id_venda,
			cod_operacao      : cod_operacao
		 } ;
		var copy_dados = angular.copy(nfTO);
		copy_dados.dados_emissao.tipo_documento = ng.NF.dados_emissao.tipo_documento;
		copy_dados.dados_emissao.local_destino = ng.NF.dados_emissao.local_destino ;
		copy_dados.dados_emissao.finalidade_emissao = ng.NF.dados_emissao.finalidade_emissao ;
		copy_dados.dados_emissao.consumidor_final = ng.NF.dados_emissao.consumidor_final;
		copy_dados.dados_emissao.forma_pagamento = ng.NF.dados_emissao.forma_pagamento;
		copy_dados.dados_emissao.presenca_comprador = ng.NF.dados_emissao.presenca_comprador;
		copy_dados.dados_emissao.cod_nota_fiscal = ng.NF.dados_emissao.cod_nota_fiscal;
		copy_dados.dados_emissao.cod_venda = ng.NF.dados_emissao.cod_venda;
		copy_dados.dados_emissao.cod_operacao = ng.NF.dados_emissao.cod_operacao;

		copy_dados.transportadora.modalidade_frete = ng.NF.transportadora.modalidade_frete;
		aj.post(baseUrlApi()+"nfe/calcular",post)
			.success(function(data, status, headers, config) {
				ng.nfeCalculada = true;
				ng.disableSendNf = false ;
				data.dados_emissao.tipo_documento = copy_dados.dados_emissao.tipo_documento ;
				data.dados_emissao.local_destino = copy_dados.dados_emissao.local_destino ;
				data.dados_emissao.finalidade_emissao = copy_dados.dados_emissao.finalidade_emissao ;
				data.dados_emissao.consumidor_final = copy_dados.dados_emissao.consumidor_final ;
				data.dados_emissao.forma_pagamento = copy_dados.dados_emissao.forma_pagamento ;
				data.dados_emissao.presenca_comprador = copy_dados.dados_emissao.presenca_comprador ;
				data.dados_emissao.cod_nota_fiscal = copy_dados.dados_emissao.cod_nota_fiscal ;
				data.dados_emissao.cod_venda = copy_dados.dados_emissao.cod_venda ;
				data.dados_emissao.cod_operacao = copy_dados.dados_emissao.cod_operacao ;
				if(data.transportadora == undefined) data.transportadora = {id:null,modalidade_frete:null} ;
				data.transportadora.modalidade_frete = copy_dados.transportadora.modalidade_frete ;

				ng.NF = data;
				if(event != null){
					$('#modal-operacao').modal('hide');
					btn.button('reset');
					$('.tab-bar li a').eq(0).trigger('click');
				}else{
					$('#modal-calculando').modal('hide');
				}
			})
			.error(function(data, status, headers, config) {
				if(event != null)
					btn.button('reset');
				ng.nfeCalculada = false;
				ng.disableSendNf = true ;
				$('#modal-calculando').modal('hide');
				if(status == 406){
					var msg = data.mensagem+"<br/>"; 
					$dialogs.error('<strong>'+msg+'</strong>');
					$('#notifyModal h4').addClass('text-warning');
					if(event != null)
						btn.button('reset');		
				}else{
					$dialogs.notify('Desculpe!','<strong>Ocorreu um erro ao calcular a NF.</strong>');
				}
			});
	}

	ng.loadTransportadoras = function() {
		ng.lista_traportadoras = [{id:'',nome_fornecedor:''}];
		aj.get(baseUrlApi()+"fornecedores?id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.lista_traportadoras  = ng.lista_traportadoras.concat(data.fornecedores);
				setTimeout(function(){
					$("select").trigger("chosen:updated");
				},300);
			})
			.error(function(data, status, headers, config) {
				ng.lista_traportadoras = [] ;
			});
	}



	ng.lista_modalidade_frete = [] ;
	ng.loadControleNfe = function(ctr,key) {
		aj.get(baseUrlApi()+"nfe/controles/null/"+ctr)
			.success(function(data, status, headers, config) {
				ng[key] = [{ num_item : null, nme_item:"Selecione"}];
				ng[key] = ng[key].concat(data) ;
				setTimeout(function(){
					//console.log(ng[key]);
					$("select").trigger("chosen:updated");
				},300);
			})
			.error(function(data, status, headers, config) {
				ng[key] = [] ;	
		});
	}

	ng.selTransportadora = function(){
		var item ;
		$.each(ng.lista_traportadoras,function(i,v){
			if(Number(ng.NF.transportadora.id) == Number(v.id)){
				item = v ;
				return ;
			}
		});

		ng.NF.transportadora.xFant 					=  item.nme_fantasia;
		ng.NF.transportadora.CNPJ 					=  item.num_cnpj;
		ng.NF.transportadora.IE   					=  item.num_inscricao_estadual;
		ng.NF.transportadora.CEP 					=  item.num_cep;
		ng.NF.transportadora.nme_logradouro 		=  item.nme_endereco;
		ng.NF.transportadora.num_logradouro 		=  item.num_logradouro;
		ng.NF.transportadora.nme_bairro_logradouro 	=  item.nme_bairro;
		ng.NF.transportadora.estado 				=  ((typeof item.estado == 'object')  ? item.estado : null );
		ng.NF.transportadora.cidade 				=  ((typeof item.cidade == 'object')  ? item.cidade : null );
	}

	ng.sendNfe = function(){
		var btnCalcula = $("#calcularNfe") ;
		btnCalcula.tooltip('destroy');
		if(!ng.nfeCalculada){
			btnCalcula.attr("data-toggle", "tooltip").attr("data-placement", "top").attr("title", 'Calcule a NF-e').attr("data-original-title", '');
			btnCalcula.tooltip('show');
			setTimeout(function(){
				btnCalcula.tooltip('destroy');
			},3000);
			return ;
		}
		var btn = $(event.target) ;
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		btn.button('loading');

		
		var hrs_entrada_saida  	= $('#InputhrsSaida').val() ;
		var data_entrada_saida  = $('#inputDtaSaida').val() ;
		data_entrada_saida  += empty(hrs_entrada_saida) ? "" : " "+hrs_entrada_saida+":00" ;
		data_entrada_saida  = moment(data_entrada_saida ,'DD/MM/YYYY HH:mm:ss');

		var data_emissao    = moment($('#inputDtaEmissao').val(),'DD/MM/YYYY HH:mm:ss');

		//console.log(data_emissao.format());
		//btn.button('reset');
		//return ;
		
		var msg = "" ;
		var error = 0 ;	
		if(!data_emissao.isValid()){
			msg += "Informe a data de emissão<br/>";
			error ++ ;
		}
		if(!data_entrada_saida.isValid()){
			msg += "Informe a data de saida<br/>";
			error ++;
		}

		if(error > 0){
			btn.button('reset');
			$dialogs.error('<strong>'+msg+'</strong>');	
			return ;
		}

		ng.NF.dados_emissao.data_emissao  		= data_emissao.format("YYYY/MM/DD HH:mm:ss");
		ng.NF.dados_emissao.data_entrada_saida  = data_entrada_saida.format("YYYY/MM/DD HH:mm:ss");
		ng.NF.id_empreendimento = ng.userLogged.id_empreendimento ;
		aj.post(baseUrlApi()+"nfe/send",ng.NF)
			.success(function(data, status, headers, config) {
				btn.button('reset');
				if(status == 202){
					ng.processando_autorizacao = true ;
					/*$dialogs.notify('Sucesso','<strong>Nota transmitida com suceso.</strong>'+
					'<br><br><pre style="overflow:auto;height: 300px;" >'+data.json+'</pre>');*/
					$dialogs.notify('Sucesso','<strong>Nota transmitida com sucesso.</strong>');

				}
			})
			.error(function(data, status, headers, config) {
				var msg = "" ;
				if( typeof data != 'undefined'){
					$.each(data.erros,function(i,v){
						msg += v.mensagem+"<br/>";
					});
				}
			
				$dialogs.error('<strong>'+msg+'</strong>'+'<br><br><pre style="overflow:auto;height: 300px;" >'+data.json+'</pre>');
				$('#notifyModal h4').addClass('text-warning')
				btn.button('reset');		
		});
	}

	ng.loadOperacaoCombo = function() {
		ng.lista_operacao  = [{cod_operacao:null,dsc_operacao:'Selecione'}] ;
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

	ng.setDadosEmissao = function(){
		var cod_operacao = ng.NF.dados_emissao.cod_operacao ;
		$.each(ng.lista_operacao,function(i,v){
			if(Number(cod_operacao) == Number(v.cod_operacao)){
				ng.NF.dados_emissao.local_destino = v.num_local_destino;
				ng.NF.dados_emissao.finalidade_emissao = v.num_finalidade_emissao;
				ng.NF.dados_emissao.consumidor_final = v.num_consumidor_final;
				ng.NF.dados_emissao.tipo_documento = v.num_tipo_documento;
				ng.NF.dados_emissao.presenca_comprador = v.num_presenca_comprador;
			}
		});
	}

	ng.showDANFEModal = function(nota){
		eModal.setEModalOptions({
			loadingHtml: '<div><div style="text-align: center;margin-top:5px;margin-bottom:3px"><span class="fa fa-circle-o-notch fa-spin fa-3x text-primary"></span></div><div style="text-align: center;"><span class="h4">Carregando, aguarde...</span></div></div>'
		});
        eModal
            .iframe({
            	message: nota.caminho_danfe, 
            	title: 'DANFE NF-e Nº '+ nota.num_documento_fiscal, 
            	size: 'lg'
            })
            .then(function(){
            	t8.success('iFrame loaded!!!!', title)
        	});
	}

	if(($.isNumeric(params.id_venda))){
		ng.NF.dados_emissao.cod_venda = params.id_venda ;
		if( ($.isNumeric(params.id_venda) &&  $.isNumeric(params.cod_operacao) )){
			ng.NF.dados_emissao.cod_operacao = Number(params.cod_operacao) ;
			ng.calcularNfe(null,params.id_venda,params.cod_operacao);
		}
		
		ng.loadTransportadoras();
		ng.loadOperacaoCombo();
		ng.loadControleNfe('modalidade_frete','lista_modalidade_frete');
		ng.loadControleNfe('modalidade_frete','lista_modalidade_frete');
		ng.loadControleNfe('tipo_documento','lista_tipo_documento');
		ng.loadControleNfe('forma_pagamento','lista_forma_pagamento');
		ng.loadControleNfe('presenca_comprador','lista_presenca_comprador');

		ng.loadControleNfe('local_destino','lista_local_destino');
		ng.loadControleNfe('finalidade_emissao','lista_finalidade_emissao');
		ng.loadControleNfe('consumidor_final','lista_consumidor_final');
	}else 
		$dialogs.notify('Desculpe!','<strong>Não foi possível calcular a NF, os paramentros estão incorretos.</strong>');
					
	//ng.loadAllEmpreendimentos();
	//ng.loadDepositos();
});
