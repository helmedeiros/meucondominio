<?php 
class SuperUsuarioDAO{

	function findALL(){
    	$return = false;
        $rs = mysql_query("SELECT * FROM super_usuarios WHERE situacao = 1 ORDER BY nome");
		while ( $r = mysql_fetch_array($rs)){
                  	$SuperUsuario=new SuperUsuario();
                  	$SuperUsuario->id = $r['id_super_usuarios'];
  					$SuperUsuario->id_tipo_usuario = $r['FKid_tipo_usuariosCol'];
					$SuperUsuario->nome = $r['nome'];
  					$SuperUsuario->login = $r['login'];
  					$SuperUsuario->senha_alteracao = $r['senha_alteracao'];
  					$SuperUsuario->senha_criacao_condominio = $r['senha_criacao_condominio'];
  					$SuperUsuario->senha = $r['senha'];
					$SuperUsuario->numero_acessos = $r['numero_acessos'];
					$SuperUsuario->data_criacao = $r['data_criacao'];
					$SuperUsuario->celular = $r['celular'];
					$SuperUsuario->email = $r['email'];
					$SuperUsuario->status = $r['situacao'];
					$SuperUsuario->cpf = $r['cpf'];
  					$result[] = $SuperUsuario;
  		}
		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM super_usuarios WHERE situacao = 1 ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM super_usuarios WHERE situacao = 1 ORDER BY nome ASC");
		while ( $r = mysql_fetch_array($rs)){
                  	$SuperUsuario=new SuperUsuario();
                  	$SuperUsuario->id = $r['id_super_usuarios'];
  					$SuperUsuario->id_tipo_usuario = $r['FKid_tipo_usuariosCol'];
					$SuperUsuario->nome = $r['nome'];
  					$SuperUsuario->login = $r['login'];
  					$SuperUsuario->senha_alteracao = $r['senha_alteracao'];
  					$SuperUsuario->senha_criacao_condominio = $r['senha_criacao_condominio'];
  					$SuperUsuario->senha = $r['senha'];
					$SuperUsuario->numero_acessos = $r['numero_acessos'];
					$SuperUsuario->data_criacao = $r['data_criacao'];
					$SuperUsuario->celular = $r['celular'];
					$SuperUsuario->email = $r['email'];
					$SuperUsuario->status = $r['situacao'];		
					$SuperUsuario->cpf = $r['cpf'];			
  					$result[] = $SuperUsuario;
  		}
		return $result;
	}	
	
	function findTopByBusca($nome, $login, $celular, $i = 0, $f = 0){
		$result = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($login != ""){
			$condicoes = $condicoes." AND login LIKE '%".$login."%' ";
		}
		if ($celular != ""){
			$condicoes = $condicoes." AND celular LIKE '%".$celular."%' ";
		}
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM super_usuarios WHERE situacao = 1".$condicoes." ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM super_usuarios WHERE situacao = 1".$condicoes." ORDER BY nome ASC");
		
		while ( $r = mysql_fetch_array($rs)){
                  	$SuperUsuario=new SuperUsuario();
                  	$SuperUsuario->id = $r['id_super_usuarios'];
  					$SuperUsuario->id_tipo_usuario = $r['FKid_tipo_usuariosCol'];
					$SuperUsuario->nome = $r['nome'];
  					$SuperUsuario->login = $r['login'];
  					$SuperUsuario->senha_alteracao = $r['senha_alteracao'];
  					$SuperUsuario->senha_criacao_condominio = $r['senha_criacao_condominio'];
  					$SuperUsuario->senha = $r['senha'];
					$SuperUsuario->numero_acessos = $r['numero_acessos'];
					$SuperUsuario->data_criacao = $r['data_criacao'];
					$SuperUsuario->celular = $r['celular'];
					$SuperUsuario->email = $r['email'];					
					$SuperUsuario->status = $r['situacao'];		
					$SuperUsuario->cpf = $r['cpf'];			
  					$result[] = $SuperUsuario;
  		}
		return $result;
	}	
	
  	
	function findByPk($id){
  		$return = false;
  		$rs = mysql_query("SELECT * FROM super_usuarios WHERE id_super_usuarios = $id AND situacao = 1");
  		while ( $r = mysql_fetch_array($rs) ){
			$SuperUsuario= new SuperUsuario();
			$SuperUsuario->id = $r['id_super_usuarios'];
			$SuperUsuario->id_tipo_usuario = $r['FKid_tipo_usuariosCol'];
			$SuperUsuario->nome = $r['nome'];
			$SuperUsuario->login = $r['login'];
			$SuperUsuario->senha_alteracao = $r['senha_alteracao'];
			$SuperUsuario->senha_criacao_condominio = $r['senha_criacao_condominio'];
			$SuperUsuario->senha = $r['senha'];
			$SuperUsuario->numero_acessos = $r['numero_acessos'];
			$SuperUsuario->data_criacao = $r['data_criacao'];
			$SuperUsuario->celular = $r['celular'];
			$SuperUsuario->email = $r['email'];		
			$SuperUsuario->status = $r['situacao'];			
			$SuperUsuario->cpf = $r['cpf'];			
			$result = $SuperUsuario;
		}
		return $result;
	}
	
	
	function findByCpf($cpf){
  		$return = false;
  		$rs = mysql_query("SELECT * FROM super_usuarios WHERE cpf = '{$cpf}'");
  		if ( $r = mysql_fetch_array($rs) ){
			$SuperUsuario= new SuperUsuario();
			$SuperUsuario->id = $r['id_super_usuarios'];
			$SuperUsuario->id_tipo_usuario = $r['FKid_tipo_usuariosCol'];
			$SuperUsuario->nome = $r['nome'];
			$SuperUsuario->login = $r['login'];
			$SuperUsuario->senha_alteracao = $r['senha_alteracao'];
			$SuperUsuario->senha_criacao_condominio = $r['senha_criacao_condominio'];
			$SuperUsuario->senha = $r['senha'];
			$SuperUsuario->numero_acessos = $r['numero_acessos'];
			$SuperUsuario->data_criacao = $r['data_criacao'];
			$SuperUsuario->celular = $r['celular'];
  			$SuperUsuario->email = $r['email'];
			$SuperUsuario->status = $r['situacao'];			
			$SuperUsuario->cpf = $r['cpf'];			
			$result = $SuperUsuario;
		}
		return $result;
	}
	
	function findByLogin($login){	
  		$return = false;
  		$rs = mysql_query("SELECT * FROM super_usuarios WHERE login = '{$login}' AND situacao = 1");
  		while ( $r = mysql_fetch_array($rs) ){
			$SuperUsuario= new SuperUsuario();
			$SuperUsuario->id = $r['id_super_usuarios'];
			$SuperUsuario->id_tipo_usuario = $r['FKid_tipo_usuariosCol'];
			$SuperUsuario->nome = $r['nome'];
			$SuperUsuario->login = $r['login'];
			$SuperUsuario->senha_alteracao = $r['senha_alteracao'];
			$SuperUsuario->senha_criacao_condominio = $r['senha_criacao_condominio'];
			$SuperUsuario->senha = $r['senha'];
			$SuperUsuario->numero_acessos = $r['numero_acessos'];
			$SuperUsuario->data_criacao = $r['data_criacao'];
			$SuperUsuario->celular = $r['celular'];
			$SuperUsuario->email = $r['email'];		
			$SuperUsuario->status = $r['situacao'];			
			$SuperUsuario->cpf = $r['cpf'];			
			$result = $SuperUsuario;
		}
		return $result;	
	}
	
	function findResp($id_responsavel){	
  		$return = false;
  		$rs = mysql_query("SELECT * FROM super_usuarios WHERE id_super_usuarios = $id_responsavel AND situacao = 1");
  		while ( $r = mysql_fetch_array($rs) ){
			$SuperUsuario= new SuperUsuario();
			$SuperUsuario->nome = $r['nome'];
			$SuperUsuario->id = $r['id_super_usuarios'];
			$result = $SuperUsuario;
		}
		return $result;	
	}
	
	function findByBusca($nome, $login, $celular){
		$return = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($login != ""){
			$condicoes = $condicoes." AND login LIKE '%".$login."%' ";
		}
		
		$rs = mysql_query("SELECT * FROM super_usuarios WHERE situacao = 1".$condicoes."ORDER BY nome ");
  		while ( $r = mysql_fetch_array($rs) ){
			$SuperUsuario= new SuperUsuario();
			$SuperUsuario->id = $r['id_super_usuarios'];
			$SuperUsuario->id_tipo_usuario = $r['FKid_tipo_usuariosCol'];
			$SuperUsuario->nome = $r['nome'];
			$SuperUsuario->login = $r['login'];
			$SuperUsuario->senha_alteracao = $r['senha_alteracao'];
			$SuperUsuario->senha_criacao_condominio = $r['senha_criacao_condominio'];
			$SuperUsuario->senha = $r['senha'];
			$SuperUsuario->numero_acessos = $r['numero_acessos'];
			$SuperUsuario->data_criacao = $r['data_criacao'];
			$SuperUsuario->email = $r['email'];
			$SuperUsuario->celular = $r['celular'];
			$SuperUsuario->status = $r['situacao'];			
			$SuperUsuario->cpf = $r['cpf'];			
			$result[] = $SuperUsuario;
		}
		return $result;	
	}
	
	function countByBusca($nome, $login, $celular){
		$return = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($login != ""){
			$condicoes = $condicoes." AND login LIKE '%".$login."%' ";
		}
		if ($celular != ""){
			$condicoes = $condicoes." AND celular LIKE '%".$celular."%' ";
		}
		$rs = mysql_query("SELECT COUNT(*) AS total FROM super_usuarios WHERE situacao = 1".$condicoes."ORDER BY nome ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM super_usuarios WHERE situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function existeByLogin($login){
		$result = false;
		$rs = mysql_query("SELECT id_super_usuarios FROM super_usuarios WHERE login = '$login' AND situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByLoginId($login, $id){
		$result = false;
		$rs = mysql_query("SELECT id_super_usuarios FROM super_usuarios WHERE login = '$login' and id_super_usuarios <> $id");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByCpf($cpf){
		$result = false;
		$rs = mysql_query("SELECT id_super_usuarios FROM super_usuarios WHERE cpf = '{$cpf}'");
		if ($r = mysql_fetch_array($rs) ){
		$result = true;
		}
		return $result;
	}
  
  	function existeByCpfId($cpf, $id){
		$result = false;
		$rs = mysql_query("SELECT id_super_usuarios FROM super_usuarios WHERE cpf = '{$cpf}' and id_super_usuarios <> $id");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function lastId(){
           $return = false;
           $rs = mysql_query("SELECT id_super_usuarios FROM super_usuarios ORDER BY id_super_usuarios DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
                $lid =  $r['id_super_usuarios'];
		     	$result = $lid;
      	}
          return $result;
   }
 
	function save($SuperUsuario){		
		if ( $SuperUsuario->id == 0){
			return mysql_query("INSERT INTO super_usuarios (FKid_tipo_usuariosCol, nome, login, senha_alteracao, senha_criacao_condominio, senha, numero_acessos, data_criacao, celular, situacao, cpf, email) VALUES ({$SuperUsuario->id_tipo_usuario}, '{$SuperUsuario->nome}', '{$SuperUsuario->login}', '{$SuperUsuario->senha_alteracao}', '{$SuperUsuario->senha_criacao_condominio}', '{$SuperUsuario->senha}', '{$SuperUsuario->numero_acessos}', '{$SuperUsuario->data_criacao}', '{$SuperUsuario->celular}', 1, '{$SuperUsuario->cpf}', '{$SuperUsuario->email}')");
		}else{
			return mysql_query("UPDATE super_usuarios SET nome = '{$SuperUsuario->nome}', login= '{$SuperUsuario->login}', senha_alteracao= '{$SuperUsuario->senha_alteracao}', senha_criacao_condominio= '{$SuperUsuario->senha_criacao_condominio}', senha= '{$SuperUsuario->senha}', numero_acessos = '{$SuperUsuario->numero_acessos}', data_criacao = '{$SuperUsuario->data_criacao}', celular = '{$SuperUsuario->celular}', cpf = '{$SuperUsuario->cpf}', situacao = '{$SuperUsuario->status}' WHERE id_super_usuarios = {$SuperUsuario->id}");
  		}
	}
  
	function delete($id){
		mysql_query("UPDATE super_usuarios SET situacao = 0 WHERE id_super_usuarios = $id");
  	}
} 
?>