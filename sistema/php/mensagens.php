<?php 
class mensagens {

    var $id;
	var $id_membroscondominio;
    var $id_condominio;
	var $data_envio;
	var $mensagem;
	var $status;

function atividades(){
    $this->id = 0;
    $this->id_membroscondominio = 0;
	$this->id_condominio = 0;
    $this->data_envio = date('Y-m-d',time());
	$this->mensagem == "";
	$this->status == "";
	
	    }
 }
?>