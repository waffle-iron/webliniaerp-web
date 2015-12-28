<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps?file=api"></script>
<style type="text/css" media="screen">
* { font: 20px 'Trebuchet MS'; }
</style>
</head>
<body>
    <form id="formPesquisa" method="post" action="">    
        <div>
            <p>Informe seu endereco para localizar suas coordenadas geograficas</p>
        </div>    
        <fieldset>
            <legend>Consulta de endereco:</legend>
            <label for="endereco">Informe o endereco a pesquisar:</label>
            <input style="width: 650px;" type="text" id="endereco" value="Av Manuel Velho Moreira, são Paulo, Brasil" />
            <input type="button" id="pesquisar" value="Localizar Coordenadas" />
        </fieldset>
        <div id="container-resultado">
            <ul id="resultado"></ul>
        </div>
    </form>
</body>
</html>
<script type="text/javascript">
<!--
$(document).ready(function(){
    $('#pesquisar').click(function(event){
        event.preventDefault();
        event.stopPropagation();
        $resultado = $('#resultado');
        $endereco = $('#endereco');
        _endereco = $.trim($endereco.val());
        if(_endereco.length > 0){
            $.ajax({
                url: 'https://maps.googleapis.com/maps/api/geocode/json',
                dataType: 'json',
                data: {
                    sensor: false,
                    region: 'BR',
                    address: _endereco
                },
                beforeSend: function(){
                    $resultado.html('').append('<li>Carregando! Aguarde...</li>');
                },
                success: function(response){
                    $resultado.html('');
                    $resultado.parent().prepend('<h4>Resultado da sua pesquisa:</h4>');
                    if(response.status == 'OK'){                                            
                        $resultado.append('<li><span style="font-weight:bold;">Latitude:</span>'+ response.results[0].geometry.location.lat.toString() +'</li>');
                        $resultado.append('<li><span style="font-weight:bold;">Longitude:</span>'+ response.results[0].geometry.location.lng.toString() +'</li>');
                    }
                }
            });
        }
        return false;
    });
});
//-->
</script>