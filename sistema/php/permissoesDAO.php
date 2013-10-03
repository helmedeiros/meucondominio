<?php 
class permissoesDAO{
 
	function findALL(){
		$return = false;
		$rs = mysql_query("SELECT * FROM permissoes");
		while ( $r = mysql_fetch_array($rs)){
			$permissoes=new permissoes();
			$permissoes->FKid_modulosCol = $r['FKid_modulosCol'];
			$permissoes->FKid_tipos_permissoesCol = $r['FKid_tipos_permissoesCol'];
			$permissoes->FKid_tipo_usuariosCol = $r['FKid_tipo_usuariosCol'];
			$result[] = $permissoes;
		}
		return $result;
	}
	
	function findTop($i = 0, $f = 0){
		$result = false;
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM permissoes ORDER BY FKid_modulosCol ASC LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM permissoes ORDER BY FKid_modulosCol ASC");
		while ( $r = mysql_fetch_array($rs)){
           	$permissoes=new permissoes();
			$permissoes->FKid_modulosCol = $r['FKid_modulosCol'];
			$permissoes->FKid_tipos_permissoesCol = $r['FKid_tipos_permissoesCol'];
			$permissoes->FKid_tipo_usuariosCol = $r['FKid_tipo_usuariosCol'];
			$result[] = $permissoes;
  		}
		return $result;
	}
	
	function findTopByBusca($modulo, $tipopermissao, $i = 0, $f = 0){
		$result = false;
		$condicoes = "";
		if ($modulo != "") {
			$condicoes = " FKid_modulosCol = ".$modulo." ";
			if ($tipopermissao != ""){
				$condicoes = $condicoes."AND FKid_tipos_permissoesCol = ".$tipopermissao." ";
			}
		}else{
			if ($tipopermissao != ""){
				$condicoes = $condicoes." FKid_tipos_permissoesCol = ".$tipopermissao." ";
			}
		}			
	
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM permissoes WHERE".$condicoes." LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM permissoes WHERE".$condicoes." ASC");
		while ( $r = mysql_fetch_array($rs)){
            $permissoes= new permissoes();
			$permissoes->FKid_modulosCol = $r['FKid_modulosCol'];
			$permissoes->FKid_tipos_permissoesCol = $r['FKid_tipos_permissoesCol'];
			$permissoes->FKid_tipo_usuariosCol = $r['FKid_tipo_usuariosCol'];
			$result[] = $permissoes;
  		}
		return $result;
	}	
 
	function findByPk($id){
		$return = false;
		$rs = mysql_query("SELECT * FROM permissoes WHERE FKid_modulosCol = $id");
		while ( $r = mysql_fetch_array($rs) ){
			$permissoes= new permissoes();
			$permissoes->FKid_modulosCol = $r['FKid_modulosCol'];
			$permissoes->FKid_tipos_permissoesCol = $r['FKid_tipos_permissoesCol'];
			$permissoes->FKid_tipo_usuariosCol = $r['FKid_tipo_usuariosCol'];
			$result = $permissoes;
		}
		return $result;
	}
	
	function findByTipoUsuario($id){
		$return = false;
		$rs = mysql_query("SELECT m. FROM permissoes p, modulos m WHERE p.FKid_modulosCol = m.id_modulos and FKid_tipo_usuariosCol = $id");
		while ( $r = mysql_fetch_array($rs) ){
			$permissoes= new permissoes();
			$permissoes->FKid_modulosCol = $r['FKid_modulosCol'];
			$permissoes->FKid_tipos_permissoesCol = $r['FKid_tipos_permissoesCol'];
			$permissoes->FKid_tipo_usuariosCol = $r['FKid_tipo_usuariosCol'];
			$result = $permissoes;
		}
		return $result;
	}
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM permissoes");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countByBusca($modulo, $tipopermissao){
		$return = false;
		$condicoes = "";
		if ($modulo != "") {
			$condicoes = " FKid_modulosCol = ".$modulo." ";
			if ($tipopermissao != ""){
				$condicoes = $condicoes."AND FKid_tipos_permissoesCol = ".$tipopermissao." ";
			}
		}else{
			if ($tipopermissao != ""){
				$condicoes = $condicoes." FKid_tipos_permissoesCol = ".$tipopermissao." ";
			}
		}						
		$rs = mysql_query("SELECT COUNT(*) AS total FROM permissoes WHERE".$condicoes);
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	//Função responsável por validar a permissão de um tipo de usuário a uma determinada tarefa em um determinado modulo
	//Parametros: 
	//				$modulo -> Id do modulo que se quer verificar a permissão
	//				$tipo -> Id do tipo de tarefa que se quer verificar a permissão
	//				$tipo_usuário -> Id do tipo de usuário que se quer verificar a permissão
	function temPermissao($modulo, $tipo, $tipo_usuario){
		$return = false;		
		$rs = mysql_query("SELECT * FROM permissoes WHERE  FKid_modulosCol = $modulo AND FKid_tipos_permissoesCol = $tipo AND FKid_tipo_usuariosCol = $tipo_usuario");
		if ( $r = mysql_fetch_array($rs) ){
			$return = true;
		}
		return $return;
	}
	
	//FUNÇÃO RESPONSÁVEL POR LIMPAR TODAS AS PERMISSÕES DE UM DETERMINADO TIPO DE USUÁRIO
	//PARAMETROS:
	//				$id -> ID DO TIPO DE USUÁRIO QUE SE QUER LIMPAR A PERMISSÃO
	function cleanPermissao($id){
		mysql_query("DELETE FROM permissoes WHERE FKid_tipo_usuariosCol = $id");		
	}
 
	function save($permissoes){		
			return mysql_query("INSERT INTO permissoes(FKid_modulosCol, FKid_tipos_permissoesCol, FKid_tipo_usuariosCol ) VALUES ($permissoes->FKid_modulosCol,$permissoes->FKid_tipos_permissoesCol,$permissoes->FKid_tipo_usuariosCol )");
	}
 
	function delete($id){
		mysql_query("DELETE FROM permissoes WHERE FKid_modulosCol = $id");
	}
 
}
?>