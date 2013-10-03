<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/tiposusuarios.php");
require_once("../php/tiposusuariosDAO.php");
require_once("../php/modulos.php");
require_once("../php/modulosDAO.php");



@session_start();

$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();


$modulos = new modulos();
$modulos = modulosDAO::findAll();

if ( isset($_POST['id']) ){
	
	//verifica se o su possue permissão para alterar(1) no modulo(3)
	if(!permissoesDAO::temPermissao(3,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
	$permisssao = new permissoes();
	
	//atribui o id ao objeto permissao
	$permisssao->FKid_tipo_usuariosCol = addslashes($_POST['id']);
	
	//limpa todas as permissoes existentes para o tipo de usuário 
	permissoesDAO::cleanPermissao($permisssao->FKid_tipo_usuariosCol );
	
	//Percorre todos os arrays enviados sob os ids dos modulos inserindo as permissões
	for($i = 0; $i < sizeof($modulos); $i++){
		$permisssao->FKid_tipo_usuariosCol = addslashes($_POST['id']);
		if($_POST[$modulos[$i]->id][1] == 1){
			$permisssao->FKid_modulosCol = $modulos[$i]->id;
			$permisssao->FKid_tipos_permissoesCol = 4;
			permissoesDAO::save($permisssao);
		}
		
		if($_POST[$modulos[$i]->id][2] == 1){
			$permisssao->FKid_modulosCol = $modulos[$i]->id;
			$permisssao->FKid_tipos_permissoesCol = 1;
			permissoesDAO::save($permisssao);
			$permisssao->FKid_tipos_permissoesCol = 2;
			permissoesDAO::save($permisssao);
		}
		
		if($_POST[$modulos[$i]->id][3] == 1){
			$permisssao->FKid_modulosCol = $modulos[$i]->id;
			$permisssao->FKid_tipos_permissoesCol = 3;
			permissoesDAO::save($permisssao);
		}
	}
	
	header("Location: home.php");
	exit();		
}  

//verifica se a pagina recebeu um id para alteração
if(isset($_GET['id'])){
	$ep = 0;
}else{
	//verifica se o su possue permissão para inserir(2) no modulo(3)
	if(!permissoesDAO::temPermissao(3,2,$usuario->id_tipo_usuario)){
		header("Location: ../index.php");
		exit();
	}
	$_GET['id'] = 1;
	
}

$tipousuarios = new tiposusuarios();
//cria listagem de tipos de usuário para ser usado no select
$tiposUsuarios = tiposusuariosDAO::findAll();

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
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar_off.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>PERMISSÕES</h1></td>
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
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaTipoUser(this)" name="permissao" id="permissao">
			  <div align="center">
			  <font class="warning">
			    <?php  if(isset($msg) )
						echo $msg;						
			    ?>
				
				</font>
			    <br />
			    <br />
				<select name="tipo_usuario" id="tipo_usuario"  onchange="mudaX(this)">
					<?php  for($i = 0; $i < sizeof($tiposUsuarios); $i++){?>
						<option <?php  if($_GET['id'] == $tiposUsuarios[$i]->id){?> selected="selected" <?php  }?> value="<?php=$tiposUsuarios[$i]->id?>"><?php=$tiposUsuarios[$i]->nome?></option>
					<?php  }?>
				</select>
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
                      <td class="tabela1_titulo2">Módulo</td>
                      <td class="tabela1_titulo2"><div align="center"><a href="javascript:checkall(1);"><img src="../images/ver.gif" alt="vizualizar" width="20" height="21" border="0" /></a></div></td>
                      <td class="tabela1_titulo2"><div align="center"><a href="javascript:checkall(2);"><img src="../images/mais.gif" alt="adicionar" width="20" height="21" border="0" /></a></div></td>
                      <td class="tabela1_titulo2"><div align="center"><a href="javascript:checkall(3);"><img src="../images/x.gif" alt="excluir" width="20" height="21" border="0" /></a></div></td>
                    </tr>
                    <?php 					  	
					  
					  	for($i = 0; $i < sizeof($modulos); $i++){
					  ?>
                    <tr>
                      <td width="36%"  align="right" class="tabela1_linha2"><div align="left">
                          <?php=$modulos[$i]->nome?>
                      </div></td>
                      <td width="21%" class="tabela1_linha2" align="center" ><input type="checkbox" id="a" name="<?php=$modulos[$i]->id?>[1]" <?php  if(permissoesDAO::temPermissao($modulos[$i]->id,4,$_GET['id'])){?> checked="checked" <?php  }?> value="1" /></td>
                      <td width="21%" class="tabela1_linha2" align="center"><input type="checkbox" id="b" name="<?php=$modulos[$i]->id?>[2]" <?php  if(permissoesDAO::temPermissao($modulos[$i]->id,1,$_GET['id'])){?> checked="checked" <?php  }?>  value="1"/></td>
                      <td width="22%" class="tabela1_linha2" align="center"><input type="checkbox" id="c" name="<?php=$modulos[$i]->id?>[3]" <?php  if(permissoesDAO::temPermissao($modulos[$i]->id,3,$_GET['id'])){?> checked="checked" <?php  }?>  value="1"/></td>
                    </tr>
                    <?php 
					  	}
					  ?>
                    <tr>
                      <td colspan="4"  align="right" class="tabela1_linha2"><div align="center"><br />
                              <input name="image" type="image" src="../images/enviar.jpg" />
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
              </table> 			  
			   <input type="hidden"  name="id" value="<?php=stripslashes($_GET['id'])?>" />
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
