/* adiciona coluna tbl_fabricante */
ALTER TABLE `tbl_fabricante` ADD `id_ref` INT NOT NULL ;

/* Adiciona Fabricante */

INSERT `tbl_fabricante` ( nome_fabricante,id_empreendimento,id_ref ) SELECT nome_fabricante,28,id FROM `tbl_fabricante` WHERE id_empreendimento = 1

--------------------------------------------------------------

/* adiciona campos na tbl_produtos */

ALTER TABLE `tbl_produtos` ADD `id_empreendimento` INT NOT NULL , ADD `id_ref` INT NOT NULL ;

/* add Produtos */

INSERT  INTO tbl_produtos (codigo_barra,nome,img,descricao,em_estoque,qtd,sabor,peso,valor,imposto,desconto,valor_desconto,valor_com_desconto,valor__desconto_imposto,custo_compra,margem_atacado,venda_atacado,margem_intermediario,venda_intermediario,margem_varejo,venda_varejo,valor_desconto_cliente,id_fabricante,id_importador,id_categoria,qtd_minima_estoque,nme_arquivo_nutricional,id_empreendimento,id_ref) 
SELECT codigo_barra,nome,img,descricao,em_estoque,qtd,sabor,peso,valor,imposto,desconto,valor_desconto,valor_com_desconto,valor__desconto_imposto,custo_compra,margem_atacado,venda_atacado,margem_intermediario,venda_intermediario,margem_varejo,venda_varejo,valor_desconto_cliente,id_fabricante,NULL,NULL,qtd_minima_estoque,nme_arquivo_nutricional,28,tp.id FROM  tbl_produtos AS tp 
INNER JOIN tbl_produto_empreendimento  AS tpe ON tp.id = tpe.id_produto
WHERE tpe.id_empreendimento = 1

/* update no id_fabricante na tabela de produtos */

UPDATE tbl_produtos SET id_fabricante = (SELECT id FROM tbl_fabricante AS tf WHERE tf.id_ref = id_fabricante AND tf.id_ref != 0 ) WHERE id_empreendimento = 28
--------------------------------------------------------------

/* Vincular produto ao empreendimento  */

INSERT INTO tbl_produto_empreendimento (id_produto,id_empreendimento)
SELECT id,28 FROM `tbl_produtos` WHERE id_empreendimento = 28

--------------------------------------------------------------

/* vincula produto ao seu valor de custo */

INSERT INTO tbl_preco_produto(id_produto,vlr_custo,dta_ultima_atualizacao) SELECT id, (SELECT ROUND((tpp.vlr_custo + (tpp.vlr_custo * tpp.perc_imposto_compra)) - (tpp.vlr_custo * tpp.perc_desconto_compra),2) FROM tbl_preco_produto AS tpp WHERE tpp.id_produto = id_ref)AS vlr_custo, NOW() FROM `tbl_produtos` WHERE id_empreendimento = 28