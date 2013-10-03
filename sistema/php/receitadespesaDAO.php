<?php 
class ReceitaDespesaDAO{
	function findAll(){
		$result = false;
		$rs = mysql_query("SELECT * FROM receita_despesa ORDER BY data_pagamento_recebimento DESC");
		while ( $r = mysql_fetch_array($rs) ){
			$receita_despesa = new ReceitaDespesa();
			$receita_despesa->id = $r['id_receita_despesa'];		
			$receita_despesa->id_condominio = $r['FKid_condominiosCol'];		
			$receita_despesa->id_centro = $r['FKid_centro_custosCol'];		
			$receita_despesa->documento = $r['documento'];		
			$receita_despesa->data_emissao = $r['data_emissao'];		
			$receita_despesa->data_vencimento = $r['data_vencimento'];		
			$receita_despesa->data_pagamento_recebimento = $r['data_pagamento_recebimento'];		
			$receita_despesa->valor = $r['valor'];		
			$receita_despesa->forma_pagamento = $r['forma_pagamento'];		
			$receita_despesa->observacao = $r['observacao'];		
			$receita_despesa->pagante_fornecedor = $r['pagante_fornecedor'];		
			$receita_despesa->valor_pago = $r['valor_pago'];		
			$receita_despesa->status = $r['situacao'];	
			$receita_despesa->recebido_pago = $r['recebido_pago'];					
			$result[] = $receita_despesa;
		}
		return $result;
	}
	
	function findTopByBusca($centro, $mes, $ano, $condominio, $tipoArea, $recebido_pago = "", $relatorio = 0, $i = 0, $f = 0, $pagante_fornecedor = "", $documento = "", $id = 0, $orderBy = "r.data_pagamento_recebimento", $ordem = "DESC"){
		$result = false;
		$condicoes = "";
		$whatelse = "";
		$groupby = "";
		$from = 'receita_despesa r';	
		if ($centro != ""){
			if(is_numeric($centro)){
				$condicoes = $condicoes." AND c.id_centro_custos = ".$centro." ";
			}else{
				$condicoes = $condicoes." AND c.nome like '%".$centro."%' ";				
			}
				$condicoes = $condicoes." AND  c.id_centro_custos = r.FKid_centro_custosCol";
				$from = $from.', centro_custos c';
				//identifica o já relacionamento entre as tabelas centro de custo e receita para que não haja duplicidades
				$relacionamento = 'c';								
		}		
		if ($mes != ""){	
			switch($relatorio){
				case 0: $condicoes =  $condicoes." AND MONTH(r.data_emissao) = '".$mes."'";
						break;
				case 1: $condicoes = $condicoes." AND MONTH(r.data_pagamento_recebimento) = '".$mes."'";
						break;
				case 2: $condicoes = $condicoes." AND( MONTH(r.data_emissao) = '".$mes."'";
						$condicoes = $condicoes." OR MONTH(r.data_pagamento_recebimento) = '".$mes."')";
						break;			
			}
		}	
		if ($ano != ""){	
			switch($relatorio){
				case 0: $condicoes =  $condicoes." AND YEAR(r.data_emissao) = '".$ano."'";
						break;
				case 1: $condicoes = $condicoes." AND YEAR(r.data_pagamento_recebimento) = '".$ano."'";
						break;
				case 2: $condicoes = $condicoes." AND (YEAR(r.data_emissao) = '".$ano."'";
						$condicoes = $condicoes." OR YEAR(r.data_pagamento_recebimento) = '".$ano."')";
						break;			
			}						
		}			
		if ($pagante_fornecedor != ""){			
				$condicoes = $condicoes." AND r.pagante_fornecedor = '".$pagante_fornecedor."'";			
		}	
		if ($documento != ""){			
				$condicoes = $condicoes." AND r.documento = '".$documento."'";			
		}	
		if ($id != 0){			
				$condicoes = $condicoes." AND r.id_receita_despesa = ".$id."";			
		}	
		if ($recebido_pago != ""){			
				$condicoes = $condicoes." AND r.recebido_pago = '".$recebido_pago."'";			
		}	
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  r.FKid_condominiosCol = cond.id_condominios";
				
				$from = $from.', condominios cond';			
		}
		if ($tipoArea != ""){
				$whatelse = ', a.nome as nomearea, c.nome as nomecentro';
				$condicoes = $condicoes." AND a.tipo like '%".$tipoArea."%' ";
				$condicoes = $condicoes." AND  a.id_area_custos = c.FKid_area_custosCol";				
				$from = $from.', area_custos a';			
				if($relacionamento != 'c'){
					$condicoes = $condicoes." AND  c.id_centro_custos = r.FKid_centro_custosCol";
					$from = $from.', centro_custos c';
					//$groupby = 'GROUP BY c.nome';
					$orderBy = 'a.id_area_custos, c.id_centro_custos';
				}
		}				
		
		
		//die("SELECT r.*".$whatelse." FROM $from WHERE r.situacao = 1".$condicoes." $groupby ORDER BY $orderBy $ordem");
			
		
		if ($f > 0)
			$rs = mysql_query("SELECT r.*".$whatelse." FROM $from WHERE r.situacao = 1".$condicoes." $groupby ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT r.*".$whatelse." FROM $from WHERE r.situacao = 1".$condicoes." $groupby ORDER BY $orderBy $ordem");
		
		while ( $r = mysql_fetch_array($rs)){
        	$receita_despesa = new ReceitaDespesa();
			$receita_despesa->id = $r['id_receita_despesa'];		
			$receita_despesa->id_condominio = $r['FKid_condominiosCol'];		
			$receita_despesa->id_centro = $r['FKid_centro_custosCol'];		
			$receita_despesa->documento = $r['documento'];		
			$receita_despesa->data_emissao = $r['data_emissao'];		
			$receita_despesa->data_vencimento = $r['data_vencimento'];		
			$receita_despesa->data_pagamento_recebimento = $r['data_pagamento_recebimento'];
			$receita_despesa->valor = $r['valor'];		
			$receita_despesa->forma_pagamento = $r['forma_pagamento'];		
			$receita_despesa->observacao = $r['observacao'];		
			$receita_despesa->pagante_fornecedor = $r['pagante_fornecedor'];		
			$receita_despesa->valor_pago = $r['valor_pago'];		
			$receita_despesa->status = $r['situacao'];
			$receita_despesa->recebido_pago = $r['recebido_pago'];	
			if($whatelse != ""){
				$receita_despesa->area->nome = 	$r['nomearea'];	
				$receita_despesa->centro->nome = 	$r['nomecentro'];	
			}
			$result[] = $receita_despesa;
  		}					
		return $result;
	}	
	
	function findByPk($id){
		$result = false;
		$rs = mysql_query("SELECT * FROM receita_despesa WHERE id_receita_despesa = $id");
		if ($r = mysql_fetch_array($rs) ){
			$receita_despesa = new ReceitaDespesa();
			$receita_despesa->id = $r['id_receita_despesa'];		
			$receita_despesa->id_condominio = $r['FKid_condominiosCol'];		
			$receita_despesa->id_centro = $r['FKid_centro_custosCol'];		
			$receita_despesa->documento = $r['documento'];		
			$receita_despesa->data_emissao = $r['data_emissao'];		
			$receita_despesa->data_vencimento = $r['data_vencimento'];		
			$receita_despesa->data_pagamento_recebimento = $r['data_pagamento_recebimento'];
			$receita_despesa->valor = $r['valor'];		
			$receita_despesa->forma_pagamento = $r['forma_pagamento'];		
			$receita_despesa->observacao = $r['observacao'];		
			$receita_despesa->pagante_fornecedor = $r['pagante_fornecedor'];		
			$receita_despesa->valor_pago = $r['valor_pago'];		
			$receita_despesa->status = $r['situacao'];	
			$receita_despesa->recebido_pago = $r['recebido_pago'];		
			$result = $receita_despesa;
		}
		return $result;
	}
	
	function findByCentro($id){
		$result = false;
		$rs = mysql_query("SELECT * FROM receita_despesa WHERE FKid_centro_custosCol = $id");
		while ($r = mysql_fetch_array($rs) ){
			$receita_despesa = new ReceitaDespesa();
			$receita_despesa->id = $r['id_receita_despesa'];		
			$receita_despesa->id_condominio = $r['FKid_condominiosCol'];		
			$receita_despesa->id_centro = $r['FKid_centro_custosCol'];		
			$receita_despesa->documento = $r['documento'];		
			$receita_despesa->data_emissao = $r['data_emissao'];		
			$receita_despesa->data_vencimento = $r['data_vencimento'];		
			$receita_despesa->data_pagamento_recebimento = $r['data_pagamento_recebimento'];
			$receita_despesa->valor = $r['valor'];		
			$receita_despesa->forma_pagamento = $r['forma_pagamento'];		
			$receita_despesa->observacao = $r['observacao'];		
			$receita_despesa->pagante_fornecedor = $r['pagante_fornecedor'];		
			$receita_despesa->valor_pago = $r['valor_pago'];		
			$receita_despesa->status = $r['situacao'];	
			$receita_despesa->recebido_pago = $r['recebido_pago'];		
			$result[] = $receita_despesa;
		}
		return $result;
	}
	
	function findByArea($id){
		$result = false;
		$rs = mysql_query("SELECT r.* FROM receita_despesa r, centro_custos c WHERE c.id_centro_custos = r.FKid_centro_custosCol AND c.FKid_area_custosCol = $id");
		while ($r = mysql_fetch_array($rs) ){
			$receita_despesa = new ReceitaDespesa();
			$receita_despesa->id = $r['id_receita_despesa'];		
			$receita_despesa->id_condominio = $r['FKid_condominiosCol'];		
			$receita_despesa->id_centro = $r['FKid_centro_custosCol'];		
			$receita_despesa->documento = $r['documento'];		
			$receita_despesa->data_emissao = $r['data_emissao'];		
			$receita_despesa->data_vencimento = $r['data_vencimento'];		
			$receita_despesa->data_pagamento_recebimento = $r['data_pagamento_recebimento'];
			$receita_despesa->valor = $r['valor'];		
			$receita_despesa->forma_pagamento = $r['forma_pagamento'];		
			$receita_despesa->observacao = $r['observacao'];		
			$receita_despesa->pagante_fornecedor = $r['pagante_fornecedor'];		
			$receita_despesa->valor_pago = $r['valor_pago'];		
			$receita_despesa->status = $r['situacao'];	
			$receita_despesa->recebido_pago = $r['recebido_pago'];		
			$result[] = $receita_despesa;
		}
		return $result;
	}
	
	function findBySituacao($situacao){
		$result = false;
		$rs = mysql_query("SELECT * FROM receita_despesa WHERE situacao = $situacao");
		while ($r = mysql_fetch_array($rs) ){
			$receita_despesa = new ReceitaDespesa();
			$receita_despesa->id = $r['id_receita_despesa'];		
			$receita_despesa->id_condominio = $r['FKid_condominiosCol'];		
			$receita_despesa->id_centro = $r['FKid_centro_custosCol'];		
			$receita_despesa->documento = $r['documento'];		
			$receita_despesa->data_emissao = $r['data_emissao'];		
			$receita_despesa->data_vencimento = $r['data_vencimento'];		
			$receita_despesa->data_pagamento_recebimento = $r['data_pagamento_recebimento'];
			$receita_despesa->valor = $r['valor'];		
			$receita_despesa->forma_pagamento = $r['forma_pagamento'];		
			$receita_despesa->observacao = $r['observacao'];		
			$receita_despesa->pagante_fornecedor = $r['pagante_fornecedor'];		
			$receita_despesa->valor_pago = $r['valor_pago'];		
			$receita_despesa->recebido_pago = $r['recebido_pago'];	
			$receita_despesa->status = $r['situacao'];			
			$result[] = $receita_despesa;
		}
		return $result;
	}
	
	function findByMes($data){
		$result = false;
		$rs = mysql_query("SELECT * FROM receita_despesa WHERE MONTH(data_pagamento_recebimento) = $data");
		if ($r = mysql_fetch_array($rs) ){
			$receita_despesa = new ReceitaDespesa();
			$receita_despesa->id = $r['id_receita_despesa'];		
			$receita_despesa->id_condominio = $r['FKid_condominiosCol'];		
			$receita_despesa->id_centro = $r['FKid_centro_custosCol'];		
			$receita_despesa->documento = $r['documento'];		
			$receita_despesa->data_emissao = $r['data_emissao'];		
			$receita_despesa->data_vencimento = $r['data_vencimento'];		
			$receita_despesa->data_pagamento_recebimento = $r['data_pagamento_recebimento'];
			$receita_despesa->valor = $r['valor'];		
			$receita_despesa->forma_pagamento = $r['forma_pagamento'];		
			$receita_despesa->observacao = $r['observacao'];		
			$receita_despesa->pagante_fornecedor = $r['pagante_fornecedor'];		
			$receita_despesa->valor_pago = $r['valor_pago'];	
			$receita_despesa->recebido_pago = $r['recebido_pago'];		
			$receita_despesa->status = $r['situacao'];		
			$result = $receita_despesa;
		}
		return $result;
	}

	function findByTipoAreaMes($tipo, $data){
		$result = false;
		$rs = mysql_query("SELECT r.*, a.nome as nomearea, c.nome as nomecentro FROM centro_custos c, area_custos a, receita_despesa r WHERE c.FKid_area_custosCol = a.id_area_custos AND c.id_centro_custos = r.FKid_centro_custosCol AND a.tipo = '{$tipo}' AND (MONTH(r.data_pagamento_recebimento) = $data OR MONTH(r.data_pagamento_recebimento) = '00') ORDER BY a.id_area_custos, c.id_centro_custos");
		while ($r = mysql_fetch_array($rs) ){
			$receita_despesa = new ReceitaDespesa();
			$receita_despesa->id = $r['id_receita_despesa'];		
			$receita_despesa->id_condominio = $r['FKid_condominiosCol'];		
			$receita_despesa->id_centro = $r['FKid_centro_custosCol'];		
			$receita_despesa->documento = $r['documento'];		
			$receita_despesa->data_emissao = $r['data_emissao'];		
			$receita_despesa->data_vencimento = $r['data_vencimento'];		
			$receita_despesa->data_pagamento_recebimento = $r['data_pagamento_recebimento'];
			$receita_despesa->valor = $r['valor'];		
			$receita_despesa->forma_pagamento = $r['forma_pagamento'];		
			$receita_despesa->observacao = $r['observacao'];		
			$receita_despesa->pagante_fornecedor = $r['pagante_fornecedor'];		
			$receita_despesa->valor_pago = $r['valor_pago'];		
			$receita_despesa->status = $r['situacao'];	
			$receita_despesa->recebido_pago = $r['recebido_pago'];	
			$receita_despesa->area->nome = 	$r['nomearea'];	
			$receita_despesa->centro->nome = 	$r['nomecentro'];	
			$result[] = $receita_despesa;
		}
		return $result;
	}
	
	function areaCentroByTipoAreaMes($tipo, $mes, $ano, $condominio){	
		$result = false;		
		$rs = mysql_query("SELECT a.nome as nomearea, c.nome as nomecentro FROM centro_custos c, area_custos a, receita_despesa r WHERE c.FKid_area_custosCol = a.id_area_custos AND c.id_centro_custos = r.FKid_centro_custosCol AND a.tipo = '{$tipo}' AND MONTH(r.data_pagamento_recebimento) = $mes AND YEAR(r.data_pagamento_recebimento) = $ano AND r.FKid_condominiosCol = $condominio GROUP BY c.nome ORDER BY a.id_area_custos, c.id_centro_custos");
		while ($r = mysql_fetch_array($rs) ){	
			$receita_despesa = new ReceitaDespesa();		
			$receita_despesa->area->nome = 	$r['nomearea'];	
			$receita_despesa->centro->nome = 	$r['nomecentro'];	
			$result[] = $receita_despesa;
		}				
		return $result;
	}
	
	function somaValoresByCentro($tipo, $mes, $ano, $area, $centro, $condominio){
		$result = false;
		$rs = mysql_query("SELECT sum(r.valor_pago) as soma FROM centro_custos c, area_custos a, receita_despesa r WHERE c.FKid_area_custosCol = a.id_area_custos AND c.id_centro_custos = r.FKid_centro_custosCol AND a.tipo = '{$tipo}' AND MONTH(r.data_pagamento_recebimento) = $mes AND YEAR(r.data_pagamento_recebimento) = $ano AND a.nome = '{$area}' AND c.nome = '{$centro}' AND r.FKid_condominiosCol = $condominio  ORDER BY a.id_area_custos, c.id_centro_custos");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['soma'];
		}
		return $result;
	}
	
	
	function somaValoresByArea($tipo, $mes, $ano, $area, $condominio){
		$result = false;
		$rs = mysql_query("SELECT sum(r.valor_pago) as soma FROM centro_custos c, area_custos a, receita_despesa r WHERE c.FKid_area_custosCol = a.id_area_custos AND c.id_centro_custos = r.FKid_centro_custosCol AND a.tipo = '{$tipo}' AND MONTH(r.data_pagamento_recebimento) = $mes AND YEAR(r.data_pagamento_recebimento) = $ano AND a.nome = '{$area}' AND r.FKid_condominiosCol = $condominio ORDER BY a.id_area_custos, c.id_centro_custos");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['soma'];
		}
		return $result;
	}
	
	function somaTotal($tipo, $mes, $ano, $condominio){
		$result = false;
		$rs = mysql_query("SELECT sum(r.valor_pago) as soma FROM centro_custos c, area_custos a, receita_despesa r WHERE c.FKid_area_custosCol = a.id_area_custos AND c.id_centro_custos = r.FKid_centro_custosCol AND a.tipo = '{$tipo}' AND MONTH(r.data_pagamento_recebimento) = $mes AND YEAR(r.data_pagamento_recebimento) = $ano AND r.FKid_condominiosCol = $condominio ORDER BY a.id_area_custos, c.id_centro_custos");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['soma'];
		}
		return $result;
	}
	
	
	function existeByCondominioTipoAreaDocumentoCentro($id_condominio, $tipo_area, $documento, $centro){
		$result = false;
		$rs = mysql_query("SELECT r.id_receita_despesa FROM receita_despesa r, centro_custos c, area_custos a WHERE r.documento = '{$documento}' AND r.FKid_condominiosCol = $id_condominio AND a.tipo like '%{$tipoArea}%' AND a.id_area_custos = c.FKid_area_custosCol AND r.FKid_centro_custosCol = c.id_centro_custos AND c.id_centro_custos = $centro ");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}	
	
	function existeByCondominioTipoAreaDocumentoCentroId($id_condominio, $tipo_area, $documento, $centro, $id){
		$result = false;
		$rs = mysql_query("SELECT r.id_receita_despesa FROM receita_despesa r, centro_custos c, area_custos a WHERE r.documento = '{$documento}' AND r.FKid_condominiosCol = $id_condominio AND a.tipo like '%{$tipoArea}%' AND a.id_area_custos = c.FKid_area_custosCol AND r.FKid_centro_custosCol = c.id_centro_custos AND r.id_receita_despesa <> $id AND c.id_centro_custos = $centro");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}	
	
	
	
	function save($receita_despesa){	
	
		if ( $receita_despesa->id == 0 ){
			return mysql_query("INSERT INTO receita_despesa (FKid_condominiosCol, FKid_centro_custosCol, data_emissao, data_vencimento, data_pagamento_recebimento, documento, valor, forma_pagamento, observacao, pagante_fornecedor, valor_pago, situacao, recebido_pago) VALUES ({$receita_despesa->id_condominio}, {$receita_despesa->id_centro}, '{$receita_despesa->data_emissao}', '{$receita_despesa->data_vencimento}', '{$receita_despesa->data_pagamento_recebimento}', '{$receita_despesa->documento}', '{$receita_despesa->valor}', '{$receita_despesa->forma_pagamento}', '{$receita_despesa->observacao}', '{$receita_despesa->pagante_fornecedor}', '{$receita_despesa->valor_pago}', '{$receita_despesa->status}', '{$receita_despesa->recebido_pago}')");
		}else{
			return mysql_query("UPDATE receita_despesa SET FKid_condominiosCol = {$receita_despesa->id_condominio}, FKid_centro_custosCol = {$receita_despesa->id_centro}, data_emissao = '{$receita_despesa->data_emissao}', data_vencimento = '{$receita_despesa->data_vencimento}', data_pagamento_recebimento = '{$receita_despesa->data_pagamento_recebimento}', documento = '{$receita_despesa->documento}', valor = '{$receita_despesa->valor}', forma_pagamento = '{$receita_despesa->forma_pagamento}', observacao = '{$receita_despesa->observacao}', pagante_fornecedor = '{$receita_despesa->pagante_fornecedor}', valor_pago = '{$receita_despesa->valor_pago}', situacao = '{$receita_despesa->status}', recebido_pago = '{$receita_despesa->recebido_pago}' WHERE id_receita_despesa = {$receita_despesa->id}");
		}
	}
	
	function delete($id){
		mysql_query("DELETE FROM receita_despesa WHERE id_receita_despesa = $id");
	}
}
?>