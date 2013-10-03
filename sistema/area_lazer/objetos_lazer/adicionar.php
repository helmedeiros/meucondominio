<?php 
require_once("../../php/conexao.php");
require_once("../../php/condominios.php");
require_once("../../php/condominiosDAO.php");
require_once("../../php/superusuario.php");
require_once("../../php/superusuarioDAO.php");
require_once("../../php/permissoes.php");
require_once("../../php/permissoesDAO.php");
require_once("../../php/arealazer.php");
require_once("../../php/arealazerDAO.php");
require_once("../../php/objetolazer.php");
require_once("../../php/objetolazerDAO.php");
require_once("../../php/funcionamento.php");
require_once("../../php/funcionamentoDAO.php");

@session_start();

$usuario = $_SESSION['usuario'];
$id_condominio = $_SESSION['id_condominio'];
if (!($usuario->logado)){
	header("Location: ../../logoff.php");
	exit();
}


$conexao = new Conexao();
$conexao->conecta();

if (isset($_GET['area']))

//recolhendo variáveis
if (isset($_GET['area'])){
	$area = $_GET['area'];
}else{
	$area = $_POST['area'];
}

$areas = arealazerDAO::findByPk($area);
 
$objetolazer = new objetolazer();

if ( isset($_POST['nome']) ){	
	
	//atribuições iniciais
	$objetolazer->id = addslashes($_POST['id']);
	$objetolazer->nome = addslashes($_POST['nome']);	
	$objetolazer->id_area = $area;	
	$objetolazer->id_area = addslashes($_POST['area']);
	$objetolazer->funcionamento = addslashes($_POST['funcionamento']);
	$objetolazer->nome = addslashes($_POST['nome']);
	$objetolazer->inicio = addslashes($_POST['Hinicio']).':'.addslashes($_POST['Minicio']);
	$objetolazer->fim = addslashes($_POST['Hfim']).':'.addslashes($_POST['Mfim']);
	$objetolazer->descricao = addslashes($_POST['descricao']);
	$objetolazer->idade_minima = addslashes($_POST['idade_minima']);
	$objetolazer->tempo_minimo = addslashes($_POST['Htempo_minimo']).':'.addslashes($_POST['Mtempo_minimo']);
	$objetolazer->tempo_maximo = addslashes($_POST['Htempo_maximo']).':'.addslashes($_POST['Mtempo_maximo']);
	$objetolazer->descricao = addslashes($_POST['descricao']);
	$objetolazer->aviso = addslashes($_POST['aviso']);
	$objetolazer->status = addslashes($_POST['status']);	
	
	if($objetolazer->nome != ""){
	
	//variável temporária para comparação entre datas
	$tempo_minimo = $_POST['Hinicio'].$_POST['Minicio'];
	$tempo_maximo = $_POST['Hfim'].$_POST['Mfim'];
	
	//verifica se o horário para inicio do funcionamento é menor do que a final
	if((int)$tempo_minimo < (int)$tempo_maximo){			
			
			
		//verifica se idade minima é maior do que zero sendo o síndico responsável pela  definição
		if($_POST['idade_minima'] > 0){		
	
			//verifica se o tempo mínimo ou o máximo não estão zerados
			if(($_POST['Htempo_minimo'] != '00') or ($_POST['Mtempo_minimo'] != '00') and ($_POST['Htempo_maximo'] != '00') or ($_POST['Mtempo_maximo'] != '00') ){				
		
				//verifica se o su possue permissão para alterar(1) no modulo(20)
				if(!permissoesDAO::temPermissao(20,1,$usuario->id_tipo_usuario)){	
					header("Location: ../../index.php");
					exit();
				}		
			
						
				//verifica se esta sendo criado ou alterado um Objeto de Lazer
				if ($objetolazer->id == 0){	
					//verifica se o nome que foi cadastrado já pertence a outro Objeto desta área de lazer
					if(objetolazerDAO::existeByNome($objetolazer->nome, $objetolazer->id_area)){					
						header("Location: home.php?msg=O objeto de lazer sujerido ao cadastro não foi incluido pois já existem outros com o mesmo nome ({$objetolazer->nome}&area={$area})");
						exit();	
					}else{						
						$id = objetolazerDAO::save($objetolazer);
						header("Location: home.php?area={$area}");
						exit();					
					}
				}else{
					//verifica se o nome que se quer cadastrar existe e se ele não pertence a área que se esta alterando
					if((objetolazerDAO::existeByNome($objetolazer->nome, $objetolazer->id_area)) && (objetolazerDAO::existeByNomeId($objetolazer->nome, $objetolazer->id, $objetolazer->id_area))) {
						header("Location: home.php?msg=A alteração não foi realizada pois já existem outros objetos com o mesmo nome ({$objetolazer->nome}&area={$area})");
						exit();	
					}else{
						//cria o objeto user com os dados do Super-Usuário que se esta alterando
						$objetolazer = objetolazerDAO::findByPk($objetolazer->id);
						
						//outras atribuições
						$objetolazer->id =  addslashes($_POST['id']);
						$objetolazer->id_area = addslashes($_POST['area']);
						$objetolazer->funcionamento = addslashes($_POST['funcionamento']);
			    		$objetolazer->nome = addslashes($_POST['nome']);
						$objetolazer->inicio = addslashes($_POST['Hinicio']).':'.addslashes($_POST['Minicio']);
						$objetolazer->fim = addslashes($_POST['Hfim']).':'.addslashes($_POST['Mfim']);
			    		$objetolazer->idade_minima = addslashes($_POST['idade_minima']);
						$objetolazer->tempo_minimo = addslashes($_POST['Htempo_minimo']).':'.addslashes($_POST['Mtempo_minimo']);
						$objetolazer->tempo_maximo = addslashes($_POST['Htempo_maximo']).':'.addslashes($_POST['Mtempo_maximo']);
						$objetolazer->descricao = addslashes($_POST['descricao']);
						$objetolazer->aviso = addslashes($_POST['aviso']);
			    		$objetolazer->status = addslashes($_POST['status']);	
						$id = objetolazerDAO::save($objetolazer);				
						header("Location: home.php?area={$area}");
						exit();
					}
				}			
			}else{
				$msg = 'O tempo mínimo ou o máximo não podem estar zerados';
			}
		}else{
			$msg = 'A idade mínima para atualização deve ser maior que zero';
		}
	}else{
		$msg = 'O horário de termino deve ser maior do que o de início';
	}
	}else{
		$msg = "O nome não pode estar vazio";
	}
}

//verifica se a pagina recebeu um id para alteração
if(isset($_GET['id'])){
	$objetolazer = objetolazerDAO::findByPk($_GET['id'], $_GET['area']);
	$ep = 0;
}else{
	//verifica se o su possue permissão para inserir(2) em area custo(20)
	if(!permissoesDAO::temPermissao(20,2,$usuario->id_tipo_usuario)){
		header("Location: ../../index.php");
		exit();
	}
	
}

$funcionamentos = funcionamentoDAO::findAll(); 
$condominio = condominiosDAO::findByPk($id_condominio); 
$pontinhos = "../../";
$classe = "tabela1_linha2";
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

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script language="javascript" type="text/javascript" src="../../js/funcoes.js" charset="iso-8859-1">
</script>

<link href="../../inc/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#ffffff">

<table width="714" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td><img src="../../images/spacer.gif" width="169" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="25" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="178" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="78" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="87" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="90" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="48" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="39" height="1" border="0" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
    <td rowspan="9" valign="top" background="../../images/complemento_menu_bottom.jpg"><?php  include("../../inc/menu.php"); ?></td>
    <td colspan="7" rowspan="9" valign="top" background="../../images/bg_geral_box.jpg" bgcolor="#FFFFFF"><table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><!-- menu superior -->
            <table width="545" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="533" valign="top" background="../../images/topo_espaco.jpg"><img src="../../images/topo_espaco.jpg" width="203" height="40" /></td>
                <td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="home.php?area=<?php=$area?>"><img src="../../images/botao_listar_off.jpg" name="listar1" width="78" height="40" border="0" id="listar1" /></a></td>
				<td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="buscar.php?area=<?php=$area?>"><img src="../../images/botao_pesquisar_off.jpg" name="pesquisar" width="90" height="40" border="0" id="listar1" /></a></td>
                <td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="adicionar.php?area=<?php=$area?>"><img src="../../images/botao_cadastrar.jpg" name="cadastrar1" width="87" height="40" border="0" id="cadastrar1" /></a></td>
                <td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="#"></a></td>
                <td valign="top" background="../centro_custo/images/topo_espaco.jpg"><a href="excluir.php?area=<?php=$area?>"><img src="../../images/botao_excluir_off.jpg" name="excluir1" width="87" height="40" border="0" id="excluir1" /></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="71" background="../../images/topo_box.jpg"><!-- titulo da secao -->
          <h1>OBJETOS DE LAZER </h1></td>
      </tr>
    </table>
      <table width="545" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" background="../../images/le_box_bg.jpg">&nbsp;</td>
          <td width="481" bgcolor="#FFFFFF"><!-- texto sempre dentro da tag "<p>" -->
           <p align="center" class="fontelinkPreto">
       		<br />
            <br />
            <br />
            CONDOMÍNIO -&gt; <strong><?php=$condominio->nome?></strong><br />
             Área de Lazer -&gt; <strong><a href="../home.php" >
             <?php=stripslashes($areas->nome)?>
             </a></strong><br />
            <br />
			<form action="adicionar.php" method="post" onSubmit="javascript:return confirmaCentroCusto(this)" nome="objetolazer" numero="objetolazer">
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
                        <td class="tabela1_titulo2" colspan="2"> obs: O Objeto de Lazer ser&aacute; adicionado na &Aacute;rea de Lazer</td>
                      </tr>
                      <tr>
					  	<td class="tabela1_linha2"  align="right"> Nome</td>
						<td class="tabela1_linha2" ><input type="text" class="FORMULARIO"  name="nome" size="30" maxlength="30" value="<?php=stripslashes($objetolazer->nome)?>"></td>
					  </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right">Descrição</td>
					    <td class="tabela1_linha2" ><textarea name="descricao" cols="30" class="FORMULARIO"><?php=stripslashes($objetolazer->descricao)?></textarea></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right">Aviso</td>
					    <td class="tabela1_linha2" ><textarea name="aviso" cols="30" class="FORMULARIO"><?php=stripslashes($objetolazer->aviso)?></textarea></td>
				      </tr>
					  <tr>
                        <td  align="right" class="tabela1_linha2">Situação</td>
					    <td  align="left" class="tabela1_linha2">Ativo
					      <input name="status" type="radio" value="1"  <?php  if ( $objetolazer->status == 1) { ?> checked="checked" <?php  }?>/>
					      Inativo
					      <input name="status" type="radio" value="0"   <?php  if ( $objetolazer->status == 0) { ?>checked="checked"<?php  }?> /></td>
				      </tr>
					  <tr>
					    <td class="tabela1_titulo2" colspan="2">Funcionamento</td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Início </td>
					    <td class="tabela1_linha2" ><select name="Hinicio">
                        	<?php 
						  		for ($i = 0; $i <= 23; $i++){
									if($i < 10)
										$horaIni = '0'.$i;
									else
										$horaIni = $i;
									$inicio = $objetolazer->inicio[0].$objetolazer->inicio[1];
							?>
                          		<option value="<?php=$horaIni?>" <?php  if($inicio == $horaIni){?> selected="selected" <?php  }?>><?php=$horaIni?></option>
                          	<?php 
								}
							?>
                        </select>
					      :
			              <select name="Minicio">
                            <?php 
						  		for ($i = 0; $i <= 59; $i++){
									if($i < 10)
										$minutoIni = '0'.$i;
									else
										$minutoIni = $i;
									$inicio = $objetolazer->inicio[3].$objetolazer->inicio[4];
							?>
                            <option value="<?php=$minutoIni?>" <?php  if($inicio == $minutoIni){?> selected="selected" <?php  }?>><?php=$minutoIni?></option>
                            <?php 
								}
							?>
                          </select></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Término </td>
					    <td class="tabela1_linha2" ><select name="Hfim">
                          <?php 
						  		for ($i = 0; $i <= 23; $i++){
									if($i < 10)
										$horafim = '0'.$i;
									else
										$horafim = $i;
									$fim = $objetolazer->fim[0].$objetolazer->fim[1];
							?>
                          <option value="<?php=$horafim?>" <?php  if($fim == $horafim){?> selected="selected" <?php  }?>><?php=$horafim?></option>
                          <?php 
								}
							?>
                        </select>
						:
						<select name="Mfim">
						<?php 
							for ($i = 0; $i <= 59; $i++){
								if($i < 10)
									$minutofim = '0'.$i;
								else
									$minutofim = $i;
								$inicio = $objetolazer->fim[3].$objetolazer->fim[4];
						?>		<option value="<?php=$minutofim?>" <?php  if($inicio == $minutofim){?> selected="selected" <?php  }?>><?php=$minutofim?></option>
						<?php 
							}
						?>
						</select></td>
					  </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right">Funcionamento</td>
					    <td class="tabela1_linha2" ><select name="funcionamento">
                            <?php 
								for ($i = 0; $i < sizeof($funcionamentos); $i++){
							?>
                            <option value="<?php=$funcionamentos[$i]->id?>" <?php  if($objetolazer->funcionamento == $funcionamentos[$i]->id){?> selected="selected" <?php  }?>>
                            <?php=$funcionamentos[$i]->nome?>
                            </option>
                            <?php 
								}
							?>
                          </select>                        </td>
				      </tr>
					  <tr>
                        <td class="tabela1_titulo2" colspan="2"> Dados de controle para Reserva </td>
                      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Idade Mínima</td>
					    <td class="tabela1_linha2" ><select name="idade_minima">
                            <?php 
								for ($i = 1; $i <= 100; $i++){
							?>
                            <option value="<?php=$i?>" <?php  if($objetolazer->idade_minima == $i){?> selected="selected" <?php  }?>>
                            <?php=$i?>
                            </option>
                            <?php 
								}
							?>
                          </select></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Tempo Mínimo</td>
					    <td class="tabela1_linha2" ><select name="Htempo_minimo">
                         <?php 
						 	for ($i = 0; $i <= 23; $i++){
								if($i < 10)
									$horamin = '0'.$i;
								else
									$horamin = $i;
								$mini = $objetolazer->tempo_minimo[0].$objetolazer->tempo_minimo[1];
						?>
                        <option value="<?php=$horamin?>" <?php  if($mini == $horamin){?> selected="selected" <?php  }?>><?php=$horamin?></option>
                         <?php 
							}
						?>
                        </select>
						:
						<select name="Mtempo_minimo">
						 <?php 
						  	for ($i = 0; $i <= 3; $i++){
								$minmin = $i.'0';
								$mini = $objetolazer->tempo_minimo[3].$objetolazer->tempo_minimo[4];
						?>
                        <option value="<?php=$minmin?>" <?php  if($mini == $minmin){?> selected="selected" <?php  }?>><?php=$minmin?></option>
                         <?php 
							}
						?>
                        </select>
						<span class="warning">*</span></td>
				      </tr>
					  <tr>
                        <td class="tabela1_linha2"  align="right"> Tempo Máximo </td>
					    <td class="tabela1_linha2" ><select name="Htempo_maximo">
                         <?php 
						 	for ($i = 0; $i <= 23; $i++){
								if($i < 10)
									$horamax = '0'.$i;
								else
									$horamax = $i;
								$max = $objetolazer->tempo_maximo[0].$objetolazer->tempo_maximo[1];
						?>
                        <option value="<?php=$horamax?>" <?php  if($max == $horamax){?> selected="selected" <?php  }?>><?php=$horamax?></option>
                         <?php 
							}
						?>
                        </select>
						:
						<select name="Mtempo_maximo">
						 <?php 
						 	for ($i = 0; $i <= 59; $i++){
								if($i < 10)
									$minmax = '0'.$i;
								else
									$minmax = $i;
								$max = $objetolazer->tempo_maximo[3].$objetolazer->tempo_maximo[4];
						?>
                        <option value="<?php=$minmax?>" <?php  if($max == $minmax){?> selected="selected" <?php  }?>><?php=$minmax?></option>
                         <?php 
							}
						?>
                        </select>
						<span class="warning">**</span></td>
					  </tr>
					  <tr>
					    <td colspan="2"  align="right" class="tabela1_linha2"><div align="left" class="warning">* Define a quantidade de divisões na tabela de reservas para este recurso. <br />
					    ** Define a quantidade máxima de horas a ser reservada por dia. </div></td>
				      </tr>
					  <tr>
                        <td colspan="2"  align="right" class="tabela1_linha2"><div align="center"><br />
                        <input type="image" src="../../images/enviar.jpg" /></div></td>
				      </tr>
                  </table>
			      </td>
                </tr>
              </table> 			  
			   <input type="hidden"  name="id" value="<?php=stripslashes($objetolazer->id)?>" />
			   <input type="hidden"  name="area" value="<?php=$area?>" />
		    </form> 
              <br />
              </p>
          </td>
          <td width="39" background="../../images/ld_box_bg.jpg">&nbsp;</td>
        </tr>
      </table></td>
   <td><img src="../../images/spacer.gif" width="1" height="40" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="71" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="83" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="48" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="73" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="54" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img src="../../images/spacer.gif" width="1" height="26" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><img name="fim_box" src="../../images/fim_box.jpg" width="714" height="32" border="0" id="fim_box" alt="" /></td>
   <td><img src="../../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="8" valign="top"><div align="center">
     <table width="655" border="0" align="right" cellpadding="0" cellspacing="0">
       <tr>
         <td><div align="center"><img src="../../images/rodape.jpg" width="583" height="23" /></div></td>
       </tr>
     </table>
   </div></td>
   <td><img src="../../images/spacer.gif" width="1" height="32" border="0" alt="" /></td>
  </tr>
</table>
 </body>
</html>
