<?php 
class ServidorDAO{

	function findALL(){
    	$return = false;
        $rs = mysql_query("SELECT * FROM servidores ORDER BY nome_servidor");
		while ( $r = mysql_fetch_array($rs)){
                  	$Servidor = new Servidor();
	              	$Servidor->id = $r['id_servidores'];
                  	$Servidor->cpf = $r['cpf'];
                  	$Servidor->cnpj = $r['cnpj'];
                  	$Servidor->nome_contato = $r['nome_contato'];
                  	$Servidor->telefone_contato = $r['telefone_contato'];
                  	$Servidor->celular_contato = $r['celular_contato'];
                  	$Servidor->nome_servidor = $r['nome_servidor'];
	              	$Servidor->telefone_servidor = $r['telefone_servidor'];
	              	$Servidor->celular_servidor = $r['celular_servidor'];
					$Servidor->cidade_servidor = $r['cidade_servidor'];
	              	$Servidor->uf_servidor = $r['uf_servidor'];
	              	$Servidor->status = $r['situacao'];
  					$result[] = $Servidor;
  		}
		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM servidores ORDER BY nome_servidor ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM servidores ORDER BY nome_servidor ASC");
		while ( $r = mysql_fetch_array($rs)){
        	$Servidor = new Servidor();
            $Servidor->id = $r['id_servidores'];
            $Servidor->cpf = $r['cpf'];
            $Servidor->cnpj = $r['cnpj'];
            $Servidor->nome_contato = $r['nome_contato'];
            $Servidor->telefone_contato = $r['telefone_contato'];
            $Servidor->celular_contato = $r['celular_contato'];
            $Servidor->nome_servidor = $r['nome_servidor'];
	        $Servidor->telefone_servidor = $r['telefone_servidor'];
	        $Servidor->celular_servidor = $r['celular_servidor'];
			$Servidor->cidade_servidor = $r['cidade_servidor'];
	       	$Servidor->uf_servidor = $r['uf_servidor'];
	        $Servidor->status = $r['situacao'];
  			$result[] = $Servidor;
  		}
		return $result;
	}	
	
	function findTopByBusca($nome_servidor,  $cpf, $cnpj, $i = 0, $f = 0){
		$result = false;
		$condicoes = "";
		if ($nome_servidor != "") {
			$condicoes = " AND nome_servidor LIKE '%".$nome_servidor."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND cpf LIKE '%".$cpf."%' ";
		}
		if ($cnpj != ""){
			$condicoes = $condicoes." AND cnpj LIKE '%".$cnpj."%' ";
		}
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM servidores WHERE situacao = 1".$condicoes." or situacao = 0".$condicoes." ORDER BY nome_servidor ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM servidores WHERE situacao = 1".$condicoes." or situacao = 1".$condicoes." ORDER BY nome_servidor ASC");
		
		while ( $r = mysql_fetch_array($rs)){
                  	$Servidor = new Servidor();
                  $Servidor->id = $r['id_servidores'];
                  	$Servidor->cpf = $r['cpf'];
                  	$Servidor->cnpj = $r['cnpj'];
                  	$Servidor->nome_contato = $r['nome_contato'];
                  	$Servidor->telefone_contato = $r['telefone_contato'];
                  	$Servidor->celular_contato = $r['celular_contato'];
                  	$Servidor->nome_servidor = $r['nome_servidor'];
	              	$Servidor->telefone_servidor = $r['telefone_servidor'];
	              	$Servidor->celular_servidor = $r['celular_servidor'];
					$Servidor->cidade_servidor = $r['cidade_servidor'];
	      			$Servidor->uf_servidor = $r['uf_servidor'];	       
	              	$Servidor->status = $r['situacao'];	
  					$result[] = $Servidor;
  		}
		return $result;
	}	
	
  	
	function findByPk($id){
  		$return = false;
  		$rs = mysql_query("SELECT * FROM servidores WHERE id_servidores = $id");
  		while ( $r = mysql_fetch_array($rs) ){
			$Servidor = new Servidor();
			$Servidor->id = $r['id_servidores'];
            $Servidor->cpf = $r['cpf'];
            $Servidor->cnpj = $r['cnpj'];
            $Servidor->nome_contato = $r['nome_contato'];
            $Servidor->telefone_contato = $r['telefone_contato'];
            $Servidor->celular_contato = $r['celular_contato'];
            $Servidor->nome_servidor = $r['nome_servidor'];
	        $Servidor->telefone_servidor = $r['telefone_servidor'];
	        $Servidor->celular_servidor = $r['celular_servidor'];
			$Servidor->cidade_servidor = $r['cidade_servidor'];
	       	$Servidor->uf_servidor = $r['uf_servidor'];
	        $Servidor->status = $r['situacao'];
			$result = $Servidor;
		}
		return $result;
	}
	
	
	function findByCpf($cpf){
  		$return = false;
  		$rs = mysql_query("SELECT * FROM servidores WHERE cpf = '{$cpf}'");
  		if ( $r = mysql_fetch_array($rs) ){
			$Servidor= new Servidor();
			$Servidor->id = $r['id_servidores'];
            $Servidor->cpf = $r['cpf'];
            $Servidor->cnpj = $r['cnpj'];
            $Servidor->nome_contato = $r['nome_contato'];
            $Servidor->telefone_contato = $r['telefone_contato'];
            $Servidor->celular_contato = $r['celular_contato'];
            $Servidor->nome_servidor = $r['nome_servidor'];
	        $Servidor->telefone_servidor = $r['telefone_servidor'];
	        $Servidor->celular_servidor = $r['celular_servidor'];
			$Servidor->cidade_servidor = $r['cidade_servidor'];
	       	$Servidor->uf_servidor = $r['uf_servidor'];
	        $Servidor->status = $r['situacao'];
			$result = $Servidor;
		}
		return $result;
	}
	
	function findByCnpj($cnpj){	
  		$return = false;
  		$rs = mysql_query("SELECT * FROM servidores WHERE cnpj = '{$cnpj}'");
  		while ( $r = mysql_fetch_array($rs) ){
			$Servidor= new Servidor();
			$Servidor->id = $r['id_servidores'];
            $Servidor->cpf = $r['cpf'];
            $Servidor->cnpj = $r['cnpj'];
            $Servidor->nome_contato = $r['nome_contato'];
            $Servidor->telefone_contato = $r['telefone_contato'];
            $Servidor->celular_contato = $r['celular_contato'];
            $Servidor->nome_servidor = $r['nome_servidor'];
	        $Servidor->telefone_servidor = $r['telefone_servidor'];
	        $Servidor->celular_servidor = $r['celular_servidor'];
			$Servidor->cidade_servidor = $r['cidade_servidor'];
	       	$Servidor->uf_servidor = $r['uf_servidor'];
	        $Servidor->status = $r['situacao'];	
			$result = $Servidor;
		}
		return $result;	
	}
	
	function findByBusca($nome_servidor, $cpf, $cnpj){
		$result = false;
		$condicoes = "";
		if ($nome_servidor != "") {
			$condicoes = " AND nome_servidor LIKE '%".$nome_servidor."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND cpf LIKE '%".$cpf."%' ";
		}
		if ($cnpj != ""){
			$condicoes = $condicoes." AND cnpj LIKE '%".$cnpj."%' ";
		}
		$rs = mysql_query("SELECT * FROM servidores WHERE situacao = 1".$condicoes." or situacao = 0".$condicoes." ORDER BY nome_servidor ");
  		while ( $r = mysql_fetch_array($rs) ){
			$Servidor= new Servidor();
			$Servidor->id = $r['id_servidores'];
            $Servidor->cpf = $r['cpf'];
            $Servidor->cnpj = $r['cnpj'];
            $Servidor->nome_contato = $r['nome_contato'];
            $Servidor->telefone_contato = $r['telefone_contato'];
            $Servidor->celular_contato = $r['celular_contato'];
            $Servidor->nome_servidor = $r['nome_servidor'];
	        $Servidor->telefone_servidor = $r['telefone_servidor'];
	        $Servidor->celular_servidor = $r['celular_servidor'];
			$Servidor->cidade_servidor = $r['cidade_servidor'];
	       	$Servidor->uf_servidor = $r['uf_servidor'];
	        $Servidor->status = $r['situacao'];	
			$result[] = $Servidor;
		}
		return $result;	
	}
	
	function countByBusca($nome_servidor,  $cpf, $cnpj){
		$result = false;
		$condicoes = "";
		if ($nome_servidor != "") {
			$condicoes = " AND nome_servidor LIKE '%".$nome_servidor."%' ";
		}
		if ($cpf != ""){
			$condicoes = $condicoes." AND cpf LIKE '%".$cpf."%' ";
		}
		if ($cnpj != ""){
			$condicoes = $condicoes." AND cnpj LIKE '%".$cnpj."%' ";
		}
		$rs = mysql_query("SELECT COUNT(*) AS total FROM servidores WHERE situacao = 1".$condicoes." or situacao = 0".$condicoes."ORDER BY nome_servidor ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM servidores");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function existeByCpf($cpf){
		$result = false;
		$rs = mysql_query("SELECT id_servidores FROM servidores WHERE cpf = '{$cpf}'");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
  
  	function existeByCpfId($cpf, $id){
		$result = false;
		$rs = mysql_query("SELECT id_servidores FROM servidores WHERE cpf = '{$cpf}' and id_servidores <> $id");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
	
	function existeByCnpj($cnpj){
		$result = false;
		$rs = mysql_query("SELECT id_servidores FROM servidores WHERE cnpj = '{$cnpj}'");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
  
  	function existeByCnpjfId($cnpj, $id){
		$result = false;
		$rs = mysql_query("SELECT id_servidores FROM servidores WHERE cnpj = '{$cnpj}' and id_servidores <> $id");
		if ($r = mysql_fetch_array($rs) ){
			$result = true;
		}
		return $result;
	}
 
	function save($Servidor){		
		if ( $Servidor->id == 0){
			return mysql_query("INSERT INTO servidores (cpf, cnpj, nome_contato, telefone_contato, celular_contato, nome_servidor, telefone_servidor, celular_servidor, cidade_servidor, uf_servidor, situacao) VALUES ('{$Servidor->cpf}', '{$Servidor->cnpj}', '{$Servidor->nome_contato}', '{$Servidor->telefone_contato}', '{$Servidor->celular_contato}', '{$Servidor->nome_servidor}', '{$Servidor->telefone_servidor}', '{$Servidor->celular_servidor}', '{$Servidor->cidade_servidor}', '{$Servidor->uf_servidor}', {$Servidor->status})");
		}else{
			return mysql_query("UPDATE servidores SET cpf = '{$Servidor->cpf}', cnpj = '{$Servidor->cnpj}', nome_contato = '{$Servidor->nome_contato}', telefone_contato = '{$Servidor->telefone_contato}', celular_contato = '{$Servidor->celular_contato}', nome_servidor = '{$Servidor->nome_servidor}', telefone_servidor = '{$Servidor->telefone_servidor}', celular_servidor = '{$Servidor->celular_servidor}', cidade_servidor = '{$Servidor->cidade_servidor}', uf_servidor = '{$Servidor->uf_servidor}', situacao = {$Servidor->status} WHERE id_servidores = {$Servidor->id}");
  		}
	}
  
	function delete($id){
		mysql_query("UPDATE servidores SET situacao = 0 WHERE id_servidores = $id");
  	}
} 