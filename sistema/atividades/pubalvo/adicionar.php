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
require_once("../../php/membroscondominio.php");
require_once("../../php/membroscondominioDAO.php");

@session_start();

$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();
$id_condominio = 1; //substituir por $id_condominio = $_SESSION['id_condominio'];
$atividades = new atividades();
$publico_alvo = new publico_alvo();
$membroscondominio = membroscondominioDAO::findAllByCond($id_condominio);

if (isset($_POST['gravapart'])) {	
	//verifica se o su possue permissão para alterar(1) em areas de custo(30)
	if(!permissoesDAO::temPermissao(7,1,$usuario->id_tipo_usuario)){	
		header("Location: ../../index.php");
		exit();
	}		
	

    for ($i = 0; $i < $qtdpalv; $i++) {
	  $ida = $_POST['id']; 	
	  $j = "nome" . "$i";
	  $k = "funcao" . "$i";
	  $publico_alvo->id_atividades = addslashes($ida);
	  $publico_alvo->id_membroscondominio = addslashes($$j);
	  $publico_alvo->compareceu = addslashes($$k);
	  $id1 = publico_alvoDAO::save($publico_alvo);
	} 
	
 
	
header("Location: home.php?atv=$id");
exit();	
 	
}  


//verifica se a pagina recebeu um id para alteração
if(isset($_GET['id'])){
	$atividades = atividadesDAO::findByPk($_GET['id']);
	$ep = 0;
}else{
	//verifica se o su possue permissão para inserir(2) em area custo(30)
	if(!permissoesDAO::temPermissao(7,2,$usuario->id_tipo_usuario)){
		header("Location: ../../index.php");
		exit();
	}
}

$pontinhos = "../../";
$j = 1;
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
<script language="javascript" type="text/javascript" src="../../js/funcoes.js" charset="iso-8859-1">
</script>
<script language="javascript" type="text/javascript" src="../../js/calendario.js">
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
                  <td valign="top" background="images/topo_espaco.jpg"><a href="home.php?atv=<?php=$id?>"><img src="../../images/botao_listar_off.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
                  <td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"></a></td>
                  <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../../images/botao_cadastrar.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                  <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                  <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php?atv=<?php=$id?>"><img src="../../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
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
                <p> <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <?php  if (!isset($_POST['qtdpalv'])) { ?>
                </p>
              <form action="adicionar.php" method="post">
                <div align="center"> 
                  <p><font class="warning">
                    <?php  if(isset($msg) )
						echo $msg;?>
                    </font> <br />
                    <br />
                    CONDOMÍNIO -&gt; <strong>
                    <?php=$condominio->nome?>
                      </strong></p>
                  <p>&nbsp;</p>
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
                            <td class="tabela1_titulo2" colspan="2">obs: </td>
                          </tr>
                          <tr>
                            <td width="24%"  align="right" class="tabela1_linha2">Qtd. Participantes </td>
                            <td width="76%" class="tabela1_linha2" ><select name="qtdpalv">
                              <?php  if (isset($_GET['id'])) { ?>
                              <option selected="selected" value="0">
                              <?php=publico_alvoDAO::countAllByAtv($_GET['id'])?>
                              </option>
                              <option value="">------</option>
                              <?php  for ($i = publico_alvoDAO::countAllByAtv($_GET['id']); $i < sizeof(membroscondominioDAO::findAllByCond($id_condominio)); $i++){ ?>
                              <?php  if ($i+2 <= membroscondominioDAO::findAllByCond($id_condominio)){?>
                              <option value="<?php=$j?>"> +
                                <?php=$j?>
                              </option>
                              <?php   $j++;  } }  } else { ?>
                              <option selected="selected" value=""> Selecionar </option>
                              <option>------</option>
                              <?php  for ($i = 0; $i < sizeof(membroscondominioDAO::findAllByCond($id_condominio)); $i++){ ?>
                              <option value="<?php=$i+1?>">
                              <?php=$i+1?>
                              <?php   } } ?>
                              </option>
                            </select></td>
                          </tr>
                          <tr>
                            <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
                                    <input name="gravareuniao" type="image" src="../../images/enviar.jpg" value="bla"/>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
                <input type="hidden"  name="id" value="<?php=stripslashes($atividades->id)?>" />
              </form>
              <?php  } else {   ?>
                <?php  if(isset($msg) )
						echo $msg; ?>
                <form name="part" action="adicionar.php" method="post" onsubmit="javascript:return confirmaReunioes(this)">
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
                            <td class="tabela1_titulo2" colspan="3">obs:
                              <?php  if($_POST['qtdpalv'] == 0){?>
                              Limite Ultrapassado
                              <?php  } ?>
                            </td>
                          </tr>
                          <tr>
                            <?php  for ($i = 0; $i < $_POST['qtdpalv']; $i++){ ?>
                            <td width="24%" rowspan="2"  align="right" class="tabela1_linha2">Participante</td>
                            <td width="38%" class="tabela1_linha2" >Nome: </td>
                            <td width="38%" class="tabela1_linha2" >Compareceu: </td>
                          </tr>
                          <tr>
                            <td class="tabela1_linha2" ><select name="nome<?php=$i?>"  onchange="this.form.submit();">
                                <?php  $t = "nome" . "$i";?>
                                <?php  if ($$t != ""){   if ($tt == ""){ $tt =  $$t; } else { $tt = $tt . ", " . $$t; }  ;  $membroscondominio = membroscondominioDAO::findAllByCond($id_condominio, $tt); ?>
                                <option selected="selected" value="<?php=$$t?>">
                                <?php=membroscondominioDAO::returnNome($$t)?>
                                </option>
                                <?php  } else { ?>
                                <option selected="selected" value=""> Selecionar </option>
                                <?php  } ?>
                                <option value="">------------</option>
                                <?php  for ($j = 0; $j < sizeof($membroscondominio); $j++){ ?>
                                <option value="<?php=$membroscondominio[$j]->id?>">
                                <?php=$membroscondominio[$j]->nome?>
                                </option>
                                <?php  } ?>
                              </select>
                            </td>
                            <td width="38%" class="tabela1_linha2" ><select name="funcao<?php=$i?>">
                                <?php  $t = "funcao" . "$i";?>
                                <?php  if($$t != "") { ?>
                                <option selected="selected" value="<?php=$$t?>">
                                <?php=$$t?>
                                </option>
                                <?php  } else { ?>
                                <option selected="selected" value=""> Selecionar </option>
                                <?php  } ?>
                                <option>------------</option>
                                <option value="2">Sem Informação</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select></td>
                          </tr>
                          <?php  } ?>
                          <tr>
                            <td colspan="3"  align="right" class="tabela1_linha2"><div align="center"><br />
                                    <input name="gravapart" type="image" src="../../images/enviar.jpg" value="bla"/>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                  <input type="hidden"  name="id" value="<?php=$id?>"/>
                  <input type="hidden"  name="qtdpalv" value="<?php=$qtdpalv?>"/>
                </form>
              <?php  } ?>
                <br />
                <p></p></td>
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
</body>
</html>
