app.controller('ControleMesasController', function($scope, $http, $window, UserService) {
	var ng = $scope,
		aj = $http;

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
});