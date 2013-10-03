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

if(isset($_GET['data'])){
	$_POST['mes'] = $_GET['data'][5].$_GET['data'][6];
	$_POST['dia'] = $_GET['data'][8].$_GET['data'][9];
	$_POST['ano'] = $_GET['data'][0].$_GET['data'][1].$_GET['data'][2].$_GET['data'][3];
}else{
	$_POST['mes'] = date("m",time());
	$_POST['dia'] = date("d",time());
	$_POST['ano'] = date("Y",time());
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
                   <form action="salao.php" method="post">
				    <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="13%"><span class="style3">Selecione:</span></td>
                        <td width="21%">
						<select name="dia">
                            <option>Escolha o dia</option>
							<?php   for($i = 1; $i <= 31; $i++){ 
									if($i < 10) {
										$a = '0'.$i;
									}else{ $a = $i; }
							?>                          
	                            <option value="<?php=$a?>"><?php=$a?></option>
							<?php  }  ?>
                          </select>                        </td>
                        <td width="23%"><select name="mes">
                            <option>Escolha o mês</option>
							<?php   for($i = 1; $i <= 12; $i++){ 
									if($i < 10) {
										$a = '0'.$i;
									}else{ $a = $i; }
							?>                          
	                            <option value="<?php=$a?>"><?php=$a?></option>
							<?php  }  ?>
                          </select></td>
                        <td width="21%"><select name="ano">
                            <option>Escolha o ano</option>							
	                            <option value="<?php=date("Y",time())?>"><?php=date("Y",time())?></option>
                          </select></td>
                        <td width="22%"><div align="center"><input type="image" src="img/botao_alterar.gif" width="75" height="25"></div></td>
                      </tr>
                    </table>
					</form>
                  <br>
				  <?php  if(checkdate($_POST['mes'], $_POST['dia'] , $_POST['ano'])){ 
				  		if($_POST['ano'] >= date("Y",time()) and $_POST['mes'] >= date("m",time()) and $_POST['dia'] >= date("d",time())) $libera = 1;
				  ?>
				   <table width="94%" border="0" align="center" cellpadding="0">
				   	<tr>
						<td class="style4">
				   		<?php=$_POST['dia']."/".$_POST['mes']."/".$_POST['ano']?>
						</td>
					 </tr>
					</table>
                   <form action="confirma2.php" method="post"> 
				    <table width="94%" border="1" align="center" cellpadding="0" cellspacing="10" bordercolor="#FFFFFF" bgcolor="8cb4ce">
                      <tr>
                        <td width="13%" class="style3">Hor&aacute;rio</td>
                        <td width="36%" class="style3"><div align="center">STATUS</div></td>
                        <td width="37%" class="style3"><div align="center">COND&Ocirc;MINO/APT&ordm;</div></td>
                        <td width="14%" class="style3"><div align="center"></div></td>
                      </tr>
					  <?php  $j = 0;
					  for($i = 6; $i <= 22; $i++){		
					  $membro = new Usuario();
					  $data = $_POST['ano']."-".$_POST['mes']."-".$_POST['dia'];
					  if($i < 10){
					  	 $hora = '0'.$i.':00';
					  }else{
					  	 $hora = $i.':00';
					  }
					 $reserva = ReservaDAO::findByDataHora($data, $hora, 2);
					  ?>
                      <tr>
                        <td class="style3"><?php  if($i < 10) 
									echo ("0");
								echo($i);
							?>:00</td>
                        <td><div align="center">
                          <input name="<?php='marcar['.$j.']'?>" <?php  if($reserva){?> checked="checked"  <?php  }?>type="checkbox" <?php  if(!$libera or $reserva){ ?> disabled="disabled" <?php  }?> class="style3" value="<?php=$i?>">
                        </div></td>
                        <td><div align="center" class="style3">
						<?php  if($reserva){						
							$membro = UsuarioDAO::findByPk($reserva->id_membro);
						?>	<?php=$membro->nome?> / <?php=$membro->numeroapt?>
						<?php  }else{?>
							-
						<?php  }?>
						</div></td>
                        <td><div align="center">
						
						<?php  if($membro->nome == $usuario->nome){?>
							<a href="desmarcar2.php?id=<?php=$reserva->id?>">
								<img src="img/botao_desmarcar.gif" width="75" height="20" border="0" >
							</a>
						<?php  }?>
						</div></td>
                      </tr>
					  <?php 
					  	$j += 1;
					  }
					  ?>
                  </table>
				  
                    <br>
                    <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><div align="center">
						<input type="hidden" name="id_objeto" id="id_objeto" value="2">
						<input type="hidden" name="id_membro" id="id_membro" value="<?php=$usuario->id?>">
						<input type="hidden" name="dia" id="dia" value="<?php=$_POST['dia']?>">
						<input type="hidden" name="mes" id="mes" value="<?php=$_POST['mes']?>">
						<input type="hidden" name="ano" id="ano" value="<?php=$_POST['ano']?>">
						<?php  	if($libera){?>
						<input type="image" src="img/botao_reservas.gif" width="75" height="25">
						<?php  }?>
						</div></td>
						
                      </tr>
                    </table>
				  </form>
					<?php  }?>
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
