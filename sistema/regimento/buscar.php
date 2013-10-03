<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/regimentos.php");
require_once("../php/regimentosDAO.php");

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

$dias = array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb");

//verifica se o su possue permissão para visualizar(4) na area de custo(30)
if(!permissoesDAO::temPermissao(30,4,$usuario->id_tipo_usuario)){
	header("Location: ../index.php");
	exit();
}

//recolhendo variáveis
if (isset($_GET['regimento'])){
		$regimento = $_GET['regimento'];
}else{
		$regimento = $_POST['regimento'];
}

if (isset($_GET['situacao'])){
		$situacao = $_GET['situacao'];
}else{
		$situacao = $_POST['situacao'];
}

if (isset($_GET['data'])){
		$data = $_GET['data'];
}else{
		$data = $_POST['data'];
}

//verifica se foram especificados quaisquer parametros para busca
if($situacao != "" or $regimento != "" or $data != ""){
	$find = 1;
}


if($find == 1){		
	if(!isset($nxt)||($nxt<0))
	{
		$nxt=0;
	}
	//quantos por pagina
	$total_mural = 10;

	$total = regimentosDAO::countByBusca($regimento, $data, $situacao);
	
	$regimentos = regimentosDAO::findTopByBusca($regimento, $data, $situacao, $nxt, $total_mural);


	if (isset($_GET['msg'])){
		$msg = $_GET['msg'];
	}else{
		$msg = $_POST['msg'];
	}
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

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script language="javascript" type="text/javascript" src="../js/calendario.js">
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
          <h1>REGIMENTOS</h1></td>
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
			  <p><font class="warning">
			    <?php  if(isset($msg) )
						echo $msg;?>
			    </font>		      </p>
			  <p>CONDOMÍNIO -&gt; <strong>
			    <?php=$condominio->nome?>
			  </strong><br />
			    <br />
	          </p>
		    </div>
			<?php 
			if (isset($find)){
				if ($regimentos){
			?>
				<table width="96%" cellpadding="0" cellspacing="0" class="tabela1">
              <tr>
                <td width="460" bgcolor="#6598CB"><table width="460" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="407" class="tabela1_titulo1">Top 10  Reuniões (ordem alfabética) </td>
                      <td width="51"><a href="home.php"><img src="../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table cellpadding="1" cellspacing="1" width="460">
                    <tr>
                      <td width="101" class="tabela1_titulo2">Regimento</td>
                      <td width="106" class="tabela1_titulo2">Data</td>
                      <td width="132" class="tabela1_titulo2">Situacao</td>
                      <td width="65" class="tabela1_titulo2">Aditivos</td>
                      <td width="38" class="tabela1_titulo2">&nbsp;</td>
                    </tr>
                    <?php 
							for ($i = 0; $i < sizeof($regimentos); $i++){ 
							 
						?>
                    <tr>
                      <td class="tabela1_linha2" nowrap="nowrap" ><a href="#" onmouseover="doTooltip(event, 0, '<?php=$regimentos[$i]->regimento?>')" onmouseout="hideTip()">
                        <?php=substr($regimentos[$i]->regimento, 0, 10)?>
                        <?php  if(strlen($regimentos[$i]->regimento) >= 12){?>
...
<?php  } ?>
                      </a><a href="#"></a></td>
                      <td class="tabela1_linha2"><a href="#">
                        <?php=$dias[date('w',strtotime($regimentos[$i]->data_envio))]?>
,
<?php=$regimentos[$i]->data_envio[8].$regimentos[$i]->data_envio[9]?>
/
<?php=$r[$i]->data_envio[5].$regimentos[$i]->data_envio[6]?>
                      </a></td>
                      <td class="tabela1_linha2"><a href=""><?php  if($regimentos[$i]->status == 1) { ?> Em vigência <?php  } else { ?> Substituído <?php  } ?>  </a></td>
                      <td class="tabela1_linha2"><div align="center"><a href="participante/home.php?ata=<?php=$regimentos[$i]->id?>"><img src="../images/lupa.jpg" width="20" height="21" border="0" /></a></div></td>
                      <td class="tabela1_linha2"><a href="adicionar.php?id=<?php=$regimentos[$i]->id?>"><img src="../images/mais.jpg" width="20" height="21" border="0" /></a></td>
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
			 	Não existem Reuni&otilde;es cadastradas
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
                  <td>
				  <form action="buscar.php" method="post">
				  <table cellpadding="1" cellspacing="1" width="100%">
                      <tr>
                        <td width="41%" class="tabela1_titulo2">Descrição</td>
                        <td width="25%" class="tabela1_titulo2">Situação</td>
                        <td width="26%" class="tabela1_titulo2">Data</td>
                        <td width="8%" class="tabela1_titulo2">&nbsp;</td>
                      </tr>                   
                      <tr>
                        <td class="tabela1_linha2" nowrap="nowrap">
                          <input name="regimento" id="regimento" class="FORMULARIO" type="text" size="20" value="<?php=$regimento?>" />                        </td>
                        <td nowrap="nowrap" class="tabela1_linha2">
						<select name="situacao">
                                <?php  if (isset($situacao)) { if ($situacao == 1){ ?>
                                <option selected="selected" value="<?php=$situacao?>"/>Em vigência</option> <?php  } else { ?> 
                                <option selected="selected" value="<?php=$situacao?>"/>Substituído</option> 
                                <?php  } } else { ?>
                                <option selected="selected" value=""> Selecionar </option><?php  } ?>
                                <option value"">------------</option>
                                <option value="1">Em vigência</option>
                                <option value="2">Substituído</option>								
                                
                            </select></td>
                        <td nowrap="nowrap" class="tabela1_linha2"><script>DateInput('data', false, 'YYYY-MM-DD')</script> </td>
                        <td class="tabela1_linha2" nowrap="nowrap"><input type="image" src="../images/lupa.jpg" width="20" height="21" border="0" /></td>
                      </tr>
                    </table>
					</form>
				  </td>
                </tr>
              </table></td>
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
