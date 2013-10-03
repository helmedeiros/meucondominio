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
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();
$id_condominio = $_SESSION['id_condominio'];
$regimentos = new regimentos();
 
if(!permissoesDAO::temPermissao(7,2,$usuario->id_tipo_usuario)){ //verifica se o su possue permissão para inserir(2) em area custo(30)
		header("Location: ../index.php");
		exit();
	}

if (isset($_POST['gravaregimento'])) {
 if ($_POST['regimento'] == "" ){ $msg = $msg."/ A descrição deve ser completa /";
        header("Location: adicionar.php");
		exit(); 
		}
		
	//verifica se o su possue permissão para alterar(1) em areas de custo(30)
	if(!permissoesDAO::temPermissao(7,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
//atribui o id ao objeto modulo
	$regimentos->id = addslashes($_POST['id']);
	//verifica se o id recebido aponta para um novo usuário(0) ou um antigo(!=0)
	if ($regimentos->id != 0){
    $regimentos = regimentosDAO::findByPk($_POST['id']);}			
	$regimentos->data_envio = addslashes($_POST['data']);
	$regimentos->id_condominio = $id_condominio;
	$regimentos->regimento = addslashes($_POST['regimento']);
	$regimentos->nome_arquivo = "";
	
	$id = regimentosDAO::save($regimentos); 
	$lid = regimentosDAO::lastid();
	
	header("Location: adicionar.php?reg=$lid");
	exit();	
 	
}  


//verifica se a pagina recebeu um id para alteração
if(isset($_GET['id'])){
	$regimentos = regimentosDAO::findByPk($_GET['id']);
	$ep = 0;
}else{
	

}
$condominio = condominiosDAO::findByPk($id_condominio);
$pontinhos = "../";
$j = 1;
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
                  <td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"><img src="../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
                  <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
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
                <p align="center"> <br />
                    <br />
                    CONDOMÍNIO -&gt; <strong>
                    <?php=$condominio->nome?>
                    </strong><br />
                    <br />
                    <br />
                    <br />
					<?php  if (isset($_GET['reg'])) { ?>
					    <br />
					    </MM:DECORATION></MM_HIDDENREGION>
                </p>
                <form action="adicionarReg.php?reg=<?php=$reg?>" type="file" method="post" enctype="multipart/form-data">
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
                            <td class="tabela1_titulo2" colspan="3">obs: Enviar arquivo em formato DOC ou PDF. </td>
                          </tr>
                          <tr>
                            <td colspan="2"  align="right" class="tabela1_linha2">Arquivo do Regimento </td>
                            <td width="70%"  align="right" class="tabela1_linha2"><div align="left">
                              <input name="arquivo" type="file" class="FormInputS" />
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="3"  align="right" class="tabela1_linha2"><div align="center"><br />
                                    <input name="gravareg" type="image" src="../images/enviar.jpg" value="bla"/>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                </form>
				<?php  } ?>
                <p>
                  <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=1><br /> 
                    
                    
                    
                  
                  <?php  if ((!isset($_POST['data']) or isset($msg)) && !isset($_GET['reg'])) { ?>
                </p>
                <form action="adicionar.php" method="post" onSubmit="javascript:return confirmaRegimento(this)"
>
                  <div align="center"> <font class="warning">
                    <?php  if(isset($msg) )
						echo $msg;?>
                    </font> <br />
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
                          <td class="tabela1_titulo2" colspan="2">obs: Enviar arquivo em formato DOC ou PDF. </td>
                        </tr>
                        <tr>
                          <td width="28%"  align="right" class="tabela1_linha2">Data do Regimento </td>
                          <td width="72%" class="tabela1_linha2" ><script>DateInput('data', true, 'YYYY-MM-DD', '<?php=$regimentos->data_envio?>')</script>                          </td>
                        </tr>
                        <tr>
                          <td class="tabela1_linha2"  align="right">Descrição</td>
                          <td class="tabela1_linha2" ><textarea name="regimento" cols="47" rows="5" class="FORMULARIO" ><?php=$regimentos->regimento?></textarea></td>
                        </tr>
						
                       

                        <?php  if (isset($_GET['id'])) { ?>
 <tr>                           
                          <td class="tabela1_linha2"  align="right">Visualizar Regimento </td>
						  <?php  if ($regimentos->nome_arquivo != '') { ?>
                          <td class="tabela1_linha2" ><a href="arquivos/<?php=$id_condominio?>/<?php=$regimentos->nome_arquivo?>"><?php=$regimentos->nome_arquivo?></a></td></tr> <?php  } else { ?><td class="tabela1_linha2" ><a href="adicionar.php?reg=<?php=$id?>">Adicionar</a></td></tr>   
						  
                        <?php  } } ?>
                      <?php  if (isset($_GET['id'])) { ?>
                        <tr>
                          <td  align="right" class="tabela1_linha2">Aditivos</td>
                          <td  align="right" class="tabela1_linha2"><div align="left"><a href="aditivos/home.php?reg=<?php=$id?>">Visualizar</a></div></td>
                        </tr>
						<?php  } ?>
                        <tr>
    <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
            <input name="gravaregimento" type="image" src="../images/enviar.jpg" value="bla"/>
    </div></td>
  </tr>
  
                     </table></td>
                    </tr>
                  </table>
				 <?php  } ?>  
                <input type="hidden"  name="id" value="<?php=stripslashes($regimentos->id)?>" />
                </form>
                <form name="part" action="adicionar.php" method="post" onsubmit="javascript:return confirmaReunioes(this)">
                  <input type="hidden"  name="id" value="<?php=$id?>"/>
                  <input type="hidden"  name="regimento" value="<?php=$regimento?>"/>
                  <input type="hidden"  name="data" value="<?php=$data?>"/>
                </form>
          
                <br />
            <p></p></td>
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
<blockquote>&nbsp;</blockquote>
</body>
</html>
