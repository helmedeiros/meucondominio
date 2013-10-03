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
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();

$servico = new servicosTerceirizados();
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
	$servico = servicosTerceirizadosDAO::findByPk($_GET['id']);
}


if ( $_POST['id_servidor'] != 0 and $_POST['id_tipos'] != 0 and $_POST['id_despesa'] != 0 ){	
	//verifica se o su possue permissão para alterar(1) no modulo(24)
	if(!permissoesDAO::temPermissao(24,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
	//atribuições iniciais
	$servico->id = addslashes($_POST['id']);	
	$servico->id_condominio = $id_condominio;
	$servico->data_prestacao = addslashes($_POST['data_prestacao']);
	$servico->status = addslashes($_POST['status']);
	$servico->despesa = ReceitaDespesaDAO::findByPk(addslashes($_POST['id_despesa']));
	$servico->servidor = ServidorDAO::findByPk(addslashes($_POST['id_servidor']));
	$servico->tipoServico = tiposservicosDAO::findByPk(addslashes($_POST['id_tipos']));	
	
	//verifica se o serviço terceirizado esta sendo alterado	
	if ($servico->id != 0){
		$servico = servicosTerceirizadosDAO::findByPk($servico->id);
	}
	
	$servico->id_condominio = $id_condominio;
	$servico->data_prestacao = addslashes($_POST['data_prestacao']);
	$servico->status = addslashes($_POST['status']);
	$servico->despesa = ReceitaDespesaDAO::findByPk(addslashes($_POST['id_despesa']));
	$servico->servidor = ServidorDAO::findByPk(addslashes($_POST['id_servidor']));
	$servico->tipoServico = tiposservicosDAO::findByPk(addslashes($_POST['id_tipos']));	
	$id = servicosTerceirizadosDAO::save($servico);
	header("Location: home.php");
	exit();
	
	
} 


	
//cria as sessões de navegação para datas
$_SESSION['mes'] = $mes;
$_SESSION['ano'] = $ano;	
	
$servidores = ServidorDAO::findALL();
$tiposServicos = tiposservicosDAO::findALL();
$despesas = ReceitaDespesaDAO::findByArea(5);
$classe2 = 'FORMULARIO';
$classe = 'FORMULARIO';
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

function adiciona_despesa(){
url = '../despesa/adicionar.php';
window.open(url,"Nova Despesa","resizable,width=573,height=130");
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
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaincalt(this)" name="servico" id="servico">
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
                        <td class="tabela1_titulo2" colspan="2">Dados do Serviço </td>
                      </tr>				
					  <?php 
					  	if($servico->servidor->id != 0){ 
							$servidor = ServidorDAO::findByPk($servico->servidor->id);
							if($servidor->status == 0){
								$classe2 = 'FORMULARIOWARNINIG';
							}else{
								$classe2 = 'FORMULARIO';
							}
						}
						?>	 
					    <tr>
					      <td class="tabela1_linha2"  align="right">Prestador de Serviço </td>
					      <td class="tabela1_linha2" ><select name="id_servidor" class="<?php=$classe2?>">
						   <option value="0">Escolha um Prestador de Serviço</option>
                            <?php  for($i = 0; $i < sizeof($servidores); $i++){
								if(($servidores[$i]->id == $servico->servidor->id) or ($servidores[$i]->status != 0)){							
							?>
                            <option <?php  if($servico->servidor->id == $servidores[$i]->id){?> selected="selected" <?php  }?> value="<?php=$servidores[$i]->id?>">
                            	<?php=$servidores[$i]->nome_servidor?>
							</option>
                            <?php  		}
								}?>
                          </select></td>
				      </tr>
				        <tr>
				          <td class="tabela1_linha2"  align="right">Tipo Serviço </td>
				          <td class="tabela1_linha2" ><select name="id_tipos" class="<?php=$classe?>">
						  <option value="0">Escolha um Tipo de Serviço</option>
                            <?php  for($i = 0; $i < sizeof($tiposServicos); $i++){?>
                            <option <?php  if($servico->tipoServico->id == $tiposServicos[$i]->id){?> selected="selected" <?php  }?> value="<?php=$tiposServicos[$i]->id?>">
                            	<?php=$tiposServicos[$i]->nome?>
                            </option>
                            <?php  }?>
                          </select></td>
			          </tr>
			            <tr>
			              <td class="tabela1_linha2"  align="right">Despesa</td>
			              <td class="tabela1_linha2" ><select name="id_despesa" class="<?php=$classe?>">
						  	<option value="0">Escolha a despesa relacionada</option>
                            <?php  for($i = 0; $i < sizeof($despesas); $i++){?>
                            <option <?php  if($servico->despesa->id == $despesas[$i]->id){?> selected="selected" <?php  }?> value="<?php=$despesas[$i]->id?>">
                            <?php=$despesas[$i]->documento?>
                            </option>
                            <?php  }?>
                          </select></td>
		              </tr>
		              <tr>
					  	<td class="tabela1_linha2"  align="right"> Data da Prestação </td>						
						<td class="tabela1_linha2" ><script>DateInput('data_prestacao', true, 'YYYY-MM-DD', '<?php=$servico->data_prestacao?>')</script></td>
					  </tr>
					   <tr>
					    <td  align="right" class="tabela1_linha2">Situação</td>
				        <td  align="left" class="tabela1_linha2">Ativo
				          <input name="status" type="radio" value="1"  <?php  if ( $servico->status == 1) { ?> checked="checked" <?php  }?>/>
				            Inativo						
				            <input name="status" type="radio" value="0"   <?php  if ( $servico->status == 0) { ?>checked="checked"<?php  }?> /></td>
					  </tr>					
					  <tr>
					  	<td align="right" class="tabela1_linha2" colspan="2">&nbsp;</td> 
					  </tr>
					  <tr>
                        <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />                           
                            <input type="image" src="../images/enviar.jpg" /></div></td>
				      </tr>
                  </table>
			      </td>
                </tr>
              </table> 
			  <input type="hidden"  name="id" value="<?php=stripslashes($servico->id)?>" />
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
