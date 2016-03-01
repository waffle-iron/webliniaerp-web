<?php
$produtos = array(
	array( // row #0
		'id' => 57475,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1810,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #1
		'id' => 57476,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1812,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #2
		'id' => 57477,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 4640,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #3
		'id' => 57478,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1819,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #4
		'id' => 57479,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1811,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #5
		'id' => 57480,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1771,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #6
		'id' => 57481,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1807,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #7
		'id' => 57482,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1808,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #8
		'id' => 57483,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1831,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #9
		'id' => 57484,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 4641,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #10
		'id' => 57485,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1817,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
	array( // row #11
		'id' => 57486,
		'nome' => 'BASE PROMOCIONAL REDONDA',
		'id_cor' => 1813,
		'id_categoria' => 118,
		'flg_produto_composto' => 0,
	),
);

$tamanhos = array(
	array( // row #1
		'id' => 10164,
		'nome_tamanho' => '25/26',
	),
	array( // row #2
		'id' => 10165,
		'nome_tamanho' => '27/28',
	),
	array( // row #3
		'id' => 10166,
		'nome_tamanho' => '29/30',
	),
	array( // row #4
		'id' => 10167,
		'nome_tamanho' => '31/32',
	),
	array( // row #5
		'id' => 6599,
		'nome_tamanho' => '33/34',
	),
	array( // row #6
		'id' => 6600,
		'nome_tamanho' => '35/36',
	),
	array( // row #7
		'id' => 3,
		'nome_tamanho' => '37/38',
	),
	array( // row #8
		'id' => 6602,
		'nome_tamanho' => '39/40',
	),
	array( // row #9
		'id' => 4,
		'nome_tamanho' => '41/42',
	),
	array( // row #10
		'id' => 5,
		'nome_tamanho' => '43/44',
	),
);

$sql = "" ;

foreach ($produtos as $key_p => $pro) {
	foreach ($tamanhos as $key_t => $tamanho) {
		$sql .= "INSERT INTO tbl_produtos (nome,id_cor,id_categoria,id_tamanho,flg_produto_composto)<br>";	
		$sql .= "VALUES('".$pro['nome']."','".$pro['id_cor']."','".$pro['id_categoria']."','".$tamanho['id']."','0');<br>";
		$sql .= "SELECT LAST_INSERT_ID() INTO @ID;<br/>";

		$sql .= "INSERT INTO tbl_produto_empreendimento VALUES(NULL, @ID,51); <br/>";

		$sql .= "INSERT INTO tbl_valor_campo_extra_produto<br/>";
		$sql .= "SELECT id_campo,@ID,valor_campo FROM tbl_valor_campo_extra_produto AS tvcep WHERE tvcep.id_produto = '".$pro['id']."' ;<br/>";

		$sql .= "INSERT tbl_preco_produto <br/>";
		$sql .= "SELECT NULL,@ID,id_empreendimento,vlr_custo,perc_imposto_compra,perc_desconto_compra,perc_venda_atacado,
				perc_venda_intermediario,perc_venda_varejo,dta_ultima_atualizacao 
				FROM tbl_preco_produto AS tpp WHERE tpp.id_produto = '".$pro['id']."' ;<br/>";
	}
}
echo $sql ; die ;
