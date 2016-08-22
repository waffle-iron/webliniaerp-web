app.controller('OrdemServicoController', function($scope, $http, $window, $dialogs, UserService, ConfigService, AsyncAjaxSrvc){
	$scope.userLogged 			= UserService.getUserLogado();
	$scope.configuracoes 		= ConfigService.getConfig($scope.userLogged.id_empreendimento);
	$scope.status_ordem_servico = AsyncAjaxSrvc.getListOfItens(baseUrlApi()+'status/atendimento');;
	$scope.status_servico 		= AsyncAjaxSrvc.getListOfItens(baseUrlApi()+'status/procedimento');;
	$scope.busca 				= { clientes: "", 	servicos: "", 	produtos: "" 	};
	$scope.paginacao			= { clientes: null, servicos: null, produtos: null 	};

	$scope.showBoxNovo = function(clearData){
    	$scope.editing = !$scope.editing;
		$('#box-novo').toggle(0,function(){$("select").trigger("chosen:updated");});
		if(clearData) {
			clearValidationFormStyle();
			clearObject();
		}
	}

	$scope.showModal = function(modal, objectDestination) {
		$scope.modalSelectDestination = objectDestination;
		switch(modal) {
			case 'list_clientes':
				$scope.loadClientes(0, 10);
				break;
			case 'list_servicos':
				$scope.loadServicos(0, 10);
				break;
			case 'list_produtos':
				$scope.loadProdutos(0, 10);
				break;
		}
		
		$("#"+ modal).modal("show");
	}

	$scope.loadClientes = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;

		$scope.clientes = [];

		var query_string = "?(tue->id_empreendimento[exp]=="+ $scope.userLogged.id_empreendimento +"&usu->id[exp]= NOT IN("+ $scope.configuracoes.id_cliente_movimentacao_caixa +","+ $scope.configuracoes.id_usuario_venda_vitrine +"))";

		if($scope.busca.clientes != ""){
			query_string += "&"+$.param({'(usu->nome':{exp:"like'%"+$scope.busca.clientes+"%' OR usu.apelido LIKE '%"+$scope.busca.clientes+"%')"}});
		}

		$http.get(baseUrlApi()+"usuarios/"+ offset +"/"+ limit +"/"+ query_string)
			.success(function(data, status, headers, config) {
				$.each(data.usuarios,function(i,item){
					if(!empty($scope.objectModel.cliente) && $scope.objectModel.cliente.id === item.id)
						item[$scope.modalSelectDestination+'_selected'] = true;
					else
						item[$scope.modalSelectDestination+'_selected'] = false;

					$scope.clientes.push(item);
				});

				$scope.paginacao.clientes = [];

				$.each(data.paginacao,function(i,item){
					$scope.paginacao.clientes.push(item);
				});
			})
			.error(function(data, status, headers, config) {
				$scope.clientes = false;
			});
	}

	$scope.selectCliente = function(item){
		$("#list_clientes").modal("hide");
		$scope.objectModel[$scope.modalSelectDestination] = item;
		if($scope.modalSelectDestination === 'cliente') {
			$http.get(baseUrlApi()+"usuarios/saldodevedor/"+ $scope.userLogged.id_empreendimento +"?usu->id="+ item.id)
				.success(function(data, status, headers, config) {
					$scope.objectModel.cliente.vlr_saldo_devedor = data.vlr_saldo_devedor;
				})
				.error(function(data, status, headers, config) {
					console.log('erro ao consultar saldo do cliente');
				});
		}
	}

	$scope.loadServicos = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 10 : limit;

		$scope.servicos = [];

		var query_string = "?id_empreendimento="+ $scope.userLogged.id_empreendimento;

		if($scope.busca.servicos != "")
			query_string += "&"+$.param({'dsc_procedimento':{exp:"like'%"+$scope.busca.servicos+"%'"}});

		$http.get(baseUrlApi()+"clinica/procedimentos/"+ offset +"/"+ limit +"/"+ query_string)
			.success(function(data, status, headers, config) {
				$.each(data.procedimentos,function(i,item){
					if(!empty(_.findWhere($scope.objectModel.servicos, { cod_procedimento: item.cod_procedimento})))
						item.selected = true;
					else
						item.selected = false;

					$scope.servicos.push(item);
				});
				
				$scope.paginacao.servicos = [];

				$.each(data.paginacao,function(i,item){
					$scope.paginacao.servicos.push(item);
				});
			})
			.error(function(data, status, headers, config) {
				$scope.servicos = false ;
			});
	}

	$scope.selectServico = function(item) {
		item.cod_status_servico = 1;
		$scope.objectModel.servicos.push(item);
		$scope.recalculaTotais();
		$("#list_servicos").modal("hide");
	}

	$scope.loadProdutos = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;

    	var query_string = "?group=&emp->id_empreendimento="+$scope.userLogged.id_empreendimento;

    	if($scope.busca.produtos != ""){
    		query_string += "&"+$.param({'prd->nome':{exp:"like'%"+$scope.busca.produtos+"%' OR fab.nome_fabricante like'%"+$scope.busca.produtos+"%'"}});
    	}

		$scope.produtos = [];
		$http.get(baseUrlApi()+"estoque/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				$.each(data.produtos, function(i, item) {
					if(!empty(_.findWhere($scope.objectModel.produtos, { id: item.id})))
						item.selected = true;
					else
						item.selected = false;

					$scope.produtos.push(item);
				});
				$scope.paginacao.produtos 	= data.paginacao;
			})
			.error(function(data, status, headers, config) {
				$scope.produtos = [];
			});
	}

	$scope.selectProduto = function(item) {
		if(empty(item.qtd_pedido))
			item.qtd_pedido = 1;
		$scope.objectModel.produtos.push(item);
		$scope.recalculaTotais();
		$("#list_produtos").modal("hide");
	}

	$scope.removeItem = function(item, objectOwner) {
		$scope.objectModel[objectOwner] = _.without($scope.objectModel[objectOwner], item);
		$scope.recalculaTotais();
		updateView(100);
	}

	$scope.recalculaTotais = function() {
		$scope.objectModel.vlr_total_servicos = _.reduce($scope.objectModel.servicos, function(value, item){
			return value + item.vlr_procedimento;
		}, 0);

		$scope.objectModel.vlr_total_produtos = _.reduce($scope.objectModel.produtos, function(value, item){
			return value + (parseInt(item.qtd_pedido, 10) * item.vlr_venda_varejo);
		}, 0);

		$scope.objectModel.qtd_total_produtos = _.reduce($scope.objectModel.produtos, function(value, item){
			return value + parseInt(item.qtd_pedido, 10);
		}, 0);

		$scope.objectModel.vlr_total_os = ($scope.objectModel.vlr_total_servicos + $scope.objectModel.vlr_total_produtos);
	}

	$scope.abrirCaixa = function() {
   		$http.get(baseUrlApi()+"pedido_venda/abrir_caixa/"+ $scope.configuracoes.id_caixa_padrao +"/"+ $scope.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				$scope.caixa = data;
			})
			.error(function(data, status, headers, config) {
				alert(data);
			});
	}

	$scope.save = function() {
		clearValidationFormStyle();

		var postData = angular.copy($scope.objectModel);
			postData.id_abertura_caixa 	= $scope.caixa.id;
			postData.id_plano_conta 	= $scope.configuracoes.id_plano_caixa;
			postData.dta_ordem_servico 	= moment(postData.dta_ordem_servico, 'DD/MM/YYYY HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');

		$http.post(baseUrlApi()+"ordem-servico", postData)
			.success(function(data, status, headers, config) {
				$scope.showBoxNovo(true);
			})
			.error(function(errors, status, headers, config) {
				if(status === 406) {
					$('.alert-form.alert-warning').text("Atenção! Alguns campos obrigatórios não foram preenchidos.").removeClass('hide');
					applyFormErrors(errors, 'objectModel');
				} else {
					$('.alert-form.alert-danger').text(errors).removeClass('hide');
				}
			});
	}

	function clearObject() {
		$scope.objectModel = {
			criador: $scope.userLogged,
			id_empreendimento: $scope.userLogged.id_empreendimento,
			cod_status_servico: 4,
			servicos: [],
			produtos: [],
			vlr_total_servicos: 0,
			vlr_total_produtos: 0,
			vlr_total_os: 0,
			dta_ordem_servico: moment().format('DD/MM/YYYY HH:mm:ss')
		};
	}

	clearObject();
	$scope.abrirCaixa();

	$('#sizeToggle').trigger("click");
});
