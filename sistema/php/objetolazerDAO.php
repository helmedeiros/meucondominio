<?php 
class objetolazerDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM objetos_lazer ORDER BY id_objetos_lazer");
		while ( $r = mysql_fetch_array($rs)){
			$objetolazer= new objetolazer();	
			$objetolazer->id = $r['id_objetos_lazer'];
			$objetolazer->id_area = $r['FKid_areas_lazerCol'];
			$objetolazer->funcionamento = $r['FKid_funcionamentoCol'];
    		$objetolazer->nome = $r['nome'];
			$objetolazer->inicio = $r['inicio'];
			$objetolazer->fim = $r['fim'];
    		$objetolazer->idade_minima = $r['idade_minima_utilizacao'];
			$objetolazer->tempo_minimo = $r['tempo_minimo_reserva'];
			$objetolazer->tempo_maximo = $r['tempo_maximo_reserva'];
			$objetolazer->descricao = $r['descricao'];
			$objetolazer->aviso = $r['aviso'];
    		$objetolazer->status = $r['situacao'];							
			$result[] = $objetolazer;
		}
		return $result;
	}
	
	function findTop($i = 0, $f = 0, $orderBy = "nome", $ordem = "ASC"){
		$result = false;				
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM objetos_lazer ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM objetos_lazer ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
        	$objetolazer= new objetolazer();	
			$objetolazer->id = $r['id_objetos_lazer'];
			$objetolazer->id_area = $r['FKid_areas_lazerCol'];
			$objetolazer->funcionamento = $r['FKid_funcionamentoCol'];
    		$objetolazer->nome = $r['nome'];
			$objetolazer->inicio = $r['inicio'];
			$objetolazer->fim = $r['fim'];
    		$objetolazer->idade_minima = $r['idade_minima_utilizacao'];
			$objetolazer->tempo_minimo = $r['tempo_minimo_reserva'];
			$objetolazer->tempo_maximo = $r['tempo_maximo_reserva'];
			$objetolazer->descricao = $r['descricao'];
			$objetolazer->aviso = $r['aviso'];
    		$objetolazer->status = $r['situacao'];
			$result[] = $objetolazer;
  		}
		return $result;
	}
	
	function findTopByBusca($nome, $funcionamento, $area, $condominio, $i = 0, $f = 0, $orderBy = "id_objetos_lazer", $ordem = "ASC"){
		$result = false;
		$condicoes = "";
		$from = 'objetos_lazer o';
		$from = $from.', areas_lazer a';		
		if ($nome != "") {
			$condicoes = " AND o.nome LIKE '%".$nome."%' ";
		}
		if ($funcionamento != ""){
			$condicoes = $condicoes." AND o.FKid_funcionamentoCol = ".$funcionamento." ";
		}		
		if ($area != ""){
			if(is_numeric($area)){
				$condicoes = $condicoes." AND a.id_areas_lazer = ".$area." ";
			}else{
				$condicoes = $condicoes." AND a.nome like '%".$area."%' ";
				
			}
				$condicoes = $condicoes." AND  o.FKid_areas_lazerCol = a.id_areas_lazer";
						
		}	
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  o.FKid_areas_lazerCol = a.id_areas_lazer AND  a.FKid_condominiosCol = cond.id_condominios";
				
				$from = $from.', condominios cond';			
		}		
		
		if ($f > 0)
			$rs = mysql_query("SELECT o.* FROM $from WHERE o.situacao = 1".$condicoes." OR o.situacao = 0".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT o.* FROM $from WHERE o.situacao = 1".$condicoes." OR o.situacao = 0".$condicoes." ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
        	$objetolazer= new objetolazer();	
			$objetolazer->id = $r['id_objetos_lazer'];
			$objetolazer->id_area = $r['FKid_areas_lazerCol'];
			$objetolazer->funcionamento = $r['FKid_funcionamentoCol'];
    		$objetolazer->nome = $r['nome'];
			$objetolazer->inicio = $r['inicio'];
			$objetolazer->fim = $r['fim'];
    		$objetolazer->idade_minima = $r['idade_minima_utilizacao'];
			$objetolazer->tempo_minimo = $r['tempo_minimo_reserva'];
			$objetolazer->tempo_maximo = $r['tempo_maximo_reserva'];
			$objetolazer->descricao = $r['descricao'];
			$objetolazer->aviso = $r['aviso'];
    		$objetolazer->status = $r['situacao'];	
			$result[] = $objetolazer;
  		}
		return $result;
	}	
	
    function findByPk($id){
		$return = false;
		$rs = mysql_query("SELECT * FROM objetos_lazer WHERE id_objetos_lazer = $id");
		while ( $r = mysql_fetch_array($rs) ){
			$objetolazer= new objetolazer();	
			$objetolazer->id = $r['id_objetos_lazer'];
			$objetolazer->id_area = $r['FKid_areas_lazerCol'];
			$objetolazer->funcionamento = $r['FKid_funcionamentoCol'];
    		$objetolazer->nome = $r['nome'];
			$objetolazer->inicio = $r['inicio'];
			$objetolazer->fim = $r['fim'];
    		$objetolazer->idade_minima = $r['idade_minima_utilizacao'];
			$objetolazer->tempo_minimo = $r['tempo_minimo_reserva'];
			$objetolazer->tempo_maximo = $r['tempo_maximo_reserva'];
			$objetolazer->descricao = $r['descricao'];
			$objetolazer->aviso = $r['aviso'];
    		$objetolazer->status = $r['situacao'];
			$result = $objetolazer;
		}		
		return $result;
	}   
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM objetos_lazer WHERE situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countByBusca($nome, $funcionamento, $area, $condominio){
		$result = false;
		$condicoes = "";
		$from = 'objetos_lazer o';
		$from = $from.', areas_lazer a';
		if ($nome != "") {
			$condicoes = " AND o.nome LIKE '%".$nome."%' ";
		}
		if ($funcionamento != ""){
			$condicoes = $condicoes." AND o.FKid_funcionamentoCol = ".$funcionamento." ";
		}		
		if ($area != ""){
			if(is_numeric($area)){
				$condicoes = $condicoes." AND a.id_areas_lazer = ".$area." ";
			}else{
				$condicoes = $condicoes." AND a.nome like '%".$area."%' ";
				
			}
				$condicoes = $condicoes." AND  o.FKid_areas_lazerCol = a.id_areas_lazer";
											
		}	
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  o.FKid_areas_lazerCol = a.id_areas_lazer AND  a.FKid_condominiosCol = cond.id_condominios";
			
				$from = $from.', condominios cond';			
		}			
		$rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE a.situacao = 1".$condicoes." OR a.situacao = 0".$condicoes." ORDER BY a.nome");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}	
	
	function existeByNome($nome, $area){
		$result = false;
		$rs = mysql_query("SELECT id_objetos_lazer FROM objetos_lazer WHERE nome = '{$nome}' AND FKid_areas_lazerCol = $area");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByNomeId($nome, $id, $area){
		$result = false;
		$rs = mysql_query("SELECT id_objetos_lazer FROM objetos_lazer WHERE nome = '{$nome}' and id_objetos_lazer <> $id AND FKid_areas_lazerCol = $area");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
		
	function delete($id){		
			mysql_query("UPDATE objetos_lazer SET situacao = 0 WHERE id_objetos_lazer = $id");
	}
   
   function save($objetolazer){
   		if ( $objetolazer->id == 0){
			return mysql_query("INSERT INTO objetos_lazer (FKid_funcionamentoCol, FKid_areas_lazerCol, nome, inicio, fim, idade_minima_utilizacao, tempo_minimo_reserva, tempo_maximo_reserva, descricao, aviso, situacao) VALUES ({$objetolazer->funcionamento}, {$objetolazer->id_area}, '{$objetolazer->nome}', '{$objetolazer->inicio}', '{$objetolazer->fim}', '{$objetolazer->idade_minima}', '{$objetolazer->tempo_minimo}', '{$objetolazer->tempo_maximo}', '{$objetolazer->descricao}', '{$objetolazer->aviso}', {$objetolazer->status})");
		}else{
			return mysql_query("UPDATE objetos_lazer SET FKid_funcionamentoCol = {$objetolazer->funcionamento}, FKid_areas_lazerCol = {$objetolazer->id_area}, nome = '{$objetolazer->nome}', inicio = '{$objetolazer->inicio}', fim = '{$objetolazer->fim}',idade_minima_utilizacao = '{$objetolazer->idade_minima}', tempo_minimo_reserva = '{$objetolazer->tempo_minimo}', tempo_maximo_reserva = '{$objetolazer->tempo_maximo}', descricao = '{$objetolazer->descricao}', aviso = '{$objetolazer->aviso}', situacao = {$objetolazer->status} WHERE id_objetos_lazer = {$objetolazer->id}");
		}
	}

}
?>