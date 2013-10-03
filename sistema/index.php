<?php 
require_once("php/conexao.php");
require_once("php/superusuario.php");
require_once("php/superusuarioDAO.php");
require_once("php/condominios.php");
require_once("php/condominiosDAO.php");

@session_start();


if ( isset($_POST["login"]) ){		
	$conexao = new Conexao();
	$conexao->conecta();
	$su = new SuperUsuario();	
	$login = htmlentities($_POST["login"]);
	$senha = md5(htmlentities($_POST["senha"]));	
	if ($su = SuperUsuarioDAO::findByLogin($login) ){
		if ( $senha == $su->senha ) {
			if (($su->id_tipo_usuario == 1)){				
				$su->logado = true;
				$_SESSION['usuario'] = $su;
				$su->numero_acessos += 1;
				SuperUsuarioDAO::save($su);
				$condominio = condominiosDAO::findTopByBusca("", "", "", $su->id, 0, 1,"id_condominios","DESC");
				$_SESSION['id_condominio'] = $condominio[0]->id;
				header("Location: home.php");
				exit();
			}
			$mensagem = "Você não tem tal permissão!!";	
		}else{
			$mensagem = "Senha inválida!!";
		}
	}else{
		$mensagem = "Login inválido!!";
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../includes/principal.css" type="text/css" rel="stylesheet" />
<title>| Sistema |</title>
<link href="inc/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:276px;
	height:276px;
	z-index:1;
	left: 524px;
}
-->
</style>
</head>

<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
  <tr align="center" valign="middle">    
    <td align="center" valign="middle">
	<table align="center">
		<tr align="center" valign="middle">
		<td align="center" valign="middle">
	<table width="204" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="3"><img src="images/temp/nomes.png" width="354" height="8"></td>
		</tr>
	  <tr>
        <td><img src="images/temp/spacer.gif" width="1" height="6"></td>
		</tr>
	  <tr bgcolor="#FCFCFC">
        <td height="15" background="images/temp/login_03.jpg"></td>
		</tr>
		 <tr bgcolor="#FCFCFC">
        <td height="44" background="images/temp/login_05.jpg"></td>
		</tr>
		 <form action="index.php" method="post" name="frmlogin">
		<tr bgcolor="#FCFCFC">
        <td height="44" background="images/temp/login_06.jpg"><div class="login"><img src="images/login/logo_login.gif" width="180" height="100"></div></td>
		</tr>
		<tr bgcolor="#FCFCFC">
        <td height="16" width="135" background="images/temp/login_08.jpg"><div align="center"><img src="images/temp/spacer.gif" width="1" height="16"></div></td>
		</tr>
		<tr bgcolor="#FCFCFC">
        <td height="16" width="135" background="images/temp/login_03 copy.gif"><div class="login">
          <table width="180" border="0" cellpadding="0" cellspacing="0" >
            <tr>
              <td width="65" align="right" bgcolor="#DEE2E2" class="verdanaAzul" height="32"><div align="center"><img src="images/temp/login.gif" width="47" height="19"></div></td>
              <td width="120" bgcolor="#DEE2E2" class="verdanaAzul">
                <div align="left">
                  <input name="login" type="text" class="FORMULARIO" id="login" value="<?php  if(isset($_POST["login"])) echo(stripslashes($_POST["login"]));?>"  size="16" tabindex="1">
                  </div></td>
            </tr>
            <tr height="25">
              <td width="65" align="right" bgcolor="#DEE2E2" class="verdanaAzul" height="32"><div align="center"><img src="images/temp/senha.gif" width="47" height="19"></div></td>
              <td bgcolor="#DEE2E2" class="verdanaAzul">
                <div align="left">
                  <input name="senha" type="password" class="FORMULARIO" size="16" tabindex="2">
                  </div></td>
            </tr>			
			<tr>
              <td colspan="2" align="right" height="50" valign="middle" ><div align="center"><input type="image" src="images/temp/logar.jpg" width="62" height="26" tabindex="3"></div></td>
              </tr>
          </table>         
        </div></td>
		</tr>
		<tr bgcolor="#FCFCFC">
        <td height="16" width="135" background="images/temp/login_03a.gif"></td>
		</tr>
		</form>
	</table>
		</td>
		</tr>
	  </table>
	<font class="warning">
	<?php=$mensagem;?>
	</font></td>
  </tr>
</table>
</td>
    <td width="1%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
