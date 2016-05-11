app.controller('RelatorioVendasCategoriaCtrl', function($scope, $http, $window, UserService) {
	var ng 				= $scope;
		aj 				= $http;
	ng.userLogged 		= UserService.getUserLogado();
	ng.itensPorPagina 	= 10;
	ng.paginacao 	   	= {};
	ng.busca			= {}
	ng.busca.categorias  	= '';
	ng.items 			= [];

	ng.reset = function() {
		 $("#dtaInicial").val('');
		 $("#dtaFinal").val('');
		 ng.categoria = {} ;
		 ng.busca.categorias = '' ;
	}

	ng.resetFilter = function() {
		ng.reset();
		ng.loadVendas();
	}

	ng.aplicarFiltro = function() {
		$("#modal-aguarde").modal('show');
		ng.loadVendas();
	}

	ng.qtd_total_vendida = 0;
	ng.vlr_total_vendida = 0;
	ng.loadVendas = function(_id_categoria, _dtaInicial, _dtaFinal) {
		ng.qtd_total_vendida = 0;
		ng.vlr_total_vendida = 0;
		ng.items = [];

		var id_categoria 	= (_id_categoria != "" && !isNaN(_id_categoria)) ? _id_categoria : (!isNaN(ng.categoria.id) ? ng.categoria.id : "");
		var dtaInicial  	= (_dtaInicial != undefined && _dtaInicial != "") ? _dtaInicial : $("#dtaInicial").val();
		var dtaFinal    	= (_dtaFinal != undefined && _dtaFinal != "") ? _dtaFinal : $("#dtaFinal").val();
		
		var queryString 	= "?id_empreendimento="+ ng.userLogged.id_empreendimento;

		if(dtaInicial != "" && dtaFinal != ""){
			dtaInicial = formatDate(dtaInicial);
			dtaFinal   = formatDate(dtaFinal);
			if(dtaInicial > dtaFinal){
				$("#modal-aguarde").modal('hide');
				ng.mensagens('alert-danger','<strong>A data inicial deve ser menor que a final</strong>','.errorBusca');
				return;
			}
			queryString += "&dtaInicial="+ dtaInicial +"&dtaFinal="+ dtaFinal;
		}
		
		queryString += "&id_categoria="+ id_categoria;
		
		aj.get(baseUrlApi()+"relatorio/vendas/consolidado/categoria/"+ queryString)
			.success(function(data, status, headers, config) {
				ng.items = data.vendas;

				$.each(ng.items, function(i,item){
					ng.qtd_total_vendida += parseInt(item.qtd_total_vendida, 10);
					ng.vlr_total_vendida += parseFloat(item.vlr_total_vendida);
				});

				$("#modal-aguarde").modal('hide');

			})
			.error(function(data, status, headers, config) {
				ng.items = null;
				$("#modal-aguarde").modal('hide');
			});
	}

	ng.showCategorias = function(){
   		ng.busca.categorias = "" ;
   		ng.loadCategorias(0,10);
   		$('#list_categorias').modal('show');
   	}

   	ng.loadCategorias = function(offset,limit) {
		offset = offset == null ? 0  : offset;
    	limit  = limit  == null ? 20 : limit;

    	var query_string = "?id_empreendimento="+ng.userLogged.id_empreendimento;

    	if(ng.busca.categorias != ""){
    		query_string += "&("+$.param({'descricao_categoria':{exp:"like'%"+ng.busca.categorias+"%'"}})+")";
    	}

		ng.categorias = [];
		aj.get(baseUrlApi()+"categorias/"+offset+"/"+limit+"/"+query_string)
			.success(function(data, status, headers, config) {
				ng.categorias        	= data.categorias;
				ng.paginacao.categorias = data.paginacao;
			})
			.error(function(data, status, headers, config) {
				ng.categorias = [];
			});
	}

	ng.selectCategoria = function(item){
		ng.categoria = item ;
		$('#list_categorias').modal('hide');
	}

	ng.mensagens = function(classe , msg,alertClass){
		alertClass = alertClass == null  ? '.alert-sistema' : alertClass ;
		$(alertClass).fadeIn().addClass(classe).html(msg);
		setTimeout(function(){
			$('.alert-sistema').fadeOut('slow');
		},5000);
	}

	ng.reset();
	$("#modal-aguarde").modal('show');
	ng.loadVendas(getUrlVars().id_categoria, getUrlVars().dtaInicial, getUrlVars().dtaFinal);

	ng.categoria.id = getUrlVars().id_categoria;
	ng.categoria.descricao_categoria = decodeURI(getUrlVars().nme_categoria);
	$("#dtaInicial").val(getUrlVars().dtaInicial);
	$("#dtaFinal").val(getUrlVars().dtaFinal);
});

app.directive('bsPopover', function () {
    return function (scope, element, attrs) {
        element.find("a[rel=popover]").popover({
            placement: 'bottom',
            html: 'true'
        });
    };
});

