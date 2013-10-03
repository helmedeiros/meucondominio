<?php 
class objetolazer {

    var $id;
	var $id_area;
	var $funcionamento;
    var $nome;
	var $inicio;
	var $fim;
    var $idade_minima;
	var $tempo_minimo;
	var $tempo_maximo;
	var $descricao;
	var $aviso;
    var $status;

function objetolazer(){
    $this->id = 0;
	$this->id_area = 0;
	$this->funcionamento = 0;
    $this->nome = "";
	$this->inicio = "08:00:00";
	$this->fim = "22:00:00";
    $this->idade_minima = 0;
	$this->tempo_minimo = "00:20:00";
	$this->tempo_maximo = "01:00:00";
	$this->descricao = "";
	$this->aviso = "";
    $this->status = 1;

    }
 }
?>