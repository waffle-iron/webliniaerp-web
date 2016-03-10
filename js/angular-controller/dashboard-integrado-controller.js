app.controller('DashboardIntegradoController', function($scope, $http, $window, UserService) {
	$scope.userLogged = UserService.getUserLogado();

	//Sparkline
	$('#faturamentoChart').sparkline([15,19,20,22,33,27,31,27,19,30,21,10,15,18,25,9], {
		type: 'bar', 
		barColor: '#3C8DBC',	
		height:'35px',
		weight:'96px'
	});

	$('#despesasChart').sparkline([220,160,189,156,201,220,104,242,221,111,164,242,183,165], {
		type: 'bar', 
		barColor: '#FC8675',	
		height:'35px',
		weight:'96px'
	});

	$('#lucroChart').sparkline([220,160,189,156,201,220,104,242,221,111,164,242,183,165], {
		type: 'bar', 
		barColor: '#65CEA7',	
		height:'35px',
		weight:'96px'
	});

	var lineChart = Morris.Line({
		element: 'lineChart',
		data: [
			{ y: '2016-01', a: 30,  b: 20 },
			{ y: '2016-02', a: 45,  b: 35 },
			{ y: '2016-03', a: 60,  b: 60 },
			{ y: '2016-04', a: 75,  b: 65 },
			{ y: '2016-05', a: 50,  b: 70 },
			{ y: '2016-06', a: 80,  b: 85 },
			{ y: '2016-07', a: 100, b: 90 }
		],
		xkey: 'y',
		grid: false,
		ykeys: ['a', 'b'],
		labels: ['Receitas', 'Despesas'],
		lineColors: ['#8CB4BC', '#538792'],
		gridTextColor : '#fff'
	});

	//Number Animation
	var faturamentoNumber = $('#faturamentoNumber').text();

	$({numberValue: 0}).animate({numberValue: faturamentoNumber}, {
		duration: 1000,
		easing: 'linear',
		step: function() {
			$('#faturamentoNumber').text(Math.ceil(this.numberValue));
		}
	});

	var despesasNumber = $('#despesasNumber').text();

	$({numberValue: 0}).animate({numberValue: despesasNumber}, {
		duration: 1000,
		easing: 'linear',
		step: function() {
			$('#despesasNumber').text(Math.ceil(this.numberValue));
		}
	});

	var lucroNumber = $('#lucroNumber').text();

	$({numberValue: 0}).animate({numberValue: lucroNumber}, {
		duration: 1000,
		easing: 'linear',
		step: function() {
			$('#lucroNumber').text(Math.ceil(this.numberValue));
		}
	});

	$scope.modernBrowsers = [
	    { icon: "<img src=assets/imagens/logos/logo.jpg />",            name: "Hage Suplementos",              maker: "(Opera Software)",        ticked: true  },
	    { icon: "<img src=assets/imagens/logos/logo_azul.png />",   	name: "Weblinia",  maker: "(Microsoft)",             ticked: true },
	    { icon: "<img src=assets/imagens/logos/logo_force_fit.png />",  name: "ForceFit Suplementos",            maker: "(Mozilla Foundation)",    ticked: true  },
	    { icon: "<img src=assets/imagens/logos/Modelo_Clube_D.png />",  name: "Loja Clube D",             maker: "(Apple)",                 ticked: true },
	    { icon: "<img src=assets/imagens/logos/Modelo_Clube_D.png />",  name: "Loja Clube D",             maker: "(Apple)",                 ticked: true },
	    { icon: "<img src=assets/imagens/logos/Modelo_Clube_D.png />",  name: "Loja Clube D",             maker: "(Apple)",                 ticked: true },
	    { icon: "<img src=assets/imagens/logos/Modelo_Clube_D.png />",  name: "Loja Clube D",             maker: "(Apple)",                 ticked: true },
	    { icon: "<img src=assets/imagens/logos/Modelo_Clube_D.png />",  name: "Loja Clube D",             maker: "(Apple)",                 ticked: true },
	    { icon: "<img src=assets/imagens/logos/Modelo_Clube_D.png />",  name: "Loja Clube D",             maker: "(Apple)",                 ticked: true }
	]; 

	$('#container').highcharts({
        title: {
            text: null
        },
        xAxis: {
            categories: ['01', '02', '03', '04', '05']
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Receitas',
            color: '#65cea7',
            type: 'column',
            data: [5, 3, 4, 7, 2]
        }, {
            name: 'Despesas',
            color: '#fc8675',
            type: 'column',
            data: [-2, -2, -3, -2, -1]
        }, {
            name: 'Saldo',
            color: '#6bafbd',
            type: 'spline',
            data: [3, 1, 1, 5, 1]
        }]
    });
});