app.controller('PerfisController', function($scope, $http, $window, $dialogs, UserService){
	var ng = $scope
		aj = $http;

	ng.baseUrl 		= baseUrl();
	ng.userLogged 	= UserService.getUserLogado();
	var perfilTO = {nome:null,status:true,id_empreendimento:ng.userLogged.id_empreendimento,modulos:[]};
	ng.perfil = perfilTO ;
    ng.editing = false;
    ng.busca = {perfis:""};
    ng.currentPag = {
    	perfis:{
    		offset:0,
    		limit:10
    	}
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
					$('html,body').animate({scrollTop: 0},'slow');
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

	ng.reset = function() {
		ng.perfil = perfilTO ;
	}
	var $checkableTree  ;
	ng.treeviewConstruct = function(data){
			$checkableTree = $('#treeview-modulos').treeview({
	          data: data,
	          showIcon: false,
	          expandIcon: 'glyphicon glyphicon-chevron-right',
	          collapseIcon: 'glyphicon glyphicon-chevron-down',
	          showCheckbox: true,
	          showBorder: false,
	          selectedBackColor: "white",
	          selectedColor: "#777",
	          onhoverColor:false,
	          onNodeChecked: function(event, node) {
	          	$scope.$apply(function () {
		           ng.perfil.modulos.push(node.id_modulo);
		        });	
	          },
	          onNodeUnchecked: function (event, node) {
	            var index = ng.perfil.modulos.indexOf(node.id_modulo);
	            $scope.$apply(function () {
	           	   ng.perfil.modulos.splice(index,1);
	        	});
	          },
	        }).treeview('collapseAll', { silent: true });
	}

	ng.subMenuConstruct = function(arrpai,arr){
		var menu = [] ;
		$.each(arr,function(key,value){
			if(arrpai.id_modulo == value.id_modulo_pai){
				var item = {
					id_modulo : value.id_modulo,
					text : value.nme_modulo,
					nodes : ng.subMenuConstruct(value,arr),
					icone : value.icn_modulo
				};	
				if(item.nodes.length == 0) delete item.nodes ;
				menu.push(item);	
			}
		});

		return menu ;
	}

	ng.menuConstruct = function(Modulos){
		var menu = [] ;
		$.each(Modulos,function(key,value){
			if(empty(value.id_modulo_pai)){
				var itens = ng.subMenuConstruct(value,Modulos)
				if(itens.length > 0){
					menu.push({
						id_modulo : value.id_modulo,
						text : value.nme_modulo,
						nodes : ng.subMenuConstruct(value,Modulos),
						icone : "fa-signal",
						selectable:false
					});	
				}else{
					menu.push({
						id_modulo : value.id_modulo,
						text : value.nme_modulo,
						icone : "fa-signal",
						selectable:false
					});			
				}
				
			}
		});

		return menu ;
	}

	ng.loadModulos = function() {
		aj.get(baseUrlApi()+"modulos/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				var menu = ng.menuConstruct(data);
				ng.treeviewConstruct(menu);
				//console.log(menu);
			})
			.error(function(data, status, headers, config) {
				if(status == 404){

				}
				
			});
	}

	ng.salvar = function(event) {
		$('#nome').removeClass('has-error');$('input','#nome').tooltip('destroy');$('#modulos').removeClass('panel-error').tooltip("destroy");
		var btn = $(event.target);
		var perfil = angular.copy(ng.perfil);
		perfil.status = Number(perfil.status); 
		btn.button('loading');
		aj.post(baseUrlApi()+"perfil/salvar",perfil)
			.success(function(data, status, headers, config) {
				btn.button('reset');
				ng.showBoxNovo();
				ng.reset();
				ng.mensagens('alert-success','<strong>Perfil cadastrado com sucesso</strong>','#alert');
				$('html,body').animate({scrollTop: $('#panel-listagem').offset().top-50 },'slow');
				ng.loadPerfis();
				return;
			})
			.error(function(data, status, headers, config) {
				btn.button('reset');
				if(status == 406){
					if(status == 406){
			 			$.each(data, function(i, item) {
			 				if(i != 'modulos'){
							$("#"+i).addClass("has-error");
							$('input',"#"+i).attr("data-toggle", "tooltip").attr("data-placement", "top").attr("title", item).attr("data-original-title", item).tooltip();
			 				}else{
			 					$("#"+i).addClass("panel-error").attr("data-toggle", "tooltip").attr("data-placement", "top").attr("title", item).attr("data-original-title", item).tooltip();
			 				}
						});
						$('html,body').animate({scrollTop: 0},'slow');
				 	}else{
				 		$dialogs.notify('Desculpe!','<strong>Acorreu um erro dutante o processo</strong>');
						return;
				 	}
				}	
				
			});
	}

	ng.perfis = {} ;
	ng.loadPerfis = function(offset,limit,posOp){
		ng.perfis.perfis = null ;
		offset = offset == null ? 0 : offset ;
		limit  = limit  == null ? 10 : limit  ;
		ng.currentPag.perfis.offset = offset;
		ng.currentPag.perfis.limit  = limit ;
		var queryString = "?id_empreendimento="+ng.userLogged;
		queryString += empty(ng.busca) ? '' : '&nome='+ng.busca ;
		aj.get(baseUrlApi()+"perfis/"+offset+"/"+limit+"?id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.perfis = data;
			})
			.error(function(data, status, headers, config) {
				if(status == 404)
					ng.perfis.perfis = [];
					ng.perfis.paginacao = [];
			});
	}

	ng.editar = function(item) {
		
	}

	ng.delete = function(){
		console.log(ng.myForm.nome.$valid);
	}

	ng.loadModulos();
	ng.loadPerfis();
});

app.directive('bsTooltip', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            $timeout(function () {
                	  element.find("[data-toggle=tooltip]").tooltip();
                	  console.log(element.find("[data-toggle=tooltip]"));
            });
        }
    }
});
