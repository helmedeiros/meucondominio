<?php 
class criticas_sugestoesDAO{

	function countAllRecebidas($id_usuario, $id_tipo_usuario){
		$result = false;
  		$rs = mysql_query("SELECT COUNT(*) AS total FROM criticas_sugestoes WHERE destinatario = $id_usuario AND tipo_destinatario = $id_tipo_usuario AND situacao NOT LIKE 'Excluida' ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}

	function countAllEnviadas($id_usuario, $id_tipo_usuario){
		$result = false;
  		$rs = mysql_query("SELECT COUNT(*) AS total FROM criticas_sugestoes WHERE FKid_membroscondominioCol  = $id_usuario AND tipo_remetente = $id_tipo_usuario AND situacao NOT LIKE 'Excluida'");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}

	function findTopRecebidas($id_usuario, $id_tipo_usuario, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		   $rs = mysql_query("SELECT * FROM criticas_sugestoes WHERE destinatario = $id_usuario AND tipo_destinatario = $id_tipo_usuario  AND situacao NOT LIKE 'Excluida' ORDER BY data_envio ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM criticas_sugestoes WHERE destinatario = $id_usuario AND tipo_destinatario = $id_tipo_usuario AND situacao NOT LIKE 'Excluida' ORDER BY data_envio ASC");
		while ( $r = mysql_fetch_array($rs)){
		    $recebidas = new criticas_sugestoes();
			$recebidas->id = $r['id_criticas_sugestoes'];
			$recebidas->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$recebidas->id_prioridade = $r['FKid_niveis_prioridadesCol'];
			$recebidas->data_envio = $r['data_envio'];
			$recebidas->mensagem = $r['mensagem'];
			$recebidas->status = $r['situacao'];
			$recebidas->resolucao = $r['resolucao'];
			$recebidas->destinatario = $r['destinatario'];
			$recebidas->tipo = $r['tipo'];
			$recebidas->data_recebimento = $r['data_recebimento'];
			$recebidas->data_resolucao = $r['data_resolucao'];
			$recebidas->tipo_destinatario =$r['tipo_destinatario'];
			$recebidas->tipo_remetente =$r['tipo_remetente'];			
			$result[] = $recebidas;
  		}
		return $result;
	}
	
	function findTopEnviadas($id_usuario, $id_tipo_usuario, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		   $rs = mysql_query("SELECT * FROM criticas_sugestoes WHERE FKid_membroscondominioCol = $id_usuario AND tipo_remetente = $id_tipo_usuario AND situacao NOT LIKE 'Excluida' ORDER BY data_envio ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM criticas_sugestoes WHERE FKid_membroscondominioCol = $id_usuario AND tipo_remetente = $id_tipo_usuario AND situacao NOT LIKE 'Excluida' ORDER BY data_envio ASC");
		while ( $r = mysql_fetch_array($rs)){
		    $enviadas = new criticas_sugestoes();
			$enviadas->id = $r['id_criticas_sugestoes'];
			$enviadas->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$enviadas->id_prioridade = $r['FKid_niveis_prioridadesCol'];
			$enviadas->data_envio = $r['data_envio'];
			$enviadas->mensagem = $r['mensagem'];
			$enviadas->status = $r['situacao'];
			$enviadas->resolucao = $r['resolucao'];
			$enviadas->destinatario = $r['destinatario'];
			$enviadas->tipo = $r['tipo'];
			$enviadas->data_recebimento = $r['data_recebimento'];
			$enviadas->data_resolucao = $r['data_resolucao'];
			$enviadas->tipo_destinatario =$r['tipo_destinatario'];
			$enviadas->tipo_remetente =$r['tipo_remetente'];				
			$result[] = $enviadas;
  		}
		return $result;
	}


		function findEscriba($id, $idescriba){
		$result = false;
		$rs = mysql_query("SELECT m.nome FROM atas_reunioes a, membros_condominio m WHERE a.id_atas_reunioes = $id AND m.id_membroscondominio = $idescriba AND situacao NOT LIKE 'Excluida'");
		while ( $r = mysql_fetch_array($rs)){
		    $nome = $r['nome'];
			$result = $nome;
  		}
		return $result;
	}

       function findALL(){
              $return = false;
              $rs = mysql_query("SELECT a.* FROM atas_reunioes a, membros_condominio m, condominios c WHERE
                                a.FKid_membroscondominioCol = m.id_membroscondominio AND
                                m.FKid_condominiosCol = c.id_condominios ORDER BY a.data_insercao AND situacao NOT LIKE 'Excluida'");
              while ( $r = mysql_fetch_array($rs)){
                  $atasreunioes=new atasreunioes();
                  $atasreunioes->id = $r['id_atas_reunioes'];
                  $atasreunioes->id_membroscondominio = $r['FKid_membroscondominioCol'];
                  $atasreunioes->data_insercao = $r['data_insercao'];
                  $atasreunioes->nome_arquivo = $r['nome_arquivo'];
                  $result[] = $atasreunioes;
    }
  return $result;
 }
		   function findByPk($id){
              $return = false;
              $rs = mysql_query("SELECT * FROM criticas_sugestoes WHERE id_criticas_sugestoes = $id");
              while ( $r = mysql_fetch_array($rs) ){
            $cs = new criticas_sugestoes();
			$cs->id = $r['id_criticas_sugestoes'];
			$cs->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$cs->id_prioridade = $r['FKid_niveis_prioridadesCol'];
			$cs->data_envio = $r['data_envio'];
			$cs->mensagem = $r['mensagem'];
			$cs->status = $r['situacao'];
			$cs->resolucao = $r['resolucao'];
			$cs->destinatario = $r['destinatario'];
			$cs->tipo = $r['tipo'];
			$cs->data_recebimento = $r['data_recebimento'];
			$cs->data_resolucao = $r['data_resolucao'];
			$cs->tipo_destinatario =$r['tipo_destinatario'];
			$cs->tipo_remetente =$r['tipo_remetente'];		
			$result = $cs;
              }
          return $result;
   }
   
   function findTopVLZU($like, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		  $rs = mysql_query("SELECT * FROM criticas_sugestoes WHERE id_criticas_sugestoes IN ($like) AND situacao NOT LIKE 'Excluida' ORDER BY data_envio ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM criticas_sugestoes WHERE id_criticas_sugestoes IN ($like) AND situacao NOT LIKE 'Excluida' ORDER BY data_envio ASC");
		while ( $r = mysql_fetch_array($rs)){
		 $vlz = new criticas_sugestoes();
			$vlz->id = $r['id_criticas_sugestoes'];
			$vlz->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$vlz->id_prioridade = $r['FKid_niveis_prioridadesCol'];
			$vlz->data_envio = $r['data_envio'];
			$vlz->mensagem = $r['mensagem'];
			$vlz->status = $r['situacao'];
			$vlz->resolucao = $r['resolucao'];
			$vlz->destinatario = $r['destinatario'];
			$vlz->tipo = $r['tipo'];
			$vlz->data_recebimento = $r['data_recebimento'];
			$vlz->data_resolucao = $r['data_resolucao'];
			$vlz->tipo_destinatario =$r['tipo_destinatario'];
			$vlz->tipo_remetente =$r['tipo_remetente'];				
			$result[] = $vlz;
  		}
		return $result;
	}
   
   
 
       function save($criticas_sugestoes, $i = 0){
	   if ($atasreunioes->nome_arquivo != "" and $i != 0 ) {
	   return mysql_query("UPDATE atas_reunioes SET nome_arquivo ='{$atasreunioes->nome_arquivo}' WHERE id_atas_reunioes = '{$i}'");
	   return;
	   }
        if ($criticas_sugestoes->id == 0){
		   return mysql_query("INSERT INTO criticas_sugestoes (FKid_niveis_prioridadesCol, FKid_membroscondominioCol, data_envio, mensagem, situacao, resolucao, destinatario, tipo, tipo_destinatario, tipo_remetente) VALUES ('{$criticas_sugestoes->id_prioridade}', '{$criticas_sugestoes->id_membroscondominio}', '{$criticas_sugestoes->data_envio}', '{$criticas_sugestoes->mensagem}', '{$criticas_sugestoes->status}', '{$criticas_sugestoes->resolucao}', '{$criticas_sugestoes->destinatario}', '{$criticas_sugestoes->tipo}', '{$criticas_sugestoes->tipo_destinatario}', '{$criticas_sugestoes->tipo_remetente}')");
	     }else{ 
				return mysql_query("UPDATE criticas_sugestoes SET FKid_niveis_prioridadesCol  = '{$criticas_sugestoes->id_prioridade}', FKid_membroscondominioCol = '{$criticas_sugestoes->id_membroscondominio}', data_envio = '{$criticas_sugestoes->data_envio}', mensagem = '{$criticas_sugestoes->mensagem}', situacao = '{$criticas_sugestoes->status}', resolucao = '{$criticas_sugestoes->resolucao}', destinatario = '{$criticas_sugestoes->destinatario}', tipo = '{$criticas_sugestoes->tipo}', data_recebimento = '{$criticas_sugestoes->data_recebimento}', data_resolucao = '{$criticas_sugestoes->data_resolucao}', tipo_destinatario = '{$criticas_sugestoes->tipo_destinatario}', tipo_remetente = '{$criticas_sugestoes->tipo_remetente}' WHERE id_criticas_sugestoes = $criticas_sugestoes->id");
	
 }
}

   function setSituacao($id, $situacao){
	  mysql_query("UPDATE  criticas_sugestoes SET situacao = '$situacao' WHERE id_criticas_sugestoes = '$id'");
   }
  
         function lastId(){
           $return = false;
              $rs = mysql_query("SELECT id_criticas_sugestoes FROM criticas_sugestoes ORDER BY id_criticas_sugestoes DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
                $lid =  $r['id_criticas_sugestoes'];
		     	$result = $lid;

      	}
          return $result;
   }
   
       function delete($id){
	  mysql_query("UPDATE criticas_sugestoes SET situacao = 'Excluida' WHERE id_criticas_sugestoes = $id");
   }
  }
?>