app.controller('FornecedoresController', function($scope, $http, $window, $dialogs, UserService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 		= baseUrl();
	ng.userLogged 	= UserService.getUserLogado();
	ng.fornecedor 	= {'tipo_cadastro':'pj',telefones:[{tbl_referencia:'tbl_fornecedores',id_referencia:null,num_telefone:null},{tbl_referencia:'tbl_fornecedores',id_referencia:null,num_telefone:null}]};
    ng.fornecedores	= [];
    ng.busca        = {} ;

    ng.editing = false;

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

    ng.consultaCep = function(){
		aj.get("http://api.postmon.com.br/v1/cep/"+ng.fornecedor.num_cep)
		.success(function(data, status, headers, config) {

			ng.fornecedor.nme_endereco = data.logradouro;
			ng.fornecedor.nme_bairro = data.bairro;
			var estado = ng.getEstado(data.estado);
			ng.fornecedor.cod_estado = estado.id;
			ng.loadCidadesByEstado(data.cidade);
			//ng.fornecedor.id_cidade = data.cidade_info.codigo_ibge.substr(0,6);
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
		var estados = angular.copy(ng.chosen_estado);
		$.each(estados,function(i,x){
			if(x.uf.toUpperCase() == uf.toUpperCase()){
			    estado = x;
				return false;
			}
		});

		return estado;
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
					$('i','#btn-novo').removeClass("fa-minus-circle").addClass("fa-plus-circle");
				}
			});
		}
	}

	ng.mensagens = function(classe , msg){
		$('.alert-sistema').fadeIn().addClass(classe).html(msg);

		setTimeout(function(){
			$('.alert-sistema').fadeOut('slow');
		},5000);
	}

	ng.reset = function() {
		
		ng.fornecedor = ng.fornecedor 	= {'tipo_cadastro':'pj'};;
		ng.editing = false;
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").removeClass("has-error");
	}
	ng.fornecedores = [] ;
	ng.load = function(offset,limit) {
		offset = offset == null ? 0  : offset ;
		limit = limit   == null ? 10 : limit ;  
		ng.fornecedores.fornecedores = null ;
		var url = "fornecedores/"+offset+"/"+limit+"?id_empreendimento="+ng.userLogged.id_empreendimento+'&cplSql= ORDER BY frn.nome_fornecedor ASC';

		var query_string = "" ;
		if(!empty(ng.busca.fornecedor)){
			var buscaCpf  = ng.busca.fornecedor.replace(/\./g, '').replace(/\-/g, '');
			var buscaCnpj = ng.busca.fornecedor.replace(/\./g, '').replace(/\-/g, '').replace(/\//g,'');
			var busca = ng.busca.fornecedor.replace(/\s/g, '%');
			query_string += "&"+$.param({"(frn->nome_fornecedor":{exp:"like'%"+busca+"%' OR frn.nme_fantasia like '%"+busca+"%' OR frn.num_cnpj like '%"+buscaCnpj+"%' OR frn.num_cpf like '%"+buscaCpf+"%')"}})+"";
		}

		aj.get(baseUrlApi()+url+query_string)
			.success(function(data, status, headers, config) {
				$.each(data.fornecedores,function(i,x){
					if($.isNumeric(x.id_banco))
					data.fornecedores[i].id_banco = ""+x.id_banco ; 
				});
				ng.fornecedores = data;
			})
			.error(function(data, status, headers, config) {
				ng.fornecedores.fornecedores = [];
			});
	}

	ng.salvar = function() {
		var btn = $('#btn-salvar-fornecedor');
		btn.button('loading');
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").removeClass("has-error");
		var url = 'fornecedor';
		var itemPost = {};

		if(ng.fornecedor.id != null && ng.fornecedor.id > 0) {
			itemPost.id = ng.fornecedor.id;
			url += '/update';
		}

		itemPost = angular.copy(ng.fornecedor);
		itemPost.id_empreendimento 		= ng.userLogged.id_empreendimento;

		aj.post(baseUrlApi()+url, itemPost)
			.success(function(data, status, headers, config) {
				btn.button('reset');
				$('html,body').animate({scrollTop: 0},'slow');
				ng.mensagens('alert-success','<strong>Fornecedores salvo com sucesso!</strong>');
				ng.showBoxNovo();
				ng.reset();
				ng.load();
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
				if(status == 406) {
					var errors = data;
					var cont  = 0 ;
					$.each(errors, function(i, item) {
						$("#"+i).closest(".form-group").addClass("has-error");
						var formControl = $($("#"+i).closest(".form-group"))
						formControl.attr("data-toggle", "tooltip")
							.attr("data-placement", "bottom")
							.attr("title", item)
							.attr("data-original-title", item);
						formControl.tooltip();

						if(cont == 0){
							$('html,body').animate({scrollTop: $("#"+i).parents('.row').offset().top - 50},'slow');
							formControl.tooltip('show');
						}
						cont ++ ;
					});
				}
			});
	}

	ng.editar = function(item) {
		ng.fornecedor = angular.copy(item);
		ng.loadCidadesByEstado();
		ng.showBoxNovo(true);
		$('html,body').animate({scrollTop: 0},'slow');
	}

	ng.delete = function(item){
		dlg = $dialogs.confirm('Atenção!!!' ,'<strong>Tem certeza que deseja excluir este fornecedor?</strong>');

		dlg.result.then(function(btn){
			aj.get(baseUrlApi()+"fornecedor/delete/"+item.id)
				.success(function(data, status, headers, config) {
					ng.mensagens('alert-success','<strong>Fornecedores excluido com sucesso</strong>');
					ng.reset();
					ng.load();
				})
				.error(defaulErrorHandler);
		}, undefined);
	}

	ng.configuracao = null ;
	ng.loadConfig = function(){
		var error = 0 ;
		aj.get(baseUrlApi()+"configuracoes/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.configuracao = data ;
			})
			.error(function(data, status, headers, config) {
				if(status == 404){
					ng.configuracao = false ;
				}
			});
	}

	ng.chosen_estado  = [{id:'',nome:'--- Selecione ---', uf: ''}] ;
    ng.loadEstados = function () {
		aj.get(baseUrlApi()+"estados")
		.success(function(data, status, headers, config) {
			 ng.chosen_estado = ng.chosen_estado.concat(data);

			 setTimeout(function(){
			 	$("select").trigger("chosen:updated")
			 }, 500);
		})
		.error(function(data, status, headers, config) {

		});
	}
	ng.loadEstados();

	ng.chosen_cidade = [{id: "" ,nome:"Selecione um estado"}];
	ng.loadCidadesByEstado = function (nome_cidade) {
		ng.chosen_cidade = [];
		var id_cidade = angular.copy(ng.fornecedor.cod_cidade);
		aj.get(baseUrlApi()+"cidades/"+ng.fornecedor.cod_estado)
		.success(function(data, status, headers, config) {
			ng.fornecedor.cod_cidade = angular.copy(id_cidade);
			console.log(ng.fornecedor.cod_cidade);
			ng.chosen_cidade = data;
			setTimeout(function(){$("select").trigger("chosen:updated");},300);
			if(nome_cidade != null){
				$.each(ng.chosen_cidade,function(i,x){
					if(removerAcentos(nome_cidade) == removerAcentos(x.nome)){
						ng.fornecedor.cod_cidade = angular.copy(x.id);
						return false ;
					}
				});
			}
		})
		.error(function(data, status, headers, config) {

		});
	}

	function defaulErrorHandler(data, status, headers, config) {
		ng.mensagens('alert-danger','<strong>'+ data +'</strong>');
	}

	ng.loadBancos = function () {
		ng.bancos = [];

		aj.get(baseUrlApi()+"bancos")
		.success(function(data, status, headers, config) {
			ng.bancos = [{id:null,nome:'Selecione',codigo:null}];
			ng.bancos = ng.bancos.concat(data.bancos);
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.load();
	ng.loadConfig();
	ng.loadBancos();
});
