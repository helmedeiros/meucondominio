<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/senha.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/contatos.php");
require_once("../php/contatosDAO.php");


@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();


$contatos = new Contatos();

$condominio = condominiosDAO::findByPk($id_condominio); 

if ( isset($_POST['cpf']) ){
	
	//verifica se o su possue permissão para alterar(1) no modulo(36)
	if(!permissoesDAO::temPermissao(36,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
	//atribuições iniciais(campos obrigatórios para autenticação de existêcia)
	$contatos->id = addslashes($_POST['id']);
	$contatos->cpf = addslashes($_POST['cpf']);
	$contatos->nome = addslashes($_POST['nome']);
    $contatos->telefone= addslashes($_POST['telefone']);
    $contatos->celular= addslashes($_POST['celular']);
    $contatos->email= addslashes($_POST['email']);			
    $contatos->descricao = addslashes($_POST['descricao']);
	
	//verifica se o nome esta vazio
	if($contatos->nome != ""){
	
	//verifica se o nome esta vazio
	if($contatos->cpf != ""){
		
	//verifica se esta sendo criado ou alterado um prestador de serviço
	if ($contatos->id == 0){	
		//verifica se o cpf que foi cadastrado já pertence a outro prestador de serviço		
		if(contatosDAO::existeByCpf($contatos->cpf)){		
			//verifica se o cpf esta preenchido
			if($contatos->cpf != ""){
				$contatos = contatosDAO::findTopByBusca('',$contatos->cpf,0,1);
			}
				//verifica se o contato esta ativo
				if($contatos->status == 0){
					$contatos->status = 1;
					$condominio->id_contato = $contatos->id;
					$id = contatosDAO::save($contatos);
					$id2 = condominiosDAO::save($condominio);					
					header("Location: home.php?msg=O Contato de CPF {$contatos->cpf} foi restaurado e setado como contato para este condomínio");
					exit();	
				}else{
					$condominio->id_contato = $contatos->id;
					$id2 = condominiosDAO::save($condominio);
					header("Location: home.php?msg=O Contato de CPF {$contatos->cpf} já esta ativo e foi setado como contato para este condomínio");
					exit();	
				}
		}else{
			//outras atribuições
			$Contato->nome = addslashes($_POST['nome']);
            $Contato->cpf = addslashes($_POST['cpf']);
            $Contato->telefone= addslashes($_POST['telefone']);
            $Contato->celular= addslashes($_POST['celular']);
            $Contato->email= addslashes($_POST['email']);			
            $Contato->descricao = addslashes($_POST['descricao']);
	        $Contato->status = 1;	
			$id = contatosDAO::save($Contato);
			$contatos = contatosDAO::findTopByBusca('',$Contato->cpf,0,1);
			$condominio->id_contato = $contatos[0]->id;
			$id2 = condominiosDAO::save($condominio);
			header("Location: home.php?msg=O Contato de CPF {$contatos[0]->cpf} foi cadastrado e setado como contato para este condomínio");
			exit();			
		}
	}else{
		//verifica se o cpf que se quer cadastrar existe e se ele não pertence ao contato que se esta alterando
		if((contatosDAO::existeByCpf($contatos->cpf) && contatosDAO::existeByCpfId($contatos->cpf, $contatos->id))) {
			header("Location: home.php?msg=O CPF {$Contato->cpf} pertence a outro contato");
			exit();	
		}else{
			//cria o objeto Contato com os dados do Contato que se esta alterando
			$Contato = contatosDAO::findByPk($contatos->id);
			
			//outras atribuições
			$Contato->nome = addslashes($_POST['nome']);
            $Contato->cpf = addslashes($_POST['cpf']);
            $Contato->telefone= addslashes($_POST['telefone']);
            $Contato->celular= addslashes($_POST['celular']);
            $Contato->descricao = addslashes($_POST['descricao']);
	        $Contato->status = 1;	
			$id = contatosDAO::save($Contato);
			$contatos = contatosDAO::findTopByBusca('',$Contato->cpf,0,1);
			$condominio->id_contato = $contatos[0]->id;
			$id2 = condominiosDAO::save($condominio);
			header("Location: home.php?msg=O Contato de CPF {$contatos[0]->cpf} foi alterado e setado como contato para este condomínio");
			exit();			
			
		}
	
	}
	}else{
		$msg = "O CPF não pode estar vazio";
	}
	}else{
		$msg = "O nome não pode estar vazio";
	}
				
}  

if(isset($_GET['id'])){
	$contatos = contatosDAO::findByPk($_GET['id']);
	$ep = 0;
}else{
	//verifica se o su possue permissão para inserir(2) no modulo(36)
	if(!permissoesDAO::temPermissao(36,2,$usuario->id_tipo_usuario)){
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
				<td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>CONTATOS</h1></td>
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
            CONDOMÍNIO -&gt; <strong>
            <?php=$condominio->nome?>
            </strong><br />
            <br />
            <br />
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaincalt(this)" name="contatos" id="contatos">
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
                        <td class="tabela1_titulo2" colspan="2">obs.: o campo CPF é obrigatório </td>
                      </tr>
                      <tr>
					  	<td class="tabela1_linha2"  align="right"> Nome:</td>
						<td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nome" id="nome" size="30" maxlength="50" value="<?php=stripslashes($contatos->nome)?>"></td>
					  </tr>
					   <tr>
                        <td class="tabela1_linha2"  align="right">CPF:</td>
					    <td class="tabela1_linha2" ><input  name="cpf" type="text" class="FORMULARIO" id="cpf" value="<?php=stripslashes($contatos->cpf)?>" size="14" maxlength="14" onkeydown="FormataCPF(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Telefone: </td>
					    <td class="tabela1_linha2" ><input  name="telefone" type="text" class="FORMULARIO" id="telefone" value="<?php=stripslashes($contatos->telefone)?>" size="14" maxlength="14" onkeydown="FormataTEL(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right"> Celular:</td>
					    <td class="tabela1_linha2" ><input  name="celular" type="text" class="FORMULARIO" id="celular" value="<?php=stripslashes($contatos->celular)?>" size="14" maxlength="14" onkeydown="FormataTEL(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right">Email</td>
					    <td class="tabela1_linha2" ><input  name="email" type="text" class="FORMULARIO" id="email" value="<?php=stripslashes($contatos->email)?>" size="14" maxlength="50" /></td>
				      </tr>	
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Descrição: </td>
					    <td class="tabela1_linha2" ><textarea name="descricao" cols="30" rows="3" class="FORMULARIO" id="descricao"><?php=stripslashes($contatos->descricao)?>
					    </textarea></td>
				      </tr>					 
					  <tr>
                        <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
                        <input type="image" src="../images/enviar.jpg" /></div></td>
				      </tr>
                  </table>
			      </td>
                </tr>
              </table> 
			   <input type="hidden"  name="id" value="<?php=stripslashes($contatos->id)?>" />
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
