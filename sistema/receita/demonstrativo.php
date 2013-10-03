<?php 
require_once("../php/conexao.php");
require_once("../php/condominios.php");
require_once("../php/condominiosDAO.php");
require_once("../php/superusuario.php");
require_once("../php/superusuarioDAO.php");
require_once("../php/permissoes.php");
require_once("../php/permissoesDAO.php");
require_once("../php/receitadespesa.php");
require_once("../php/receitadespesaDAO.php");
require_once("../php/centrocustos.php");
require_once("../php/centrocustosDAO.php");
require_once("../php/areacustos.php");
require_once("../php/areacustosDAO.php");

@session_start();

$usuario = $_SESSION['usuario'];
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

//verifica se o su possue permissão para visualizar(4) no modulo(25)
if(!permissoesDAO::temPermissao(25,4,$usuario->id_tipo_usuario)){
	header("Location: ../index.php");
	exit();
}


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


if ( isset($mes) && is_numeric($mes) ){	
	$mes = $mes;
}else{
	$mes = date("m",time());	
}

if ( isset($ano) && is_numeric($ano) ){	
	$ano = $ano;
}else{
	$ano = date("Y",time());	
}

if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
}else{
	$msg = $_POST['msg'];
}

//cria as sessões de navegação para datas
$_SESSION['mes'] = $mes;
$_SESSION['ano'] = $ano;


$receitas = ReceitaDespesaDAO::findTopByBusca("", $mes, $ano, $id_condominio, 'receita',"",2);
$condominio = condominiosDAO::findByPk($id_condominio); 
$classe = "tabela1_linha2";
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
<script language="javascript" type="text/javascript" src="../js/hint.js">
</script>
</head>

<body bgcolor="#ffffff">


<div id="tipDiv" style="position:absolute; visibility:hidden; z-index:100"></div>
<p align="center">
<table width="545" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
			<td>
				<div align="center"><strong>MEUCONDOMÍNIO.NET		    </strong></div></td>
  </tr>
</table>
<table width="545" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><div align="center"><strong>DEMONSTRATIVO DE RECEITAS </strong></div></td>
  </tr>
</table>
</p>
<div align="center"><strong>
<?php=$condominio->nome?>
</strong><br />
<table width="545" border="0">
  <tr>
    <th scope="row"><div align="left">
      Período: 
        <?php=$mes?>
    /
    <?php=$ano?>
    </span></div></th>
  </tr>
</table>
</div>
<table width="545" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="396" bgcolor="#FFFFFF"><div align="center"><strong>RECEITAS</strong></div></td>
    <td width="143" bgcolor="#FFFFFF"><div align="center"><strong>VALORES EM R$ </strong></div></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">
    <?php 
		$classe ="tabela1_linha2";
		$classe2 ="tabela1_linha2";
		if ($receitas){
	?>
     <table cellpadding="0" cellspacing="0" width="100%" >
          <tr>
            <td><table cellpadding="1" cellspacing="1" width="100%">
                <?php 
					$areaAtual = "";
					$centroAtual = "";
					for ($i = 0; $i < sizeof($receitas); $i++){
						$centroAtual = $receitas[$i]->centro->nome;
						if($receitas[$i]->area->nome != $areaAtual){
							$areaAtual = $receitas[$i]->area->nome;
							
							$totalArea = number_format(ReceitaDespesaDAO::somaValoresByArea('receita', $mes, $ano, $areaAtual, $condominio->id), 2, ',', '.');
							if($totalArea != "0,00"){
					?>
                <tr>
                  <th colspan="8" scope="col"><div align="left"><strong>
                    <?php=$receitas[$i]->area->nome?>
                  </strong></div></th>
                </tr>
			<?php 	
					}
				}
				if($receitas[($i+1)]->centro->nome != $centroAtual){
					$totalCentro = number_format(ReceitaDespesaDAO::somaValoresByCentro('receita', $mes, $ano, $receitas[$i]->area->nome, $centroAtual, $id_condominio), 2, ',', '.');					if($totalCentro != "0,00"){
			?>
                <tr>
                  <td width="74%">&nbsp;&nbsp;&nbsp;&nbsp;<?php=$receitas[$i]->centro->nome?></td>               
                  <td width="26%" nowrap="nowrap" ><div align="right">
                    <?php=$totalCentro?>&nbsp;
                  </div></td>
                </tr>
            <?php 		}
				}
				if($receitas[($i+1)]->area->nome != $areaAtual){ 					
					if($totalArea != "0,00"){
			?>
                <tr>
                  <td colspan="1" nowrap="nowrap" >                  </td>
                  <td colspan="3" nowrap="nowrap" ><strong>_________________</strong></td>
                </tr>
				<tr>
                  <td colspan="1" nowrap="nowrap" >                  </td>
                  <td colspan="3" nowrap="nowrap" ><div align="right">
                    <?php=$totalArea?>&nbsp;
                  </div></td>
                </tr>
                <?php 
					}
						}
				}
			?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <?php 
				}else{					
			?>
        <div align="center"><span class="verdanaAzul"> Não existem despesas do condomínio cadastrados </span></div>
      <?php 	
				}
			?>
        <br />
        </p></td>
  </tr>
</table>
</body>
</html>
