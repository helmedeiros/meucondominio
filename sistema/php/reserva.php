<?php 
class Reserva{
	var $id;
	var $id_membro;
	var $id_objeto;
	var $data_inicio;
	var $data_fim;
	var $comentario;
	var $status;
	
	
	
	function Reserva(){
		$this->id = 0;
		$this->id_membro = 0;
		$this->id_objeto = 0;		
		$this->data_inicio = date("Y-m-d", time());
		$this->data_fim = date("Y-m-d", time());;
		$this->comentario = "";
		$this->status = 0;
	}
	
}
?>