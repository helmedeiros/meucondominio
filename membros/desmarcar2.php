<?php 
require_once("sistema/php/conexao.php");
require_once("sistema/php/usuario.php");
require_once("sistema/php/usuarioDAO.php");
require_once("sistema/php/permissao.php");
require_once("sistema/php/permissaoDAO.php");
require_once("sistema/php/reserva.php");
require_once("sistema/php/reservaDAO.php");
require_once("sistema/php/tipoobjeto.php");
require_once("sistema/php/tipoobjetoDAO.php");


@session_start();

$usuario = $_SESSION['usuario'];
if ( !($usuario->logado) ){
	header("Location: login.php?onde=salao");
	exit();
}

$con = new Conexao();
$con->conecta();

if(!PermissaoDAO::temPermissao($usuario->id_tipo, 6)){
	header("Location: login.php?onde=salao");
	exit();
}
$reserva = ReservaDAO::findByPk($_GET['id']);
$membro = UsuarioDAO::findByPk($reserva->id_membro);

if($membro->nome != $usuario->nome){
	header("Location: login.php?onde=salao");
	exit();
}

if($reserva->data_inicio < date("Y-m-d",time())){
	header("Location: salao.php?data={$reserva->data_inicio}");
	exit();
}

if ( isset($_GET['id']) && is_numeric($_GET['id']) ){
	ReservaDAO::delete($_GET['id']);
	}
	header("Location: salao.php?data={$reserva->data_inicio}");
	exit();

?>