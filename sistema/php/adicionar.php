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

@session_start();

$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();
$id_condominio = $_SESSION['id_condominio'];
$tiposusuarios = tiposusuariosDAO::findAll();
$tiposfuncionarios = tiposfuncionariosDAO::findAll();

if(!permissoesDAO::temPermissao(7,2,$usuario->id_tipo_usuario)){ //verifica se o su possue permissão para inserir(2) em area custo(30)
		header("Location: ../index.php");
		exit();
	}
//if (isset($_POST['tipo_destinatario'])) { echo $tipo_destinatario; die();}

/*
if (isset($_POST['gravapart'])) {	
	//verifica se o su possue permissão para alterar(1) em areas de custo(30)
	if(!permissoesDAO::temPermissao(7,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
//atribui o id ao objeto modulo
	$atasreuniao->id = addslashes($_POST['id']);
	//verifica se o id recebido aponta para um novo usuário(0) ou um antigo(!=0)
	if ($atasreuniao->id != 0){
    $atasreuniao = atasreuniaoDAO::findByPk($_POST['id']);}			
	$atasreuniao->id_membroscondominio = addslashes($_POST['escriba']);
	$atasreuniao->id_condominio = $id_condominio;
	$atasreuniao->data_insercao = date("Y-m-d");
	$atasreuniao->data_realizacao = addslashes($_POST['data']);
	$atasreuniao->hora_inicio = addslashes($_POST['h1']).":".addslashes($_POST['m1']);
	$atasreuniao->hora_final = addslashes($_POST['h2']).":".addslashes($_POST['m2']);
	$atasreuniao->assunto = addslashes($_POST['assunto']);
	$atasreuniao->nome_arquivo = "";
	
	if ($qtdpart == 0) { 
	$id = atasreuniaoDAO::save($atasreuniao); 
	}
     for ($i = 0; $i < $qtdpart; $i++) {
	  if ($i == 0) {
	  $id = atasreuniaoDAO::save($atasreuniao);  
      if ($atasreuniao->id == 0) {
	  $ida = atasreuniaoDAO::lastid(); } else {
	  $ida = $atasreuniao->id; } 	
	  }
	  $j = "nome" . "$i";
	  $k = "funcao" . "$i";
	  $participante->id_atas_reunioes = addslashes($ida);
	  $participante->id_membroscondominio = addslashes($$j);
	  $participante->funcao = addslashes($$k);
	  $id1 = participanteDAO::save($participante);
	} 
	
 
	
	header("Location: adicionar.php?ata=$ida");
	exit();	
 	
}  
*/

//verifica se a pagina recebeu um id para alteração

if(isset($_GET['id'])){
	$cs = criticas_sugestoesDAO::findByPk($_GET['id']);
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
              <h1>CRITICAS &amp; SUGESTÕES </h1></td>
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
                  
                </p>
                <form action="adicionar.php" method="post">
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
                            <td class="tabela1_titulo2" colspan="3">obs: </td>
                          </tr>
                          <tr>
                            <td width="27%"  align="right" class="tabela1_linha2">Tipo</td>
                            <td width="73" colspan="2" class="tabela1_linha2" >
							<select name="tipo"><?php  if (isset($_GET['id'])) { ?>
							<option selected="selected" value="<?php=$cs->tipo?>"><?php=$cs->tipo?></option><?php  } else {
							if(isset($_POST['tipo'])){ ?>
							<option selected="selected" value="<?php=$tipo?>"><?php=$tipo?></option><?php  } else { ?>
							<option selected="selected" value="">Selecionar</option><?php  } } ?>
                            <option value="">------------</option>
                            <option value="Critica">Critica</option>														
                            <option value="Sugestão">Sugestão</option>
							</select></td>
                          </tr>
                          <tr>
                            <td class="tabela1_linha2"  align="right">Mensagem</td>
                            <td colspan="2" class="tabela1_linha2" ><textarea name="descricao" cols="47" rows="10" class="FORMULARIO"><?php  if (isset($_GET['id'])){ ?><?php=$cs->nome?><?php  } else { if (isset($_POST['descricao'])){?><?php=$descricao?> <?php  } } ?></textarea></td>
                          </tr>
                          <tr>
                            <td class="tabela1_linha2"  align="right">Destinatário</td>
                            <td class="tabela1_linha2" ><select name="tipo_destinatario" onchange="this.form.submit();">
                                <?php  if (isset($_GET['id'])) { ?>
                                <option selected="selected" value="<?php=$cs->tipo_destinatario?>"><?php  
								$tdest = tiposusuariosDAO::findByPk($cs->tipo_destinatario); echo $tdest->nome; ?></option>
                                <?php  } else { if (isset($_POST['tipo_destinatario'])){ ?>
								<option selected="selected" value="<?php=$tipo_destinatario?>"><?php  $tdest = tiposusuariosDAO::findByPk($tipo_destinatario); echo $tdest->nome; ?> </option> <?php  } else { ?>
                                <option selected="selected" value="">Selecionar</option>
                                <?php  } } ?>
								<option value="">------------</option>
								<?php  for ($i = 0 ; $i < sizeof($tiposusuarios); $i++) { ?>
								 <?php  if (!isset($tdest->id)){ ?>                                
                                <option value="<?php=$tiposusuarios[$i]->id?>"><?php=$tiposusuarios[$i]->nome?></option>
								<?php   } else { if ($tdest->id != $tiposusuarios[$i]->id) { ?>
                                <option value="<?php=$tiposusuarios[$i]->id?>"><?php=$tiposusuarios[$i]->nome?></option> 
								<?php  } } } ?>
                                </select></td>
                            <td class="tabela1_linha2" >
							<?php  if (isset($tipo_destinatario)) $tdestaux = $tipo_destinatario; 
							if (isset($cs->tipo_destinatario)) $tdestaux = $cs->tipo_destinatario; ?>
							<?php  if (isset($tdestaux)){ ?>
							<select name="destinatario">
                              <?php  
							  switch ($tdestaux) {
								case 1:
								   if (isset($cs->destinatario)) $dest = superusuarioDAO::findByPk($cs->destinatario);
								   $usuarios = superusuarioDAO::findAll();
								   break;
								case 4:
								   if (isset($cs->destinatario)) $dest = funcionariosDAO::findByPk($cs->destinatario);
								   $usuarios = funcionariosDAO::findALLbyCond($id_condominio);
								   break;
								default:
								    if (isset($cs->destinatario)) $dest = membroscondominioDAO::findByPk($cs->destinatario);
									$usuarios = membroscondominioDAO::findALLbyCond($id_condominio,'',$tdestaux);
								   break;
								} ?>
								<?php  if (isset($dest)){ ?>
                              <option selected="selected" value="<?php=$dest->id?>"><?php=$dest->nome?></option>
                              <?php  } else { ?>
                              <option selected="selected" value="">Selecionar</option>
                              <?php  } ?>
                              <option value="">------------</option>
                              <?php  for ($i = 0 ; $i < sizeof($usuarios); $i++) { ?>
                               <option value="<?php=$usuarios[$i]->id?>"><?php=$usuarios[$i]->nome?></option>
                               <?php   } ?>
                            </select> <?php  } ?></td>
                          </tr>
                          <tr>
                            <td rowspan="2"  align="right" class="tabela1_linha2">Visualizadores<br />
                            (GRUPO)</td>
                            <td class="tabela1_linha2" ><div align="center">Membros do Condomínio </div></td>
                            <td class="tabela1_linha2" ><div align="center">Funcionários do Condomínio </div></td>
                          </tr>
                          <tr>
                            <td width="38%" valign="top" class="tabela1_linha2" ><div align="left">
                                <?php  for ($i = 0 ; $i < sizeof($tiposusuarios) ; $i ++){ ?>
                                <input type="checkbox" id="a" name="pau<?php=$i?>" value="<?php=$tiposusuarios[$i]->id?>" />
                                <?php=$tiposusuarios[$i]->nome?>
                                <br />
                                <?php  } ?>
                                <br />
                            </div></td>
                            <td width="38%" valign="top" class="tabela1_linha2" ><div align="left">
                                <?php  for ($i = 0 ; $i < sizeof($tiposfuncionarios); $i ++){ ?>
                                <input type="checkbox" id="pa" name="paf<?php=$i?>" value="<?php=$tiposfuncionarios[$i]->id?>" />
                                <?php=$tiposfuncionarios[$i]->nome?>
                                <br />
                                <?php  } ?>
                                <br />
                            </div></td>
                          </tr>
	
                          
                          <tr>
                            <td colspan="3"  align="right" class="tabela1_linha2"><div align="center"><br />
                                    <input name="gravareuniao" type="image" src="../images/enviar.jpg" value="bla"/>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                <input type="hidden"  name="id" value="<?php=stripslashes($cs->id)?>"/>
               
                </form>
                <form name="part" action="adicionar.php" method="post" onsubmit="javascript:return confirmaReunioes(this)">
                  <p>&nbsp;</p>
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
                              <?php  if($_POST['qtdpart'] == 0){?>
                              Limite Ultrapassado
                              <?php  } ?>
                            </td>
                          </tr>
                          <tr>
                            <?php  for ($i = 0; $i < $_POST['qtdpart']; $i++){ ?>
                            <td width="24%" rowspan="2"  align="right" class="tabela1_linha2">Participante</td>
                            <td width="38%" class="tabela1_linha2" >Nome: </td>
                            <td width="38%" class="tabela1_linha2" >Função: </td>
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
                                <option value="Ouvinte">Ouvinte</option>
                                <option value="Presidente">Presidente</option>
                                <option value="Secretário">Secretário</option>
                            </select></td>
                          </tr>
                          <?php  } ?>
                          <tr>
                            <td colspan="3"  align="right" class="tabela1_linha2"><div align="center"><br />
                                    <input name="gravapart" type="image" src="../images/enviar.jpg" value="bla"/>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                  <input type="hidden"  name="id" value="<?php=$id?>"/>
                  <input type="hidden"  name="escriba" value="<?php=$escriba?>"/>
                  <input type="hidden"  name="data" value="<?php=$data?>"/>
                  <input type="hidden"  name="assunto" value="<?php=$assunto?>"/>
                  <input type="hidden"  name="qtdpart" value="<?php=$qtdpart?>"/>
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
</body>
</html>
