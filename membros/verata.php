<?php 
require_once("sistema/php/conexao.php");
require_once("sistema/php/usuario.php");
require_once("sistema/php/usuarioDAO.php");
require_once("sistema/php/permissao.php");
require_once("sistema/php/permissaoDAO.php");
require_once("sistema/php/atareuniao.php");
require_once("sistema/php/atareuniaoDAO.php");
require_once("sistema/php/participante.php");
require_once("sistema/php/participanteDAO.php");


@session_start();

$usuario = $_SESSION['usuario'];
if ( !($usuario->logado) ){
	header("Location: login.php");
	exit();
}

$con = new Conexao();
$con->conecta();

if(!PermissaoDAO::temPermissao($usuario->id_tipo, 1)){
	header("Location: login.php");
	exit();
}

$ata = AtaReuniaoDAO::findByPk($_GET['id']);

$participantes = ParticipanteDAO::findByAta($_GET['id']);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Residencial Aldebaran -  Atas de Reuni&atilde;o ::</title>
<style type="text/css">
<!--
body {
	background-color: #F4E5C3;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style2 {
	font-size: 27px;
	color: #cec0a0;
	font-family: Tahoma;
	font-weight: bold;
}

.style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif, Tahoma;
	font-size: 12px;
	color: #FFFFFF;
}

.style4 {
	font-size: 27px;
	color: #ffffff;
	font-family: Tahoma;
	font-weight: bold;
}
-->
</style></head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td align="center"><table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><span class="style2">ATAS DE REUNI&Atilde;O </span></td>
      </tr>
    </table>
      <br>
      <table width="700" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#FFFFFF"><br>
		
            <table width="670" height="270" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="top" bgcolor="#6492af"><br>
                   <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="13%" class="style4">DATA - <?php=$ata->data_inicio[8].$ata->data_inicio[9]."/".$ata->data_inicio[5].$ata->data_inicio[6]."/".$ata->data_inicio[0].$ata->data_inicio[1].$ata->data_inicio[2].$ata->data_inicio[3]?>
                        <br>
                        <span class="style3">INICIO - 
                        <?php=$ata->data_inicio[11].$ata->data_inicio[12].":".$ata->data_inicio[14].$ata->data_inicio[15]?>
                        <br>
                        TERMINO - 
                        <?php=$ata->data_fim[11].$ata->data_fim[12].":".$ata->data_fim[14].$ata->data_fim[15]?>
                        </span></td>
                      </tr>
					  <tr>
					    <td class="style4">&nbsp;</td>
				     </tr>
					  <tr>
                        <td width="13%" class="style3"><?php=nl2br($ata->ata)?></td>
                      </tr>
					   <tr>
					    <td class="style4">&nbsp;</td>
				     </tr>
					   <tr>
					     <td class="style3" align="right"><div align="left"><strong>PRESENTES:</strong><br>
					       <br>
						  <?php  for($i = 0; $i < sizeof($participantes); $i++){
						  		$memb = UsuarioDAO::findByPk($participantes[$i]->id_membro);
						  ?> 
					     <?php=strtoupper($memb->nome);?><br>
						 <?php  }?>
					     </div></td>
				     </tr>
				      <tr>
					    <td class="style3" align="right"><a href="ata.php" class="style3">voltar</a></td>
				     </tr>
                  </table>				
                  <br>
                  <br>
					<br></td>
            </tr>
            </table>            <p><br>
              </p>			
          </td></tr>
      </table>
      <br>
    <br>
    <br>
    <br>
    </td>
  </tr>
</table>
</body>
</html>
