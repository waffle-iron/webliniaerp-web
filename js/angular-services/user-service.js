app.service('UserService', function($http, $window) {
	var aj = $http;

	this.KEY_USER_LOGGED 			= "KEY_USER_LOGGED";
	this.KEY_MEUS_EMPREENDIMENTOS 	= "KEY_MEUS_EMPREENDIMENTOS";

	this.getUserLogado = function() {
		var user = {};

		 $.ajax({
		 	url: baseUrl() + "get_session.php",
		 	async: false,
		 	success: function(usuario) {
		 		user.id 					= usuario.id;
		 		user.id_empreendimento 		= usuario.id_empreendimento;
		 		user.nme_usuario 			= usuario.nome;
		 		user.end_email 				= usuario.email;
		 		user.id_perfil 				= usuario.id_perfil;
		 		user.nome_empreendimento 	= usuario.nome_empreendimento;
		 		user.nme_logo 				= usuario.nme_logo;
		 		user.flg_dispositivo 		= (!empty(usuario.flg_dispositivo) ? usuario.flg_dispositivo : null );

		 	},
		 	error: function(error) {
		 		console.log(error);
		 	}
		 });
		sessionStorage.user = angular.toJson(user);
		return user;
	}

	this.getMeusEmpreendimentos = function(id_usuario) {
		var empreendimentos = this.getSessionData(this.KEY_MEUS_EMPREENDIMENTOS);
		var serviceScope = this;
		if(empreendimentos == null) {
			$.ajax({
				url: baseUrlApi() + "empreendimentos?id_usuario="+id_usuario,
				async: false,
				success: function(items) {
					empreendimentos = items;
					
					serviceScope.setSessionData(serviceScope.KEY_MEUS_EMPREENDIMENTOS, items);
				},
				error: function(error) {
					console.log(error);
				}
			});
		}

		return empreendimentos;
	};

	this.getSessionData = function(key) {
		var value = $window.sessionStorage.getItem(key);
		
		if(!value)
			return null;
		
		return JSON.parse(value);
	};

	this.setSessionData = function(key, value) {
		$window.sessionStorage.setItem(key, JSON.stringify(value));
	};

	this.clearSessionData = function() {
		$window.sessionStorage.removeItem(this.KEY_USER_LOGGED);
		$window.sessionStorage.removeItem(this.KEY_MEUS_EMPREENDIMENTOS);
	}
});

app.service('ConfigService', function($http) {
	this.getConfig = function(id_empreendimento) {
		var configuracoes ;
		 $.ajax({
		 	url: baseUrlApi()+"configuracoes/"+id_empreendimento,
		 	async: false,
		 	success: function(config) {
		 		configuracoes = config ;
		 	},
		 	error: function(error) {
		 		console.log(error);
		 	}
		 });
		return configuracoes ;
	}
});

app.service('NFService', function($http) {
	this.getNota = function(id_empreendimento,id_venda) {
		var nota  = false ;;
		 $.ajax({
		 	url: baseUrlApi()+"nota_fiscal/?cod_empreendimento="+id_empreendimento+"&cod_venda="+id_venda,
		 	async: false,
		 	success: function(dados) {
		 		nota = dados ;
		 	},
		 	error: function(error) {
		 		console.log(error);
		 	}
		 });
		return nota ;
	}
});

app.service('CaixaService', function($http) {
	this.getCaixaAberto = function(id_empreendimento,pth_local,id_usuario) {
		var caixa ;
		 $.ajax({
		 	url: baseUrlApi()+"caixa/aberto/"+id_empreendimento+"/"+pth_local+"/"+id_usuario,
		 	async: false,
		 	success: function(data) {
		 		caixa = data ;
		 	},
		 	error: function(error) {
		 		console.log(error);
		 	}
		 });
		return caixa ;
	}
});


