app.controller('AgendamentoConsultaController', function($scope, $http, $window, $dialogs, UserService){

	var ng = $scope
	aj = $http;

	ng.baseUrl 		= baseUrl();
	ng.userLogged 	= UserService.getUserLogado();

	var eventsElements = [] ;
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay',
		},
		defaultView: 'agendaDay',
		defaultDate: NOW('en'),
		lang: 'pt-br',
		editable: false,
		eventLimit: true,
		events: [
			{
				title: 'João Batista',
				start: '2016-02-17T11:40:00',
				end: '2016-02-17T12:30:00',
				color: '#4285F4',
				textColor: '#fff',
			},{
				title: 'Filipe Coelho',
				start: '2016-02-17T12:35:00',
				end: '2016-02-17T13:25:00',
				color: '#E94335',
				textColor: '#fff',
			},{
				title: 'Margarette Menezes',
				start: '2016-02-17T14:30:00',
				end: '2016-02-17T15:20:00',
				color: '#4285F4',
				textColor: '#fff',
			},{
				title: 'Wellington Souza',
				start: '2016-02-17T15:30:00',
				end: '2016-02-17T16:30:00',
				color: '#4285F4',
				textColor: '#fff',
			}
		]
	});

	$('#calendar-fev').fullCalendar({
		defaultDate: NOW('en'),
		lang: 'pt-br',
		editable: false,
		eventLimit: true,
		events: [
			{
				title: 'João Batista',
				start: '2016-02-17T11:40:00',
				end: '2016-02-17T12:30:00',
				color: '#4285F4',
				textColor: '#fff',
			},{
				title: 'Filipe Coelho',
				start: '2016-02-17T12:35:00',
				end: '2016-02-17T13:25:00',
				color: '#E94335',
				textColor: '#fff',
			},{
				title: 'Margarette Menezes',
				start: '2016-02-17T14:30:00',
				end: '2016-02-17T15:20:00',
				color: '#4285F4',
				textColor: '#fff',
			},{
				title: 'Wellington Souza',
				start: '2016-02-17T15:30:00',
				end: '2016-02-17T16:30:00',
				color: '#4285F4',
				textColor: '#fff',
			}
		]
	});
});