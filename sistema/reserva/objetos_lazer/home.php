<?php 
require_once("../../php/conexao.php");
require_once("../../php/condominios.php");
require_once("../../php/condominiosDAO.php");
require_once("../../php/superusuario.php");
require_once("../../php/superusuarioDAO.php");
require_once("../../php/permissoes.php");
require_once("../../php/permissoesDAO.php");
require_once("../../php/arealazer.php");
require_once("../../php/arealazerDAO.php");
require_once("../../php/objetolazer.php");
require_once("../../php/objetolazerDAO.php");
require_once("../../php/funcionamento.php");
require_once("../../php/funcionamentoDAO.php");
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

//verifica se o su possue permissão para visualizar(4) em centro de custo(20)
if(!permissoesDAO::temPermissao(20,4,$usuario->id_tipo_usuario)){
	header("Location: ../../index.php");
	exit();
}

	if(!isset($nxt)||($nxt<0))
	{
		$nxt=0;
	}
	//quantos por pagina
	$total_mural = 10;
	
//recolhendo variáveis
if (isset($_GET['area'])){
	$area = $_GET['area'];
}else{
	$area = $_POST['area'];
}

if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
}else{
	$msg = $_POST['msg'];
}

if ( isset($area) && is_numeric($area) ){
	$condominio = condominiosDAO::findByPk($id_condominio); 
	$areas = arealazerDAO::findByPk($area);
	$total = objetolazerDAO::countByBusca("","",$areas->id,$id_condominio);
    $objetos = objetolazerDAO::findTopByBusca("","",$areas->id,$id_condominio,$nxt,$total_mural,"a.nome");
}

$classe = "tabela1_linha2";
$pontinhos = "../../";

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
<script language="javascript" type="text/javascript" src="../../js/funcoes.js" charset="iso-8859-1">
</script>
<link href="../../inc/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#ffffff">

<table width="714" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td><img src="../../images/spacer.gif" width="169" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="25" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="178" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="78" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="87" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="90" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="48" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="39" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
    <td rowspan="9" valign="top" background="../../images/complemento_menu_bottom.jpg"><?php  include("../../inc/menu.php"); ?></td>
    <td colspan="7" rowspan="9" valign="top" background="../../images/bg_geral_box.jpg" bgcolor="#FFFFFF"><table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><!-- menu superior -->
            <table width="545" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="533" valign="top" background="../../images/topo_espaco.jpg"><img src="../../images/topo_espaco.jpg" width="203" height="40" /></td>
                <td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="home.php?area=<?php=$area?>"><img src="../../images/botao_listar.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="buscar.php?area=<?php=$area?>"><img src="../../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="adicionar.php?area=<?php=$area?>"></a></td>
                <td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="#"></a></td>
                <td width="12" valign="bottom" background="../../images/topo_espaco.jpg"><img src="../../images/canto.jpg" width="12" height="9" border="0" /></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>RESERVAS </h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
            <p align="center" class="fontelinkPreto">
       		<br />
            <br />
            <br />
            CONDOMÍNIO -&gt; <strong><?php=$condominio->nome?></strong><br />
             Área de Lazer -&gt; <strong><a href="../home.php" >
             <?php=stripslashes($areas->nome)?>
             </a></strong><br />
            <br />
			 <div align="center">
			  <font class="warning">
			    <?php  if(isset($msg) )
						echo $msg;?>
			   </font>
			    <br />
			    <br />
            </div>
			<?php 
				if ($objetos){
			?>
            <table width="96%" cellpadding="0" cellspacing="0" class="tabela1">
                <tr>
                  <td width="460" bgcolor="#6598CB"><table width="460" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="407" class="tabela1_titulo1">Top 10 Objetos de Lazer(ordem alfabética) </td>
                        <td width="51"><a href="home.php?area=<?php=$_GET['area']?>"><img src="../../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
                    <tr>
                      <td width="31%" class="tabela1_titulo2">Objeto de Lazer </td>
                      <td width="34%" class="tabela1_titulo2">Situação</td>
                      <td width="35%" class="tabela1_titulo2">&nbsp;</td>
                    </tr>
                    <?php 
							for ($i = 0; $i < sizeof($objetos); $i++){
							if ($objetos[$i]->status == 0) { $classe = "tabela1_linhaWarning"; } else { $classe = "tabela1_linha2"; }	
							$funcionamento = funcionamentoDAO::findByPk($objetos[$i]->funcionamento);	
						?>
                    <tr>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#">
                        <?php=$objetos[$i]->nome?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#">
                        <?php=$funcionamento->nome?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><div align="center"><a href="tabelaReserva/home.php?area=<?php=$area?>&objeto=<?php=$objetos[$i]->id?>"><img src="../../images/tabeladereservas.jpg" alt="tabela de reservas" width="135" height="21" border="0" /></a></div></td>
                    </tr>
                    <?php 
							}
						?>
                  </table>
                 </td>
                </tr>
            </table>
			<br />
			<br />

			<div align="center" class="fontelink"><?php  if(($nxt) > 0) {?>
                    <a href="home.php?area=<?php=$area?>&amp;nxt=<?php=($nxt - $total)?>">
                    <?php  } ?>
                    Anterior</a> |
                    <?php  if(($nxt + $total_mural) < $total) {?>
                    <a href="home.php?area=<?php=$area?>&amp;nxt=<?php=($nxt + $total_mural)?>">
                    <?php  } ?>
                  Pr&oacute;ximo</a></div>
			<?php 
				}else{					
			?>
			 <div align="center"><span class="verdanaAzul">
			 	Não existem objetos de lazer Cadastrados
			</span></div>
			 <?php 	
				}
			?>
			
			   
              <br />
              </p>
          </td>
          <td width="39" background="../../images/ld_box_bg.jpg">&nbsp;</td>
        </tr>
      </table></td>
   <td><img src="../../images/spacer.gif" width="1" height="40" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="71" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="83" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="48" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="73" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="54" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="26" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><img name="fim_box" src="../../images/fim_box.jpg" width="714" height="32" border="0" id="fim_box" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><div align="center">
     <table width="655" border="0" align="right" cellpadding="0" cellspacing="0">
       <tr>
         <td><div align="center"><img src="../../images/rodape.jpg" width="583" height="23" /></div></td>
       </tr>
     </table>
   </div></td>
   <td><img src="../../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
</table>
 </body>
</html>
