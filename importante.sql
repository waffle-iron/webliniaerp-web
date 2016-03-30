/*Qtd pacientes*/
SELECT COUNT(*) AS qtd_pacientes FROM(
	SELECT DISTINCT ta.id_paciente FROM tbl_atendimento AS ta 
	WHERE ta.id_empreendimento = 75
		AND date_format(ta.dta_entrada,'%Y-%m-%d') = '2016-03-29'   
) AS tbl_pacientes;

SELECT COUNT(*) AS qtd_pacientes_atendidos FROM(
	SELECT DISTINCT ta.id_paciente FROM tbl_atendimento AS ta 
	WHERE ta.id_empreendimento = 75
		AND date_format(ta.dta_entrada,'%Y-%m-%d') = '2016-03-29'   
		AND ta.id_profissional_atendimento IS NOT NULL
) AS tbl_pacientes;

SELECT COUNT(*) AS qtd_paciente_sem_orcamento FROM tbl_atendimento AS ta
LEFT JOIN tbl_atendimento_venda AS tav ON ta.id = tav.id_atendimento 
WHERE ta.id_empreendimento = 75
		AND date_format(ta.dta_entrada,'%Y-%m-%d') = '2016-03-29'   
		AND ta.id_profissional_atendimento IS NOT NULL
		AND tav.id IS NULL;

SELECT ta.id AS id_atendimento,
(
	SELECT sub_tv.venda_confirmada FROM tbl_atendimento AS sub_ta 
	INNER JOIN tbl_atendimento_venda AS sub_tav ON sub_ta.id = sub_tav.id_atendimento
	INNER JOIN tbl_vendas AS sub_tv ON sub_tav.id_venda = sub_tv.id
	INNER JOIN tbl_itens_venda AS sub_tiv ON sub_tv.id = sub_tiv.id_venda
	WHERE sub_ta.id_profissional_atendimento = ta.id_profissional_atendimento 
			AND date_format(sub_ta.dta_entrada,'%Y-%m-%d') = date_format(ta.dta_entrada,'%Y-%m-%d')
			AND sub_tav.id_atendimento = ta.id
	ORDER BY sub_ta.id, sub_tv.venda_confirmada DESC LIMIT 1 	
) AS flg_orcamento_contratado,
(
	SELECT SUM(tiv.valor_real_item) FROM tbl_atendimento AS sub_ta 
	INNER JOIN tbl_atendimento_venda AS sub_tav ON sub_ta.id = sub_tav.id_atendimento
	INNER JOIN tbl_vendas AS sub_tv ON sub_tav.id_venda = sub_tv.id
	INNER JOIN tbl_itens_venda AS sub_tiv ON sub_tv.id = sub_tiv.id_venda
	WHERE sub_ta.id_profissional_atendimento = ta.id_profissional_atendimento 
			AND date_format(sub_ta.dta_entrada,'%Y-%m-%d') = date_format(ta.dta_entrada,'%Y-%m-%d')
			AND sub_tav.id_atendimento = ta.id
	ORDER BY sub_ta.id, sub_tv.venda_confirmada DESC LIMIT 1 	
) AS vlr_orcamento
FROM tbl_atendimento AS ta 
INNER JOIN tbl_atendimento_venda AS tav ON ta.id = tav.id_atendimento
INNER JOIN tbl_vendas AS tv ON tav.id_venda = tv.id
INNER JOIN tbl_itens_venda AS tiv ON tv.id = tiv.id_venda
WHERE date_format(ta.dta_entrada,'%Y-%m-%d') = '2016-03-29'
		AND ta.id_empreendimento = 75
GROUP BY ta.id
