<?php 
require_once("sistema/php/conexao.php");
require_once("sistema/php/usuario.php");
require_once("sistema/php/usuarioDAO.php");
require_once("sistema/php/permissao.php");
require_once("sistema/php/permissaoDAO.php");
require_once("sistema/php/atareuniao.php");
require_once("sistema/php/atareuniaoDAO.php");
require_once("sistema/php/receitadespesa.php");
require_once("sistema/php/receitadespesaDAO.php");
require_once("sistema/php/centrocusto.php");
require_once("sistema/php/centrocustoDAO.php");
require_once("sistema/php/areacusto.php");
require_once("sistema/php/areacustoDAO.php");


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

if ( isset($_POST['mes']) && is_numeric($_POST['mes']) ){	
	$despesas = ReceitaDespesaDAO::areaCentroByTipoAreaMes('despesa', $_POST['mes']);
	$receitas = ReceitaDespesaDAO::areaCentroByTipoAreaMes('receita', $_POST['mes']);	
	$mes = $_POST['mes'];
}else{	
	$despesas = ReceitaDespesaDAO::areaCentroByTipoAreaMes('despesa', date("m",time()));
	$receitas = ReceitaDespesaDAO::areaCentroByTipoAreaMes('receita', date("m",time()));	
	$mes = date("m",time());
	}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Residencial Aldebaran -  Presta&ccedil;&atilde;o de Contas ::</title>
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

.style5 {
	font-family: Verdana, Arial, Helvetica, sans-serif, Tahoma;
	font-size: 12px;
	color: #FF0000;
}
-->
</style>
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td align="center"><table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><span class="style2">PRESTA&Ccedil;&Atilde;O DE CONTAS </span></td>
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
                        <td width="13%"><span class="style3">Bem vindo <?php=$usuario->nome?>
                        , o corrente Demonstrativos de Receita e Despesa refere-se ao do m&ecirc;s 
                            <?php=$mes?>
                        , para visualizar os referentes a outros utilize a busca na parte inferior da p&aacute;gina. </span></td>
                      </tr>
                  </table>				
                  <br>
				  <?php 
					if ($receitas){
				  ?>
                  <table width="94%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="8cb4ce">
                    <?php 
							$areaAtual = "";
							for ($i = 0; $i < sizeof($receitas); $i++){
								if($receitas[$i]->area->nome != $areaAtual){
									$areaAtual = $receitas[$i]->area->nome;									
						?>
					<?php 
					if($i == 0){
					?>
                    <tr>
                      <th width="74%" class="style3" scope="col">RECEITAS</th>
                      <th width="26%" class="style3" scope="col">VALORES EM R$ </th>
                    </tr>
					<?php 
					}
					?>
                    <tr>
                      <th colspan="2" class="style3" scope="col"><div align="left"><strong>
                        <?php=$receitas[$i]->area->nome?>
                      </strong></div></th>
                    </tr>                  
                    <?php 
					   			}
					   ?>
                    <tr>
                      <td align="center" class="style3" scope="col"><div align="left">
                        <?php=$receitas[$i]->centro->nome?>
                      </div>                      </td>
                      <td align="center" class="style3" scope="col"><?php=number_format(ReceitaDespesaDAO::somaValoresByCentro('receita', $mes, $areaAtual, $receitas[$i]->centro->nome), 2, ',', '.')?></td>
                    </tr>
                    <?php  if($receitas[($i+1)]->area->nome != $areaAtual){ ?>
                    <tr>
                      <td><div align="right" class="style3">
                          <p><strong>TOTAL------------&gt;</strong></p>
                      </div></td>
                      <td class="style3"><div align="center">
                          <?php=number_format(ReceitaDespesaDAO::somaValoresByArea('receita', $mes, $areaAtual), 2, ',', '.')?>
                      </div></td>
                    </tr>
                    <?php  }?>
                    <?php 
					  }
					  ?>
                  </table>
				  <?php 
				  }else{
				  ?>
				 	<table width="94%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="8cb4ce">
						<tr>
							<td>
							  <div align="center" class="style3">Não existem Receitas cadastradas para este mês </div></td>
						</tr>
					</table> 
				  <?php 
				  }
				  ?>
				  <br>
				  <?php 
				  if ($despesas){
				  ?>
				<table width="94%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="8cb4ce">
                    <?php 
							$areaAtual = "";
							for ($i = 0; $i < sizeof($despesas); $i++){
								if($despesas[$i]->area->nome != $areaAtual){
									$areaAtual = $despesas[$i]->area->nome;									
						?>
					<?php 
					if($i == 0){
					?>
                    <tr>
                      <th width="74%" class="style3" scope="col">DESPESAS</th>
                      <th width="26%" class="style3" scope="col">VALORES EM R$ </th>
                    </tr>
					<?php 
					}
					?>						
                    <tr>
                      <th colspan="2" class="style3" scope="col"><div align="left"><strong>
                        <?php=$despesas[$i]->area->nome?>
                      </strong></div></th>
                    </tr>                  
                    <?php 
					   			}
					   ?>
                    <tr>
                      <td align="center" class="style3" scope="col"><div align="left">
                        <?php=$despesas[$i]->centro->nome?>
                      </div>                      </td>
                      <td align="center" class="style3" scope="col"><?php=number_format(ReceitaDespesaDAO::somaValoresByCentro('despesa', $mes, $areaAtual, $despesas[$i]->centro->nome), 2, ',', '.')?></td>
                    </tr>
                    <?php  if($despesas[($i+1)]->area->nome != $areaAtual){ ?>
                    <tr>
                      <td><div align="right" class="style3">
                          <p><strong>TOTAL------------&gt;</strong></p>
                      </div></td>
                      <td class="style3"><div align="center">
                          <?php=number_format(ReceitaDespesaDAO::somaValoresByArea('despesa', $mes, $areaAtual), 2, ',', '.')?>
                      </div></td>
                    </tr>
                    <?php  }?>
                    <?php 
					  }
					  ?>
                  </table>
				  <?php 
				  }else{
				  ?>
				  <table width="94%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="8cb4ce">
                    <tr>
                      <td><div align="center" class="style3">N&atilde;o existem Despesas cadastradas para este m&ecirc;s </div></td>
                    </tr>
                  </table>
				  <?php  }?>
				  <br>
				   <form action="contas.php" method="post">
				  <table width="300" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="8cb4ce">               
				    <tr>
                       <td class="style3" valign="middle">
                          <p align="center">Buscar outros meses: <input name="mes" type="text" class="FormInputS" value="01">
						  </p>
                          <p align="center">
                            <input type="image" src="img/botao_buscar.gif">
                          </p>
					    </td>
                    </tr>                   
                  </table>
				  <br>
				   </form>
			    </td>
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
