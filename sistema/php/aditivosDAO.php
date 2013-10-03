<?php 
class aditivosDAO{

function countAll($reg){
		$result = false;
  		$rs = mysql_query("SELECT COUNT(*) AS total FROM adtivos WHERE FKid_regimentosCol = $reg AND situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
		
	}
/*
	function countByBusca($regimento, $data, $situacao){
		$return = false;
		$condicoes = "";
		$from = 'regimentos';
		if ($regimento != "") {
			$condicoes = " AND regimento LIKE '%".$regimento."%' ";
		}
		if ($data != ""){
			$condicoes = $condicoes." AND data_envio LIKE '%".$data."%' ";
		}		
		if ($situacao != ""){
			$condicoes = $condicoes." AND situacao = $situacao ";
			}
		$rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE situacao <> 0".$condicoes." ORDER BY id_regimentos");
 		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}

	function findTopByBusca($regimento, $data, $situacao, $i = 0, $f = 0, $orderBy = "id_regimentos", $ordem = "ASC"){
		$return = false;
		$condicoes = "";
		$from = 'regimentos';
		if ($regimento != "") {
			$condicoes = " AND regimento LIKE '%".$regimento."%' ";
		}
		if ($data != ""){
			$condicoes = $condicoes." AND data_envio LIKE '%".$data."%' ";
		}		
		if ($situacao != ""){
			$condicoes = $condicoes." AND situacao = $situacao ";
			}
		if (f > 0) 
 $rs = mysql_query("SELECT * FROM $from WHERE situacao <> 0".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f"); 
 else
 $rs = mysql_query("SELECT * FROM $from WHERE situacao <> 0".$condicoes." ORDER BY $orderBy $ordem"); 
		while ($r = mysql_fetch_array($rs) ){
		      $regimentos = new regimentos();
			$regimentos->id = $r['id_regimentos'];
			$regimentos->id_condominio = $r['FKid_condominiosCol'];
			$regimentos->regimento = $r['regimento'];
			$regimentos->data_envio = $r['data_envio'];
			$regimentos->nome_arquivo = $r['arquivo'];
			$regimentos->status = $r['situacao'];
			$result[] = $regimentos;
		}
		return $result;
	}
	*/

	function findTop($reg, $i = 0, $f = 0){
		$result = false;
		if ($f > 0)
		   $rs = mysql_query("SELECT * FROM adtivos WHERE situacao = 1 AND FKid_regimentosCol = $reg ORDER BY id_adtivos ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM adtivos WHERE situacao = 1 AND FKid_regimentosCol = $reg ORDER BY id_adtivos ASC");
		while ( $r = mysql_fetch_array($rs)){
		    $aditivos = new aditivos();
			$aditivos->id = $r['id_adtivos'];
			$aditivos->id_regimento = $r['FKid_regimentosCol'];
			$aditivos->aditivo = $r['aditivo'];
			$aditivos->data_envio = $r['data_envio'];
			$aditivos->nome_arquivo = $r['arquivo'];
			$aditivos->status = $r['situacao'];
			$result[] = $aditivos;
				}
		return $result;
	}

		   function findByPk($id){
              $return = false;
              $rs = mysql_query("SELECT * FROM adtivos WHERE situacao = 1 AND id_adtivos = $id");
              while ( $r = mysql_fetch_array($rs) ){
          $aditivos = new aditivos();
			$aditivos->id = $r['id_adtivos'];
			$aditivos->id_regimento = $r['FKid_regimentosCol'];
			$aditivos->aditivo = $r['aditivo'];
			$aditivos->data_envio = $r['data_envio'];
			$aditivos->nome_arquivo = $r['arquivo'];
			$aditivos->status = $r['situacao'];
			$result = $aditivos;
              }
          return $result;
   }
   
 
       function save($aditivos, $i = 0){
	   if ($aditivos->nome_arquivo != "" and $i != 0 ) {
	   return mysql_query("UPDATE adtivos SET arquivo = '{$aditivos->nome_arquivo}' WHERE id_adtivos = '{$i}'");
	   return;
	   }
        if ($aditivos->id == 0){
			  mysql_query("INSERT INTO adtivos (data_envio, arquivo, aditivo, situacao, FKid_regimentosCol) VALUES ('{$aditivos->data_envio}', '', '{$aditivos->aditivo}', 1, '{$aditivos->id_regimento}')");
		   $lid = regimentosDAO::lastId();
		  	return mysql_query("UPDATE regimentos SET situacao = 2 where id_regimentos <> $lid");
	     }else{ 
		return mysql_query("UPDATE atas_reunioes SET data_insercao = '{$atasreunioes->data_insercao}', nome_arquivo = '{$atasreunioes->nome_arquivo}', FKid_membroscondominioCol = '{$atasreunioes->id_membroscondominio}', FKid_condominiosCol = '{$atasreunioes->id_condominio}', data_realizacao = '{$atasreunioes->data_realizacao}', hora_inicio = '{$atasreunioes->hora_inicio}', hora_fim = '{$atasreunioes->hora_final}', assunto = '{$atasreunioes->assunto}' WHERE id_atas_reunioes = '{$atasreunioes->id}'");
	
 }
}
        function lastId(){
           $return = false;
              $rs = mysql_query("SELECT id_adtivos FROM adtivos ORDER BY id_adtivos DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
                $lid =  $r['id_adtivos'];;
		     	$result = $lid;
      	}
          return $result;
   }
   
       function delete($id){
	  mysql_query("UPDATE adtivos SET situacao = 0 WHERE id_adtivos = $id");
   }
  }
?>