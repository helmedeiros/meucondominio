<?php 
class contatos {

    var $id;
    var $nome;
	var $cpf;
    var $telefone;
	var $celular;
	var $email;
    var $descricao;
	var $status;
	

function contatos(){
    $this->id = 0;
    $this->nome = "";
	$this->cpf = "";
    $this->telefone = "";
	$this->celular = "";
    $this->email = "";
    $this->descricao = "";
    $this->status = 0;
    }
 }
?>
