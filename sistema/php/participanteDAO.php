<?php 
class participanteDAO{
       function findALL(){
              $return = false;
              $rs = mysql_query("SELECT * FROM participante WHERE situacao = 1 ORDER BY funcao");
              while ( $r = mysql_fetch_array($rs)){
                  $participante=new participante();
                  $participante->id_atas_reunioes = $r['FKid_atas_reunioes'];
                  $participante->id_membroscondominio = $r['FKid_membroscondominioCol'];
                  $participante->funcao = $r['funcao'];
                  $result[] = $participante;
    }
  return $result;
 }
       function findByPk($id){
              $return = false;
              $rs = mysql_query("SELECT * FROM participante WHERE FKid_atas_reunioes = $id AND situacao = 1 ");
              while ( $r = mysql_fetch_array($rs) ){
                  $participante= new participante();
                  $participante->id_atas_reunioes = $r['FKid_atas_reunioes'];
                  $participante->id_membroscondominio = $r['FKid_membroscondominioCol'];
                  $participante->funcao = $r['funcao'];
                  $result = $participante;
              }
          return $result;
   }
   
        function countAllByAta($id){
              $return = false;
              $rs = mysql_query("SELECT COUNT( * ) AS total FROM participante WHERE FKid_atas_reunioesCol = $id AND situacao = 1 ");
              if ( $r = mysql_fetch_array($rs)){
				$result = $r['total'];
		}
		return $result;
	}

    

      function countAll($idcondominios){
		$result = false;
  		$rs = mysql_query("SELECT COUNT( * ) AS total FROM participante WHERE FKid_condominiosCol = $idcondominios AND situacao = 1 ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
   
   	function findTopByAta($id, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		   $rs = mysql_query("SELECT p.*, m.nome FROM participante p, membros_condominio m WHERE FKid_atas_reunioesCol = $id AND p.FKid_membroscondominioCol = m.id_membroscondominio AND p.situacao = 1 ORDER BY m.nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT p.*, m.nome FROM participante p, membros_condominio m WHERE FKid_atas_reunioesCol = $id AND p.FKid_membroscondominioCol = m.id_membroscondominio AND p.situacao = 1 ORDER BY m.nome  ASC");
		while ( $r = mysql_fetch_array($rs)){
		    $participante = new participante();
			$participante->id_atas_reunioes = $r['FKid_atas_reunioesCol'];
            $participante->id_membroscondominio = $r['FKid_membroscondominioCol'];
            $participante->funcao = $r['funcao'];			
			$result[] = $participante;
  		}
		return $result;
	}
   
       function save($participante){
	 	 return mysql_query("INSERT INTO participante (FKid_atas_reunioesCol, FKid_membroscondominioCol, funcao, situacao) VALUES ('{$participante->id_atas_reunioes}', '{$participante->id_membroscondominio}', '{$participante->funcao}', 1)");

}

   function delete($id){
	 mysql_query("UPDATE participante SET situacao = 0 WHERE FKid_atas_reunioesCol = $id");
   }
}
?>