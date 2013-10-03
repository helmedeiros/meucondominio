<?php 
$condomenu = condominiosDAO::findAll();
?>

<table width="169" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40"><a href="<?php=$pontinhos?>home.php"><img name="topo_logo" src="<?php=$pontinhos?>images/topo_logo.jpg" width="169" height="40" border="0" id="topo_logo" alt="" /></a></td>
  </tr>
  <tr> 
  <?php  if ($condomenu){ ?>
    <td height="77" background="<?php=$pontinhos?>images/box_condominios.jpg"><!-- condominios -->
        <div class="boxcondominios">
          <form action="<?php=$pontinhos?>pagina_condominio/home.php" method="post"> 
		  <select name="id_condominio" onchange="submit()"> 
		  <?php  if ($j !=1){ ?>
		      <option selected>SELECIONAR</option> <?php  } ?>
               <?php  for ($i = 0; $i < sizeof($condomenu); $i++){ ?>
			    $j = 1;
              <option value="<?php=$condomenu[$i]->id?>"><?php=substr($condomenu[$i]->nome,0,20)?><?php  if(strlen($condomenu[$i]->nome) > 20){?>...<?php  }?> </option> <?php  } ?>
            </select>
                    </form>
		  <?php  } ?>
    </div></td>
  </tr>
  <tr>
    <td background="<?php=$pontinhos?>images/bg_condominios.jpg">
	
	<!-- menu condominio -->
	
	<table width="140" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>pagina_condominio/home.php">P&aacute;gina do Condom&iacute;nio</a></td>
      </tr>
      <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>area_lazer/home.php">Areas de Lazer</a></td>
      </tr>
	   <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>atividades/home.php">Atividades</a></td>
      </tr>
       <tr>
         <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>contato/home.php">Contatos</a></td>
       </tr>
       <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>criticas_sugestoes/home.php">Cr&iacute;ticas e sugest&otilde;es</a></td>
      </tr>
      <tr>
	    <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>despesa/home.php">Despesas</a></td>
	  </tr>
	  <tr>
	    <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>funcionarios/home.php">Funcion&aacute;rios</a></td>
	  </tr>
      <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>membro_condominio/home.php">Membros</a></td>
      </tr>
      <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>mensagens/home.php">Mensagens</a></td>
      </tr>            
	  <tr>
	    <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>receita/home.php">Receitas</a></td>
	  </tr>
	  <tr>
	    <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>regimento/home.php">Regimentos</a></td>
	  </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>reserva/home.php">Reservas</a></td>
      </tr>      
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>reuniao/home.php">Reuni&otilde;es</a></td>
      </tr>
	  <tr>
	    <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>servico_terceirizado/home.php">Servi&ccedil;os Terceirizados</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="#">&nbsp;</a></td>
      </tr>
    </table>
	
	</td>
  </tr>
  <tr>
    <td height="48"><img name="box_sistema" src="<?php=$pontinhos?>images/box_sistema.jpg" width="169" height="48" border="0" id="box_sistema" alt="" /></td>
  </tr>
  <tr>
    <td background="<?php=$pontinhos?>images/bg_sistema.jpg">
	
	<!-- menu sistema -->
	
	<table width="140" border="0" align="center" cellpadding="0" cellspacing="0">
       <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>area_custo/home.php">Area de Custos</a></td>
      </tr>	 
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>condominio/home.php">Condom&iacute;nios</a></td>
      </tr>	  
	  <tr>
	    <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>funcionamento/home.php">Funcionamento</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>modulo/home.php">M&oacute;dulos</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>nivel_prioridade/home.php">N&iacute;veis de Prioridade</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>permissao/home.php">Permiss&otilde;es</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>servidor/home.php">Prestadores de Servi&ccedil;o</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>super_usuario/home.php">Super-Usu&aacute;rios</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>tipo_funcionario/home.php">Tipos Funcion&aacute;rios</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>tipo_permissao/home.php">Tipos de Permiss&otilde;es</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>tipo_servico/home.php">Tipos de Servi&ccedil;o</a></td>
	    </tr>
	  <tr>
        <td height="20" class="fontemenu"><a href="<?php=$pontinhos?>tipo_usuario/home.php">Tipos de Usu&aacute;rios</a></td>
	    </tr>   
	  <tr>
        <td height="20" class="fontemenu"></td>
      </tr>      
    </table>
	
	</td>
  </tr>
  <tr>
    <td height="54" background="<?php=$pontinhos?>images/bg_saudacao.jpg" class="verdanaMarronBold">
	
	<!-- logoff -->
    <div class="logoff"><div class="posiLogoff"><a href="<?php=$pontinhos?>super_usuario/adicionar.php?id=<?php=strtoupper($usuario->id)?>" ><?php=strtoupper($usuario->nome)?></a>
      , bom te ver!!<br />
      para sair clique <a href="<?php=$pontinhos?>logoff.php">AQUI</a>!
	 </div>	
	</td>
  </tr>
  <tr>
    <td><img name="complemento_menu" src="<?php=$pontinhos?>images/complemento_menu.jpg" width="169" height="14" border="0" id="complemento_menu" alt="" /></td>
  </tr>
  <tr>
    <td background="<?php=$pontinhos?>images/complemento_menu_bottom.jpg"></td>
  </tr>
</table>
