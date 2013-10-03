<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/participante.php");
require_once("../php/participanteDAO.php");
require_once("../php/atasreuniao.php");
require_once("../php/atasreuniaoDAO.php");
require_once("../php/membroscondominio.php");
require_once("../php/membroscondominioDAO.php");
require_once("../php/ftp.php");

@session_start();

$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}
//recolhendo variáveis
$conexao = new Conexao();	
$conexao->conecta();
$id_condominio =  $_SESSION['id_condominio'];


if(!permissoesDAO::temPermissao(7,2,$usuario->id_tipo_usuario)){ //verifica se o su possue permissão para inserir(2) no modulo(7)
		header("Location: ../index.php");
		exit();
	}


//Verifica no arquivo o nome da extensão, para ser adicionado ao numero da ata passada por post, de forma que todos os tipos de arquivo possam ser enviados.
if($_FILES['arquivo']['name'] != ""){ 
  $arquivo = $_FILES['arquivo'];
   for ( $i = 0 ; $i <= strlen($arquivo_name) ; $i++) {
	 if ($aux == 1) { $name = $name.$arquivo_name[$i]; }   
      if ($arquivo_name[$i] == ".") { $aux = 1; }	
	}
$arquivo_name = "$ata.$name";
 } 

$atasreuniao = atasreuniaoDAO::findByPk($ata);

//separa o arquivo do nome original, cria uma nova classe de ftp e chama o metodo salvaAta, que por sua vez passa o id do condominio(diretório), o arquivo e o nome do mesmo e salva no ftp.
if($_FILES['arquivo']['name'] != ""){
	$arquivo = $_FILES['arquivo'];
	$ftp = new Ftp();
	$ftp->salvaAta($id_condominio, $arquivo, $arquivo_name);
	$atasreuniao->nome_arquivo = $arquivo_name;	
		}
//alteracao do link no banco de dados.		
$id = atasreuniaoDAO::save($atasreuniao, $ata);
header("Location: adicionar.php?id=$ata");
	exit();
	
	
	
?>