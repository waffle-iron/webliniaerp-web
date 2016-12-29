var Utils = {
	getBaseUrlWeb: function(){
		var pos   = window.location.pathname.lastIndexOf("/");
		var pasta = "";

		if(location.hostname == 'localhost' || window.location.hostname.indexOf("192.168.") != -1)
			pasta = "/webliniaerp-web";

		return location.protocol+'//'+location.hostname+pasta+'/';
	},
	getBaseUrlApi: function(){
	    if(location.hostname.indexOf("192.168.") != -1)
	        return "http://"+ location.hostname +"/webliniaerp-api/";
		else if(location.hostname == 'localhost')
			return "http://localhost/webliniaerp-api/";
		else
			return location.protocol+'//'+location.hostname+location.pathname+'api/';
	}
};

var APIService = {
	getEmpreendimentosAtivos: function() {
		var items = null;
		$.ajax({
			url: Utils.getBaseUrlApi() +'/empreendimentos/ativos',
			async: false,
			success: function(data) {
				items = data;
			},
			error: function(error) {
				console.error(error);
			}
		});
		return items;
	}
}

var empreendimentosAtivos = APIService.getEmpreendimentosAtivos();

console.log(empreendimentosAtivos);