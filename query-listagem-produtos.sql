select 
	prd.id 					as codigo, 
	prd.nome 				as produto, 
	tcp.nome_cor 			as sabor, 
	tmh.nome_tamanho 		as tamanho, 
	cat.descricao_categoria as categoria, 
	fab.nome_fabricante 	as fabricante, 
	sum(est.qtd_item) 		as estoque
from tbl_produto_empreendimento as tpe
left join tbl_produtos 			as prd on prd.id = tpe.id_produto
left join tbl_cor_produto 		as tcp on tcp.id = prd.id_cor
left join tbl_tamanho 			as tmh on tmh.id = prd.id_tamanho
left join tbl_categorias 		as cat on cat.id = prd.id_categoria
left join tbl_fabricante 		as fab on fab.id = prd.id_fabricante
left join tbl_estoque 			as est on est.id_produto = prd.id
where tpe.id_empreendimento = 87
group by prd.id
order by prd.nome