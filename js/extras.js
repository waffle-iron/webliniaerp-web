
document.write(unescape("%3Cscript src='js/constants.js' type='text/javascript'%3E%3C/script%3E"));

function printDiv(id, pg) {
    var contentToPrint, printWindow;

    contentToPrint = window.document.getElementById(id).innerHTML;
    printWindow = window.open(pg);

    printWindow.document.write("<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet'>");
    printWindow.document.write("<link href='css/font-awesome.min.css' rel='stylesheet'>");
    printWindow.document.write("<link href='css/pace.css' rel='stylesheet'>");
    printWindow.document.write("<link href='css/endless.min.css' rel='stylesheet'>");
    printWindow.document.write("<link href='css/endless-skin.css' rel='stylesheet'>");

    printWindow.document.write("<style type='text/css' media='print'>@page { size: portrait; } th, td { font-size: 8pt; } </style>");

    printWindow.document.write(contentToPrint);

    printWindow.window.print();
    printWindow.document.close();
    printWindow.focus();
}

function formatDate(dta) {
    var arr_date_first = dta.split('/');
    if(arr_date_first.length == 1)
        var arr_date_first = dta.split('-');

    var date= arr_date_first[2]+'-'+arr_date_first[1]+'-'+arr_date_first[0];

    return date;
}

function uiDateFormat(dta,format){
    dta   = dta.replace(/\//g,'');
    if(format == '99-99-999')
        return dta.substring(4)+"-"+dta.substring(2,4)+"-"+dta.substring(0,2);
    else if(format == '99/99/999'){
        console.log(dta.substring(0,2)+"-"+dta.substring(2,4)+"-"+dta.substring(4));
        return dta.substring(0,2)+"/"+dta.substring(2,4)+"/"+dta.substring(4);
    }
}

function formatDateBR(dta) {
    var arr_date_first = dta.split(' ');
    arr_date_first = arr_date_first[0];
    arr_date_first = arr_date_first.split('-');
    var date= arr_date_first[2]+'/'+arr_date_first[1]+'/'+arr_date_first[0];

    return date;
}

function numdias(mes,ano) {
    if((mes<8 && mes%2==1) || (mes>7 && mes%2==0)) return 31;
    if(mes!=2) return 30;
    if(ano%4==0) return 29;
    return 28;
}

function somadias(data, dias) {
   data=data.split('/');
   diafuturo=parseInt(data[0])+dias;
   mes=parseInt(data[1]);
   ano=parseInt(data[2]);
   while(diafuturo>numdias(mes,ano)) {
       diafuturo-=numdias(mes,ano);
       mes++;
       if(mes>12) {
           mes=1;
           ano++;
       }
   }

   if(diafuturo<10) diafuturo='0'+diafuturo;
   if(mes<10) mes='0'+mes;

   return diafuturo+"/"+mes+"/"+ano;
}

function subtraiData(dataAtual, dias) {
    var myDate = new Date(dataAtual);
    var dayOfMonth = myDate.getDate();
    myDate.setDate(dayOfMonth - dias);

    return(myDate.toISOString().substr(0,10));
}

function getDate(op,day,format){
    var dataAtual = new Date();
    var dayOfMonth = dataAtual.getDate();

    if(op == '-')
        dataAtual.setDate(dayOfMonth - day);
    else if(op == '+')
        dataAtual.setDate(dayOfMonth + day);

    if(dataAtual.getDate() < 10 ){
        var dia =  '0' + dataAtual.getDate();
    }else{
        var dia = dataAtual.getDate();
    }

    if((dataAtual.getMonth()+1) < 10){
        var mes = '0' + (dataAtual.getMonth()+1);
    }else{
        var mes =  dataAtual.getMonth()+1;
    }

    var ano = dataAtual.getFullYear();
    var hora = dataAtual.getHours();
    var minuto = dataAtual.getMinutes();
    var segundo = dataAtual.getSeconds();

    if(format == null)
         var data = ano+'-'+mes+'-'+dia;
    else if(format = 'pt')
         var data = dia+'/'+mes+"/"+ano;

    return data ;
}

function cloneArray(arr,arr_exceto){
    var arr_saida = {} ;
    $.each(arr,function(a,val){
        if(!in_array(a,arr_exceto))
            arr_saida[a] = val;
    });

    return arr_saida;

}

function in_array(val,arr){
    var b = false ;
    $.each(arr,function(a,value){
        if(val == value){
            b = true
        }
    });
    return b ;
}

function ultimoDiaDoMes(ObjetoDate){
    return (new Date(ObjetoDate.getFullYear(), ObjetoDate.getMonth() + 1, 0) ).getDate();
}


function numberFormat(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k).toFixed(prec);
        };

        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }

        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }

        var vlr = s.join(dec);
        return $.isNumeric(vlr) ? Number(vlr) : vlr ;
}

// function getUrlVars()
// {
//     var vars = [], hash;

//     var url =  window.location.href.split("#");
//      if(url.length > 1)
//          var hashes = url[0].slice(window.location.href.indexOf('?') + 1).split('&');
//      else
//      var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
//     for(var i = 0; i < hashes.length; i++)
//     {
//         hash = hashes[i].split('=');
//         //vars.push(hash[0]);
//         vars[hash[0]] = hash[1];
//     }

//     return vars;
// }

function getUrlVars()
{
    var vars = {}, hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars[hash[0]] = hash[1];
    }

    return vars;
}

function empty(vlr,zero){
    zero = zero == null ? true : false ;
    if((vlr == undefined || vlr == null || vlr == '' || vlr == 0) && (zero) )
        return true;
    else if(isNaN(Number(vlr))){
        if(vlr == undefined || vlr == null || vlr == '')
            return true;
        else
            return false;
    }
    else
        return false;
}

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla>47 && tecla<58)) return true;
    else{
        if (tecla==8 || tecla==0) return true;
    else  return false;
    }
}

function SomenteNumeroLetras(e){
     var tecla=(window.event)?event.keyCode:e.which;
    var value = String.fromCharCode(tecla);
    var caracteresIlegais = /[\W_]/; 
    if(caracteresIlegais.test(value) && value != ' ') return false ;
    else return true ;
}

function getFirstDateOfMonthString() {
    var dtaAtual = new Date();
    var actualMonth = parseInt(dtaAtual.getMonth() + 1);
    if(actualMonth < 10)
        actualMonth = "0" + actualMonth;
    var actualYear = dtaAtual.getFullYear();

    return "01/" + actualMonth + "/" + actualYear;
}

function getLastDateOfMonthString() {
    var dtaAtual = new Date();
    var actualMonth = parseInt(dtaAtual.getMonth() + 1);
    if(actualMonth < 10)
        actualMonth = "0" + actualMonth;
    var actualYear = dtaAtual.getFullYear();
    var lastDay = parseInt(ultimoDiaDoMes(new Date()));
    if(lastDay < 10)
        lastDay = "0" + lastDay;

    return lastDay + "/" + actualMonth + "/" + actualYear;
}

function getFirstDateOfMonth() {
    var dtaAtual = new Date();
    var actualMonth = parseInt(dtaAtual.getMonth() + 1);
    if(actualMonth < 10)
        actualMonth = "0" + actualMonth;
    var actualYear = dtaAtual.getFullYear();

    return new Date(actualYear + "/" + actualMonth + "/01");
}

function getLastDateOfMonth() {
    var dtaAtual = new Date();
    var actualMonth = parseInt(dtaAtual.getMonth() + 1);
    if(actualMonth < 10)
        actualMonth = "0" + actualMonth;
    var actualYear = dtaAtual.getFullYear();
    var lastDay = parseInt(ultimoDiaDoMes(new Date()));
    if(lastDay < 10)
        lastDay = "0" + lastDay;

    return new Date(actualYear + "/" + actualMonth + lastDay);
}

function NOW(format){
    format = format == null ? 'pt-br' : 'en' ;
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; 
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd;
    } 

    if(mm<10) {
        mm='0'+mm;
    } 

    today = format == 'pt-br' ? dd+'/'+mm+'/'+yyyy : yyyy+'-'+mm+'-'+dd;
    return today;
}

String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/g,"");
}

//left trim
String.prototype.ltrim = function () {
    return this.replace(/^\s+/,"");
}

//right trim
String.prototype.rtrim = function () {
    return this.replace(/\s+$/,"");
}

$(function(){
    $('#invoicePrint').on("click", function() {
        printDiv("main-container", "");
    });
});

 function FormatMilhar(value,groupSeparator){
        var num = value.length == undefined ? value.toString() : num ;
        var groupSeparator = groupSeparator == null ? '.' : groupSeparator ;       
        if(num.length > 3){
             return  num.substr(0, num.length - 3) + groupSeparator + num.substr(num.length - 3);
        }else{
            return num ;
        }
 }

 function roundNumber (rnum) {

   return Math.round(rnum*Math.pow(10,2))/Math.pow(10,2);

}

 function removerAcentos( newStringComAcento ) {
  var string = newStringComAcento.toLowerCase();
    var mapaAcentosHex  = {
        a : /[\xE0-\xE6]/g,
        e : /[\xE8-\xEB]/g,
        i : /[\xEC-\xEF]/g,
        o : /[\xF2-\xF6]/g,
        u : /[\xF9-\xFC]/g,
        c : /\xE7/g,
        n : /\xF1/g
    };
 
    for ( var letra in mapaAcentosHex ) {
        var expressaoRegular = mapaAcentosHex[letra];
        string = string.replace( expressaoRegular, letra );
    }
 
    return string.replace( /\s/g, '' ).toUpperCase();
}

 function removerAcentosSAT(newStringComAcento) {
  var string = newStringComAcento.toLowerCase();
  var mapaAcentosHex  = {
    a : /[\xE0-\xE6]/g,
    e : /[\xE8-\xEB]/g,
    i : /[\xEC-\xEF]/g,
    o : /[\xF2-\xF6]/g,
    u : /[\xF9-\xFC]/g,
    c : /\xE7/g,
    n : /\xF1/g
  };
 
  for ( var letra in mapaAcentosHex ) {
    var expressaoRegular = mapaAcentosHex[letra];
    string = string.replace( expressaoRegular, letra );
  }
  string = string.replace(/[^0-9A-Za-z ]/g,"");
  return string.toUpperCase();
}

Date.prototype.addHoras = function(horas){
    this.setHours(this.getHours() + horas)
};
Date.prototype.addMinutos = function(minutos){
    this.setMinutes(this.getMinutes() + minutos)
};
Date.prototype.addSegundos = function(segundos){
    this.setSeconds(this.getSeconds() + segundos)
};
Date.prototype.addDias = function(dias){
    this.setDate(this.getDate() + dias)
};
Date.prototype.addMeses = function(meses){
    this.setMonth(this.getMonth() + meses)
};
Date.prototype.addAnos = function(anos){
    this.setYear(this.getFullYear() + anos)
};

function parseJSON (jsonString){
    try {
        var o = jQuery.parseJSON(jsonString);
        if (o && typeof o === "object" && o !== null) return o;
    }
    catch (e) { }
    return jsonString;
};

function isCPF(strCPF) {strCPF = ""+strCPF;strCPF = strCPF.replace(/\./g, '').replace(/\-/g, ''); ;var Soma; var Resto; Soma = 0; if (strCPF == "00000000000") return false; for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); Resto = (Soma * 10) % 11; if ((Resto == 10) || (Resto == 11)) Resto = 0; if (Resto != parseInt(strCPF.substring(9, 10)) ) return false; Soma = 0; for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i); Resto = (Soma * 10) % 11; if ((Resto == 10) || (Resto == 11)) Resto = 0; if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false; return true; }

function isCnpj(str){
    str = str.replace('.','');
    str = str.replace('.','');
    str = str.replace('.','');
    str = str.replace('-','');
    str = str.replace('/','');
    cnpj = str;
    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    digitos_iguais = 1;
    if (cnpj.length < 14 && cnpj.length < 15)
        return false;
    for (i = 0; i < cnpj.length - 1; i++)
        if (cnpj.charAt(i) != cnpj.charAt(i + 1))
    {
        digitos_iguais = 0;
        break;
    }
    if (!digitos_iguais)
    {
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--)
        {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--)
        {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}

function Utf8Decode(strUtf) {
    // note: decode 3-byte chars first as decoded 2-byte strings could appear to be 3-byte char!
    if(!empty(strUtf)){
        strUtf = ""+strUtf;
        var strUni = strUtf.replace(
            /[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g,  // 3-byte chars
            function(c) {  // (note parentheses for precedence)
                var cc = ((c.charCodeAt(0)&0x0f)<<12) | ((c.charCodeAt(1)&0x3f)<<6) | ( c.charCodeAt(2)&0x3f);
                return String.fromCharCode(cc); }
        );
        strUni = strUni.replace(
            /[\u00c0-\u00df][\u0080-\u00bf]/g,                 // 2-byte chars
            function(c) {  // (note parentheses for precedence)
                var cc = (c.charCodeAt(0)&0x1f)<<6 | c.charCodeAt(1)&0x3f;
                return String.fromCharCode(cc); }
        );
        return strUni;
    }else
        return strUtf ;
}

function Utf8Encode(strUni) {
     if(!empty(strUni)){
        strUni = ""+strUni;
        var strUtf = strUni.replace(
            /[\u0080-\u07ff]/g,  // U+0080 - U+07FF => 2 bytes 110yyyyy, 10zzzzzz
            function(c) {
                var cc = c.charCodeAt(0);
                return String.fromCharCode(0xc0 | cc>>6, 0x80 | cc&0x3f); }
        );
        strUtf = strUtf.replace(
            /[\u0800-\uffff]/g,  // U+0800 - U+FFFF => 3 bytes 1110xxxx, 10yyyyyy, 10zzzzzz
            function(c) {
                var cc = c.charCodeAt(0);
                return String.fromCharCode(0xe0 | cc>>12, 0x80 | cc>>6&0x3F, 0x80 | cc&0x3f); }
        );
        return strUtf;
    }else
        return strUni;

}

function round(vlr,dec){
    return Number(accounting.toFixed(vlr,dec));
}

function _in(str_compare,str_values){
    str_compare = str_compare+"";
    var  arr =  str_values.split(',');
    var ret = false ;
    $.each(arr,function(i,x){
        x = x+"";
        if(x == str_compare){
            ret = true ;
            return ;
        }
    });  
    return ret ;       
}
function not_in(str_compare,str_values){
    str_compare = str_compare+"";
    var  arr =  str_values.split(',');
    var ret = true ;
    $.each(arr,function(i,x){
        x = x+"";
        if(x == str_compare){
            ret = false ;
            return ;
        }
    });  
    return ret ;       
}

function groupObjByQtd(arr,qtd){
    var index = 0 ;
    var count = 1;
    var aux = [] ;
    $.each(arr,function(i,x){
        if(typeof aux[index] == 'undefined') aux[index] = [] ;
        aux[index].push(x);
        if(count == qtd){
            index ++;
            count = 1 ;
        }else
            count ++ ;
    });
    return aux ;
}