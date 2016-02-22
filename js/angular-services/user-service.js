app.service('UserService', function($http) {
	var aj = $http;

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

		 	},
		 	error: function(error) {
		 		console.log(error);
		 	}
		 });
		sessionStorage.user = angular.toJson(user);
		return user;
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


