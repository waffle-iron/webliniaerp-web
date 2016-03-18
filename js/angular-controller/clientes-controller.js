app.controller('ClientesController', function($scope, $http, $window, $dialogs, UserService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 		= baseUrl();
	ng.userLogged 	= UserService.getUserLogado();
	ng.cliente 	= { 
					tipo_cadastro: "pf",empreendimentos:[],cod_regime_tributario:null,cod_regime_pis_cofins:null,
					cod_tipo_empresa:null,flg_contribuinte_icms:0,flg_contribuinte_ipi:0,cod_zoneamento:null ,regime_especial:[]
				  };
    ng.clientes	= [];
    ng.paginacao = {};
    ng.busca = {clientes:""};
    ng.editing = false;
    ng.estadoSelecionado = {};

    ng.showBoxNovo = function(onlyShow){
    	ng.editing = !ng.editing;

    	if(onlyShow) {
			$('i','#btn-novo').removeClass("fa-plus-circle").addClass("fa-minus-circle");
			$('#box-novo').show(400,function(){$("select").trigger("chosen:updated");});
		}
		else {
			$('#box-novo').toggle(400, function(){
				if($(this).is(':visible')){
					$('i','#btn-novo').removeClass("fa-plus-circle").addClass("fa-minus-circle");
				}else{
					$('i','#btn-novo').removeClass("fa-minus-circle").addClass("fa-plus-circle");
				}
				$("select").trigger("chosen:updated");
			});
		}
		$("select").trigger("chosen:updated");
	}

	ng.consultaCep = function(){
		aj.get("http://api.postmon.com.br/v1/cep/"+ng.cliente.cep)
		.success(function(data, status, headers, config) {

			ng.cliente.endereco = data.logradouro;
			ng.cliente.bairro = data.bairro;
			var estado = ng.getEstado(data.estado);
			ng.cliente.id_estado = estado.id;
			ng.loadCidadesByEstado(data.cidade);
			//ng.cliente.id_cidade = data.cidade_info.codigo_ibge.substr(0,6);
			$("#num_logradouro").focus();
			$('#busca-cep').modal('hide');
		})
		.error(function(data, status, headers, config) {
			$('#busca-cep').modal('hide');
			alert('CEP inválido');
		});
	}

	ng.getEstado = function(uf){
		var estado = null ;
		$.each(ng.estados,function(i,x){
			if(x.uf.toUpperCase() == uf.toUpperCase()){
			    estado = x;
				return false;
			}
		});

		return estado;
	}

	ng.getCidadeByIBGE = function(id){
		var cidade = null ;
		$.each(ng.cidades,function(i,x){
			if(Number(id) == Number(x.id)){
			    cidade = x;
				return false;
			}
		});

		return cidade;
	}

	ng.getEstadoByidIBGE = function(id){
		var estado = null ;
		$.each(ng.estados,function(i,x){
			if(Number(id) == Number(x.id) ){
			    estado = x;
				return false;
			}
		});

		return estado;
	}

	ng.consultaLatLog = function() {
		/*
		var address = ng.cliente.endereco + ", " + ng.cliente.numero + ", " + ng.cliente.cep.substr(0,5) + "-" + ng.cliente.cep.substr(5,ng.cliente.cep.length);

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': address}, function(results, status) {
			if(results.length == 1) {
				ng.cliente.num_latitude = results[0].geometry.location.k;
				ng.cliente.num_longitude = results[0].geometry.location.B;
			} else {
				//alert("Endereço inválido!");
			}
		});
		*/
	}

	ng.mensagens = function(classe , msg){
		$('.alert-sistema').fadeIn().addClass(classe).html(msg);

		setTimeout(function(){
			$('.alert-sistema').fadeOut('slow');
		},5000);
	}

	ng.reset = function() {
		ng.cliente = {};
		ng.editing = false;
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").removeClass("has-error");
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

	ng.loadCidadesByEstado = function (nome_cidade) {
		ng.cidades = [];

		aj.get(baseUrlApi()+"cidades/"+ng.cliente.id_estado)
		.success(function(data, status, headers, config) {
			ng.cidades = data;
			if(nome_cidade != null){
				$.each(ng.cidades,function(i,x){
					if(removerAcentos(nome_cidade) == removerAcentos(x.nome)){
						ng.cliente.id_cidade = x.id;
						return false ;
					}
				});
			}
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.loadComoEncontrou = function () {
		ng.comoencontrou = [];

		aj.get(baseUrlApi()+"comoencontrou")
		.success(function(data, status, headers, config) {
			data.push({id:"outros",nome:"Outros"});
			ng.comoencontrou = data;
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.loadPerfil = function () {
		ng.perfis = [];

		aj.get(baseUrlApi()+"perfis")
		.success(function(data, status, headers, config) {
			var perfis = [] ;
			$.each(data,function(i,v){
				if((v.id == 1 || v.id == 9 || v.id == 10 || v.id == 11) &&  (Number(ng.userLogged.id_empreendimento) == 75)){
					perfis.push(v);
				}else if((v.id != 9 && v.id != 10 && v.id != 11) && (Number(ng.userLogged.id_empreendimento) != 75)){
					perfis.push(v);
				}
			});
			ng.perfis = perfis;
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.loadFinalidades = function () {
		ng.finalidades = [];

		aj.get(baseUrlApi()+"finalidades")
		.success(function(data, status, headers, config) {
			ng.finalidades = data;
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.loadBancos = function () {
		ng.bancos = [];

		aj.get(baseUrlApi()+"bancos")
		.success(function(data, status, headers, config) {
			ng.bancos = data.bancos;
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.loadClientes = function(offset, limit) {
		offset = offset == null ? 0  : offset;
		limit  = limit  == null ? 10 : limit;
		ng.clientes = null ;
		var query_string = "?(tue->id_empreendimento[exp]=="+ng.userLogged.id_empreendimento+"&usu->id[exp]= NOT IN("+ng.configuracao.id_cliente_movimentacao_caixa+","+ng.configuracao.id_usuario_venda_vitrine+"))";

		if(ng.busca.clientes != ""){
			query_string += "&"+$.param({"(usu->nome":{exp:"like'%"+ng.busca.clientes+"%' OR apelido like '%"+ng.busca.clientes+"%')"}})+"";
		}

		aj.get(baseUrlApi()+"usuarios/"+ offset +"/"+ limit +"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.clientes = [];
				ng.paginacao.itens = data.paginacao;
				$.each(data.usuarios,function(i, item){
					//console.log(( empty(item.id_como_encontrou) && !empty(item.como_entrou_outros)));
					item.id_como_encontrou = item.id_como_encontrou == null && (empty(item.id_como_encontrou) && !empty(item.como_entrou_outros)) ? 'outros' : item.id_como_encontrou ; 
					ng.clientes.push(item);
				});
				ng.loadSaldoDevedorClientes();
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.clientes = false;
			});
	}

	ng.loadEmpreendimentoCliente = function() {
		aj.get(baseUrlApi()+"empreendimentos?id_usuario="+ng.cliente.id)
			.success(function(data, status, headers, config) {
				ng.cliente.empreendimentos = data ;
				ng.load_empreendimentos = false ;
			})
			.error(function(data, status, headers, config) {
				
			});
	}

	ng.verificarEmpSelected = function(item){
		var x = false ;
		$.each(ng.cliente.empreendimentos,function(i,v){
			if(Number(item.id) == Number(v.id)){
				x = true;
				return false;
			}
		});
		return x ;
	}

	ng.loadSaldoDevedorClientes = function() {
		var id 			= "" ;
		var id_index 	= {} ;

		$.each(ng.clientes,function(i,v){
			id += v.id+", ";
			id_index[v.id] = i ; 
		});

		id = id.substr(0,id.lastIndexOf(','));

		//console.log(id,id_index);
		

		aj.get(baseUrlApi()+"usuarios/saldodevedor/"+ ng.userLogged.id_empreendimento+"?usu->id[exp]=IN("+id+")")
			.success(function(data, status, headers, config) {
				if(data.id != undefined){
					var index_cliente = id_index[data.id];
					ng.clientes[index_cliente].vlr_saldo_devedor = data.vlr_saldo_devedor;
				}else{
					$.each(data,function(i, item){
						var index_cliente = id_index[item.id];
						ng.clientes[index_cliente].vlr_saldo_devedor = item.vlr_saldo_devedor;
					});
				}	
			})
			.error(function(data, status, headers, config) {
				
			});
	}

	ng.salvar = function() {
		ng.removeError();
		//console.log(ng.cliente);
		var cliente = angular.copy(ng.cliente);
		var btn = $('#btn_salvar');
		btn.button('loading');

		var msg = 'Cliente salvo com sucesso!';
		var url = 'cliente';

		if(cliente.id != null && cliente.id > 0) {
		 	url += '/update';
		 	msg = 'Cliente atualizado com sucesso!';
		 }

		 cliente.id_empreendimento = ng.userLogged.id_empreendimento;
		 cliente.status = 1 ;

		  if(cliente.dta_nacimento != null && cliente.dta_nacimento.length == 8 ){
		 	var data = cliente.dta_nacimento;
		 	var dia  = cliente.dta_nacimento.substring(0,2); 
		 	var mes  = cliente.dta_nacimento.substring(2,4);
		 	var ano  = cliente.dta_nacimento.substring(4,8);

		 	cliente.dta_nacimento = ano+"-"+mes+"-"+dia ;

		 }

		 /*cliente.cod_regime_tributario = cliente.cod_regime_tributario == 0 ? null : cliente.cod_regime_tributario ;
		 cliente.cod_regime_pis_cofins = cliente.cod_regime_pis_cofins == 0 ? null : cliente.cod_regime_pis_cofins ;
		 cliente.cod_tipo_empresa = cliente.cod_tipo_empresa 		   == 0 ? null : cliente.cod_tipo_empresa ;
		 cliente.cod_zoneamento = cliente.cod_zoneamento 			   == 0 ? null : cliente.cod_zoneamento ;*/

		if(!(empty(ng.cliente.id_estado) && empty(ng.cliente.id_cidade) && empty(ng.cliente.endereco) && empty(ng.cliente.numero) && empty(ng.cliente.bairro))){
			 var estado_selecionado = ng.getEstadoByidIBGE(ng.cliente.id_estado);
			 var cidade_selecionada = ng.getCidadeByIBGE(ng.cliente.id_cidade);
			 var address = ng.cliente.endereco + ", " + ng.cliente.numero + ", " + ng.cliente.bairro + "," + cidade_selecionada.nome +"," +estado_selecionado.nome ;
			
			aj.get('https://maps.googleapis.com/maps/api/geocode/json?region=BR&address='+address)
				.success(function(data, status, headers, config) {
					if(data.status = 'OK'){
						cliente.num_latitude  = data.results[0].geometry.location.lat ;
						cliente.num_longitude = data.results[0].geometry.location.lng ;
						ng.ajaxSalvar(cliente,url,msg,btn);
				    }else
				        ng.ajaxSalvar(cliente,url,msg,btn);

				})
				.error(function(data, status, headers, config) {
					ng.ajaxSalvar(cliente,url,msg,btn);

				});
		}else{
			ng.ajaxSalvar(cliente,url,msg,btn);
		}
	}

	ng.ajaxSalvar = function(cliente,url,msg,btn){
		aj.post(baseUrlApi()+url, cliente)
		 	.success(function(data, status, headers, config) {
		 		ng.mensagens('alert-success','<strong>'+msg+'</strong>');
		 		ng.showBoxNovo();
		 		ng.reset();
		 		btn.button('reset');
		 		ng.loadClientes(0,10);
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
		 					.attr("title", "")
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
		 		}
		 	});
	}

	/*ng.buscarLatLog = function (){
		var address = ng.cliente.endereco + ", " + ng.cliente.numero + ", " + ng.cliente.cep.substr(0,5) + "-" + ng.cliente.cep.substr(5,ng.cliente.cep.length);
		aj.get('https://maps.googleapis.com/maps/api/geocode/json?address='+address)
			.success(function(data, status, headers, config) {
				ng.cliente.num_latitude  = data.results[0].geometry.location.lat ;
				ng.cliente.num_longitude = data.results[0].geometry.location.lng ;

			})
			.error(function(data, status, headers, config) {
				
			});
	}*/

	ng.removeError = function(){
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").tooltip('destroy');
		$(".has-error").css({border:"none",background: 'none'}).addClass('has-error');
		$(".has-error").parent().css({'background':'none'});
		$(".has-error").tooltip('destroy');
		$(".has-error").removeClass("has-error");
	}
	ng.load_empreendimentos = false ;
	ng.editar = function(item) {
		ng.load_empreendimentos = true ;
		ng.cliente = angular.copy(item);

		/*ng.cliente.cod_regime_pis_cofins = ng.cliente.cod_regime_pis_cofins  === null ? 0 : ng.cliente.cod_regime_pis_cofins ;
		ng.cliente.cod_tipo_empresa      = ng.cliente.cod_tipo_empresa       === null ? 0 : ng.cliente.cod_tipo_empresa  ;
		ng.cliente.cod_zoneamento        = ng.cliente.cod_zoneamento         === null ? 0 : ng.cliente.cod_zoneamento ;
		ng.cliente.cod_regime_tributario = ng.cliente.cod_regime_tributario  === null ? 0 : ng.cliente.cod_regime_tributario ;*/
		
		ng.cliente.regime_especial = [] ;
	ng.loadRegimeCliente(ng.cliente.id);

		if(ng.cliente.empreendimentos == false)
			ng.cliente.empreendimentos = [] ;
		ng.loadEmpreendimentoCliente();
		ng.loadCidadesByEstado();
		ng.showBoxNovo(true);
	}

	ng.delete = function(item){
		dlg = $dialogs.confirm('Atenção!!!' ,'<strong>Tem certeza que deseja excluir este cliente?</strong>');

		dlg.result.then(function(btn){
			aj.get(baseUrlApi()+"cliente/delete/"+item.id)
				.success(function(data, status, headers, config) {
					ng.mensagens('alert-success','<strong>Cliente excluido com sucesso</strong>');
					ng.reset();
					ng.loadClientes(0,10);
				})
				.error(defaulErrorHandler);
		}, undefined);
	}

	ng.loadEmpreendimentos = function() {
		//ng.reset();
		aj.get(baseUrlApi() + "empreendimentos?id_usuario="+ng.userLogged.id)
			.success(function(data, status, headers, config) {
				ng.empreendimentos = data;
				$('#list_emp').modal('show');
			})
			.error(function(data, status, headers, config) {
				ng.empreendimentos = [] ;
			});
		return false;
	}

	ng.addEmp = function(item){
		if(ng.cliente.empreendimentos == null)
			ng.cliente.empreendimentos = [];

		ng.cliente.empreendimentos.push(item);
	}

	ng.delEmpreendimento = function(index){
		ng.cliente.empreendimentos.splice(index,1);
	}

	ng.loadGrupoComissionamento = function() {
		aj.get(baseUrlApi()+"grupo/comissao/vendedores/?id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.grupo_comissionamento = data.grupoComissaoVendedores;
				ng.grupo_comissionamento.unshift({nme_grupo_comissao:' ',id:null});
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.grupo_comissionamento = [];
			});
	}

	var cep_anterior = null;
	ng.validCep = function(cep){
		if(cep != cep_anterior){
			 var exp  = /^[0-9]{8}$/;
	         var cep = cep;
	         if(exp.test(cep)){
	         	cep_anterior = cep ;
	         	$('#busca-cep').modal({
				  backdrop: 'static',
				  keyboard: false
				});
				ng.consultaCep();
	         }
		}
	}

	ng.configuracao = null ;
	ng.loadConfig = function(){
		var error = 0 ;
		aj.get(baseUrlApi()+"configuracoes/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.configuracao = data ;
				ng.loadClientes(0,10);
			})
			.error(function(data, status, headers, config) {
				ng.loadClientes(0,10);
				if(status == 404){
					ng.configuracao = false ;
				}
			});
	}

	ng.ClearChosenSelect = function(item){
		if(ng.cliente[item] == ''){
			ng.cliente[item] = null;
		}
	}

	ng.regimeTributario = [] ;
	ng.regimePisCofins  = [] ;
	ng.tipoEmpresa      = [] ;
	ng.zoneamentos      = [] ;

	ng.loadControleNfe = function(ctr,key) {
		ng[key] = [] ;
		aj.get(baseUrlApi()+"nfe/controles/null/"+ctr)
			.success(function(data, status, headers, config) {
				ng[key] = [{cod_controle_item_nfe:''}] ;
				ng[key] = ng[key].concat(data) ;
			})
			.error(function(data, status, headers, config) {
				
		});
	}

	ng.loadZoneamento = function() {
		aj.get(baseUrlApi()+"zoneamento/get?cod_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.zoneamentos = [{cod_zoneamento:''}] ;
				ng.zoneamentos = ng.zoneamentos.concat(data.zoneamentos);
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.zoneamentos = [];
			});
	}


	ng.showModalRegimeEspecial = function(){
		$('#list-regime-especial').modal('show');
		ng.loadRegimeEspecial();

	}

	ng.selectedRegimeEspecial = function(item){
		var saida = false ;
		$.each(ng.cliente.regime_especial,function(i,x){
			if(Number(x.cod_regime_especial) == Number(item.cod_regime_especial)){
				saida = true ;
			}
		});
		return saida ;
	}

	ng.selRegimeEspecial = function(item){
		item = angular.copy(item);
		item.cod_cliente = ng.cliente.id;
		ng.cliente.regime_especial.push(item);
	}

	ng.delRegimeEspecial = function(index){
		ng.cliente.regime_especial.splice(index,1);
	}	

	ng.loadRegimeEspecial = function(offset,limit) {
		offset = offset == null ? 0 : offset ;
		limit  = limit  == null ? 10 : limit ;
		ng.regimes = null ;
		aj.get(baseUrlApi()+"regime_especial/get/"+offset+"/"+limit+"?cod_empreendimento="+ng.userLogged.id_empreendimento+"&flg_excluido=0")
			.success(function(data, status, headers, config) {
				ng.regimes = data.regimes;
				ng.paginacao.regimes = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				if(status == 404){
					ng.regimes = [];
					ng.paginacao.regimes = [];
				}
			});
	}

	ng.loadRegimeCliente = function (cod_cliente) {
		aj.get(baseUrlApi()+"regime_especial/cliente/get/"+cod_cliente)
		.success(function(data, status, headers, config) {
			ng.cliente.regime_especial = data;
		})
		.error(function(data, status, headers, config) {
			ng.cliente.regime_especial = [];
		});
	}

	ng.mensagens = function(classe , msg){
		$('.alert-sistema').fadeIn().addClass(classe).html(msg);

		setTimeout(function(){
			$('.alert-sistema').fadeOut('slow');
		},5000);
	}

	ng.loadEstados();
	ng.loadComoEncontrou();
	ng.loadPerfil();
	ng.loadFinalidades();
	ng.loadBancos();
	ng.loadConfig();
	ng.loadGrupoComissionamento();
	ng.loadZoneamento();
	ng.loadControleNfe('regime_tributario','regimeTributario');
	ng.loadControleNfe('regime_tributario_pis_cofins','regimePisCofins');
	ng.loadControleNfe('tipo_empresa','tipoEmpresa');
});
