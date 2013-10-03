<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/servicosTerceirizados.php");
require_once("../php/servicosTerceirizadosDAO.php");
require_once("../php/tiposservicos.php");
require_once("../php/tiposservicosDAO.php");
require_once("../php/servidor.php");
require_once("../php/servidorDAO.php");
require_once("../php/receitadespesa.php");
require_once("../php/receitadespesaDAO.php");
require_once("../php/centrocustos.php");
require_once("../php/centrocustosDAO.php");
require_once("../php/areacustos.php");
require_once("../php/areacustosDAO.php");
require_once("../php/ftp.php");

@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();
	
//verifica se o su possue permissão para alterar(1) no modulo(24)
if(!permissoesDAO::temPermissao(24,1,$usuario->id_tipo_usuario)){	
	header("Location: ../index.php");
	exit();
}	

if( empty($_GET['id']) && empty($_POST['id']) ){
	header("Location: home.php");
	die();
}
	
$servico = servicosTerceirizadosDAO::findByPk($id);
if(ftp::deletanota($servico->copia_nota, $id_condominio)){
	$servico->copia_nota = "";		
	servicosTerceirizadosDAO::save($servico);	
}
	
header("Location: adicionarNota.php?id={$id}");
die();
?>