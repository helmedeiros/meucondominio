<?php 
class modulosDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM modulos WHERE situacao = 1 ORDER BY nome");
        while ( $r = mysql_fetch_array($rs)){
        	$modulos=new modulos();
            $modulos->id = $r['id_modulos'];
            $modulos->nome = $r['nome'];
			$modulos->descricao = $r['descricao'];
			$modulos->status = $r['situacao'];
            $result[] = $modulos;
    	}
 		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM modulos WHERE situacao = 1 ORDER BY id_modulos ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM modulos WHERE situacao = 1 ORDER BY id_modulos ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$modulos=new modulos();
            $modulos->id = $r['id_modulos'];
            $modulos->nome = $r['nome'];
			$modulos->descricao = $r['descricao'];
			$modulos->status = $r['situacao'];
            $result[] = $modulos;
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
			$rs = mysql_query("SELECT * FROM modulos WHERE situacao = 1".$condicoes." ORDER BY id_modulos ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM modulos WHERE situacao = 1".$condicoes." ORDER BY id_modulos ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$modulos=new modulos();
            $modulos->id = $r['id_modulos'];
            $modulos->nome = $r['nome'];
			$modulos->descricao = $r['descricao'];
			$modulos->status = $r['situacao'];
            $result[] = $modulos;
  		}
		return $result;
	}	
    
	function findByPk($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM modulos WHERE id_modulos = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$modulos= new modulos();
            $modulos->id = $r['id_modulos'];
             $modulos->nome = $r['nome'];
			$modulos->descricao = $r['descricao'];
			$modulos->status = $r['situacao'];
            $result = $modulos;
        }
        return $result;
   	}
	
	function findByTipoUsuario($id){
		$return = false;
		$rs = mysql_query("SELECT DISTINCT (m.id_modulos), m.nome FROM permissoes p, modulos m WHERE p.FKid_modulosCol = m.id_modulos AND FKid_tipo_usuariosCol = $id ORDER BY m.nome");
		while ( $r = mysql_fetch_array($rs) ){
			$modulos= new modulos();      
		    $modulos->id = $r['id_modulos'];      
            $modulos->nome = $r['nome'];
            $result[] = $modulos;
		}
		return $result;
	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM modulos WHERE situacao = 1");
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
		$rs = mysql_query("SELECT COUNT(*) AS total FROM modulos WHERE situacao = 1".$condicoes."ORDER BY id_modulos ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function save($modulos){
    	if ( $modulos->id == 0){
		    return mysql_query("INSERT INTO modulos (nome, descricao, situacao) VALUES ('{$modulos->nome}','{$modulos->descricao}',{$modulos->status})");
	    }else{
			return mysql_query("UPDATE modulos SET nome = '{$modulos->nome}', descricao = '{$modulos->descricao}', situacao = {$modulos->status} WHERE id_modulos = {$modulos->id}");
		}
	}
	
	function delete($id){
		mysql_query("UPDATE modulos set situacao = 0 WHERE id_modulos = $id");
	}
}
?>