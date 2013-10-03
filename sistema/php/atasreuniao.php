<?php 
class atasreuniao {

    var $id;
	var $id_condominio;
    var $id_membroscondominio;
    var $data_insercao;
	var $data_realizacao;
	var $hora_inicio;
	var $hora_fim;
    var $nome_arquivo;
	var $assunto;
	var $status;

function atasreuniao(){
    $this->id = 0;
    $this->id_membroscondominio = 0;
	$this->id_condominio = 0;
    $this->data_insercao = "";
    $this->data_realizacao = date('Y-m-d',time());
	$this->hora_inicio = "";
	$this->hora_fim == "";
    $this->nome_arquivo == "";
	$this->assunto == "";
	$this->status == "";
	
	    }
 }
?>
