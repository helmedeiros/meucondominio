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
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();

$receita = new ReceitaDespesa();
$condominio = condominiosDAO::findByPk($id_condominio); 



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

if(isset($_GET['id'])){
	$receita = ReceitaDespesaDAO::findByPk($_GET['id']);
}


if ( isset($_POST['valor']) ){	
	//verifica se o su possue permissão para alterar(1) no modulo(25)
	if(!permissoesDAO::temPermissao(25,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
	//atribuições iniciais
	$receita->id = addslashes($_POST['id']);
	$receita->documento = addslashes($_POST['documento']);
	$receita->pagante_fornecedor = addslashes($_POST['pagante_fornecedor']);
	$receita->id_condominio = $id_condominio;	
	$receita->id_centro = $_POST['id_centro'];
	$receita->data_emissao = addslashes($_POST['data_emissao']);
	$receita->data_vencimento = addslashes($_POST['data_vencimento']);
	$receita->documento = addslashes($_POST['documento']);
	$receita->pagante_fornecedor = addslashes($_POST['pagante_fornecedor']);
	$receita->valor = str_replace(',','.',addslashes($_POST['valor']));
	$receita->forma_pagamento = addslashes($_POST['forma_pagamento']);
	$receita->observacao = addslashes($_POST['observacao']);
	$receita->valor_pago = str_replace(',','.',addslashes($_POST['valor_pago']));
	$receita->status = addslashes($_POST['status']);
	$receita->recebido_pago = addslashes($_POST['recebido_pago']);	
	
	//verifica se esta sendo criado ou alterado uma Receita
	if ($receita->data_emissao < $receita->data_vencimento){		
		
	//verifica se esta sendo criado ou alterado uma Receita
	if ($receita->id == 0){	
		//verifica se existe uma receita com o mesmo número para o mesmo condomínio
		if(ReceitaDespesaDAO::existeByCondominioTipoAreaDocumentoCentro($receita->id_condominio, 'despesa', $receita->documento, $receita->id_centro)){
			$receita = ReceitaDespesaDAO::findTopByBuscafindTopByBusca("", "", "", $receita->id_condominio, 'despesa', "", 0, 0, 1,  "", $receita->documento);
				//verifica se a receita esta ativa
				if($receita[0]->status == 0){
					$receita[0]->status = 1;
					$id = ReceitaDespesaDAO::save($receita[0]);
					header("Location: home.php?msg=A receita de número {$receita[0]->documento} do condomínio {$condominio->nome} foi restaurado");
					exit();	
				}else{
					header("Location: home.php?msg=A receita de número {$receita[0]->documento} do condomínio {$condominio->nome} já esta ativa");
					exit();	
				}
		}else{
			//outras atribuições			
			$receita->data_emissao = addslashes($_POST['data_emissao']);
			$receita->data_vencimento = addslashes($_POST['data_vencimento']);
			$receita->valor = str_replace(',','.',addslashes($_POST['valor']));
			$receita->forma_pagamento = addslashes($_POST['forma_pagamento']);
			$receita->observacao = addslashes($_POST['observacao']);
			$receita->pagante_fornecedor = addslashes($_POST['pagante_fornecedor']);
			$receita->valor_pago = str_replace(',','.',addslashes($_POST['valor_pago']));
			$receita->status = addslashes($_POST['status']);
			$receita->recebido_pago = addslashes($_POST['recebido_pago']);
			if($receita->recebido_pago == 1 and $receita->data_pagamento_recebimento[0] == 0){
				$receita->data_pagamento_recebimento = date("Y-m-d", time());
			}
			$id = ReceitaDespesaDAO::save($receita);
			header("Location: home.php");
			exit();
		}
	}else{

		//verifica se existe uma receita com o mesmo número para o mesmo condomínio e se esta receita nâo é a que se esta alterando
		if((ReceitaDespesaDAO::existeByCondominioTipoAreaDocumentoCentro($receita->id_condominio, 'despesa', $receita->documento, $receita->id_centro)) && (ReceitaDespesaDAO::existeByCondominioTipoAreaDocumentoCentroId($receita->id_condominio, 'despesa', $receita->documento, $receita->id_centro, $receita->id))) {
			header("Location: home.php?msg=O número de documento {$receita->documento} pertence a outra receita");
			exit();	
		}else{
			//cria a receita que se quer alterar
			$receita = ReceitaDespesaDAO::findByPk($receita->id);
			
			//outras atribuições	
			$receita->documento = addslashes($_POST['documento']);
			$receita->pagante_fornecedor = addslashes($_POST['pagante_fornecedor']);
			$receita->id_condominio = $id_condominio;	
			$receita->id_centro = $_POST['id_centro'];		
			$receita->data_emissao = addslashes($_POST['data_emissao']);
			$receita->data_vencimento = addslashes($_POST['data_vencimento']);
			$receita->valor = str_replace(',','.',addslashes($_POST['valor']));
			$receita->forma_pagamento = addslashes($_POST['forma_pagamento']);
			$receita->observacao = addslashes($_POST['observacao']);
			$receita->pagante_fornecedor = addslashes($_POST['pagante_fornecedor']);
			$receita->valor_pago = str_replace(',','.',addslashes($_POST['valor_pago']));
			$receita->status = addslashes($_POST['status']);
			$receita->recebido_pago = addslashes($_POST['recebido_pago']);
			if($receita->recebido_pago == 1 and $receita->data_pagamento_recebimento[0] == 0){
				$receita->data_pagamento_recebimento = date("Y-m-d", time());
			}

			$id = ReceitaDespesaDAO::save($receita);
			header("Location: home.php");
			exit();
		}
	}		
	
	}else{
		$msg = 'A data de emissão não pode ser maior ou igual a data de vencimento do ducemnto de receita';
	}	
	
	
} 


	
//cria as sessões de navegação para datas
$_SESSION['mes'] = $mes;
$_SESSION['ano'] = $ano;	
	
$centros = centrocustosDAO::findByTipoArea('despesa');
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
                <td width="266" valign="top" background="../images/topo_espaco.jpg">&nbsp;</td>
                 <td valign="top" background="images/topo_espaco.jpg"><a href="grafico.php"><img src="../images/botao_grafico_off.jpg" name="listar1" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="home.php"><img src="../images/botao_listar_off.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"><img src="../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>DESPESAS</h1></td>
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
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaincalt(this)" name="membro" id="membro">
			  <div align="center">
			  <font class="warning">
			    <?php  if(isset($msg) )
						echo $msg;?>
				</font>
			    <br />
			    <br />
	          </div>
			  <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                <tr>
                  <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="89%" class="tabela1_titulo1">Dados Cadastrais </td>                       
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
                      <tr>
                        <td class="tabela1_titulo2" colspan="2">obs.:Os números de documentos para recebimento devem ser únicos por centro de custo </td>
                      </tr>
                      <tr>
					  	<td class="tabela1_linha2"  align="right"> Centro Custo</td>
						<?php 
							if($receita->id != 0){
								$centro = centrocustosDAO::findByPk($receita->id_centro);
							
								//verifica se o centro de custo utilizado o que se quer usar esta ativo ou não							
								if($centro->status == 0){
									$classe = 'FORMULARIOWARNINIG';
								}else{
									$classe = 'FORMULARIO';
								}
							}else{
								$classe = 'FORMULARIO';
							}
						?>
						<td class="tabela1_linha2" ><select name="id_centro" class="<?php=$classe?>">
                          <?php  for($i = 0; $i < sizeof($centros); $i++){
						  		if(($centros[$i]->id == $receita->id_centro) or ($centros[$i]->status != 0)){
						  ?>						  
                          <option <?php  if($receita->id_centro == $centros[$i]->id){?> selected="selected" <?php  }?> value="<?php=$centros[$i]->id?>">
                             <?php=$centros[$i]->id_area_custos?>.<?php=$centros[$i]->numero?> - <?php=$centros[$i]->nome?>
                            </option>
                          <?php 	} 
						  	}?>
                        </select></td>
					  </tr>
					  
					  <tr>
					    <td class="tabela1_linha2"  align="right">Documento</td>
					    <td class="tabela1_linha2" ><input name="documento" type="text" class="FORMULARIO" id="documento" value="<?php=stripslashes($receita->documento)?>" size="40" maxlength="20" /></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right"><span class="verdanaMarron">Data Emiss&atilde;o</span></td>
					    <td class="tabela1_linha2" ><script>DateInput('data_emissao', true, 'YYYY-MM-DD', '<?php=$receita->data_emissao?>')</script></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"><span class="verdanaMarron">Data Vencimento</span></td>
					    <td class="tabela1_linha2" ><script>DateInput('data_vencimento', true, 'YYYY-MM-DD', '<?php=$receita->data_vencimento?>')</script></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right"><span class="verdanaMarron">Valor Cobrado </span></td>
					    <td class="tabela1_linha2" ><input name="valor" type="text" class="FORMULARIO" id="valor" value="<?php=number_format(stripslashes($receita->valor), 2, ',', '')?>" size="10" maxlength="10" onkeydown="FormataFloat(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">Parcelado</td>
					    <td class="tabela1_linha2" >Sim
                          <input name="parcelado" type="radio" value="1"  <?php  if ( $receita->parcelado == 1) { ?> checked="checked" <?php  }?>/>
Não
<input name="parcelado" type="radio" value="0"   <?php  if ( $receita->parcelado == 0) { ?>checked="checked"<?php  }?> /></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">Quantidade de Parcelas </td>
					    <td class="tabela1_linha2" ><input name="parcelas" type="text" class="FORMULARIO" id="parcelas" value="<?php=$receita->numeroParcela?>" size="2" maxlength="2" onkeypress="return Numero(event);"/></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right"><span class="verdanaMarron">Forma Pagamento</span></td>
					    <td class="tabela1_linha2" ><script>DateInput('data_nascimento', true, 'YYYY-MM-DD', '<?php=$membro->data_nascimento?>')</script>
					      <select name="forma_pagamento" class="FORMULARIO" >
                            <option <?php  if($receita->forma_pagamento == 'Boleto Bancário'){?> selected="selected" <?php  }?> value="Boleto Bancário">Boleto Bancário</option>
                            <option <?php  if($receita->forma_pagamento == 'Cheque'){?> selected="selected" <?php  }?> value="Cheque">Cheque</option>
                            <option <?php  if($receita->forma_pagamento == 'Cartão'){?> selected="selected" <?php  }?> value="Cartão">Cartão</option>
                            <option <?php  if($receita->forma_pagamento == 'Á Vista'){?> selected="selected" <?php  }?> value="Á Vista">Á Vista</option>
                          </select></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"><span class="verdanaMarron">Observa&ccedil;&atilde;o</span></td>
					    <td class="tabela1_linha2" ><textarea name="observacao" cols="40" rows="3" class="FORMULARIO" id="observacao"><?php=stripslashes($receita->observacao)?></textarea></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"><span class="verdanaMarron">Pagante</span></td>
					    <td class="tabela1_linha2" ><input  <?php  if($receita->recebido_pago == 1){?> disabled="disabled" <?php  }?> name="pagante_fornecedor" type="text" class="FORMULARIO" id="pagante_fornecedor" value="<?php=stripslashes($receita->pagante_fornecedor)?>" size="40" maxlength="150" />
				        <span class="warning"><?php  if($receita->recebido_pago == 1){?> * <?php  }?></span>
						 <?php  if($receita->recebido_pago == 1){?> <input type="hidden" name="pagante_fornecedor" id="pagante_fornecedor" value="<?php=stripslashes($receita->pagante_fornecedor)?>" /><?php  }?>						</td>
				      </tr>
					   <tr>
                        <td class="tabela1_linha2"  align="right"><span class="verdanaMarron">Valor Pago </span></td>
					    <td class="tabela1_linha2" ><input  <?php  if($receita->recebido_pago == 1){?> disabled="disabled" <?php  }?> name="valor_pago" type="text" class="FORMULARIO" id="valor_pago" value="<?php=number_format(stripslashes($receita->valor_pago), 2, ',', '')?>" size="10" maxlength="10" onkeydown="FormataFloat(this,event)" onKeyPress="return Numero(event);"/>
					      <span class="warning"><?php  if($receita->recebido_pago == 1){?> * <?php  }?><?php  if($receita->recebido_pago == 1){?> <input type="hidden" name="valor_pago" id="valor_pago" value="<?php=number_format(stripslashes($receita->valor_pago), 2, ',', '')?>" /><?php  }?></span></td>
				      </tr>
					   <tr>
					     <td  align="right" class="tabela1_linha2">Pago</td>
					     <td  align="left" class="tabela1_linha2"><select <?php  if($receita->recebido_pago == 1){?> disabled="disabled" <?php  }?> name="recebido_pago" class="FORMULARIO" >
                           <option <?php  if($receita->recebido_pago == 0){?> selected="selected" <?php  }?> value="0">Não</option>
                           <option <?php  if($receita->recebido_pago == 1){?> selected="selected"<?php  }?> value="1">Sim</option>
                         </select>
					       <span class="warning"><?php  if($receita->recebido_pago == 1){?> * <?php  }?><?php  if($receita->recebido_pago == 1){?> <input type="hidden" name="recebido_pago" id="recebido_pago" value="<?php=$receita->recebido_pago?>" /><?php  }?></span></td>
				      </tr>
				      <tr>
					    <td  align="right" class="tabela1_linha2">Situação</td>
				        <td  align="left" class="tabela1_linha2">Ativo
				          <input name="status" type="radio" value="1"  <?php  if ( $receita->status == 1) { ?> checked="checked" <?php  }?>/>
				            Inativo						
				            <input name="status" type="radio" value="0"   <?php  if ( $receita->status == 0) { ?>checked="checked"<?php  }?> /></td>
					  </tr>
					  <?php  if($receita->recebido_pago == 1){?> 
					  <tr>
					  	<td align="right" class="tabela1_linha2" colspan="2"><div align="left"><span class="warning">* Os campos não podem ser alterados após o pagamento </span></div></td> 
					  </tr>
					  <?php  }?>
					  <tr>
                        <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
                        <input type="image" src="../images/enviar.jpg" /></div></td>
				      </tr>
                  </table>
			      </td>
                </tr>
              </table> 
			  <input type="hidden"  name="id" value="<?php=stripslashes($receita->id)?>" />
		    </form> 
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
 </body>
</html>
