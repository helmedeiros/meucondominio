<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/atividades.php");
require_once("../php/atividadesDAO.php");
require_once("../php/niveisprioridade.php");
require_once("../php/niveisprioridadeDAO.php");

@session_start();

$dias = array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb");
$id_condominio = $_SESSION['id_condominio'];
$usuario = $_SESSION['usuario'];
if ( !($usuario->logado) ){
	header("Location: ../logoff.php");
	exit();
}

if (($usuario->id_tipo_usuario != 1)){
	header("Location: ../logoff.php");
	exit();
}

$con = new Conexao();
$con->conecta();

//verifica se o su possue permissão para visualizar(4) em areas de cuso(30)
if(!permissoesDAO::temPermissao(7,4,$usuario->id_tipo_usuario)){
	header("Location: ../index.php");
	exit();
}


	if(!isset($nxt)||($nxt<0))
	{
		$nxt=0;
	}
	//quantos por pagina
	$total_mural = 10;
	
	$total = atividadesDAO::countAll($id_condominio);
	$atividades = atividadesDAO::findTop($id_condominio, $nxt,$total_mural);

	
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
}else{
	$msg = $_POST['msg'];
}

$pontinhos = "../";
$condominio = condominiosDAO::findByPk($id_condominio);
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
<script language="javascript" type="text/javascript" src="../js/hint.js">
</script>
<link href="../inc/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#ffffff">

<table width="714" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td><img src="../images/spacer.gif" width="169" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="25" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="178" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="78" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="87" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="90" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="48" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="39" height="1" border="0" alt="" /></td>
   <td><img src="../images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
    <td rowspan="9" valign="top" background="../images/complemento_menu_bottom.jpg"><?php  include("../inc/menu.php"); ?></td>
    <td colspan="7" rowspan="9" valign="top" background="../images/bg_geral_box.jpg" bgcolor="#FFFFFF"><table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><!-- menu superior -->
            <table width="545" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="533" valign="top" background="../images/topo_espaco.jpg"><img src="../images/topo_espaco.jpg" width="203" height="40" /></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="home.php"><img src="../images/botao_listar.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"><img src="../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar_off.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>ATIVIDADES</h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
              <p align="center">
            <br />
            <br />
             CONDOMÍNIO -&gt; <strong><?php=$condominio->nome?></strong><br /><br />
            <br />
            <br />
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
				if ($atividades){
			?>
            <table width="96%" cellpadding="0" cellspacing="0" class="tabela1">
                <tr>
                  <td width="460" bgcolor="#6598CB"><table width="460" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="407" class="tabela1_titulo1">Top 10  Atividades (ordem alfabética) </td>
                        <td width="51"><a href="home.php"><img src="../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="460">
                    <tr>
                      <td width="98" class="tabela1_titulo2">Responsável</td>
                      <td width="90" class="tabela1_titulo2">Atividade</td>
                      <td width="100" class="tabela1_titulo2">Data de Realização</td>
                      <td width="87" class="tabela1_titulo2">Prioridade</td>
                      <td width="67" class="tabela1_titulo2">Público Alvo </td>
                    </tr>
                    <?php 
							for ($i = 0; $i < sizeof($atividades); $i++){
						?>
                    <tr>
					<td height="46" nowrap="nowrap" class="tabela1_linha2" ><a href="#" onmouseover="doTooltip(event, 0, '<?php=atividadesDAO::findAnunciante($atividades[$i]->id, $atividades[$i]->id_membroscondominio)?>')" onmouseout="hideTip()"><?php=substr(atividadesDAO::findAnunciante($atividades[$i]->id, $atividades[$i]->id_membroscondominio), 0, 15)?><?php  if(strlen(atividadesDAO::findAnunciante( $atividades[$i]->id, $atividades[$i]->id_membroscondominio)) >= 15){?>...<?php  } ?></a></td>
                      <td class="tabela1_linha2" nowrap="nowrap"><a href="#" onmouseover="doTooltip(event, 0, '<?php=$atividades[$i]->titulo?>')" onmouseout="hideTip()"><?php=substr($atividades[$i]->titulo, 0, 15)?><?php  if(strlen($atividades[$i]->titulo) >= 15){ ?>...<?php  } ?>  </a></td>
                      <td class="tabela1_linha2"><a href="#"><?php=$dias[date('w',strtotime($atividades[$i]->data_realizacao))]?>, <?php=$atividades[$i]->data_realizacao[8].$atividades[$i]->data_realizacao[9]?>/<?php=$atividades[$i]->data_realizacao[5].$atividades[$i]->data_realizacao[6]?>
</a></td>
                      <td class="tabela1_linha2"><?php  $np = niveisprioridadeDAO::findByPk($atividades[$i]->id_prioridade); ?> <?php=$np->nome;?></td>
                      <td class="tabela1_linha2"><div align="center"><a href="#"></a> <a href="pubalvo/home.php?atv=<?php=$atividades[$i]->id?>"><img src="../images/lupa.jpg" width="20" height="21" border="0" /></a><a href="adicionar.php?id=<?php=$atividades[$i]->id?>"></a></div></td>
                    </tr>
                    <?php 
							}
						?>
                  </table></td>
                </tr>
            </table>
			<br />
			<br />

			<div align="center" class="fontelink"><?php  if(($nxt) > 0) {?>
                    <a href="home.php?nxt=<?php=($nxt - $total)?>">
                    <?php  } ?>
                    Anterior</a> |
                    <?php  if(($nxt + $total_mural) < $total) {?>
                    <a href="home.php?nxt=<?php=($nxt + $total_mural)?>">
                    <?php  } ?>
                  Pr&oacute;ximo</a></div>
			<?php 
				}else{					
			?>
			 <div align="center"><span class="verdanaAzul">
			 	Não existem Atividades cadastradas
			</span></div>
			 <?php 	
				}
			?>
			
			   
              <br />
              </p>
          </td>
          <td width="39" background="../images/ld_box_bg.jpg">&nbsp;</td>
        </tr>
      </table></td>
   <td><img src="../images/spacer.gif" width="1" height="40" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../images/spacer.gif" width="1" height="71" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../images/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../images/spacer.gif" width="1" height="83" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../images/spacer.gif" width="1" height="48" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../images/spacer.gif" width="1" height="73" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../images/spacer.gif" width="1" height="54" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../images/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../images/spacer.gif" width="1" height="26" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><img name="fim_box" src="../images/fim_box.jpg" width="714" height="32" border="0" id="fim_box" alt="" /></td>
   <td><img src="../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><div align="center">
     <table width="655" border="0" align="right" cellpadding="0" cellspacing="0">
       <tr>
         <td><div align="center"><img src="../images/rodape.jpg" width="583" height="23" /></div></td>
       </tr>
     </table>
   </div></td>
   <td><img src="../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
</table>
 <div id="tipDiv" style="position:absolute; visibility:hidden; z-index:100"></div>
 </body>
</html>
