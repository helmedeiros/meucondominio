<?php 
class centrocustosDAO{
       function findALL(){
              $return = false;
              $rs = mysql_query("SELECT c.* FROM centro_custos c, area_custos a WHERE 
                                 c.FKid_area_custosCOL = a.id_area_custos AND situacao = 1 ORDER BY a.nome");
              while ( $r = mysql_fetch_array($rs)){
                  $centrocustos=new centrocustos();
                  $centrocustos->id = $r['id_centro_custos'];
                  $centrocustos->id_area_custos = $r['FKid_area_custosCol'];
                  $centrocustos->numero = $r['numero'];
                  $centrocustos->nome = $r['nome'];
				  $centrocustos->status = $r['situacao'];
                  $result[] = $centrocustos;
    }
	 return $result;
 }
       function findByPk($id, $area=""){
			   $condicoes = "";
	   		   if($area != ""){
			   		$condicoes = "AND FKid_area_custosCol = $area";
			   }			   
              $return = false;
              $rs = mysql_query("SELECT * FROM centro_custos WHERE id_centro_custos = $id ".$condicoes."  AND situacao = 1");
              while ( $r = mysql_fetch_array($rs) ){
                  $centrocustos= new centrocustos();
                  $centrocustos->id = $r['id_centro_custos'];
                  $centrocustos->id_area_custos = $r['FKid_area_custosCol'];
                  $centrocustos->numero = $r['numero'];
                  $centrocustos->nome = $r['nome'];
 				  $centrocustos->status = $r['situacao'];
                  $result = $centrocustos;
              }
          return $result;
   }

   function countAll($id){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM centro_custos WHERE situacao = 1 AND FKid_area_custosCol = $id");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function findByTipoArea($tipo){
		$result = false;
		$rs = mysql_query("SELECT c.id_centro_custos, c.numero, c.FKid_area_custosCol, c.nome, c.situacao FROM centro_custos c, area_custos a WHERE c.FKid_area_custosCol = a.id_area_custos AND a.tipo = '{$tipo}' ORDER BY FKid_area_custosCol ASC");
		while ($r = mysql_fetch_array($rs) ){
			$centrocustos= new centrocustos();
            $centrocustos->id = $r['id_centro_custos'];
            $centrocustos->id_area_custos = $r['FKid_area_custosCol'];
            $centrocustos->numero = $r['numero'];
            $centrocustos->nome = $r['nome'];
 			$centrocustos->status = $r['situacao'];
			$result[] = $centrocustos;		
		}
		return $result;
	}
  
  	function countByBusca($nome, $numero, $area){
		$return = false;
		$condicoes = "";
		  if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
				}
		if ($numero != ""){
     		$condicoes = $condicoes." AND numero LIKE '%".$numero."%' ";
			}				
					$rs = mysql_query("SELECT COUNT(*) AS total FROM centro_custos WHERE FKid_area_custosCol = $area AND situacao = 1".$condicoes."ORDER BY id_centro_custos ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		echo $result;
		return $result;
		
	}
	
	function findTopByBusca($nome, $numero, $area, $i = 0, $f = 0){
		$result = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($numero != ""){
			$condicoes = $condicoes." AND numero LIKE '%".$numero."%' ";
		}		
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM centro_custos WHERE FKid_area_custosCol = $area AND situacao = 1".$condicoes." ORDER BY id_centro_custos ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM centro_custos WHERE FKid_area_custosCol = $area AND situacao = 1".$condicoes." ORDER BY id_centro_custos ASC");
		while ( $r = mysql_fetch_array($rs)){
            $centrocustos= new centrocustos();
                  $centrocustos->id = $r['id_centro_custos'];
                  $centrocustos->id_area_custos = $r['FKid_area_custosCol'];
                  $centrocustos->numero = $r['numero'];
                  $centrocustos->nome = $r['nome'];
 				  $centrocustos->status = $r['situacao'];
            $result[] = $centrocustos;
  		}
		return $result;
	}	

	
 function existeByNumNomAr($nome, $numero, $area){
		$result = false;
		$rs = mysql_query("SELECT * FROM centro_custos WHERE nome = '$nome' AND FKid_area_custosCol = $area AND situacao = 1 OR numero = $numero AND FKid_area_custosCol = $area AND situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = true; 
			}
		return $result;
	}
	
	 function countLBA(){
		$result = false;
		$rs = mysql_query("SELECT count(*) AS total FROM area_custos a, centro_custos c WHERE c.FKid_area_custosCol = a.id_area_custos AND c.situacao = 1 AND a.situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
   
   function findTop($id, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM centro_custos WHERE situacao = 1 AND FKid_area_custosCol = $id ORDER BY numero ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM centro_custos WHERE situacao = 1 AND FKid_area_custosCol = $id ORDER BY numero ASC");
		while ( $r = mysql_fetch_array($rs)){
                  $centrocustos= new centrocustos();
                  $centrocustos->id = $r['id_centro_custos'];
                  $centrocustos->id_area_custos = $r['FKid_area_custosCol'];
                  $centrocustos->numero = $r['numero'];
                  $centrocustos->nome = $r['nome'];
 				  $centrocustos->status = $r['situacao'];
            $result[] = $centrocustos;
  		}
		return $result;
	}
	
	
       function save($centrocustos){
	     if ( $centrocustos->id == 0){
		return mysql_query("INSERT INTO centro_custos (numero, nome, FKid_area_custosCol, situacao) VALUES ({$centrocustos->numero}, '{$centrocustos->nome}', {$centrocustos->id_area_custos}, 1)");
     } else { 
	    return mysql_query("UPDATE centro_custos SET nome = '{$centrocustos->nome}', numero = {$centrocustos->numero}, situacao = {$centrocustos->status}, FKid_area_custosCol = {$centrocustos->id_area_custos} WHERE id_centro_custos = {$centrocustos->id}");		
}
}

       function delete($id){
     mysql_query("UPDATE centro_custos SET situacao = 0 WHERE id_centro_custos = $id");
   }
  }
?>