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
<title>:: Residencial Aldebaran -  Reservas de Sal&atilde;o de Festas::</title>
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
                   <form action="reserva2.php" method="post">
				    <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td colspan="3"><p class="style3">Voc&ecirc; solicitou a  reserva do Sal&atilde;o de Festas para o dia 
                          <?php=$_POST['dia']."/".$_POST['mes']."/".$_POST['ano']?>,
                           nos hor&aacute;rios
                          : 
                        </p>
                          <?php  $marcar = $_POST['marcar'];
						   $j = 0;
						   for($i = 0; $i <= 17; $i++){ ?>
                          <blockquote>
                            <p class="style3">
							<?php  if(isset($marcar[$i])){
								if($marcar[$i] < 10)
									echo ("0");
								echo($marcar[$i].':00');
							?>
								<input type="hidden" name="horas[<?php=$j?>]" id="horas" value="<?php=$marcar[$i]?>">
							<?php 
								$j += 1;
							}
							?></p>
                        </blockquote>
						  <p>
						    <?php  }?>
					      </p>
						  <p class="style3">Voc&ecirc; confirma a reserva ?</p>
						  <p class="style3"><input type="hidden" name="id_objeto" id="id_objeto" value="2">
						<input type="hidden" name="id_membro" id="id_membro" value="<?php=$usuario->id?>">
						<input type="hidden" name="dia" id="dia" value="<?php=$_POST['dia']?>">
						<input type="hidden" name="mes" id="mes" value="<?php=$_POST['mes']?>">
						<input type="hidden" name="ano" id="ano" value="<?php=$_POST['ano']?>">
						</p></td>
                      </tr>
                      <tr>
                        <td width="45%"><div align="center">
                          <input type="submit" value="Sim" name="submit">
                        </div></td>
                        <td width="11%">&nbsp;</td>
                        <td width="44%"><div align="center">
                          <input type="submit" value="Não" name="submit">
                        </div></td>
                      </tr>
                    </table>
				  </form>
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
