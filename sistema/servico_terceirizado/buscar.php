<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/servicosTerceirizados.php");
require_once("../php/servicosTerceirizadosDAO.php");
require_once("../php/tiposservicos.php");
require_once("../php/tiposservicosDAO.php");
require_once("../php/servidor.php");
require_once("../php/servidorDAO.php");
require_once("../php/receitadespesa.php");
require_once("../php/receitadespesaDAO.php");
require_once("../php/centrocustos.php");
require_once("../php/centrocustosDAO.php");
require_once("../php/areacustos.php");
require_once("../php/areacustosDAO.php");

@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
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

//verifica se o su possue permissão para visualizar(4) no modulo(24)
if(!permissoesDAO::temPermissao(24,4,$usuario->id_tipo_usuario)){
	header("Location: ../index.php");
	exit();
}


//recolhendo variáveis
if (isset($_GET['mes'])){
	$mes = stripslashes($_GET['mes']);
}else{
	if (isset($_POST['mes'])){
		$mes = stripslashes($_POST['mes']);
	}else{
		$mes = stripslashes($_SESSION['mes']);
	}
}

if (isset($_GET['ano'])){
	$ano = stripslashes($_GET['ano']);
}else{
	if (isset($_POST['ano'])){
		$ano = stripslashes($_POST['ano']);
	}else{
		$ano = stripslashes($_SESSION['ano']);
	}
}


if ( isset($mes) && is_numeric($mes) ){	
	$mes = $mes;
}else{
	$mes = date("m",time());	
}

if ( isset($ano) && is_numeric($ano) ){	
	$ano = $ano;
}else{
	$ano = date("Y",time());	
}

if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
}else{
	$msg = $_POST['msg'];
}

//cria as sessões de navegação para datas
$_SESSION['mes'] = $mes;
$_SESSION['ano'] = $ano;


$servicos = servicosTerceirizadosDAO::findTopByBusca("", $mes, $ano, $id_condominio, $servidor="", $id = 0, $i = 0, $f = 0, $orderBy = "t.nome");
$condominio = condominiosDAO::findByPk($id_condominio); 
$classe = "tabela1_linha2";
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
<script language="javascript" type="text/javascript" src="../js/hint.js">
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
                <td width="266" valign="top" background="../images/topo_espaco.jpg">&nbsp;</td>
                 <td valign="top" background="images/topo_espaco.jpg"><a href="grafico.php"></a></td>
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
          <h1>SERVIÇOS TERCEIRIZADOS</h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
              <p align="center">
         <br />
            <br />
             <br />
            CONDOMÍNIO -&gt; <strong><?php=$condominio->nome?></strong><br />
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
			if($_POST['find'] == 1){
			if ($servicos){
			?>
		    <table cellpadding="0" cellspacing="0" width="99%" class="tabela1">
              <tr>
                <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="89%" class="tabela1_titulo1">Serviços Terceirizados do mês (
                          <?php=$mes?>
                        /
                        <?php=$ano?>
                        )</td>
                      <td width="11%"><a href="home.php"><img src="../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table cellpadding="1" cellspacing="1" width="100%">
                    <?php 
					$tipoServicoAtual = "";
					for ($i = 0; $i < sizeof($servicos); $i++){
						if($servicos[$i]->tipoServico->nome != $tipoServicoAtual){
							$tipoServicoAtual = $servicos[$i]->tipoServico->nome ;
					?>
                    <tr>
                      <th colspan="5" class="tabela1_titulo2" scope="col"><div align="left"><strong>
                        <?php=$servicos[$i]->tipoServico->nome ?>
                      </strong></div></th>
                    </tr>
                    <tr>
                      <td width="18%" class="tabela1_titulo2">Documento</td>
                      <td width="30%" class="tabela1_titulo2">Data da Prestação </td>
                      <td width="26%" class="tabela1_titulo2">Valor Cobrado </td>
                      <td width="20%" class="tabela1_titulo2">&nbsp;</td>
                      <td width="6%" class="tabela1_titulo2">&nbsp;</td>
                    </tr>
                    <?php 
						}			
						
			?>
                    <tr>
                      <td class="<?php=$classe?>"><a href="../despesa/adicionar.php?id=<?php=$servicos[$i]->despesa->id?>" onmouseover="doTooltip(event, 0, '<?php=$servicos[$i]->despesa->documento?>')" onmouseout="hideTip()">
                        <?php=substr($servicos[$i]->despesa->documento,0,6)?>
                        ...</a></td>
                      <td nowrap="nowrap" class="<?php=$classe?>"><?php=$servicos[$i]->data_prestacao[8].$servicos[$i]->data_prestacao[9]."/".$servicos[$i]->data_prestacao[5].$servicos[$i]->data_prestacao[6]."/".$servicos[$i]->data_prestacao[0].$servicos[$i]->data_prestacao[1].$servicos[$i]->data_prestacao[2].$servicos[$i]->data_prestacao[3]?></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#">
                        <?php=number_format(stripslashes($servicos[$i]->despesa->valor), 2, ',', '.')?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="adicionarNota.php?id=<?php=$servicos[$i]->id?>"><img src="../images/notaFiscal.jpg" width="80" height="21" border="0" /></a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="adicionar.php?id=<?php=$servicos[$i]->id?>"><img src="../images/mais.jpg" width="20" height="21" border="0" /></a></td>
                    </tr>
                    <?php  if($servicos[($i+1)]->tipoServico->nome != $tipoServicoAtual){ ?>
                    <tr>
                      <td colspan="2" nowrap="nowrap" class="tabela1_linha2"><a href="#">
                        <div align="right">TOTAL------------&gt;</div>
                      </a></td>
                      <td colspan="3" nowrap="nowrap" class="tabela1_linha2"><?php=number_format(servicosTerceirizadosDAO::somaValoresByTipo($tipoServicoAtual, $mes, $ano, $condominio->id), 2, ',', '.')?></td>
                    </tr>
                    <?php 
						}
				}
			?>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
		    <br />
			<br />
			<?php 
				}else{					
			?>
<div align="center"><span class="verdanaAzul">
			 	Não existem serviços terceirizados do condomínio cadastrados
			</span></div>
			 <?php 	
				}
				}
			?>
			
			   
              <br />
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
                  <td><form onsubmit="return checa_formulario2(this)" action="buscar.php" method="post" >
                      <table cellpadding="1" cellspacing="1" width="100%">
                        <tr>
                          <td width="92%" class="tabela1_titulo2">Data</td>
                          <td width="8%" class="tabela1_titulo2">&nbsp;</td>
                        </tr>
                        <tr>
                          <td class="tabela1_linha2" nowrap="nowrap"><select name="mes">
                              <option  value="selecione">Escolha o mês</option>
                              <?php   for($i = 1; $i <= 12; $i++){ 
									if($i < 10) {
										$a = '0'.$i;
									}else{ $a = $i; }
							?>
                              <option value="<?php=$a?>">
                              <?php=$a?>
                              </option>
                              <?php  }  ?>
                            </select>
                              <select name="ano">
                                <option  value="selecione">Escolha o ano</option>
                                <option value="<?php=date("Y",time())?>">
                                <?php=date("Y",time())?>
                                </option>
                              </select>
                              <input type="hidden" name="find" value="1" />
                          </td>
                          <td class="tabela1_linha2" nowrap="nowrap"><input name="image2" type="image" src="../images/lupa.jpg" /></td>
                        </tr>
                      </table>
                  </form></td>
                </tr>
              </table>
          </p></td>
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
