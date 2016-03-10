<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>WebliniaERP - Importação de dados</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <link rel='stylesheet prefetch' href='bootstrap/css/bootstrap.min.css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/endless.min.css">
  <link rel="stylesheet" href="css/endless-skin.css">
  <link rel="stylesheet" href="css/custom.css">
  <style type="text/css">
    .container { max-width: 780px; margin: 0 auto; }
  </style>
</head>
<body>
  <div class="container">
    <div class="page-header clearfix">
      <h3 class="page-title">
        <div class="pull-left">
          Tabela de Produtos p/ Importação
          <br/>
          <small>Empreendimento: Alternativa Perfeita</small>
        </div>
        <div class="pull-right">
          <button id="exportToExcel" class="btn btn-sm btn-success">
            <i class="fa fa-download"></i> Baixar Planilha de Excel
          </button>
        </div>
      </h3>
    </div>

    <div class="panel panel-default">
      <div class="table-responsive">
        <table id="produtos" class="table table-bordered table-hover table-condesed table-striped">
          <thead>
            <th>cod_barras</th>
            <th>nme_produto</th>
            <th>und_medida</th>
            <th>qtd_estoque</th>
            <th>nme_fabricante</th>
          </thead>
          <tbody>
            <?php
              $pointer = fopen("teste-lista.txt", "r");

              while(!feof($pointer)) {
                // Line of text
                $line         = fgets($pointer, 4096);
                if(strlen($line) === 0)
                  continue;
                // Fields
                $cod_barras     = substr($line, 4, 5);
                $nme_produto    = substr($line, 10, 48);
                $und_medida     = substr($line, 58, 2);
                $qtd_estoque    = substr($line, 81, 2);
                $nme_fabricante = substr($line, 84, strlen($line));
            ?>
            <tr>
              <td><?=($cod_barras)?></td>
              <td><?=(utf8_encode($nme_produto))?></td>
              <td><?=($und_medida)?></td>
              <td><?=($qtd_estoque)?></td>
              <td><?=(utf8_encode($nme_fabricante))?></td>
            </tr>
            <?php
              }

              fclose($pointer);
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="js/jquery-1.10.2.min.js"></script>
  <script src="js/table2excel.js"></script>
  <script src="js/moment/moment.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      function exportToExcel(tableElement, worksheetName, filename) {
        $(tableElement).table2excel({
          name: worksheetName,
          filename: filename
        });
      }

      $("button#exportToExcel").on("click", function() {
        exportToExcel('table#produtos', 'Produtos p/ Importação', moment().format('YYYY-MM-DD') +"_Produtos para Importacao");
      });
    });
  </script>
</body>
</html>