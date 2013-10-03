<?php 
require_once("php/conexao.php");
require_once("php/condominios.php");
require_once("php/condominiosDAO.php");
require_once("php/superusuario.php");
require_once("php/superusuarioDAO.php");
require_once("php/permissoes.php");
require_once("php/permissoesDAO.php");
require_once("php/contatos.php");
require_once("php/contatosDAO.php");



@session_start();

$usuario = $_SESSION['usuario'];
if ( !($usuario->logado) ){
	header("Location: index.php");
	exit();
}

if (($usuario->id_tipo_usuario != 1)){
	header("Location: index.php");
	exit();
}

$con = new Conexao();
$con->conecta();

$pontinhos = "";

$dias = array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb");
$situacao = array( "Desativado","Ativado");

$usuarios = SuperUsuarioDAO::findTop(0,10);
$ultimos_condominios = condominiosDAO::findTop(0,3,"data_insercao","DESC");
$meuscondominio = condominiosDAO::findTopByBusca("", "", "", $usuario->id, 0, 5, "data_insercao","DESC");

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
<link href="inc/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#ffffff">

<table width="714" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td><img src="images/spacer.gif" width="169" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="25" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="178" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="78" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="87" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="90" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="48" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="39" height="1" border="0" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
    <td rowspan="9" valign="top" background="images/complemento_menu_bottom.jpg"><?php  include("inc/menu.php"); ?></td>
    <td colspan="7" rowspan="9" valign="top" background="images/bg_geral_box.jpg" bgcolor="#FFFFFF"><table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><!-- menu superior -->
            <table width="545" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="533" valign="top" background="images/topo_espaco.jpg"><img src="images/topo_espaco.jpg" width="203" height="40" /></td>
                <td width="12" valign="bottom" background="images/topo_espaco.jpg"><img src="images/canto.jpg" width="12" height="9" border="0" /></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="images/topo_box.jpg"><!-- titulo da secao -->
            <h1>BEM VINDO <?php=strtoupper($usuario->nome)?></h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
              <p>
            <br />
            <br />
            <span class="verdanaAzul">Você acessou o sistema <?php=$usuario->numero_acessos?> vezes desde <?php=$usuario->data_criacao[8].$usuario->data_criacao[9]."/".$usuario->data_criacao[5].$usuario->data_criacao[6]."/".$usuario->data_criacao[0].$usuario->data_criacao[1].$usuario->data_criacao[2].$usuario->data_criacao[3]." ".$usuario->data_criacao[11].$usuario->data_criacao[12]?>
            </a></span> <br />
            <br />
            <br />
            <br />
            <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                <tr>
                  <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="89%" class="tabela1_titulo1">Últimos Condomínios </td>
                        <td width="11%"><a href="condominio/home.php?ordem=DESC&orderBy=data_insercao"><img src="images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
                      <tr>
                        <td width="20%" class="tabela1_titulo2">Condomínio</td>
                        <td width="26%" class="tabela1_titulo2">Data</td>
                        <td width="49%" class="tabela1_titulo2">SU Responsável</td>
                        <td width="5%" class="tabela1_titulo2">&nbsp;</td>
                      </tr>
					  <?php  for($i = 0; $i < sizeof($ultimos_condominios); $i++){ 
					  		$superusuario = superusuarioDAO::findResp($ultimos_condominios[$i]->id_responsavel);
					  ?>
                      <tr>
                        <td class="tabela1_linha2" nowrap="nowrap"><a href="#"><?php=substr($ultimos_condominios[$i]->nome,0,9)?><?php  if(strlen($ultimos_condominios[$i]->nome) > 9){?>...<?php  }?></a></td>
                        <td nowrap="NOWRAP" class="tabela1_linha2"><a href="#"><?php=$dias[date('w',strtotime($ultimos_condominios[$i]->data_criacao))]?>, <?php=$ultimos_condominios[$i]->data_criacao[8].$ultimos_condominios[$i]->data_criacao[9]?>/<?php=$ultimos_condominios[$i]->data_criacao[5].$ultimos_condominios[$i]->data_criacao[6]?> - <?php=$ultimos_condominios[$i]->data_criacao[11].$ultimos_condominios[$i]->data_criacao[12]?>:<?php=$ultimos_condominios[$i]->data_criacao[14].$ultimos_condominios[$i]->data_criacao[15]?></a></td>
                        <td nowrap="NOWRAP" class="tabela1_linha2"><a href="#"><?php=$superusuario->nome?></a></td>
                        <td class="tabela1_linha2" nowrap="nowrap"><a href="condominio/adicionar.php?id=<?php=$ultimos_condominios[$i]->id?>"><img src="images/mais.jpg" width="20" height="21" border="0" /></a></td>
                      </tr>
					  <?php 
					  	}
					  ?>
                  </table></td>
                </tr>
            </table>  
              <br />
              <br />
				<table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                  <tr>
                    <td><table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="93%" class="tabela1_titulo1"> Meus Condomínios </td>
                          <td width="8%" bgcolor="#6598CB" ><div align="right"><a href="condominio/buscar.php?responsavel=<?php=$usuario->id?>"><img src="images/listar.jpg" width="48" height="17" border="0" /></a></div></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table cellpadding="1" cellspacing="1" width="100%">
                        <tr>
                          <td width="19%" class="tabela1_titulo2">Condomínio</td>
                          <td width="22%" class="tabela1_titulo2">Data</td>
                          <td width="32%" class="tabela1_titulo2">Contato</td>
                          <td width="19%" class="tabela1_titulo2">Situação</td>
                          <td width="8%" class="tabela1_titulo2">&nbsp;</td>
                        </tr>
						<?php  for($i = 0; $i < sizeof($meuscondominio); $i++){
								$contato = contatosDAO::findByPk($meuscondominio[$i]->id_contato);
						?>
                        <tr>
                          <td class="tabela1_linha2" nowrap="nowrap"><a href="#"><?php=substr($meuscondominio[$i]->nome,0,9)?><?php  if(strlen($meuscondominio[$i]->nome) > 9){?>...<?php  }?> </a></td>
                          <td class="tabela1_linha2" nowrap="nowrap"><a href="#"><?php=$dias[date('w',strtotime($meuscondominio[$i]->data_criacao))]?>, <?php=$meuscondominio[$i]->data_criacao[8].$meuscondominio[$i]->data_criacao[9]?>/<?php=$meuscondominio[$i]->data_criacao[5].$meuscondominio[$i]->data_criacao[6]?> - <?php=$meuscondominio[$i]->data_criacao[11].$meuscondominio[$i]->data_criacao[12]?>:<?php=$meuscondominio[$i]->data_criacao[14].$meuscondominio[$i]->data_criacao[15]?></a></td>
                          <td class="tabela1_linha2" nowrap="nowrap"><a href="#"><?php=$contato->nome?> </a></td>
                          <td class="tabela1_linha2" nowrap="nowrap"><a href="#"><?php=$situacao[$meuscondominio[$i]->status]?></a></td>
                          <td class="tabela1_linha2" nowrap="nowrap"><a href="condominio/adicionar.php?id=<?php=$meuscondominio[$i]->id?>"><img src="images/mais.jpg" width="20" height="21" border="0" /></a></td>
                        </tr>
						<?php 
							}
						?>
                    </table></td>
                  </tr>
                </table>
				<br />
				<br />
				<?php 
				if ($usuarios){
			?>
            <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                <tr>
                  <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="89%" class="tabela1_titulo1">Super-usuários </td>
                        <td width="11%"><a href="super_usuario/home.php"><img src="images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
                      <tr>
                        <td width="53%" class="tabela1_titulo2">Super-Usuário</td>
                        <td width="40%" class="tabela1_titulo2">Celular</td>
                        <td width="7%" class="tabela1_titulo2">&nbsp;</td>
                      </tr>
					    <?php 
							for ($i = 0; $i < sizeof($usuarios); $i++){
						?>
                      <tr>
                        <td class="tabela1_linha2" nowrap="nowrap"><a href="#"><?php=$usuarios[$i]->nome?></a></td>
                        <td class="tabela1_linha2" nowrap="nowrap"><a href="#"><?php=$usuarios[$i]->celular?></a></td>
                        <td class="tabela1_linha2" nowrap="nowrap"><a href="super_usuario/adicionar.php?id=<?php=$usuarios[$i]->id?>"><img src="images/mais.jpg" width="20" height="21" border="0" /></a></td>
                      </tr>
					  	<?php 
							}
						?>
                  </table>
				    <div align="center"><span class="verdanaAzul">
			        <?php 
				  	}else{					
				  ?>
			        Não existem super-usuários cadastrados
			        <?php 	
					}
				  ?>				  
		          </span></div></td>
                </tr>
              </table>  
		  </p>          </td>
          <td width="39" background="images/ld_box_bg.jpg">&nbsp;</td>
        </tr>
      </table></td>
   <td><img src="images/spacer.gif" width="1" height="40" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="71" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="83" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="48" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="73" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="54" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="images/spacer.gif" width="1" height="26" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><img name="fim_box" src="images/fim_box.jpg" width="714" height="32" border="0" id="fim_box" alt="" /></td>
   <td><img src="images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><div align="center">
     <table width="655" border="0" align="right" cellpadding="0" cellspacing="0">
       <tr>
         <td><div align="center"><img src="images/rodape.jpg" width="583" height="23" /></div></td>
       </tr>
     </table>
   </div></td>
   <td><img src="images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
</table>
 </body>
</html>
