app.controller('CadastroController', function($scope, $http, $window, $dialogs, UserService){

	var ng = $scope
		aj = $http;

	ng.baseUrl 		= baseUrl();
	//ng.userLogged 	= UserService.getUserLogado();
	ng.cliente 	= { tipo_cadastro: "pf",id_perfil:7 };
    ng.clientes	= [];
    ng.editing = false;
    ng.estadoSelecionado = {};

	ng.baseUrl 		   = baseUrl();
	ng.busca		   = {nome:"" , id_categoria:null, id_fabricante:null};
	ng.paginacao       = {grade:null}; 


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

	ng.consultaCep = function(){
		aj.get("http://api.postmon.com.br/v1/cep/"+ng.cliente.cep)
		.success(function(data, status, headers, config) {
			ng.cliente.endereco = data.logradouro;
			ng.cliente.bairro = data.bairro;
			ng.cliente.id_estado = data.estado_info.codigo_ibge;
			ng.cliente.id_cidade = data.cidade_info.codigo_ibge.substr(0,6);
			ng.loadCidadesByEstado();
			$("#num_logradouro").focus();
		})
		.error(function(data, status, headers, config) {

		});
	}

	ng.consultaLatLog = function() {
		var address = ng.cliente.endereco + ", " + ng.cliente.numero + ", " + ng.cliente.cep.substr(0,5) + "-" + ng.cliente.cep.substr(5,ng.cliente.cep.length);

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': address}, function(results, status) {
			if(results.length == 1) {

				ng.cliente.num_latitude  = results[0].geometry.location.k;
				ng.cliente.num_longitude = results[0].geometry.location.B;
				
			} else {
				alert("Endereço inválido!");
			}
		});
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

	ng.loadCidadesByEstado = function () {
		ng.cidades = [];

		aj.get(baseUrlApi()+"cidades/"+ng.cliente.id_estado)
		.success(function(data, status, headers, config) {
			ng.cidades = data;
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
			ng.perfis = data;
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

		var query_string = "?emp->id="+ng.userLogged.id_empreendimento;

		if(ng.busca.clientes != ""){
			query_string += "&"+$.param({"usu->nome":{exp:"like'%"+ng.busca.clientes+"%' OR apelido like '%"+ng.busca.clientes+"%' OR per.nome like '%"+ng.busca.clientes+"%'"}})+"";
		}

		aj.get(baseUrlApi()+"usuarios/"+ offset +"/"+ limit +"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.clientes = [];
				ng.paginacao.itens = data.paginacao;
				$.each(data.usuarios,function(i, item){
					item.id_como_encontrou = item.id_como_encontrou == null || item.id_como_encontrou == "" ? 'outros' : item.id_como_encontrou ; 
					ng.clientes.push(item);
				});
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.clientes = [];
			});
	}

	ng.salvar = function() {
		ng.cliente.empreendimentos 		= [{id:ng.id_empreendimento}];
		ng.cliente.id_empreendimento 	= ng.id_empreendimento ;

		var btn = $('#btn-salvar');
   		btn.button('loading');
		ng.removeError();
		var cliente = angular.copy(ng.cliente);
		var msg = 'Seu Cadastro foi efetuado com sucesso!';
		var url = 'cliente';

		if(cliente.id != null && cliente.id > 0) {
		 	url += '/update';
		 	msg = 'Cliente atualizado com sucesso!';
		 }

		 cliente.status = 1 ;
		 
		 if(cliente.dta_nacimento != null && cliente.dta_nacimento.length == 8 ){
		 	var data = cliente.dta_nacimento;
		 	var dia  = cliente.dta_nacimento.substring(0,2); 
		 	var mes  = cliente.dta_nacimento.substring(2,4);
		 	var ano  = cliente.dta_nacimento.substring(4,8);

		 	cliente.dta_nacimento = ano+"-"+mes+"-"+dia ;

		 }

		 aj.post(baseUrlApi()+url, cliente)
		 	.success(function(data, status, headers, config) {
		 		ng.mensagens('alert-success','<strong>'+msg+'</strong>');
		 		$('form').hide();
   				btn.button('reset');
		 		ng.reset();

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
		 		}
		 	});
	}

	ng.removeError = function(){
		$($(".has-error").find(".form-control")).tooltip('destroy');
		$(".has-error").tooltip('destroy');
		$(".has-error").css({border:"none",background: 'none'}).addClass('has-error');
		$(".has-error").parent().css({'background':'none'});
		$(".has-error").tooltip('destroy');
		$(".has-error").removeClass("has-error");
	}

	ng.editar = function(item) {
		ng.cliente = angular.copy(item);
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

	ng.mensagens = function(classe , msg){
		$('.alert-sistema').fadeIn().addClass(classe).html(msg);

	}

	ng.loadEmpreendimento = function(id_empreendimento) {
		aj.get(baseUrlApi()+"empreendimento/"+id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.empreendimento = data;
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.empreendimento = [];
			});
	}

	ng.loadEstados();
	ng.loadComoEncontrou();
	ng.loadPerfil();
	ng.loadFinalidades();
	ng.loadBancos();
	//ng.loadClientes(0,10);
	//ng.loadEmpreendimento(ng.userLogged.id_empreendimento);
});
