app.service('UserService', function($http, $window) {
	var aj = $http;

	this.KEY_USER_LOGGED 			= "KEY_USER_LOGGED";
	this.KEY_MEUS_EMPREENDIMENTOS 	= "KEY_MEUS_EMPREENDIMENTOS";

	this.getUserLogado = function() {
		var user = {};
		if(empty(sessionStorage.user)){
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
			 		user.modulosAssociatePage 	= usuario.modulosAssociatePage;
			 		user.perc_venda 			= usuario.perc_venda;
			 		user.empreendimento_usuario = usuario.empreendimento_usuario;
			 		user.flg_dispositivo 		= (!empty(usuario.flg_dispositivo) ? usuario.flg_dispositivo : null );

			 	},
			 	error: function(error) {
			 		console.log(error);
			 	}
			 });
			sessionStorage.user = angular.toJson(user);
		}else
			user = parseJSON(sessionStorage.user) ;
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
		$window.sessionStorage.removeItem('user');
		$window.sessionStorage.removeItem('funcionalidades');
	}
});

app.service('FuncionalidadeService', function($http) {
	this.getIdModulo = function(){
		var aux = parseJSON(sessionStorage.user) ;
		modulos = aux.modulosAssociatePage ;
		var page = location.pathname.substring(location.pathname.lastIndexOf("/") + 1) ;
		if(!empty(modulos[page])){
			return modulos[page].id_modulo;
		}
		else return null
	}
	this.getIdsPerfisAuthorizedByModulo = function(id_empreendimento,associativo) {
		associativo = empty(associativo) ? 'false' : (associativo === true ? 'true' : 'false' ) ; 
		id_modulo = this.getIdModulo();
		var modulosFuncionalidades = (empty(sessionStorage.funcionalidades) ? [] : parseJSON(sessionStorage.funcionalidades)) ;
		var funcionalidades = empty(modulosFuncionalidades[id_modulo]) ? null : modulosFuncionalidades[id_modulo] ; 
		if(funcionalidades == null) {
			$.ajax({
				url: baseUrlApi() + "modulo/funcionalidades/id_perfis/"+id_modulo+"/"+id_empreendimento+"/"+associativo,
				async: false,
				success: function(items) {
					funcionalidades = items ;
				},
				error: function(error) {
					funcionalidades = [-1] ;
					console.log(error);
				}
			});
			modulosFuncionalidades[id_modulo] = funcionalidades ;
			sessionStorage.funcionalidades = angular.toJson(modulosFuncionalidades) ;
		}
		return funcionalidades;
	};

	this.Authorized = function(cod_funcionalidade,id_perfil,id_empreendimento){
		var funcionalidades = this.getIdsPerfisAuthorizedByModulo(id_empreendimento,true);
		funcionalidades = empty(funcionalidades) ? [] : funcionalidades ;
		var funcionalidade = empty(funcionalidades[cod_funcionalidade]) ? [] : funcionalidades[cod_funcionalidade] ;
		return _in(id_perfil,funcionalidade) ;
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


