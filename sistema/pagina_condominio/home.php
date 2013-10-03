<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/contatos.php");
require_once("../php/contatosDAO.php");
require_once("../php/membroscondominio.php");
require_once("../php/membroscondominioDAO.php");


@session_start();

$usuario = $_SESSION['usuario'];

//verifica se o usuário foi redirecionado para a pagina do condominio pelo combobox do menu alterando a variável de sessão que registra o condominio ativo
if(isset($_POST['id_condominio'])){
	$_SESSION['id_condominio'] = $_POST['id_condominio'];
}

$id_condominio = $_SESSION['id_condominio'];

if ( !($usuario->logado) ){
	header("Location: ../logoff.php");
	exit();
}

if (($usuario->id_tipo_usuario != 1)){
	header("Location: ../logoff.php");
	exit();
}

$con = new Conexao();
$con->conecta();

//verifica se o su possue permissão para visualizar(4) no modulo(35)
if(!permissoesDAO::temPermissao(35,4,$usuario->id_tipo_usuario)){
	header("Location: ../index.php");
	exit();
}

$condominio = condominiosDAO::findByPk($id_condominio);
$contato = contatosDAO::findByPk($condominio->id_contato);

//conta a quantidade de membros do condomínio e atribui ao array de objetos membros os objetos resultantes da busca
$totalMembros = membroscondominioDAO::countByBusca("","",$id_condominio);
$membros = membroscondominioDAO::findTopByBusca("","",$id_condominio,0,$total_mural,"nome");
//calcula a quantidade de objetos na primeira coluna  de membros
$nmTr = intval($totalMembros/2);
if(floatval($totalMembros/2) != intval($totalMembros/2)){	
	$nmTr += 1;
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
                <td width="12" valign="bottom" background="../images/topo_espaco.jpg"><img src="../images/canto.jpg" width="12" height="9" border="0" /></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../images/topo_box.jpg"><!-- titulo da secao -->
            <h1>PÁGINA DO CONDOM&Iacute;NIO</h1></td>
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
                        <td width="89%" class="tabela1_titulo1">Dados do Condomínio </td>
                        <td width="11%"><a href="../condominio/adicionar.php?id=<?php=$condominio->id?>"><img src="../images/editar.jpg" width="53" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">                    
                   <tr> 
					  	<td width="26%"  align="right" class="tabela1_linha2"> Nome:</td>
						<td class="tabela1_linha2" ><?php=$condominio->nome?></td>
				    </tr>
					  <tr>
                        <td  align="right" class="tabela1_linha2"> CNPJ: </td>
					    <td class="tabela1_linha2" ><?php=$condominio->CNPJ?></td>
				    </tr>
					  <tr>
                        <td  align="right" class="tabela1_linha2"> Telefone: </td>
					    <td class="tabela1_linha2" ><?php=$condominio->telefone?></td>
					  </tr>
					  <tr>
                        <td  align="right" class="tabela1_linha2">
                          <div align="right">QTD Blocos:</div></td>
				      <td  align="right" class="tabela1_linha2">
				        <div align="left">
				          <?php=$condominio->qtd_blocos?>
			            </div></td>
			          </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2"><div align="right">QTD Apartamentos:</div></td>
				      <td  align="right" class="tabela1_linha2">
				        <div align="left">
				          <?php=$condominio->qtd_apartamentos?>
			            </div></td>
			          </tr>
					  <tr>
					    <td rowspan="7"  align="right" class="tabela1_linha2">Endere&ccedil;o:</td>
					    <td class="tabela1_linha2" ><?php=$condominio->tipo_logradouro?>
                          </p>
                          <?php=$condominio->logradouro?>
                          <?php=$condominio->numero_logradouro?>
                          <?php=$condominio->bairro_logradouro?>
                          <br />
                          <?php=$condominio->cidade_logradouro?>
-
<?php=$condominio->uf_logradouro?>
<br />
<?php=$condominio->cep_logradouro?></td>
				      </tr>
					 
					                         
                  </table></td>
                </tr>
            </table>
			<br />
			<br />
			<table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
              <tr>
                <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="89%" class="tabela1_titulo1">Dados do Contato </td>
                      <td width="11%"><a href="../contato/adicionar.php?id=<?php=$contato->id?>"><img src="../images/editar.jpg" width="53" height="17" border="0" /></a></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table cellpadding="1" cellspacing="1" width="100%">
                    <tr>
                      <td width="26%"  align="right" class="tabela1_linha2"> Nome:</td>
                      <td width="74%" class="tabela1_linha2" ><?php=$contato->nome?></td>
                    </tr>
                    <tr>
                      <td  align="right" class="tabela1_linha2"> Telefone: </td>
                      <td class="tabela1_linha2" ><?php=$contato->telefone?></td>
                    </tr>
					 <tr>
                      <td  align="right" class="tabela1_linha2"> Observações: </td>
                      <td class="tabela1_linha2" ><?php=$contato->descricao?></td>
                    </tr>


                </table></td>
              </tr>
            </table>
			<br />
			<br />
			<table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
              <tr>
                <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="89%" class="tabela1_titulo1">Membros do condomínio </td>
                      <td width="11%"><a href="../membro_condominio/home.php"><img src="../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table cellpadding="1" cellspacing="1" width="100%">
                    <tr>										  
                      <td width="50%" align="left" class="tabela1_linha2" valign="top">
					  	<?php  	$cont = 1;
							for($i = 0; $i < $nmTr; $i++){?>
					  			<a href="../membro_condominio/adicionar.php?id=<?php=$membros[$i]->id?>"><?php=$cont?>. <?php=$membros[$i]->nome?></a><br />
					  	<?php  	$cont++;
							}
						?>
					  </td>
                      <td width="50%" align="left" class="tabela1_linha2" valign="top">
					  <?php 	for($i = ($cont-1); $i < $totalMembros; $i++){?>
					  			<a href="../membro_condominio/adicionar.php?id=<?php=$membros[$i]->id?>"><?php=$cont?>. <?php=$membros[$i]->nome?></a><br />
					  	<?php  	$cont++;
							}
						?>
					  </td>
                    </tr>
                    
                </table></td>
              </tr>
            </table>
			<br />
			<br />			   
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
