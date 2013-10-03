<?php 
require_once("sistema/php/conexao.php");
require_once("sistema/php/usuario.php");
require_once("sistema/php/usuarioDAO.php");
require_once("sistema/php/permissao.php");
require_once("sistema/php/permissaoDAO.php");
require_once("sistema/php/visitante.php");
require_once("sistema/php/visitanteDAO.php");


@session_start();

$usuario = $_SESSION['usuario'];
if ( !($usuario->logado) ){
	header("Location: login.php");
	exit();
}

$con = new Conexao();
$con->conecta();

if(!PermissaoDAO::temPermissao($usuario->id_tipo, 8)){
	header("Location: login.php");
	exit();
}

if ( isset($_POST['nome']) ){
	$visitante->id = addslashes($_POST['id']);
	if ($visitante->id != 0){
		$visitante = VisitanteDAO::findByPk($visitante->id);
	}			
	$visitante->id_membro = addslashes($_POST['membro']);
	if($visitante->id_membro == 0){
		$visitante->id_membro = $usuario->id;
	}
	$visitante->nome = addslashes($_POST['nome']);
	$visitante->identidade = addslashes($_POST['identidade']);
	$visitante->cpf = addslashes($_POST['cpf']);
	$visitante->tipo = addslashes($_POST['tipo']);
	$visitante->data_autorizacao = addslashes($_POST['ano'])."-".addslashes($_POST['mes'])."-".addslashes($_POST['dia']);
	$visitante->onde = addslashes($_POST['onde']);
	$id = VisitanteDAO::save($visitante);
	header("Location: visitante.php");
	exit();	
}

if(isset($_POST['id_visita'])){
	$id = VisitanteDAO::delete($_POST['id_visita']);
	header("Location: visitante.php");
	exit();	
}

$visitantes = VisitanteDAO::findByMembro($usuario->id);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Residencial Aldebaran -  Autoriza&ccedil;&atilde;o de Visitantes ::</title>
<script Language="JavaScript">
<!--
function verifica_data(){ 
	alert("aqui");
	return false;
	dia = (document.forms[0].dia.value); 
    mes = (document.forms[0].ano.value); 
    ano = (document.forms[0].mes.value); 


    // verifica o dia valido para cada mes 
    if ((dia < 01)||(dia < 01 || dia > 30) && (  mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || dia > 31) { 
    	return false; 
    } 

    // verifica se o mes e valido 
    if (mes < 01 || mes > 12 ) { 
        return false; 
    } 

    // verifica se e ano bissexto 
    if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
         return false; 
    } 	
	
	return true;
} 

function validaCPF(){ 		
	var i; 
    s = document.forms[0].cpf.value; 
    var c = s.substr(0,9); 
    var dv = s.substr(9,2); 
    var d1 = 0; 
    for (i = 0; i < 9; i++){ 
		d1 += c.charAt(i)*(10-i); 
    }
	if (d1 == 0){
		alert("O número do CPF é Invalido")
		return false; 
    }
	d1 = 11 - (d1 % 11);
	if (d1 > 9) d1 = 0;
	if (dv.charAt(0) != d1){ 
		alert("O número do CPF é Invalido") 
        return false; 
   }
   d1 *= 2;
   for (i = 0; i < 9; i++){
   		d1 += c.charAt(i)*(11-i);
   }
   d1 = 11 - (d1 % 11);
   if (d1 > 9) d1 = 0;
   if (dv.charAt(1) != d1){
   		alert("O número do CPF é Invalido")
		return false;
	}
	return true;
}

function checa_formulario(visitante){
	if (visitante.nome.value == ""){
		alert("Por Favor Coloque Seu Nome !!!");
		visitante.nome.focus();
		return (false);
	}
	if (visitante.identidade.value == ""){
		alert("O campo Identidade Está Vazio !!!");
		visitante.identidade.focus();
		return (false);
	}
	var ver_numero = "1234567890";
	var sk15 = visitante.identidade.value;
	var invalido = true;
	for (i = 0;  i < sk15.length;  i++){
		ch = sk15.charAt(i);
		for (j = 0;  j < ver_numero.length;  j++)
			if (ch == ver_numero.charAt(j))
				break;
		if (j == ver_numero.length){
			invalido = false;
			break;
		}
	}
	if (!invalido){
		alert("O Campo Identidade Deve Conter Apenas Números !!!");
		visitante.identidade.focus();
		return (false);
	}
	if (visitante.identidade.value.length != 7){
		alert("O campo Identidade Deve Ter 7 Números !!!")
		visitante.identidade.focus();
		return (false);
	}
	if (visitante.cpf.value == ""){
		alert("O campo CPF Está Vazio !!!");
		visitante.cpf.focus();
		return (false);
	}
	var ver_numero = "1234567890";
	var sk15 = visitante.cpf.value;
	var invalido = true;
	for (i = 0;  i < sk15.length;  i++){
		ch = sk15.charAt(i);
		for (j = 0;  j < ver_numero.length;  j++)
			if (ch == ver_numero.charAt(j))
				break;
		if (j == ver_numero.length){
			invalido = false;
			break;
		}
	}
	if (!invalido){
		alert("O Campo CPF Deve Conter Apenas Números !!!");
		visitante.cpf.focus();
		return (false);
	}
	if (!validaCPF()){
		visitante.cpf.value = "";
		visitante.cpf.focus();
		return (false);
	}
	if (visitante.cpf.value.length != 11){
		alert("O campo CPF Deve Ter 11 Números !!!")
		visitante.cpf.focus();
		return (false);
	}
	if (visitante.dia.value == ""){
		alert("O campo Dia da Data da Visita Está Vazio !!!");
		visitante.dia.focus();
		return (false);
	}
	var ver_numero = "1234567890";
	var sk15 = visitante.dia.value;
	var invalido = true;
	for (i = 0;  i < sk15.length;  i++){
		ch = sk15.charAt(i);
		for (j = 0;  j < ver_numero.length;  j++)
			if (ch == ver_numero.charAt(j))
				break;
		if (j == ver_numero.length){
			invalido = false;
			break;
		}
	}
	if (!invalido){
		alert("O Campo Dia da Data da Visita Deve Conter Apenas Números !!!");
		visitante.dia.focus();
		return (false);
	}
	if (visitante.mes.value == ""){
		alert("O campo Mês da Data da Visita Está Vazio !!!");
		visitante.mes.focus();
		return (false);
	}
	var ver_numero = "1234567890";
	var sk15 = visitante.mes.value;
	var invalido = true;
	for (i = 0;  i < sk15.length;  i++){
		ch = sk15.charAt(i);
		for (j = 0;  j < ver_numero.length;  j++)
			if (ch == ver_numero.charAt(j))
				break;
		if (j == ver_numero.length){
			invalido = false;
			break;
		}
	}
	if (!invalido){
		alert("O Campo Mês da Data da Visita Deve Conter Apenas Números !!!");
		visitante.mes.focus();
		return (false);
	}
	return (true);
	
	if(!verifica_data()){
		alert("verfica");
		visitante.dia.value = "";
		visitante.mes.value = "";
		visitante.ano.value = "";
		visitante.dia.focus();
		return (false);
	}
}
//-->
</script>
<style type="text/css">
<!--
body {
	background-color: #F4E5C3;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style2 {
	font-size: 27px;
	color: #cec0a0;
	font-family: Tahoma;
	font-weight: bold;
}

.style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif, Tahoma;
	font-size: 12px;
	color: #FFFFFF;
}

.style4 {
	font-size: 27px;
	color: #ffffff;
	font-family: Tahoma;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td align="center"><table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><span class="style2">AUTORIZA&Ccedil;&Atilde;O DE VISITANTES </span></td>
      </tr>
    </table>
      <br>
      <table width="700" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#FFFFFF"><br>
		
            <table width="670" height="270" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="top" bgcolor="#6492af"><br>
                   <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="13%"><span class="style3">Bem vindo <?php=$usuario->nome?>, para permitir a entrada de uma pessoa no pr&eacute;dio, insira o nome, um dos documentos da mesma e o seu tipo(<span class="verdanaAzul">Entregador</span>, Diarista, Empregado, Morador, Familiar, Amigo), atrav&eacute;s do formul&aacute;rio abaixo. </span></td>
                      </tr>
                  </table>				
                  <br>  
				   <form onSubmit="return checa_formulario(this);" action="visitante.php" method="post" name="visitante" id="visitante" >					             
				    <table width="94%" border="1" align="center" cellpadding="0" cellspacing="10" bordercolor="#FFFFFF" bgcolor="8cb4ce">
					<tr>
                      <td width="128" class="style3"> Nome: </td>
                      <td width="167"><p>
                        <input name="nome" type="text" class="FormInputS" id="nome" value="<?php=stripslashes($visitante->nome)?>" size="50" maxlength="50">
                      </p></td>
                    </tr>
                    <tr>
                      <td class="style3"> Identidade: </td>
                      <td><p>
                          <input name="identidade" type="text" class="FormInputS" id="identidade" value="<?php=stripslashes($visitante->identidade)?>" size="50" maxlength="7">
                      </p></td>
                    </tr>
                    <tr>
                      <td class="style3"> CPF: </td>
                      <td><p>
                          <input name="cpf" type="text" class="FormInputS" id="cpf" value="<?php=stripslashes($visitante->cpf)?>" size="50" maxlength="11">
                      </p></td>
                    </tr>
                    <tr>
                      <td class="style3"><span class="verdanaAzul">Data da Visita</span>: </td>
                      <td><p><span class="verdanaAzul">
                        <input name="dia" type="text" class="FormInputS" id="dia" value="<?php=$visitante->data_autorizacao[8].$visitante->data_autorizacao[9]?>" size="2" maxlength="2">/<input name="mes" type="text" class="FormInputS" id="mes" value="<?php=$visitante->data_autorizacao[5].$visitante->data_autorizacao[6]?>" size="2" maxlength="2">/<input name="ano" type="text" class="FormInputS" id="ano" value="<?php=$visitante->data_autorizacao[0].$visitante->data_autorizacao[1].$visitante->data_autorizacao[2].$visitante->data_autorizacao[3]?>" size="4" maxlength="4">
                      </span></p></td>
                    </tr>
                    <tr>
                      <td class="style3"><span class="verdanaAzul">Local</span>: </td>
                      <td><p>
                        <select name="onde" class="FormInputS">
                          <option <?php  if($visitante->onde == "Sal&atilde;o de Festas"){?> selected="selected" <?php  }?> value="Sal&atilde;o de Festas">Sal&atilde;o de Festas</option>
                          <option <?php  if($visitante->onde == "Apartamento"){?> selected="selected" <?php  }?> value="Apartamento">Apartamento</option>
                          <option <?php  if($visitante->onde == "Quadra"){?> selected="selected" <?php  }?> value="Quadra">Quadra</option>
                        </select>
                      </p></td>
                    </tr>
                    
                    <tr>
                      <td class="style3"> Tipo: </td>
                      <td><p>
					  	<select name="tipo" class="FormInputS">
							<option <?php  if($visitante->tipo == 0){?> selected="selected" <?php  }?> value="0">Entregador</option>
							<option <?php  if($visitante->tipo == 1){?> selected="selected" <?php  }?> value="1">Diarista</option>
							<option <?php  if($visitante->tipo == 2){?> selected="selected" <?php  }?> value="2">Empregado</option>
							<option <?php  if($visitante->tipo == 3){?> selected="selected" <?php  }?> value="3">Morador</option>
							<option <?php  if($visitante->tipo == 4){?> selected="selected" <?php  }?> value="4">Familiar</option>
							<option <?php  if($visitante->tipo == 5){?> selected="selected" <?php  }?> value="5">Amigo</option>
					  	</select>
					  </p></td>
                    </tr>                  				  					
                  </table>
				   <div align="center"><br>
                    <input name="membro" type="hidden" id="membro" value="<?php=$visitante->id_membro?>">
                    <input name="id" type="hidden" id="id" value="<?php=$visitante->id?>">
                    <input type="image" src="img/botao_autorizar.jpg" name="Submit" value="Cadastrar">
                  </div>
				  </form>
				  <br>
				  <br>
				  <?php  if($visitantes){?>
                   <table width="94%" border="1" align="center" cellpadding="0" cellspacing="10" bordercolor="#FFFFFF" bgcolor="8cb4ce">
					<tr>
                      <td width="34%" class="style3"> Nome</td>
                      <td width="18%" class="style3"><div align="center"><span class="verdanaAzul">Data da Visita</span></div></td>
                      <td width="14%" class="style3"><div align="center">Local</div></td>
                      <td width="14%" class="style3"><div align="center">Identidade</div></td>
                      <td width="18%" class="style3"><div align="center">CPF</div></td>
                      <td width="16%" class="style3"><div align="center">Tipo</div></td>
                      <td width="16%" class="style3"><div align="center"></div></td>
					</tr>  
					<?php  for($i = 0; $i < sizeof($visitantes); $i++){ ?>   
					<tr>
                      <td width="34%" class="style3"> <?php=$visitantes[$i]->nome?> </td>
                      <td width="18%" class="style3"><div align="center"><span class="verdanaAzul">
                        <?php=$visitantes[$i]->data_autorizacao[8].$visitantes[$i]->data_autorizacao[9]."/".$visitantes[$i]->data_autorizacao[5].$visitantes[$i]->data_autorizacao[6]."/".$visitantes[$i]->data_autorizacao[2].$visitantes[$i]->data_autorizacao[3]?>
                      </span></div></td>
                      <td width="14%" class="style3">  <div align="center">
                        <?php  if($visitantes[$i]->onde == "Salão de Festas"){?>
                        Salão de Festas
                        <?php  }?>
                        <?php  if($visitantes[$i]->onde == "Apartamento"){?> 
                        Apartamento 
                        <?php  }?>
                        <?php  if($visitantes[$i]->onde == "Quadra"){?> 
                        Quadra 
                        <?php  }?>
                      </div></td>
                      <td width="14%" class="style3"><div align="center"><?php=$visitantes[$i]->identidade?></div></td>
                      <td width="18%" class="style3"><div align="center"><?php=$visitantes[$i]->cpf?></div></td>
                      <td width="16%" class="style3"><div align="center">
                          <?php  if($visitantes[$i]->tipo == 0){?>
                        Entregador
                        <?php  }?>
                        <?php  if($visitantes[$i]->tipo == 1){?>
                        Diarista
                        <?php  }?>
                        <?php  if($visitantes[$i]->tipo == 2){?>
                        Empregado
                        <?php  }?>
                        <?php  if($visitantes[$i]->tipo == 3){?>
                        Morador
                        <?php  }?>
                        <?php  if($visitantes[$i]->tipo == 4){?>
                        Familiar
                        <?php  }?>
                        <?php  if($visitantes[$i]->tipo == 5){?>
                        Amigo
                        <?php  }?>
                      </div></td>
                      <td width="16%" class="style3"><div align="center">
					  <form action="visitante.php" method="post" name="visita<?php=?>" id="visita<?php=$visitantes[$i]->id?>" >
                            <input name="id_visita" type="hidden" id="id_visita" value="<?php=$visitantes[$i]->id?>">
                            <input name="Excluir<?php=$visitantes[$i]->id?>" type="image" id="Excluir<?php=?>" value="Excluir" src="img/botao_excluir.jpg">
                      </form></div></td>
					</tr> 
					<?php  }?>                 				  					
                  </table>				  
				 <?php  }else{?>
				 <table width="94%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="8cb4ce">
						<tr>
							<td>
							  <div align="center" class="style3">Voc&ecirc; n&atilde;o autorizou nenhum visitante ainda  </div></td>
						</tr>
				  </table>
				 <?php  }?>
				  <br></td>
            </tr>
            </table>            <p><br>
              </p>			
          </td></tr>
      </table>
      <br>
    <br>
    <br>
    <br>
    </td>
  </tr>
</table>
</body>
</html>
