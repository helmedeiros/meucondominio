<?php 
class contatosDAO{
  
	function findAll(){	
  		$return = false;
  		$rs = mysql_query("SELECT * FROM contatos WHERE situacao = 1");
  		while ( $r = mysql_fetch_array($rs) ){
			$contatos= new contatos();
			$contatos->id = $r['id_contato'];
			$contatos->nome = $r['nome'];
			$contatos->cpf = $r['cpf'];
			$contatos->telefone = $r['telefone'];
			$contatos->celular = $r['celular'];
			$contatos->email = $r['email'];			
			$contatos->descricao = $r['descricao'];
			$contatos->status = $r['situacao'];
			$result[] = $contatos;
		}
		return $result;	
	}	
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM contatos WHERE situacao = 1 ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM contatos WHERE situacao = 1 ORDER BY nome ASC");
		while ( $r = mysql_fetch_array($rs)){
        	$contatos= new contatos();
			$contatos->id = $r['id_contato'];
			$contatos->nome = $r['nome'];
			$contatos->cpf = $r['cpf'];
			$contatos->telefone = $r['telefone'];
			$contatos->celular = $r['celular'];
			$contatos->email = $r['email'];						
			$contatos->descricao = $r['descricao'];
			$contatos->status = $r['situacao'];
			$result[] = $contatos;
  		}
		return $result;
	}	
	
	function findTopByBusca($nome, $cpf, $condominio, $i = 0, $f = 0, $orderBy = "id_contato", $ordem = "ASC"){
		$result = false;
		$condicoes = "";
		$from = 'contatos cont';
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND cpf LIKE '%".$cpf."%' ";
		}		
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND cont.id_contato = cond.FKid_contatoCol";
				$from = $from.', condominios cond';			
		}							
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM $from WHERE cont.situacao = 1".$condicoes." OR cont.situacao = 0".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM $from WHERE cont.situacao = 1".$condicoes." OR cont.situacao = 0".$condicoes." ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
        	$contatos= new contatos();
			$contatos->id = $r['id_contato'];
			$contatos->nome = $r['nome'];
			$contatos->cpf = $r['cpf'];
			$contatos->telefone = $r['telefone'];
			$contatos->celular = $r['celular'];
			$contatos->email = $r['email'];						
			$contatos->descricao = $r['descricao'];
			$contatos->status = $r['situacao'];
			$result[] = $contatos;
  		}
		return $result;
	}		
	
  	
	function findByPk($id){
  		$return = false;
  		$rs = mysql_query("SELECT * FROM contatos WHERE id_contato = $id AND situacao = 1");
  		while ( $r = mysql_fetch_array($rs) ){
			$contatos= new contatos();
			$contatos->id = $r['id_contato'];
			$contatos->nome = $r['nome'];
			$contatos->cpf = $r['cpf'];
			$contatos->telefone = $r['telefone'];
			$contatos->celular = $r['celular'];
			$contatos->descricao = $r['descricao'];
			$contatos->email = $r['email'];						
			$contatos->status = $r['situacao'];
			$result = $contatos;
		}
		return $result;
	}		
	
	
	function countByBusca($nome,  $cpf, $condominio){
		$result = false;
		$condicoes = "";
		$from = 'contatos cont';
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND cpf LIKE '%".$cpf."%' ";
		}		
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND cont.id_contato = cond.FKid_contatoCol";
				$from = $from.', condominios cond';			
		}	
		$rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE cont.situacao = 1".$condicoes." OR cont.situacao = 0".$condicoes." ORDER BY nome");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM contatos WHERE situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function existeByCpf($cpf){
		$result = false;
		$rs = mysql_query("SELECT id_contato FROM contatos WHERE cpf = '{$cpf}'");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
  
  	function existeByCpfId($cpf, $id){
		$result = false;	
		$rs = mysql_query("SELECT id_contato FROM contatos WHERE cpf = '{$cpf}' and id_contato <> $id");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}	
	
 	function lastId(){
           $return = false;
           $rs = mysql_query("SELECT id_contato FROM contatos ORDER BY id_contato DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
                $lid =  $r['id_contato'];;
		     	$result = $lid;
      	}
          return $result;
   }
 
	function save($contatos){			
		if ( $contatos->id == 0){
			return mysql_query("INSERT INTO contatos (nome, cpf, telefone, descricao, celular, situacao, email) VALUES ('{$contatos->nome}', '{$contatos->cpf}', '{$contatos->telefone}',  '{$contatos->descricao}', '{$contatos->celular}', {$contatos->status}, '{$contatos->email}')");
		}else{
			return mysql_query("UPDATE contatos SET nome = '{$contatos->nome}', cpf = '{$contatos->cpf}', telefone = '{$contatos->telefone}',  descricao = '{$contatos->descricao}', celular = '{$contatos->celular}', situacao = {$contatos->status}, email = '{$contatos->email}' WHERE id_contato = {$contatos->id}");
  		}
	}
  
	function delete($id){
		mysql_query("UPDATE contatos SET situacao = 0 WHERE id_contato = $id");
  	}
 
	
}
?>