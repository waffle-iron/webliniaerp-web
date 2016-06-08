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

	ng.userLogged = UserService.getUserLogado();
	$('#sizeToggle').trigger("click");

	ng.mesas = [
		{
			vlr_total_mesa: 0,
			flg_livre: true,
			qtd_comandas_abertas: 0
		},{
			vlr_total_mesa: 137.68,
			flg_livre: false,
			qtd_comandas_abertas: 7
		},{
			vlr_total_mesa: 963.97,
			flg_livre: false,
			qtd_comandas_abertas: 4
		},{
			vlr_total_mesa: 0,
			flg_livre: true,
			qtd_comandas_abertas: 0
		},{
			vlr_total_mesa: 963.97,
			flg_livre: false,
			qtd_comandas_abertas: 4
		},{
			vlr_total_mesa: 963.97,
			flg_livre: true,
			qtd_comandas_abertas: 4
		},{
			vlr_total_mesa: 867.77,
			flg_livre: false,
			qtd_comandas_abertas: 1
		},{
			vlr_total_mesa: 963.97,
			flg_livre: false,
			qtd_comandas_abertas: 4
		},{
			vlr_total_mesa: 0,
			flg_livre: true,
			qtd_comandas_abertas: 0
		},{
			vlr_total_mesa: 963.97,
			flg_livre: false,
			qtd_comandas_abertas: 4
		},{
			vlr_total_mesa: 963.97,
			flg_livre: false,
			qtd_comandas_abertas: 4
		}
	]

	ng.changeTela = function(tela){
		if(!empty(tela)){
			$.each(ng.layout,function(i,x){
				if(x) ng.telaAnterior = i ;
				ng.layout[i] = false ;
			});

			ng.layout[tela] = true ;
		}
	}
});