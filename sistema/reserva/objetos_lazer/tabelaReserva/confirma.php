<?php 
require_once("../../../php/conexao.php");
require_once("../../../php/condominios.php");
require_once("../../../php/condominiosDAO.php");
require_once("../../../php/superusuario.php");
require_once("../../../php/superusuarioDAO.php");
require_once("../../../php/permissoes.php");
require_once("../../../php/permissoesDAO.php");
require_once("../../../php/arealazer.php");
require_once("../../../php/arealazerDAO.php");
require_once("../../../php/objetolazer.php");
require_once("../../../php/objetolazerDAO.php");
require_once("../../../php/funcionamento.php");
require_once("../../../php/funcionamentoDAO.php");
require_once("../../../php/reserva.php");
require_once("../../../php/reservaDAO.php");
require_once("../../../php/membroscondominio.php");
require_once("../../../php/membroscondominioDAO.php");
@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
if ( !($usuario->logado) ){
	header("Location: ../../logoff.php");
	exit();
}

if (($usuario->id_tipo_usuario != 1)){
	header("Location: ../../logoff.php");
	exit();
}

$con = new Conexao();
$con->conecta();

//verifica se o su possue permissão para visualizar(4) em centro de custo(14)
if(!permissoesDAO::temPermissao(14,4,$usuario->id_tipo_usuario)){
	header("Location: ../../index.php");
	exit();
}
	
//recolhendo variáveis
if (isset($_GET['area'])){
	$area = $_GET['area'];
}else{
	$area = $_POST['area'];
}

//recolhendo variáveis
if (isset($_GET['objeto'])){
	$objeto = $_GET['objeto'];
}else{
	$objeto = $_POST['objeto'];
}

if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
}else{
	$msg = $_POST['msg'];
}

if(isset($_GET['data'])){
	$_POST['mes'] = $_GET['data'][5].$_GET['data'][6];
	$_POST['dia'] = $_GET['data'][8].$_GET['data'][9];
	$_POST['ano'] = $_GET['data'][0].$_GET['data'][1].$_GET['data'][2].$_GET['data'][3];
}

if(!isset($_POST['mes'])){
	$_POST['mes'] = date("m",time());
	$_POST['dia'] = date("d",time());
	$_POST['ano'] = date("Y",time());
}


if ( isset($area) && is_numeric($area) && isset($objeto) && is_numeric($objeto)){
	$condominio = condominiosDAO::findByPk($id_condominio); 
	
	$areas = arealazerDAO::findByPk($area);
	$objetos = objetolazerDAO::findByPk($objeto);	
}

$classe = "tabela1_linha2";
$pontinhos = "../../../";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>| Sistema |</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script language="javascript" type="text/javascript" src="../../../js/funcoes.js">
</script>
<link href="../../../inc/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style3 {	font-family: Verdana, Arial, Helvetica, sans-serif, Tahoma;
	font-size: 12px;
	color: #FFFFFF;
}
-->
</style>
</head>

<body bgcolor="#ffffff">

<table width="714" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td><img src="../../../images/spacer.gif" width="169" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="25" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="178" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="78" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="87" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="90" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="48" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="39" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
    <td rowspan="9" valign="top" background="../../../images/complemento_menu_bottom.jpg"><?php  include("../../../inc/menu.php"); ?></td>
    <td colspan="7" rowspan="9" valign="top" background="../../../images/bg_geral_box.jpg" bgcolor="#FFFFFF"><table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><!-- menu superior -->
            <table width="545" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="533" valign="top" background="../../../images/topo_espaco.jpg"><img src="../../../images/topo_espaco.jpg" width="203" height="40" /></td>
                <td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="home.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/botao_listar_off.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="buscar.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="adicionar.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/botao_cadastrar.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="excluir.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../../../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>RESERVAS</h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../../../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
            <p align="center" class="fontelinkPreto">
       		<br />
            <br />
            <br />
            CONDOMÍNIO -&gt; <strong><?php=$condominio->nome?></strong><br />
            Área de Lazer -&gt; <strong><a href="../../home.php" ><?php=stripslashes($areas->nome)?></a></strong><br />
            Objeto de Lazer -&gt; <strong><a href="../home.php?area=<?php=$areas->id?>" ><?php=stripslashes($objetos->nome)?></a></strong><br />
		    <div align="center">
			  <font class="warning">
			    <?php  if(isset($msg) )
						echo $msg;?>
		      </font>
			    <br />
			    <br />
            </div>
				
			<form action="reserva.php" method="post">
              <table width="459" cellpadding="0" cellspacing="0" class="tabela1">
                <tr>
                  <td bgcolor="#6598CB" colspan="2"><table  cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="407" class="tabela1_titulo1">Reservas do dia ( <?php=$_POST['dia']."/".$_POST['mes']."/".$_POST['ano']?> )</td>
                        <td width="51"><a href="home.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                  <td colspan="2" class="tabela1_linha2">Foram solicitada(s) a(s) reserva(s) da(o) <?php=stripslashes($objetos->nome)?> para o dia <?php=$_POST['dia']."/".$_POST['mes']."/".$_POST['ano']?> , os hor&aacute;rios para os Usuários :
				  <br />
				  <br />
				  <p>                     
                    <?php 	$marcar = $_POST['marcar'];
					  	$membro = $_POST['membro'];
						$j = 0;
						
						for($i = 0; $i < sizeof($marcar); $i++){ 
							//proibir a entrada de horarios não selecionados no array final
							if($membro[$i] != "" and $marcar[$i][inicio] != "" ){
								$m = membroscondominioDAO::findByPk($membro[$i]);													
								$horarios[$j][inicio] = $marcar[$i][inicio];
								$horarios[$j][fim] = $marcar[$i][fim];
								$horarios[$j][membro] =  $membro[$i]; 							
					?>
					<input name="<?php='horarios['.$j.'][inicio]'?>" type="hidden" value="<?php=$horarios[$j][inicio]?>" />
					<input name="<?php='horarios['.$j.'][fim]'?>" type="hidden" value="<?php=$horarios[$j][fim]?>" />
					<input name="<?php='horarios['.$j.'][membro]'?>" type="hidden" value="<?php=$horarios[$j][membro]?>" />
					<p><?php=$marcar[$i][inicio]?> - <strong><?php=$m->nome?></strong></p>
					<?php 	
								$j += 1;
							}
						}
					?>    
					</p>                     
					<br />
					Voc&ecirc; confirma a reserva ?
					
                    <p class="style3">
                      <span class="tabela1_linha2">					
                    <input type="hidden" name="area" value="<?php=$areas->id?>" />
			        <input type="hidden" name="objeto" value="<?php=$objetos->id?>" />
                    <input type="hidden" name="dia" id="dia" value="<?php=$_POST['dia']?>" />
                    <input type="hidden" name="mes" id="mes" value="<?php=$_POST['mes']?>" />
                    <input type="hidden" name="ano" id="ano" value="<?php=$_POST['ano']?>" />
                    </span></p></td>
                </tr>
                <tr>
                  <td width="232" class="tabela1_titulo2"><div align="center">
                      <input type="submit" value="Sim" name="submit" />
                  </div></td>
                  <td width="225" class="tabela1_titulo2"><div align="center">
                      <a href="adicionar.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><input type="submit" value="Não" name="submit" /></a>
                                    </div></td>
                </tr>
              </table>
		    </form>
			<br />
			<br />			   
            <br />
              </p></td>
          <td width="39" background="../../../images/ld_box_bg.jpg">&nbsp;</td>
        </tr>
      </table></td>
   <td><img src="../../../images/spacer.gif" width="1" height="40" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="71" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="83" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="48" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="73" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="54" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="26" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><img name="fim_box" src="../../../images/fim_box.jpg" width="714" height="32" border="0" id="fim_box" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><div align="center">
     <table width="655" border="0" align="right" cellpadding="0" cellspacing="0">
       <tr>
         <td><div align="center"><img src="../../../images/rodape.jpg" width="583" height="23" /></div></td>
       </tr>
     </table>
   </div></td>
   <td><img src="../../../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
</table>
</body>
</html>
