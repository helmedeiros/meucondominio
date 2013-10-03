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
	header("Location: login.php");
	exit();
}

$con = new Conexao();
$con->conecta();

if(!PermissaoDAO::temPermissao($usuario->id_tipo, 6)){
	header("Location: login.php");
	exit();
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Residencial Aldebaran -  Reservas de Sal&atilde;o de Festas ::</title>
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
        <td><span class="style2">RESERVAS DE SAL&Atilde;O DE FESTAS </span></td>
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
                        <td width="100%"><p class="style3">O sal&atilde;o  foi reservado com sucesso  no dia 
                          <?php=$_POST['dia']."/".$_POST['mes']."/".$_POST['ano']?> nos hor&aacute;rios : 
                        </p>
                          <?php  $horas = $_POST['horas'];
						   for($i = 0; $i < sizeof($horas); $i++){ ?>
                          <blockquote>
                            <p class="style3">
							<?php  if(isset($horas[$i])){
								if($horas[$i] < 10)
									echo ("0");
									
								echo($horas[$i].':00');																
								
								$reserva = new Reserva();
								$reserva->id_membro = addslashes($_POST['id_membro']);
								$reserva->id_objeto = addslashes($_POST['id_objeto']);
								$reserva->data_inicio = htmlentities($_POST['ano'])."-".htmlentities($_POST['mes'])."-".htmlentities($_POST['dia']." ".htmlentities($horas[$i]).":00:00");
								$reserva->data_fim = htmlentities($_POST['ano'])."-".htmlentities($_POST['mes'])."-".htmlentities($_POST['dia']." ".$horas[$i].":00:00");								
								$id = ReservaDAO::save($reserva);	
														
							}?></p>
                        </blockquote>
						  <p>
						    <?php  }?>
						    <br>
						  </p>
						  <p align="center" class="style3"><a href="salao.php?data=<?php=$reserva->data_inicio?>" class="style3">Voltar</a></p></td>
                      </tr>
                    </table>
                  <br>
                <br></td>
              </tr>
          </table><br></td>
        </tr>
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