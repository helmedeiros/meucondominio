<?php 
class funcionariosDAO{
	function findALL(){
		$return = false;
        $rs = mysql_query("SELECT * FROM funcionarios_condominio ORDER BY nome");
        while ( $r = mysql_fetch_array($rs)){
        	$funcionarios=new funcionarios();
        	$funcionarios->id = $r['id_funcionarios_condominio'];
        	$funcionarios->id_condominios = $r['FKid_condominiosCol'];
        	$funcionarios->id_tipo_funcionario = $r['FKid_tipos_funcionariosCol'];
        	$funcionarios->nome = $r['nome'];
        	$funcionarios->data_nascimento = $r['data_nascimento'];
        	$funcionarios->cpf = $r['cpf'];
        	$funcionarios->telefone = $r['telefone'];
        	$funcionarios->celular = $r['celular'];
        	$funcionarios->email = $r['email'];        	
        	$funcionarios->login = $r['login'];
        	$funcionarios->senha = $r['senha'];
			$funcionarios->numero_acessos = $r['numero_acessos'];
			$funcionarios->data_criacao = $r['data_criacao'];
        	$funcionarios->status = $r['situacao'];
            $result[] = $funcionarios;
	    }
		return $result;
  	}
	
		
	function findTop($i = 0, $f = 0, $orderBy = "nome", $ordem = "ASC"){
		$result = false;				
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM funcionarios_condominio ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM funcionarios_condominio ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
            $funcionarios=new funcionarios();
        	$funcionarios->id = $r['id_funcionarios_condominio'];
        	$funcionarios->id_condominios = $r['FKid_condominiosCol'];
        	$funcionarios->id_tipo_funcionario = $r['FKid_tipos_funcionariosCol'];
        	$funcionarios->nome = $r['nome'];
        	$funcionarios->data_nascimento = $r['data_nascimento'];
        	$funcionarios->cpf = $r['cpf'];
        	$funcionarios->telefone = $r['telefone'];
        	$funcionarios->celular = $r['celular'];
        	$funcionarios->email = $r['email'];        	
        	$funcionarios->login = $r['login'];
        	$funcionarios->senha = $r['senha'];
			$funcionarios->numero_acessos = $r['numero_acessos'];
			$funcionarios->data_criacao = $r['data_criacao'];
        	$funcionarios->status = $r['situacao'];
            $result[] = $funcionarios;
  		}
		return $result;
	}
	
	function findTopByBusca($nome, $cpf, $condominio, $i = 0, $f = 0, $orderBy = "id_funcionarios_condominio", $ordem = "ASC"){
		$result = false;
		$condicoes = "";
		$from = 'funcionarios_condominio f';
		if ($nome != "") {
			$condicoes = " AND f.nome LIKE '%".$nome."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND f.cpf LIKE '%".$cpf."%' ";
		}		
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  f.FKid_condominiosCol = cond.id_condominios";
				$from = $from.', condominios cond';			
		}			
					
		if ($f > 0)
			$rs = mysql_query("SELECT f.* FROM $from WHERE f.situacao = 1".$condicoes." OR f.situacao = 0".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT f.* FROM $from WHERE f.situacao = 1".$condicoes." OR f.situacao = 0".$condicoes." ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
        	$funcionarios=new funcionarios();
        	$funcionarios->id = $r['id_funcionarios_condominio'];
        	$funcionarios->id_condominios = $r['FKid_condominiosCol'];
        	$funcionarios->id_tipo_funcionario = $r['FKid_tipos_funcionariosCol'];
        	$funcionarios->nome = $r['nome'];
        	$funcionarios->data_nascimento = $r['data_nascimento'];
        	$funcionarios->cpf = $r['cpf'];
        	$funcionarios->telefone = $r['telefone'];
        	$funcionarios->celular = $r['celular'];
        	$funcionarios->email = $r['email'];
        	
        	$funcionarios->login = $r['login'];
        	$funcionarios->senha = $r['senha'];
			$funcionarios->numero_acessos = $r['numero_acessos'];
			$funcionarios->data_criacao = $r['data_criacao'];
        	$funcionarios->status = $r['situacao'];
            $result[] = $funcionarios;
  		}
		return $result;
	}	
       
	function findByPk($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM funcionarios_condominio WHERE id_funcionarios_condominio = $id"); 
        while ( $r = mysql_fetch_array($rs) ){
        	$funcionarios= new funcionarios();
        	$funcionarios->id = $r['id_funcionarios_condominio'];
        	$funcionarios->id_condominios = $r['FKid_condominiosCol'];
        	$funcionarios->id_tipo_funcionario = $r['FKid_tipos_funcionariosCol'];
        	$funcionarios->nome = $r['nome'];
        	$funcionarios->data_nascimento = $r['data_nascimento'];
        	$funcionarios->cpf = $r['cpf'];
        	$funcionarios->telefone = $r['telefone'];
        	$funcionarios->celular = $r['celular'];
        	$funcionarios->email = $r['email'];
        	
        	$funcionarios->login = $r['login'];
        	$funcionarios->senha = $r['senha'];
			$funcionarios->numero_acessos = $r['numero_acessos'];
			$funcionarios->data_criacao = $r['data_criacao'];
        	$funcionarios->status = $r['situacao'];
            $result = $funcionarios;
        }
        return $result;
   }  
  
  	function findTopByTipo($id, $tipo, $i = 0, $f = 0, $orderBy = "nome", $ordem = "ASC"){
    	$return = false;
		 if ($f > 0)
            $rs = mysql_query("SELECT * FROM funcionarios_condominio WHERE FKid_condominiosCol = $id AND FKid_tipos_funcionariosCol in ($tipo) ORDER BY $orderBy $ordem LIMIT $i, $f"); 
			else
			$rs = mysql_query("SELECT * FROM funcionarios_condominio WHERE FKid_condominiosCol = $id AND FKid_tipos_funcionariosCol in ($tipo) ORDER BY $orderBy $ordem");
        while ( $r = mysql_fetch_array($rs) ){
        	$funcionarios= new funcionarios();
        	$funcionarios->id = $r['id_funcionarios_condominio'];
        	$funcionarios->id_condominios = $r['FKid_condominiosCol'];
        	$funcionarios->id_tipo_funcionario = $r['FKid_tipos_funcionariosCol'];
        	$funcionarios->nome = $r['nome'];
        	$funcionarios->data_nascimento = $r['data_nascimento'];
        	$funcionarios->cpf = $r['cpf'];
        	$funcionarios->telefone = $r['telefone'];
        	$funcionarios->celular = $r['celular'];
        	$funcionarios->email = $r['email'];
        	$funcionarios->login = $r['login'];
        	$funcionarios->senha = $r['senha'];
			$funcionarios->numero_acessos = $r['numero_acessos'];
			$funcionarios->data_criacao = $r['data_criacao'];
        	$funcionarios->status = $r['situacao'];
            $result[] = $funcionarios;
        }
        return $result;
   }  
  
  	function returnNome($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM funcionarios_condominio WHERE id_funcionarios_condominio = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$funcionarios = $r['nome'];
        	$result = $funcionarios;
		    }
        return $result;
   }  
  
  	function findAllByCond($id_condominio, $exception = "", $tipo = ""){	
  		$return = false;
		if ($exception != "") {
		$rs = mysql_query("SELECT * FROM funcionarios_condominio WHERE FKid_condominiosCol = $id_condominio AND id_funcionarios_condominio NOT IN ($exception) AND situacao = 1"); } else {
		if ($tipo != "" ) {
		$tipo = "AND FKid_tipos_funcionariosCol = $tipo";

		$rs = mysql_query("SELECT * FROM funcionarios_condominio WHERE FKid_condominiosCol = $id_condominio $tipo AND situacao = 1"); } else {
		$rs = mysql_query("SELECT * FROM funcionarios_condominio WHERE FKid_condominiosCol = $id_condominio AND situacao = 1"); } }
		while ( $r = mysql_fetch_array($rs) ){
			$funcionarios= new funcionarios();
			$funcionarios->id = $r['id_funcionarios_condominio'];
			$funcionarios->nome = $r['nome'];
    		$funcionarios->tipo = $r['tipo'];
			$result[] = $funcionarios;
		}
		
		return $result;	
	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM funcionarios_condominio");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countByBusca($nome, $cpf, $condominio){
		$result = false;
		$condicoes = "";
		$from = 'funcionarios_condominio f';
		if ($nome != "") {
			$condicoes = " AND f.nome LIKE '%".$nome."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND f.cpf LIKE '%".$cpf."%' ";
		}		
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND f.FKid_condominiosCol = cond.id_condominios";
				$from = $from.', condominios cond';			
		}		
		$rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE f.situacao = 1".$condicoes." OR f.situacao = 0".$condicoes." ORDER BY f.nome");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function existeByLogin($login, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_funcionarios_condominio FROM funcionarios_condominio WHERE login = '$login' AND FKid_condominiosCol = $condominio AND situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByLoginId($login, $id, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_funcionarios_condominio FROM funcionarios_condominio WHERE login = '$login' AND FKid_condominiosCol = $condominio AND id_funcionarios_condominio <> $id");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByCpf($cpf, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_funcionarios_condominio FROM funcionarios_condominio WHERE cpf = '{$cpf}' AND FKid_condominiosCol = $condominio");
		if ($r = mysql_fetch_array($rs) ){
		$result = true;
		}
		return $result;
	}
  
  	function existeByCpfId($cpf, $id, $condominio){
		$result = false;
		$rs = mysql_query("SELECT id_funcionarios_condominio FROM funcionarios_condominio WHERE cpf = '{$cpf}' and id_funcionarios_condominio <> $id AND FKid_condominiosCol = $condominio");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function save($funcionarios){		
    	if ( $funcionarios->id == 0){
			return mysql_query("INSERT INTO funcionarios_condominio (FKid_condominiosCol, FKid_tipos_funcionariosCol, nome, data_nascimento, cpf, telefone, celular, email, login, senha, numero_acessos, data_criacao, situacao) VALUES ({$funcionarios->id_condominios}, {$funcionarios->id_tipo_funcionario},'{$funcionarios->nome}', '{$funcionarios->data_nascimento}', '{$funcionarios->cpf}', '{$funcionarios->telefone}', '{$funcionarios->celular}', '{$funcionarios->email}', '{$funcionarios->login}', '{$funcionarios->senha}', '{$funcionarios->numero_acessos}', '{$funcionarios->data_criacao}', {$funcionarios->status})");
		}else{
			return mysql_query("UPDATE funcionarios_condominio SET FKid_tipos_funcionariosCol = {$funcionarios->id_tipo_funcionario}, nome = '{$funcionarios->nome}', data_nascimento= '{$funcionarios->data_nascimento}', cpf= '{$funcionarios->cpf}', telefone= '{$funcionarios->telefone}', celular= '{$funcionarios->celular}', email= '{$funcionarios->email}', login= '{$funcionarios->login}', senha= '{$funcionarios->senha}', situacao= {$funcionarios->status}, numero_acessos = '{$funcionarios->numero_acessos}' WHERE id_funcionarios_condominio = {$funcionarios->id}");
		}
	}
    
	function delete($id){
    	mysql_query("UPDATE funcionarios_condominio SET situacao = '0' WHERE id_funcionarios_condominio =$id");
   	}
}
?>