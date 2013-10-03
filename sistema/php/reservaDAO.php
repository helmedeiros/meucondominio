<?php 
class reservaDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM reservas WHERE situacao = 1 ORDER BY data_inicio");
		while ( $r = mysql_fetch_array($rs)){
			$reserva= new reserva();	
			$reserva->id = $r['id_reservas'];
			$reserva->id_membro = $r['FKid_membroscondominioCol'];
			$reserva->id_objeto = $r['FKid_objetos_lazerCol'];
			$reserva->data_inicio = $r['data_inicio'];
			$reserva->data_fim = $r['data_fim'];
			$reserva->comentario = $r['comentario'];
			$reserva->status = $r['situacao'];								
			$result[] = $reserva;
		}
		return $result;
	}
	
	function findTop($i = 0, $f = 0, $orderBy = "data_inicio", $ordem = "DESC"){
		$result = false;				
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM reservas WHERE situacao = 1 ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM reservas WHERE situacao = 1 ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
        	$reserva= new reserva();	
			$reserva->id = $r['id_reservas'];
			$reserva->id_membro = $r['FKid_membroscondominioCol'];
			$reserva->id_objeto = $r['FKid_objetos_lazerCol'];
			$reserva->data_inicio = $r['data_inicio'];
			$reserva->data_fim = $r['data_fim'];
			$reserva->comentario = $r['comentario '];
			$reserva->status = $r['situacao'];
			$result[] = $reserva;
  		}
		return $result;
	}
	
	function findTopByBusca($objeto, $membro, $condominio, $dataInicio, $dataFim,  $i = 0, $f = 0, $orderBy = "r.data_inicio", $ordem = "DESC"){
		$result = false;
		$condicoes = "";
		$from = 'reservas r';
		$from = $from.', objetos_lazer o, areas_lazer a';		
		if ($objeto != ""){
			if(is_numeric($objeto)){
				$condicoes = $condicoes." AND o.id_objetos_lazer = ".$objeto." ";
			}else{
				$condicoes = $condicoes." AND o.nome like '%".$objeto."%' ";				
			}
				$condicoes = $condicoes." AND  o.id_objetos_lazer = r.FKid_objetos_lazerCol";
						
		}		
		if ($membro != ""){
			if(is_numeric($membro)){
				$condicoes = $condicoes." AND m.id_membroscondominio = ".$membro." ";
			}else{
				$condicoes = $condicoes." AND m.nome like '%".$membro."%' ";
			}
				$condicoes = $condicoes." AND  m.id_membroscondominio = r.FKid_membroscondominioCol";
				$from = $from.', membros_condominio m';								
		}	
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  o.id_objetos_lazer = r.FKid_objetos_lazerCol AND o.FKid_areas_lazerCol = a.id_areas_lazer AND  a.FKid_condominiosCol = cond.id_condominios";
				
				$from = $from.', condominios cond';			
		}	
		if ($dataInicio != "") {
			$condicoes .= " AND r.data_inicio = '".$dataInicio."' ";
		}	
		if ($dataFim != "") {
			$condicoes .= " AND r.data_fim = '".$dataFim."' ";
		}				
			
		
		if ($f > 0)
			$rs = mysql_query("SELECT distinct r.* FROM $from WHERE r.situacao = 1".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT distinct r.* FROM $from WHERE r.situacao = 1".$condicoes." ORDER BY $orderBy $ordem");
		
		while ( $r = mysql_fetch_array($rs)){
        	$reserva= new reserva();	
			$reserva->id = $r['id_reservas'];
			$reserva->id_membro = $r['FKid_membroscondominioCol'];
			$reserva->id_objeto = $r['FKid_objetos_lazerCol'];
			$reserva->data_inicio = $r['data_inicio'];
			$reserva->data_fim = $r['data_fim'];
			$reserva->comentario = $r['comentario '];
			$reserva->status = $r['situacao'];	
			$result[] = $reserva;
  		}					
		return $result;
	}	
	
    function findByPk($id){
		$return = false;
		$rs = mysql_query("SELECT * FROM reservas WHERE situacao = 1 AND id_reservas = $id");
		while ( $r = mysql_fetch_array($rs) ){
			$reserva= new reserva();	
			$reserva->id = $r['id_reservas'];
			$reserva->id_membro = $r['FKid_membroscondominioCol'];
			$reserva->id_objeto = $r['FKid_objetos_lazerCol'];
			$reserva->data_inicio = $r['data_inicio'];
			$reserva->data_fim = $r['data_fim'];
			$reserva->comentario = $r['comentario '];
			$reserva->status = $r['situacao'];
			$result = $reserva;
		}
		return $result;
	}   
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM reservas");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countByBusca($objeto, $membro, $condominio, $dataInicio, $dataFim){
		$result = false;
		$condicoes = "";
		$from = 'reservas r';
		$from = $from.', objetos_lazer o, areas_lazer a';		
		if ($objeto != ""){
			if(is_numeric($objeto)){
				$condicoes = $condicoes." AND o.id_objetos_lazer = ".$objeto." ";
			}else{
				$condicoes = $condicoes." AND o.nome like '%".$objeto."%' ";				
			}
				$condicoes = $condicoes." AND  o.id_objetos_lazer = r.FKid_objetos_lazerCol";
						
		}		
		if ($membro != ""){
			if(is_numeric($membro)){
				$condicoes = $condicoes." AND m.id_membroscondominio = ".$membro." ";
			}else{
				$condicoes = $condicoes." AND m.nome like '%".$membro."%' ";
			}
				$condicoes = $condicoes." AND  m.id_membroscondominio = r.FKid_membroscondominioCol";
				$from = $from.', membros_condominio m';								
		}	
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  o.id_objetos_lazer = r.FKid_objetos_lazerCol AND o.FKid_areas_lazerCol = a.id_areas_lazer AND  a.FKid_condominiosCol = cond.id_condominios";
				
				$from = $from.', condominios cond';			
		}	
		if ($dataInicio != "") {
			$condicoes .= " AND r.data_inicio LIKE = '".$dataInicio."' ";
		}	
		if ($dataFim != "") {
			$condicoes .= " AND r.data_fim LIKE = '".$dataFim."' ";
		}				
		

		
		$rs = mysql_query("SELECT distinct COUNT(*) AS total FROM $from WHERE r.situacao = 1".$condicoes." ORDER BY r.data_inicio");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}	
	
	function delete($id){		
			mysql_query("UPDATE reservas SET situacao = 0 WHERE id_reservas = $id");
	}
   
   function save($reserva){
   		if ( $reserva->id == 0){
			return mysql_query("INSERT INTO reservas (FKid_membroscondominioCol, FKid_objetos_lazerCol, data_inicio, data_fim, comentario, situacao) VALUES ({$reserva->id_membro}, {$reserva->id_objeto}, '{$reserva->data_inicio}', '{$reserva->data_fim}', '{$reserva->comentario}', {$reserva->status})");
		}else{
			return mysql_query("UPDATE reservas SET FKid_membroscondominioCol = {$reserva->id_membro}, FKid_objetos_lazerCol = {$reserva->id_objeto}, data_inicio = '{$reserva->data_inicio}', data_fim = '{$reserva->data_fim}', comentario = '{$reserva->comentario}', situacao = {$reserva->status} WHERE id_reservas = {$reserva->id}");
		}
	}

}
?>