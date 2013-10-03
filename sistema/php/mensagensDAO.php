<?php 
class mensagensDAO{

function countAll($idcondominios){
		$result = false;
  		$rs = mysql_query("SELECT COUNT(*) AS total FROM mensagens WHERE situacao =  1 AND FKid_condominiosCol = $idcondominios");
		if ($r = mysql_fetch_array($rs) ){
		 $result = $r['total'];
		}
		return $result;
		
	}

function countByBusca($mensagem, $data, $responsavel){
		$return = false;
		$condicoes = "";
		$from = 'mensagens msg';
		if ($mensagem != "") {
			$condicoes = " AND mensagem LIKE '%".$mensagem."%' ";
		}
		if ($data != ""){
			$condicoes = $condicoes." AND data_envio LIKE '%".$data."%' ";
		}		
		if ($responsavel != ""){
			if(is_numeric($responsavel)){
				$condicoes = $condicoes." AND FKid_membroscondominioCol = ".$responsavel." ";
			}else{
				$condicoes = $condicoes." AND mb.nome like '%".$responsavel."%' ";
				$condicoes = $condicoes." AND mb.id_membroscondominio = msg.FKid_membroscondominioCol";
				$from = $from.', membros_condominio mb';
			}
		}		
		 $rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE msg.situacao = 1".$condicoes." ORDER BY id_mensagens");
 		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	 }
	  

	function findTopByBusca($mensagem, $data, $responsavel, $i = 0, $f = 0, $orderBy = "msg.id_mensagens", $ordem = "ASC"){
			$return = false;
		$condicoes = "";
		$from = 'mensagens msg';
		if ($mensagem != "") {
			$condicoes = " AND mensagem LIKE '%".$mensagem."%' ";
		}
		if ($data != ""){
			$condicoes = $condicoes." AND data_envio LIKE '%".$data."%' ";
		}		
		if ($responsavel != ""){
			if(is_numeric($responsavel)){
				$condicoes = $condicoes." AND FKid_membroscondominioCol = ".$responsavel." ";
			}else{
				$condicoes = $condicoes." AND mb.nome like '%".$responsavel."%' ";
				$condicoes = $condicoes." AND mb.id_membroscondominio = msg.FKid_membroscondominioCol";
				$from = $from.', membros_condominio mb';
			}
		}		
		if ($f > 0)  
 $rs = mysql_query("SELECT * FROM $from WHERE msg.situacao = 1".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f"); 
 else
 $rs = mysql_query("SELECT * FROM $from WHERE msg.situacao = 1".$condicoes." ORDER BY $orderBy $ordem"); 
		while ($r = mysql_fetch_array($rs) ){
		    $mensagens = new mensagens();
			$mensagens->id = $r['id_mensagens'];
			$mensagens->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$mensagens->id_condominio = $r['FKid_condominiosCol'];
         	$mensagens->data_envio = $r['data_envio'];
			$mensagens->mensagem = $r['mensagem'];
			$mensagens->status = $r['situacao'];
			$result[] = $mensagens;
		}
		return $result;
	}
   	   	   	   	   	 

	function findTop($idcondominios, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		   $rs = mysql_query("SELECT * FROM mensagens WHERE situacao = 1 AND FKid_condominiosCol = $idcondominios ORDER BY id_mensagens ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM mensagens WHERE situacao = 1 AND FKid_condominiosCol = $idcondominios ORDER BY id_atas_reunioes ASC");
		while ( $r = mysql_fetch_array($rs)){
		    $mensagens = new mensagens();
			$mensagens->id = $r['id_mensagens'];
			$mensagens->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$mensagens->id_condominio = $r['FKid_condominiosCol'];
         	$mensagens->data_envio = $r['data_envio'];
			$mensagens->mensagem = $r['mensagem'];
			$mensagens->status = $r['situacao'];
			$result[] = $mensagens;
		}
		return $result;
	}
	
	function findAnunciante($id, $idanunciante){
		$result = false;
		$rs = mysql_query("SELECT m.nome FROM mensagens a, membros_condominio m WHERE a.id_mensagens = $id AND m.id_membroscondominio = $idanunciante");
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
              $rs = mysql_query("SELECT * FROM mensagens WHERE id_mensagens = $id AND situacao = 1");
              while ( $r = mysql_fetch_array($rs) ){
	        $mensagens = new mensagens();
			$mensagens->id = $r['id_mensagens'];
			$mensagens->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$mensagens->id_condominio = $r['FKid_condominiosCol'];
         	$mensagens->data_envio = $r['data_envio'];
			$mensagens->mensagem = $r['mensagem'];
			$mensagens->status = $r['situacao'];
			$result = $mensagens;
              }
          return $result;
   }
   
      function lastId(){
           $return = false;
              $rs = mysql_query("SELECT id_mensagens FROM mensagens ORDER BY id_mensagens DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
                $lid =  $r['id_mensagens'];;
		     	$result = $lid;
      	}
          return $result;
   }
    
       function save($mensagens, $i = 0){
         return mysql_query("INSERT INTO mensagens (FKid_membroscondominioCol, FKid_condominiosCol, data_envio, mensagem, situacao) VALUES ('{$mensagens->id_membroscondominio}', '{$mensagens->id_condominio}', '{$mensagens->data_envio}', '{$mensagens->mensagem}', 1)");
		}        
	  
       function delete($id){
	  mysql_query("UPDATE mensagens SET situacao = 0 WHERE id_mensagens = $id");
   }
  }
?>