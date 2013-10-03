<?php 
class destinatariosDAO{
       function findALL(){
              $return = false;
              $rs = mysql_query("SELECT * FROM destinatarios WHERE situacao = 1");
              while ( $r = mysql_fetch_array($rs)){
                  $destinatarios->id_atividades = $r['FKid_mensagensCol'];
                  $destinatarios->id_tipo_usuario = $r['FKid_tipos_funcionariosCol'];
                  $destinatarios->id_tipo_funcionario = $r['FKid_tipo_usuariosCol'];
                  $result[] = $destinatarios;
    }
  return $result;
 }
    
 
       function findByPk($id){
              $return = false;
              $rs = mysql_query("SELECT * FROM destinatarios WHERE FKid_mensagens = $id AND situacao = 1");
              while ( $r = mysql_fetch_array($rs) ){
                 $destinatarios=new destinatarios();
                  $destinatarios->id_mensagens = $r['FKid_mensagensCol'];
    $destinatarios->id_tipo_usuario = $r['FKid_tipos_funcionariosCol'];
    $destinatarios->id_tipo_funcionario = $r['FKid_tipo_usuariosCol'];
                  $result = $destinatarios;
              }
          return $result;
   }
   
        function countAllByAtv($id){
              $return = false;
              $rs = mysql_query("SELECT COUNT( * ) AS total FROM destinatarios WHERE FKid_mensagensCol = $id AND situacao = 1");
              if ( $r = mysql_fetch_array($rs)){
				$result = $r['total'];
		}
		return $result;
	}

/*   	function returnNome($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM publico_alvo WHERE id_membroscondominio = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$membroscondominio = $r['nome'];
        	$result = $membroscondominio;
		    }
        return $result;
   } */  
  

     
   
/*   	function findTopByUsr($id, $i = 0, $f = 0){
	die("SELECT a . * , t.nome FROM publico_alvo a, tipo_usuarios t WHERE FKid_atividadesCol = 1 AND a.FKid_tipo_usuariosCol = t.id_tipo_usuarios AND a.situacao = 1 ORDER BY t.nome ASC LIMIT 0 , 10");
		$result = false;
		if ($f > 0)
	   $rs = mysql_query("SELECT a.*, m.nome FROM publico_alvo a, tipo_usuarios t WHERE FKid_atividadesCol = $id AND a.FKid_tipo_usuariosColCol = t.id_tipo_usuarios AND a.situacao = 1 ORDER BY m.nome ASC LIMIT $i, $f");
		else
		$rs = mysql_query("SELECT a.*, m.nome FROM publico_alvo a, membros_condominio m WHERE FKid_atividadesCol = $id AND a.FKid_membroscondominioCol = m.id_membroscondominio AND a.situacao = 1 ORDER BY m.nome ASC");
		while ( $r = mysql_fetch_array($rs)){
		          $publico_alvo=new publico_alvo();
                  $publico_alvo->id_atividades = $r['FKid_atividadesCol'];
    			  $publico_alvo->id_tipo_usuario = $r['FKid_tipos_funcionariosCol'];
  				  $publico_alvo->id_tipo_funcionario = $r['FKid_tipo_usuariosCol'];
                  $result[] = $publico_alvo;
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
 */  

	    function findTopByFnc($id){
	   $result = "";
	  	$rs = mysql_query("SELECT FKid_tipos_funcionariosCol FROM destinatarios WHERE FKid_mensagensCol = $id");
		while($r = mysql_fetch_array($rs)){
		      if ($r['FKid_tipos_funcionariosCol'] != 0) {
			  if ($result == "") { 
			   $result = $r['FKid_tipos_funcionariosCol'];} else {
		  	  $result = $result.", ".$r['FKid_tipos_funcionariosCol']; } }
			 			}
		return $result;
	} 
		 
       function findTopByUsr($id){
	   $result = "";
	  	$rs = mysql_query("SELECT FKid_tipos_usuariosCol FROM destinatarios WHERE FKid_mensagensCol = $id");
		while($r = mysql_fetch_array($rs)){
		      if ($r['FKid_tipos_usuariosCol'] != 0) {
			  if ($result == "") { 
			   $result = $r['FKid_tipos_usuariosCol'];} else {
		  	  $result = $result.", ".$r['FKid_tipos_usuariosCol']; } }
			 			}
		return $result;
	} 
	   
	    

       function saveUsr($id, $id_membro){
			 return mysql_query("INSERT INTO destinatarios (FKid_mensagensCol, FKid_tipos_usuariosCol, situacao) VALUES ('{$id}', '{$id_membro}', 1)");
}

       function saveFnc($id, $id_funcionario){
	 	 return mysql_query("INSERT INTO destinatarios (FKid_mensagensCol, FKid_tipos_funcionariosCol, situacao) VALUES ('{$id}', '{$id_funcionario}', 1)");
}

   function delete($id){
  	 mysql_query("UPDATE destinatarios SET situacao = 0 WHERE FKid_atividadesCol = $id");
   }
}
?>