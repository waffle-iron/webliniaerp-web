var paramModule = ['ui.mask','ui.bootstrap','dialogs','filters','angularTreeview','net.enzey.autocomplete'] ;
if(!(typeof addParamModule == "undefined") && addParamModule.length > 0)
	paramModule = paramModule.concat(addParamModule);
var app = angular.module('HageERP', paramModule , function($httpProvider) {
	// Use x-www-form-urlencoded Content-Type
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

	var param = function(obj) {
		var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

		for(name in obj) {
			value = obj[name];

			if(value instanceof Array) {
				for(i=0; i<value.length; ++i) {
					subValue = value[i];
					fullSubName = name + '[' + i + ']';
					innerObj = {};
					innerObj[fullSubName] = subValue;
					query += param(innerObj) + '&';
				}
			}
			else if(value instanceof Object) {
				for(subName in value) {
					subValue = value[subName];
					fullSubName = name + '[' + subName + ']';
					innerObj = {};
					innerObj[fullSubName] = subValue;
					query += param(innerObj) + '&';
				}
			}
			else if(value !== undefined && value !== null)
				query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
		}

		return query.length ? query.substr(0, query.length - 1) : query;
	};

	$httpProvider.defaults.transformRequest = [function(data) {
		return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
	}];
 });

angular.module('filters', [])
	.filter('numberFormat', function () {
		return function (number, decimals, dec_point, thousands_sep) {
			number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		    var n = !isFinite(+number) ? 0 : +number,
		    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		    s = '',
		    toFixedFix = function(n, prec) {
		      var k = Math.pow(10, prec);
		      return '' + (Math.round(n * k) / k)
		        .toFixed(prec);
		    };
		  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
		   s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		   if (s[0].length > 3) {
		    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		   }
		  if ((s[1] || '')
		    .length < prec) {
		    s[1] = s[1] || '';
		    s[1] += new Array(prec - s[1].length + 1)
		      .join('0');
		  }
		  return s.join(dec);
	    };
	}).filter('Utf8Decode', function () {
		return function (inputFormat) {
			if(inputFormat != undefined)
				return Utf8Decode(inputFormat);
			else
				return null;
		}
	})
	.filter('dateFormat', function () {
		return function (inputFormat,tipo) {
		  	function pad(s) { return (s < 10) ? '0' + s : s; }
		  if (empty(inputFormat)) return "" ;
		  if(inputFormat.length < 6){
		  	return "" ;
		  }else if(inputFormat == '0000-00-00'){
		  	return "" ;
		  }else if(tipo == 'date-m/y'){;
		  	if(inputFormat.length == 6)
		  		return inputFormat.substring(0,2)+'/'+inputFormat.substring(2,6);
		  	else{
		  		var arr = inputFormat.split('-');
		  		return arr[1]+'/'+arr[0];
		  	}
		  }

		  inputFormat = inputFormat.replace(/-/g,"/");
		  var d = new Date(inputFormat);
		  if(tipo == null || tipo == "dateTime"){
		  	var hora = d.getHours() < 10 ? '0'+d.getHours() : d.getHours() ;
		  	var minutos = d.getMinutes() < 10 ? '0'+d.getMinutes() : d.getMinutes() ;
		  	var segundos = d.getSeconds() < 10 ? '0'+d.getSeconds() : d.getSeconds() ;

		  	return pad(d.getDate())+'/'+pad(d.getMonth()+1)+'/'+d.getFullYear()+' '+hora+':'+minutos+':'+segundos;
		  }else if(tipo=="time"){
		  	var hora = d.getHours() < 10 ? '0'+d.getHours() : d.getHours() ;
		  	var minutos = d.getMinutes() < 10 ? '0'+d.getMinutes() : d.getMinutes() ;
		  	var segundos = d.getSeconds() < 10 ? '0'+d.getSeconds() : d.getSeconds() ;
		  	return hora+':'+minutos+':'+segundos;
		  }
	      else
	      	return pad(d.getDate())+'/'+pad(d.getMonth()+1)+'/'+d.getFullYear();
	    };
	})
	.filter('maskCpf', function () {
		return function (inputFormat) {
			if(empty(inputFormat) || inputFormat.length != 11 ){
				return inputFormat ;
			}
			var cpf = inputFormat ;
			return cpf.substring(0,3)+"."+cpf.substring(3,6)+"."+cpf.substring(6,9)+"-"+cpf.substring(9,11) ;
	    };
	})
	.filter('maskCnpj', function () {
		return function (inputFormat) {
			if(empty(inputFormat) || inputFormat.length != 14 ){
				return inputFormat ;
			}
			var cnpj = inputFormat ;
			return cnpj.substring(0,2)+"."+cnpj.substring(2,5)+"."+cnpj.substring(5,8)+"/"+cnpj.substring(8,12)+"-"+cnpj.substring(12,14) ;
	    };
	})
	.filter('phoneFormat', function () {
		return function (inputFormat) {
			if(empty(inputFormat)){
				return "" ;
			}
			inputFormat = ""+inputFormat;
			if(empty(inputFormat)){
				return "" ;
			}
			var ddd = inputFormat.substring(0,2);
			var telefone = inputFormat.substring(2,inputFormat.length);
			var part1, part2;

			if(telefone.length == 9) {
				part1 = telefone.substring(0,5);
				part2 = telefone.substring(5,telefone.length);
			} else {
				part1 = telefone.substring(0,4);
				part2 = telefone.substring(4,telefone.length);
			}

			telefone = part1 +"-"+ part2;

			return "("+ ddd +") "+ telefone;
	    };
	})
	.filter('cpfFormat', function () {
		return function (inputFormat,prefix) {
			inputFormat = ""+inputFormat;
			if(inputFormat.length == 11){
				prefix = empty(prefix) ? '' : prefix ;
				if(inputFormat.length != 11 && $.isNumeric(inputFormat)){
					return "" ;
				}
				var cpf = inputFormat.substring(0,3)+'.'+inputFormat.substring(3,6)+'.'+inputFormat.substring(6,9)+'-'+inputFormat.substring(9,11);

				return prefix+cpf ;
			}else{
				return '' ;
			}

	    };
	})
	.filter('cnpjFormat', function () {
		return function (inputFormat,prefix) {
			inputFormat = ""+inputFormat;
			if(inputFormat.length == 14){
				prefix = empty(prefix) ? '' : prefix ;
				var cnpj = inputFormat.substring(0,2)+'.'+inputFormat.substring(2,5)+'.'+inputFormat.substring(5,8)+'/'+inputFormat.substring(8,12)+'-'+inputFormat.substring(12,14);

				return prefix+cnpj ;
			}else{
				return '' ;
			}

	    };
	})
	.directive('thousandsFormatter', function ($filter) {
	    var precision = 2;
	    return {
	        require: 'ngModel',
	              link: function (scope, element, attrs, ctrl) {

	            ctrl.$formatters.push(function (data) {
	            	if(data != null && data != undefined){
		                var formatted = $filter('numberFormat')(data,2,',','.');
		                $(element).val(formatted);
		                if(formatted != '0,00' )
		                	return formatted;
		                else{
		                	ctrl.$setViewValue('0');
		                	ctrl.$render();
		                	return '0,00';
		                }
	            	}else
	            		return '';
	            });

	            element.bind('focusout', function (event) {
		       		if(element.val() == '0,00')
		       			element.val('');
	            });

	            element.bind('focusin', function (event) {
		       		if(element.val() == '')
		       			element.val('0,00');
	            });

	            ctrl.$parsers.push(function (data) {
	                var plainNumber = data.replace(/[^\d|\-+|\+]/g, '');
	                var length = plainNumber.length;
	                var intValue = plainNumber.substring(0,length-precision);
	                var decimalValue = plainNumber.substring(length-precision,length)
	                var plainNumberWithDecimal = intValue + '.' + decimalValue;
	                //convert data from view format to model format
	                var formatted = $filter('numberFormat')(plainNumberWithDecimal,2,',','.');
	                element.val(formatted);

	                return isNaN(Number(plainNumberWithDecimal)) ? 0 : Number(plainNumberWithDecimal);
	            });
	        }
	    };
	})
	.directive('maskMoeda', function ($filter) {
	    var precision = 2;
	    return {
	        require: 'ngModel',
	              link: function (scope, element, attrs, ctrl) {

	            ctrl.$formatters.push(function (data) {
	            	if(data != null && data != undefined){
		                var formatted = $filter('numberFormat')(data,2,',','.');
		                $(element).val(formatted);
		                if(formatted != '0,00' )
		                	return formatted;
		                else{
		                	ctrl.$setViewValue('0');
		                	ctrl.$render();
		                	return '0,00';
		                }
	            	}else
	            		return '';
	            });

	            /*element.bind('focusout', function (event) {
		       		if(element.val() == '0,00')
		       			element.val('');
	            });*/

	            element.bind('focusin', function (event) {
		       		if(Number(ctrl.viewValue) == 0)
		       			element.val('0,00');
	            });

	            ctrl.$parsers.push(function (data) {
	            	if(data == "")
	            		return null ;
	                var plainNumber = data.replace(/[^\d|\-+|\+]/g, '');
	                if(Number(plainNumber) == 0){
	                	element.val('0.00');
	                	return 0 ;
	                }
	                var length = plainNumber.length;
	                var intValue = plainNumber.substring(0,length-precision);
	                var decimalValue = plainNumber.substring(length-precision,length)
	                var plainNumberWithDecimal = intValue + '.' + decimalValue;
	                //convert data from view format to model format
	                var formatted = $filter('numberFormat')(plainNumberWithDecimal,2,',','.');
	                element.val(formatted);

	                return isNaN(Number(plainNumberWithDecimal)) ? 0 : Number(plainNumberWithDecimal);
	            });
	        }
	    };
	})
	.directive('datePicker', function ($filter) {
	    return {
	        require: 'ngModel',
	            link: function (scope, element, attrs, ctrl) {
	            $(element).datepicker().on('changeDate', function(e) {
	            	ctrl.$viewValue = e.date;
               		ctrl.$commitViewValue();
               		ctrl.$setViewValue(e.date);
               		ctrl.render ;
			    });
	            ctrl.$parsers.push(function (data) {
	            	var data = $(element).val();
	            	if(data.length == 10)
	            		return formatDate(data) ;
	            });
	        }
	    };
	})
	.directive('controlSizeString', function ($filter) {
	    return {
	    	link:function(scope,element,attrs,ctrl){
	    		var size = Number(attrs.size);
	    		if(attrs.content.length > size){
	    			element.html( attrs.content.substring(0,size)+' <a style="cursor:pointer;color:black" class="controlSizeString-active">...</a>' );
		    		var trigger = empty(attrs.trigger) ? 'hover' : attrs.trigger ;
		    		var container = empty(attrs.container) ? 'body' : attrs.container;
		    		var title     = empty(attrs.title) ? false : attrs.title ;
		    		var placement = empty(attrs.placement) ? 'top' : attrs.placement;

		    		var config = {
						title: ( title==false ? '' : title ) ,
		                placement: placement ,
		                content: attrs.content ,
		                html: true,
		                container: container,
		                trigger  :trigger
		            }
		            if(title == false)
		           	 config.template =  '<div class="popover"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p></p></div></div></div>'
	    			$('.controlSizeString-active',element).popover(config).popover();
	    		}else{
	    			element.html((attrs.content))
	    		}
	    	}
	    }
	}).directive('initPopover', function ($compile,$filter) {
	    return {
	    	link:function(scope,element,attrs,ctrl){
		    		var trigger = empty(attrs.trigger) ? 'click' : attrs.trigger ;
		    		var container = empty(attrs.container) ? 'body' : attrs.container;
		    		var title     = empty(attrs.title) ? false : attrs.title ;
		    		var placement = empty(attrs.placement) ? 'top' : attrs.placement;

		    		var config = {
						title: ( title==false ? '' : title ) ,
		                placement: placement ,
		                content:  $compile($(attrs.content))(scope) ,
		                html: true,
		                container: container,
		                trigger  :trigger
		            }
		            if(title == false)
		           	 config.template =  '<div class="popover"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p></p></div></div></div>'
	    			$(element).popover(config).popover();
	    		
	    	}
	    }
	}).directive('preLoadImg', function ($compile,$filter) {
	    return {
	    	link:function(scope,element,attrs,ctrl){
			   //Coloque no atributo IMG o caminho (src) da imagem clicada
				$(element).attr('src',attrs.imgpreload);
				//$(element).fadeIn(300);
				//Agora faça a leitura do arquivo usando o atributo .load() da imagem
				//$(element).load(function(response, status, xhr) {
					//console.log(response);
					//Após acabar a leitura faça a imagem aparecer
					//$(element).fadeIn(300);
				//});
				$(element).after('<img style="display:none" class="pre-load-img-cache" src="'+attrs.datasrc+'"/>')
				$(element).next('.pre-load-img-cache').on('load', function() {
					$(element).attr('src',attrs.datasrc);
					$(element).next('.pre-load-img-cache').remove();
				})
			    .on('error', function() {
			    	$(element).attr('src',attrs.notimg);
			    })
	    	}
	    }
	});

function Ctrl($scope) {
    $scope.currencyVal;
}

String.prototype.splice = function(idx, rem, s) {
    return (this.slice(0, idx) + s + this.slice(idx + Math.abs(rem)));
};

(function(l) {
    l.module("angularTreeview", []).directive("treeModel", function($compile) {
        return {
            restrict: "A",
            link: function(a, g, c) {
                var e = c.treeModel,
                    h = c.nodeLabel || "label",
                    d = c.nodeChildren || "children",
                    k = '<ul><li data-ng-repeat="node in ' + e + '"><i class="collapsed" data-ng-show="node.' + d + '.length && node.collapsed" data-ng-click="selectNodeHead(node, $event)"></i><i class="expanded" data-ng-show="node.' + d + '.length && !node.collapsed" data-ng-click="selectNodeHead(node, $event)"></i><i class="normal" data-ng-hide="node.' +
                    d + '.length"></i> <span data-ng-class="node.selected" data-ng-click="selectNodeLabel(node, $event)">{{node.' + h + '}}</span><div data-ng-hide="node.collapsed" data-tree-model="node.' + d + '" data-node-id=' + (c.nodeId || "id") + " data-node-label=" + h + " data-node-children=" + d + "></div></li></ul>";
                e && e.length && (c.angularTreeview ? (a.$watch(e, function(m, b) {
                    g.empty().html($compile(k)(a))
                }, !1), a.selectNodeHead = a.selectNodeHead || function(a, b) {
                    b.stopPropagation && b.stopPropagation();
                    b.preventDefault && b.preventDefault();
                    b.cancelBubble = !0;
                    b.returnValue = !1;
                    a.collapsed = !a.collapsed
                }, a.selectNodeLabel = a.selectNodeLabel || function(c, b) {
                    b.stopPropagation && b.stopPropagation();
                    b.preventDefault && b.preventDefault();
                    b.cancelBubble = !0;
                    b.returnValue = !1;
                    a.currentNode && a.currentNode.selected && (a.currentNode.selected = void 0);
                    c.selected = "selected";
                    a.currentNode = c
                }) : g.html($compile(k)(a)))
            }
        }
    })
})(angular);

app.directive('syncFocusWith', function($timeout, $rootScope) {
    return {
        restrict: 'A',
        scope: {
            focusValue: "=syncFocusWith"
        },
        link: function($scope, $element, attrs) {
            $scope.$watch("focusValue", function(currentValue, previousValue) {
                if (currentValue === true && !previousValue) {
                    $element[0].focus();
                } else if (currentValue === false && previousValue) {
                    $element[0].blur();
                }
            })
        }
    }
});

app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});

app.directive('bsTooltip', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            $timeout(function () {
                	  element.find("[data-toggle=tooltip]").tooltip();
            });
        }
    }
});

app.controller('MasterController', function($scope, $http, $window, UserService) {
	var ng = $scope,
		aj = $http;

	ng.userLogged = UserService.getUserLogado();
	ng.meusEmpreendimentos = UserService.getMeusEmpreendimentos(ng.userLogged.id);
	
	ng.logout = function() {
		UserService.clearSessionData();
		window.location.href = "logout.php";
	}

	ng.changeEmpreendimento = function(empSelected) {
		var url = "util/login/login.php?";
			url += "id_empreendimento=" 	+ empSelected.id;
			url += "&nome_empreendimento=" 	+ empSelected.nome_empreendimento;
			url += "&nickname=" 			+ empSelected.nickname;
			url += "&nme_logo=" 			+ empSelected.nme_logo;
			url += "&id_perfil=" 			+ ng.userLogged.id_perfil;
			url += "&id=" 					+ ng.userLogged.id;
			url += "&end_email=" 			+ ng.userLogged.end_email;
			url += "&nme_usuario=" 			+ ng.userLogged.nme_usuario;

		aj.get(url)
			.success(function(data, status, headers, config) {
				UserService.clearSessionData();
				window.location.reload();
			})
			.error(function(data, status, headers, config) {
				alert('Desculpe, ocorreu um erro inesperado !!!');
			});

		return false;
	};
	
	ng.openModalMeusEmpreendimentos = function(){
		$(".modal.meus-empreendimentos").modal("show");
	}
});

app.controller('AlertasController', function($scope, $http, $window, UserService) {
	var ng = $scope,
		aj = $http;
	ng.userLogged = UserService.getUserLogado();
	ng.itensVencidos = [];
	ng.itensVencer = [];
	ng.itensEstoqueMinimo = [];
	ng.paginacao = {};
	ng.alertas = [];
	ng.count = {
		orcamentos : 0
	};
	ng.loadCountOrcamentos = function(first_date,last_date) {
		var vlrTotalVendasPeriodoComparativo = 0 ;
		aj.get(baseUrlApi()+"count_orcamentos/dashboard?id_empreendimento="+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.count.orcamentos = data.total_orcamentos  ;

				if(ng.count.orcamentos > 0) {
					ng.alertas.push({
						type: 'danger',
						message: "Você tem "+ ng.count.orcamentos +" orçamentos para validar!",
						link: "vendas.php?status=orcamento"
					});
				}
			})
			.error(function(data, status, headers, config) {
				ng.count.orcamentos  = 0 ;
			});
	}

	ng.loadProdutosVencidos = function() {
		aj.get(baseUrlApi()+"produtos/vencidos/"+ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.itensVencidos = data.produtos;

				if(ng.itensVencidos.length > 0) {
					var msg;

					if(ng.itensVencidos.length == 1) {
						msg = '1 produto venceu há '+ ng.itensVencidos[0].qtd_dias_vencido +' dias';
					}
					else {
						var qtd = 0;

						$.each(ng.itensVencidos, function(i, item) {
							qtd += item.qtd_item;
						});

						msg = qtd + ' produtos vencidos no estoque';
					}

					ng.alertas.push({
						type: 'danger',
						message: msg,
						link: "rel_produtos_vencidos.php"
					});
				}
			})
			.error(function(data, status, headers, config) {
				arr = null;
			});
	}

	ng.loadProdutosVencer = function() {
		aj.get(baseUrlApi()+"produtos/vencer/"+ ng.userLogged.id_empreendimento +"/30")
			.success(function(data, status, headers, config) {
				ng.itensVencer = Object.keys(data.produtos).map(function(key){return data.produtos[key]});
				//ng.itensVencer = data.produtos;

				if(ng.itensVencer.length > 0) {
					var qtd = 0;

					$.each(ng.itensVencer, function(i, item) {
						qtd += item.qtd_item;
					});

					var msg = qtd +' prod. vence nos próx. 30 dias';;

					ng.alertas.push({
						type: 'warning',
						message: msg,
						link: "rel_produtos_vencer.php"
					});
				}
			})
			.error(function(data, status, headers, config) {
				arr = null;
			});
	}

	ng.loadProdutosEstoqueMinimo = function() {
		aj.get(baseUrlApi()+"produtos/estoque/minimo?id_empreendimento="+ ng.userLogged.id_empreendimento)
			.success(function(data, status, headers, config) {
				ng.itensEstoqueMinimo = data;

				if(ng.itensEstoqueMinimo.length > 0) {
					var msg = ng.itensEstoqueMinimo.length +' prod. abaixo do estoque mínimo';;

					ng.alertas.push({
						type: 'warning',
						message: msg,
						link: "rel_produtos_estoque_minimo.php"
					});
				}
			})
			.error(function(data, status, headers, config) {
				arr = null;
			});
	}

	ng.loadPedidosTransferenciaRecebido = function() {
		var vlrTotalVendasPeriodoComparativo = 0 ;
		aj.get(baseUrlApi()+"transferencias/estoque/?id_empreendimento_transferencia="+ng.userLogged.id_empreendimento+"&id_status_transferencia=1")
			.success(function(data, status, headers, config) {
				if(data.length > 0) {
					ng.alertas.push({
						type: 'warning',
						message: "Você tem "+ data.length +" "+ (data.length == 1 ? 'pedido' : 'pedidos' ) + " de transferência de estoque",
						link: "pedido_transferencia_recebido.php"
					});
				}
			})
			.error(function(data, status, headers, config) {
				ng.count.orcamentos  = 0 ;
			});
	}

	ng.loadPedidosTransferenciaTransporte = function() {
		var vlrTotalVendasPeriodoComparativo = 0 ;
		aj.get(baseUrlApi()+"transferencias/estoque/?id_empreendimento_pedido="+ng.userLogged.id_empreendimento+"&id_status_transferencia=2")
			.success(function(data, status, headers, config) {
				if(data.length > 0) {
					ng.alertas.push({
						type: 'warning',
						message: "Você tem "+ data.length +" "+ (data.length == 1 ? 'pedido' : 'pedidos' ) + " de transferência de estoque em transporte",
						link: "pedido_transferencia.php"
					});
				}
			})
			.error(function(data, status, headers, config) {
				ng.count.orcamentos  = 0 ;
			});
	}

	ng.loadCountOrcamentos(formatDate(getFirstDateOfMonthString()), formatDate(getLastDateOfMonthString()));
	ng.loadProdutosVencidos();
	ng.loadProdutosVencer();
	ng.loadProdutosEstoqueMinimo();
	ng.loadPedidosTransferenciaRecebido();
	ng.loadPedidosTransferenciaTransporte();
});

app.directive('bsTooltip', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            $timeout(function () {
                	  element.find("[data-toggle=tooltip]").tooltip();
            });
        }
    }
});


/*app.factory('httpRequestInterceptor',function () {
  var user = angular.fromJson(sessionStorage.user);
  console.log(user);
  return {
    request: function (config) {
      //config.headers['Authorization'] = 'Basic d2VudHdvcnRobWFuOkNoYW5nZV9tZQ==';
      config.headers['Empreendimento'] = user.id_empreendimento;
      return config;
    }
  };
});

app.config(function ($httpProvider) {
  $httpProvider.interceptors.push('httpRequestInterceptor');
});*/
