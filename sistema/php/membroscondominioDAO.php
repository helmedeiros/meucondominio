<?php 
class membroscondominioDAO{
	function findALL(){
		$return = false;
        $rs = mysql_query("SELECT * FROM membros_condominio ORDER BY nome");
        while ( $r = mysql_fetch_array($rs)){
        	$membroscondominio=new membroscondominio();
        	$membroscondominio->id = $r['id_membroscondominio'];
        	$membroscondominio->id_condominios = $r['FKid_condominiosCol'];
        	$membroscondominio->id_tipo_usuarios = $r['FKid_tipo_usuariosCol'];
        	$membroscondominio->nome = $r['nome'];
        	$membroscondominio->data_nascimento = $r['data_nascimento'];
        	$membroscondominio->cpf = $r['cpf'];
        	$membroscondominio->telefone = $r['telefone'];
        	$membroscondominio->celular = $r['celular'];
        	$membroscondominio->email = $r['email'];
        	$membroscondominio->numero_apartamento = $r['numero_apartamento'];
        	$membroscondominio->login = $r['login'];
        	$membroscondominio->senha = $r['senha'];
        	$membroscondominio->proprietario = $r['proprietario'];
			$membroscondominio->numero_acessos = $r['numero_acessos'];
			$membroscondominio->data_criacao = $r['data_criacao'];
        	$membroscondominio->status = $r['situacao'];
            $result[] = $membroscondominio;
	    }
		return $result;
  	}
	
	function findTop($i = 0, $f = 0, $orderBy = "nome", $ordem = "ASC"){
		$result = false;				
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM membros_condominio ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM membros_condominio ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
            $membroscondominio=new membroscondominio();
        	$membroscondominio->id = $r['id_membroscondominio'];
        	$membroscondominio->id_condominios = $r['FKid_condominiosCol'];
        	$membroscondominio->id_tipo_usuarios = $r['FKid_tipo_usuariosCol'];
        	$membroscondominio->nome = $r['nome'];
        	$membroscondominio->data_nascimento = $r['data_nascimento'];
        	$membroscondominio->cpf = $r['cpf'];
        	$membroscondominio->telefone = $r['telefone'];
        	$membroscondominio->celular = $r['celular'];
        	$membroscondominio->email = $r['email'];
        	$membroscondominio->numero_apartamento = $r['numero_apartamento'];
        	$membroscondominio->login = $r['login'];
        	$membroscondominio->senha = $r['senha'];
        	$membroscondominio->proprietario = $r['proprietario'];
			$membroscondominio->numero_acessos = $r['numero_acessos'];
			$membroscondominio->data_criacao = $r['data_criacao'];
        	$membroscondominio->status = $r['situacao'];
            $result[] = $membroscondominio;
  		}
		return $result;
	}
	
	function findTopByBusca($nome, $cpf, $condominio, $i = 0, $f = 0, $orderBy = "id_membroscondominio", $ordem = "ASC"){
		$result = false;
		$condicoes = "";
		$from = 'membros_condominio m';
		if ($nome != "") {
			$condicoes = " AND m.nome LIKE '%".$nome."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND m.cpf LIKE '%".$cpf."%' ";
		}		
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  m.FKid_condominiosCol = cond.id_condominios";
				$from = $from.', condominios cond';			
		}			
					
		if ($f > 0)
			$rs = mysql_query("SELECT m.* FROM $from WHERE m.situacao = 1".$condicoes." OR m.situacao = 0".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT m.* FROM $from WHERE m.situacao = 1".$condicoes." OR m.situacao = 0".$condicoes." ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
        	$membroscondominio=new membroscondominio();
        	$membroscondominio->id = $r['id_membroscondominio'];
        	$membroscondominio->id_condominios = $r['FKid_condominiosCol'];
        	$membroscondominio->id_tipo_usuarios = $r['FKid_tipo_usuariosCol'];
        	$membroscondominio->nome = $r['nome'];
        	$membroscondominio->data_nascimento = $r['data_nascimento'];
        	$membroscondominio->cpf = $r['cpf'];
        	$membroscondominio->telefone = $r['telefone'];
        	$membroscondominio->celular = $r['celular'];
        	$membroscondominio->email = $r['email'];
        	$membroscondominio->numero_apartamento = $r['numero_apartamento'];
        	$membroscondominio->login = $r['login'];
        	$membroscondominio->senha = $r['senha'];
        	$membroscondominio->proprietario = $r['proprietario'];
			$membroscondominio->numero_acessos = $r['numero_acessos'];
			$membroscondominio->data_criacao = $r['data_criacao'];
        	$membroscondominio->status = $r['situacao'];
            $result[] = $membroscondominio;
  		}
		return $result;
	}	
       
	function findByPk($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM membros_condominio WHERE id_membroscondominio = $id"); 
        while ( $r = mysql_fetch_array($rs) ){
        	$membroscondominio= new membroscondominio();
        	$membroscondominio->id = $r['id_membroscondominio'];
        	$membroscondominio->id_condominios = $r['FKid_condominiosCol'];
        	$membroscondominio->id_tipo_usuarios = $r['FKid_tipo_usuariosCol'];
        	$membroscondominio->nome = $r['nome'];
        	$membroscondominio->data_nascimento = $r['data_nascimento'];
        	$membroscondominio->cpf = $r['cpf'];
        	$membroscondominio->telefone = $r['telefone'];
        	$membroscondominio->celular = $r['celular'];
        	$membroscondominio->email = $r['email'];
        	$membroscondominio->numero_apartamento = $r['numero_apartamento'];
        	$membroscondominio->login = $r['login'];
        	$membroscondominio->senha = $r['senha'];
        	$membroscondominio->proprietario = $r['proprietario'];
			$membroscondominio->numero_acessos = $r['numero_acessos'];
			$membroscondominio->data_criacao = $r['data_criacao'];
        	$membroscondominio->status = $r['situacao'];
            $result = $membroscondominio;
        }
        return $result;
   }  
  
  	function findTopByTipo($id, $tipo, $i = 0, $f = 0, $orderBy = "nome", $ordem = "ASC"){
	   	$return = false;
		 if ($f > 0)
            $rs = mysql_query("SELECT * FROM membros_condominio WHERE FKid_condominiosCol = $id AND FKid_tipo_usuariosCol in ($tipo) ORDER BY $orderBy $ordem LIMIT $i, $f"); 
			else
			$rs = mysql_query("SELECT * FROM membros_condominio WHERE FKid_condominiosCol = $id AND FKid_tipo_usuariosCol in ($tipo) ORDER BY $orderBy $ordem");
        while ( $r = mysql_fetch_array($rs) ){
        	$membroscondominio= new membroscondominio();
        	$membroscondominio->id = $r['id_membroscondominio'];
        	$membroscondominio->id_condominios = $r['FKid_condominiosCol'];
        	$membroscondominio->id_tipo_usuarios = $r['FKid_tipo_usuariosCol'];
        	$membroscondominio->nome = $r['nome'];
        	$membroscondominio->data_nascimento = $r['data_nascimento'];
        	$membroscondominio->cpf = $r['cpf'];
        	$membroscondominio->telefone = $r['telefone'];
        	$membroscondominio->celular = $r['celular'];
        	$membroscondominio->email = $r['email'];
        	$membroscondominio->numero_apartamento = $r['numero_apartamento'];
        	$membroscondominio->login = $r['login'];
        	$membroscondominio->senha = $r['senha'];
        	$membroscondominio->proprietario = $r['proprietario'];
			$membroscondominio->numero_acessos = $r['numero_acessos'];
			$membroscondominio->data_criacao = $r['data_criacao'];
        	$membroscondominio->status = $r['situacao'];
            $result[] = $membroscondominio;
        }
        return $result;
   }  
  
  	function returnNome($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM membros_condominio WHERE id_membroscondominio = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$membroscondominio = $r['nome'];
        	$result = $membroscondominio;
		    }
        return $result;
   }  
  
  	function findAllByCond($id_condominio, $exception = "", $tipo = ""){	
  		$return = false;
		if ($exception != "") {
		$rs = mysql_query("SELECT * FROM membros_condominio WHERE FKid_condominiosCol = $id_condominio AND id_membroscondominio NOT IN ($exception) AND situacao = 1"); } else {
		if ($tipo != "") {
		 $tipo = "AND FKid_tipo_usuariosCol = $tipo";
		 $rs = mysql_query("SELECT * FROM membros_condominio WHERE FKid_condominiosCol = $id_condominio $tipo AND situacao = 1"); } else {
		$rs = mysql_query("SELECT * FROM membros_condominio WHERE FKid_condominiosCol = $id_condominio AND situacao = 1"); } }
		while ( $r = mysql_fetch_array($rs) ){
			$membroscondominio= new membroscondominio();
			$membroscondominio->id = $r['id_membroscondominio'];
			$membroscondominio->nome = $r['nome'];
    		$membroscondominio->tipo = $r['tipo'];
			$result[] = $membroscondominio;
		}
		
		return $result;	
	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM membros_condominio");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countByBusca($nome, $cpf, $condominio){
		$result = false;
		$condicoes = "";
		$from = 'membros_condominio m';
		if ($nome != "") {
			$condicoes = " AND m.nome LIKE '%".$nome."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND m.cpf LIKE '%".$cpf."%' ";
		}		
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND m.FKid_condominiosCol = cond.id_condominios";
				$from = $from.', condominios cond';			
		}		
		$rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE m.situacao = 1".$condicoes." OR m.situacao = 0".$condicoes." ORDER BY m.nome");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function existeByLogin($login, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_membroscondominio FROM membros_condominio WHERE login = '$login' AND FKid_condominiosCol = $condominio AND situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByLoginId($login, $id, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_membroscondominio FROM membros_condominio WHERE login = '$login' AND FKid_condominiosCol = $condominio AND id_membroscondominio <> $id");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByCpf($cpf, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_membroscondominio FROM membros_condominio WHERE cpf = '{$cpf}' AND FKid_condominiosCol = $condominio");
		if ($r = mysql_fetch_array($rs) ){
		$result = true;
		}
		return $result;
	}
  
  	function existeByCpfId($cpf, $id, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_membroscondominio FROM membros_condominio WHERE cpf = '{$cpf}' and id_membroscondominio <> $id AND FKid_condominiosCol = $condominio");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function save($membroscondominio){		
    	if ( $membroscondominio->id == 0){
			return mysql_query("INSERT INTO membros_condominio (FKid_condominiosCol, FKid_tipo_usuariosCol, nome, data_nascimento, cpf, telefone, celular, email, numero_apartamento, login, senha, proprietario,  numero_acessos, data_criacao, situacao) VALUES ({$membroscondominio->id_condominios}, {$membroscondominio->id_tipo_usuarios},'{$membroscondominio->nome}', '{$membroscondominio->data_nascimento}', '{$membroscondominio->cpf}', '{$membroscondominio->telefone}', '{$membroscondominio->celular}', '{$membroscondominio->email}', '{$membroscondominio->numero_apartamento}', '{$membroscondominio->login}', '{$membroscondominio->senha}', {$membroscondominio->proprietario},  '{$membroscondominio->numero_acessos}', '{$membroscondominio->data_criacao}', {$membroscondominio->status})");
		}else{
			return mysql_query("UPDATE membros_condominio SET FKid_tipo_usuariosCol = {$membroscondominio->id_tipo_usuarios}, nome = '{$membroscondominio->nome}', data_nascimento= '{$membroscondominio->data_nascimento}', cpf= '{$membroscondominio->cpf}', telefone= '{$membroscondominio->telefone}', celular= '{$membroscondominio->celular}', email= '{$membroscondominio->email}', numero_apartamento= '{$membroscondominio->numero_apartamento}', login= '{$membroscondominio->login}', senha= '{$membroscondominio->senha}', proprietario= {$membroscondominio->proprietario}, situacao= {$membroscondominio->status}, numero_acessos = '{$membroscondominio->numero_acessos}' WHERE id_membroscondominio = {$membroscondominio->id}");
		}
	}
    
	function delete($id){
    	mysql_query("UPDATE membros_condominio SET situacao = '0' WHERE id_membroscondominio =$id");
   	}
}
?>