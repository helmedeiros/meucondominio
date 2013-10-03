<?php 
class aditivos {

    var $id;
	var $id_regimento;
	var $data_envio;
	var $nome_arquivo;
	var $status;
    var $aditivo;
	
function aditivos(){
    $this->id = 0;
    $this->id_regimento = 0;
    $this->data_envio = date('Y-m-d',time());
    $this->nome_arquivo == "";
	$this->status == "";
	$this->aditivo = "";	
	    }
 }
?>
