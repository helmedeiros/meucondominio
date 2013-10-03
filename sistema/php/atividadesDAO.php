<?php 
class atividadesDAO{

function countAll($idcondominios){
		$result = false;
  		$rs = mysql_query("SELECT COUNT(*) AS total FROM atividades WHERE situacao =  1 AND FKid_condominiosCol = $idcondominios");
		if ($r = mysql_fetch_array($rs) ){
		 $result = $r['total'];
		}
		return $result;
		
	}
	
function countByBusca($titulo, $data, $responsavel){
		$return = false;
		$condicoes = "";
		$from = 'atividades atv';
		if ($titulo != "") {
			$condicoes = " AND titulo LIKE '%".$titulo."%' ";
		}
		if ($data != ""){
			$condicoes = $condicoes." AND data_realizacao LIKE '%".$data."%' ";
		}		
		if ($responsavel != ""){
			if(is_numeric($responsavel)){
				$condicoes = $condicoes." AND FKid_membroscondominioCol = ".$responsavel." ";
			}else{
				$condicoes = $condicoes." AND mb.nome like '%".$responsavel."%' ";
				$condicoes = $condicoes." AND mb.id_membroscondominio = atv.FKid_membroscondominioCol";
				$from = $from.', membros_condominio mb';
			}
		}		
		 $rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE atv.situacao = 1".$condicoes." ORDER BY id_atividades");
 		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	 }
	  

	function findTopByBusca($titulo, $data, $responsavel, $i = 0, $f = 0, $orderBy = "atv.id_atividades", $ordem = "ASC"){
		$return = false;
		$condicoes = "";
		$from = 'atividades atv';
		if ($titulo != "") {
			$condicoes = " AND titulo LIKE '%".$titulo."%' ";
		}
		if ($data != ""){
			$condicoes = $condicoes." AND data_realizacao LIKE '%".$data."%' ";
		}		
		if ($responsavel != ""){
			if(is_numeric($responsavel)){
				$condicoes = $condicoes." AND FKid_membroscondominioCol = ".$responsavel." ";
			}else{
				$condicoes = $condicoes." AND mb.nome like '%".$responsavel."%' ";
				$condicoes = $condicoes." AND mb.id_membroscondominio = atv.FKid_membroscondominioCol";
				$from = $from.', membros_condominio mb';
			}
		}			
		if ($f > 0)  
 $rs = mysql_query("SELECT * FROM $from WHERE atv.situacao = 1".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f"); 
 else
 $rs = mysql_query("SELECT * FROM $from WHERE atv.situacao = 1".$condicoes." ORDER BY $orderBy $ordem"); 
		while ($r = mysql_fetch_array($rs) ){
		     $atividades = new atividades();
			$atividades->id = $r['id_atividades'];
			$atividades->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$atividades->id_condominio = $r['FKid_condominiosCol'];
            $atividades->id_prioridade = $r['FKid_niveis_prioridadesCol'];			
			$atividades->data_realizacao = $r['data_realizacao'];
			$atividades->descricao = $r['descricao'];
			$atividades->titulo = $r['titulo'];
			$atividades->status = $r['situacao'];
			$result[] = $atividades;
		}
		return $result;
	}

	function findTop($idcondominios, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		   $rs = mysql_query("SELECT * FROM atividades WHERE situacao = 1 AND FKid_condominiosCol = $idcondominios ORDER BY id_atividades ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM atividades WHERE situacao = 1 AND FKid_condominiosCol = $idcondominios ORDER BY id_atas_reunioes ASC");
		while ( $r = mysql_fetch_array($rs)){
		     $atividades = new atividades();
			$atividades->id = $r['id_atividades'];
			$atividades->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$atividades->id_condominio = $r['FKid_condominiosCol'];
            $atividades->id_prioridade = $r['FKid_niveis_prioridadesCol'];			
			$atividades->data_realizacao = $r['data_realizacao'];
			$atividades->descricao = $r['descricao'];
			$atividades->titulo = $r['titulo'];
			$atividades->status = $r['situacao'];
			$result[] = $atividades;
		}
		return $result;
	}
	
	function findAnunciante($id, $idanunciante){
		$result = false;
		$rs = mysql_query("SELECT m.nome FROM atividades a, membros_condominio m WHERE a.id_atividades = $id AND m.id_membroscondominio = $idanunciante");
		while ( $r = mysql_fetch_array($rs)){
		    $nome = $r['nome'];
			$result = $nome;
  		}
		return $result;
	}

  /*     function findALL(){
              $return = false;
              $rs = mysql_query("SELECT a.* FROM atas_reunioes a, membros_condominio m, condominios c WHERE
                                a.FKid_membroscondominioCol = m.id_membroscondominio AND
                                m.FKid_condominiosCol = c.id_condominios ORDER BY a.data_insercao");
              while ( $r = mysql_fetch_array($rs)){
                  $atasreunioes=new atasreunioes();
                  $atasreunioes->id = $r['id_atas_reunioes'];
                  $atasreunioes->id_membroscondominio = $r['FKid_membroscondominioCol'];
                  $atasreunioes->data_insercao = $r['data_insercao'];
                  $atasreunioes->nome_arquivo = $r['nome_arquivo'];
                  $result[] = $atasreunioes;
    }
  return $result;
 } */
		   function findByPk($id){
              $return = false;
              $rs = mysql_query("SELECT * FROM atividades WHERE id_atividades = $id AND situacao = 1");
              while ( $r = mysql_fetch_array($rs) ){
            $atividades = new atividades();
			$atividades->id = $r['id_atividades'];
			$atividades->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$atividades->id_condominio = $r['FKid_condominiosCol'];
            $atividades->id_prioridade = $r['FKid_niveis_prioridadesCol'];			
			$atividades->data_realizacao = $r['data_realizacao'];
			$atividades->descricao = $r['descricao'];
			$atividades->titulo = $r['titulo'];
			$atividades->status = $r['situacao'];
			$result = $atividades;
              }
          return $result;
   }
   
      function lastId(){
           $return = false;
              $rs = mysql_query("SELECT id_atividades FROM atividades ORDER BY id_atividades DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
                $lid =  $r['id_atividades'];;
		     	$result = $lid;
      	}
          return $result;
   }
    
       function save($atividades, $i = 0){
         return mysql_query("INSERT INTO atividades (FKid_membroscondominioCol, FKid_condominiosCol, data_realizacao, descricao, titulo, situacao, FKid_niveis_prioridadesCol) VALUES ('{$atividades->id_membroscondominio}', '{$atividades->id_condominio}', '{$atividades->data_realizacao}', '{$atividades->descricao}', '{$atividades->titulo}', 1, '{$atividades->id_prioridade}')");
		
}        
       function delete($id){
	  mysql_query("UPDATE atividades SET situacao = 0 WHERE id_atividades = $id");
   }
  }
?>