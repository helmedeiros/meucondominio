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
require_once("../php/informativos.php");
require_once("../php/informativosDAO.php");
require_once("../php/destinatarios_visualizadores.php");
require_once("../php/destinatarios_visualizadoresDAO.php");
require_once("../php/email.php");

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
$membroscondominio = membroscondominioDAO::findALLbyCond($id_condominio);
$criticas_sugestoes = new criticas_sugestoes();
$dias = array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb");

if(!permissoesDAO::temPermissao(7,2,$usuario->id_tipo_usuario)){ //verifica se o su possue permissão para inserir(2) em area custo(30)
		header("Location: ../index.php");
		exit();
	}


if(isset($_POST['enviadados'])){ 
 if ($tipo == "") $msg = " \ A seleção do tipo é Obrigatória \ ";
 if ($descricao == "") $msg = " \ O Campo de Mensagem deve ser cadastrado  \ ";
 if ($tipo_destinatario == "") $msg = " \ A seleção do tipo de destinatário é obrigatória  \ ";
 if ($destinatario == "") $msg = " \ A seleção do destinatário é obrigatória  \ ";
 }

if(isset($_POST['svinfo'])) {
   $cs = criticas_sugestoesDAO::findByPk($_POST['id']);
   if( $_POST['fim'] == "0") {
   $informativos = new informativos();
   $informativos->id_criticas_sugestoes = addslashes($_POST['id']);
   $informativos->descricao = addslashes($_POST['informativo']);
   $informativos->data =  date('Y-m-d',time());
   $inf = informativosDAO::save($informativos);
   $cs->status = "Em Processamento";
   $inf = criticas_sugestoesDAO::save($cs);
   	                switch ($cs->tipo_remetente) {
								case 1:
								   $mail = superusuarioDAO::findByPk($cs->id_membroscondominio);
								   break;
								case 4:
								   $mail = funcionariosDAO::findByPk($cs->id_membroscondominio);
								   break;
								default:
								   $mail = membroscondominioDAO::findByPk($cs->id_membroscondominio);
								   break;
	}
	 $id4 = email::sendMail(' Criticas & Sugestoes - MeuCondominio.net ', ' Um novo informativo foi adicionado a sua'.$cs->tipo.' Para a descrição completa, verifique o módulo correspondente através do site',$mail->email); 
  	header("Location: adicionar.php?id=$id&opt=$opt");
		exit();
   }  else {
   $cs = criticas_sugestoesDAO::findByPk($_POST['id']);
   $cs->status = "Finalizada";
   $cs->resolucao = addslashes($_POST['informativo']);
   $cs->data_resolucao = date('Y-m-d',time());
             switch ($cs->tipo_remetente) {
								case 1:
								   $mail = superusuarioDAO::findByPk($cs->id_membroscondominio);
								   break;
								case 4:
								   $mail = funcionariosDAO::findByPk($cs->id_membroscondominio);
								   break;
								default:
								   $mail = membroscondominioDAO::findByPk($cs->id_membroscondominio);
								   break;
	}
   $inf = criticas_sugestoesDAO::save($cs);
	 $id4 = email::sendMail(' Criticas & Sugestoes - MeuCondominio.net ', ' A sua'.$cs->tipo.' já foi concluída. Para a descrição completa, verifique o módulo correspondente através do site',$mail->email); 
	 header("Location: home.php?opt=$opt");
		exit();
 }
 
}

if (isset($_POST['gravacrit_sug']) or (isset($_POST['id']) && $_POST['id'] != "" && (!isset($_POST['addinfo']))) ) {	
	//verifica se o su possue permissão para alterar(1) em areas de custo(30)
	if(!permissoesDAO::temPermissao(7,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
//atribui o id ao objeto modulo
	$criticas_sugestoes->id = addslashes($_POST['id']);
	//verifica se o id recebido aponta para um novo usuário(0) ou um antigo(!=0)
	if ($criticas_sugestoes->id != 0){
    $criticas_sugestoes = criticas_sugestoesDAO::findByPk($_POST['id']);}			
		$criticas_sugestoes->id_membroscondominio = addslashes($usuario->id);
		$criticas_sugestoes->id_prioridade = addslashes($_POST['prioridade']);
		$criticas_sugestoes->data_envio = date('Y-m-d',time());
		$criticas_sugestoes->mensagem = addslashes($_POST['descricao']);
		$criticas_sugestoes->status = 'Em Aberto';
		$criticas_sugestoes->visualizacao = '';
		$criticas_sugestoes->destinatario = addslashes($_POST['destinatario']);
		$criticas_sugestoes->tipo = addslashes($_POST['tipo']);
		$criticas_sugestoes->data_recebimento = addslashes($_POST['data_recebimento']);
		$criticas_sugestoes->data_resolucao = addslashes($_POST['data_envio']);
		$criticas_sugestoes->tipo_destinatario = addslashes($_POST['tipo_destinatario']);
		$criticas_sugestoes->tipo_remetente = addslashes($usuario->id_tipo_usuario);		
        $go = criticas_sugestoesDAO::save($criticas_sugestoes);
        $lid = criticas_sugestoesDAO::lastId();
				    switch ($_POST['tipo_destinatario']) {
								case 1:
								   $mail = superusuarioDAO::findByPk($_POST['destinatario']);
								   break;
								case 4:
								   $mail = funcionariosDAO::findByPk($_POST['destinatario']);
								   break;
								default:
								   $mail = membroscondominioDAO::findByPk($_POST['destinatario']);
								   break;
	}
	 $id4 = email::sendMail(' Criticas & Sugestoes - MeuCondominio.net ', ' O usuário '.$usuario->nome.' lhe enviou uma '.$criticas_sugestoes->tipo.'. Para a descrição completa, verifique o módulo correspondente através do site',$mail->email); 

	for ($i = 1 ; $i < sizeof($tiposusuarios) ; $i++) {
	                   switch ($i) {
								case 1:
								   $totalMembros = superusuarioDAO::countAll();
								   break;
								case 4:
								   $totalMembros = sizeof($usuarios = funcionariosDAO::findALLbyCond($id_condominio));
								    break;
								default:
								  $totalMembros = sizeof(membroscondominioDAO::findALLbyCond($id_condominio,'',$$aux));
								   break; }

	 for ($j = 0 ; $j < $totalMembros ; $j++) {
	 		if (isset($mbr_[$i][$j])) {
			 $d_v = new destinatarios_visualizadores();
			 $d_v->id_criticas_sugestoes = $lid;
			 $d_v->id_tipo_usuario = $i;
			 $d_v->id_membro_condominio = $mbr_[$i][$j];
			    switch ($i) {
								case 1:
								   $mail = superusuarioDAO::findByPk($mbr_[$i][$j]);
								   break;
								case 4:
								   $mail = funcionariosDAO::findByPk($mbr_[$i][$j]);
								   break;
								default:
								   $mail = membroscondominioDAO::findByPk($mbr_[$i][$j]);
								   break;
                         	}   
				 $okgo = destinatarios_visualizadoresDAO::saveUsr($d_v);
				 $id4 = email::sendMail(' Criticas & Sugestoes - MeuCondominio.net ', ' Você recebeu o direito de visualização em uma '.$criticas_sugestoes->tipo.'. Para a descrição completa, verifique o módulo correspondente através do site',$mail->email); 
			  }
	      }
		  
		     
			    } 
			for ($i = 1 ; $i <= sizeof($tiposfuncionarios) ; $i++) {
		   $totalMembros = sizeof(funcionariosDAO::findALLbyCond($id_condominio,'',$i));
              for ($j = 0 ; $j < $totalMembros ; $j++) {
			  $d_v = new destinatarios_visualizadores();
			  $d_v->id_criticas_sugestoes = $lid;
              $d_v->id_tipo_funcionario = $i;
              $d_v->id_funcionario_condominio = $fnc_[$i][$j]; 
			  $mail = funcionariosDAO::findByPk($fnc_[$i][$j]);
			  $okgo = destinatarios_visualizadoresDAO::saveFnc($d_v);	   		  
			  			  $id4 = email::sendMail(' Criticas & Sugestoes - MeuCondominio.net ', ' Você recebeu o direito de visualização em uma '.$criticas_sugestoes->tipo.'. Para a descrição completa, verifique o módulo correspondente através do site',$mail->email);
		  }
	    }
	  
	
	
	header("Location: home.php?opt=1");
	exit();	
 	
}  


//verifica se a pagina recebeu um id para alteração

if(isset($_GET['id'])){
  	$cs = criticas_sugestoesDAO::findByPk($_GET['id']);
	$informativos = informativosDAO::findALLByCS($_GET['id']);
	if ($cs->destinatario == $usuario->id && $cs->data_recebimento == ""){
	 $cs->data_recebimento = date('Y-m-d',time());
	 $cs->status = "Recebida pelo Destinatário";
	 $svcs = criticas_sugestoesDAO::save($cs);
	                switch ($cs->tipo_remetente) {
								case 1:
								   $mail = superusuarioDAO::findByPk($cs->id_membroscondominio);
								   break;
								case 4:
								   $mail = funcionariosDAO::findByPk($cs->id_membroscondominio);
								   break;
								default:
								   $mail = membroscondominioDAO::findByPk($cs->id_membroscondominio);
								   break;
	}
	 $id4 = email::sendMail(utf8_encode(' Criticas & Sugestoes - MeuCondominio.net '), utf8_encode(' A sua '.$cs->tipo.' foi visualizada pelo destinatário na seguinte data: '.$cs->data_recebimento.'. Para a descrição completa, verifique o módulo correspondente através do site'),$mail->email); 
	 }
	$ep = 0;
}

switch($opt){
	case 1: $txt = "Enviadas";
			break;
	case 2: $txt = "Recebidas";
			break;
	case 3: $txt = "Visualizações";
			break;
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
                  <td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"></a></td>
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
             <p align="center" class="fontelinkPreto">
				<br />
	            <br />
    	         CONDOMÍNIO -&gt; <strong><a href="home.php"><?php=$condominio->nome?></a></strong><br />
        	     <?php  if($txt != ""){?>
				 	Críticas &amp; Sugestões -&gt; <strong><a href="home.php?opt=<?php=$opt?>" ><?php=$txt?></a></strong>
				<?php  }?>
				<br />
            	<br />
	            <br />
              </p>
				<form action="adicionar.php" method="post">
				  <?php  if (isset($_POST['addinfo']) or isset($_POST['fnlz'])) { ?>
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
                              <td class="tabela1_titulo2" colspan="2">obs:</td>
                            </tr>

                            <tr>
                              <td class="tabela1_linha2"  align="right">Informativo</td>
                              <td class="tabela1_linha2" ><textarea name="informativo" cols="50" rows="2" class="FORMULARIO" id="descricao"></textarea></td>
                            </tr>
                            <tr>
                              <td class="tabela1_linha2"  align="right">Finalização</td>
                              <td class="tabela1_linha2" >
				            <input name="fim" type="radio" value="1" />
				            Sim						
				            <input name="fim" type="radio" value="0" checked="checked" />Não</td>
                            </tr>
                            <tr>
                              <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
							      <input name="svinfo" type="image" src="../images/enviar.jpg" value="bla" />
                              </div></td>
                            </tr>
                        </table></td>
                      </tr>
                    </table>
				      <?php  } ?>
			          <input type="hidden" name="id" value="<?php=stripslashes($_POST['id'])?>"/>
			          <input type="hidden" name="opt" value="<?php=stripslashes($_POST['opt'])?>"/>					  
					  
				</form>
<br	 />
                <form action="adicionar.php" method="post" onSubmit="javascript:return confirmaMsg(this)" >
                  <div align="center"> <font class="warning">
				  <?php  if((!isset($_POST['enviadados']) && !isset($_POST['addinfo'])) or isset($msg)){ ?>
                    <?php  if(isset($msg) )
						echo $msg;?>
                    </font> <br />
                    <br />
                  </div>
                <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                    <tr>
                      <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="89%" class="tabela1_titulo1">Dados Cadastrais  </td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table cellpadding="1" cellspacing="1" width="100%">
                          <tr>
                            <td class="tabela1_titulo2" colspan="4">obs: </td>
                          </tr>
						  <?php  if (isset($_GET['opt'])){ ?>
                          <tr>
                            <td  align="right" class="tabela1_linha2">Situação</td>
                            <td colspan="3" class="tabela1_linha2" ><?php=$cs->status?></td>
                          </tr>
						  <?php  } ?>
					  <?php  if (isset($_GET['opt']) && $cs->data_recebimento != ""){ ?>                      
					   <tr>
                            <td  align="right" class="tabela1_linha2">Data de Recebimento </td>
                            <td colspan="3" class="tabela1_linha2" ><?php=$dias[date('w',strtotime($cs->data_recebimento))]?>, <?php=$cs->data_recebimento[8].$cs->data_recebimento[9]?>/<?php=$cs->data_recebimento[5].$cs->data_recebimento[6]?>/<?php=$cs->data_recebimento[0].$cs->data_recebimento[1]?><?php=$cs->data_recebimento[2].$cs->data_recebimento[3]?></td>
                          </tr>
						  <?php  } ?>
					  <?php  if (isset($_GET['opt']) && $cs->status == "Finalizada"){ ?>
                         <tr>
                            <td  align="right" class="tabela1_linha2">Data de Resolução </td>
                            <td colspan="3" class="tabela1_linha2" >
                              <?php=$dias[date('w',strtotime($cs->data_resolucao))]?>
                              ,
                              <?php=$cs->data_resolucao[8].$cs->data_resolucao[9]?>/<?php=$cs->data_resolucao[5].$cs->data_resolucao[6]?>/<?php=$cs->data_resolucao[0].$cs->data_resolucao[1]?><?php=$cs->data_resolucao[2].$cs->data_resolucao[3]?>                            </td>
                          </tr>
						  <?php  } ?>
                          <tr>
                            <td  align="right" class="tabela1_linha2">Tipo</td>
                            <td colspan="3" class="tabela1_linha2" >
							 <?php  if (!isset($_GET['opt'])){ ?>
							<select name="tipo">
                              <?php  if (isset($_GET['id'])) { ?>
                              <option selected="selected" value="<?php=$cs->tipo?>"><?php=$cs->tipo?></option>
                              <?php  } else {
							if(isset($_POST['tipo']) && $_POST['tipo'] != "" ){ ?>
                              <option selected="selected" value="<?php=$tipo?>">
                                <?php=$tipo?>
                              </option>
                              <?php  } else { ?>
                              <option selected="selected" value="">Selecionar</option>
                              <?php  } } ?>
                              <option value="">------------</option>
                              <option value="Critica">Critica</option>
                              <option value="Sugestão">Sugestão</option>
                            </select><?php  } else { echo $cs->tipo; } ?>							</td>
                          </tr> 
						  
                          <tr>
                            <td width="119"  align="right" class="tabela1_linha2">Prioridade</td>
                            <td colspan="3" class="tabela1_linha2">
							<?php  if(!isset($_GET['opt'])){ ?>
							<select name="prioridade">
							  <?php  if (isset($_GET['id'])) { ?>
                              <option selected="selected" value="<?php=$cs->id_prioridade?>"><?php  $niveisprioridades = niveisprioridadeDAO::findByPk($cs->id_prioridade); echo $niveisprioridades->nome; ?></option><?php  } else { 
							   if (isset($_POST['prioridade']) && $_POST['prioridade'] != "") { ?>
                              <option selected="selected" value="<?php=$_POST['prioridade']?>"><?php  $niveisprioridades = niveisprioridadeDAO::findByPk($_POST['prioridade']); echo $niveisprioridades->nome; ?></option> <?php  }  else { ?>
							  <option selected="selected" value="">Selecionar</option>
							  <?php  } } ?>
                              <option value="value""">------------</option>
                              <?php  $niveisprioridades = niveisprioridadeDAO::findAll(); 
							for ($i = 0; $i < sizeof($niveisprioridades); $i++){ ?>
                              <option value="<?php=$niveisprioridades[$i]->id?>">
                              <?php=$niveisprioridades[$i]->nome?>
                              </option>
                              <?php  }  ?>
                            </select><?php  } else { $niveisprioridades = niveisprioridadeDAO::findByPk($cs->id_prioridade); echo $niveisprioridades->nome; } ?>  </td>
                          </tr>
                          <tr>
                            <td class="tabela1_linha2"  align="right">Mensagem</td>
                            <td colspan="3" class="tabela1_linha2" ><?php  if(!isset($_GET['opt'])){ ?><textarea name="descricao" cols="47" rows="10" class="FORMULARIO"><?php  if (isset($_GET['id'])){ ?><?php=$cs->mensagem?><?php  } else { if (isset($_POST['descricao'])){?><?php=$descricao?> <?php  } } ?></textarea><?php  } else { echo $cs->mensagem; ?><?php  } ?> </td>
                          </tr>
						  <?php  if (isset($_GET['opt']) && $cs->status == "Finalizada"){ ?>
						  <tr>
                            <td class="tabela1_linha2"  align="right">Resolução</td>
                            <td colspan="3" class="tabela1_linha2" ><?php=$cs->resolucao?></td>
                          </tr>
						 <?php  } ?>
					
						  <?php  if (!isset($_GET['opt'])){ ?>
                            <tr>
                            <td class="tabela1_linha2"  align="right">Destinatário</td>
                            <td colspan="2" class="tabela1_linha2" ><select name="tipo_destinatario" onchange="this.form.submit();">
                              <?php  if (isset($_GET['id'])) { ?>
                              <option selected="selected" value="<?php=$cs->tipo_destinatario?>">
                                <?php  
								$tdest = tiposusuariosDAO::findByPk($cs->tipo_destinatario); echo $tdest->nome; ?>
                              </option>
                              <?php  } else { if (isset($_POST['tipo_destinatario'])){ ?>
                              <option selected="selected" value="<?php=$tipo_destinatario?>">
                                <?php  if ($tipo_destinatario != ""){ $tdest = tiposusuariosDAO::findByPk($tipo_destinatario);} else { ?>
                              </option>
                              <option selected="selected" value="">Selecionar</option>
                              <?php  } echo $tdest->nome; ?>
                              <?php  } else { ?>
                              <option selected="selected" value="">Selecionar</option>
                              <?php  } } ?>
                              <option value="">------------</option>
                              <?php  for ($i = 0 ; $i < sizeof($tiposusuarios); $i++) { ?>
                              <?php  if (!isset($tdest->id)){ ?>
                              <option value="<?php=$tiposusuarios[$i]->id?>">
                                <?php=$tiposusuarios[$i]->nome?>
                              </option>
                              <?php   } else { if ($tdest->id != $tiposusuarios[$i]->id) { ?>
                              <option value="<?php=$tiposusuarios[$i]->id?>">
                                <?php=$tiposusuarios[$i]->nome?>
                              </option>
                              <?php  } } } ?>
                            </select></td>
                            <td class="tabela1_linha2" ><?php  if (isset($tipo_destinatario)) $tdestaux = $tipo_destinatario; 
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
                                <option selected="selected" value="<?php=$dest->id?>">
                                  <?php=$dest->nome?>
                                </option>
                                <?php  } else { ?>
                                <option selected="selected" value="">Selecionar</option>
                                <?php  } ?>
                                <option value="">------------</option>
                                <?php  for ($i = 0 ; $i < sizeof($usuarios); $i++) { ?>
                                <option value="<?php=$usuarios[$i]->id?>">
                                  <?php=$usuarios[$i]->nome?>
                                </option>
                                <?php   } ?>
                              </select>							  </td> </tr>
                              <?php  } } else { if($_GET['opt'] == 1){?> 	
						      <tr>
						        <td rowspan="2"  align="right" class="tabela1_linha2">Destinatário</td>
						        <td colspan="2" class="tabela1_linha2" ><div align="center">GRUPO</div></td>
						        <td class="tabela1_linha2" ><div align="center">RESPONSÁVEL</div></td>
				        </tr>
					      <tr>
                            <td colspan="2" class="tabela1_linha2" ><div align="center"><?php  $tdest = tiposusuariosDAO::findByPk($cs->tipo_destinatario); echo $tdest->nome; ?></div></td>
                            <td class="tabela1_linha2" ><div align="center">
							<?php 
							 switch ($cs->tipo_destinatario) {
								case 1:
								   $dest = superusuarioDAO::findByPk($cs->destinatario);
								   break;
								case 4:
								   $dest = funcionariosDAO::findByPk($cs->destinatario);
								   break;
								default:
								    $dest = membroscondominioDAO::findByPk($cs->destinatario);
								   break;
								   }  echo $dest->nome; ?></div></td>
						  </tr> <?php  } else {?>
						  <tr>
						    <td rowspan="2"  align="right" class="tabela1_linha2">Remetente</td>
						    <td colspan="2" class="tabela1_linha2" ><div align="center">GRUPO</div></td>
						    <td class="tabela1_linha2" ><div align="center">RESPONSÁVEL</div></td>
					    </tr>
						  <tr>
                            <td colspan="2" class="tabela1_linha2" ><div align="center">soh</div></td>
                            <td class="tabela1_linha2" ><div align="center">soh</div></td>
						  </tr><?php  } } ?>						
						  	  
						  <?php  if (isset($_GET['opt']) && $informativos > 0) { ?>
					      <tr>
                            <td rowspan="<?php=sizeof($informativos)+1?>"  align="right" class="tabela1_linha2">Informativos</td>
                            <td width="151"  class="tabela1_linha2" ><div align="center">DATA</div></td>
                            <td colspan="2"  class="tabela1_linha2" ><div align="center">INFORMATIVO</div></td>
                         </tr>				  						 			
						 <?php  for ($i = 0 ; $i < sizeof($informativos) ; $i++) { ?>
					       <tr>	   
					        <td class="tabela1_linha2">
				              <div align="center">
				                <?php=$dias[date('w',strtotime($informativos[$i]->data))]?> 
				                ,
				                <?php=$informativos[$i]->data[8].$informativos[$i]->data[9]?>
				                / 
				                <?php=$informativos[$i]->data[5].$informativos[$i]->data[6]?>
					          </div></td>
				            <td colspan="2" class="tabela1_linha2"><div align="center">
				              <?php=$informativos[$i]->descricao?>
			                 </div></td>
					       </tr>
							  <?php  } ?> <?php  } ?>
							      
                     
					  
					  
						  <?php  if (!isset($_GET['id'])) { ?>
                          <tr>
                            <td rowspan="2"  align="right" class="tabela1_linha2">Visualizadores<br />
                            (GRUPO)</td>
                            <td colspan="2"  nowrap="nowrap" class="tabela1_linha2"><div align="center">Membros do Condomínio </div></td>
                            <td class="tabela1_linha2" nowrap="nowrap"><div align="center">Funcionários do Condomínio </div></td>
                          </tr>
                          <tr>
                            <td colspan="2" valign="top" class="tabela1_linha2" ><div align="left">
                                <?php  for ($i = 0 ; $i < sizeof($tiposusuarios) ; $i ++){ ?>
                                <input type="checkbox" id="a" name="pau<?php=$i?>" value="<?php=$tiposusuarios[$i]->id?>" />
                                <?php=$tiposusuarios[$i]->nome?>
                                <br />
                                <?php  } ?>
                                <br />
                            </div></td>
                            <td width="166" valign="top" class="tabela1_linha2" ><div align="left">
                                <?php  for ($i = 0 ; $i < sizeof($tiposfuncionarios); $i ++){ ?>
                                <input type="checkbox" id="pa" name="paf<?php=$i?>" value="<?php=$tiposfuncionarios[$i]->id?>" />
                                <?php=$tiposfuncionarios[$i]->nome?>
                                <br />
                                <?php  } ?>
                                <br />
                            </div></td>
                          </tr>
	<?php  } ?>
                          
                          <tr>
                            <td colspan="4"  align="right" class="tabela1_linha2"><div align="center"><br />
							  
	 					 <?php  if($_GET['opt'] == 2 && $cs->situacao != "Finalizada") { ?> 
						 <input name="addinfo" type="image" src="../images/mais.jpg" value="soh"/>
						 <?php  } else { ?> 
						 <?php  if($_GET['opt'] != 3) { ?>
						 <input name="enviadados" type="image" src="../images/enviar.jpg" value="bla"/> <?php  } else { ?> Botão de voltar <?php  } } ?>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                <p>
                  <input type="hidden"  name="id" value="<?php=stripslashes($cs->id)?>"/>
                  <input type="hidden"  name="opt" value="<?php=stripslashes($opt)?>"/>
                </p>
                <p>&nbsp;</p>
                </form>
				<form action="adicionar.php"  method="POST">
                  <p>
                    <?php  } else { if (!isset($_POST['addinfo'])) { ?>
                  </p>
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
                            <td class="tabela1_titulo2" colspan="4">obs: Caso não selecione nenhum usuário, a Crítica/Sugestão só será enviada ao Destinatário. </td>
                          </tr>
						  <?php  for ( $i = 0 ; $i < sizeof($tiposusuarios) ; $i++) { $aux = "pau"."$i"; ?>
						   <?php  if(isset($$aux)){
						   switch ($$aux) {
								case 1:
								   $totalMembros = superusuarioDAO::countAll();
								   $membros = superusuarioDAO::findAll();
								   break;
								case 4:
								   $totalMembros = sizeof($usuarios = funcionariosDAO::findALLbyCond($id_condominio));
								   $usuarios = funcionariosDAO::findALLbyCond($id_condominio);
								   break;
								default:
								  $totalMembros = sizeof(membroscondominioDAO::findALLbyCond($id_condominio,'',$$aux));
								  $membros = membroscondominioDAO::findALLbyCond($id_condominio,'',$$aux);
								   break;
								} 
						    							?>
						  <tr>
                            <td width="27%" class="tabela1_linha2" ><div align="right">
                              <?php  $tdest = tiposusuariosDAO::findByPk($$aux); echo $tdest->nome; ?>
							  <?php  if($totalMembros > 0) { ?>
                            </div></td>
                            <td width="36%" class="tabela1_linha2">
							<?php  
							 $nmTr = intval($totalMembros/2);
							if(floatval($totalMembros/2) != intval($totalMembros/2)){	
							$nmTr += 1; }
							$cont = 1;
							for($j = 0; $j < $nmTr; $j++){?>
							<input type="checkbox" id="" name="mbr_[<?php=$$aux?>][]" value="<?php=$membros[$j]->id?>"/><?php=$membros[$j]->nome?><br />
							<?php  $cont++; }?></td>
                            <td width="37%" class="tabela1_linha2"><?php 	for($k = ($cont-1); $k < $totalMembros; $k++){?>
                              <input type="checkbox" id="" name="mbr_[<?php=$$aux?>][]" value="<?php=$membros[$k]->id?>"/><?php=$membros[$k]->nome?><br /><?php  $cont++; } ?></td>
                          </tr>
						  <?php  } else { ?>
						    <td colspan="2" class="tabela1_linha2">Não foram encontrados usuários nesse grupo. </td> 
						    <?php  } } } ?>
						  
						  <?php  for ( $i = 0 ; $i < sizeof($tiposfuncionarios) ; $i++) { $aux = "paf"."$i"; ?>
						   <?php  if(isset($$aux)){
						   $totalMembros = sizeof(funcionariosDAO::findALLbyCond($id_condominio,'',$$aux));
						   $membros = funcionariosDAO::findALLbyCond($id_condominio,'',$$aux); ?>
						   
                          <tr>
                            <td class="tabela1_linha2"><div align="right">
							<?php  $tdest = tiposfuncionariosDAO::findByPk($$aux); echo $tdest->nome; ?> 
							<?php  if($totalMembros > 0) { ?> 	
                            </div></td>
                            <td class="tabela1_linha2"><?php  
														
							$nmTr = intval($totalMembros/2);
							if(floatval($totalMembros/2) != intval($totalMembros/2)){	
							$nmTr += 1; }
							$cont = 1;
							for($j = 0; $j < $nmTr; $j++){?>
                              <input type="checkbox" id="" name="fnc_[<?php=$$aux?>][]" value="<?php=$membros[$j]->id?>"/><?php=$membros[$j]->nome?><br />
                            <?php  $cont++; }?></td>
                            <td class="tabela1_linha2"><?php 	for($k = ($cont-1); $k < $totalMembros; $k++){?>
                              <input type="checkbox" id="" name="fnc_[<?php=$$aux?>][]" value="<?php=$membros[$k]->id?>"/><?php=$membros[$k]->nome?></td>       </tr>						  <?php  }}else { ?> <td colspan="2" class="tabela1_linha2">Não foram encontrados usuários nesse grupo.</td><?php  }}} ?>

                          <tr>
                            <td colspan="4"  align="right" class="tabela1_linha2"><div align="center"><br />
                                    <input name="gravacrit_sug" type="image" src="../images/enviar.jpg" value="bla"/>
                            </div></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table>
                  <input type="hidden"  name="id" value="<?php=$id?>"/>
                  <input type="hidden"  name="tipo" value="<?php=$tipo?>"/>
                  <input type="hidden"  name="descricao" value="<?php=$descricao?>"/>
                  <input type="hidden"  name="tipo_destinatario" value="<?php=$tipo_destinatario?>"/>
                  <input type="hidden"  name="destinatario" value="<?php=$destinatario?>"/>
                  <input type="hidden"  name="prioridade" value="<?php=$prioridade?>"/>				  
                  <input type="hidden"  name="status" value="<?php=$status?>"/>				  				 
                  <input type="hidden"  name="data_recebimento" value="<?php=$data_recebimento?>"/>
				  <input type="hidden"  name="data_resolucao" value="<?php=$data_resolucao?>"/>
				  <input type="hidden"  name="opt" value="<?php=$opt?>"/>
                </form>
				  <?php  } } ?>
			    
				<p><br />
	          </p>
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
