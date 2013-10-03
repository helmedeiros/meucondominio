<?php 
class atividades {

    var $id;
	var $id_membroscondominio;
    var $id_condominio;
    var $id_prioridade;
	var $data_realizacao;
	var $descricao;
	var $titulo;
	var $status;

function atividades(){
    $this->id = 0;
    $this->id_membroscondominio = 0;
	$this->id_condominio = 0;
	$this->id_prioridade = 0;
    $this->data_realizacao = date('Y-m-d',time());
	$this->descricao == "";
	$this->titulo == "";
	$this->status == "";
	
	    }
 }
?>