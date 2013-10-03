<?php 
require_once("../../php/conexao.php");
require_once("../../php/condominios.php");
require_once("../../php/condominiosDAO.php");
require_once("../../php/superusuario.php");
require_once("../../php/superusuarioDAO.php");
require_once("../../php/permissoes.php");
require_once("../../php/permissoesDAO.php");
require_once("../../php/receitadespesa.php");
require_once("../../php/receitadespesaDAO.php");
require_once("../../php/centrocustos.php");
require_once("../../php/centrocustosDAO.php");
require_once("../../php/areacustos.php");
require_once("../../php/areacustosDAO.php");

// Permite o uso da classe jpgraph padrão e sua especialização em gráfico de barras
include ("../../jpgraph-2.1.4/src/jpgraph.php");
include ("../../jpgraph-2.1.4/src/jpgraph_bar.php");

@session_start();

$con = new Conexao();
$con->conecta();

$id_condominio = $_SESSION['id_condominio'];


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

$tipo = 'receita';


$receitas = ReceitaDespesaDAO::areaCentroByTipoAreaMes($tipo, $mes, $ano,$id_condominio );
$total = ReceitaDespesaDAO::somaTotal($tipo, $mes, $ano, $id_condominio);


if($total){
	

for($i = 0; $i < sizeof($receitas); $i++){
	$CentroCusto[$i] = $receitas[$i]->centro->nome;
	$valorCentroCusto[$i] = ReceitaDespesaDAO::somaValoresByCentro($tipo, $mes, $ano, $receitas[$i]->area->nome, $CentroCusto[$i], $id_condominio);	
	$porcetagemCentroCusto[$i] = ($valorCentroCusto[$i]/$total)*100;
}



 DEFINE ("DEFAULT_GFORMAT" ,"auto");


$grafico = new graph(740,500,"png");

//ESTABELECE AS DIMENSÕES DAS MARGENS PARA O GRÁFICO(ESQUERDA, DIREITA, ACIMA, ABAIXO) em pixels 
$grafico->img->SetMargin(60,60,60,60);
$grafico->img->SetImgFormat("jpeg");

//Define a cor da margem
$grafico->SetMarginColor("#F6F8F9");

// ESTABELECE O FORMATO DAS ESCALAS PARA OS EIXOS X E Y (texto-linear) -> PLOTAGEM DEPENDENTE EXCLUSIVAMENTE DOS PONTOS Y  
$grafico->SetScale("textlin");

// definir a imagem de fundo a ser usada pelo grafico
//$grafico->SetBackgroundImage( '/home/fpaula/vol3/imagens/fundo_penguim.jpg', BGIMG_FILLFRAME);

//Define fundo da caixa
$grafico->SetShadow();

//Fundo do grafico de dentro
$grafico->SetColor("#F6F8F9");


$grafico->title->Set('Grafico de Receitas');
$grafico->title->SetColor("#26385e");
$grafico->subtitle->Set('Centros de Custos/Reais');
$grafico->ygrid->Show(true);
$grafico->xgrid->Show(true);


$gBarras = new BarPlot($valorCentroCusto);
$gBarras->SetFillColor("#ccd8e6");
$gBarras->SetShadow("#b0b0b0@0.2",4,4,true);
// com a função SetLegend estamos automaticamente criando uma legenda
// para o gráfico
$gBarras->SetLegend("Reais");

// criar mais um gráfico de barras para o número de gols sofridos
$gBarras2 = new BarPlot($porcetagemCentroCusto);
$gBarras2->SetFillColor("#ffd600");
$gBarras2->SetShadow("#b0b0b0@0.4",4,4,true);
$gBarras2->SetLegend("% da Receita");
$grafico->legend->Pos( 0.02	,0.05,"right" ,"top");
$grafico->legend->SetFillColor('#f0f2f3'); 

$grupoBarras = new GroupBarPlot(array($gBarras,$gBarras2));
 //Largura das barras
//$grupoBarras->SetWidth(0.6);
$grafico->Add($grupoBarras);

//  RELACIONA OS VALORES PLOTADOS NO TOPO DAS BARRAS
$gBarras->value->SetColor("black");
$gBarras->value->Show();

//  RELACIONA OS VALORES PLOTADOS NO TOPO DAS BARRAS
$gBarras2->value->SetColor("black");
$gBarras2->value->Show();


//ESTABELECE AS MARGENS DE SEPARAÇÃO ENTRE OS VALORES PLOTADOS E O RESPECTIVO EIXO  
$grafico->xaxis->SetLabelMargin(0.1);
$grafico->yaxis->SetLabelMargin(1);

//ESTABELECE AS MARGENS DE SEPARAÇÃO ENTRE OS titulos PLOTADOS E O RESPECTIVO EIXO  
$grafico->xaxis->title->SetMargin(20);
$grafico->yaxis->title->SetMargin(20);

$grafico->yaxis->title->Set("Reais");
$grafico->xaxis->title->Set("Centros de Custos");
$grafico->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$grafico->xaxis->SetTickLabels($CentroCusto);



$grafico->Stroke();
}else{
?>
<img src="../../images/nGraficos.jpg" />
<?php 
}
?>