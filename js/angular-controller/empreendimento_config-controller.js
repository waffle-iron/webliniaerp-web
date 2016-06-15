app.controller('Empreendimento_config-Controller', function($scope, $http, $window, $dialogs, UserService,ConfigService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 		 = baseUrl();
	ng.userLogged 	 = UserService.getUserLogado();
	ng.cfg  		 = ConfigService.getConfig(ng.userLogged.id_empreendimento);
	ng.currentNode 	 = null;
	ng.exists_cookie = null ; 
    serieDocumentoFiscalTO = {
		cod_empreendimento : ng.userLogged.id_empreendimento,
		serie_documento_fiscal : '',
		num_modelo_documento_fiscal : '',
		num_ultimo_documento_fiscal : '',
    }
    ng.serie_documento_fiscal = angular.copy(serieDocumentoFiscalTO) ;
    ng.lista_serie_documento_fiscal = []; 
    ng.edit_serie_documento_fiscal = false ;
    ng.notEmails = [] ;
    ng.valoresChinelos = { 
    	infantil: { tamanhos: { de: null , ate:null }, faixas: [/*{ de:null,ate:null,valor:null }*/] }, 
    	adulto: { tamanhos: { de: null , ate:null }, faixas: [/*{ de:null,ate:null,valor:null }*/] },
    	adicionais:{cor_adicional:null,chinelo_quadrado:null,acima_41:null}
    };
    ng.impressoras                  = [
    	{ value: null					, dsc:'Selecione' 			},
    	{ value:'bematech_mp_2500_th'	, dsc:'BEMATECH MP-2500 TH' },
    	{ value:'bematech_mp_4200_th'	, dsc:'BEMATECH MP-4200 TH' },
    	{ value:'epson_tm_t20'			, dsc:'EPSON TM T20' 		}
	];


	ng.loadPlanoContasSelect = function() {
	 	ng.plano_contas = [{id:null,dsc_completa:"Selecione"}];
		aj.get(baseUrlApi()+"planocontas?tpc->id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.plano_contas = ng.plano_contas.concat(data);
				setTimeout(function(){$("select").trigger("chosen:updated");},300);
			})
			.error(function(data, status, headers, config) {
				ng.plano_contas;
			});
	}

	ng.mensagens = function(classe , msg, alertClass){
		alertClass = alertClass != null  ?  alertClass:'.alert-sistema' ;
		$(alertClass).fadeIn().addClass(classe).html(msg);
		setTimeout(function(){
			$(alertClass).fadeOut('slow');
		},5000);
	}

	ng.reset = function() {
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").removeClass("has-error");
	}

	ng.loadEmpreendimento = function(id_empreendimento) {
		aj.get(baseUrlApi()+"empreendimento/"+id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.empreendimento = data;
				ng.loadCidadesByEstado();
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.empreendimento = [];
			});
	}

	ng.update = function(event) {
		var btn = $(event.target);
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		btn.button('loading');
		ng.reset();
		$('.formEmprendimento').ajaxForm({
		 	url: baseUrlApi()+"empreendimento/config/update",
		 	type: 'post',
		 	data: ng.empreendimento,
		 	success:function(data){
		 		btn.button('reset');
		 		ng.mensagens('alert-success', 'Configurações atualizadas com sucesso','.alert-basico-loja');
		 	},
		 	error:function(data){
		 		btn.button('reset');
		 		if(data.status == 406){
		 			$.each(data.responseJSON, function(i, item) {
						$("#"+i).addClass("has-error");

						var formControl = $($("#"+i))
							.attr("data-toggle", "tooltip")
							.attr("data-placement", "bottom")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();
					});
		 		}
		 	}
		}).submit(); 
	}
	ng.tipo_plano = null ;
	ng.config     = {} ;
	ng.modalPlanoContas = function(tipo){
		ng.tipo_plano = tipo;
		ng.loadPlanoContas();
		$('#modal-plano-contas').modal('show');
	}

	ng.escolherPlano = function(){
		//console.log(ng.tipo_plano,ng.currentNode);
		if(ng.tipo_plano =='movimentacao'){
			ng.config.nome_plano_movimentacao = ng.currentNode.dsc_plano ;
			ng.id_plano_movimentacao_caixa    = ng.currentNode.id;
		}
		else if(ng.tipo_plano =='fechamento'){
			ng.config.nome_plano_fechamento = ng.currentNode.dsc_plano ;
			ng.id_plano_fechamento_caixa    = ng.currentNode.id;
		}
		$('#modal-plano-contas').modal('hide');
	}

	ng.existsCookie = function(){
		 $.ajax({
		 	url: "setup_caixa.php?exists=true",
		 	async: false,
		 	success: function(data) {
		 		ng.exists_cookie = data;
		 		ng.config.pth_local = data.pth_local;
		 	},
		 	error: function(error) {
		 		ng.exists_cookie = false
		 	}
		 });
	}

	ng.keysConfig = {} ;
	ng.loadConfig = function(event){
		var error = 0 ;
		aj.get(baseUrlApi()+"configuracoes/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {

				$.each(data,function(i,x){
					ng.keysConfig[i] = { 
											nome : i,
											valor : x,
											id_empreendimento : ng.userLogged.id_empreendimento
										}
				});
				data.emails_notificacoes = !empty(data.emails_notificacoes) ? JSON.parse(data.emails_notificacoes) : [] ;
				var emails = [] ;
				$.each(data.emails_notificacoes,function(i,v){
					emails.push({text:v});
				});
				data.emails_notificacoes = emails ;
				ng.configuracoes = data;
				ng.configuracoes.id_plano_conta_pagamento_profissional = ""+ng.configuracoes.id_plano_conta_pagamento_profissional ;
				ng.notEmails = emails;

				if(!empty(data.valores_chinelos) && typeof parseJSON(data.valores_chinelos) == 'object' ){
					ng.valoresChinelos = parseJSON(data.valores_chinelos);
				}
				
				if(data.id_plano_caixa == undefined){
					$('#id_plano_caixa').addClass('has-error');
					error++ ;
				}else{
					ng.loadPlanoConta(data.id_plano_caixa,'movimentacao');
					$('#id_plano_caixa').removeClass('has-error');
				}

				if(!ng.exists_cookie){
					$('#pth_local').addClass('has-error');
					error++ ;
				}else{
					$('#pth_local').removeClass('has-error')
				}

				if(data.id_plano_fechamento_caixa == undefined){
					$('#id_plano_fechamento_caixa').addClass('has-error');
					error++;
				}else{
					ng.loadPlanoConta(data.id_plano_fechamento_caixa,'fechamento');
					$('#id_plano_fechamento_caixa').removeClass('has-error');
				}

				if(error > 0)
					$('.alert-error-config').show();
				else{
					$('.alert-error-config').hide();
				}

			})
			.error(function(data, status, headers, config) {
				if(status == 404){
					ng.configuracoes = [];
					$('#id_plano_caixa').addClass('has-error');
					$('#id_plano_fechamento_caixa').addClass('has-error');
					$('.alert-error-config').show();
					if(!ng.exists_cookie){
						$('#pth_local').addClass('has-error');
					}
				}
			});	
	}

	ng.loadPlanoConta = function(id,tipo) {
		var r  = false ;
		aj.get(baseUrlApi()+"planoconta/"+id)
			.success(function(data, status, headers, config) {
				//console.log(data);
				if(tipo == 'movimentacao'){
					ng.config.nome_plano_movimentacao = data.dsc_plano;
					ng.id_plano_movimentacao_caixa = data.id;
				}else if(tipo == 'fechamento'){
					ng.config.nome_plano_fechamento = data.dsc_plano ;
					ng.id_plano_fechamento_caixa = data.id;
				}
			})
			.error(function(data, status, headers, config) {
			});
	}
	ng.config = {} ;
	ng.salvarConfig = function(event){
		var btn = $(event.target);
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		var chaves = [];
		if(ng.id_plano_fechamento_caixa != undefined){
			var item1 = {
							nome 				:'id_plano_fechamento_caixa',
							valor 				:ng.id_plano_fechamento_caixa , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item1);
		}
		if(ng.id_plano_movimentacao_caixa != undefined){
			var item2 = {
							nome 				:'id_plano_caixa',
							valor 				:ng.id_plano_movimentacao_caixa , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item2);
		}
		if(ng.configuracoes.flg_emitir_nfe_pdv != undefined){
			var item3 = {
							nome 				:'flg_emitir_nfe_pdv',
							valor 				:ng.configuracoes.flg_emitir_nfe_pdv , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item3);
		}

		if(ng.configuracoes.id_plano_conta_pagamento_profissional != undefined){
			var item4 = {
							nome 				:'id_plano_conta_pagamento_profissional',
							valor 				:ng.configuracoes.id_plano_conta_pagamento_profissional , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item4);
		}

		if(ng.configuracoes.patch_socket_sat != undefined){
			var item5 = {
							nome 				:'patch_socket_sat',
							valor 				:ng.configuracoes.patch_socket_sat , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item5);
		}

		if(ng.configuracoes.cadastro_cpf_pdv != undefined){
			var item6 = {
							nome 				:'cadastro_cpf_pdv',
							valor 				:ng.configuracoes.cadastro_cpf_pdv , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item6);
		}

		if(ng.configuracoes.num_cnpj_sw != undefined){
			var item7 = {
							nome 				:'num_cnpj_sw',
							valor 				:ng.configuracoes.num_cnpj_sw , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item7);
		}

		if(ng.configuracoes.txt_sign_ac != undefined){
			var item8 = {
							nome 				:'txt_sign_ac',
							valor 				:ng.configuracoes.txt_sign_ac , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item8);
		}

		if(typeof ng.formas_pagamento_pdv == 'object'){
			var formas_pagamento_pdv = JSON.stringify(angular.copy(ng.formas_pagamento_pdv));
			var item9 = {
							nome 				:'formas_pagamento_pdv',
							valor 				:formas_pagamento_pdv , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item9);
		}

		btn.button('loading');
		var pth_local_sucess = false ;
		if(ng.config.pth_local != undefined){

			aj.post("setup_caixa.php",{pth_local: ng.config.pth_local } )
				.success(function(data, status, headers, config) {
					ng.exists_cookie = true ;
				})
				.error(function(data, status, headers, config) {

				});
		}

		aj.post(baseUrlApi()+"configuracao/save/",{ chaves:chaves, pth_local: ng.config.pth_local} )
			.success(function(data, status, headers, config) {
				btn.button('reset');
				ng.mensagens('alert-success', 'Configurações atualizadas com sucesso','.alert-config');
				ng.loadConfig();
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
			});
	}

	ng.cancelarModal = function(id){
		$('#'+id).modal('hide');
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
	 	ng[key] = [];
		aj.get(baseUrlApi()+"nfe/controles/null/"+ctr)
			.success(function(data, status, headers, config) {
				ng[key] = [{cod_controle_item_nfe:'',num_item:''}];
				$.each(data,function(i,v){
					data[i].descricao = v.nme_item+' - '+v.dsc_item ;
				});
				ng[key] = ng[key].concat(data);
				setTimeout(function(){
					$("select").trigger("chosen:updated");
				},300);
			})
			.error(function(data, status, headers, config) {
				
		});
	}

	ng.loadSerieDocumentoFiscal = function() {
		ng.lista_serie_documento_fiscal = null ;
		aj.get(baseUrlApi()+"serie_documento_fiscal/?cod_empreendimento="+ng.userLogged.id_empreendimento+"&tsdf->flg_excluido=0")
			.success(function(data, status, headers, config) {
				ng.lista_serie_documento_fiscal = data;
				$("select").trigger("chosen:updated");
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.lista_serie_documento_fiscal = [];
			});
	}

	ng.incluirSerieDocumentoFiscal = function(event){
		var btn = $(event.target) ;
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		btn.button('loading');
		var item = angular.copy(ng.serie_documento_fiscal) ;
		var error = 0 ;
		$('.has-error').tooltip('destroy')
		$('.has-error').removeClass('has-error')
		$.each(item,function(i,v){
			if(empty(v) && (i == 'serie_documento_fiscal' ||  i == 'num_modelo_documento_fiscal' ||  i == 'num_ultimo_documento_fiscal')){
				$("#produto-cliente-nme_cliente").addClass("has-error");
					var formControl = $("#"+i);
						formControl.addClass("has-error")
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", "Campo  obrigatório")
						.attr("data-original-title", "Campo  obrigatório");
				if(error == 0) formControl.tooltip('show');
				else  formControl.tooltip() ;
				error ++ ;
			}else if(i == 'serie_documento_fiscal' && !(ng.edit_serie_documento_fiscal)){
				$.each(ng.lista_serie_documento_fiscal,function(y,z){
					if(v == z.serie_documento_fiscal){
						var formControl = $("#"+i);
						formControl.addClass("has-error")
						.attr("data-toggle", "tooltip")
						.attr("data-placement", "bottom")
						.attr("title", "Número de série ja existe")
						.attr("data-original-title", "Número de série ja existe");
						if(error == 0) formControl.tooltip('show');
						else  formControl.tooltip() ;
						error ++ ;
						return ;
					}
				});

			}
		});


		if(error > 0){
			btn.button('reset');
			return ;
		}


		$.each(ng.chosen_modelo_nota_fiscal,function(i,v){
			
			if(v.num_item == item.num_modelo_documento_fiscal){
				item.dsc_modelo_documento_fiscal =  v.nme_item +' - '+ v.dsc_item ;
				return ;
			}
		});

		if(ng.edit_serie_documento_fiscal){
			ng.lista_serie_documento_fiscal[ng.index_edit_serie_documento_fiscal] = item ;
			ng.index_edit_serie_documento_fiscal = null ;
			ng.edit_serie_documento_fiscal = false ;
		}
		else ng.lista_serie_documento_fiscal.push(item);
		ng.serie_documento_fiscal = angular.copy(serieDocumentoFiscalTO) ;
		btn.button('reset');
	}

	ng.indexEditSerieDocumentoFiscal ;
	ng.editSerieDocumentoFiscal = function(index,item){
		ng.edit_serie_documento_fiscal = true ;
		ng.index_edit_serie_documento_fiscal = index ;
		ng.serie_documento_fiscal = angular.copy(item);
		console.log(ng.serie_documento_fiscal);
	}

	var deleteSerieFiscal = [] ;
	ng.delSerieDocumentoFiscal = function(index){
		if(ng.lista_serie_documento_fiscal[index].id == undefined)
			ng.lista_serie_documento_fiscal.splice(index,1);
		else
			ng.lista_serie_documento_fiscal[index].flg_excluido = 1 ;

		console.log(deleteSerieFiscal);
	}

	ng.salvarConfigFiscal = function(event){
		var serie = angular.copy(ng.serie_documento_fiscal);
		var btn = $(event.target);
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		var chaves = [];
		if(ng.configuracoes.id_operacao_padrao_venda != undefined){
			var item = {nome:'id_operacao_padrao_venda',valor:ng.configuracoes.id_operacao_padrao_venda,id_empreendimento:ng.userLogged.id_empreendimento}
			chaves.push(item);
		}

		if(ng.configuracoes.id_serie_padrao_nfce != undefined){
			var item = {nome :'id_serie_padrao_nfce',valor:ng.configuracoes.id_serie_padrao_nfce ,id_empreendimento:ng.userLogged.id_empreendimento}
			chaves.push(item);
		}

		if(ng.configuracoes.id_serie_padrao_nfe != undefined){
			var item = {nome :'id_serie_padrao_nfe',valor:ng.configuracoes.id_serie_padrao_nfe , id_empreendimento	:ng.userLogged.id_empreendimento}
			chaves.push(item);
		}

		if(ng.configuracoes.flg_ambiente_nfe != undefined){
			var item = {nome :'flg_ambiente_nfe',valor:ng.configuracoes.flg_ambiente_nfe , id_empreendimento	:ng.userLogged.id_empreendimento}
			chaves.push(item);
		}

		if(ng.configuracoes.token_focus_producao != undefined){
			var item = {nome :'token_focus_producao',valor:ng.configuracoes.token_focus_producao , id_empreendimento	:ng.userLogged.id_empreendimento}
			chaves.push(item);
		}

		if(ng.configuracoes.token_focus_homologacao != undefined){
			var item = {nome :'token_focus_homologacao',valor:ng.configuracoes.token_focus_homologacao , id_empreendimento	:ng.userLogged.id_empreendimento}
			chaves.push(item);
		}

		btn.button('loading');
		if(empty(ng.lista_serie_documento_fiscal)){
			ng.lista_serie_documento_fiscal = [] ;
		}
		aj.post(baseUrlApi()+"serie_documento_fiscal",{series:ng.lista_serie_documento_fiscal})
			.success(function(data, status, headers, config) {
				aj.post(baseUrlApi()+"configuracao/save/",{ chaves:chaves, pth_local: ng.config.pth_local} )
					.success(function(data, status, headers, config) {
						ng.loadSerieDocumentoFiscal();
						btn.button('reset');
						ng.mensagens('alert-success', 'Configurações atualizadas com sucesso','.alert-config-fiscal');
					})
					.error(function(data, status, headers, config) {
						btn.button('reset');
					});
			})
			.error(function(data, status, headers, config) {
				alert('Erro Fatal')
				btn.button('reset');
			});
		
	}
 
	ng.salvarConfigNotificacoes = function(event){
		var btn = $(event.target);
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		var chaves = [];
		if(!empty(ng.notEmails) || ng.notEmails.length > 0){
			var emails = [] ;
			$.each(ng.notEmails,function(i,v){
				emails.push(v.text);
			});
			var x = JSON.stringify(emails);
			item = {nome:'emails_notificacoes',valor:x,id_empreendimento:ng.userLogged.id_empreendimento}
			chaves.push(item);
		}else{
			return ;
		}

		btn.button('loading');
		aj.post(baseUrlApi()+"configuracao/save/",{ chaves:chaves, pth_local: ng.config.pth_local} )
			.success(function(data, status, headers, config) {
				btn.button('reset');
				ng.mensagens('alert-success', 'Configurações atualizadas com sucesso','.alert-config-not');
				ng.loadConfig();
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
			});
		
	}

	ng.salvarConfigAtendimento = function(event){
		var btn = $(event.target);
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		var chaves = [];


		if(ng.configuracoes.id_plano_conta_pagamento_profissional != undefined){
			var item = {
							nome 				:'id_plano_conta_pagamento_profissional',
							valor 				:ng.configuracoes.id_plano_conta_pagamento_profissional , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item);
		}

		if(ng.configuracoes.flg_controlar_tempo_atendimento != undefined){
			var item = {
							nome 				:'flg_controlar_tempo_atendimento',
							valor 				:ng.configuracoes.flg_controlar_tempo_atendimento , 
							id_empreendimento	:ng.userLogged.id_empreendimento
						}
			chaves.push(item);
		}

		btn.button('loading');
		
		aj.post(baseUrlApi()+"configuracao/save/",{ chaves:chaves, pth_local: ng.config.pth_local} )
			.success(function(data, status, headers, config) {
				btn.button('reset');
				ng.mensagens('alert-success', 'Configurações atualizadas com sucesso','.alert-config-atendimento');
				ng.loadConfig();
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
			});
	}

	ng.salvarConfigControleMesas = function(event){
		var btn = $(event.target);
		if(!(btn.is(':button')))
			btn = $(btn.parent('button'));
		var chaves = [];

		if(ng.configuracoes.printer_model_op != undefined){
			var item = {
				nome 				:'printer_model_op',
				valor 				:ng.configuracoes.printer_model_op , 
				id_empreendimento	:ng.userLogged.id_empreendimento
			};
			chaves.push(item);
		}

		btn.button('loading');
		
		aj.post(baseUrlApi()+"configuracao/save/",{ chaves: chaves })
			.success(function(data, status, headers, config) {
				btn.button('reset');
				ng.mensagens('alert-success', 'Configurações atualizadas com sucesso','.alert-config-mesas');
				ng.loadConfig();
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
			});
	}

	ng.loadEstados = function () {
		ng.estados = [];

		aj.get(baseUrlApi()+"estados")
		.success(function(data, status, headers, config) {
			ng.estados = data;
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.cidades = [{id: "" ,nome:"Selecione um estado"}];
	ng.loadCidadesByEstado = function () {
		ng.cidades = [];
		aj.get(baseUrlApi()+"cidades_by_id_estado/"+ng.empreendimento.cod_estado)
		.success(function(data, status, headers, config) {
			ng.cidades = data;
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.loadZoneamento = function() {
		aj.get(baseUrlApi()+"zoneamento/get?cod_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.zoneamentos = ng.zoneamentos.concat(data.zoneamentos);
				setTimeout(function(){$("select").trigger("chosen:updated");},300);
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.zoneamentos = [];
			});
	}

	ng.loadPlanoContas = function() {
		aj.get(baseUrlApi()+"plano_contas_treeview?tpc->id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.planoContas = data;
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.planoContas = [];
			});
	}

	ng.loadFormasPagamento = function() {
		ng.formas_pagamento = [];
		aj.get(baseUrlApi()+"formas_pagamento")
			.success(function(data, status, headers, config) {
				ng.formas_pagamento_pdv = data ;
				var aux = typeof parseJSON(ng.cfg.formas_pagamento_pdv) == 'object' ?  parseJSON(ng.cfg.formas_pagamento_pdv) : [] ;
				$.each(ng.formas_pagamento_pdv,function(i,x){ 
					ng.formas_pagamento_pdv[i].value = 0 ;
					var exists = false ;
					$.each(aux,function(y,z){ 
						if(x.id == z.id && Number(z.value) == 1){
							exists = true
							return ;
						}
					});
					if(exists)
						ng.formas_pagamento_pdv[i].value = aux[i].value ;
					else
						ng.formas_pagamento_pdv[i].value = 0 ;

				});
			});
	}
	ng.incluirFaixa = function(tipo){
		ng.valoresChinelos[tipo].faixas.push({de:null,ate:null,valor:null });
	}

	ng.excluirFaixa = function(tipo,obj){
		ng.valoresChinelos[tipo].faixas = _.without(ng.valoresChinelos[tipo].faixas,obj);
	}

	ng.salvarConfigPedidoPersonalizado = function(valoresChinelos){
		var btn = $('#btn-pedido-personalizado');
		btn.button('loading');
		valoresChinelos = angular.copy(valoresChinelos);
		var json = JSON.stringify(valoresChinelos);
		var chaves = [];
		var item = {
			nome 				:'valores_chinelos',
			valor 				: json , 
			id_empreendimento	:ng.userLogged.id_empreendimento
		}
		chaves.push(item);
		
		aj.post(baseUrlApi()+"configuracao/save/",{chaves:chaves} )
			.success(function(data, status, headers, config) {
				btn.button('reset');
				ng.mensagens('alert-success', 'Configurações atualizadas com sucesso','.alert-config-pedido-personalizado');
				ng.loadConfig();
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
			});

		console.log(json);
	}


	ng.loadControleNfe('modelo_nota_fiscal','chosen_modelo_nota_fiscal');
	function defaulErrorHandler(data, status, headers, config) {
		ng.mensagens('alert-danger','<strong>'+ data +'</strong>');
	}

	ng.regimeTributario = [{num_item:null,nme_item:null}] ;
	ng.regimePisCofins = [{num_item:null,nme_item:null}] ;
	ng.tipoEmpresa = [{num_item:null,nme_item:null}] ;
	ng.zoneamentos = [{num_item:null,nme_item:null}] ;

	ng.loadEmpreendimento(ng.userLogged.id_empreendimento);
	ng.existsCookie();
	ng.loadConfig();
	ng.loadOperacaoCombo();
	ng.loadSerieDocumentoFiscal();
	ng.loadEstados();
	ng.loadZoneamento();
	ng.loadControleNfe('regime_tributario','regimeTributario');
	ng.loadControleNfe('regime_tributario_pis_cofins','regimePisCofins');
	ng.loadControleNfe('tipo_empresa','tipoEmpresa');
	ng.loadPlanoContas();
	ng.loadPlanoContasSelect();
	ng.loadFormasPagamento();

	
});
