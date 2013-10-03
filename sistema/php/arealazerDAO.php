<?php 
class arealazerDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM areas_lazer ORDER BY id_areas_lazer");
		while ( $r = mysql_fetch_array($rs)){
			$arealazer= new arealazer();			
			$arealazer->id = $r['id_areas_lazer'];
			$arealazer->id_condominio = $r['FKid_condominiosCol'];
			$arealazer->nome = $r['nome'];
			$arealazer->tamanho = $r['tamanho'];
			$arealazer->funcionamento = $r['FKid_funcionamentoCol'];
			$arealazer->status = $r['situacao'];			
			$result[] = $arealazer;
		}
		return $result;
	}
	
	function findTop($i = 0, $f = 0, $orderBy = "nome", $ordem = "ASC"){
		$result = false;				
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM areas_lazer ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM areas_lazer ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
            $arealazer= new arealazer();			
			$arealazer->id = $r['id_areas_lazer'];
			$arealazer->id_condominio = $r['FKid_condominiosCol'];
			$arealazer->nome = $r['nome'];
			$arealazer->tamanho = $r['tamanho'];
			$arealazer->funcionamento = $r['FKid_funcionamentoCol'];
			$arealazer->status = $r['situacao'];			
			$result[] = $arealazer;
  		}
		return $result;
	}
	
	function findTopByBusca($nome, $funcionamento, $condominio, $i = 0, $f = 0, $orderBy = "id_areas_lazer", $ordem = "ASC"){
		$result = false;
		$condicoes = "";
		$from = 'areas_lazer a';
		if ($nome != "") {
			$condicoes = " AND a.nome LIKE '%".$nome."%' ";
		}
		if ($funcionamento != ""){
			$condicoes = $condicoes." AND a.FKid_funcionamentoCol = ".$funcionamento." ";
		}		
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  a.FKid_condominiosCol = cond.id_condominios";
				$from = $from.', condominios cond';			
		}						
		if ($f > 0)
			$rs = mysql_query("SELECT a.* FROM $from WHERE a.situacao = 1".$condicoes." OR a.situacao = 0".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT a.* FROM $from WHERE a.situacao = 1".$condicoes." OR a.situacao = 0".$condicoes." ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
        	$arealazer= new arealazer();			
			$arealazer->id = $r['id_areas_lazer'];
			$arealazer->id_condominio = $r['FKid_condominiosCol'];
			$arealazer->nome = $r['nome'];
			$arealazer->tamanho = $r['tamanho'];
			$arealazer->funcionamento = $r['FKid_funcionamentoCol'];
			$arealazer->status = $r['situacao'];			
			$result[] = $arealazer;
  		}
		return $result;
	}	
	
    function findByPk($id){
		$return = false;
		$rs = mysql_query("SELECT * FROM areas_lazer WHERE id_areas_lazer = $id");
		while ( $r = mysql_fetch_array($rs) ){
			$arealazer= new arealazer();
			$arealazer->id = $r['id_areas_lazer'];
			$arealazer->id_condominio = $r['FKid_condominiosCol'];
			$arealazer->nome = $r['nome'];
			$arealazer->tamanho = $r['tamanho'];
			$arealazer->funcionamento = $r['FKid_funcionamentoCol'];
			$arealazer->status = $r['situacao'];		
			$result = $arealazer;
		}
		return $result;
	}   
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM areas_lazer WHERE situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countByBusca($nome, $funcionamento, $condominio){
		$result = false;
		$condicoes = "";
		$from = 'areas_lazer a';
		if ($nome != "") {
			$condicoes = " AND a.nome LIKE '%".$nome."%' ";
		}
		if ($funcionamento != ""){
			$condicoes = $condicoes." AND a.FKid_funcionamentoCol = ".$funcionamento." ";
		}		
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  a.FKid_condominiosCol = cond.id_condominios";
				$from = $from.', condominios cond';			
		}				
		$rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE a.situacao = 1".$condicoes." OR a.situacao = 0".$condicoes." ORDER BY a.nome");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}	
	
	function existeByNome($nome, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_areas_lazer FROM areas_lazer WHERE nome = '{$nome}' AND FKid_condominiosCol = $condominio");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByNomeId($nome, $id, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_areas_lazer FROM areas_lazer WHERE nome = '{$nome}' and id_areas_lazer <> $id AND FKid_condominiosCol = $condominio");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
		
	function delete($id){
		mysql_query("UPDATE areas_lazer SET situacao = 0 WHERE id_areas_lazer = $id ");		
	}
   
   function save($arealazer){ 
		if ( $arealazer->id == 0){
			return mysql_query("INSERT INTO areas_lazer (FKid_condominiosCol, nome, tamanho, FKid_funcionamentoCol, situacao) VALUES ({$arealazer->id_condominio}, '{$arealazer->nome}', '{$arealazer->tamanho}', {$arealazer->funcionamento}, '{$arealazer->status}')");
		}else{
			return mysql_query("UPDATE areas_lazer SET FKid_condominiosCol = {$arealazer->id_condominio}, nome = '{$arealazer->nome}', tamanho = '{$arealazer->tamanho}',   	FKid_funcionamentoCol = {$arealazer->funcionamento}, situacao = '{$arealazer->status}' WHERE id_areas_lazer = {$arealazer->id}");
		}
	}

}
?>