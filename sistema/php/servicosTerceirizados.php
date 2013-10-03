<?php 
class servicosTerceirizados{
	var $id;
	var $id_condominio;
	var $copia_nota;
	var $data_prestacao;
	var $status;
	var $despesa;
	var $servidor;
	var $tipoServico;	
	
	
	
	function servicosTerceirizados(){
		$this->id = 0;
		$this->id_condominio = 0;
		$this->copia_nota = "";
		$this->data_prestacao = date("Y-m-d", time());
		$this->status = 1;
		$this->despesa = new ReceitaDespesa();
		$this->servidor = new Servidor();
		$this->tipoServico = new tiposservicos();
	}
	
}
?>