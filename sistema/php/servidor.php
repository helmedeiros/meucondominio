<?php 
class Servidor {

    var $id;
    var $cpf;
    var $cnpj;
    var $nome_contato;
    var $telefone_contato;
    var $celular_contato;
    var $nome_servidor;
	var $telefone_servidor;
	var $celular_servidor;
	var $cidade_servidor;
	var $uf_servidor;
	var $status;

function Servidor(){
    $this->id = 0;
    $this->cpf = "";
    $this->cnpj = "";
    $this->nome_contato = "";
    $this->telefone_contato = "";
    $this->celular_contato = "";
    $this->nome_servidor = "";
	$this->telefone_servidor = "";
	$this->celular_servidor = "";
	$this->cidade_servidor = "";
	$this->uf_servidor = "";
	$this->status = 0;
    }
 }
?>
