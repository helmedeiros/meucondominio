<?php 
require_once("../../php/conexao.php");
require_once("../../php/condominios.php");
require_once("../../php/condominiosDAO.php");
require_once("../../php/superusuario.php");
require_once("../../php/superusuarioDAO.php");
require_once("../../php/permissoes.php");
require_once("../../php/permissoesDAO.php");
require_once("../../php/aditivos.php");
require_once("../../php/aditivosDAO.php");
require_once("../../php/regimentos.php");
require_once("../../php/regimentosDAO.php");
require_once("../../php/ftp.php");

@session_start();



$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../../logoff.php");
	exit();
}

$conexao = new Conexao();	
$conexao->conecta();
$id_condominio =  $_SESSION['id_condominio'];


if(!permissoesDAO::temPermissao(7,2,$usuario->id_tipo_usuario)){ //verifica se o su possue permissão para inserir(2) em area custo(30)
		header("Location: ../../index.php");
		exit();
	}


if($_FILES['arquivo']['name'] != ""){ //retorna o nome da extensao
  $arquivo = $_FILES['arquivo'];
   for ( $i = 0 ; $i <= strlen($arquivo_name) ; $i++) {
	 if ($aux == 1) { $name = $name.$arquivo_name[$i]; }   
      if ($arquivo_name[$i] == ".") { $aux = 1; }	
	}
$arquivo_name = "$adt.$name";
 } 



//if( empty($_GET['id']) && empty($_POST['id']) )
//{
//	header("Location: ../../home.php");
//}	

	 $aditivos = aditivosDAO::findByPk($adt);
	if($_FILES['arquivo']['name'] != ""){
		$arquivo = $_FILES['arquivo'];
		$ftp = new Ftp();
		$ftp->salvaAdt($id_condominio, $arquivo, $arquivo_name);
		$aditivos->nome_arquivo = $arquivo_name;	
		}

$id = aditivosDAO::save($aditivos, $adt);
header("Location: home.php?reg=$reg");
	exit();
	
	
	
?>