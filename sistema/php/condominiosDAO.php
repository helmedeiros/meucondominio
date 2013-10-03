<?php 
class condominiosDAO{
	function findALL(){
        $return = false;
        $rs = mysql_query("SELECT * FROM condominios ORDER BY id_condominios");
        while ( $r = mysql_fetch_array($rs)){
			$condominios= new condominios();
			$condominios->id = $r['id_condominios'];
			$condominios->qtd_apartamentos = $r['qtd_apartamentos'];
			$condominios->tipo_logradouro = $r['tipo_logradouro'];
			$condominios->logradouro = $r['logradouro'];
			$condominios->numero_logradouro = $r['numero_logradouro'];
			$condominios->bairro_logradouro = $r['bairro_logradouro'];
			$condominios->cep_logradouro = $r['cep_logradouro'];
			$condominios->cidade_logradouro = $r['cidade_logradouro'];
			$condominios->uf_logradouro = $r['uf_logradouro'];
			$condominios->CNPJ = $r['CNPJ'];
			$condominios->telefone = $r['telefone'];
			$condominios->qtd_blocos = $r['qtd_blocos'];
			$condominios->status = $r['situacao'];
			$condominios->nome = $r['nome_condominio'];
			$condominios->id_contato = $r['FKid_contatoCol'];
			$condominios->id_responsavel = $r['FKid_super_usuariosCol'];
			$condominios->data_criacao = $r['data_insercao'];
			$result[] = $condominios;
    	}	
  		return $result;
 	}	
		
	function findTop($i = 0, $f = 0, $orderBy = "nome_condominio", $ordem = "ASC"){
		$result = false;				
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM condominios ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM condominios ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
                  $condominios = new condominios();
				  $condominios->id = $r['id_condominios'];
                  $condominios->qtd_apartamentos = $r['qtd_apartamentos'];
                  $condominios->tipo_logradouro = $r['tipo_logradouro'];
                  $condominios->logradouro = $r['logradouro'];
                  $condominios->numero_logradouro = $r['numero_logradouro'];
                  $condominios->bairro_logradouro = $r['bairro_logradouro'];
                  $condominios->cep_logradouro = $r['cep_logradouro'];
                  $condominios->cidade_logradouro = $r['cidade_logradouro'];
                  $condominios->uf_logradouro = $r['uf_logradouro'];
                  $condominios->CNPJ = $r['CNPJ'];
                  $condominios->telefone = $r['telefone'];
                  $condominios->qtd_blocos = $r['qtd_blocos'];
                  $condominios->status = $r['situacao'];
				  $condominios->nome = $r['nome_condominio'];
				  $condominios->id_contato = $r['FKid_contatoCol'];
                  $condominios->id_responsavel = $r['FKid_super_usuariosCol'];
				  $condominios->data_criacao = $r['data_insercao'];
                  $result[] = $condominios;
  		}
		return $result;
	}
	
	
	function findTopByBusca($nome, $cnpj, $contato, $responsavel, $i = 0, $f = 0, $orderBy = "id_condominios", $ordem = "ASC"){
		$result = false;
		$condicoes = "";
		$from = 'condominios cond';
		if ($nome != "") {
			$condicoes = " AND nome_condominio LIKE '%".$nome."%' ";
		}
		if ($cnpj != ""){
			$condicoes = $condicoes." AND cnpj LIKE '%".$cnpj."%' ";
		}		
		if ($contato != ""){
			if(is_numeric($responsavel)){
				$condicoes = $condicoes." AND FKid_contatoCol = ".$contato." ";
			}else{
				$condicoes = $condicoes." AND cont.nome like '%".$contato."%' ";
				$condicoes = $condicoes." AND cont.id_contato = cond.FKid_contatoCol";
				$from = $from.', contatos cont';
			}
		}		
		if ($responsavel != ""){
		  	if(is_numeric($responsavel)){
				$condicoes = $condicoes." AND FKid_super_usuariosCol = ".$responsavel." ";
			}else{
				$condicoes = $condicoes." AND sup.nome like '%".$responsavel."%' ";
				$condicoes = $condicoes." AND sup.id_super_usuarios = cond.FKid_super_usuariosCol";
				$from = $from.', super_usuarios sup';
			}
		}				
	
		if ($f > 0)
			$rs = mysql_query("SELECT * FROM $from WHERE cond.situacao = 1".$condicoes." OR cond.situacao = 0".$condicoes." ORDER BY $orderBy $ordem LIMIT $i, $f");
		else
			$rs = mysql_query("SELECT * FROM $from WHERE cond.situacao = 1".$condicoes." OR cond.situacao = 0".$condicoes." ORDER BY $orderBy $ordem");
		while ( $r = mysql_fetch_array($rs)){
                 $condominios= new condominios();
                  $condominios->id = $r['id_condominios'];
                  $condominios->qtd_apartamentos = $r['qtd_apartamentos'];
                  $condominios->tipo_logradouro = $r['tipo_logradouro'];
                  $condominios->logradouro = $r['logradouro'];
                  $condominios->numero_logradouro = $r['numero_logradouro'];
                  $condominios->bairro_logradouro = $r['bairro_logradouro'];
                  $condominios->cep_logradouro = $r['cep_logradouro'];
                  $condominios->cidade_logradouro = $r['cidade_logradouro'];
                  $condominios->uf_logradouro = $r['uf_logradouro'];
                  $condominios->CNPJ = $r['CNPJ'];
                  $condominios->telefone = $r['telefone'];
                  $condominios->qtd_blocos = $r['qtd_blocos'];
                  $condominios->status = $r['situacao'];
				  $condominios->nome = $r['nome_condominio'];
                  $condominios->id_contato = $r['FKid_contatoCol'];
                  $condominios->id_responsavel = $r['FKid_super_usuariosCol'];
				  $condominios->data_criacao = $r['data_insercao'];
                  $result[] = $condominios;
  		}
		return $result;
	}	
	
	function countAll(){
		$result = false;
		$rs = mysql_query("SELECT COUNT(*) AS total FROM condominios");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
	function countByBusca($nome, $cnpj, $contato, $responsavel){
		$return = false;
		$condicoes = "";
		$from = 'condominios cond';
		if ($nome != "") {
			$condicoes = " AND nome_condominio LIKE '%".$nome."%' ";
		}
		if ($cnpj != ""){
			$condicoes = $condicoes." AND cnpj LIKE '%".$tipo."%' ";
		}		
		if ($contato != ""){
			if(is_numeric($responsavel)){
				$condicoes = $condicoes." AND FKid_contatoCol = ".$contato." ";
			}else{
				$condicoes = $condicoes." AND cont.nome like '%".$contato."%' ";
				$condicoes = $condicoes." AND cont.id_contato = cond.FKid_contatoCol";
				$from = $from.', contatos cont';
			}
		}		
		if ($responsavel != ""){
		  	if(is_numeric($responsavel)){
				$condicoes = $condicoes." AND FKid_super_usuariosCol = ".$responsavel." ";
			}else{
				$condicoes = $condicoes." AND sup.nome like '%".$responsavel."%' ";
				$condicoes = $condicoes." AND sup.id_super_usuarios = cond.FKid_super_usuariosCol";
				$from = $from.', super_usuarios sup';
			}
		}				
		$rs = mysql_query("SELECT COUNT(*) AS total FROM $from WHERE cond.situacao = 1".$condicoes." OR cond.situacao = 0".$condicoes." ORDER BY id_condominios");
		if ($r = mysql_fetch_array($rs) ){
			$result = $r['total'];
		}
		return $result;
	}
	
    function findByPk($id){
              $return = false;
              $rs = mysql_query("SELECT * FROM condominios WHERE id_condominios = $id ");
              while ( $r = mysql_fetch_array($rs) ){
                  $condominios= new condominios();
                  $condominios->id = $r['id_condominios'];
                  $condominios->qtd_apartamentos = $r['qtd_apartamentos'];
                  $condominios->tipo_logradouro = $r['tipo_logradouro'];
                  $condominios->logradouro = $r['logradouro'];
                  $condominios->numero_logradouro = $r['numero_logradouro'];
                  $condominios->bairro_logradouro = $r['bairro_logradouro'];
                  $condominios->cep_logradouro = $r['cep_logradouro'];
                  $condominios->cidade_logradouro = $r['cidade_logradouro'];
                  $condominios->uf_logradouro = $r['uf_logradouro'];
                  $condominios->CNPJ = $r['CNPJ'];
                  $condominios->telefone = $r['telefone'];
                  $condominios->qtd_blocos = $r['qtd_blocos'];
                  $condominios->status = $r['situacao'];
				  $condominios->nome = $r['nome_condominio'];
                  $condominios->id_contato = $r['FKid_contatoCol'];
                  $condominios->id_responsavel = $r['FKid_super_usuariosCol'];
				  $condominios->data_criacao = $r['data_insercao'];
                  $result = $condominios;
              }
          return $result;
   }   
   
   function existeByNomCnpj($nome = '', $cnpj){

		$result = false;
		$rs = mysql_query("SELECT * FROM condominios WHERE nome_condominio = '$nome' OR cnpj = '$cnpj'");
		if ($r = mysql_fetch_array($rs) ){
			$result = true; 
			}
		return $result;
	}
	
	function existByContatoId($contato, $id){
		$result = false;
		$rs = mysql_query("SELECT * FROM condominios WHERE id_condominios <> $id AND FKid_contatoCol = $contato");
		if ($r = mysql_fetch_array($rs) ){
			$result = true; 
			}
		return $result;
	}
     
	function lastId(){
           $return = false;
           $rs = mysql_query("SELECT id_condominios FROM condominios ORDER BY id_condominios DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
                $lid =  $r['id_condominios'];
		     	$result = $lid;
      	}
          return $result;
   }
	
	
		function lastResp(){
           $return = false;
           $rs = mysql_query("SELECT FKid_super_usuariosCol FROM condominios ORDER BY id_condominios DESC LIMIT 1");
			  while ( $r = mysql_fetch_array($rs) ) {
                $lid =  $r['FKid_super_usuariosCol'];
		     	$result = $lid;
      	}
          return $result;
   }
	 
	function save($condominios){
		if ( $condominios->id == 0){
		   return mysql_query("INSERT INTO condominios (qtd_apartamentos, tipo_logradouro, logradouro, numero_logradouro, bairro_logradouro, cep_logradouro, cidade_logradouro, uf_logradouro, CNPJ, telefone, qtd_blocos, situacao, nome_condominio, FKid_contatoCol, FKid_super_usuariosCol, data_insercao) VALUES ({$condominios->qtd_apartamentos}, '{$condominios->tipo_logradouro}', '{$condominios->logradouro}', '{$condominios->numero_logradouro}', '{$condominios->bairro_logradouro}', '{$condominios->cep_logradouro}',  '{$condominios->cidade_logradouro}', '{$condominios->uf_logradouro}', '{$condominios->cnpj}', '{$condominios->telefone}', {$condominios->qtd_blocos}, '{$condominios->status}', '{$condominios->nome}', {$condominios->id_contato}, {$condominios->id_responsavel}, '{$condominios->data_criacao}')");
		}else{
			return mysql_query("UPDATE condominios SET qtd_apartamentos = {$condominios->qtd_apartamentos}, tipo_logradouro = '{$condominios->tipo_logradouro}', logradouro = '{$condominios->logradouro}', numero_logradouro = '{$condominios->numero_logradouro}', bairro_logradouro = '{$condominios->bairro_logradouro}', cep_logradouro = '{$condominios->cep_logradouro}', cidade_logradouro = '{$condominios->cidade_logradouro}', uf_logradouro = '{$condominios->uf_logradouro}', cnpj = '{$condominios->cnpj}', telefone = '{$condominios->telefone}', qtd_blocos = {$condominios->qtd_blocos}, nome_condominio = '{$condominios->nome}', FKid_contatoCol = '{$condominios->id_contato}', FKid_super_usuariosCol = '{$condominios->id_responsavel}', situacao = '{$condominios->status}' WHERE id_condominios = '{$condominios->id}'");
		}
	}

    function delete($id){
		mysql_query("UPDATE condominios SET situacao = 0 WHERE id_condominios = $id");
	}
}
?>