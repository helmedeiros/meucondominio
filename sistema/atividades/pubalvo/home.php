<?php 
require_once("../../php/conexao.php");
require_once("../../php/condominios.php");
require_once("../../php/condominiosDAO.php");
require_once("../../php/superusuario.php");
require_once("../../php/superusuarioDAO.php");
require_once("../../php/permissoes.php");
require_once("../../php/permissoesDAO.php");
require_once("../../php/atividades.php");
require_once("../../php/atividadesDAO.php");
require_once("../../php/publico_alvo.php");
require_once("../../php/publico_alvoDAO.php");
require_once("../../php/funcionarios.php");
require_once("../../php/funcionariosDAO.php");
require_once("../../php/membroscondominio.php");
require_once("../../php/membroscondominioDAO.php");
require_once("../../php/tiposfuncionarios.php");
require_once("../../php/tiposfuncionariosDAO.php");

@session_start();

$id_condominio =  $_SESSION['id_condominio'];
$usuario = $_SESSION['usuario'];
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

//verifica se o su possue permissão para visualizar(4) em areas de cuso(30)
if(!permissoesDAO::temPermissao(7,4,$usuario->id_tipo_usuario)){
	header("Location: ../../index.php");
	exit();
}


	if(!isset($nxt)||($nxt<0))
	{
		$nxt=0;
	}
	//quantos por pagina
	$total_mural = 10;
	
if (isset($_GET['atv']) && $_GET['atv'] != "") {
	$total = publico_alvoDAO::countAllByAtv($atv);
	$pau = publico_alvoDAO::findTopByUsr($atv);
	if ($pau != "") $membrocondominio = membroscondominioDAO::findTopByTipo($id_condominio, $pau, $nxt,$total_mural);
	$paf = publico_alvoDAO::findTopByFnc($atv);
    if ($paf != "") $funcionarioscondominio = funcionariosDAO::findTopByTipo($id_condominio, $paf, $nxt,$total_mural); 
	}
	
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
}else{
	$msg = $_POST['msg'];
}

$pontinhos = "../../";
$condominio = condominiosDAO::findByPk($id_condominio);
$atividades = atividadesDAO::findByPk($atv);
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
<script language="javascript" type="text/javascript" src="../../js/hint.js">
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
                <td valign="top" background="images/topo_espaco.jpg"><a href="home.php"><img src="../../images/botao_listar.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td width="12" valign="bottom" background="../../images/topo_espaco.jpg"><img src="../../images/canto.jpg" width="12" height="9" border="0" /></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>PÚBLICO ALVO </h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
              <p>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
			 <div align="center" class="fontelinkPreto">
			   <p><font class="warning">
			     <?php  if(isset($msg) )
						echo $msg;?>
			     </font>		        </p>
			   <p>CONDOMÍNIO -&gt; <strong>
               <?php=$condominio->nome?>
               </strong><br />
			   Atividades -&gt;<a href="../home.php"><?php=$atividades->titulo?></a><br />
			   <?php  if (isset($flg)) { 
			     switch ($flg) {
    				case 1: ?>Destinatário -> <a href="home.php?atv=<?php=$atv?>">Membros do Condomínio</a>
                    <?php  break;
                   case 2: ?>Destinatário -> <a href="home.php?atv=<?php=$atv?>">Funcionários do Condomínio</a>
                <?php 	break; } }?>
			   <p><br />
			      <br />
	           </p>
		    </div>
			 <div align="center">
			 
			   <p>
			   <?php  if (!isset($flg)) { ?>
			    <a href="home.php?atv=<?php=$atv?>&flg=1"> <img src="../../images/membros.jpg" border="0" /></a></p>
			   <p><a href="home.php?atv=<?php=$atv?>&flg=2"><img src="../../images/funcionarios.jpg" border="0" /> </a> </p> 
			   <?php  } ?>
			     <?php 
				if (isset($membrocondominio) && $flg == 1){
			?>
			    
			 </div>
			 <table width="96%" cellpadding="0" cellspacing="0" class="tabela1">
                <tr>
                  <td width="460" bgcolor="#6598CB"><table width="460" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="407" class="tabela1_titulo1">Top 10  Público Alvo (ordem alfabética)  <br />
                          Membros do Condomínio </td>
                        <td width="51"><a href="home.php?atv=<?php=$atv?>&flg=<?php=$flg?>"><img src="../../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="460">
                    <tr>
                      <td width="143" class="tabela1_titulo2">Nome </td>
                      <td width="170" class="tabela1_titulo2">Telefone </td>
                      <td width="92" class="tabela1_titulo2">N. Apto.</td>
                      <td width="40" class="tabela1_titulo2">&nbsp;</td>
                    </tr>
                    <?php 
							for ($i = 0; $i < sizeof($membrocondominio); $i++){

							 if($membrocondominio[$i]->id != "") {
						?>
                    <tr>
                      <td class="tabela1_linha2" nowrap="nowrap" ><a href="#"><?php=$membrocondominio[$i]->nome?>
                      </a></td>
                      <td class="tabela1_linha2"><a href="#"><?php=$membrocondominio[$i]->telefone?></a></td>
                      <td class="tabela1_linha2"><a href="#"><?php=$membrocondominio[$i]->numero_apartamento?></a><a href="#"></a></td>
                      <td class="tabela1_linha2"><a href="../../membro_condominio/adicionar.php?id=<?php=$membrocondominio[$i]->id?>"><img src="../../images/mais.jpg" width="20" height="21" border="0" /></a></td>
                    </tr>
                    <?php 
							} } 
							
						?>
                  </table></td>
                </tr>
            </table>
			<br />
			<?php  } else { if (isset($funcionarioscondominio) && $flg == 2){ ?>
			<table width="96%" cellpadding="0" cellspacing="0" class="tabela1">
              <tr>
                <td width="460" bgcolor="#6598CB"><table width="460" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="407" class="tabela1_titulo1">Top 10  Público Alvo (ordem alfabética) <br />
                        Funcionários do Condomínio </td>
                      <td width="51"><a href="home.php?atv=<?php=$atv?>&flg=<?php=$flg?>"><img src="../../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table cellpadding="1" cellspacing="1" width="460">
                    <tr>
                      <td width="143" class="tabela1_titulo2">Nome </td>
                      <td width="170" class="tabela1_titulo2">Telefone </td>
                      <td width="92" class="tabela1_titulo2">Função</td>
                      <td width="40" class="tabela1_titulo2">&nbsp;</td>
                    </tr>
                    <?php 
							for ($i = 0; $i < sizeof($funcionarioscondominio); $i++){

							 if($funcionarioscondominio[$i]->id != "") {
						?>
                    <tr>
                      <td class="tabela1_linha2" nowrap="nowrap" ><a href="#">
                        <?php=$funcionarioscondominio[$i]->nome?>
                      </a></td>
                      <td class="tabela1_linha2"><a href="#">
                        <?php=$funcionarioscondominio[$i]->telefone?>
                      </a></td>
                      <td class="tabela1_linha2"><a href="#">
                        <?php  $fnc = tiposfuncionariosDAO::findByPk($funcionarioscondominio[$i]->id_tipo_funcionario); echo $fnc->nome; ?>
                      </a><a href="#"></a></td>
                      <td class="tabela1_linha2"><a href="../../funcionarios/adicionar.php?id=<?php=$funcionarioscondominio[$i]->id?>"><img src="../../images/mais.jpg" width="20" height="21" border="0" /></a></td>
                    </tr>
                    <?php 
							} }
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
				} else { if(isset($flg)){			
			?>
			 <div align="center"><span class="verdanaAzul">
			 	Não existem Participantes cadastrados
			</span></div>
			 <?php 	
				 } } }
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
 <div id="tipDiv" style="position:absolute; visibility:hidden; z-index:100"></div>
 </body>
</html>
