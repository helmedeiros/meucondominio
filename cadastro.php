<?php 
require_once("sistema/php/conexao.php");
require_once("sistema/php/condominios.php");
require_once("sistema/php/condominiosDAO.php");
require_once("sistema/php/superusuario.php");
require_once("sistema/php/superusuarioDAO.php");
require_once("sistema/php/contatos.php");
require_once("sistema/php/contatosDAO.php");
require_once("sistema/php/imgvrf.php");
require_once("sistema/php/email.php");
require_once("sistema/php/sms.php");
require_once("sistema/php/ftp.php");

@session_start();

$conexao = new Conexao();
$conexao->conecta();
//recolhimento de variáveisSSs
$image = new verification_image();
$superusuarios = superusuarioDAO::findAll();
$mysms = new sms();
$ftp = new ftp();

if (isset($_POST['enviacad'])){ 
if ($_POST['nomecond'] == "" ) { $msg = " \ O nome do condomínio não foi digitado corretamente \ "; }
if ($_POST['cnpj'] == "" ) { $msg = $msg." \ O CNPJ do condomínio é um campo obrigatório \ "; }
if ($_POST['tipo_logradouro'] == "" ){ $msg = $msg." \ O tipo de logradouro não foi digitado corretamente \ "; }
if ($_POST['logradouro'] == "" ){ $msg = $msg." \ O logradouro não foi digitado corretamente \ "; }
if ($_POST['numero_logradouro'] == "" ){ $msg = $msg." \ O número não foi digitado corretamente \ "; }
if ($_POST['bairro_logradouro'] == "" ){ $msg = $msg." \ O bairro não foi digitado corretamente \ "; }
if ($_POST['cep_logradouro'] == "" ){ $msg = $msg." \ O CEP não foi digitado corretamente \ "; }
if ($_POST['cidade_logradouro'] == "" ){ $msg = $msg." \ A cidade não foi digitada corretamente \ "; }
if ($_POST['uf_logradouro'] == "" ){ $msg = $msg." \ A UF não foi digitada corretamente \ "; }
if ($_POST['telefone'] == "" ){ $msg = $msg." \ O telefone do condomínio é um campo de preenchimento obrigatório \ "; }
if ($_POST['qtd_apartamentos'] == "" ){ $msg = $msg." \ A quantidade de apartamentos é um campo de preenchimento obrigatório \ "; }
if ($_POST['nomecnt'] == "" ){ $msg = $msg." \ O Nome do contato é um campo obrigatório \ "; }
if ($_POST['cpfcnt'] == "" ){ $msg = $msg." \ O número do CPF do contato é obrigatório \ "; }
if ($_POST['telefonecnt'] == "" ){ $msg = $msg." \ O telefone do contato é obrigatório \ "; }
if ($_POST['celularcnt'] == "" ){ $msg = $msg." \ O celular do contato é um campo obrigatório \ "; }
if ($_POST['emailcnt'] == "" ){ $msg = $msg." \ O email do contato é um campo obrigatório \ "; }
if (contatosDAO::existeByCpf($_POST['cpfcnt'])){ $msg = $msg." \ Impossível concluir o cadastro, o contato já se encontra cadastrado no banco de dados. Verifique o CPF digitado. \ ";}
if (condominiosDAO::existeByNomCnpj('',$_POST['cnpj'])){ $msg = $msg." \ Impossível concluir o cadastro, o condomínio já se encontra cadastrado no banco de dados. Verifique o CNPJ digitaro. \ ";}
 if (!$image->validate_code($go)){ $msg = $msg." \ O código de verificação foi digitado incorretamente, favor redigitar \ "; } 

}

if (isset($_POST['enviacad']) && $msg == "") { 
 //adiciona contato
 $contato = new contatos();
 	$contato->nome = addslashes($_POST['nomecnt']);
    $contato->cpf = addslashes($_POST['cpfcnt']);
    $contato->telefone = addslashes($_POST['telefonecnt']);
    $contato->celular = addslashes($_POST['celularcnt']);
    $contato->email = addslashes($_POST['emailcnt']);	
    $contato->descricao = addslashes("Cadastrou-se através do site, aguarda um retorno do super usuário selecionado");			
	$contato->status = 1;	
	$id = contatosDAO::save($contato);
	 
//procura o proximo SU responsável
  $lastresp = condominiosDAO::lastResp();
  $ultsu = superusuarioDAO::lastId();
   if($lastresp == $ultsu){ 
     $responsavel = 1 ;
	 for($i = 0 ; $i < sizeof($superusuarios) ; $i++) {
	  if(superusuarioDAO::findByPk($responsavel)){ 
	      break; } else { $responsavel = $responsavel + 1; }
		 }
		} 
	 else { 
      $responsavel = $lastresp + 1;
	  for($i = 0 ; $i < sizeof($superusuarios) ; $i++) {
	  if(superusuarioDAO::findByPk($responsavel)){ 
	      break; } else {  if($responsavel == $ultsu) {  $responsavel = 1; } else { $responsavel = $responsavel + 1;} }
		 }
	 }
   
   //salva o condomínio para posterior ativação
 $condominios = new condominios();
  	$condominios->nome = addslashes($_POST['nomecond']);
    $condominios->cnpj = addslashes($_POST['cnpj']);
    $condominios->tipo_logradouro = addslashes($_POST['tipo_logradouro']);
    $condominios->logradouro = addslashes($_POST['logradouro']);
    $condominios->numero_logradouro = addslashes($_POST['numero_logradouro']);
    $condominios->bairro_logradouro = addslashes($_POST['bairro_logradouro']);
    $condominios->cep_logradouro = addslashes($_POST['cep_logradouro']);
    $condominios->cidade_logradouro = addslashes($_POST['cidade_logradouro']);
    $condominios->uf_logradouro = addslashes($_POST['uf_logradouro']);
	$condominios->telefone = addslashes($_POST['telefone']);
   	$condominios->qtd_apartamentos = addslashes($_POST['qtd_apartamentos']);
   	$condominios->qtd_blocos = '1';	
	$condominios->id_contato = contatosDAO::lastId();
	$condominios->id_responsavel = $responsavel;
    $condominios->status = '0';
	$condominios->data_criacao = date("Y-m-d H:i:s", time());
	 $id = condominiosDAO::save($condominios);	
	 $ftp->criaDirCond(condominiosDAO::lastID());	

$responsavel = superusuarioDAO::findByPk($responsavel);
 //envio de email para as 2 partes relacionadas (confirmação de cadastro para o solicitante e o formulário de abertura de conta pelo superusuario
$htmlsol = "
 
<html>
<style type=\"text/css\">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif}
.style2 {
	font-size: 11px;
	font-weight: bold;
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style6 {font-size: 11px}
.style8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style10 {font-size: 12px}
.style11 {color: #FF0000}
.style12 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FF0000;
}
-->
</style>
<body>
<p class=\"style1\">Recebemos a sua solicita&ccedil;&atilde;o de cadastro atrav&eacute;s do site MeuCondominio.NET</p>
<p class=\"style1\">A sua mensagem foi repassada para um dos nossos representantes, e dentro de no m&aacute;ximo 2 dias &uacute;teis, estaremos entrando em contato para repassar os dados referentes ao contrato e or&ccedil;amento. </p>
<p class=\"style1\">Seguem os Dados Cadastrados:</p>
<table width=\"411\" height=\"239\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#F6F8F9\" class=\"tabela1\">
  <tr>
    <td width=\"408\" height=\"16\" bgcolor=\"#6598CB\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
      <tr>
        <td width=\"89%\" class=\"tabela1_titulo1 style1 style2 style10\">Dados Cadastrais Referentes ao CONDOM&Iacute;NIO </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height=\"221\"><table cellpadding=\"1\" cellspacing=\"1\" width=\"408\">
       <tr>
        <td width=\"23%\"  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong> Nome</strong></td>
        <td colspan=\"2\" class=\"tabela1_linha2\" ><p class=\"style12\">$condominios->nome</p>          </td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong> CNPJ </strong></td>
        <td colspan=\"2\" class=\"style12\" >.$condominios->cnpj.</td>
      </tr>
      <tr>
        <td rowspan=\"7\"  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong>Endere&ccedil;o</strong></td>
        <td width=\"21%\" class=\"style8\" ><div align=\"right\" class=\"style8\">Tipo Logradouro: </div></td>
        <td width=\"56%\" class=\"style12\" ></p>$condominios->tipo_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Logradouro: </div></td>
        <td class=\"style12\" >$condominios->logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Numero:</div></td>
        <td class=\"style12\" >$condominios->numero_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Bairro:</div></td>
        <td class=\"style12\" >$condominios->bairro_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Cep:</div></td>
        <td class=\"style12\" >$condominios->cep_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Cidade:</div></td>
        <td class=\"style12\" >$condominios->cidade_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Estado:</div></td>
        <td class=\"style12\" >$condominios->uf_logradouro</td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"tabela1_linha2\"><div align=\"right\" class=\"style8\">QTD Apartamentos</div></td>
        <td colspan=\"2\"  align=\"right\" class=\"style12\"><div align=\"left\">$condominios->qtd_apartamentos</div></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong>Telefone</strong></td>
        <td colspan=\"2\"  align=\"right\" class=\"style12\"><div align=\"left\">$condominios->telefone</div></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong>Respons&aacute;vel</strong></td>
        <td colspan=\"2\"  align=\"right\" class=\"style12\"><div align=\"left\">$responsavel->nome</div></td>
      </tr>
     
    </table></td>
  </tr>
</table>
<br>
<table width=\"411\" height=\"123\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#F6F8F9\" class=\"tabela1\">
  <tr>
    <td width=\"409\" height=\"19\" bgcolor=\"#6598CB\"><span class=\"tabela1_titulo1 style1 style2\">Dados Cadastrais referentes ao CONTATO </span></td>
  </tr>
  <tr>
    <td height=\"102\"><table cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
      <tr>
        <td width=\"18%\"  align=\"right\" class=\"style6 style3 tabela1_linha2\"><span class=\"tabela1_linha2\"><strong>Nome</strong></span></td>
        <td width=\"82%\" class=\"style12\" ><p>$contato->nome
<br>
        </p></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong> CPF </strong></td>
        <td class=\"style12\" >$contato->cpf
<br></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"tabela1_linha2\"><div align=\"right\" class=\"style8\">Telefone</div></td>
        <td  align=\"right\" class=\"style12\"><div align=\"left\"><span class=\"style6 style3 tabela1_linha2\">$contato->telefone
<br>
        </span></div></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"tabela1_linha2\"><div align=\"right\" class=\"style8\">Celular</div></td>
        <td  align=\"right\" class=\"style12\"><div align=\"left\"><span class=\"style6 style3 tabela1_linha2\">$contato->celular
<br>
        </span></div></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong>Email</strong></td>
        <td  align=\"right\" class=\"style12\"><div align=\"left\"><span class=\"style6 style3 tabela1_linha2\">$contato->email</span></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<p class=\"style1\">Caso exista alguma d&uacute;vida, favor, entrar em contato atrav&eacute;s do link &quot;contato&quot;, localizado no canto superior direito. </p>
<p class=\"style1\">&nbsp; </p>
<p>&nbsp; </p>
</body>
</html>
  ";

$htmlresp = " 

<html>
<style type=\"text/css\">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif}
.style2 {
	font-size: 11px;
	font-weight: bold;
	color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style6 {font-size: 11px}
.style8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style10 {font-size: 12px}
.style11 {color: #FF0000}
.style12 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FF0000;
}
-->
</style>
<body>
<p class=\"style1\">Voc&ecirc; recebeu um novo condom&iacute;nio. </p>
<p class=\"style1\">Para maiores detalhes, acesse o m&oacute;dulo &quot;condom&iacute;nios&quot; no sistema administrativo. </p>
<p class=\"style1\">Seguem os Dados Cadastrados:</p>
<table width=\"411\" height=\"239\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#F6F8F9\" class=\"tabela1\">
  <tr>
    <td width=\"408\" height=\"16\" bgcolor=\"#6598CB\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
      <tr>
        <td width=\"89%\" class=\"tabela1_titulo1 style1 style2 style10\">Dados Cadastrais Referentes ao CONDOM&Iacute;NIO </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height=\"221\"><table cellpadding=\"1\" cellspacing=\"1\" width=\"408\">
       <tr>
        <td width=\"23%\"  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong> Nome</strong></td>
        <td colspan=\"2\" class=\"tabela1_linha2\" ><p class=\"style12\">$condominios->nome</p>          </td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong> CNPJ </strong></td>
        <td colspan=\"2\" class=\"style12\" >.$condominios->cnpj.</td>
      </tr>
      <tr>
        <td rowspan=\"7\"  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong>Endere&ccedil;o</strong></td>
        <td width=\"21%\" class=\"style8\" ><div align=\"right\" class=\"style8\">Tipo Logradouro: </div></td>
        <td width=\"56%\" class=\"style12\" ></p>$condominios->tipo_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Logradouro: </div></td>
        <td class=\"style12\" >$condominios->logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Numero:</div></td>
        <td class=\"style12\" >$condominios->numero_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Bairro:</div></td>
        <td class=\"style12\" >$condominios->bairro_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Cep:</div></td>
        <td class=\"style12\" >$condominios->cep_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Cidade:</div></td>
        <td class=\"style12\" >$condominios->cidade_logradouro</td>
      </tr>
      <tr>
        <td class=\"style8\" ><div align=\"right\" class=\"style8\">Estado:</div></td>
        <td class=\"style12\" >$condominios->uf_logradouro</td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"tabela1_linha2\"><div align=\"right\" class=\"style8\">QTD Apartamentos</div></td>
        <td colspan=\"2\"  align=\"right\" class=\"style12\"><div align=\"left\">$condominios->qtd_apartamentos</div></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong>Telefone</strong></td>
        <td colspan=\"2\"  align=\"right\" class=\"style12\"><div align=\"left\">$condominios->telefone</div></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong>Respons&aacute;vel</strong></td>
        <td colspan=\"2\"  align=\"right\" class=\"style12\"><div align=\"left\">$responsavel->nome</div></td>
      </tr>
     
    </table></td>
  </tr>
</table>
<br>
<table width=\"411\" height=\"123\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#F6F8F9\" class=\"tabela1\">
  <tr>
    <td width=\"409\" height=\"19\" bgcolor=\"#6598CB\"><span class=\"tabela1_titulo1 style1 style2\">Dados Cadastrais referentes ao CONTATO </span></td>
  </tr>
  <tr>
    <td height=\"102\"><table cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
      <tr>
        <td width=\"18%\"  align=\"right\" class=\"style6 style3 tabela1_linha2\"><span class=\"tabela1_linha2\"><strong>Nome</strong></span></td>
        <td width=\"82%\" class=\"style12\" ><p>$contato->nome
<br>
        </p></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong> CPF </strong></td>
        <td class=\"style12\" >$contato->cpf
<br></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"tabela1_linha2\"><div align=\"right\" class=\"style8\">Telefone</div></td>
        <td  align=\"right\" class=\"style12\"><div align=\"left\"><span class=\"style6 style3 tabela1_linha2\">$contato->telefone
<br>
        </span></div></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"tabela1_linha2\"><div align=\"right\" class=\"style8\">Celular</div></td>
        <td  align=\"right\" class=\"style12\"><div align=\"left\"><span class=\"style6 style3 tabela1_linha2\">$contato->celular
<br>
        </span></div></td>
      </tr>
      <tr>
        <td  align=\"right\" class=\"style6 style3 tabela1_linha2\"><strong>Email</strong></td>
        <td  align=\"right\" class=\"style12\"><div align=\"left\"><span class=\"style6 style3 tabela1_linha2\">$contato->email</span></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<p class=\"style1\">&nbsp;</p>
</body>
</html>



";
    $id4 = email::sendMail(' CONFIRMACAO - MeuCondominio.net ', $htmlsol, $contato->email); //enviando email para o solicitante
    $id4 = email::sendMail(' NOVO CONDOMINIO - MeuCondominio.net ', $htmlresp, $responsavel->email); //enviando email para o novo super usuario.
	$fone = ereg_replace("[^0-9]", "", $responsavel->celular);
	$results = $mysms->send('55'.$fone, 'Novo Condominio ',' - MeuCondominio.net - Voce recebeu um novo condominio, para maiores detalhes, acesse-o atraves do menu "condominios", no site de administrativo.'); //enviando sms

 header("Location: cadastro.php?act=1");
	exit();
}


?>

<html>
<head>
<title>Index</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script language="javascript" type="text/javascript" src="sistema/js/funcoes.js " charset="iso-8859-1">
</script>

<link href="../sistema/inc/estilos.css" rel="stylesheet" type="text/css">
<link href="sistema/inc/estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- ImageReady Slices (Index.psd) -->
<table width="729" height="238" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
	<tr>
		<td>
			<img src="images/index_01.gif" alt="" width="729" height="86" border="0" usemap="#Map2"></td>
	</tr>
	<tr>
		<td>
			<img src="images/index_02.gif" alt="" width="729" height="66" border="0" usemap="#Map3"></td>
	</tr>
	<tr>
		<td background="images/index_04.gif">
			<table border="0" align="left" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="258"><img src="images/cadasto_02.gif" border="0" usemap="#Map">					</td>
					<td width="444">
						<table align="left" width="98%">
							<tr>
								<td background="images/Index_interna_05.jpg">
									<img src="images/Index_interna_04.jpg">								</td>
							</tr>
							
							<tr>
							
								<td><form action="cadastro.php" method="post" onSubmit="javascript:return confirmaCad(this)" nome="condominios" numero="condominios">
			  <div align="center">
			    <p><font class="warning">
			      <?php  if(isset($msg) )
						echo $msg;?>
			      </font>
			      </p>
			    </div>
			<?php  if(!isset($act)){ ?>
			  <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                <tr>
                  <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="89%" class="tabela1_titulo1">Dados do Condom&iacute;nio </td>                       
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table cellpadding="1" cellspacing="1" width="100%">
                      <tr>
                        <td class="tabela1_titulo2" colspan="3"> obs: Todos os Campos S&atilde;o Obrigat&oacute;rios </td>
                      </tr> 
                      <tr> 
					  	<td class="tabela1_linha2"  align="right"> Nome</td>
						<td colspan="2" class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nomecond" size="30" maxlength="30" value="<?php=$nome?>"></td>
					  </tr>
					  <tr>
                        <td  align="right" class="tabela1_linha2"> CNPJ </td>
					    <td colspan="2" class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="cnpj" size="18" maxlength="18" value="<?php=$cnpj?>" onKeyDown="FormataCNPJ(this,event)" onKeyPress="return Numero(event);" /></td>
					  </tr>
					  <tr>
					    <td rowspan="7"  align="right" class="tabela1_linha2">Endere&ccedil;o</td>
					    <td class="tabela1_linha2" ><div align="right">Tipo Logradouro: </div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="tipo_logradouro" size="30" maxlength="30" value="<?php=$tipo_logradouro?>"/>
				      </p></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Logradouro: </div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="logradouro" size="30" maxlength="30" value="<?php=$logradouro?>" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Numero:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="numero_logradouro" size="30" maxlength="30" value="<?php=$numero_logradouro?>" onKeyPress="return Numero(event);" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Bairro:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="bairro_logradouro" size="30" maxlength="30" value="<?php=$bairro_logradouro?>" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Cep:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="cep_logradouro" size="30" maxlength="30" value="<?php=$cep_logradouro?>" onKeyPress="return Numero(event);" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Cidade:</div></td>
				      <td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="cidade_logradouro" size="30" maxlength="30" value="<?php=$cidade_logradouro?>" /></td>
					  </tr>
					  <tr>
					    <td class="tabela1_linha2" ><div align="right">Estado:</div></td>
				        <td class="tabela1_linha2" ><select name="uf_logradouro">
                          <option value='AC'  >Acre</option>
                          <option value='AL'  >Alagoas</option>
                          <option value='AP'  >Amapa</option>
                          <option value='AM'  >Amazonas</option>
                          <option value='BA'  >Bahia</option>
                          <option value='CE'  >Ceara</option>
                          <option value='DF'  >Distrito Federal</option>
                          <option value='ES'  >Espirito Santo</option>
                          <option value='GO'  >Goias</option>
                          <option value='MA'  >Maranhao</option>
                          <option value='MT'  >Mato Grosso</option>
                          <option value='MS'  >Mato Grosso do Sul</option>
                          <option value='MG'  >Minas Gerais</option>
                          <option value='PA'  >Para</option>
                          <option value='PB'  >Paraiba</option>
                          <option value='PR'  >Parana</option>
                          <option value='PE'  >Pernambuco</option>
                          <option value='PI'  >Piaui</option>
                          <option value='RN'  selected="selected" >Rio Grande do Norte</option>
                          <option value='RS'  >Rio Grande do Sul</option>
                          <option value='RJ'  >Rio de Janeiro</option>
                          <option value='RO'  >Rondonia</option>
                          <option value='RR'  >Roraima</option>
                          <option value='SC'  >Santa Catarina</option>
                          <option value='SP'  >Sao Paulo</option>
                          <option value='SE'  >Sergipe</option>
                          <option value='TO'  >Tocantins</option>
                        </select></td>
					  </tr>
					  <tr>
                        <td  align="right" class="tabela1_linha2">Telefone</td>
					    <td colspan="2"  align="right" class="tabela1_linha2"><div align="left">
                            <input type="text" class="FORMULARIO"  name="telefone" value="<?php=$telefone?>" size="14" maxlength="14" onKeyDown="FormataTEL(this,event)" onKeyPress="return Numero(event);"/>
                        </div></td>
					    </tr>
					  <tr>
					    <td  align="right" class="tabela1_linha2"><div align="right">QTD Apartamentos</div></td>
				      <td colspan="2"  align="right" class="tabela1_linha2">
				        <div align="left">
				          <input type="text" class="FORMULARIO"  name="qtd_apartamentos" size="30" maxlength="30" value="<?php=$qtd_apartamentos?>" onKeyPress="return Numero(event);" />
			            </div></td>
			          </tr>
					 
                  </table>
			      </td>
                </tr>
              </table> 			  
			  
			   <br>
			   <table cellpadding="0" cellspacing="0" width="96%" class="tabela1">
                 <tr>
                   <td bgcolor="#6598CB"><table width="100%" cellpadding="0" cellspacing="0">
                       <tr>
                         <td width="89%" class="tabela1_titulo1">Dados do Solicitante </td>
                       </tr>
                   </table></td>
                 </tr>
                 <tr>
                   <td><table cellpadding="1" cellspacing="1" width="100%">
                       <tr>
                         <td class="tabela1_titulo2" colspan="3">obs.: Os ítens <strong>Email e Celular</strong> devem ser cadastrados corretamente, para que possamos entrar em contato.</td>
                       </tr>
                       <tr>
                         <td width="43%"  align="right" class="tabela1_linha2"> Nome:</td>
                         <td colspan="2" class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nomecnt" id="nome" size="30" maxlength="50" value="<?php=$nomecnt?>"></td>
                       </tr>
                       <tr>
                         <td class="tabela1_linha2"  align="right">CPF:</td>
                         <td colspan="2" class="tabela1_linha2" ><input  name="cpfcnt" type="text" class="FORMULARIO" id="cpfcnt" value="<?php=$cpfcnt?>" size="14" maxlength="14" onKeydown="FormataCPF(this,event)" onKeyPress="return Numero(event);"/></td>
                       </tr>
                       <tr>
                         <td class="tabela1_linha2"  align="right"> Telefone: </td>
                         <td colspan="2" class="tabela1_linha2" ><input  name="telefonecnt" type="text" class="FORMULARIO" id="telefonecnt" value="<?php=$telefonecnt?>" size="14" maxlength="14" onKeydown="FormataTEL(this,event)" onKeyPress="return Numero(event);" /></td>
                       </tr>
                       <tr>
                         <td class="tabela1_linha2"  align="right">Celular:</td>
                         <td colspan="2" class="tabela1_linha2" ><input  name="celularcnt" type="text" class="FORMULARIO" id="celularcnt" value="<?php=$celularcnt?>" size="14" maxlength="14" onKeyPress="FormataTEL(this,event)"/></td>
                       </tr>
                       <tr>
                         <td class="tabela1_linha2"  align="right"> Email:</td>
                         <td colspan="2" class="tabela1_linha2" ><input  name="emailcnt" type="text" class="FORMULARIO" id="emailcnt" value="<?php=$emailcnt?>" size="14" maxlength="50"/></td>
                       </tr>
                       <tr>
                         <td class="tabela1_linha2"  align="right">C&oacute;digo de Verifica&ccedil;&atilde;o </td>
                         <td width="26%" class="tabela1_linha2" ><img src="picture.php"/></td>
                         <td width="31%" class="tabela1_linha2" ><div align="left">
                           <input  name="go" type="text" class="FORMULARIO" id="go" size="6" maxlength="6" />
                         </div></td>
                       </tr>
                       <tr>
                         <td colspan="3"  align="right" class="tabela1_linha2"><div align="center">
                           <input name="enviacad" type="image" src="sistema/images/enviar.jpg" value="bla" />
<br />
                         </div></td>
                       </tr>
                   </table></td>
                 </tr>
               </table>
			   <div align="center" class="fontelinkPreto">
			     <p>
			       <?php  } else { ?>
			       O Cadastro foi realizado com sucesso, dentro de instantes você estará recebendo um Email com os dados do cadastro.			     </p>
			     <p>Clique <a href="index.html"> AQUI </a>para voltar.
			       <?php  } ?>
			       <input type="hidden"  name="id" value="<?php=stripslashes($id)?>" />
			       </p>
			   </div>
								</form> 
			   </td>
				</tr>
				
					  </table>
					
					</td>
				</tr>
				
		  </table>
		  
		</td>
		
	</tr>	
	
	<tr>
		<td>
			<img src="images/index_06.jpg" alt="" width="729" height="81" border="0" usemap="#Map4">			</td>
	</tr>
</table>
<!-- End ImageReady Slices -->

<map name="Map"><area shape="rect" coords="47,3,243,63" href="cadasto.php">
</map>
<map name="Map2"><area shape="rect" coords="45,34,217,78" href="index.html">
</map>
<map name="Map3"><area shape="rect" coords="42,4,200,64" href="index.html">
</map>
<map name="Map4">
  <area shape="rect" coords="658,10,732,83" href="sistema/index.php">
</map>
</body>
</html>