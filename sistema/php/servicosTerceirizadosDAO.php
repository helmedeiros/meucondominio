<?php 
class servicosTerceirizadosDAO{
	function findAll(){
		$result = false;
		$rs = mysql_query("SELECT * FROM servicos_tercerizados ORDER BY data_prestacao DESC");
		while ( $r = mysql_fetch_array($rs) ){
			$servicos_tercerizados = new servicosTerceirizados();
			$servicos_tercerizados->id = $r['id_servicos_tercerizados'];	
			$servicos_tercerizados->id_condominio = $r['FKid_condominiosCol'];					
			$servicos_tercerizados->copia_nota = $r['copia_nota'];
			$servicos_tercerizados->data_prestacao = $r['data_prestacao'];
			$servicos_tercerizados->status = $r['situacao'];
			$servicos_tercerizados->despesa = ReceitaDespesaDAO::findByPk($r['FKid_receita_despesaCol']);
			$servicos_tercerizados->servidor = ServidorDAO::findByPk($r['FKid_servidoresCol']);
			$servicos_tercerizados->tipoServico = tiposservicosDAO::findByPk($r['FKid_tipos_servicosCol']);
			$result[] = $servicos_tercerizados;
		}
		return $result;
	}
	
	function findTopByBusca($tiposServicos, $mes, $ano, $condominio, $servidor="", $id = 0, $i = 0, $f = 0, $orderBy = "s.data_prestacao", $ordem = "DESC"){
		$result = false;
		$condicoes = "";
		$whatelse = "";
		$groupby = "";
		$from = 'servicos_tercerizados s';	
		$from = $from.', tipos_servicos t';		
		$condicoes = $condicoes." AND  t.id_tipos_servicos = s.FKid_tipos_servicosCol";			
		if ($tiposServicos != ""){
			if(is_numeric($tiposServicos)){
				$condicoes = $condicoes." AND t.id_tipos_servicos = ".$tiposServicos." ";
			}else{
				$condicoes = $condicoes." AND t.nome like '%".$tiposServicos."%' ";				
			}
							
		}		
		if ($mes != ""){	
			$condicoes =  $condicoes." AND MONTH(s.data_prestacao) = '".$mes."'";		
		}	
		if ($ano != ""){	
			$condicoes =  $condicoes." AND YEAR(s.data_prestacao) = '".$ano."'";			
		}						
		if ($condominio != ""){
			if(is_numeric($condominio)){
				$condicoes = $condicoes." AND cond.id_condominios = ".$condominio." ";
			}else{
				$condicoes = $condicoes." AND cond.nome_condominio like '%".$condominio."%' ";
				
			}
				$condicoes = $condicoes." AND  s.FKid_condominiosCol = cond.id_condominios";
				
				$from = $from.', condominios cond';			
		}	
		if ($servidor != ""){
			if(is_numeric($servidor)){
				$condicoes = $condicoes." AND serv.id_servidores = ".$servidor." ";
			}else{
				$condicoes = $condicoes." AND serv.nome_servidor like '%".$servidor."%' ";				
			}
				$condicoes = $condicoes." AND  serv.id_servidores = s.FKid_tipos_servicosCol";
				$from = $from.', servidores serv';											
		}					
		if ($id != 0){			
				$condicoes = $condicoes." AND s.id_servicos_tercerizados = ".$id."";			
		}	
		
		//die("SELECT s.*".$whatelse." FROM $from WHERE s.situacao = 1".$condicoes." $groupby ORDER BY $orderBy $ordem");
			
		
		if ($f > 0)
			$rs = mysql_query("SELECT s.*".$whatelse." FROM $from WHERE s.situacao = 1".$condicoes." $groupby ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT s.*".$whatelse." FROM $from WHERE s.situacao = 1".$condicoes." $groupby ORDER BY $orderBy $ordem");
		
		while ( $r = mysql_fetch_array($rs)){
        	$servicos_tercerizados = new servicosTerceirizados();			
			$servicos_tercerizados->id = $r['id_servicos_tercerizados'];	
			$servicos_tercerizados->id_condominio = $r['FKid_condominiosCol'];		
			$servicos_tercerizados->copia_nota = $r['copia_nota'];
			$servicos_tercerizados->data_prestacao = $r['data_prestacao'];
			$servicos_tercerizados->status = $r['situacao'];
			$servicos_tercerizados->despesa = ReceitaDespesaDAO::findByPk($r['FKid_receita_despesaCol']);
			$servicos_tercerizados->servidor = ServidorDAO::findByPk($r['FKid_servidoresCol']);
			$servicos_tercerizados->tipoServico = tiposservicosDAO::findByPk($r['FKid_tipos_servicosCol']);						
			$result[] = $servicos_tercerizados;
  		}					
		return $result;
	}	
	
	function findByPk($id){
		$result = false;
		$rs = mysql_query("SELECT * FROM servicos_tercerizados WHERE id_servicos_tercerizados = $id");
		if ($r = mysql_fetch_array($rs) ){
			$servicos_tercerizados = new servicosTerceirizados();
			$servicos_tercerizados->id = $r['id_servicos_tercerizados'];	
			$servicos_tercerizados->id_condominio = $r['FKid_condominiosCol'];		
			$servicos_tercerizados->copia_nota = $r['copia_nota'];
			$servicos_tercerizados->data_prestacao = $r['data_prestacao'];
			$servicos_tercerizados->status = $r['situacao'];
			$servicos_tercerizados->despesa = ReceitaDespesaDAO::findByPk($r['FKid_receita_despesaCol']);
			$servicos_tercerizados->servidor = ServidorDAO::findByPk($r['FKid_servidoresCol']);
			$servicos_tercerizados->tipoServico = tiposservicosDAO::findByPk($r['FKid_tipos_servicosCol']);
			$result = $servicos_tercerizados;
		}
		return $result;
	}
	
	function findByTipoServico($id){
		$result = false;
		$rs = mysql_query("SELECT * FROM servicos_tercerizados WHERE FKid_tipos_servicosCol = $id");
		while ($r = mysql_fetch_array($rs) ){
			$servicos_tercerizados = new servicosTerceirizados();
			$servicos_tercerizados->id = $r['id_servicos_tercerizados'];	
			$servicos_tercerizados->id_condominio = $r['FKid_condominiosCol'];		
			$servicos_tercerizados->copia_nota = $r['copia_nota'];
			$servicos_tercerizados->data_prestacao = $r['data_prestacao'];
			$servicos_tercerizados->status = $r['situacao'];
			$servicos_tercerizados->despesa = ReceitaDespesaDAO::findByPk($r['FKid_receita_despesaCol']);
			$servicos_tercerizados->servidor = ServidorDAO::findByPk($r['FKid_servidoresCol']);
			$servicos_tercerizados->tipoServico = tiposservicosDAO::findByPk($r['FKid_tipos_servicosCol']);
			$result[] = $servicos_tercerizados;
		}
		return $result;
	}
	
	function findBySituacao($situacao){
		$result = false;
		$rs = mysql_query("SELECT * FROM servicos_tercerizados WHERE situacao = $situacao");
		while ($r = mysql_fetch_array($rs) ){
			$servicos_tercerizados = new servicosTerceirizados();
		$servicos_tercerizados->id = $r['id_servicos_tercerizados'];	
			$servicos_tercerizados->id_condominio = $r['FKid_condominiosCol'];		
			$servicos_tercerizados->copia_nota = $r['copia_nota'];
			$servicos_tercerizados->data_prestacao = $r['data_prestacao'];
			$servicos_tercerizados->status = $r['situacao'];
			$servicos_tercerizados->despesa = ReceitaDespesaDAO::findByPk($r['FKid_receita_despesaCol']);
			$servicos_tercerizados->servidor = ServidorDAO::findByPk($r['FKid_servidoresCol']);
			$servicos_tercerizados->tipoServico = tiposservicosDAO::findByPk($r['FKid_tipos_servicosCol']);
			$result[] = $servicos_tercerizados;
		}
		return $result;
	}
	
	function findByMes($data){
		$result = false;
		$rs = mysql_query("SELECT * FROM servicos_tercerizados WHERE MONTH(data_prestacao) = $data");
		if ($r = mysql_fetch_array($rs) ){
			$servicos_tercerizados = new servicosTerceirizados();
			$servicos_tercerizados->id = $r['id_servicos_tercerizados'];	
			$servicos_tercerizados->id_condominio = $r['FKid_condominiosCol'];		
			$servicos_tercerizados->copia_nota = $r['copia_nota'];
			$servicos_tercerizados->data_prestacao = $r['data_prestacao'];
			$servicos_tercerizados->status = $r['situacao'];
			$servicos_tercerizados->despesa = ReceitaDespesaDAO::findByPk($r['FKid_receita_despesaCol']);
			$servicos_tercerizados->servidor = ServidorDAO::findByPk($r['FKid_servidoresCol']);
			$servicos_tercerizados->tipoServico = tiposservicosDAO::findByPk($r['FKid_tipos_servicosCol']);
			$result = $servicos_tercerizados;
		}
		return $result;
	}

	function findByTipoServicoMes($tipo, $mes, $ano){
		$result = false;
		$rs = mysql_query("SELECT s.* FROM servicos_tercerizados s, tipos_servicos t WHERE t.id_tipos_servicos = s.FKid_tipos_servicosCol AND t.nome = '{$tipo}' AND MONTH(s.data_prestacao) = $mes AND YEAR(s.data_prestacao) = $ano ORDER BY t.nome");
		while ($r = mysql_fetch_array($rs) ){
			$servicos_tercerizados = new servicosTerceirizados();
			$servicos_tercerizados->id = $r['id_servicos_tercerizados'];	
			$servicos_tercerizados->id_condominio = $r['FKid_condominiosCol'];		
			$servicos_tercerizados->copia_nota = $r['copia_nota'];
			$servicos_tercerizados->data_prestacao = $r['data_prestacao'];
			$servicos_tercerizados->status = $r['situacao'];
			$servicos_tercerizados->despesa = ReceitaDespesaDAO::findByPk($r['FKid_receita_despesaCol']);
			$servicos_tercerizados->servidor = ServidorDAO::findByPk($r['FKid_servidoresCol']);
			$servicos_tercerizados->tipoServico = tiposservicosDAO::findByPk($r['FKid_tipos_servicosCol']);
			$result[] = $servicos_tercerizados;
		}
		return $result;
	}
	
	function somaValoresByTipo($tipo, $mes, $ano, $condominio){
		$result = false;
		$rs = mysql_query("SELECT sum(r.valor) as soma FROM tipos_servicos t, servicos_tercerizados s, receita_despesa r WHERE t.id_tipos_servicos = s.FKid_tipos_servicosCol AND s.FKid_receita_despesaCol = r.id_receita_despesa AND t.nome = '{$tipo}' AND MONTH(s.data_prestacao) = $mes AND YEAR(s.data_prestacao) = $ano AND s.FKid_condominiosCol = $condominio  ORDER BY t.nome");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['soma'];
		}
		return $result;
	}
	
	
	function somaTotal($tipo, $mes, $ano, $condominio){
		$result = false;
		$rs = mysql_query("SELECT sum(t.valor) as soma FROM tipos_servicos t, servicos_tercerizados r WHERE t.id_tipos_servicos = s.FKid_tipos_servicosCol AND t.nome = '{$tipo}' AND MONTH(s.data_prestacao) = $mes AND YEAR(s.data_prestacao) = $ano AND s.FKid_condominiosCol = $condominio ORDER BY t.nome");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['soma'];
		}
		return $result;
	}
	
	
	function save($servicos_tercerizados){		
		if ( $servicos_tercerizados->id == 0 ){
			return mysql_query("INSERT INTO `servicos_tercerizados` (`FKid_condominiosCol`, `FKid_tipos_servicosCol`, `FKid_servidoresCol`, `FKid_receita_despesaCol`, `copia_nota`, `data_prestacao`, `situacao`) VALUES ({$servicos_tercerizados->id_condominio}, {$servicos_tercerizados->tipoServico->id}, {$servicos_tercerizados->servidor->id}, {$servicos_tercerizados->despesa->id}, '{$servicos_tercerizados->copia_nota}', '{$servicos_tercerizados->data_prestacao}', '{$servicos_tercerizados->status}')");
		}else{
			return mysql_query("UPDATE servicos_tercerizados SET FKid_condominiosCol = {$servicos_tercerizados->id_condominio}, FKid_tipos_servicosCol = {$servicos_tercerizados->tipoServico->id}, FKid_servidoresCol = {$servicos_tercerizados->servidor->id}, FKid_receita_despesaCol = {$servicos_tercerizados->despesa->id}, copia_nota = '{$servicos_tercerizados->copia_nota}', data_prestacao = '{$servicos_tercerizados->data_prestacao}', situacao = '{$servicos_tercerizados->status}' WHERE id_servicos_tercerizados = {$servicos_tercerizados->id}");
		}
	}
	
	function delete($id){
		mysql_query("DELETE FROM servicos_tercerizados WHERE id_servicos_tercerizados = $id");
		
	}
}
?>