<?php
	include_once "util/login/restrito.php";
	restrito();
?>
<!DOCTYPE html>
<html lang="en" ng-app="HageERP">
  <head>
    <meta charset="utf-8">
    <title>WebliniaERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
      <link rel='stylesheet prefetch' href='bootstrap/css/bootstrap.min.css'>

	<!-- Font Awesome -->
	<link href="css/font-awesome-4.1.0.min.css" rel="stylesheet">

	<!-- Pace -->
	<link href="css/pace.css" rel="stylesheet">

	<!-- Endless -->
	<link href="css/endless.min.css" rel="stylesheet">
	<link href="css/endless-skin.css" rel="stylesheet">

	<link href="css/custom.css" rel="stylesheet">

	<!-- Agenda -->
    <link href='js/agenda/fullcalendar.css' rel='stylesheet' />
    <link href='js/agenda/fullcalendar.print.css' rel='stylesheet' media='print' />

	<style type="text/css">

		/* Fix for Bootstrap 3 with Angular UI Bootstrap */

		.modal {
			display: block;
		}

		/* Custom dialog/modal headers */

		.dialog-header-error { background-color: #d2322d; }
		.dialog-header-wait { background-color: #428bca; }
		.dialog-header-notify { background-color: #eeeeee; }
		.dialog-header-confirm { background-color: #333333; }
		.dialog-header-error span, .dialog-header-error h4,
		.dialog-header-wait span, .dialog-header-wait h4,
		.dialog-header-confirm span, .dialog-header-confirm h4 { color: #ffffff; }

		/* Ease Display */

		.pad { padding: 25px; }

		@media screen and (min-width: 768px) {

			#list_proodutos.modal-dialog  {width:900px;}

		}

		#list_produtos .modal-dialog  {width:70%;}

		#list_produtos .modal-content {min-height: 640px;;}

		/*Agenda*/
		.agenda-event{
			font-weight: bold;
		}
		.fc-day-number{
			cursor: pointer;
		}

		tr.green-td td{
			background-color: rgb(154, 210, 104);
 			color: #FFF;
  		    font-weight: bold;
		}
		tr.red-td td{
			background-color: rgb(247, 71, 71);
 			color: #FFF;
  		    font-weight: bold;
		}

		/*Redimencionando PopOver*/
		.popover{
		    display:block !important;
		    max-width: 400px!important;
		    width: 400px!important;
		    width:auto;
		}



	</style>
  </head>

  <body class="overflow-hidden" ng-controller="AgendaForncedoresController" ng-cloak>
  
    <div id="content">
      <h1>ItemNotaFiscalXML</h1>
      <h2>Descrição</h2>
      <div class="docstring">
        <p>
<p>Item da nota fiscal</p>
</p>
      </div>
      <h2>Atributos</h2>
      
      
        
        
      
        
        
          
          <div class="method_details first">
            <p class="signature">
              <strong>
                numero_item
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Número (índice) do item na nota fiscal, começando por <code>1</code>.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                codigo_produto
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código interno do produto. Se não existir deve ser usado o CFOP no
formato</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                codigo_barras_comercial
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código GTIN/EAN do produto.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                descricao
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Descrição do produto.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                codigo_ncm
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código NCM do produto. É permitida a informação do gênero (posição
do</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                nves
              </strong>
              
              
                
                <span class="extras">[coleção: <a href='NveXML.html'>NveXML</a>]</span>
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Codificação NVE - Nomenclatura de Valor Aduaneiro e Estatística
(codificação opcional que detalha alguns NCM)</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                codigo_ex_tipi
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código EX TIPI do produto.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cfop
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>CFOP do produto.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                unidade_comercial
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Unidade comercial</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                quantidade_comercial
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Quantidade comercial</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                valor_unitario_comercial
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor unitário comercial.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                valor_bruto
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor bruto. Deve ser igual ao produto de Valor unitário comercial com
quantidade comercial.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                codigo_barras_tributavel
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código GTIN/EAN tributável.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                unidade_tributavel
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Unidade tributável.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                quantidade_tributavel
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Quantidade tributável.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                valor_unitario_tributavel
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor unitário tributável.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                valor_frete
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do frete.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                valor_seguro
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do seguro.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                valor_desconto
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do desconto.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                valor_outras_despesas
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor de outras despesas acessórias.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                inclui_no_total
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do item (<code>valor_bruto</code>) compõe valor total da NFe
(<code>valor_produtos</code>)?</p>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>0</code>: não</p>
</li><li>
<p><code>1</code>: sim</p>
</li></ul>

              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                documentos_importacao
              </strong>
              
              
                
                <span class="extras">[coleção: <a href='DocumentoImportacaoXML.html'>DocumentoImportacaoXML</a>]</span>
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Documentos de importação.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                detalhes_exportacao
              </strong>
              
              
                
                <span class="extras">[coleção: <a href='DetalheExportacaoXML.html'>DetalheExportacaoXML</a>]</span>
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Detalhes de exportação</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pedido_compra
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Pedido de Compra.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                numero_item_pedido_compra
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Número do Item de Pedido de Compra.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                numero_fci
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Número da FCI (Ficha de Conteúdo de Importação) veja NT 2013/006</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_tipo_operacao
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Tipo da operação.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>1</code>: venda concessionária</p>
</li><li>
<p><code>2</code>: faturamento direto</p>
</li><li>
<p><code>3</code>: venda direta</p>
</li><li>
<p><code>0</code>: outros</p>
</li></ul>

              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_chassi
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Chassi do veículo - VIN.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_codigo_cor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Cor do veículo (código de cada montadora).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_descricao_cor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Descrição da cor.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_potencia_motor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Potência máxima do motor em cavalo-vapor (CV).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_cm3
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Capacidade voluntária do motor em centímetros cúbicos</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_peso_liquido
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Peso líquido.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_peso_bruto
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Peso bruto.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_serie
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Número de série.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_tipo_combustivel
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Tipo de combustível (utilizar tabela do RENAVAM):</p>
<ul><li>
<p><code>01</code>: álcool</p>
</li><li>
<p><code>02</code>: gasolina</p>
</li><li>
<p><code>03</code>: diesel</p>
</li><li>
<p>(…)</p>
</li><li>
<p><code>16</code>: álcool/gasolina</p>
</li><li>
<p><code>17</code>: gasolina/álcool/GNV</p>
</li><li>
<p><code>18</code>: gasolina/elétrico</p>
</li></ul>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_numero_motor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Número do motor.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_cmt
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Capacidade máxima de tração em toneladas (4 casas decimais).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_distancia_eixos
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Distância entre eixos.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_ano_modelo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Ano do modelo.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_ano_fabricacao
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Ano de fabricação.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_tipo_pintura
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Tipo de pintura.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_tipo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Tipo de veículo (utilizar tabela RENAVAM).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_especie
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Espécie de veículo (utilizar tabela RENAVAM).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_codigo_vin
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Veículo tem VIN remarcado?</p>
<ul><li>
<p><code>R</code>: remarcado</p>
</li><li>
<p><code>N</code>: normal</p>
</li></ul>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_condicao
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Condição do veículo.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>1</code>: acabado</p>
</li><li>
<p><code>2</code>: inacabado</p>
</li><li>
<p><code>3</code>: semi-acabado</p>
</li></ul>

              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_codigo_marca_modelo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código Marca Modelo (utilizar tabela RENAVAM).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_codigo_cor_denatran
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código da cor segundo as regras de pré-cadastro do DENATRAN.</p>
<ul><li>
<p><code>01</code>: amarelo</p>
</li><li>
<p><code>02</code>: azul</p>
</li><li>
<p><code>03</code>: bege</p>
</li><li>
<p><code>04</code>: branca</p>
</li><li>
<p><code>05</code>: cinza</p>
</li><li>
<p><code>06</code>: dourada</p>
</li><li>
<p><code>07</code>: grena</p>
</li><li>
<p><code>08</code>: laranja</p>
</li><li>
<p><code>09</code>: marrom</p>
</li><li>
<p><code>10</code>: prata</p>
</li><li>
<p><code>11</code>: preta</p>
</li><li>
<p><code>12</code>: rosa</p>
</li><li>
<p><code>13</code>: roxa</p>
</li><li>
<p><code>14</code>: verde</p>
</li><li>
<p><code>15</code>: vermelha</p>
</li><li>
<p><code>16</code>: fantasia</p>
</li></ul>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_lotacao
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Quantidade máxima permitida de passageiros sentados, inclusive motorista.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                veiculo_restricao
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Restrição.</p>
<ul><li>
<p><code>0</code>: não há</p>
</li><li>
<p><code>1</code>: alienação fiduciária</p>
</li><li>
<p><code>2</code>: arrendamento mercantil</p>
</li><li>
<p><code>3</code>: reserva de domínio</p>
</li><li>
<p><code>4</code>: penhor de veículos</p>
</li><li>
<p><code>9</code>: outras</p>
</li></ul>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                medicamento_numero_lote
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Número do lote.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                medicamento_quantidade_lote
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Quantidade de produtos no Lote.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                medicamento_data_fabricacao
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Data de Fabricaçao do medicamento</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                medicamento_data_validade
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Data de Validade do medicamento</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                medicamento_preco_maximo_consumidor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Preço Máximo ao consumidor</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                informacoes_adicionais_item
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Informações adicionais do item</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_origem
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Origem constant id'>Origem</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_mercadoria identifier id'>mercadoria</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>0</code>: nacional</p>
</li><li>
<p><code>1</code>: estrangeira (importação direta)</p>
</li><li>
<p><code>2</code>: estrangeira (adquirida no mercado interno)</p>
</li><li>
<p><code>3</code>: nacional com mais de 40% de conteúdo estrangeiro</p>
</li><li>
<p><code>4</code>: nacional produzida através de processos produtivos
básicos</p>
</li><li>
<p><code>5</code>: nacional com menos de 40% de conteúdo estrangeiro</p>
</li><li>
<p><code>6</code>: estrangeira (importação direta) sem produto nacional
similar</p>
</li><li>
<p><code>7</code>: estrangeira (adquirida no mercado interno) sem produto
nacional similar</p>
</li></ul>

              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_situacao_tributaria
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Situa constant id'>Situa</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>00</code>: tributada integralmente</p>
</li><li>
<p><code>10</code>: tributada e com cobrança do ICMS por substituição
tributária</p>
</li><li>
<p><code>20</code>: tributada com redução de base de cálculo</p>
</li><li>
<p><code>30</code>: isenta ou não tributada e com cobrança do ICMS por
substituição tributária</p>
</li><li>
<p><code>40</code>: isenta</p>
</li><li>
<p><code>41</code>: não tributada</p>
</li><li>
<p><code>50</code>: suspensão</p>
</li><li>
<p><code>51</code>: diferimento (a exigência do preenchimento das
informações do ICMS diferido fica a critério de cada UF)</p>
</li><li>
<p><code>60</code>: cobrado anteriormente por substituição tributária</p>
</li><li>
<p><code>70</code>: tributada com redução de base de cálculo e com
cobrança do ICMS por substituição tributária</p>
</li><li>
<p><code>90</code>: outras (regime Normal)</p>
</li><li>
<p><code>101</code>: tributada pelo Simples Nacional com permissão de
crédito</p>
</li><li>
<p><code>102</code>: tributada pelo Simples Nacional sem permissão de
crédito</p>
</li><li>
<p><code>103</code>: isenção do ICMS no Simples Nacional para faixa de
receita bruta</p>
</li><li>
<p><code>201</code>: tributada pelo Simples Nacional com permissão de
crédito e com cobrança do ICMS por substituição tributária</p>
</li><li>
<p><code>202</code>: tributada pelo Simples Nacional sem permissão de
crédito e com cobrança do ICMS por substituição tributária</p>
</li><li>
<p><code>203</code>: isenção do ICMS nos Simples Nacional para faixa de
receita bruta e com cobrança do ICMS por substituição tributária</p>
</li><li>
<p><code>300</code>: imune</p>
</li><li>
<p><code>400</code>: não tributada pelo Simples Nacional</p>
</li><li>
<p><code>500</code>: ICMS cobrado anteriormente por substituição tributária
(substituído) ou por antecipação</p>
</li><li>
<p><code>900</code>: outras (regime Simples Nacional)</p>
</li></ul>

              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_modalidade_base_calculo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Modalidade constant id'>Modalidade</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_determina identifier id'>determina</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>0</code>: margem de valor agregado (%)</p>
</li><li>
<p><code>1</code>: pauta (valor)</p>
</li><li>
<p><code>2</code>: preço tabelado máximo (valor)</p>
</li><li>
<p><code>3</code>: valor da operação</p>
</li></ul>

              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_base_calculo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_base identifier id'>base</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_calculo identifier id'>calculo</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_base_calculo_retido_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_base identifier id'>base</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_c identifier id'>c</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_reducao_base_calculo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Percentual constant id'>Percentual</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_redu identifier id'>redu</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_aliquota
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Al constant id'>Al</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_valor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_valor_retido_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span> <span class='rubyid_retido identifier id'>retido</span> <span class='rubyid_anteriormente identifier id'>anteriormente</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_valor_desonerado
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span> <span class='rubyid_desonerado identifier id'>desonerado</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_valor_operacao
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='lparen token'>(</span><span class='rubyid_CST constant id'>CST</span><span class='assign token'>=</span><span class='integer val'>51</span><span class='rparen token'>)</span> <span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_como identifier id'>como</span> <span class='rubyid_se identifier id'>se</span> <span class='rubyid_n identifier id'>n</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_percentual_diferimento
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='lparen token'>(</span><span class='rubyid_CST constant id'>CST</span><span class='assign token'>=</span><span class='integer val'>51</span><span class='rparen token'>)</span> <span class='rubyid_Percentual constant id'>Percentual</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_diferimento identifier id'>diferimento</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_valor_diferido
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='lparen token'>(</span><span class='rubyid_CST constant id'>CST</span><span class='assign token'>=</span><span class='integer val'>51</span><span class='rparen token'>)</span> <span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span> <span class='rubyid_diferido identifier id'>diferido</span> <span class='lparen token'>(</span><span class='rubyid_informar identifier id'>informar</span> <span class='rubyid_o identifier id'>o</span> <span class='rubyid_valor identifier id'>valor</span> <span class='rubyid_realmente identifier id'>realmente</span> <span class='rubyid_devido identifier id'>devido</span> <span class='rubyid_no identifier id'>no</span> <span class='rubyid_campo identifier id'>campo</span> <span class='rubyid_icms_valor identifier id'>icms_valor</span><span class='rparen token'>)</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_motivo_desoneracao
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Motivo constant id'>Motivo</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_desonera identifier id'>desonera</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>1</code>: táxi</p>
</li><li>
<p><code>3</code>: produtor agropecuário</p>
</li><li>
<p><code>4</code>: frotista/locadora</p>
</li><li>
<p><code>5</code>: diplomático/consular</p>
</li><li>
<p><code>6</code>: utilitários e motocicletas da Amazônia Ocidental e áreas
de livre comércio (resolução 714/88 e 790/94 – CONTRAN e suas
alterações)</p>
</li><li>
<p><code>7</code>: SUFRAMA</p>
</li><li>
<p><code>9</code>: outros</p>
</li><li>
<p><code>10</code>: deficiente condutor</p>
</li><li>
<p><code>11</code>: deficiente não condutor</p>
</li><li>
<p><code>12</code>: órgão de fomento e desenvolvimento agropecuário</p>
</li></ul>

              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_modalidade_base_calculo_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Modalidade constant id'>Modalidade</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_determinacao identifier id'>determinacao</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_base identifier id'>base</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_calculo identifier id'>calculo</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span> <span class='rubyid_ST constant id'>ST</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>0</code>: preço tabelado ou máximo sugerido</p>
</li><li>
<p><code>1</code>: lista negativa (valor)</p>
</li><li>
<p><code>2</code>: lista positiva (valor)</p>
</li><li>
<p><code>3</code>: lista neutra (valor)</p>
</li><li>
<p><code>4</code>: margem de valor agregado (%)</p>
</li><li>
<p><code>5</code>: pauta (valor)</p>
</li></ul>

              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_margem_valor_adicionado_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Percentual constant id'>Percentual</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_margem identifier id'>margem</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_valor identifier id'>valor</span> <span class='rubyid_adicionado identifier id'>adicionado</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span> <span class='rubyid_ST constant id'>ST</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_reducao_base_calculo_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Percentual constant id'>Percentual</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_reducao identifier id'>reducao</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_base identifier id'>base</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_c identifier id'>c</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_base_calculo_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_base identifier id'>base</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_calculo identifier id'>calculo</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span> <span class='rubyid_ST constant id'>ST</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_aliquota_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Aliquota constant id'>Aliquota</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span> <span class='rubyid_ST constant id'>ST</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                icms_valor_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_ICMS constant id'>ICMS</span> <span class='rubyid_ST constant id'>ST</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_situacao_tributaria
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Situa constant id'>Situa</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>00</code>: entrada com recuperação de crédito</p>
</li><li>
<p><code>01</code>: entrada tributada com alíquota zero</p>
</li><li>
<p><code>02</code>: entrada isenta</p>
</li><li>
<p><code>03</code>: entrada não-tributada</p>
</li><li>
<p><code>04</code>: entrada imune</p>
</li><li>
<p><code>05</code>: entrada com suspensão</p>
</li><li>
<p><code>49</code>: outras entradas</p>
</li><li>
<p><code>50</code>: saída tributada</p>
</li><li>
<p><code>51</code>: saída tributada com alíquota zero</p>
</li><li>
<p><code>52</code>: saída isenta</p>
</li><li>
<p><code>53</code>: saída não-tributada</p>
</li><li>
<p><code>54</code>: saída imune</p>
</li><li>
<p><code>55</code>: saída com suspensão</p>
</li><li>
<p><code>99</code>: outras saídas</p>
</li></ul>

              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_base_calculo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_base identifier id'>base</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_calculo identifier id'>calculo</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_IPI constant id'>IPI</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_aliquota
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Aliquota constant id'>Aliquota</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_IPI constant id'>IPI</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_quantidade_total
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Quantidade constant id'>Quantidade</span> <span class='rubyid_total identifier id'>total</span> <span class='rubyid_na identifier id'>na</span> <span class='rubyid_unidade identifier id'>unidade</span> <span class='rubyid_padrao identifier id'>padrao</span> <span class='rubyid_para identifier id'>para</span> <span class='rubyid_tributacao identifier id'>tributacao</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_valor_por_unidade_tributavel
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_por identifier id'>por</span> <span class='rubyid_unidade identifier id'>unidade</span> <span class='rubyid_tributavel identifier id'>tributavel</span><span class='dot token'>.</span> <span class='rubyid_Informar constant id'>Informar</span> <span class='rubyid_o identifier id'>o</span> <span class='rubyid_valor identifier id'>valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_imposto identifier id'>imposto</span> <span class='rubyid_pauta identifier id'>pauta</span> <span class='rubyid_por identifier id'>por</span> <span class='rubyid_unidade identifier id'>unidade</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_medida identifier id'>medida</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_valor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_IPI constant id'>IPI</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_classe_enquadramento
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Classe de enquadramento do IPI (para cigarros e bebidas).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_cnpj_produtor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>CNPJ do produtor. Informar apenas quando for diferente do emitente, em
casos</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_codigo_selo_controle
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código do selo de controle do IPI.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_quantidade_selo_controle
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Quantidade de selo de controle.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ipi_codigo_enquadramento_legal
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Código de Enquadramento Legal do IPI. Obrigatório quando informado IPI
(use o valor fixo “999”)</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ii_base_calculo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Base de cálculo do imposto de importação.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ii_despesas_aduaneiras
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor das despesas aduaneiras.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ii_valor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do imposto de importação.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                ii_valor_iof
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do IOF.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_situacao_tributaria
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Situacao constant id'>Situacao</span> <span class='rubyid_tributaria identifier id'>tributaria</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_PIS constant id'>PIS</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>01</code>: operação tributável: base de cálculo = valor da
operação (alíquota normal - cumulativo/não cumulativo)</p>
</li><li>
<p><code>02</code>: operação tributável: base de calculo = valor da
operação (alíquota diferenciada)</p>
</li><li>
<p><code>03</code>: operação tributável: base de calculo = quantidade
vendida × alíquota por unidade de produto</p>
</li><li>
<p><code>04</code>: operação tributável: tributação monofásica
(alíquota zero)</p>
</li><li>
<p><code>05</code>: operação tributável: substituição tributária</p>
</li><li>
<p><code>06</code>: operação tributável: alíquota zero</p>
</li><li>
<p><code>07</code>: operação isenta da contribuição</p>
</li><li>
<p><code>08</code>: operação sem incidência da contribuição</p>
</li><li>
<p><code>09</code>: operação com suspensão da contribuição</p>
</li><li>
<p><code>49</code>: outras operações de saída</p>
</li><li>
<p><code>50</code>: operação com direito a crédito: vinculada
exclusivamente a receita tributada no mercado interno</p>
</li><li>
<p><code>51</code>: operação com direito a crédito: vinculada
exclusivamente a receita não tributada no mercado interno</p>
</li><li>
<p><code>52</code>: operação com direito a crédito: vinculada
exclusivamente a receita de exportação</p>
</li><li>
<p><code>53</code>: operação com direito a crédito: vinculada a receitas
tributadas e não-tributadas no mercado interno</p>
</li><li>
<p><code>54</code>: operação com direito a crédito: vinculada a receitas
tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>55</code>: operação com direito a crédito: vinculada a receitas
não-tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>56</code>: operação com direito a crédito: vinculada a receitas
tributadas e não-tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>60</code>: crédito presumido: operação de aquisição vinculada
exclusivamente a receita tributada no mercado interno</p>
</li><li>
<p><code>61</code>: crédito presumido: operação de aquisição vinculada
exclusivamente a receita não-tributada no mercado interno</p>
</li><li>
<p><code>62</code>: crédito presumido: operação de aquisição vinculada
exclusivamente a receita de exportação</p>
</li><li>
<p><code>63</code>: crédito presumido: operação de aquisição vinculada a
receitas tributadas e não-tributadas no mercado interno</p>
</li><li>
<p><code>64</code>: crédito presumido: operação de aquisição vinculada a
receitas tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>65</code>: crédito presumido: operação de aquisição vinculada a
receitas não-tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>66</code>: crédito presumido: operação de aquisição vinculada a
receitas tributadas e não-tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>67</code>: crédito presumido: outras operações</p>
</li><li>
<p><code>70</code>: operação de aquisição sem direito a crédito</p>
</li><li>
<p><code>71</code>: operação de aquisição com isenção</p>
</li><li>
<p><code>72</code>: operação de aquisição com suspensão</p>
</li><li>
<p><code>73</code>: operação de aquisição a alíquota zero</p>
</li><li>
<p><code>74</code>: operação de aquisição sem incidência da
contribuição</p>
</li><li>
<p><code>75</code>: operação de aquisição por substituição tributária</p>
</li><li>
<p><code>98</code>: outras operações de entrada</p>
</li><li>
<p><code>99</code>: outras operações</p>
</li></ul>

              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_base_calculo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_base identifier id'>base</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_calculo identifier id'>calculo</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_PIS constant id'>PIS</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_aliquota_porcentual
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Aliquota constant id'>Aliquota</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_PIS constant id'>PIS</span> <span class='rubyid_em identifier id'>em</span> <span class='rubyid_porcentual identifier id'>porcentual</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_quantidade_vendida
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Quantidade constant id'>Quantidade</span> <span class='rubyid_vendida identifier id'>vendida</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_aliquota_valor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Aliquota constant id'>Aliquota</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_PIS constant id'>PIS</span> <span class='rubyid_em identifier id'>em</span> <span class='rubyid_unidades identifier id'>unidades</span> <span class='rubyid_monet identifier id'>monet</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_valor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_PIS constant id'>PIS</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_base_calculo_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor da base de cálculo do PIS ST.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_aliquota_porcentual_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Alíquota do PIS ST (em percentual).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_quantidade_vendida_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Quantidade vendida.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_aliquota_valor_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Alíquota do PIS ST (em unidades monetárias).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                pis_valor_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do PIS ST.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_situacao_tributaria
              </strong>
              
                <span class="extras">(obrigatório)</span>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Situacao constant id'>Situacao</span> <span class='rubyid_tributaria identifier id'>tributaria</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_PIS constant id'>PIS</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
                <h3>Valores permitidos</h3>
                <ul><li>
<p><code>01</code>: operação tributável: base de cálculo = valor da
operação (alíquota normal - cumulativo/não cumulativo)</p>
</li><li>
<p><code>02</code>: operação tributável: base de calculo = valor da
operação (alíquota diferenciada)</p>
</li><li>
<p><code>03</code>: operação tributável: base de calculo = quantidade
vendida × alíquota por unidade de produto</p>
</li><li>
<p><code>04</code>: operação tributável: tributação monofásica
(alíquota zero)</p>
</li><li>
<p><code>05</code>: operação tributável: substituição tributária</p>
</li><li>
<p><code>06</code>: operação tributável: alíquota zero</p>
</li><li>
<p><code>07</code>: operação isenta da contribuição</p>
</li><li>
<p><code>08</code>: operação sem incidência da contribuição</p>
</li><li>
<p><code>09</code>: operação com suspensão da contribuição</p>
</li><li>
<p><code>49</code>: outras operações de saída</p>
</li><li>
<p><code>50</code>: operação com direito a crédito: vinculada
exclusivamente a receita tributada no mercado interno</p>
</li><li>
<p><code>51</code>: operação com direito a crédito: vinculada
exclusivamente a receita não tributada no mercado interno</p>
</li><li>
<p><code>52</code>: operação com direito a crédito: vinculada
exclusivamente a receita de exportação</p>
</li><li>
<p><code>53</code>: operação com direito a crédito: vinculada a receitas
tributadas e não-tributadas no mercado interno</p>
</li><li>
<p><code>54</code>: operação com direito a crédito: vinculada a receitas
tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>55</code>: operação com direito a crédito: vinculada a receitas
não-tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>56</code>: operação com direito a crédito: vinculada a receitas
tributadas e não-tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>60</code>: crédito presumido: operação de aquisição vinculada
exclusivamente a receita tributada no mercado interno</p>
</li><li>
<p><code>61</code>: crédito presumido: operação de aquisição vinculada
exclusivamente a receita não-tributada no mercado interno</p>
</li><li>
<p><code>62</code>: crédito presumido: operação de aquisição vinculada
exclusivamente a receita de exportação</p>
</li><li>
<p><code>63</code>: crédito presumido: operação de aquisição vinculada a
receitas tributadas e não-tributadas no mercado interno</p>
</li><li>
<p><code>64</code>: crédito presumido: operação de aquisição vinculada a
receitas tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>65</code>: crédito presumido: operação de aquisição vinculada a
receitas não-tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>66</code>: crédito presumido: operação de aquisição vinculada a
receitas tributadas e não-tributadas no mercado interno e de exportação</p>
</li><li>
<p><code>67</code>: crédito presumido: outras operações</p>
</li><li>
<p><code>70</code>: operação de aquisição sem direito a crédito</p>
</li><li>
<p><code>71</code>: operação de aquisição com isenção</p>
</li><li>
<p><code>72</code>: operação de aquisição com suspensão</p>
</li><li>
<p><code>73</code>: operação de aquisição a alíquota zero</p>
</li><li>
<p><code>74</code>: operação de aquisição sem incidência da
contribuição</p>
</li><li>
<p><code>75</code>: operação de aquisição por substituição tributária</p>
</li><li>
<p><code>98</code>: outras operações de entrada</p>
</li><li>
<p><code>99</code>: outras operações</p>
</li></ul>

              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_base_calculo
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_da identifier id'>da</span> <span class='rubyid_base identifier id'>base</span> <span class='rubyid_de identifier id'>de</span> <span class='rubyid_calculo identifier id'>calculo</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_COFINS constant id'>COFINS</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_aliquota_porcentual
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Aliquota constant id'>Aliquota</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_COFINS constant id'>COFINS</span> <span class='rubyid_em identifier id'>em</span> <span class='rubyid_porcentual identifier id'>porcentual</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_quantidade_vendida
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Quantidade constant id'>Quantidade</span> <span class='rubyid_vendida identifier id'>vendida</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_aliquota_valor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Aliquota constant id'>Aliquota</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_COFINS constant id'>COFINS</span> <span class='rubyid_em identifier id'>em</span> <span class='rubyid_unidades identifier id'>unidades</span> <span class='rubyid_monet identifier id'>monet</span></code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_valor
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<pre class="code ruby"><code class="ruby"><span class='rubyid_Valor constant id'>Valor</span> <span class='rubyid_do do kw'>do</span> <span class='rubyid_COFINS constant id'>COFINS</span><span class='dot token'>.</span>
</code></pre>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_base_calculo_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor da base de cálculo do COFINS ST.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_aliquota_porcentual_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Alíquota do COFINS ST (em percentual).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_quantidade_vendida_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Quantidade vendida.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_aliquota_valor_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Alíquota do COFINS ST (em unidades monetárias).</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                cofins_valor_st
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do COFINS ST.</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                percentual_devolvido
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Percentual da mercadoria devolvida</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
          
          <div class="method_details ">
            <p class="signature">
              <strong>
                valor_ipi_devolvido
              </strong>
              
              
            </p>
            <div class="docstring">
              <div class="discussion">
                <p>
<p>Valor do IPI devolvido</p>
</p>
              </div>
            </div>
            <div class="tags">
              
            </div>
          </div>
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
        
        
      
    </div>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

	<!-- Jquery -->
	<script src="js/jquery-1.10.2.min.js"></script>

	<!-- Agenda -->
	<script src='js/agenda/lib/moment.min.js'></script>
	<script src='js/agenda/lib/jquery.min.js'></script>
	<script src='js/agenda/fullcalendar.min.js'></script>
	<script src='js/agenda/lang-all.js'></script> 

	<!-- Bootstrap -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

	<!-- Modernizr -->
	<script src='js/modernizr.min.js'></script>

    <!-- Pace -->
	<script src='js/pace.min.js'></script>

	<!-- Popup Overlay -->
	<script src='js/jquery.popupoverlay.min.js'></script>

    <!-- Slimscroll -->
	<script src='js/jquery.slimscroll.min.js'></script>

	<!-- Cookie -->
	<script src='js/jquery.cookie.min.js'></script>

	<!-- Endless -->
	<script src="js/endless/endless.js"></script>

	<!-- Extras -->
	<script src="js/extras.js"></script>


	<script type="text/javascript" src="bower_components/angular/angular.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.tpl.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-ui-utils/mask.min.js"></script>
    <script src="js/angular-sanitize.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="js/dialogs.v2.min.js" type="text/javascript"></script>
    <script src="js/auto-complete/ng-sanitize.js"></script>
    <script src="js/app.js"></script>
    <script src="js/auto-complete/AutoComplete.js"></script>
    <script src="js/angular-services/user-service.js"></script>
	<script src="js/angular-controller/agendaForncedores-controller.js"></script>
	<script type="text/javascript">
	var a = "";
		$.each($('.signature'),function(i,v){  
			 console.log($('strong',v).text()) ;
			 a += $('strong',v).text()+' - '+ ( $('.extras',v).text() ) + "<br/>";

		 });

		$('body').html(a);

	</script>
	<?php include("google_analytics.php"); ?>
  </body>
</html>
