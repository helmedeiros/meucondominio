<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/niveisprioridade.php");
require_once("../php/niveisprioridadeDAO.php");
require_once("../php/criticas_sugestoes.php");
require_once("../php/criticas_sugestoesDAO.php");
require_once("../php/tiposusuarios.php");
require_once("../php/tiposusuariosDAO.php");
require_once("../php/tiposfuncionarios.php");
require_once("../php/tiposfuncionariosDAO.php");
require_once("../php/membroscondominio.php");
require_once("../php/membroscondominioDAO.php");
require_once("../php/funcionarios.php");
require_once("../php/funcionariosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/informativos.php");
require_once("../php/informativosDAO.php");
require_once("../php/destinatarios_visualizadores.php");
require_once("../php/destinatarios_visualizadoresDAO.php");
require_once("../php/email.php");

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
$tiposusuarios = tiposusuariosDAO::findAll();
$tiposfuncionarios = tiposfuncionariosDAO::findAll();

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
	if(isset($_GET['opt'])){
 switch ($_GET['opt']) {
   case 1:
    if(isset($usuario->id_tipo_usuario)){
	  $total = criticas_sugestoesDAO::countAllEnviadas($usuario->id, $usuario->id_tipo_usuario);
	  $cs = criticas_sugestoesDAO::findTopEnviadas($usuario->id, $usuario->id_tipo_usuario, $nxt,$total_mural); } else {
	 if(isset($usuario->id_tipo_funcionario)){
	  $total = criticas_sugestoesDAO::countAllEnviadas($usuario->id, $usuario->id_tipo_usuario);
	  $cs = criticas_sugestoesDAO::findTopEnviadas($usuario->id, $usuario->id_tipo_usuario, $nxt,$total_mural); } 
	  }
	 $txt = "Enviadas";
   break;
   case 2:
    if(isset($usuario->id_tipo_usuario)){
	  $total = criticas_sugestoesDAO::countAllRecebidas($usuario->id, $usuario->id_tipo_usuario);
	  $cs = criticas_sugestoesDAO::findTopRecebidas($usuario->id, $usuario->id_tipo_usuario, $nxt,$total_mural); }
	else {
	 if(isset($usuario->id_tipo_funcionario)){
	  $total = criticas_sugestoesDAO::countAllRecebidas($usuario->id, $usuario->id_tipo_usuario);
	  $cs = criticas_sugestoesDAO::findTopRecebidas($usuario->id, $usuario->id_tipo_usuario, $nxt,$total_mural); } }
	  $txt = "Recebidas";
	break;
   case 3:	
   	if(isset($usuario->id_tipo_usuario)){
		$total = destinatarios_visualizadoresDAO::findbyVLZU($usuario->id_tipo_usuario, $usuario->id);
	    for ($i = 0 ; $i < sizeof($total) ; $i++) {
		  	if ($i == 0 ) 
				$like = $total[$i]->id_criticas_sugestoes;
			else
				$like = $like.', '.$total[$i]->id_criticas_sugestoes; 
		}
		$total = sizeof($total);
		if($like != ""){
			$cs = criticas_sugestoesDAO::findTopVLZU($like, $nxt,$total_mural);
		}
	 }
	 $txt = "Visualizações";
   	 break; 
   } }

	
	
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
				<td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar_off.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>CRITICAS &amp; SUGESTÕES </h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
		  	<p align="center" class="fontelinkPreto">
				<br />
	            <br />
    	         CONDOMÍNIO -&gt; <strong><a href="home.php"><?php=$condominio->nome?></a></strong><br />
        	      <?php  if($txt != ""){?>
				 	Críticas &amp; Sugestões -&gt; <strong><a href="home.php?opt=<?php=$opt?>" ><?php=$txt?></a></strong>
				<?php  }?>
            	<br />
	            <br />
				<div align="center">
					<font class="warning">
						<?php  if(isset($msg) ) echo $msg;?>
					</font>
				    <br />
				    <br />
            	</div>

			 <?php  if (!isset($opt)) { ?>
			 	<table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
               		<tr>
		                 <td bgcolor="#6598CB">
						 	<table width="100%" cellpadding="0" cellspacing="0">
			                   <tr>
        			             <td width="89%" class="tabela1_titulo1">Opções </td>
                   			   </tr>
		                    </table>
						 </td>
					</tr>
					<tr>
                 		<td>
							<table cellpadding="1" cellspacing="1" width="100%">
                     			<tr>
			                       <td class="tabela1_titulo2">obs:Selecione um dos items a baixo </td>
            			         </tr>
								 <tr>
                     				<td colspan="5" nowrap="nowrap" class="tabela1_linha2" >									
										<div align="center"><a href="home.php?opt=1">
											<img src="../images/enviadas.jpg" alt="Enviadas" border="0" />
										</a></div>
									</td>                      			 
								</tr>
								<tr>
								   <td colspan="5" nowrap="nowrap" class="tabela1_linha2" >
								   		<div align="center"><a href="home.php?opt=2">
											<img src="../images/recebidas.jpg" alt="Recebidas" border="0" />
										</a></div>
									</td>
						      </tr>
								 <tr>
								   <td colspan="5" nowrap="nowrap" class="tabela1_linha2" >
								   		<div align="center"><a href="home.php?opt=3">
											<img src="../images/visualizacao.jpg" alt="Visualizações" border="0" />
										</a></div>
									</td>
						      </tr>
							</table>
						</td>
					</tr>
			</table>			 
			 <?php  } ?>
			 
			    <?php  if (isset($_GET['id'])){ ?>
                 <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
               <tr>
                 <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                     <tr>
                       <td width="89%" class="tabela1_titulo1">Visualizadores</td>
                     </tr>
                 </table></td>
               </tr>
               <tr>
                 <td><table cellpadding="1" cellspacing="1" width="100%">
                     <tr>
                       <td class="tabela1_titulo2" colspan="3">obs:</td>
                     </tr>
					  <?php  for ( $i = 1 ; $i <= sizeof($tiposusuarios) ; $i++) { 
	              $totalMembros = destinatarios_visualizadoresDAO::countAllByTu($i, $_GET['id']);
				  $membros = destinatarios_visualizadoresDAO::findByCSU($i, $_GET['id']); 
				  if ($totalMembros > 0 ) {
				  ?>
				      <tr>
                       <td width="24%"  align="right" class="tabela1_linha2"><?php  $tdest = tiposusuariosDAO::findByPk($i); echo $tdest->nome; ?> </td>
                       <td width="38%" class="tabela1_linha2" ><?php  
							 $nmTr = intval(sizeof($membros)/2);
							if(floatval(sizeof($membros)/2) != intval(sizeof($membros)/2)){	
							$nmTr += 1; }
							$cont = 1;
							for($j = 0; $j < $nmTr; $j++){?>
						       <?php    
							   switch ($membros[$j]->id_tipo_usuario) {
								case 1:
								   $mbr = superusuarioDAO::findByPk($membros[$j]->id_membro_condominio );
								   $ref = "/super_usuario/adicionar.php?id=";
								   break;
								case 4:
								   $mbr = funcionariosDAO::findByPk($membros[$j]->id_membro_condominio );
								    $ref = "/membro_condominio/adicionar.php?id=";
								   break;
								default:
								   $mbr = membroscondominioDAO::findByPk($membros[$j]->id_membro_condominio );
  								   $ref = "/membro_condominio/adicionar.php?id=";
								   break; } ?><a href="..<?php=$ref?><?php=$membros[$j]->id_membro_condominio?>"> <?php  echo $mbr->nome; ?><br /> </a> <?php   $cont++; }?></td>
                       <td width="38%" class="tabela1_linha2" ><?php 	for($k = ($cont-1); $k < sizeof($membros); $k++){?>
                         <?php    switch ($membros[$j]->id_tipo_usuario) {
								case 1:
								   $mbr = superusuarioDAO::findByPk($membros[$j]->id_membro_condominio );
								   $ref = "/super_usuario/adicionar.php?id=";
								   break;
								case 4:
								   $mbr = funcionariosDAO::findByPk($membros[$j]->id_membro_condominio );
								   $ref = "/membro_condominio/adicionar.php?id=";
								   break;
								default:
								   $mbr = membroscondominioDAO::findByPk($membros[$j]->id_membro_condominio );
								    $ref = "/membro_condominio/adicionar.php?id=";
								   break; } ?> <a href="..<?php=$ref?><?php=$membros[$j]->id_membro_condominio?>"> <?php  echo $mbr->nome; ?> <br /> </a> <?php    $cont++; } ?>					   </td>
			         </tr>
                     <?php  }  }?>
				 <?php  for ( $i = 1 ; $i <= sizeof($tiposfuncionarios) ; $i++) { 
	             $totalMembros = destinatarios_visualizadoresDAO::countAllByTf($i, $_GET['id']);
				 $membros = destinatarios_visualizadoresDAO::findByCSF($i, $_GET['id']);
				  if ($totalMembros > 0 ) {
				  ?>
                     <tr>
                       <td  align="right" class="tabela1_linha2"><?php  $tdest = tiposfuncionariosDAO::findByPk($i); echo $tdest->nome; ?>					   </td>
                       <td  align="right" class="tabela1_linha2"><div align="left">
                         <?php  													
							$nmTr = intval(sizeof($membros)/2);
							if(floatval(sizeof($membros)/2) != intval(sizeof($membros)/2)){	
							$nmTr += 1; }
							$cont = 1;
							for($j = 0; $j < $nmTr; $j++){?><a href="../funcionarios/adicionar.php?id=<?php=$membros[$j]->id_funcionario_condominio?>"><?php  $fnc = funcionariosDAO::findByPk($membros[$j]->id_funcionario_condominio); echo $fnc->nome; ?> </a>
                         <br />
                         <?php  $cont++; }?>
                       </div></td>
                       <td  align="right" class="tabela1_linha2"><div align="left">
                         <?php 	for($k = ($cont-1); $k < $totalMembros; $k++){?><a href="../funcionarios/adicionar.php?id=<?php=$membros[$j]->id_funcionario_condominio?>"><?php  $fnc = funcionariosDAO::findByPk($membros[$j]->id_funcionario_condominio); ?> <?php  echo $fnc->nome; ?></a>
                       </div></td>
                     </tr>
					 <?php  } } } ?>
                     <tr>
                       <td colspan="3"  align="right" class="tabela1_linha2"><div align="center"><br />
                               <input name="svinfo" type="image" src="../images/enviar.jpg" value="bla" />
                       </div></td>
                     </tr>
                 </table></td>
               </tr>
             </table>
<?php  } ?>
            
            <?php 
				if ($cs && !isset($_GET['id'])){
			?>
               
             </p>
             <table width="96%" cellpadding="0" cellspacing="0" class="tabela1">
                <tr>
                  <td width="460" bgcolor="#6598CB"><table width="460" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="407" class="tabela1_titulo1">Top 10  Criticas &amp; Sugestões (ordem alfabética) </td>
                        <td width="51"><a href="home.php"><img src="../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="460">
                    <tr>
                      <td width="86" class="tabela1_titulo2">Data </td>
                      <td width="41" class="tabela1_titulo2">Tipo</td>
                      <td width="58" class="tabela1_titulo2">Prioridade</td>
                      <td width="67" class="tabela1_titulo2">Mensagem</td>
                      <td width="77" class="tabela1_titulo2">Situação</td>
                      <td width="76" class="tabela1_titulo2">Visualizadores</td>
                      <td width="31" class="tabela1_titulo2">&nbsp;</td>
                    </tr>
                    <?php 
							for ($i = 0; $i < sizeof($cs); $i++){
						?>
                    <tr>
                      <td class="tabela1_linha2" nowrap="nowrap" ><a href="#">
                        <?php=$dias[date('w',strtotime($cs[$i]->data_envio))]?>,<?php=$cs[$i]->data_envio[8].$cs[$i]->data_envio[9]?>/<?php=$cs[$i]->data_envio[5].$cs[$i]->data_envio[6]?></a></td>
                      <td class="tabela1_linha2"><a href="#"><?php=$cs[$i]->tipo?></a></td>
                      <td class="tabela1_linha2"><a href="#"><?php  $np = niveisprioridadeDAO::findByPk($cs[$i]->id_prioridade); ?> <?php=$np->nome?> </a></td>
                      <td nowrap="nowrap" class="tabela1_linha2" ><a href="#" onmouseover="doTooltip(event, 0, '<?php=$cs[$i]->mensagem?>')" onmouseout="hideTip()"><?php=substr($cs[$i]->mensagem, 0, 6)?><?php  if(strlen($cs[$i]->mensagem) >= 6){?>...<?php  } ?></a></td>
                      <td class="tabela1_linha2" ><a href="#" onmouseover="doTooltip(event, 0, '<?php=$cs[$i]->status?>')" onmouseout="hideTip()">
                        <?php=substr($cs[$i]->status, 0, 6)?>
                        <?php  if(strlen($cs[$i]->status) >= 6){?>
                        ...
                        <?php  } ?>
                      </a><a href=""></a></td>
                      <td class="tabela1_linha2"><div align="center"><a href="#"></a> <a href="home.php?opt=<?php=$opt?>&id=<?php=$cs[$i]->id?>"><img src="../images/lupa.jpg" width="20" height="21" border="0" /></a></div></td>
                      <td class="tabela1_linha2"><a href="adicionar.php?opt=<?php=$opt?>&id=<?php=$cs[$i]->id?>"><img src="../images/mais.jpg" width="20" height="21" border="0" /></a></td>
                    </tr>
                    <?php 
							}
						?>
                  </table></td>
                </tr>
            </table>
			 <br />
			 
			<br />
			<br />
			<br />

			<div align="center" class="fontelink"><?php  if(($nxt) > 0) {?>
                    <a href="home.php?opt=<?php=$opt?>&nxt=<?php=($nxt - $total)?>">
                    <?php  } ?>
                    Anterior</a> |
                    <?php  if(($nxt + $total_mural) < $total) {?>
                    <a href="home.php?opt=<?php=$opt?>&nxt=<?php=($nxt + $total_mural)?>">
                    <?php  } ?>
                  Pr&oacute;ximo</a></div>
			<?php 
				}else{					
			?>
			 <div align="center"><span class="verdanaAzul">
			 <?php  if (isset($opt) && !isset($id)) {?>
			 	Não existem Criticas ou Sugestões cadastradas 
			</span></div>
			 <?php 	
				} }
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
