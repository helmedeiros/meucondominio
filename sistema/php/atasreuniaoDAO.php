<?php 
class atasreuniaoDAO{

function countAll($idcondominios){
		$result = false;
  		$rs = mysql_query("SELECT COUNT(*) AS total FROM atas_reunioes WHERE situacao =  1 AND FKid_condominiosCol = $idcondominios");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
		
	}
	
	function countByBusca($assunto, $data, $escriba){
		$return = false;
		$condicoes = "";
		$from = 'atas_reunioes ata';
		if ($assunto != "") {
			$condicoes = " AND assunto LIKE '%".$assunto."%' ";
		}
		if ($data != ""){
			$condicoes = $condicoes." AND data_realizacao LIKE '%".$data."%' ";
		}		
		if ($escriba != ""){
			if(is_numeric($escriba)){
				$condicoes = $condicoes." AND FKid_membroscondominioCol = ".$escriba." ";
			}else{
				$condicoes = $condicoes." AND mb.nome like '%".$escriba."%' ";
				$condicoes = $condicoes." AND mb.id_membroscondominio = ata.FKid_membroscondominioCol";
				$from = $from.', membros_condominio mb';
			}
		}		
 $rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE ata.situacao = 1".$condicoes." ORDER BY id_atas_reunioes");
 		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}

	function findTopByBusca($assunto, $data, $escriba, $i = 0, $f = 0, $orderBy = "ata.id_atas_reunioes", $ordem = "ASC"){
		$return = false;
		$condicoes = "";
		$from = 'atas_reunioes ata';
		if ($assunto != "") {
			$condicoes = " AND assunto LIKE '%".$assunto."%' ";
		}
		if ($data != ""){
			$condicoes = $condicoes." AND data_realizacao LIKE '%".$data."%' ";
		}		
		if ($escriba != ""){
			if(is_numeric($escriba)){
				$condicoes = $condicoes." AND FKid_membroscondominioCol = ".$escriba." ";
			}else{
				$condicoes = $condicoes." AND mb.nome like '%".$escriba."%' ";
				$condicoes = $condicoes." AND mb.id_membroscondominio = ata.FKid_membroscondominioCol";
				$from = $from.', membros_condominio mb';
			}
		}		
		if (f > 0) 
 $rs = mysql_query("SELECT * FROM $from WHERE ata.situacao = 1".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f"); 
 else
 $rs = mysql_query("SELECT * FROM $from WHERE ata.situacao = 1".$condicoes." ORDER BY $orderBy $ordem"); 
		while ($r = mysql_fetch_array($rs) ){
		    $atasreuniao = new atasreuniao();
			$atasreuniao->id = $r['id_atas_reunioes'];
			$atasreuniao->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$atasreuniao->id_condominio = $r['FKid_condominiosCol'];
			$atasreuniao->data_insercao = $r['data_insercao'];
			$atasreuniao->data_realizacao = $r['data_realizacao'];
			$atasreuniao->hora_inicio = $r['hora_inicio'];
			$atasreuniao->hora_fim = $r['hora_fim'];
			$atasreuniao->nome_arquivo = $r['nome_arquivo'];
			$atasreuniao->assunto = $r['assunto'];
			$atasreuniao->status = $r['situacao'];
			$result[] = $atasreuniao;
		}
		return $result;
	}

	function findTop($idcondominios, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		   $rs = mysql_query("SELECT * FROM atas_reunioes WHERE situacao = 1 AND FKid_condominiosCol = $idcondominios ORDER BY id_atas_reunioes ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM atas_reunioes WHERE situacao = 1 AND FKid_condominiosCol = $idcondominios ORDER BY id_atas_reunioes ASC");
		while ( $r = mysql_fetch_array($rs)){
		    $atasreuniao = new atasreuniao();
			$atasreuniao->id = $r['id_atas_reunioes'];
			$atasreuniao->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$atasreuniao->id_condominio = $r['FKid_condominiosCol'];
			$atasreuniao->data_insercao = $r['data_insercao'];
			$atasreuniao->data_realizacao = $r['data_realizacao'];
			$atasreuniao->hora_inicio = $r['hora_inicio'];
			$atasreuniao->hora_fim = $r['hora_fim'];
			$atasreuniao->nome_arquivo = $r['nome_arquivo'];
			$atasreuniao->assunto = $r['assunto'];
			$atasreuniao->status = $r['situacao'];
			$result[] = $atasreuniao;
  		}
		return $result;
	}
	
		function findEscriba($id, $idescriba){
		$result = false;
		$rs = mysql_query("SELECT m.nome FROM atas_reunioes a, membros_condominio m WHERE a.id_atas_reunioes = $id AND m.id_membroscondominio = $idescriba");
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
 }
		   function findByPk($id){
              $return = false;
              $rs = mysql_query("SELECT * FROM atas_reunioes WHERE id_atas_reunioes = $id AND situacao = 1");
              while ( $r = mysql_fetch_array($rs) ){
            $atasreuniao = new atasreuniao();
			$atasreuniao->id = $r['id_atas_reunioes'];
			$atasreuniao->id_membroscondominio = $r['FKid_membroscondominioCol'];
			$atasreuniao->id_condominio = $r['FKid_condominiosCol'];
			$atasreuniao->data_insercao = $r['data_insercao'];
			$atasreuniao->data_realizacao = $r['data_realizacao'];
			$atasreuniao->hora_inicio = $r['hora_inicio'];
			$atasreuniao->hora_fim = $r['hora_fim'];
			$atasreuniao->nome_arquivo = $r['nome_arquivo'];
			$atasreuniao->assunto = $r['assunto'];
			$atasreuniao->status = $r['situacao'];
			$result = $atasreuniao;
              }
          return $result;
   }
   
 
      function save($atasreunioes, $i = 0){
	   if ($atasreunioes->nome_arquivo != "" and $i != 0 ) {
	   return mysql_query("UPDATE atas_reunioes SET nome_arquivo ='{$atasreunioes->nome_arquivo}' WHERE id_atas_reunioes = '{$i}'");
	   return;
	   }
        if ($atasreunioes->id == 0){
		    return mysql_query("INSERT INTO atas_reunioes (data_insercao, nome_arquivo, FKid_membroscondominioCol, FKid_condominiosCol, data_realizacao, hora_inicio, hora_fim, assunto, situacao) VALUES ('{$atasreunioes->data_insercao}', '{$atasreunioes->nome_arquivo}', '{$atasreunioes->id_membroscondominio}', '{$atasreunioes->id_condominio}', '{$atasreunioes->data_realizacao}', '{$atasreunioes->hora_inicio}', '{$atasreunioes->hora_final}', '{$atasreunioes->assunto}', 1)");
	     }else{ 
		return mysql_query("UPDATE atas_reunioes SET data_insercao = '{$atasreunioes->data_insercao}', nome_arquivo = '{$atasreunioes->nome_arquivo}', FKid_membroscondominioCol = '{$atasreunioes->id_membroscondominio}', FKid_condominiosCol = '{$atasreunioes->id_condominio}', data_realizacao = '{$atasreunioes->data_realizacao}', hora_inicio = '{$atasreunioes->hora_inicio}', hora_fim = '{$atasreunioes->hora_final}', assunto = '{$atasreunioes->assunto}' WHERE id_atas_reunioes = '{$atasreunioes->id}'");
	
 }
}
        function lastId(){
           $return = false;
              $rs = mysql_query("SELECT id_atas_reunioes FROM atas_reunioes ORDER BY id_atas_reunioes DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
              
              
                $lid =  $r['id_atas_reunioes'];;
		     	$result = $lid;
      	}
          return $result;
   }
   
       function delete($id){
	  mysql_query("UPDATE  atas_reunioes SET situacao = 0 WHERE id_atas_reunioes = $id");
   }
  }
?>