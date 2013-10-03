<?php 
class tiposusuariosDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM tipo_usuarios ORDER BY id_tipo_usuarios");
        while ( $r = mysql_fetch_array($rs)){
        	$tiposusuarios=new tiposusuarios();
            $tiposusuarios->id = $r['id_tipo_usuarios'];
            $tiposusuarios->nome = $r['nome'];
			$tiposusuarios->descricao = $r['descricao'];
			$tiposusuarios->status = $r['situacao'];
            $result[] = $tiposusuarios;
    	}
 		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM tipo_usuarios  ORDER BY id_tipo_usuarios ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM tipo_usuarios  ORDER BY id_tipo_usuarios ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$tiposusuarios=new tiposusuarios();
            $tiposusuarios->id = $r['id_tipo_usuarios'];
            $tiposusuarios->nome = $r['nome'];
			$tiposusuarios->descricao = $r['descricao'];
			$tiposusuarios->status = $r['situacao'];
            $result[] = $tiposusuarios;
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
			$rs = mysql_query("SELECT * FROM tipo_usuarios WHERE situacao = 1".$condicoes." or WHERE situacao = 0".$condicoes." ORDER BY id_tipo_usuarios ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM tipo_usuarios WHERE situacao = 1".$condicoes." or WHERE situacao = 0".$condicoes." ORDER BY id_tipo_usuarios ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$tiposusuarios=new tiposusuarios();
            $tiposusuarios->id = $r['id_tipo_usuarios'];
            $tiposusuarios->nome = $r['nome'];
			$tiposusuarios->descricao = $r['descricao'];
			$tiposusuarios->status = $r['situacao'];
            $result[] = $tiposusuarios;
  		}
		return $result;
	}	
    
	function findByPk($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM tipo_usuarios WHERE id_tipo_usuarios = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$tiposusuarios= new tiposusuarios();
            $tiposusuarios->id = $r['id_tipo_usuarios'];
             $tiposusuarios->nome = $r['nome'];
			$tiposusuarios->descricao = $r['descricao'];
			$tiposusuarios->status = $r['situacao'];
            $result = $tiposusuarios;
        }
        return $result;
   	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM tipo_usuarios ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
    
	function countByBusca($nome, $descricao){
		$return = false;
		$condicoes = " ";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($descricao != ""){
			$condicoes = $condicoes." AND descricao LIKE '%".$descricao."%' ";
		}				
		$rs = mysql_query("SELECT COUNT(*) AS total FROM tipo_usuarios WHERE situacao = 1".$condicoes." or WHERE situacao = 0".$condicoes." ORDER BY nome ");
		
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function save($tiposusuarios){
    	if ( $tiposusuarios->id == 0){
		    return mysql_query("INSERT INTO tipo_usuarios (nome, descricao, situacao) VALUES ('{$tiposusuarios->nome}','{$tiposusuarios->descricao}',{$tiposusuarios->status})");
	    }else{
			return mysql_query("UPDATE tipo_usuarios SET nome = '{$tiposusuarios->nome}', descricao = '{$tiposusuarios->descricao}', situacao = {$tiposusuarios->status} WHERE id_tipo_usuarios = {$tiposusuarios->id}");
		}
	}
	
	function delete($id){
		mysql_query("UPDATE tipo_usuarios set situacao = 0 WHERE id_tipo_usuarios = $id");
	}
}
?>