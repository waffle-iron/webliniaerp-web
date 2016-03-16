app.controller('AgendamentoConsultaController', function($scope, $http, $window, $dialogs, UserService, ConfigService){

	var ng = $scope ,
		aj = $http;
	$scope.userLogged = UserService.getUserLogado();
	ng.configuracoes = ConfigService.getConfig(ng.userLogged.id_empreendimento);

	function loadCalendar() {
		$('#calendar').fullCalendar({
			height: 500,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay',
			},
			events: [
				{
					title: 'Limpeza',
					start: '2016-03-08T10:30:00',
					end: '2016-03-08T11:30:00',
					color: '#6BAFBD'
				},{
					title: 'Limpeza',
					start: '2016-03-08T11:40:00',
					end: '2016-03-08T12:40:00',
					color: '#FC8675'
				},{
					title: 'Limpeza',
					start: '2016-03-08T12:50:00',
					end: '2016-03-08T13:50:00',
					color: '#65CEA7'
				},{
					title: 'Limpeza',
					start: '2016-03-08T14:00:00',
					end: '2016-03-08T15:00:00',
					color: '#F3CE85'
				},{
					title: 'Limpeza',
					start: '2016-03-08T15:10:00',
					end: '2016-03-08T16:10:00',
					color: '#424F63'
				}
			],
			defaultView: 'agendaWeek',
			defaultDate: NOW('en'),
			lang: 'pt-br',
			editable: false,
			eventLimit: true // allow "more" link when too many events,
		});
	}

	loadCalendar();
});