<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/senha.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/servidor.php");
require_once("../php/servidorDAO.php");


@session_start();

$usuario = $_SESSION['usuario'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();


$servidor = new Servidor();

if ( isset($_POST['nome_servidor']) ){
	
	//verifica se o su possue permissão para alterar(1) no modulo(29)
	if(!permissoesDAO::temPermissao(29,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
	//atribuições iniciais(campos obrigatórios para autenticação de existêcia)
	$servidor->id = addslashes($_POST['id']);
	$servidor->cpf = addslashes($_POST['cpf']);
	$servidor->cnpj = addslashes($_POST['cnpj']);	
	$servidor->nome_contato = addslashes($_POST['nome_contato']);
	$servidor->telefone_contato = addslashes($_POST['telefone_contato']);
	$servidor->celular_contato = addslashes($_POST['celular_contato']);
	$servidor->nome_servidor = addslashes($_POST['nome_servidor']);
	$servidor->telefone_servidor = addslashes($_POST['telefone_servidor']);
	$servidor->celular_servidor = addslashes($_POST['celular_servidor']);
	$servidor->cidade_servidor = addslashes($_POST['cidade_servidor']);
	$servidor->uf_servidor = addslashes($_POST['uf_servidor']);
	$servidor->status = addslashes($_POST['status']);
	
	//verifica se o o nome da esta em branco
	if($servidor->nome_servidor != ""){
	
	//verifica se o cpf ou o cnpj do servidor esta em branco
	if($servidor->cpf != "" or $servidor->cnpj != ""){
	
	//verifica se a cidade do servidor esta em branco
	if($servidor->cidade_servidor != ""){
	
	//verifica se esta sendo criado ou alterado um prestador de serviço
	if ($servidor->id == 0){	
	
		//verifica se o cpf esta preenchido
		if($servidor->cpf != ""){
			
			//verifica se o cpf que se quer cadastrar pertence a outro prestador	
			if(ServidorDAO::existeByCpf($servidor->cpf)){
				
				$servidor = ServidorDAO::findByCpf($servidor->cpf);
				
				//verifica se o usuário esta ativo
				if($servidor->status == 0){
					$servidor->status = addslashes($_POST['status']);
					$id = ServidorDAO::save($servidor);
					header("Location: home.php?msg=O Prestador de serviço de CPF {$servidor->cpf} foi restaurado");
					exit();	
				}else{
					header("Location: home.php?msg=O Prestador de serviço de CPF {$servidor->cpf} já esta ativo");
					exit();	
				}
			}else{
				//outras atribuições
				$Servidor->cpf = addslashes($_POST['cpf']);
	            $Servidor->cnpj = addslashes($_POST['cnpj']);
	            $Servidor->nome_contato = addslashes($_POST['nome_contato']);
	            $Servidor->telefone_contato = addslashes($_POST['telefone_contato']);
    	        $Servidor->celular_contato = addslashes($_POST['celular_contato']);
	            $Servidor->nome_servidor = addslashes($_POST['nome_servidor']);
		        $Servidor->telefone_servidor = addslashes($_POST['telefone_servidor']);
	    	    $Servidor->celular_servidor = addslashes($_POST['celular_servidor']);
				$Servidor->cidade_servidor = addslashes($_POST['cidade_servidor']);
	       		$Servidor->uf_servidor = addslashes($_POST['uf_servidor']);
	       		$Servidor->status = addslashes($_POST['status']);
				$id = ServidorDAO::save($Servidor);
				header("Location: home.php");
				exit();	
			}
		}else{
		
			//verifica se o cpf que se quer cadastrar pertence a outro prestador	
			if(ServidorDAO::existeByCnpj($servidor->cnpj)){
			
				$servidor = ServidorDAO::findByCnpj($servidor->cnpj);
				//verifica se o servidor esta ativo
				if($servidor->status == 0){
					$servidor->status = addslashes($_POST['status']);
					$id = ServidorDAO::save($servidor);
					header("Location: home.php?msg=A Prestadora de serviço de CNPJ {$servidor->cnpj} foi restaurada");
					exit();
				}else{
					header("Location: home.php?msg=A Prestadora de serviço de CNPJ {$servidor->cnpj} já esta ativa");
				}
			}else{
				//outras atribuições
				$Servidor->cpf = addslashes($_POST['cpf']);
	            $Servidor->cnpj = addslashes($_POST['cnpj']);
	            $Servidor->nome_contato = addslashes($_POST['nome_contato']);
	            $Servidor->telefone_contato = addslashes($_POST['telefone_contato']);
    	        $Servidor->celular_contato = addslashes($_POST['celular_contato']);
	            $Servidor->nome_servidor = addslashes($_POST['nome_servidor']);
		        $Servidor->telefone_servidor = addslashes($_POST['telefone_servidor']);
	    	    $Servidor->celular_servidor = addslashes($_POST['celular_servidor']);
				$Servidor->cidade_servidor = addslashes($_POST['cidade_servidor']);
	       		$Servidor->uf_servidor = addslashes($_POST['uf_servidor']);
	       		$Servidor->status = addslashes($_POST['status']);
				$id = ServidorDAO::save($Servidor);
				header("Location: home.php");
				exit();	
			}
		}		
	}else{		
	
		//verifica se o cpf ou cnpj que se quer cadastrar existe e se ele não pertence ao prestador de serviço que se esta alterando
		if((ServidorDAO::existeByCpf($servidor->cpf) && ServidorDAO::existeByCpfId($servidor->cpf, $servidor->id)) and (ServidorDAO::existeByCnpj($servidor->cnpj) && ServidorDAO::existeByCnpjfId($servidor->cnpj, $servidor->id))) {
			if($servidor->cpf != ""){
				header("Location: home.php?msg=O CPF {$servidor->cpf} pertence a outro prestador de serviço");
			}else{
				header("Location: home.php?msg=O CNPJ {$servidor->cnpj} pertence a outra prestadora de serviço");
			}
			exit();	
		}else{
			//cria o objeto Servidor com os dados do Servidor que se esta alterando
			$Servidor = ServidorDAO::findByPk($servidor->id);
			
			//outras atribuições
			$Servidor->id = addslashes($_POST['id']);
			$Servidor->cpf = addslashes($_POST['cpf']);
            $Servidor->cnpj = addslashes($_POST['cnpj']);
            $Servidor->nome_contato = addslashes($_POST['nome_contato']);
            $Servidor->telefone_contato = addslashes($_POST['telefone_contato']);
            $Servidor->celular_contato = addslashes($_POST['celular_contato']);
            $Servidor->nome_servidor = addslashes($_POST['nome_servidor']);
	        $Servidor->telefone_servidor = addslashes($_POST['telefone_servidor']);
	        $Servidor->celular_servidor = addslashes($_POST['celular_servidor']);
			$Servidor->cidade_servidor = addslashes($_POST['cidade_servidor']);
	       	$Servidor->uf_servidor = addslashes($_POST['uf_servidor']);
	        $Servidor->status = addslashes($_POST['status']);
			$id = ServidorDAO::save($Servidor);
			header("Location: home.php");
			exit();			
			
		}
	
	}
	}else{
		$msg = "A cidade de origem da prestadora de serviços não pode estar vazia";
	}
	}else{
		$msg = "O CPF e o CNPJ da prestadora de serviços não pode estar vazio";
	}
	}else{
		$msg = "O nome da prestadora de serviços não pode estar vazio";
	}
				
}  

if(isset($_GET['id'])){
	$servidor = ServidorDAO::findByPk($_GET['id']);
	$ep = 0;
}else{
	//verifica se o su possue permissão para inserir(2) no modulo(29)
	if(!permissoesDAO::temPermissao(29,2,$usuario->id_tipo_usuario)){
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
				<td valign="top" background="images/topo_espaco.jpg"><a href="buscar.php"><img src="../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="adicionar.php"><img src="../images/botao_cadastrar.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="images/topo_espaco.jpg"><a href="excluir.php"><img src="../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
            <h1>PRESTADORES DE SERVIÇO</h1></td>
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
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaincalt(this)" name="servidor" id="servidor">
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
                        <td class="tabela1_titulo2" colspan="2">Dados da Prestadora de Serviços </td>
                      </tr>
                      <tr>
					  	<td class="tabela1_linha2"  align="right"> Nome</td>
						<td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nome_servidor" id="nome_servidor" size="30" maxlength="50" value="<?php=stripslashes($servidor->nome_servidor)?>"></td>
					  </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Telefone </td>
					    <td class="tabela1_linha2" ><input  name="telefone_servidor" type="text" class="FORMULARIO" id="telefone_servidor" value="<?php=stripslashes($servidor->telefone_servidor)?>" size="14" maxlength="14" onkeydown="FormataTEL(this,event)" onKeyPress="return Numero(event);" /></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Celular</td>
					    <td class="tabela1_linha2" ><input  name="celular_servidor" type="text" class="FORMULARIO" id="celular_servidor" value="<?php=stripslashes($servidor->celular_servidor)?>" size="14" maxlength="14" onkeydown="FormataTEL(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right">CNPJ:</td>
					    <td class="tabela1_linha2" ><input  name="cnpj" type="text" class="FORMULARIO" id="cnpj" value="<?php=stripslashes($servidor->cnpj)?>" size="18" maxlength="18" onkeydown="FormataCNPJ(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right">CPF:</td>
					    <td class="tabela1_linha2" ><input  name="cpf" type="text" class="FORMULARIO" id="cpf" value="<?php=stripslashes($servidor->cpf)?>" size="14" maxlength="14" onkeydown="FormataCPF(this,event)" onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2" align="right">Estado:</td>
	                    <td class="tabela1_linha2"><SELECT class="FORMULARIO" name="uf_servidor">
						<OPTION VALUE="" > -- Selecione -- </OPTION>
						<OPTION VALUE="AC">Acre</OPTION>
						<OPTION VALUE="AL">Alagoas</OPTION>
						<OPTION VALUE="AP">Amapá</OPTION>
						<OPTION VALUE="AM">Amazonas</OPTION>
						<OPTION VALUE="BA">Bahia</OPTION>
						<OPTION VALUE="CE">Ceará</OPTION>
						<OPTION VALUE="DF">Distrito Federal</OPTION>
						<OPTION VALUE="ES">Espírito Santo</OPTION>
						<OPTION VALUE="GO">Goiás</OPTION>
						<OPTION VALUE="MA">Maranhão</OPTION>
						<OPTION VALUE="MT">Mato Grosso</OPTION>
						<OPTION VALUE="MS">Mato Grosso do Sul</OPTION>
						<OPTION VALUE="MG">Minas Gerais</OPTION>
						<OPTION VALUE="PA">Pará</OPTION>
						<OPTION VALUE="PB">Paraíba</OPTION>
						<OPTION VALUE="PR">Paraná</OPTION>
						<OPTION VALUE="PE">Pernambuco</OPTION>
						<OPTION VALUE="PI">Piauí</OPTION>
						<OPTION VALUE="RJ">Rio de Janeiro</OPTION>
						<OPTION VALUE="RN" SELECTED>Rio Grande do Norte</OPTION>
						<OPTION VALUE="RS">Rio Grande do Sul</OPTION>
						<OPTION VALUE="RO">Rondônia</OPTION>
						<OPTION VALUE="RR">Roraima</OPTION>
						<OPTION VALUE="SC">Santa Catarina</OPTION>
						<OPTION VALUE="SP">São Paulo</OPTION>
						<OPTION VALUE="SE">Sergipe</OPTION>
						<OPTION VALUE="TO">Tocantins</OPTION>
						</SELECT>
						</td>
				      </tr>
					  <tr>
					    <td class="tabela1_linha2" align="right">Cidade</td>
	<td class="tabela1_linha2"><input  name="cidade_servidor" type="text" class="FORMULARIO" id="cidade_servidor" value="<?php=stripslashes($servidor->cidade_servidor)?>" size="25" maxlength="25" /></td>
				      </tr>
					  
					  <tr>
                        <td class="tabela1_titulo2" colspan="2">Dados do Contato na Prestadora de Serviços </td>
                      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Nome</td>
					    <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nome_contato" id="nome_contato" size="30" maxlength="50" value="<?php=stripslashes($servidor->nome_contato)?>" /></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Telefone </td>
					    <td class="tabela1_linha2" ><input  name="telefone_contato" type="text" class="FORMULARIO" id="telefone_contato" value="<?php=stripslashes($servidor->telefone_contato)?>" size="14" maxlength="14" onkeydown="FormataTEL(this,event)"   onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Celular</td>
					    <td class="tabela1_linha2" ><input  name="celular_contato" type="text" class="FORMULARIO" id="celular_contato" value="<?php=stripslashes($servidor->celular_contato)?>"size="14" maxlength="14" onkeydown="FormataTEL(this,event)"  onKeyPress="return Numero(event);"/></td>
				      </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2">Situação</td>
				        <td  align="right" class="tabela1_linha2"><div align="left">Ativo
				          <input name="status" type="radio" value="1"  <?php  if ( $servidor->status == 1) { ?> checked="checked" <?php  }?>/>
				          Inativo
  <input name="status" type="radio" value="0"   <?php  if ( $servidor->status == 0) { ?>checked="checked"<?php  }?> />
                        </div></td>
					  </tr>
					  <tr>
                        <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
                        <input type="image" src="../images/enviar.jpg" /></div></td>
				      </tr>
					  
                  </table>
			      </td>
                </tr>
              </table> 
			   <input type="hidden"  name="id" value="<?php=stripslashes($servidor->id)?>" />
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
