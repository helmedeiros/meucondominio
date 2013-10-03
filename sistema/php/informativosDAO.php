<?php 
class informativosDAO{

       function findALL(){
              $return = false;
              $rs = mysql_query("SELECT * FROM informativos");
              while ( $r = mysql_fetch_array($rs)){
			      $informativos = new informativos();
                  $informativos->id = $r['id_informativos'];
                  $informativos->id_criticas_sugetoes = $r['FKid_criticas_sugestoesCol'];
                  $informativos->descricao = $r['descricao'];
				  $informativos->data = $r['data'];
                  $result[] = $informativos;
    }
  return $result;
 }
        
       function findALLByCS($cs){
              $return = false;
              $rs = mysql_query("SELECT * FROM informativos WHERE FKid_criticas_sugestoesCol = $cs ");
              while ( $r = mysql_fetch_array($rs)){
  			      $informativos = new informativos();
                  $informativos->id = $r['id_informativos'];
                  $informativos->id_criticas_sugetoes = $r['FKid_criticas_sugestoesCol'];
                  $informativos->descricao = $r['descricao'];
				  $informativos->data = $r['data'];
                  $result[] = $informativos;
    }
  return $result;
 }
 
       function save($informativos){
	 	 return mysql_query("INSERT INTO informativos (FKid_criticas_sugestoesCol, descricao, data) VALUES ('{$informativos->id_criticas_sugestoes}', '{$informativos->descricao}', '{$informativos->data}')");
}

       function saveFnc($id, $id_funcionario){
	 	 return mysql_query("INSERT INTO publico_alvo (FKid_atividadesCol, FKid_tipos_funcionariosCol, situacao) VALUES ('{$id}', '{$id_funcionario}', 1)");
}

   function delete($id){
  	 mysql_query("UPDATE publico_alvo SET situacao = 0 WHERE FKid_atividadesCol = $id");
   }
}
?>