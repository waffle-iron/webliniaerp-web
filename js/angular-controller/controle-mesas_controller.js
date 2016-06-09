app.controller('ControleMesasController', function($scope, $http, $window, UserService) {
	var ng = $scope,
		aj = $http;
	ng.layout = { 
		mesas:true,
		detMesa:false,
		SelCliente:false,
		cadCliente:false,
		detComanda:false,
		detItemComanda:false 
	} ;
	ng.telaAnterior = null ;
	ng.mesas = [];
	ng.mesaSelecioada = {} ;
	ng.busca = {} ;

	ng.userLogged = UserService.getUserLogado();
	$('#sizeToggle').trigger("click");

	ng.changeTela = function(tela){
		if(!empty(tela)){
			$.each(ng.layout,function(i,x){
				if(x) ng.telaAnterior = i ;
				ng.layout[i] = false ;
			});

			ng.layout[tela] = true ;
		}
	}

	ng.loadMesas = function(offset,limit){
		offset = offset ==  null ? 0 : offset ; 
		limit  = limit  ==  null ? 10 : limit ;
		aj.get(baseUrlApi()+"mesas/resumo/?cplSql=WHERE tm.id_empreendimento="+ng.userLogged.id_empreendimento)
		.success(function(data, status, headers, config) {
			ng.mesas = data;
		})
		.error(function(data, status, headers, config) {
		
		}); 
	}

	ng.abrirMesa = function(mesa){
		ng.changeTela('detMesa');
		ng.mesaSelecioada = angular.copy(mesa);
	}

	var interval_busca_clientes = null ;
	ng.autoCompleteCliente = function(busca){
		 clearInterval(interval_busca_clientes);
		 if(!empty(busca)){
			 interval_busca_clientes = setTimeout(function(){
			 	ng.loadClientes(busca);
			 },500);
		}else
			ng.clientes = [] ;
	}

	ng.loadClientes = function(busca){
		ng.clientes = null ;
		busca = angular.copy(busca);
		var url = "usuarios?tue->id_empreendimento="+ng.userLogged.id_empreendimento;
		var query_string = "";
		if(!empty(busca)){
			var buscaCpf  = busca.replace(/\./g, '').replace(/\-/g, '');
			var buscaCnpj = busca.replace(/\./g, '').replace(/\-/g, '').replace(/\//g,'');
			busca = busca.replace(/\s/g, '%');
			query_string += "&"+$.param({"(usu->nome":{exp:"like'%"+busca+"%' OR usu.apelido like '%"+busca+"%' OR tpj.cnpj like '%"+buscaCnpj+"%' OR tpf.cpf like '%"+buscaCpf+"%')"}})+"";
		}
		aj.get(baseUrlApi()+url+query_string)
		.success(function(data, status, headers, config) {
			ng.clientes = data.usuarios ;
		})
		.error(function(data, status, headers, config) {
			ng.clientes = [];
		}); 
	}

	ng.loadMesas();
});