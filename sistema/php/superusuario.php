<?php 
class SuperUsuario {

    var $id;
    var $id_tipo_usuario;
    var $nome;
    var $login;
    var $senha_alteracao;
    var $senha_criacao_condominio;
    var $senha;
	var $logado;
	var $numero_acessos;
	var $data_criacao;
	var $celular;
	var $status;
	var $email;

function SuperUsuario(){
    $this->id = 0;
    $this->id_tipo_usuario = 0;
    $this->nome = "";
    $this->login = "";
    $this->senha_alteracao = "";
    $this->senha_criacao_condominio = "";
    $this->senha = "";
	$this->logado = false;
	$this->numero_acessos = 0;
	$this->data_criacao = "";
	$this->celular = "";
	$this->email = "";	
	$this->status = 0;
    }
 }
?>