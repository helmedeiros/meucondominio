<?php 
class funcionarios {

    var $id;
    var $id_condominios;
    var $id_tipo_funcionario;
    var $nome;
    var $data_nascimento;
    var $cpf;
    var $telefone;
    var $celular;
    var $email;
	var $login;
    var $senha;
    var $numero_acessos;
	var $data_criacao;
    var $status;

function funcionarios(){
    $this->id = 0;
    $this->id_condominios = 0;
    $this->id_tipo_funcionario = 0;
    $this->nome = "";
    $this->data_nascimento = date('Y-m-d',time());
    $this->cpf = "";
    $this->telefone = "";
    $this->celular = "";
    $this->email = "";
    $this->numero_apartamento = 0;
    $this->login = "";
    $this->senha = "";
    $this->proprietario = 0;
	$this->numero_acessos = 0;
	$this->data_criacao = "";
    $this->status = 0;
    }
 }
?>