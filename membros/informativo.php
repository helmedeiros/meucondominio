<?php 
require_once("sistema/php/conexao.php");
require_once("sistema/php/email.php");
require_once("sistema/php/emailDAO.php");

$con = new Conexao();
$con->conecta();

if(isset($_POST['nome']) and isset($_POST['email'])){
		$email = new Email();
		$email->nome = addslashes($_POST['nome']);
		$email->email = addslashes($_POST['email']);
		if (!EmailDAO::findByEmail($email->email)){
			$id = EmailDAO::save($email);
			$foi ='ok';		
		}		
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Residencial Aldebaran -  Reservas de Quadras::</title>
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
        <td><span class="style2">INFORMATIVO</span></td>
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
                        <td width="100%"><p class="style3">
						<?php  if(isset($foi) and $foi == 'ok'){?>
							Parabens <?php=$_POST['nome']?> o seu e-mail (<?php=$_POST['email']?>) foi cadastrado com sucesso. 
						<?php  }else{?>
							<?php=$_POST['nome']?> o seu e-mail (<?php=$_POST['email']?>) já foi cadastrado anteriormente. 
						<?php  }?>
                        
						  </p>
                          <p align="center" class="style3"><a href="javascript: self.close ()" class="style3">FECHAR</a></p></td>
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