<?php 
require_once("sistema/php/conexao.php");
require_once("sistema/php/usuario.php");
require_once("sistema/php/usuarioDAO.php");
require_once("sistema/php/modulo.php");
require_once("sistema/php/moduloDAO.php");
require_once("sistema/php/permissao.php");
require_once("sistema/php/permissaoDAO.php");

@session_start();


if ( isset($_POST["login"]) ){		
	$conexao = new Conexao();
	$conexao->conecta();
	$usuario = new Usuario();	
	$login = htmlentities($_POST["login"]);
	$senha = md5(htmlentities($_POST["senha"]));	
	if ($usuario = UsuarioDAO::findByLogin($login) ){
		if ( $senha == $usuario->senha ) {
			$usuario->logado = true;
			$_SESSION['usuario'] = $usuario;
			header("Location: {$_POST['onde']}.php");
			exit();
		}
		$mensagem = "Senha inválida!!";
	}else{
		$mensagem = "Login inválido!!";
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="includes/principal.css" type="text/css" rel="stylesheet" />
<title>Sistema Administrativo Residencial Aldebaran</title>
<link href="sistema/estilos/estilo.css" rel="stylesheet" type="text/css">
</head>

<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
  <tr align="center" valign="middle">    
    <td align="center" valign="middle">
	<table align="center">
		<tr align="center" valign="middle">
		<td align="center" valign="middle">
	<table width="204" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr bgcolor="#FCFCFC">
        <td width="5" height="5"><img src="sistema/imagens/login/01.gif" width="5" height="5"></td>
        <td width="5" height="5" background="sistema/imagens/login/02.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td width="5" height="5" background="sistema/imagens/login/02.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td height="5" background="sistema/imagens/login/02.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td width="5" height="5" background="sistema/imagens/login/02.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td width="5" height="5" background="sistema/imagens/login/02.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td width="5" height="5"><img src="sistema/imagens/login/03.gif" width="5" height="5"></td>
      </tr>
      <tr bgcolor="#FCFCFC">
        <td background="sistema/imagens/login/04.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td width="5">&nbsp;</td>
        <td width="5">&nbsp;</td>
        <td align="center"><img src="sistema/imagens/login/logo_login.gif" width="180" height="100"></td>
        <td width="5">&nbsp;</td>
        <td width="5">&nbsp;</td>
        <td background="sistema/imagens/login/05.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
      </tr>
      <tr bgcolor="#FCFCFC">
        <td background="sistema/imagens/login/04.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td width="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td width="5" bgcolor="#F0F0F0"><img src="sistema/imagens/login/09.gif" width="5" height="5"></td>
        <td bgcolor="#F0F0F0"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td width="5" bgcolor="#F0F0F0"><img src="sistema/imagens/login/09.gif" width="5" height="5"></td>
        <td width="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        <td background="sistema/imagens/login/05.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
      </tr>
      <form action="login.php" method="post" name="frmlogin">
        <?php 
		if (isset($mensagem) and $mensagem != '') {
?>
        <tr bgcolor="#FCFCFC">
          <td background="sistema/imagens/login/04.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5" bgcolor="#F0F0F0"><img src="sistema/imagens/login/09.gif" width="5" height="5"></td>
          <td bgcolor="#F0F0F0" align="center" class="verdanaVermelha"><span class="msgErro">
            <?php=$mensagem;?>
          </span></td>
          <td width="5" bgcolor="#F0F0F0"><img src="sistema/imagens/login/09.gif" width="5" height="5"></td>
          <td width="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td background="sistema/imagens/login/05.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        </tr>
        <?php 
		}
	?>
        <tr bgcolor="#FCFCFC">
          <td background="sistema/imagens/login/04.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5">&nbsp;</td>
          <td width="5" bgcolor="#F0F0F0">&nbsp;</td>
          <td bgcolor="#F0F0F0"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td width="50" align="right" class="verdanaAzul">Usu&aacute;rio:</td>
                <td class="verdanaAzul"><input name="login" id="login" type="text" class="verdanaAzul" size="20" value="<?php  if(isset($_POST["login"])) echo(stripslashes($_POST["login"]));?>"></td>
              </tr>
              <tr>
                <td width="50" align="right" class="verdanaAzul">Senha:</td>
                <td class="verdanaAzul"><input name="senha" type="password" class="verdanaAzul" size="20"></td>
              </tr>
          </table></td>
          <td width="5" bgcolor="#F0F0F0">&nbsp;</td>
          <td width="5">&nbsp;</td>
          <td background="sistema/imagens/login/05.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr bgcolor="#FCFCFC">
          <td background="sistema/imagens/login/04.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5" bgcolor="#F0F0F0"><img src="sistema/imagens/login/10.gif" width="5" height="5"></td>
          <td bgcolor="#F0F0F0"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5" bgcolor="#F0F0F0"><img src="sistema/imagens/login/12.gif" width="5" height="5"></td>
          <td width="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td background="sistema/imagens/login/05.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr bgcolor="#FCFCFC">
          <td height="5" background="sistema/imagens/login/04.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td height="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td height="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td height="5" align="left"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td height="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td height="5"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td height="5" background="sistema/imagens/login/05.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr bgcolor="#FCFCFC">
          <td background="sistema/imagens/login/04.gif" bgcolor="#FCFCFC"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td bgcolor="#FCFCFC"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td bgcolor="#FCFCFC"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td align="right"><div align="center">
              <input name="onde" type="hidden" value="<?php=$_GET['onde']?>">
              <input name="image" type="image" src="sistema/imagens/botoes/acessar.gif"  border="0">
          </div>
              <div align="center"></div></td>
          <td bgcolor="#FCFCFC"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td bgcolor="#FCFCFC"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td background="sistema/imagens/login/05.gif" bgcolor="#FCFCFC"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr bgcolor="#FCFCFC">
          <td><img src="sistema/imagens/login/06.gif" width="5" height="5"></td>
          <td width="5" background="sistema/imagens/login/07.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5" background="sistema/imagens/login/07.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td background="sistema/imagens/login/07.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5" background="sistema/imagens/login/07.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td width="5" background="sistema/imagens/login/07.gif"><img src="sistema/imagens/spacer.gif" width="1" height="1"></td>
          <td><img src="sistema/imagens/login/08.gif" width="5" height="5"></td>
        </tr>
      </form>
    </table>
		</td>
		</tr>
		</table>
	</td>
  </tr>
</table>
</td>
    <td width="1%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
