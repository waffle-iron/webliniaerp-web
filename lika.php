<?php
$cores = array(
	array( // row #14
		'id_cor' => 1819
	),
);



$tamanhos = array(
	array( // row #0
		'id_tamanho' => 3,
		'id_empreendimento' => 51,
		'nome_tamanho' => '37/38',
	),
	array( // row #2
		'id_tamanho' => 6599,
		'id_empreendimento' => 51,
		'nome_tamanho' => '33/34',
	),
	array( // row #3
		'id_tamanho' => 6600,
		'id_empreendimento' => 51,
		'nome_tamanho' => '35/36',
	),
	array( // row #4
		'id_tamanho' => 6602,
		'id_empreendimento' => 51,
		'nome_tamanho' => '39/40',
	),
);



foreach ($cores as $key => $cor) {
	foreach ($tamanhos as $key => $tamanho) {
		echo "INSERT INTO `tbl_produtos` (`codigo_barra`, `nome`, `img`, `descricao`, `em_estoque`, `qtd`, `sabor`, `peso`, `valor`, `imposto`, `desconto`, `valor_desconto`, `valor_com_desconto`, `valor__desconto_imposto`, `custo_compra`, `margem_atacado`, `venda_atacado`, `margem_intermediario`, `venda_intermediario`, `margem_varejo`, `venda_varejo`, `valor_desconto_cliente`, `id_fabricante`, `id_importador`, `id_categoria`, `qtd_minima_estoque`, `nme_arquivo_nutricional`, `id_ref`, `id_empreendimento`, `dsc_unidade_medida`, `cod_ncm`, `ex_tipi`, `cod_especializacao_ncm`, `cod_forma_aquisicao`, `cod_origem_mercadoria`, `cod_tipo_tributacao_ipi`, `flg_excluido`, `id_tamanho`, `id_cor`, `flg_produto_composto`) 
			  VALUES ('', 'BASE LIKA SHOES REDONDA', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 118, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '".$tamanho['id_tamanho']."', '".$cor['id_cor']."', 0);<br/>
			  SELECT LAST_INSERT_ID() INTO @ID;<br/>
			  INSERT INTO `tbl_produto_empreendimento` (`id_produto`, `id_empreendimento`) VALUES (@ID, 51);<br/>
			  INSERT INTO tbl_preco_produto (id_produto,id_empreendimento,vlr_custo,dta_ultima_atualizacao) VALUES(@ID,51,5,NOW());<br/>";
		
	}
	echo '<br/>';
}

