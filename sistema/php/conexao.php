<?php 
class Conexao{
	var $con;
	
	function conecta(){
		$this->con = mysql_connect("mysql01.meucondominio.net","meucondominio2","m3uc0nd0m1n10") or die ("erro");
		mysql_select_db("meucondominio2", $this->con);
	}
}
?>