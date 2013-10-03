<?php 
class tiposfuncionariosDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM tipos_funcionarios ORDER BY id_tipos_funcionarios");
        while ( $r = mysql_fetch_array($rs)){
        	$tiposfuncionarios=new tiposfuncionarios();
            $tiposfuncionarios->id = $r['id_tipos_funcionarios'];
            $tiposfuncionarios->nome = $r['nome'];
			$tiposfuncionarios->descricao = $r['descricao'];
			$tiposfuncionarios->status = $r['situacao'];
            $result[] = $tiposfuncionarios;
    	}
 		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM tipos_funcionarios ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM tipos_funcionarios ORDER BY nome ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$tiposfuncionarios=new tiposfuncionarios();
            $tiposfuncionarios->id = $r['id_tipos_funcionarios'];
            $tiposfuncionarios->nome = $r['nome'];
			$tiposfuncionarios->descricao = $r['descricao'];
			$tiposfuncionarios->status = $r['situacao'];
            $result[] = $tiposfuncionarios;
  		}
		return $result;
	}
	
	function findTopByBusca($nome, $descricao, $i = 0, $f = 0){
		$result = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($descricao != ""){
			$condicoes = $condicoes." AND descricao LIKE '%".$descricao."%' ";
		}		
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM tipos_funcionarios WHERE situacao = 1".$condicoes." or situacao = 0".$condicoes." ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM tipos_funcionarios WHERE situacao = 1".$condicoes." or situacao = 0".$condicoes." ORDER BY nome ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$tiposfuncionarios=new tiposfuncionarios();
            $tiposfuncionarios->id = $r['id_tipos_funcionarios'];
            $tiposfuncionarios->nome = $r['nome'];
			$tiposfuncionarios->descricao = $r['descricao'];
			$tiposfuncionarios->status = $r['situacao'];
            $result[] = $tiposfuncionarios;
  		}
		return $result;
	}	
    
	function findByPk($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM tipos_funcionarios WHERE id_tipos_funcionarios = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$tiposfuncionarios= new tiposfuncionarios();
            $tiposfuncionarios->id = $r['id_tipos_funcionarios'];
             $tiposfuncionarios->nome = $r['nome'];
			$tiposfuncionarios->descricao = $r['descricao'];
			$tiposfuncionarios->status = $r['situacao'];
            $result = $tiposfuncionarios;
        }
        return $result;
   	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM tipos_funcionarios WHERE situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
    
	function countByBusca($nome, $descricao){
		$return = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($descricao != ""){
			$condicoes = $condicoes." AND descricao LIKE '%".$descricao."%' ";
		}				
		$rs = mysql_query("SELECT COUNT(*) AS total FROM tipos_funcionarios WHERE situacao = 1".$condicoes." or situacao = 0".$condicoes."ORDER BY nome ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function save($tiposfuncionarios){
    	if ( $tiposfuncionarios->id == 0){
		    return mysql_query("INSERT INTO tipos_funcionarios (nome, descricao, situacao) VALUES ('{$tiposfuncionarios->nome}','{$tiposfuncionarios->descricao}',{$tiposfuncionarios->status})");
	    }else{
			return mysql_query("UPDATE tipos_funcionarios SET nome = '{$tiposfuncionarios->nome}', descricao = '{$tiposfuncionarios->descricao}', situacao = {$tiposfuncionarios->status} WHERE id_tipos_funcionarios = {$tiposfuncionarios->id}");
		}
	}
	
	function delete($id){
		mysql_query("UPDATE tipos_funcionarios set situacao = 0 WHERE id_tipos_funcionarios = $id");
	}
}
?>