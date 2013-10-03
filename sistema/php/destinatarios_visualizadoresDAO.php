<?php 
class destinatarios_visualizadoresDAO{
	function findALL(){
    	$return = false;
        $rs = mysql_query("SELECT * FROM destinatarios_visualizadores AND situacao <> 0");
        while ( $r = mysql_fetch_array($rs)){
        	$destinatarios_visualizadores=new destinatarios_visualizadores();
			$destinatarios_visualizadores->id_criticas_sugestoes = $r['FKid_criticas_sugestoesCol'];
            $destinatarios_visualizadores->id_tipo_usuario = $r['Fkid_tipos_usuariosCol'];
            $destinatarios_visualizadores->id_tipo_funcionario = $r['Fkid_tipos_funcionariosCol'];
            $destinatarios_visualizadores->id_membro_condominio = $r['FKid_membroscondominioCol'];
            $destinatarios_visualizadores->id_funcionario_condominio = $r['FKid_funcionarios_condominioCol'];				  				
            $result[] = $destinatarios_visualizadores;			   
     	}
		return $result;
	 }
    
	 function findByPk($id){
     	$return = false;
        $rs = mysql_query("SELECT * FROM destinatarios_visualizadores WHERE FKid_criticas_sugestoesCol = $id AND situacao <> 0");
        while ( $r = mysql_fetch_array($rs)){
        	$destinatarios_visualizadores=new destinatarios_visualizadores();
			$destinatarios_visualizadores->id_criticas_sugestoes = $r['FKid_criticas_sugestoesCol'];
            $destinatarios_visualizadores->id_tipo_usuario = $r['Fkid_tipos_usuariosCol'];
            $destinatarios_visualizadores->id_tipo_funcionario = $r['Fkid_tipos_funcionariosCol'];
            $destinatarios_visualizadores->id_membro_condominio = $r['FKid_membroscondominioCol'];
            $destinatarios_visualizadores->id_funcionario_condominio = $r['FKid_funcionarios_condominioCol'];				  				
            $result[] = $destinatarios_visualizadores;   
	    }
		return $result;
	}
 
 
 
	function findByCSU($id, $cs){
    	$return = false;
		$rs = mysql_query("SELECT * FROM destinatarios_visualizadores WHERE Fkid_tipos_usuariosCol = $id AND FKid_criticas_sugestoesCol = $cs AND situacao <> 0");
        while ( $r = mysql_fetch_array($rs) ){
        	$destinatarios_visualizadores=new destinatarios_visualizadores();
			$destinatarios_visualizadores->id_criticas_sugestoes = $r['FKid_criticas_sugestoesCol'];
            $destinatarios_visualizadores->id_tipo_usuario = $r['Fkid_tipos_usuariosCol'];
            $destinatarios_visualizadores->id_membro_condominio = $r['FKid_membroscondominioCol'];
            $result[] = $destinatarios_visualizadores;
		}
		return $result;
	}
   
	function findByCSF($id, $cs){
		$return = false;
		$rs = mysql_query("SELECT * FROM destinatarios_visualizadores WHERE Fkid_tipos_funcionariosCol = $id AND FKid_criticas_sugestoesCol = $cs AND situacao <> 0");
		while ( $r = mysql_fetch_array($rs) ){
			$destinatarios_visualizadores=new destinatarios_visualizadores();
			$destinatarios_visualizadores->id_criticas_sugestoes = $r['FKid_criticas_sugestoesCol'];
			$destinatarios_visualizadores->id_tipo_funcionario = $r['Fkid_tipos_funcionariosCol'];
			$destinatarios_visualizadores->id_funcionario_condominio = $r['FKid_funcionarios_condominioCol'];				  				
			$result[] = $destinatarios_visualizadores;
		}
        return $result;
	}
   
    function countAllByTu($id, $cs){
		$return = false;
		$rs = mysql_query("SELECT COUNT( * ) AS total FROM destinatarios_visualizadores WHERE Fkid_tipos_usuariosCol = $id AND FKid_criticas_sugestoesCol = $cs AND situacao <> 0");
		if ( $r = mysql_fetch_array($rs)){
			$result = $r['total'];
		}
		return $result;
	}

	function countAllByTf($id, $cs){
		$return = false;
		$rs = mysql_query("SELECT COUNT( * ) AS total FROM destinatarios_visualizadores WHERE Fkid_tipos_funcionariosCol = $id AND FKid_criticas_sugestoesCol = $cs AND situacao <> 0");
		if ( $r = mysql_fetch_array($rs)){
			$result = $r['total'];
		}
		return $result;
	}

	function findbyVLZU($id, $cs){
		$return = false;		
		$rs = mysql_query("SELECT  * FROM destinatarios_visualizadores WHERE Fkid_tipos_usuariosCol = $id AND FKid_membroscondominioCol = $cs AND situacao <> 0");
		while ( $r = mysql_fetch_array($rs) ){
			$destinatarios_visualizadores=new destinatarios_visualizadores();
			$destinatarios_visualizadores->id_criticas_sugestoes = $r['FKid_criticas_sugestoesCol'];
			$destinatarios_visualizadores->id_tipo_funcionario = $r['Fkid_tipos_funcionariosCol'];
			$destinatarios_visualizadores->id_funcionario_condominio = $r['FKid_funcionarios_condominioCol'];				  				
			$result[] = $destinatarios_visualizadores;
		}
		return $result;
	}


	function saveUsr($d_v){
		return mysql_query("INSERT INTO destinatarios_visualizadores (FKid_criticas_sugestoesCol, FKid_funcionarios_condominioCol, FKid_membroscondominioCol, Fkid_tipos_usuariosCol, Fkid_tipos_funcionariosCol, situacao) VALUES ('{$d_v->id_criticas_sugestoes}', NULL, '{$d_v->id_membro_condominio}', '{$d_v->id_tipo_usuario}', NULL, 1)");
	}

	function saveFNC($d_v){
		return mysql_query("INSERT INTO destinatarios_visualizadores (FKid_criticas_sugestoesCol, FKid_funcionarios_condominioCol, FKid_membroscondominioCol, Fkid_tipos_usuariosCol, Fkid_tipos_funcionariosCol, situacao) VALUES ('{$d_v->id_criticas_sugestoes}', '{$d_v->id_funcionario_condominio}', NULL, NULL, '{$d_v->id_tipo_funcionario}', 1)");
	}



	function delete($id){
		mysql_query("UPDATE destinatarios_visualizadores SET situacao = 0 WHERE FKid_criticas_sugestoesCol = $id");
	}
}
?>