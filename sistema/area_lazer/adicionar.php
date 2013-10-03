<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/senha.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/arealazer.php");
require_once("../php/arealazerDAO.php");
require_once("../php/funcionamento.php");
require_once("../php/funcionamentoDAO.php");

@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();


$area = new arealazer();

if ( isset($_POST['nome']) ){	
	
	//verifica se o su possue permissão para alterar(1) no modulo(19)
	if(!permissoesDAO::temPermissao(19,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
	//atribuições iniciais
	$area->id = addslashes($_POST['id']);
	$area->nome = addslashes($_POST['nome']);
	$area->tamanho = addslashes($_POST['tamanho']);
	$area->id_condominio = $id_condominio;	
	
	//verifica se o nome esta em branco
	if($area->nome != ""){
	
	//verifica se o tamanho esta em branco
	if($area->tamanho != "" and strlen($area->tamanho) > 3){	
	
	//verifica se esta sendo criado ou alterado uma Área e Lazer
	if ($area->id == 0){	
		//verifica se o nome que foi cadastrado já pertence a outra área deste condomínio
		if(arealazerDAO::existeByNome($area->nome, $area->id_condominio)){					
			header("Location: home.php?msg=A área de lazer sujerida ao cadastro não foi incluida pois já existem outras com o mesmo nome ({$area->nome})");
			exit();	
		}else{
			//outras atribuições
			$area->id = addslashes($_POST['id']);
			$area->nome = addslashes($_POST['nome']);
			$area->tamanho = addslashes($_POST['tamanho']);
			$area->funcionamento = addslashes($_POST['funcionamento']);
			$area->status = addslashes($_POST['status']);
			$area->id_condominio = $id_condominio;	
			$id = arealazerDAO::save($area);
			header("Location: home.php");
			exit();					
		}
	}else{
		//verifica se o nome que se quer cadastrar existe e se ele não pertence a área que se esta alterando
		if((arealazerDAO::existeByNome($area->nome, $area->id_condominio)) && (arealazerDAO::existeByNomeId($area->nome, $area->id, $area->id_condominio))) {
			header("Location: home.php?msg=A alteração não foi realizada pois já existem outras com o mesmo nome ({$area->nome})");
			exit();	
		}else{
			//cria o objeto user com os dados do Super-Usuário que se esta alterando
			$area = arealazerDAO::findByPk($area->id);
			
			//outras atribuições
			$area->id = addslashes($_POST['id']);
			$area->nome = addslashes($_POST['nome']);
			$area->tamanho = addslashes($_POST['tamanho']);
			$area->funcionamento = addslashes($_POST['funcionamento']);
			$area->status = addslashes($_POST['status']);
			$area->id_condominio = $id_condominio;	
			$id = arealazerDAO::save($area);
			header("Location: home.php");
			exit();
		}
	}	
	}else{
		$msg = "O tamanho não pode estar vazio";
	}
	}else{
		$msg = "O nome não pode estar vazio";
	}		
}  

if(isset($_GET['id'])){
	$area = arealazerDAO::findByPk($_GET['id']);
	$ep = 0;
}else{
	//verifica se o su possue permissão para inserir(2) no modulo(19)
	if(!permissoesDAO::temPermissao(19,2,$usuario->id_tipo_usuario)){
		header("Location: ../index.php");
		exit();
	}
}

$funcionamentos = funcionamentoDAO::findAll(); 
$condominio = condominiosDAO::findByPk($id_condominio); 
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
          <h1>ÁREAS DE LAZER </h1></td>
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
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaarea(this)" nome="area" tipo"area">
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
                        <td class="tabela1_titulo2" colspan="2">obs.:O tamanho abaixo diz respeito a área em metros quadrados(m<sup>2</sup>). </td>
                      </tr>
                      <tr>
					  	<td class="tabela1_linha2"  align="right"> Nome</td>
						<td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nome" size="30" maxlength="30" value="<?php=stripslashes($area->nome)?>"></td>
					  </tr>
					  
					  <tr>
					    <td class="tabela1_linha2"  align="right">Tamanho</td>
					    <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="tamanho" size="10" maxlength="10" value="<?php=stripslashes($area->tamanho)?>" onkeydown="FormataFloat(this,event)" onKeyPress="return Numero(event);" />
					    m<sup>2</sup></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">Funcionamento</td>
					    <td class="tabela1_linha2" >
						<select name="funcionamento">
							<?php 
								for ($i = 0; $i < sizeof($funcionamentos); $i++){
							?>
							<option value="<?php=$funcionamentos[$i]->id?>" <?php  if($area->funcionamento == $funcionamentos[$i]->id){?> selected="selected" <?php  }?>><?php=$funcionamentos[$i]->nome?></option>
							<?php 
								}
							?>
						</select>
						</td>
				      </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2">Situação</td>
				        <td  align="left" class="tabela1_linha2">Ativo
				          <input name="status" type="radio" value="1"  <?php  if ( $area->status == 1) { ?> checked="checked" <?php  }?>/>
				            Inativo						
				            <input name="status" type="radio" value="0"   <?php  if ( $area->status == 0) { ?>checked="checked"<?php  }?> /></td>
					  </tr>
					  <tr>
                        <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
                        <input type="image" src="../images/enviar.jpg" /></div></td>
				      </tr>
                  </table>
			      </td>
                </tr>
              </table> 			 
			   <input type="hidden"  name="id" value="<?php=stripslashes($area->id)?>" />
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
