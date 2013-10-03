<?php 
require_once("sistema/php/conexao.php");
require_once("sistema/php/usuario.php");
require_once("sistema/php/usuarioDAO.php");
require_once("sistema/php/permissao.php");
require_once("sistema/php/permissaoDAO.php");
require_once("sistema/php/visitante.php");
require_once("sistema/php/visitanteDAO.php");

@session_start();

$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../index.php");
	exit();
}

if (($usuario->id_tipo != 2) and ($usuario->id_tipo != 3) and ($usuario->id_tipo != 4)){
	header("Location: index.php");
	exit();
}

$conexao = new Conexao();
$conexao->conecta();

if(!PermissaoDAO::temPermissao($usuario->id_tipo, 8)){
	header("Location: ../index.php");
	exit();
}

$visitante = new VisitanteDAO();

if ( isset($_POST['nome']) ){
	$visitante->id = addslashes($_POST['id']);
	if ($visitante->id != 0){
		$visitante = VisitanteDAO::findByPk($visitante->id);
	}			
	$visitante->id_membro = addslashes($_POST['membro']);
	if($visitante->id_membro == 0){
		$visitante->id_membro = $usuario->id;
	}
	$visitante->nome = addslashes($_POST['nome']);
	$visitante->identidade = addslashes($_POST['identidade']);
	$visitante->cpf = addslashes($_POST['cpf']);
	$visitante->tipo = addslashes($_POST['tipo']);
	$id = VisitanteDAO::save($visitante);
	
}
header("Location: visitante.php");
exit();	
?>