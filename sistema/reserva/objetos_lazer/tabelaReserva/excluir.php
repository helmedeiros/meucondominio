<?php 
require_once("../../../php/conexao.php");
require_once("../../../php/condominios.php");
require_once("../../../php/condominiosDAO.php");
require_once("../../../php/superusuario.php");
require_once("../../../php/superusuarioDAO.php");
require_once("../../../php/permissoes.php");
require_once("../../../php/permissoesDAO.php");
require_once("../../../php/arealazer.php");
require_once("../../../php/arealazerDAO.php");
require_once("../../../php/objetolazer.php");
require_once("../../../php/objetolazerDAO.php");
require_once("../../../php/funcionamento.php");
require_once("../../../php/funcionamentoDAO.php");
require_once("../../../php/reserva.php");
require_once("../../../php/reservaDAO.php");
require_once("../../../php/membroscondominio.php");
require_once("../../../php/membroscondominioDAO.php");
@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
if ( !($usuario->logado) ){
	header("Location: ../../logoff.php");
	exit();
}

if (($usuario->id_tipo_usuario != 1)){
	header("Location: ../../logoff.php");
	exit();
}

$con = new Conexao();
$con->conecta();

//verifica se o su possue permissão para excluir(3) em centro de custo(14)
if(!permissoesDAO::temPermissao(14,3,$usuario->id_tipo_usuario)){
	header("Location: ../../index.php");
	exit();
}
	
//recolhendo variáveis
if (isset($_GET['area'])){
	$area = $_GET['area'];
}else{
	$area = $_POST['area'];
}

//recolhendo variáveis
if (isset($_GET['objeto'])){
	$objeto = $_GET['objeto'];
}else{
	$objeto = $_POST['objeto'];
}

if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
}else{
	$msg = $_POST['msg'];
}

if(isset($_GET['data'])){
	$_POST['mes'] = $_GET['data'][5].$_GET['data'][6];
	$_POST['dia'] = $_GET['data'][8].$_GET['data'][9];
	$_POST['ano'] = $_GET['data'][0].$_GET['data'][1].$_GET['data'][2].$_GET['data'][3];
}

if(!isset($_POST['mes'])){
	$_POST['mes'] = date("m",time());
	$_POST['dia'] = date("d",time());
	$_POST['ano'] = date("Y",time());
}

if ( isset($_POST['id']) && is_numeric($_POST['id']) ){
	//verifica se o usuário que esta tentando realizar a exclusao é dono ou ou sindico
	if($usuario->id_tipo_usuario == 1){
		reservaDAO::delete($_POST['id']);
	}
	$condominio->id_contato =  0;
	$id = condominiosDAO::save($condominio);		
}

if ( isset($area) && is_numeric($area) && isset($objeto) && is_numeric($objeto)){
	$condominio = condominiosDAO::findByPk($id_condominio); 	
	$areas = arealazerDAO::findByPk($area);
	$objetos = objetolazerDAO::findByPk($objeto);	
}

$membros = membroscondominioDAO::findTopByBusca("", "", $condominio->id);

$classe = "tabela1_linha2";
$pontinhos = "../../../";

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
<script language="javascript" type="text/javascript" src="../../../js/funcoes.js">
</script>
<link href="../../../inc/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#ffffff">

<table width="714" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td><img src="../../../images/spacer.gif" width="169" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="25" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="178" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="78" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="87" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="90" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="48" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="39" height="1" border="0" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
    <td rowspan="9" valign="top" background="../../../images/complemento_menu_bottom.jpg"><?php  include("../../../inc/menu.php"); ?></td>
    <td colspan="7" rowspan="9" valign="top" background="../../../images/bg_geral_box.jpg" bgcolor="#FFFFFF"><table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><!-- menu superior -->
            <table width="545" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="533" valign="top" background="../../../images/topo_espaco.jpg"><img src="../../../images/topo_espaco.jpg" width="203" height="40" /></td>
                <td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="home.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/botao_listar_off.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="buscar.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="adicionar.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/botao_cadastrar_off.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="../../../area_lazer/centro_custo/images/topo_espaco.jpg"><a href="excluir.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/botao_excluir.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../../../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>RESERVAS</h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../../../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
            <p align="center" class="fontelinkPreto">
       		<br />
            <br />
            <br />
            CONDOMÍNIO -&gt; <strong><?php=$condominio->nome?></strong><br />
            Área de Lazer -&gt; <strong><a href="../../home.php" ><?php=stripslashes($areas->nome)?></a></strong><br />
            Objeto de Lazer -&gt; <strong><a href="../home.php?area=<?php=$areas->id?>" ><?php=stripslashes($objetos->nome)?></a></strong><br />
		    <div align="center">
			  <font class="warning">
			    <?php  if(isset($msg) )
						echo $msg;?>
		      </font>
			    <br />
			    <br />
            </div>
			
			<form onsubmit="return checa_formulario(this)" action="adicionar.php" method="post">
              <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="13%"><span class="style3">Selecione:</span></td>
                  <td width="21%"><select name="dia">
                      <option value="selecione">Escolha o dia</option>
                      <?php   for($i = 1; $i <= 31; $i++){ 
									if($i < 10) {
										$a = '0'.$i;
									}else{ $a = $i; }
							?>
                      <option value="<?php=$a?>">
                        <?php=$a?>
                      </option>
                      <?php  }  ?>
                    </select>
                  </td>
                  <td width="23%"><select name="mes">
                      <option  value="selecione">Escolha o mês</option>
                      <?php   for($i = 1; $i <= 12; $i++){ 
									if($i < 10) {
										$a = '0'.$i;
									}else{ $a = $i; }
							?>
                      <option value="<?php=$a?>">
                        <?php=$a?>
                      </option>
                      <?php  }  ?>
                  </select></td>
                  <td width="21%"><select name="ano">
                      <option  value="selecione">Escolha o ano</option>
                      <option value="<?php=date("Y",time())?>">
                        <?php=date("Y",time())?>
                      </option>
                  </select></td>
                  <td width="22%"><div align="center">
                    <input name="image" type="image" src="../../../images/lupa.jpg" />
                  </div></td>
                </tr>
              </table>
			  <input type="hidden" name="area" value="<?php=$areas->id?>" />
              <input type="hidden" name="objeto" value="<?php=$objetos->id?>" />
            </form>
			<?php  if(checkdate($_POST['mes'], $_POST['dia'] , $_POST['ano'])){ 
				  		if($_POST['ano'] >= date("Y",time()) and $_POST['mes'] >= date("m",time()) and $_POST['dia'] >= date("d",time())) $libera = 1;
		    ?>			 
            <table width="96%" cellpadding="0" cellspacing="0" class="tabela1">
                <tr>
                  <td width="460" bgcolor="#6598CB"><table width="460" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="407" class="tabela1_titulo1">Reservas do dia ( <?php=$_POST['dia']."/".$_POST['mes']."/".$_POST['ano']?> )</td>
                        <td width="51"><a href="home.php?area=<?php=$area?>&objeto=<?php=$objeto?>"><img src="../../../images/listar.jpg" width="48" height="17" border="0" /></a></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
                    <tr>
                      <td width="11%" class="tabela1_titulo2">Horário </td>
                      <td width="13%" class="tabela1_titulo2" align="center">STATUS</td>
                      <td width="71%" class="tabela1_titulo2" align="center">CONDÔMINO/APTº</td>
                      <td width="5%" class="tabela1_titulo2" align="center">&nbsp;</td>
                    </tr>
                    <?php 					
					$inicio = (int)substr($objetos->inicio,0,2).substr($objetos->inicio,3,2);
					$fim = (int)substr($objetos->fim,0,2).substr($objetos->fim,3,2);
					$tempoMinimo = (int)substr($objetos->tempo_minimo,0,2).substr($objetos->tempo_minimo,3,2);
					$data = substr($objetos->inicio,0,5); 			
					
					while($inicio < $fim){		
						$dataInicio = $_POST['ano']."-".$_POST['mes']."-".$_POST['dia'].' '.$data;
						$reserva = reservaDAO::findTopByBusca($objeto, "", "", $dataInicio, "");	
								
					?>
                    <tr>
                      <td class="<?php=$classe?>" nowrap="nowrap"><a href="#">
                        <?php=$data?>
                      </a></td>
                      <td class="<?php=$classe?>" nowrap="nowrap"><div align="center"><a href="#">
                          <?php  if($reserva){?>
                        X
                        <?php  }?>
                      </a></div></td>
                      <td class="<?php=$classe?>"><div align="center" class="style3">
                          <?php  if($reserva){
							$membro = membroscondominioDAO::findByPk($reserva[0]->id_membro);
						?>
                          <?php=$membro->nome?>
                        /
                        <?php=$membro->numero_apartamento?>
                        <?php  }else{?>
                        -
                        <?php  }?>
                      </div></td>
                      <td class="<?php=$classe?>"><div align="center" class="style3">
					  <?php  if(($membro->nome == $usuario->nome or $usuario->id_tipo_usuario == 1) and $reserva[0]->id != ""){?>
                        <form action="excluir.php" method="post" onsubmit="javascript:return confirma('<?php=$reserva[0]->data_inicio?>','Reserva')">
                          <input name="image2" type="image" src="../../../images/xis.jpg" width="20" height="21" border="0" />
                          <input type="hidden" value="<?php=$reserva[0]->id?>" name="id" />
						  <input type="hidden" name="area" value="<?php=$areas->id?>" />
			            <input type="hidden" name="objeto" value="<?php=$objetos->id?>" />
                        </form>
						<?php  }?>
                        </div></td>
                    </tr>
                    <?php 
					$var = "";
					
							$inicio += $tempoMinimo;
							
							if($inicio < 1000){
								$tempM = (int)substr($inicio,1,2);
							}else{
								$tempM = (int)substr($inicio,2,2);
							}
							
							if($tempM >= 60){
								$inicio = $inicio - 60;
								$inicio += 100;
							}
							if($inicio < 1000){
								$data = '0'.substr($inicio,0,1).':'.substr($inicio,1,2);
							}else{
								$data = substr($inicio,0,2).':'.substr($inicio,2,2);
							}
						}
					?>
                  </table></td>
                </tr>
            </table>
			<div align="center"><br />
			</div>
			<?php 
				}
			?>
			
			<br />
			<br />			   
            <br />
              </p></td>
          <td width="39" background="../../../images/ld_box_bg.jpg">&nbsp;</td>
        </tr>
      </table></td>
   <td><img src="../../../images/spacer.gif" width="1" height="40" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="71" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="83" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="48" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="73" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="54" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../../images/spacer.gif" width="1" height="26" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><img name="fim_box" src="../../../images/fim_box.jpg" width="714" height="32" border="0" id="fim_box" alt="" /></td>
   <td><img src="../../../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><div align="center">
     <table width="655" border="0" align="right" cellpadding="0" cellspacing="0">
       <tr>
         <td><div align="center"><img src="../../../images/rodape.jpg" width="583" height="23" /></div></td>
       </tr>
     </table>
   </div></td>
   <td><img src="../../../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
</table>
 </body>
</html>
