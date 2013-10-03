<?php 
class regimentos {

    var $id;
	var $id_condominio;
	var $data_envio;
	var $regimento;
    var $nome_arquivo;
	var $status;

function regimentos(){
    $this->id = 0;
    $this->id_condominio = 0;
    $this->data_envio = date('Y-m-d',time());
	$this->regimento = "";
    $this->nome_arquivo == "";
	$this->status == "";
	
	    }
 }
?>
