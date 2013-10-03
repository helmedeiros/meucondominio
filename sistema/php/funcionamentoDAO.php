<?php 
class funcionamentoDAO{
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM funcionamento WHERE situacao = 1 ORDER BY id_funcionamento");
        while ( $r = mysql_fetch_array($rs)){
        	$funcionamento=new funcionamento();
            $funcionamento->id = $r['id_funcionamento'];
            $funcionamento->nome = $r['nome'];
			$funcionamento->impedimento = $r['impedimento'];
			$funcionamento->status = $r['situacao'];
            $result[] = $funcionamento;
    	}
 		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM funcionamento ORDER BY id_funcionamento ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM funcionamento ORDER BY id_funcionamento ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$funcionamento=new funcionamento();
            $funcionamento->id = $r['id_funcionamento'];
            $funcionamento->nome = $r['nome'];
			$funcionamento->impedimento = $r['impedimento'];
			$funcionamento->status = $r['situacao'];
            $result[] = $funcionamento;
  		}
		return $result;
	}
	
	function findTopByBusca($nome, $impedimento, $i = 0, $f = 0){
		$result = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($impedimento != ""){
			$condicoes = $condicoes." AND impedimento = ".$impedimento." ";
		}		
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM funcionamento WHERE situacao = 1".$condicoes." OR situacao = 0".$condicoes." ORDER BY id_funcionamento ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM funcionamento WHERE situacao = 1".$condicoes." OR situacao = 0".$condicoes." ORDER BY id_funcionamento ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$funcionamento=new funcionamento();
            $funcionamento->id = $r['id_funcionamento'];
            $funcionamento->nome = $r['nome'];
			$funcionamento->impedimento = $r['impedimento'];
			$funcionamento->status = $r['situacao'];
            $result[] = $funcionamento;
  		}
		return $result;
	}	
    
	function findByPk($id){
    	$return = false;
        $rs = mysql_query("SELECT * FROM funcionamento WHERE id_funcionamento = $id");
        while ( $r = mysql_fetch_array($rs) ){
        	$funcionamento= new funcionamento();
            $funcionamento->id = $r['id_funcionamento'];
             $funcionamento->nome = $r['nome'];
			$funcionamento->impedimento = $r['impedimento'];
			$funcionamento->status = $r['situacao'];
            $result = $funcionamento;
        }
        return $result;
   	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM funcionamento WHERE situacao = 1");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
    
	function countByBusca($nome, $impedimento){
		$return = false;
		$condicoes = "";
		if ($nome != "") {
			$condicoes = " AND nome LIKE '%".$nome."%' ";
		}
		if ($impedimento != ""){
			$condicoes = $condicoes." AND impedimento = ".$impedimento." ";
		}				
		$rs = mysql_query("SELECT COUNT(*) AS total FROM funcionamento WHERE situacao = 1".$condicoes." OR situacao = 0".$condicoes." ORDER BY id_funcionamento ");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function save($funcionamento){
    	if ( $funcionamento->id == 0){
		    return mysql_query("INSERT INTO funcionamento (nome, impedimento, situacao) VALUES ('{$funcionamento->nome}',{$funcionamento->impedimento},{$funcionamento->status})");
	    }else{
			return mysql_query("UPDATE funcionamento SET nome = '{$funcionamento->nome}', impedimento = {$funcionamento->impedimento}, situacao = {$funcionamento->status} WHERE id_funcionamento = {$funcionamento->id}");
		}
	}
	
	function delete($id){
		mysql_query("UPDATE funcionamento set situacao = 0 WHERE id_funcionamento = $id");
	}
}
?>