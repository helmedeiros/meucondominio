<?php 
class ReceitaDespesa{
	var $id;
	var $id_condominio;
	var $id_centro;
	var $documento;
	var $data_emissao;
	var $data_vencimento;
	var $data_pagamento_recebimento;
	var $valor;
	var $forma_pagamento;
	var $observacao;
	var $pagante_fornecedor;
	var $valor_pago;
	var $status;
	var $recebido_pago;
	var $centro;
	var $area;	
	
	
	
	function ReceitaDespesa(){
		$this->id = 0;
		$this->id_condominio = 0;
		$this->id_centro = 0;		
		$this->documento = "-";		
		$this->data_emissao = date("Y-m-d", time());
		$this->data_vencimento = date("Y-m-d", time());
		$this->data_pagamento_recebimento = "0000-00-00";
		$this->valor = "";
		$this->forma_pagamento = "-";
		$this->observacao = "-";
		$this->pagante_fornecedor = "-";
		$this->valor_pago = "";
		$this->status = 1;
		$this->recebido_pago = "-";
		$this->centro = new centrocustos();
		$this->area = new areacustos();
	}
	
}
?>