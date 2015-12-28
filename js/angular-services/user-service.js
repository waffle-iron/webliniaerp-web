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

		return user;
	}

});
