var AMBIENTE = 'CLIENTES';
function baseUrl(){
	var pos   = window.location.pathname.lastIndexOf("/");
	var pasta = "";
	if(window.location.hostname == "localhost"){
		pasta = "/webliniaerp-web";
	}
	return location.protocol+'//'+location.hostname+pasta+'/';
}

function baseUrlApi(){
    if(location.hostname.indexOf("192.168.") != -1)
        return "http://"+ location.hostname +"/webliniaerp-api/";
	else if(location.hostname == 'localhost')
		return "http://localhost/webliniaerp-api/";
	else {
		return location.protocol+'//'+location.hostname+location.pathname+'api/';
	}
	//return 'http://www.webliniaerp.com.br/api/';
}
