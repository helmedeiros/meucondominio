<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/contatos.php");
require_once("../php/contatosDAO.php");


@session_start();

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

if(!permissoesDAO::temPermissao(18,4,$usuario->id_tipo_usuario)){
	header("Location: ../index.php");
	exit();
}

//recolhendo variáveis
if (isset($_GET['nome'])){
		$nome = $_GET['nome'];
}else{
		$nome = $_POST['nome'];
}

if (isset($_GET['cnpj'])){
		$cnpj = $_GET['cnpj'];
}else{
		$cnpj = $_POST['cnpj'];
}

if (isset($_GET['contato'])){
		$contato = $_GET['contato'];
}else{
		$contato = $_POST['contato'];
}

if (isset($_GET['responsavel'])){
		$responsavel = $_GET['responsavel'];
}else{
		$responsavel = $_POST['responsavel'];
}


//verifica se foram especificados quaisquer parametros para busca
if($nome != "" or $cnpj != "" or $contato != "" or $responsavel != ""){
	$find = 1;
}


if($find == 1){		
	if(!isset($nxt)||($nxt<0))
	{
		$nxt=0;
	}
	//quantos por pagina
	$total_mural = 10;

	$total = condominiosDAO::countByBusca($nome, $cnpj, $contato, $responsavel);
	$condominios = condominiosDAO::findTopByBusca($nome, $cnpj, $contato, $responsavel, $nxt, $total_mural);
	
	if (isset($_GET['msg'])){
		$msg = $_GET['msg'];
	}else{
		$msg = $_POST['msg'];
	}
}
	
$pontinhos = "../";
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
<script language="javascript" type="text/javascript" src="../js/funcoes.js" charset="iso-8859-1" >
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
                <td valign="top" background="images/topo_espaco.jpg"><a href="home.php"><img src="../images/botao_listar_off.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"><img src="../images/botao_pesquisar.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar_off.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
            <h1>CONDOMÍNIOS</h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
              <p>
            <br />
            <br />
            <br />
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
			if (isset($find)){
				if ($condominios){
			?>
            <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                <tr>
                  <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="89%" class="tabela1_titulo1">Top 10  Super-usuários (ordem alfabética) </td>
                        <td width="11%"><a href="home.php"><img src="../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
                    <tr>
                      <td width="24%" class="tabela1_titulo2">Nome</td>
                      <td width="21%" class="tabela1_titulo2">CNPJ</td>
                      <td width="27%" class="tabela1_titulo2">Contato</td>
                      <td width="21%" class="tabela1_titulo2">Responsável</td>
                      <td width="7%" class="tabela1_titulo2">&nbsp;</td>
                    </tr>
                    <?php 
							for ($i = 0; $i < sizeof($condominios); $i++){
								$superusuario = superusuarioDAO::findResp($condominios[$i]->id_responsavel);
								$contatos = contatosDAO::findByPk($condominios[$i]->id_contato);
								if ($condominios[$i]->status == 0) { 
									$classe = "tabela1_linhaWarning"; 
								}else {
									$classe = "tabela1_linha2"; 
								}
						?>
                    <tr>
                      <td class="<?php=$classe?>"><a href="#">
                        <?php=$condominios[$i]->nome?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#">
                        <?php=$condominios[$i]->CNPJ?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#">
                        <?php=$contatos->nome?>
                      </a></td>
                      <td class="<?php=$classe?>"><a href="#">
                         <?php=$superusuario->nome?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="adicionar.php?id=<?php=$condominios[$i]->id?>"><img src="../images/mais.jpg" width="20" height="21" border="0" /></a></td>
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
                    <a href="buscar.php?nxt=<?php=($nxt - $total)?>&nome=<?php=$nome?>&cnpj=<?php=$cnpj?>&contato=<?php=$contato?>&responsavel=<?php=$responsavel?>">
                    <?php  } ?>
                    Anterior</a> |
                    <?php  if(($nxt + $total_mural) < $total) {?>
                    <a href="buscar.php?nxt=<?php=($nxt + $total_mural)?>&nome=<?php=$nome?>&cnpj=<?php=$cnpj?>&contato=<?php=$contato?>&responsavel=<?php=$responsavel?>">
                    <?php  } ?>
                  Pr&oacute;ximo</a></div>
			<?php 
				}else{					
			?>
			 <div align="center"><span class="verdanaAzul">
			 	Não existem Condomínios cadastrados.
			</span></div>
			 <?php 	
				}}
			?>
			
			   
              <br />
              </p>
              <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                <tr>
                  <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="89%" class="tabela1_titulo1">Busca</td>
                        <td width="11%"><a href="home.php"></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><form action="buscar.php" method="get">
                      <table cellpadding="1" cellspacing="1" width="100%">
                        <tr>
                          <td width="23%" class="tabela1_titulo2">Nome</td>
                          <td width="23%" class="tabela1_titulo2">CNPJ</td>
                          <td width="23%" class="tabela1_titulo2">Contato</td>
                          <td width="24%" class="tabela1_titulo2">Responsável</td>
                          <td width="7%" class="tabela1_titulo2">&nbsp;</td>
                        </tr>
                        <tr>
                          <td class="tabela1_linha2" ><input name="nome" id="nome" class="FORMULARIO" type="text" size="10" value="<?php=$nome?>" />
                          </td>
                          <td class="tabela1_linha2" ><input name="cnpj" id="cnpj" class="FORMULARIO" type="text" value="<?php=$cnpj?>" size="10" maxlength="18" onkeypress="FormataCNPJ(this,event)"/>
                          </td>
                          <td class="tabela1_linha2" ><input name="contato" id="contato" class="FORMULARIO" type="text" size="10" value="<?php=$contato?>" />
                          </td>
                          <td class="tabela1_linha2" ><input name="responsavel" id="responsavel" class="FORMULARIO" type="text" size="10" value="<?php=$responsavel?>" /></td>
                          <td class="tabela1_linha2" nowrap="nowrap"><input name="image2" type="image" src="../images/lupa.jpg" width="20" height="21" border="0" /></td>
                        </tr>
                      </table>
                  </form></td>
                </tr>
              </table>
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
 </body>
</html>
