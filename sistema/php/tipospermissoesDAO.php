<?php 
class tipospermissoesDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM tipos_permissoes WHERE situacao = 1 ORDER BY id_tipos_permissoes");
        while ( $r = mysql_fetch_array($rs)){
        	$tipospermissoes=new tipospermissoes();
            $tipospermissoes->id = $r['id_tipos_permissoes'];
            $tipospermissoes->nome = $r['nome'];
			$tipospermissoes->descricao = $r['descricao'];
			$tipospermissoes->status = $r['situacao'];
            $result[] = $tipospermissoes;
    	}
 		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM tipos_permissoes WHERE situacao = 1 ORDER BY id_tipos_permissoes ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM tipos_permissoes WHERE situacao = 1 ORDER BY id_tipos_permissoes ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$tipospermissoes=new tipospermissoes();
            $tipospermissoes->id = $r['id_tipos_permissoes'];
            $tipospermissoes->nome = $r['nome'];
			$tipospermissoes->descricao = $r['descricao'];
			$tipospermissoes->status = $r['situacao'];
            $result[] = $tipospermissoes;
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
			$rs = mysql_query("SELECT * FROM tipos_permissoes WHERE situacao = 1".$condicoes." ORDER BY id_tipos_permissoes ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM tipos_permissoes WHERE situacao = 1".$condicoes." ORDER BY id_tipos_permissoes ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$tipospermissoes=new tipospermissoes();
            $tipospermissoes->id = $r['id_tipos_permissoes'];
            $tipospermissoes->nome = $r['nome'];
			$tipospermissoes->descricao = $r['descricao'];
			$tipospermissoes->status = $r['situacao'];
            $result[] = $tipospermissoes;
  		}
		return $result;
	}	
    
	function findByPk($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM tipos_permissoes WHERE id_tipos_permissoes = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$tipospermissoes= new tipospermissoes();
            $tipospermissoes->id = $r['id_tipos_permissoes'];
             $tipospermissoes->nome = $r['nome'];
			$tipospermissoes->descricao = $r['descricao'];
			$tipospermissoes->status = $r['situacao'];
            $result = $tipospermissoes;
        }
        return $result;
   	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM tipos_permissoes WHERE situacao = 1");
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
		$rs = mysql_query("SELECT COUNT(*) AS total FROM tipos_permissoes WHERE situacao = 1".$condicoes."ORDER BY id_tipos_permissoes ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function save($tipospermissoes){
    	if ( $tipospermissoes->id == 0){
		    return mysql_query("INSERT INTO tipos_permissoes (nome, descricao, situacao) VALUES ('{$tipospermissoes->nome}','{$tipospermissoes->descricao}',{$tipospermissoes->status})");
	    }else{
			return mysql_query("UPDATE tipos_permissoes SET nome = '{$tipospermissoes->nome}', descricao = '{$tipospermissoes->descricao}', situacao = {$tipospermissoes->status} WHERE id_tipos_permissoes = {$tipospermissoes->id}");
		}
	}
	
	function delete($id){
		mysql_query("UPDATE tipos_permissoes set situacao = 0 WHERE id_tipos_permissoes = $id");
	}
}
?>