<?php 
class condominios {

    var $id;
    var $qtd_apartamentos;
    var $tipo_logradouro;
    var $logradouro;
    var $numero_logradouro;
    var $bairro_logradouro;
    var $cep_logradouro;
    var $cidade_logradouro;
    var $uf_logradouro;
    var $CNPJ;
    var $telefone;
    var $qtd_blocos;
    var $status;
	var $nome;
	var $id_contato;
	var $id_responsavel;
	var $data_criacao;

function condominios(){
    $this->id = 0;
    $this->qtd_apartamentos = "";
    $this->tipo_logradouro = "";
    $this->logradouro = "";
    $this->numero_logradouro = "";
    $this->bairro_logradouro = "";
    $this->cep_logradouro = "";
    $this->cidade_logradouro = "";
    $this->uf_logradouro = "";
    $this->CNPJ = "";
    $this->telefone = "";
    $this->qtd_blocos = "";
    $this->status = "";
	$this->nome = "";
	$this->id_contato = 0;
	$this->id_responsavel = 0;
	$this->data_criacao = "";
    }
 }
?>