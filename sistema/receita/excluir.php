<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
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

//verifica se o su possue permissão para excluir(3) no modulo(25)
if(!permissoesDAO::temPermissao(25,3,$usuario->id_tipo_usuario)){
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

if ( isset($_POST['id']) && is_numeric($_POST['id']) ){	
	ReceitaDespesaDAO::delete($_POST['id']);
}

//cria as sessões de navegação para datas
$_SESSION['mes'] = $mes;
$_SESSION['ano'] = $ano;

$receitas = ReceitaDespesaDAO::findTopByBusca("", $mes, $ano, $id_condominio, 'receita');
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
                 <td valign="top" background="images/topo_espaco.jpg"><a href="grafico.php"><img src="../images/botao_grafico_off.jpg" name="listar1" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="home.php"><img src="../images/botao_listar_off.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"><img src="../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar_off.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
            <h1>RECEITAS</h1></td>
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
			
			 <form onsubmit="return checa_formulario(this)" action="excluir.php" method="post">
               <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
                 <tr>
                   <td width="17%"><span class="style3">Selecione:</span></td>
                   
                   <td width="24%"><select name="mes" class="FORMULARIO">
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
                   </select></td>
				   <?php 
				   
				   		//gera um numero temporário relativo ao ano de criação do condomínio a partir dp qual se dará qualquer busca por data
				   		$numero = $condominio->data_criacao[0].$condominio->data_criacao[1].$condominio->data_criacao[2].$condominio->data_criacao[3];
				   
				   ?>
                   <td width="23%"><select name="ano" class="FORMULARIO">
                       <option  value="selecione">Escolha o ano</option>
					   <?php   for($i = $numero; $i <= date("Y",time()); $i++){ ?>
	                       	<option value="<?php=$i?>"><?php=$i?></option>
                       <?php  }  ?>
                   </select></td>
                   <td width="36%"><div align="center">
                       <input name="image" type="image" src="../images/lupa.jpg" />
                   </div></td>
                 </tr>
               </table>
			   <input type="hidden" name="area" value="<?php=$areas->id?>" />
               <input type="hidden" name="objeto" value="<?php=$objetos->id?>" />
             </form>
			 <br />
		    <?php 
				if ($receitas){
			?>
			
            <table cellpadding="0" cellspacing="0" width="99%" class="tabela1">
			   <tr>
                  <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="89%" class="tabela1_titulo1">Receitas do mês (<?php=$mes?>/<?php=$ano?>)</td>
                        <td width="11%"><a href="home.php"><img src="../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>
				  <table cellpadding="1" cellspacing="1" width="100%">
				  <?php 
					$areaAtual = "";
					for ($i = 0; $i < sizeof($receitas); $i++){
						if($receitas[$i]->area->nome != $areaAtual){
							$areaAtual = $receitas[$i]->area->nome;
					?>
					 <tr>
                        <th colspan="8" class="tabela1_titulo2" scope="col"><div align="left"><strong><?php=$receitas[$i]->area->nome?></strong></div></th>
                     </tr>
                    <tr>
                      <td width="15%" class="tabela1_titulo2">Centro de Custo </td>
                      <td width="18%" class="tabela1_titulo2">Documento</td>
                      <td width="11%" class="tabela1_titulo2">Data de Emiss&atilde;o</td>
                      <td width="15%" class="tabela1_titulo2">Data de Vencimento </td>
                      <td width="12%" class="tabela1_titulo2">Recebido</td>
                      <td width="23%" class="tabela1_titulo2">Valor Cobrado </td>
                      <td width="23%" class="tabela1_titulo2">Valor Recebido </td>
                      <td width="6%" class="tabela1_titulo2">&nbsp;</td>
                    </tr>
                    <?php 
						}
					
						//Verifica se esta conta foi faturada em outro mês e define a classe apropriada à receita				
						if (substr($receitas[$i]->data_pagamento_recebimento,0,7) != ($ano.'-'.$mes) and substr($receitas[$i]->data_pagamento_recebimento,0,7) != ('0000-00')){ 
							$classe = "tabela1_linhaGreen"; 
						} else { 
							if(substr($receitas[$i]->data_emissao,0,7) != ($ano.'-'.$mes) and  substr($receitas[$i]->data_pagamento_recebimento,0,7) == ($ano.'-'.$mes)){
								$classe = "tabela1_linhaAzul"; 							
							}else{
								$classe = "tabela1_linha2"; 							
							}							
						}
						
						//Verifica se o valor pago é inferior ao cobrado e define a classe apropriada ao valor recebido
						if($receitas[$i]->valor > $receitas[$i]->valor_pago and $receitas[$i]->recebido_pago == 1){
							$classe2 = "tabela1_linhaWarning"; 
						}else{
							$classe2 = "tabela1_linha2"; 							
						}	
			?>
                    <tr>
                      <td class="<?php=$classe?>"><a href="#" onmouseover="doTooltip(event, 0, '<?php=$receitas[$i]->centro->nome?>')" onmouseout="hideTip()">
                        <?php=substr($receitas[$i]->centro->nome,0,5)?>
                      </a></td>
                      <td class="<?php=$classe?>"><a href="#" onmouseover="doTooltip(event, 0, '<?php=$receitas[$i]->documento?>')" onmouseout="hideTip()">
                        <?php=substr($receitas[$i]->documento,0,6)?>
                        ...</a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#" onmouseover="doTooltip(event, 0, '<?php=$receitas[$i]->data_emissao[8].$receitas[$i]->data_emissao[9]."/".$receitas[$i]->data_emissao[5].$receitas[$i]->data_emissao[6]."/".$receitas[$i]->data_emissao[2].$receitas[$i]->data_emissao[3]?>')" onmouseout="hideTip()">
                        <?php=$receitas[$i]->data_emissao[8].$receitas[$i]->data_emissao[9]."/".$receitas[$i]->data_emissao[5].$receitas[$i]->data_emissao[6]?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#">
                        <?php=$receitas[$i]->data_vencimento[8].$receitas[$i]->data_vencimento[9]."/".$receitas[$i]->data_vencimento[5].$receitas[$i]->data_vencimento[6]."/".$receitas[$i]->data_emissao[2].$receitas[$i]->data_emissao[3]?>
                      </a></td>
                      <td class="<?php=$classe?>"><a href="#">
                        <?php  if($receitas[$i]->recebido_pago == 0){?>
                        <span class="warning">Não</span>
                        <?php  }else{?>
                        Sim
                        <?php  }?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#">
                        <?php=number_format(stripslashes($receitas[$i]->valor), 2, ',', '.')?>
                      </a></td>
                      <td class="<?php=$classe2?>" nowrap="nowrap"><a href="<?php  if($classe == 'tabela1_linhaGreen'){?>home.php?mes=<?php=$receitas[$i]->data_pagamento_recebimento[5].$receitas[$i]->data_pagamento_recebimento[6]?>&amp;ano=<?php=$receitas[$i]->data_pagamento_recebimento[0].$receitas[$i]->data_pagamento_recebimento[1].$receitas[$i]->data_pagamento_recebimento[2].$receitas[$i]->data_pagamento_recebimento[3]?>"  onmouseover="doTooltip(event, 0, 'Recebido em:<?php=$receitas[$i]->data_pagamento_recebimento[8].$receitas[$i]->data_pagamento_recebimento[9]?>-<?php=$receitas[$i]->data_pagamento_recebimento[5].$receitas[$i]->data_pagamento_recebimento[6]?>-<?php=$receitas[$i]->data_pagamento_recebimento[0].$receitas[$i]->data_pagamento_recebimento[1].$receitas[$i]->data_pagamento_recebimento[2].$receitas[$i]->data_pagamento_recebimento[3]?>')" onmouseout="hideTip()"<?php  }else{?>#"<?php  }?>>
                        <?php=number_format(stripslashes($receitas[$i]->valor_pago), 2, ',', '.')?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap">
					  <form action="excluir.php" method="post" onsubmit="javascript:return confirma('<?php=$receitas[$i]->nome?>','Receita')">
                        <input name="image22" type="image" src="../images/xis.jpg" width="20" height="21" border="0" />
                        <input type="hidden" value="<?php=$receitas[$i]->id?>" name="id" />
                      </form> </td>
                    </tr>
                    <?php  if($receitas[($i+1)]->area->nome != $areaAtual){ ?>
                    <tr>
                      <td colspan="6" nowrap="nowrap" class="tabela1_linha2"><a href="#">
                        <div align="right">TOTAL------------&gt;</div>
                      </a></td>
                      <td colspan="3" nowrap="nowrap" class="tabela1_linha2"><?php=number_format(ReceitaDespesaDAO::somaValoresByArea('receita', $mes, $ano, $areaAtual, $condominio->id), 2, ',', '.')?></td>
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
              <tr>
                <td class="tabela1_linhaGreen">*A receita foi emitida no mês atual, porém só foi paga em outro mês(data relatada posicionando o mouse sobre o valor recebido).</td>
              </tr>
              <tr>
                <td class="tabela1_linhaAzul">*A receita foi emitida em outro mês, porém só foi paga no mês atual.</td>
              </tr>
              <tr>
                <td class="tabela1_linhaWarning">*O valor pago foi inferior ao valor cobrado.</td>
              </tr>
            </table>
            <br />
			<br />
			<?php 
				}else{					
			?>
<div align="center"><span class="verdanaAzul">
			 	Não existem receitas do condomínio cadastrados
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
