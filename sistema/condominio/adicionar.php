<?php 
require_once("../php/conexao.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/contatos.php");
require_once("../php/contatosDAO.php");
require_once("../php/membroscondominio.php");
require_once("../php/membroscondominioDAO.php");
require_once("../php/ftp.php");

@session_start();

$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();
$ftp = new Ftp();
 
$condominios = new condominios();

$superusuarios = superusuarioDAO::findAll();
$contatos = contatosDAO::findAll();	

if ((isset($_POST['nome']))) {
	
	//verifica se o su possue permissão para alterar(1) em areas de custo(30)
	if(!permissoesDAO::temPermissao(18,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	} 
	
	//atribuições iniciais
	$condominios->nome = addslashes($_POST['nome']);
	$condominios->cnpj = addslashes($_POST['cnpj']);
	$condominios->tipo_logradouro = addslashes($_POST['tipo_logradouro']);
	$condominios->logradouro = addslashes($_POST['logradouro']);
	$condominios->numero_logradouro = addslashes($_POST['numero_logradouro']);
	$condominios->bairro_logradouro = addslashes($_POST['bairro_logradouro']);
	$condominios->cep_logradouro = addslashes($_POST['cep_logradouro']);
	$condominios->cidade_logradouro = addslashes($_POST['cidade_logradouro']);
	$condominios->uf_logradouro = addslashes($_POST['uf_logradouro']);
	$condominios->qtd_blocos = addslashes($_POST['qtd_blocos']);
	$condominios->qtd_apartamentos = addslashes($_POST['qtd_apartamentos']);
	$condominios->telefone = addslashes($_POST['telefone']);
	$condominios->id_contato = addslashes($_POST['cont']);
	$condominios->id_responsavel = addslashes($_POST['resp']);
	$condominios->status = addslashes($_POST['status']);


	//verifica se eh vazio
	if ($_POST['qtd_apartamentos'] == "" ){ $msg = "A quantidade de apartamentos é um campo de preenchimento obrigatório";}
	if ($_POST['telefone'] == "" ){ $msg = "O telefone do condomínio é um campo de preenchimento obrigatório"; }
	if ($_POST['uf_logradouro'] == "" ){ $msg = "A UF não foi digitada corretamente"; }
	if ($_POST['cidade_logradouro'] == "" ){ $msg = "A cidade não foi digitada corretamente"; }
	if ($_POST['cep_logradouro'] == "" ){ $msg = "O CEP não foi digitado corretamente"; }
	if ($_POST['bairro_logradouro'] == "" ){ $msg = "O bairro não foi digitado corretamente"; }
	if ($_POST['numero_logradouro'] == "" ){ $msg = "O número não foi digitado corretamente"; }
	if ($_POST['logradouro'] == "" ){ $msg = "O logradouro não foi digitado corretamente"; }
	if ($_POST['tipo_logradouro'] == "" ){ $msg = "O tipo de logradouro não foi digitado corretamente"; }
	if ($_POST['cnpj'] == "" ) { $msg = "O CNPJ do condomínio é um campo obrigatório"; }
	if ($_POST['nome'] == "" ) { $msg = "O nome do condomínio não foi digitado corretamente"; }
	
	 
   	if($msg == ""){
	
	//atribui o id ao objeto modulo
	$condominios->id = addslashes($_POST['id']);
	
	//verifica se o id recebido aponta para um novo usuário(0) ou um antigo(!=0)
	if ($condominios->id != ""){
		$condominios = condominiosDAO::findByPk($condominios->id); 
	}
	$condominios->nome = addslashes($_POST['nome']);
    $condominios->cnpj = addslashes($_POST['cnpj']);
    $condominios->tipo_logradouro = addslashes($_POST['tipo_logradouro']);
    $condominios->logradouro = addslashes($_POST['logradouro']);
    $condominios->numero_logradouro = addslashes($_POST['numero_logradouro']);
    $condominios->bairro_logradouro = addslashes($_POST['bairro_logradouro']);
    $condominios->cep_logradouro = addslashes($_POST['cep_logradouro']);
    $condominios->cidade_logradouro = addslashes($_POST['cidade_logradouro']);
    $condominios->uf_logradouro = addslashes($_POST['uf_logradouro']);
    $condominios->qtd_blocos = addslashes($_POST['qtd_blocos']);
    $condominios->qtd_apartamentos = addslashes($_POST['qtd_apartamentos']);
	$condominios->telefone = addslashes($_POST['telefone']);
    $condominios->id_contato = addslashes($_POST['cont']);
	$condominios->id_responsavel = addslashes($_POST['resp']);
    $condominios->status = addslashes($_POST['status']);
	$condominios->data_criacao = date("Y-m-d H:i:s", time());
	$id = condominiosDAO::save($condominios);
	$ftp->criaDirCond(condominiosDAO::lastID());
	header("Location: home.php");
	exit(); 
	}

}

//verifica se a pagina recebeu um id para alteração
if(isset($_GET['id'])){
	$condominios = condominiosDAO::findByPk($_GET['id']);
	$superusuario = superusuarioDAO::findResp($condominios->id_responsavel);
	$contato = contatosDAO::findByPk($condominios->id_contato);
	$ep = 0; 
}else{
	//verifica se o su possue permissão para inserir(2) em area custo(30)
	if(!permissoesDAO::temPermissao(18,2,$usuario->id_tipo_usuario)){
		header("Location: ../index.php");
		exit();
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

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
				<td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"><img src="../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>CONDOM&Iacute;NIOS</h1></td>
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
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaCondominio(this)" nome="condominios" numero="condominios">
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
                        <td width="89%" class="tabela1_titulo1">Dados Cadastrais</td>                       
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
                      <tr>
                        <td class="tabela1_titulo2" colspan="3"> obs: Todos os Campos S&atilde;o Obrigat&oacute;rios </td>
                      </tr> 
                      <tr> 
					  	<td class="tabela1_linha2"  align="right"> Nome</td>
						<td colspan="2" class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nome" size="30" maxlength="30" value="<?php=$condominios->nome?>"></td>
					  </tr>
					  <tr>
                        <td  align="right" class="tabela1_linha2"> CNPJ </td>
					    <td colspan="2" class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="cnpj" size="18" maxlength="18" value="<?php=$condominios->CNPJ?>" onkeydown="FormataCNPJ(this,event)" onKeyPress="return Numero(event);"  /></td>
					  </tr>
					  <tr>
					    <td rowspan="7"  align="right" class="tabela1_linha2">Endere&ccedil;o</td>
					    <td class="tabela1_linha2" ><div align="right">Tipo Logradouro: </div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="tipo_logradouro" size="30" maxlength="30" value="<?php=$condominios->tipo_logradouro?>"/>
				      </p>				        </td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Logradouro: </div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="logradouro" size="30" maxlength="30" value="<?php=$condominios->logradouro?>" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Numero:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="numero_logradouro" size="30" maxlength="30" value="<?php=$condominios->numero_logradouro?>" onKeyPress="return Numero(event);"/></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Bairro:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="bairro_logradouro" size="30" maxlength="30" value="<?php=$condominios->bairro_logradouro?>" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Cep:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="cep_logradouro" size="30" maxlength="30" value="<?php=$condominios->cep_logradouro?>" onKeyPress="return Numero(event);" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Cidade:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="cidade_logradouro" size="30" maxlength="30" value="<?php=$condominios->cidade_logradouro?>" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Estado:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="uf_logradouro" size="30" maxlength="30" value="<?php=$condominios->uf_logradouro?>" /></td>
					  </tr>
					  <tr>
                        <td  align="right" class="tabela1_linha2">
                          <div align="right">QTD Blocos<br />
                        </div></td>
				      <td colspan="2"  align="right" class="tabela1_linha2">
				        <div align="left">
				          <input type="text" class="FORMULARIO"  name="qtd_blocos" size="30" maxlength="30" value="<?php=$condominios->qtd_blocos?>" onKeyPress="return Numero(event);" />
			            </div></td>
			          </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2"><div align="right">QTD Apartamentos</div></td>
				      <td colspan="2"  align="right" class="tabela1_linha2">
				        <div align="left">
				          <input type="text" class="FORMULARIO"  name="qtd_apartamentos" size="30" maxlength="30" value="<?php=$condominios->qtd_apartamentos?>" onKeyPress="return Numero(event);" />
			            </div></td>
			          </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2">Nome Contato</td>
				      <td colspan="2"  align="right" class="tabela1_linha2">
				        <div align="left">
				        <select name="cont"> 
						   <option selected value="<?php=$contato->id?>"><?php=$contato->nome?></option> <option>----------------</option> 
						   <?php  for ($i = 0; $i < sizeof($contatos); $i++){ ?>
						     <option value="<?php=$contatos[$i]->id?>"><?php=$contatos[$i]->nome?></option> <?php  } ?>   </select>
			            </div></td>
			          </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2">Telefone</td>
					    <td colspan="2"  align="right" class="tabela1_linha2"><div align="left">
					      <input type="text" class="FORMULARIO"  name="telefone" value="<?php=$condominios->telefone?>" size="14" maxlength="14" onkeydown="FormataTEL(this,event)" onKeyPress="return Numero(event);"/>
				        </div></td>
				      </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2">Responsável</td>
				      <td colspan="2"  align="right" class="tabela1_linha2"><div align="left">
                       <select name="resp"> 
		    		      <option selected value="<?php=$superusuario->id?>"><?php=$superusuario->nome?></option>
						  <option>------------------------</option>
                          <?php  for ($i = 0; $i < sizeof($superusuarios); $i++){ ?>
			               <option value="<?php=$superusuarios[$i]->id?>"><?php=$superusuarios[$i]->nome?></option> <?php  } ?>
            </select>
				        </div></td>
			          </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2">Situação</td>
				        <td colspan="2"  align="right" class="tabela1_linha2"><label>
				          <div align="left">Ativo
						 
				            <input name="status" type="radio" value="1"  <?php  if ( $condominios->status == 1) { ?> checked="checked" <?php  }?>/>
				            Inativo						
				            <input name="status" type="radio" value="0"   <?php  if ( $condominios->status == 0) { ?>checked="checked"<?php  }?> />
				         </div>
				        </label></td>
			          </tr>
					  <tr>
					    <td colspan="3"  align="right" class="tabela1_linha2"><div align="center">
					      <input name="image" type="image" src="../images/enviar.jpg" />
				        </div></td>
				      </tr>
                  </table>
			      </td>
                </tr>
              </table> 			  
			  
			   <input type="hidden"  name="id" value="<?php=stripslashes($id)?>" />
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
