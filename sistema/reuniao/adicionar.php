<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/participante.php");
require_once("../php/participanteDAO.php");
require_once("../php/atasreuniao.php");
require_once("../php/atasreuniaoDAO.php");
require_once("../php/membroscondominio.php");
require_once("../php/membroscondominioDAO.php");

@session_start();

$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}

//recolhendo variáveis
$conexao = new Conexao();
$conexao->conecta();
$id_condominio = $_SESSION['id_condominio'];
$atasreuniao = new atasreuniao();
$participante = new participante();
$membroscondominio = membroscondominioDAO::findAllByCond($id_condominio);

if(!permissoesDAO::temPermissao(7,2,$usuario->id_tipo_usuario)){ 
//verifica se o su possue permissão para inserir(2) no modulo(7)
		header("Location: ../index.php");
		exit();
	}
	
//verifica se os campos digitados não são vazios
if (isset($_POST['gravareuniao'])) {
	$atasreuniao->id_membroscondominio = addslashes($_POST['escriba']);
	$atasreuniao->id_condominio = $id_condominio;
	$atasreuniao->data_insercao = date("Y-m-d");
	$atasreuniao->data_realizacao = addslashes($_POST['data']);
	$atasreuniao->hora_inicio = addslashes($_POST['h1']).":".addslashes($_POST['m1']);
	$atasreuniao->hora_final = addslashes($_POST['h2']).":".addslashes($_POST['m2']);
	$atasreuniao->assunto = addslashes($_POST['assunto']);

 if ($_POST['h1'] > $_POST['h2'])  $msg = "/ Hora Inicial não pode ser maior que a final /";
 if ($_POST['escriba'] == "" ) $msg = $msg."/ Pelo menos um Escriba deve ser Selecionado /";
 if ($_POST['assunto'] == "" ) $msg = $msg."/ Um Assunto deve ser descrito /";
 if ($_POST['qtdpart'] == "" or $_POST['qtdpart'] == 0 ) $msg = $msg."/ Deve existir pelo menos um participante /";  
  
}

//função que grava a reunião e os seus participantes, caso todas as etapas já tenham sido feitas.
if (isset($_POST['gravapart'])) {	
	//verifica se o su possue permissão para alterar(1) em areas de custo(7)
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
 	/*Caso nenhum participante tenha sido escolhido, somente a reunião será gravada. Caso contrário,      os participantes também serao adicionados. */
	if ($qtdpart == 0) { 
	$id = atasreuniaoDAO::save($atasreuniao); 
	}
	//Conta-se quantos participantes irão ser escritos e a partir disso, comecam a ser escritos
     for ($i = 0; $i < $qtdpart; $i++) {
	  if ($i == 0) {
	   $id = atasreuniaoDAO::save($atasreuniao);  
	 //caso a reunião seja nova, o programa busca no banco qual foi o ultimo registro adicionado
      if ($atasreuniao->id == 0) {
	   $ida = atasreuniaoDAO::lastid(); } 
	    else {
	   $ida = $atasreuniao->id; } 	
	  }
	  //cria as variáveis das variáveis que contém a identificação do usuário (nome e função), assim        como foi criada nos dados cadastrais, adiciona nas variáveis e entao salva no banco.
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


//verifica se a pagina recebeu um id para alteração
if(isset($_GET['id'])){
	$atasreuniao = atasreuniaoDAO::findByPk($_GET['id']);
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
              <h1>REUNIÕES</h1></td>
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
					<?php  /* Caso a reunião já tenha sido cadasrtada ou o usuário tenha clicado no link para adicionar a ata de reuniao será mostrado o seguinte formulario de envio de arquivos que após enviado, será redirecionado para a pagina que adiciona uma ata especifica.*/
					 if (isset($_GET['ata'])) { ?>
					    <br />
					    </MM:DECORATION></MM_HIDDENREGION>
                </p>
                <form action="adicionarAta.php?ata=<?php=$ata?>" type="file" method="post" enctype="multipart/form-data">
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
                            <td colspan="2"  align="right" class="tabela1_linha2">Ata a ser enviada: </td>
                            <td width="70%"  align="right" class="tabela1_linha2"><div align="left">
                              <input name="arquivo" type="file" class="FormInputS" />
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="3"  align="right" class="tabela1_linha2"><div align="center"><br />
                                    <input name="gravaata" type="image" src="../images/enviar.jpg" value="bla"/>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                </form>
                <p>
                  <MM_HIDDENREGION><MM:DECORATION OUTLINE="Show%20If..." OUTLINEID=1><br /> 
                  <?php  } ?>
                  <?php  /* Caso não tenha sido selecionada uma ata para alteração, ou um aleta tenha sido identificado e não tenha se chegado uma ata para alteração, os dados de criação/alteração de uma determinada ata de reuniao será mostrado em tela.
				  */
				  if ((!isset($_POST['data']) or isset($msg)) && !isset($_GET['ata'])) { ?>
                </p>
                <form action="adicionar.php" method="post" >
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
                            <td class="tabela1_titulo2" colspan="2">obs: </td>
                          </tr>
                          <tr>
                            <td width="24%"  align="right" class="tabela1_linha2">Data da Reunião </td>
                            <td width="76%" class="tabela1_linha2" ><script>DateInput('data', true, 'YYYY-MM-DD', '<?php=$atasreuniao->data_realizacao?>')</script>                            </td>
                          </tr>
                          <tr>
                            <td class="tabela1_linha2"  align="right">Hora Inicial </td>
                            <td class="tabela1_linha2" ><select name="h1">
                                <?php  if (isset($_GET['id'])) { ?>
                                <option selected="selected" value="<?php=$atasreuniao->hora_inicio[0]?><?php=$atasreuniao->hora_inicio[1]?>"/><?php=$atasreuniao->hora_inicio[0]?><?php=$atasreuniao->hora_inicio[1]?></option>
                                <?php  } else {  
								/*funcao para mostrar as horas e minutos a serem escolhidos, em 													                                  intervalos de 1 em 1 hora e 5 em 5 minutos.*/
								?>
                                <option selected="selected" value="08">08</option>
                                <?php  } ?>
								<option value="">--</option>
								<?php  //escrita das horas ?>
                                <?php  for($i = 9; $i < 24; $i++){ ?>
                                <?php  if ($i < 10) { ?>
                                <option value="0<?php=$i?>">0<?php=$i?></option>
                                <?php  } else { ?>
                                <option value="<?php=$i?>"><?php=$i?></option>
                                <?php  } }?>
                              </select>
                              :
                              <select name="m1">
                                <?php  if (isset($_GET['id'])) { ?>
                                <option selected="selected" value="<?php=$atasreuniao->hora_inicio[3]?><?php=$atasreuniao->hora_inicio[4]?>"/><?php=$atasreuniao->hora_inicio[3]?><?php=$atasreuniao->hora_inicio[4]?></option>
                                <?php  } else { //escrita dos minutos?>
                                <option selected="selected" value="00">00</option>
                                <?php  } ?>
                                <option value="">--</option>
                                <?php  for($i = 5; $i <= 55; $i = $i+5){ ?>
                                <?php  if ($i == 5) { ?>
                                <option value="05">05</option>
                                <?php  } else  { ?>
                                <?php  if ($i < 10) { ?>
                                <option value="0<?php=$i?>">0<?php=$i?></option>
                                <?php  } else { ?>
                                <option value="<?php=$i?>"><?php=$i?></option>
                                <?php  } } } ?>
                              </select></td>
                          </tr>
                          <tr>
                            <td class="tabela1_linha2"  align="right">Hora Final </td>
                            <td class="tabela1_linha2" ><select name="h2">
                                <?php  if (isset($_GET['id'])) { ?>
                                <option selected="selected" value="<?php=$atasreuniao->hora_fim[0]?><?php=$atasreuniao->hora_fim[1]?>"/><?php=$atasreuniao->hora_fim[0]?><?php=$atasreuniao->hora_fim[1]?></option><?php  } else { ?>
                                <option selected="selected" value="08">08</option><?php  } ?>
                                <option value="">--</option>
                                <?php  for($i = 9; $i < 24; $i++){ ?>
                                <?php  if ($i < 10) { ?>
                                <option value="0<?php=$i?>">0<?php=$i?></option>
                                <?php  } else { ?>
                                <option value="<?php=$i?>"><?php=$i?></option>
                                <?php  } }?>
                              </select>
                              :
                              <select name="m2">
                                <?php  if (isset($_GET['id'])) { ?>
                                <option selected="selected" value="<?php=$atasreuniao->hora_fim[3]?><?php=$atasreuniao->hora_fim[4]?>"/><?php=$atasreuniao->hora_fim[3]?><?php=$atasreuniao->hora_fim[4]?></option>
                                <?php  } else { ?>
                                <option selected="selected" value="00">00</option>
                                <?php  } ?>
                                <option value="">--</option>
                                <?php  for($i = 5; $i <= 55; $i = $i+5){ ?>
                                <?php  if ($i == 5) { ?>
                                <option value="05">05</option>
                                <?php  } else  { ?>
                                <?php  if ($i < 10) { ?>
                                <option value="0<?php=$i?>">0<?php=$i?></option>
                                <?php  } else { ?>
                                <option value="<?php=$i?>"><?php=$i?></option>
                                <?php  } } } ?>
                              </select></td>
                          </tr>
                          <tr>
                            <td class="tabela1_linha2"  align="right">Assunto</td>
                            <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="assunto" size="30" maxlength="250" value="<?php=$atasreuniao->assunto?>" /></td>
                          </tr>
                          <tr>
                            <td class="tabela1_linha2"  align="right">Escriba</td>
                            <td class="tabela1_linha2" ><select name="escriba">
                               
							    <?php  /*o usuário cadastrante petença ao condomínio, ou  já tenha sido 		                                   escolhido um escriba anteriormente, o sistema seleciona o escriba                                   de acordo com a situação, caso contrario, é mostrado a opcao de                                   selecao. */ ?>
								<?php  if (isset($_GET['id'])) { ?>
                                <option selected="selected" value="<?php=$atasreuniao->id_membroscondominio?>"/>    
                                <?php=atasreuniaoDAO::findEscriba($atasreuniao->id, $atasreuniao->id_membroscondominio)?>
                                <?php  } else { ?>
                                <?php  if ($usuario->id_tipo_usuarios == 2 || $usuario->id_tipo_usuarios == 3 || $usuario->id_tipo_usuarios == 5 || $usuario->id_tipo_usuarios == 7){ ?>
                                <option selected="selected" value="<?php=$usuario->id?>">
                                <?php=$usuario->nome?>
                                </option>
                                <?php  } else { ?>
                                <option selected="selected" value=""> Selecionar </option>
                                <?php  } } ?>
                                <option value"">------------</option>
                                <?php  $escriba = membroscondominioDAO::findAllByCond($id_condominio); for ($i = 0; $i < sizeof(membroscondominioDAO::findAllByCond($id_condominio)); $i++){ ?>
                                <option value="<?php=$escriba[$i]->id?>">
                                <?php=$escriba[$i]->nome?>
                                </option>
                                <?php  } ?>
                            </select>
							
							</td>
                          </tr>
                          <tr>
				  <?php  //escolhe ou mostra a quantidade de participantes, dependendo da situacao ?>
                            <td class="tabela1_linha2"  align="right">Qtd. Participantes </td>
                            <td class="tabela1_linha2" ><select name="qtdpart">
                                <?php  if (isset($_GET['id'])) { ?>
                                <option selected="selected" value="0">
                                <?php=participanteDAO::countAllByAta($_GET['id'])?>
                                </option>
                                <option value="0">------</option>
                                <?php  for ($i = participanteDAO::countAllByAta($_GET['id']); $i < sizeof(membroscondominioDAO::findAllByCond($id_condominio)); $i++){ ?>
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
                                <?php 	   } } ?>
                                </option>
                            </select></td>
                          </tr>
						  <?php  if (isset($_GET['id'])) { ?>
                          <tr>
 						  <?php  // Caso o arquivo de ata ja tenha sido enviado, o sistema mostra o link                              para o mesmo, caso contrario, o sistema mostra um link para o envio do                               mesmo ?>
                            <td  align="right" class="tabela1_linha2">Ata</td>
							 <?php  if ($atasreuniao->nome_arquivo != ""){ ?>
                            <td  align="right" class="tabela1_linha2"><div align="left"><a href="atas/<?php=$id_condominio?>/<?php=$atasreuniao->nome_arquivo?>"> <?php  echo $atasreuniao->nome_arquivo; ?> </a></div></td></tr> <?php  } else { ?>
	 <td  align="right" class="tabela1_linha2"><div align="left"><a href="adicionar.php?ata=<?php=$id?>">Adicionar</a></div></td></tr>
							<?php  }} ?>
                          
                          <tr>
                            <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
                                    <input name="gravareuniao" type="image" src="../images/enviar.jpg" value="bla"/>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                <input type="hidden"  name="id" value="<?php=stripslashes($atasreuniao->id)?>" />
                </form>
              <?php  } else {  if (!isset($_GET['ata'])){ ?>
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
							<?php  //caso todos os membros do condomínio ja tenham sido adicionados, o                               sistema bloqueia a adicao de mais participantes. ?>
                              <?php  if($_POST['qtdpart'] == 0){?>
                              Limite Ultrapassado
                              <?php  } ?>
                            </td>
                          </tr>
                          <tr>
						  <?php  //exibe quantos campos forem necessários de acordo com a quantidade de                             participantes selecionada ?>
                            <?php  for ($i = 0; $i < $_POST['qtdpart']; $i++){ ?>
                            <td width="24%" rowspan="2"  align="right" class="tabela1_linha2">Participante</td>
                            <td width="38%" class="tabela1_linha2" >Nome: </td>
                            <td width="38%" class="tabela1_linha2" >Função: </td>
                          </tr>
                          <tr>
						  <?php  //ao se clicar sobre um campo de select, a pagina é atualizada, impedindo que um usuario seja cadastrado 2 vezes ?>
                            <td class="tabela1_linha2" ><select name="nome<?php=$i?>"  onchange="this.form.submit();">
                             <?php  $t = "nome" . "$i";?>
                             <?php  if ($$t != ""){   
							     if ($tt == ""){ 
								  $tt =  $$t; } else { 
								   $tt = $tt . ", " . $$t; }  
								    $membroscondominio = membroscondominioDAO::findAllByCond($id_condominio, $tt);?>
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
                  <input type="hidden"  name="h1" value="<?php=$h1?>"/>
                  <input type="hidden"  name="m1" value="<?php=$m1?>"/>
                  <input type="hidden"  name="h2" value="<?php=$h2?>"/>
                  <input type="hidden"  name="m2" value="<?php=$m2?>"/>
                  <input type="hidden"  name="assunto" value="<?php=$assunto?>"/>
                  <input type="hidden"  name="qtdpart" value="<?php=$qtdpart?>"/>
                </form>
              <?php  } } ?>
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
