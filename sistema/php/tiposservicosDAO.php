<?php 
class tiposservicosDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM tipos_servicos ORDER BY id_tipos_servicos");
        while ( $r = mysql_fetch_array($rs)){
        	$tiposservicos=new tiposservicos();
            $tiposservicos->id = $r['id_tipos_servicos'];
            $tiposservicos->nome = $r['nome'];
			$tiposservicos->descricao = $r['descricao'];
			$tiposservicos->status = $r['situacao'];
            $result[] = $tiposservicos;
    	}
 		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM tipos_servicos ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM tipos_servicos ORDER BY nome ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$tiposservicos=new tiposservicos();
            $tiposservicos->id = $r['id_tipos_servicos'];
            $tiposservicos->nome = $r['nome'];
			$tiposservicos->descricao = $r['descricao'];
			$tiposservicos->status = $r['situacao'];
            $result[] = $tiposservicos;
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
			$rs = mysql_query("SELECT * FROM tipos_servicos WHERE situacao = 1".$condicoes." or situacao = 0".$condicoes." ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM tipos_servicos WHERE situacao = 1".$condicoes."or situacao = 0".$condicoes." ORDER BY nome ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$tiposservicos=new tiposservicos();
            $tiposservicos->id = $r['id_tipos_servicos'];
            $tiposservicos->nome = $r['nome'];
			$tiposservicos->descricao = $r['descricao'];
			$tiposservicos->status = $r['situacao'];
            $result[] = $tiposservicos;
  		}
		return $result;
	}	
    
	function findByPk($id){
    	$return = false;
		
        $rs = mysql_query("SELECT * FROM tipos_servicos WHERE id_tipos_servicos = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$tiposservicos= new tiposservicos();
            $tiposservicos->id = $r['id_tipos_servicos'];
             $tiposservicos->nome = $r['nome'];
			$tiposservicos->descricao = $r['descricao'];
			$tiposservicos->status = $r['situacao'];
            $result = $tiposservicos;
        }
        return $result;
   	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM tipos_servicos WHERE situacao = 1");
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
		$rs = mysql_query("SELECT COUNT(*) AS total FROM tipos_servicos WHERE situacao = 1".$condicoes." or situacao = 1".$condicoes."ORDER BY nome ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function save($tiposservicos){
    	if ( $tiposservicos->id == 0){
		    return mysql_query("INSERT INTO tipos_servicos (nome, descricao, situacao) VALUES ('{$tiposservicos->nome}','{$tiposservicos->descricao}',{$tiposservicos->status})");
	    }else{
			return mysql_query("UPDATE tipos_servicos SET nome = '{$tiposservicos->nome}', descricao = '{$tiposservicos->descricao}', situacao = {$tiposservicos->status} WHERE id_tipos_servicos = {$tiposservicos->id}");
		}
	}
	
	function delete($id){
		mysql_query("UPDATE tipos_servicos set situacao = 0 WHERE id_tipos_servicos = $id");
	}
}
?>