<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/servicosTerceirizados.php");
require_once("../php/servicosTerceirizadosDAO.php");
require_once("../php/tiposservicos.php");
require_once("../php/tiposservicosDAO.php");
require_once("../php/servidor.php");
require_once("../php/servidorDAO.php");
require_once("../php/receitadespesa.php");
require_once("../php/receitadespesaDAO.php");
require_once("../php/centrocustos.php");
require_once("../php/centrocustosDAO.php");
require_once("../php/areacustos.php");
require_once("../php/areacustosDAO.php");
require_once("../php/ftp.php");


@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
if (!($usuario->logado)){
	header("Location: ../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();

$servico = new servicosTerceirizados();
$condominio = condominiosDAO::findByPk($id_condominio); 



//recolhendo variáveis
if (isset($_GET['mes'])){
	$mes = stripslashes($_GET['mes']);
}else{
	if (isset($_POST['mes'])){
		$mes = stripslashes($_POST['mes']);
	}else{
		$mes = stripslashes($_SESSION['mes']);
	}
}

if (isset($_GET['ano'])){
	$ano = stripslashes($_GET['ano']);
}else{
	if (isset($_POST['ano'])){
		$ano = stripslashes($_POST['ano']);
	}else{
		$ano = stripslashes($_SESSION['ano']);
	}
}

if(isset($_GET['id'])){
	$servico = servicosTerceirizadosDAO::findByPk($_GET['id']);
}


if ( isset($_POST['id']) and $_POST['id'] != 0 ){	
	//verifica se o su possue permissão para alterar(1) no modulo(24)
	if(!permissoesDAO::temPermissao(24,1,$usuario->id_tipo_usuario)){	
		header("Location: ../index.php");
		exit();
	}		
	
	$servico = servicosTerceirizadosDAO::findByPk($_POST['id']);
	if($_FILES['arquivo']['name'] != ""){
	
		$arquivo = $_FILES['arquivo'];			
		$nome = "nota".$condominio->id."_".$servico->id.$_FILES['arquivo']['name'];	

		$ftp = new Ftp();
		if($ftp->salvaNota($condominio->id, $arquivo, $nome)){
			//verifica se a nota inserida esta nos padrôes solicitados
			if (!(($_FILES["arquivo"]["type"] == "image/gif") || ($_FILES["arquivo"]["type"] == "image/jpeg") || ($_FILES["arquivo"]["type"] == "image/pjpeg") || ($_FILES["arquivo"]["type"] == "image/jpg")) ) {
				ftp::deletanota($nome, $condominio->id); // deleta nota nova 
				$msg = "Não foi possível inserir a nota pois esta se encontra fora dos padrões solicitados";
			}else{				
				//verifica se já exisita uma nota anterior
				if($servico->copia_nota != "" and $servico->copia_nota != $nome){					
					ftp::deletanota($servico->copia_nota, $condominio->id); //deleta nota antiga
				}				
				$servico->copia_nota = $nome;	
				servicosTerceirizadosDAO::save($servico);
			}
		}else{
			$msg = "Não foi possível inserir a nota";
		}		
	}else{
		$msg = "Não foi possível inserir a nota, pois não foi selecionado nenhum arquivo";
	}	
} 


	
//cria as sessões de navegação para datas
$_SESSION['mes'] = $mes;
$_SESSION['ano'] = $ano;	
	
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

function adiciona_despesa(){
url = '../despesa/adicionar.php';
window.open(url,"Nova Despesa","resizable,width=573,height=130");
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
                <td width="266" valign="top" background="../images/topo_espaco.jpg">&nbsp;</td>
                 
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
          <h1>SERVIÇOS TERCEIRIZADOS</h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
              <p align="center" class="fontelinkPreto">
         <br />
            <br />
             <br />
            CONDOMÍNIO -&gt; <strong><?php=$condominio->nome?></strong><br />
            Serviço terceirizado-&gt; <strong><a href="home.php" >
            <?php=$servico->despesa->documento?>
             </a></strong><br />
            <br />
			
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
                        <td width="89%" class="tabela1_titulo1">Nota Fiscal </td>                       
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
					    <tr>
                        <td class="tabela1_titulo2">Nota Fiscal (miniatura) </td>
                        <td class="tabela1_titulo2">Cadastro de Nota Fiscal </td>
				      </tr>					 
					    <tr>
					      <td width="50%"  align="right" class="tabela1_linha2"><div align="center"><br />
				            <?php 
	 						 if ($servico->copia_nota!=""){
							?>
				            <table>
                              <tr>
                                <td><a href="#"><img src="nota/<?php=$condominio->id?>/<?php=$servico->copia_nota?>" width="171" height="114" border="0" onclick="MM_openBrWindow('nota/<?php=$condominio->id?>/<?php=$servico->copia_nota?>','Nota','scrollbars=yes,resizable=yes,width=500,height=500')" /> </a></td>
                              </tr>
                            </table>
															 <a href="apagarNota.php?id=<?php=$id?>">Apagar essa Nota </a>
					        <?php 
								}
							?>
				            <br />
				           </div></td>
				          <td width="50%"  align="right" class="tabela1_linha2">
						  <form action="adicionarNota.php?id=<?php=$id?>" method="post" enctype="multipart/form-data">
						  <table align="center">
                                  <tr>
                                    <td width="46" class="tabela1_linha2">Nota:</td>
                                    <td width="218"><input name="arquivo" type="file" class="FORMULARIO" size="10" />
                                    <span class="warning">*</span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" class="verdanaVerde"><div align="center">
                                        <input type="hidden" value="<?php=$_GET['id']?>" name="id" />
                                      <input name="image" type="image" src="../images/enviar.jpg" />
                                    </div></td>
                                  </tr>
                          </table>
						  </form> 
						 </td>
				      </tr>
					  <tr>
					  	<td colspan="2" class="tabela1_linhaWarning">
						*O arquivo da nota fiscal deve:<br />
						*---&gt;Ter um tamanho menor que 2 Mb<br />
						*---&gt;Estar em um dos formatos a seguir: .jpg | .jpeg | .gif </td>
					  </tr>
                  </table>
				  
			      </td>
                </tr>
              </table> 
		   
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
