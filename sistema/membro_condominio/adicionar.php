<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/senha.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/membroscondominio.php");
require_once("../php/membroscondominioDAO.php");
require_once("../php/tiposusuarios.php");
require_once("../php/tiposusuariosDAO.php");

@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();


$membro = new membroscondominio();

if ( isset($_POST['login']) ){	
	
	//verifica se o su possue permissão para alterar(1) no modulo(13)
	if(!permissoesDAO::temPermissao(13,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
	//atribuições iniciais
	$membro->id = addslashes($_POST['id']);
	$membro->cpf = addslashes($_POST['cpf']);
	$membro->id_condominios = $id_condominio;	
	$membro->id_tipo_usuarios = addslashes($_POST['id_tipo_usuarios']);
	$membro->nome = addslashes($_POST['nome']);
	$membro->data_nascimento = addslashes($_POST['data_nascimento']);
	$membro->cpf = addslashes($_POST['cpf']);
	$membro->telefone = addslashes($_POST['telefone']);
	$membro->celular = addslashes($_POST['celular']);
	$membro->email = addslashes($_POST['email']);
	$membro->numero_apartamento = addslashes($_POST['numero_apartamento']);
	$membro->login = addslashes($_POST['login']);
	$membro->proprietario = addslashes($_POST['proprietario']);
	$membro->status = addslashes($_POST['status']);
	
	
	//cria o objeto centro de custo que se quer obter as informações
	$tipo_usuario = tiposusuariosDAO::findByPk($membro->id_tipo_usuarios);
	
	//verifica se o centro de custo que se esta utilizando esta ativo
	if (($tipo_usuario->status == 1) or ($membro->id_tipo_usuarios == $_POST['id_tipo_usuarios2'])){	
	
	//verifica se esta sendo criado ou alterado um Membro do condomínio
	if ($membro->id == 0){	
		//verifica se o cpf que foi cadastrado já pertence a outro usuário
		if(membroscondominioDAO::existeByCpf($membro->cpf, $membro->id_condominios)){
			$membro = membroscondominioDAO::findTopByBusca('',$membro->cpf, $membro->id_condominios, 0,1);			
				//verifica se o usuário esta ativo
				if($membro[0]->status == 0){
					$membro[0]->status = 1;
					$id = membroscondominioDAO::save($membro[0]);
					header("Location: home.php?msg=O Membro do condomínio de CPF {$membro[0]->cpf} foi restaurado");
					exit();	
				}else{
					header("Location: home.php?msg=O Membro do condomínio de CPF {$membro[0]->cpf} já esta ativo");
					exit();	
				}
		}else{
			//outras atribuições
			$membro->id_tipo_usuarios = addslashes($_POST['id_tipo_usuarios']);
		    $membro->nome = addslashes($_POST['nome']);
		   	$membro->data_nascimento = addslashes($_POST['data_nascimento']);
		    $membro->cpf = addslashes($_POST['cpf']);
			$membro->telefone = addslashes($_POST['telefone']);
		    $membro->celular = addslashes($_POST['celular']);
			$membro->email = addslashes($_POST['email']);
			$membro->numero_apartamento = addslashes($_POST['numero_apartamento']);
			$membro->login = addslashes($_POST['login']);
			$membro->proprietario = addslashes($_POST['proprietario']);
			$membro->numero_acessos = addslashes($_POST['numeroacessos']);
			$membro->data_criacao = date("Y-m-d", time());	
			$membro->status = 1;

			
			//verifica se existe um usuário com o login desejado
			if(!membroscondominioDAO::existeByLogin($_POST['login'], $membro->id_condominios)){
				if($_POST['senha'] == $_POST['confsenha']){
					//verifica se a senha segue o padrão desejado
					if(Senha::confSenha($_POST['senha'], $_POST['login'])){
						$membro->senha = md5(($_POST['senha']));
						$id = membroscondominioDAO::save($membro);
						header("Location: home.php");
						exit();					
					}else{
						$msg = "Não é possível inserir o usuário requirido, pois a senha digitada não é confiável. Para torná-la confiável: <br> 1- Não faça uso de repetição de caracteres idênticos; <br> 2 - Escreva senhas com mais de 5 caracteres; <br> 3 - Não repita a sequência de caracteres de seu login em sua senha; <br> 4 - Não utilize sequências de números; <br> 5 - Não utilize sequência de caracteres;";
					}		
				}else{
					$msg = "Não é possível inserir o usuário requirido, pois o conteudo do campo de senha difere do de sua confirmação.";
				}		
			}else{
				$msg = "Não é possível inserir o usuário requirido, pois já existe um usuários cadastrados com este login.";
			}
		}
	}else{
		//verifica se o cpf que se quer cadastrar existe e se ele não pertence ao membro que se esta alterando
		if((membroscondominioDAO::existeByCpf($membro->cpf, $membro->id_condominios)) && (membroscondominioDAO::existeByCpfId($membro->cpf, $membro->id, $membro->id_condominios))) {
			header("Location: home.php?msg=O CPF {$membro->cpf} pertence a outro membro");
			exit();	
		}else{
			//cria o objeto user com os dados do Super-Usuário que se esta alterando
			$membro = membroscondominioDAO::findByPk($membro->id);
			
			//outras atribuições
			$membro->id_tipo_usuarios = addslashes($_POST['id_tipo_usuarios']);
		    $membro->nome = addslashes($_POST['nome']);
		   	$membro->data_nascimento = addslashes($_POST['data_nascimento']);
		    $membro->cpf = addslashes($_POST['cpf']);
			$membro->telefone = addslashes($_POST['telefone']);
		    $membro->celular = addslashes($_POST['celular']);
			$membro->email = addslashes($_POST['email']);
			$membro->numero_apartamento = addslashes($_POST['numero_apartamento']);
			$membro->login = addslashes($_POST['login']);
			$membro->proprietario = addslashes($_POST['proprietario']);
			$membro->status = addslashes($_POST['status']);
			//verifica se existe um usuário com o login desejado diferente dele
			if(!membroscondominioDAO::existeByLoginId($_POST['login'], $membro->id, $membro->id_condominios)){				
				if($_POST['senha'] == $_POST['confsenha']){
					//verifica se a senha segue o padrão desejado
					if(Senha::confSenha($_POST['senha'], $_POST['login'])){
						$membro->senha = md5(($_POST['senha']));
						$id = membroscondominioDAO::save($membro);
						header("Location: home.php");
						exit();					
					}else{
						if($_POST['senha'] == ""){
							$id = membroscondominioDAO::save($membro);
							header("Location: home.php");
							exit();					
						}else{
							$msg = "Não é possível inserir o usuário requirido, pois a senha digitada não é confiável. Para torná-la confiável: <br> 1- Não faça uso de repetição de caracteres idênticos; <br> 2 - Escreva senhas com mais de 5 caracteres; <br> 3 - Não repita a sequência de caracteres de seu login em sua senha; <br> 4 - Não utilize sequências de números; <br> 5 - Não utilize sequência de caracteres;";
						}
					}		
				}else{
					$msg = "Não é possível inserir o usuário requirido, pois o conteudo do campo de senha difere do de sua confirmação.";
				}		
			}else{
				$msg = "Não é possível inserir o usuário requirido, pois já existe um usuários cadastrados com este login.";
			}
		}
	}		
	}else{
			$msg = 'O Tipo de Usuário a qual se quer inserir um registro não permite novas entradas';	
	}		
}  

if(isset($_GET['id'])){
	$membro = membroscondominioDAO::findByPk($_GET['id']);
	$ep = 0;
}else{
	//verifica se o su possue permissão para inserir(2) no modulo(13)
	if(!permissoesDAO::temPermissao(13,2,$usuario->id_tipo_usuario)){
		header("Location: ../index.php");
		exit();
	}
}

$tipos_usuario = tiposusuariosDAO::findAll();
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
          <h1>MEMBROS DO CONDOMÍNIO </h1></td>
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
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaincalt(this)" name="membro" id="membro">
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
                        <td class="tabela1_titulo2" colspan="2">Dados Pessoais </td>
                      </tr>
                      <tr>
					  	<td class="tabela1_linha2"  align="right"> Nome</td>
						<td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nome" size="30" maxlength="30" value="<?php=stripslashes($membro->nome)?>"></td>
					  </tr>
					  
					  <tr>
					    <td class="tabela1_linha2"  align="right">Email</td>
					    <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="email" size="30" maxlength="30" value="<?php=stripslashes($membro->email)?>" /></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">Telefone</td>
					    <td class="tabela1_linha2" ><input  name="telefone" type="text" class="FORMULARIO" id="telefone" value="<?php=stripslashes($membro->celular)?>" size="14" maxlength="14" onkeydown="FormataTEL(this,event)" onKeyPress="return Numero(event);" /></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right">Celular</td>
					    <td class="tabela1_linha2" ><input  name="celular" type="text" class="FORMULARIO" id="celular" value="<?php=stripslashes($membro->celular)?>" size="14" maxlength="14" onkeydown="FormataTEL(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">CPF</td>
					    <td class="tabela1_linha2" ><input  name="cpf" type="text" class="FORMULARIO" id="cpf" value="<?php=stripslashes($membro->cpf)?>" size="14" maxlength="14" onkeydown="FormataCPF(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">Data de Nascimento </td>
					    <td class="tabela1_linha2" ><script>DateInput('data_nascimento', true, 'YYYY-MM-DD', '<?php=$membro->data_nascimento?>')</script></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Login<font class="warning">*</font></td>
					    <td class="tabela1_linha2" ><input  name="login" type="text" class="FORMULARIO" id="login" value="<?php=stripslashes($membro->login)?>" size="30" maxlength="30" /></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right">Senha<font class="warning">*</font></td>
					    <td class="tabela1_linha2" ><input  name="senha" type="password" class="FORMULARIO" id="senha" value="" size="30" maxlength="30" /></td>
				      </tr>
					   <tr>
                        <td class="tabela1_linha2"  align="right">Confirmação de Senha<font class="warning">*</font></td>
					    <td class="tabela1_linha2" ><input  name="confsenha" type="password" class="FORMULARIO" id="confsenha" value="" size="30" maxlength="30" /></td>
				      </tr>
					   <tr>
					     <td colspan="2"  align="left" class="tabela1_titulo2">Dados Relativos ao Condomínio </td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">Função</td>
					    <td class="tabela1_linha2" >
						<?php 
							if($membro->id != 0){
								$tipo_usuario = tiposusuariosDAO::findByPk($membro->id_tipo_usuarios);
							
								//verifica se o tipo de usuario utilizado o que se quer usar esta ativo ou não							
								if($tipo_usuario->status == 0){
									$classe2 = 'FORMULARIOWARNINIG';
									//usuário criado para manter sempre o imput comparador com o id original
									$user = tiposusuariosDAO::findByPk($membro->id);
						
									//input que servirá como comparação para aceitar ou não a permanencia do campo com dados da tabela tipo de funcionarios com status 0
								?>
									<input type="hidden" name="id_tipo_usuarios2" value="<?php=$user->id_tipo_usuarios?>" />
								<?php 
								}else{
									$classe2 = 'FORMULARIO';
								}
							}else{
								$classe2 = 'FORMULARIO';
							}
							?>	
						<select name="id_tipo_usuarios" class="<?php=$classe2?>">
							<?php  for($i = 0; $i < sizeof($tipos_usuario); $i++){
									if(($tipos_usuario[$i]->id == $membro->id_tipo_usuarios) or ($tipos_usuario[$i]->status != 0)){	
										if ($tipos_usuario[$i]->id != 1){
							?>
							<option <?php  if($tipos_usuario[$i]->id == $membro->id_tipo_usuarios){ ?> selected="selected" <?php  }?> value="<?php=$tipos_usuario[$i]->id?>"><?php=$tipos_usuario[$i]->nome?></option>
							<?php 
										}
									}
								}
							?>
						</select>						</td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">Proprietário</td>
					    <td class="tabela1_linha2" ><div align="left">Sim <input name="proprietario" type="radio" value="1" <?php  if ( $membro->proprietario == 1) { ?> checked="checked" <?php  }?> /> Não
						 
				            <input name="proprietario" type="radio" value="0"  <?php  if ( $membro->proprietario == 0) { ?> checked="checked" <?php  } ?>/> 
				         </div></td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2"  align="right">Número do apartamento </td>
					    <td class="tabela1_linha2" ><input  name="numero_apartamento" type="text" class="FORMULARIO" id="numero_apartamento" value="<?php=stripslashes($membro->numero_apartamento)?>" size="4" maxlength="4" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2">Situação</td>
				        <td  align="left" class="tabela1_linha2">Ativo
				          <input name="status" type="radio" value="1"  <?php  if ( $membro->status == 1) { ?> checked="checked" <?php  }?>/>
				            Inativo						
				            <input name="status" type="radio" value="0"   <?php  if ( $membro->status == 0) { ?>checked="checked"<?php  }?> /></td>
					  </tr>
					  <tr>
                        <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
                        <input type="image" src="../images/enviar.jpg" /></div></td>
				      </tr>
                  </table>
			      </td>
                </tr>
              </table> 
			  <input type="hidden"  name="numeroacessos" value="<?php=stripslashes($membro->numero_acessos)?>" />
			  <input type="hidden"  name="datacriacao" value="<?php=stripslashes($membro->data_criacao)?>" />
			   <input type="hidden"  name="id" value="<?php=stripslashes($membro->id)?>" />
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
