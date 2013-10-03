<?php 
class areacustosDAO{
       function findALL(){
              $return = false;
              $rs = mysql_query("SELECT * FROM area_custos WHERE situacao = 1 ORDER BY id_area_custos");
              while ( $r = mysql_fetch_array($rs)){
                  $areacustos=new areacustos();
                  $areacustos->id = $r['id_area_custos'];
                  $areacustos->nome = $r['nome'];
                  $areacustos->tipo = $r['tipo'];
				  $areacustos->status = $r['situcao'];
                  $result[] = $areacustos;
    }
  return $result;
 }
       function findByPk($id){
              $return = false;
              $rs = mysql_query("SELECT * FROM area_custos WHERE id_area_custos = $id AND situacao = 1");
              while ( $r = mysql_fetch_array($rs) ){
                  $areacustos= new areacustos();
                  $areacustos->id = $r['id_area_custos'];
                  $areacustos->nome = $r['nome'];
                  $areacustos->tipo = $r['tipo'];
  				  $areacustos->status = $r['situcao'];
                  $result = $areacustos;
              }
          return $result;
   }
       function save($areacustos){
        if ( $areacustos->id == 0){
    return mysql_query("INSERT INTO area_custos (nome, tipo, situacao) VALUES ('{$areacustos->nome}', '{$areacustos->tipo}', {$areacustos->status})");
     }else{
    return mysql_query("UPDATE area_custos SET nome = '{$areacustos->nome}', tipo= '{$areacustos->tipo}', situacao = '{$areacustos->status}' WHERE id_area_custos = {$areacustos->id}");
}
}

	function countByBusca($nome, $tipo){
		$return = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($tipo != ""){
     		$condicoes = $condicoes." AND tipo LIKE '%".$tipo."%' ";
			}				
		$rs = mysql_query("SELECT COUNT(*) AS total FROM area_custos WHERE situacao = 1".$condicoes."ORDER BY id_area_custos ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}

function findTopByBusca($nome, $tipo, $i = 0, $f = 0){
		$result = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($tipo != ""){
			$condicoes = $condicoes." AND tipo LIKE '%".$tipo."%' ";
		}		
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM area_custos WHERE situacao = 1".$condicoes." ORDER BY id_area_custos ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM area_custos WHERE situacao = 1".$condicoes." ORDER BY id_area_custos ASC");
		while ( $r = mysql_fetch_array($rs)){
             $areacustos= new areacustos();
             $areacustos->id = $r['id_area_custos'];
             $areacustos->nome = $r['nome'];
             $areacustos->tipo = $r['tipo'];
             $areacustos->status = $r['situcao'];
             $result[] = $areacustos;
  		}
		return $result;
	}	

	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		$rs = mysql_query("SELECT * FROM area_custos WHERE situacao = 1 ORDER BY id_area_custos ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM area_custos WHERE situacao = 1 ORDER BY id_area_custos ASC");
		while ( $r = mysql_fetch_array($rs)){
             $areacustos=new areacustos();
             $areacustos->id = $r['id_area_custos'];
             $areacustos->nome = $r['nome'];
             $areacustos->tipo = $r['tipo'];
             $areacustos->status = $r['situcao'];
             $result[] = $areacustos;
  		}
		return $result;
	}

	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM area_custos WHERE situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
		
	function delete($id){
		mysql_query("UPDATE area_custos SET situacao = 0 WHERE id_area_custos = $id ");
		mysql_query("UPDATE centro_custos SET situacao = 0 WHERE c.FKid_area_custosCol = $id");
	}
}
?>