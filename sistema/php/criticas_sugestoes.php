<?php 
class criticas_sugestoes {

    var $id;
	var $id_prioridade;
    var $id_membroscondominio;
    var $data_envio;
    var $mensagem;
	var $status;
    var $resolucao;
    var $destinatario;
	var $tipo;
	var $data_recebimento;
	var $data_resolucao;	

function criticas_sugestoes(){
    $this->id = 0;
    $this->id_prioridade = 0;
    $this->id_membroscondominio = 0;
	$this->data_envio = date('Y-m-d',time());
    $this->mensagem = "";
	$this->status == "";
    $this->resolucao = "";
	$this->destinatario = "";
	$this->tipo == "";
	$this->data_recebimento = date('Y-m-d',time());
	$this->data_resolucao = date('Y-m-d',time());;	

	
	    }
 }
?>
