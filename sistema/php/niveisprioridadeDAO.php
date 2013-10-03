<?php 
class niveisprioridadeDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM niveis_prioridades ORDER BY id_niveis_prioridades");
        while ( $r = mysql_fetch_array($rs)){
        	$niveisprioridade=new niveisprioridade();
            $niveisprioridade->id = $r['id_niveis_prioridades'];
            $niveisprioridade->nome = $r['nome'];
			$niveisprioridade->descricao = $r['descricao'];
			$niveisprioridade->status = $r['situacao'];
            $result[] = $niveisprioridade;
    	}
 		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM niveis_prioridades WHERE situacao = 1 ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM niveis_prioridades WHERE situacao = 1 ORDER BY nome ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$niveisprioridade=new niveisprioridade();
            $niveisprioridade->id = $r['id_niveis_prioridades'];
            $niveisprioridade->nome = $r['nome'];
			$niveisprioridade->descricao = $r['descricao'];
			$niveisprioridade->status = $r['situacao'];
            $result[] = $niveisprioridade;
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
			$rs = mysql_query("SELECT * FROM niveis_prioridades WHERE situacao = 1".$condicoes." ORDER BY nome ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM niveis_prioridades WHERE situacao = 1".$condicoes." ORDER BY nome ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$niveisprioridade=new niveisprioridade();
            $niveisprioridade->id = $r['id_niveis_prioridades'];
            $niveisprioridade->nome = $r['nome'];
			$niveisprioridade->descricao = $r['descricao'];
			$niveisprioridade->status = $r['situacao'];
            $result[] = $niveisprioridade;
  		}
		return $result;
	}	
    
	function findByPk($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM niveis_prioridades WHERE id_niveis_prioridades = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$niveisprioridade= new niveisprioridade();
            $niveisprioridade->id = $r['id_niveis_prioridades'];
             $niveisprioridade->nome = $r['nome'];
			$niveisprioridade->descricao = $r['descricao'];
			$niveisprioridade->status = $r['situacao'];
            $result = $niveisprioridade;
        }
        return $result;
   	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM niveis_prioridades WHERE situacao = 1");
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
		$rs = mysql_query("SELECT COUNT(*) AS total FROM niveis_prioridades WHERE situacao = 1".$condicoes."ORDER BY nome ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function save($niveisprioridade){
    	if ( $niveisprioridade->id == 0){
		    return mysql_query("INSERT INTO niveis_prioridades (nome, descricao, situacao) VALUES ('{$niveisprioridade->nome}','{$niveisprioridade->descricao}',{$niveisprioridade->status})");
	    }else{
			return mysql_query("UPDATE niveis_prioridades SET nome = '{$niveisprioridade->nome}', descricao = '{$niveisprioridade->descricao}', situacao = {$niveisprioridade->status} WHERE id_niveis_prioridades = {$niveisprioridade->id}");
		}
	}
	
	function delete($id){
		mysql_query("UPDATE niveis_prioridades set situacao = 0 WHERE id_niveis_prioridades = $id");
	}
}
?>