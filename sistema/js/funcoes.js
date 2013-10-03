function confirma(nome, oq){
	return confirm("Tem certeza que deseja excluir o "+oq+" "+nome+"?");
}

function confirmaa(){
	return confirm("Tem certeza que deseja excluir o ");
}

function confirmaarea(area){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+area.nome.value+"\nTamanho: "+area.tamanho.value+"\nFuncionamento: "+area.funcionamento.value+"");
}

function confirmaincalt(super){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+super.nome.value+"\nCelular: "+super.celular.value+"\nCPF: "+super.cpf.value+"\nLogin: "+super.login.value+"");
}

function confirmaincalt(super){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+super.nome.value+"\nCPF: "+super.cpf.value+"\nDescrição: "+super.descricao.value+"");
}

function confirmaCad(ac){
    return confirm("Confirma a adição dos seguintes dados?\nDados do Condomínio:\nNome do Condomínio: "+ac.nomecond.value+"\nCNPJ: "+ac.cnpj.value+"\nEndereço: "+ac.tipo_logradouro.value+""+ac.logradouro.value+", "+ac.numero_logradouro.value+", "+ac.bairro_logradouro.value+", "+ac.cidade_logradouro.value+"/"+ac.uf_logradouro.value+"\nCEP: "+ac.cep_logradouro.value+"\nTelefone: "+ac.telefone.value+"\nQtd. Apartamentos: "+ac.qtd_apartamentos.value+"\n\nDados do Solicitante:\nNome do Solicitante: "+ac.nomecnt.value+"\nCPF: "+ac.cpfcnt.value+"\nTelefone Residencial: "+ac.telefonecnt.value+"\nTelefone Celular: "+ac.celularcnt.value+"\nEmail :"+ac.emailcnt.value+"");

}


function confirmaMsg(ac){
	return confirm("Os Seguintes dados serão gravados no banco:\nTipo: "+ac.tipo.value+"\nDescrição: "+ac.descricao.value+"");
}

function confirmaAreaCusto(ac){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+ac.nome.value+"\nTipo: "+ac.tipo.value+"");
}

function confirmaCentroCusto(ac){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+ac.nome.value+"\nTipo: "+ac.numero.value+"");
}

function confirmaTipoUser(user){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+user.nome.value+"\nDescrição: "+user.descricao.value+"");
}

function confirmaCondominio(ac){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+ac.nome.value+"\nTipo: "+ac.cnpj.value+"");
}

function confirmaSituacaoFuncionamento(ac){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+ac.nome.value+"");
}

function confirmaMensagem(ac){
	return confirm("Tem certeza que deseja enviar a mensagem:\nNome: "+ac.mensagem.value+"");
}

function confirmaRegimento(ac){
	return confirm("Os Seguintes dados serão gravados no banco:\nNome: "+ac.regimento.value+"");
}

function muda(ac){
	document.location='adicionar.php?id='+ac.value;
} 

function confirmaReunioes(ac){
	return confirm("Os Seguintes dados serão gravados no banco:\nData: "+ac.data.value+"\nHora Inicial: "+ac.h1.value+":"+ac.m1.value+"\nHora Final: "+ac.h2.value+":"+ac.m2.value+"\nAssunto: "+ac.assunto.value+"");
}

function confirmaAtividades(ac){
	return confirm("Tem certeza que deseja enviar a seguinte atividade?:\nData de Realização: "+ac.data.value+"\nTítulo: "+ac.titulo.value+"Descrição: "+ac.descricao.value+"");
}

function mudaX(ac){
	document.location='excluir.php?id='+ac.value;
}

//função que a partir da opc enviada seleciona todos os itens de um determinado tipo de permissao
function checkall(opc){
	var nb;
	var chk;
	nb = (document.permissao.elements.length - 2)/3;	
	var z = 1;
	for (var i=1;i<=nb;i++){		
		for( var j=1;j<=3;j++){
			if (opc == j){				
				var e = document.permissao.elements[z];
				if(e.checked == 1){
					e.checked = 0;
				}else{
					e.checked = 1;	
				}
			}
			z = z + 1;
		}
	}	
}

function FormataCPF(Campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(Campo.value);
	vr = vr.replace(".", "");
	vr = vr.replace(".", "");
	vr = vr.replace("-", "");
	tam = vr.length + 1;
	if(tecla != 9 && tecla !=8){
		if(tam > 3 && tam < 7)
			Campo.value = vr.substr(0, 3) + '.' + vr.substr(3, tam);
		if(tam >= 7 && tam <10)
			Campo.value = vr.substr(0,3) + '.' + vr.substr(3,3) + '.' + vr.substr(6,tam-6);
		if(tam >= 10 && tam < 12)
			Campo.value = vr.substr(0,3) + '.' + vr.substr(3,3) + '.' + vr.substr(6,3) + '-' + vr.substr(9,tam-9);
	}
}

function FormataCNPJ(Campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(Campo.value);
	vr = vr.replace(".", "");
	vr = vr.replace(".", "");
	vr = vr.replace("/", "");
	vr = vr.replace("-", "");
	tam = vr.length + 1 ;
	if(tecla != 9 && tecla !=8){
		if(tam > 2 && tam < 6)
			Campo.value = vr.substr(0, 2) + '.' + vr.substr(2, tam);
		if(tam >= 6 && tam < 9)
			Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,tam-5);
		if(tam >= 9 && tam < 13)
			Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,tam-8);
		if(tam >= 13 && tam < 15)
			Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,4)+ '-' + vr.substr(12,tam-12);
	}
}

function FormataTEL(Campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(Campo.value);
	vr = vr.replace("(", "");
	vr = vr.replace(")", "");
	vr = vr.replace(" ", "");
	vr = vr.replace("-", "");
	tam = vr.length + 1 ;
	if(tecla != 9 && tecla !=8){
		if(tam >= 0 && tam < 2)
			Campo.value = '(' + vr.substr(0, 2);
		if(tam > 2 && tam <= 6)
			Campo.value = '(' + vr.substr(0, 2) + ') ' + vr.substr(2, tam);
		if(tam > 6 && tam < 9)
			Campo.value = '(' + vr.substr(0,2)  + ') ' + vr.substr(2,4) + '-' + vr.substr(6,4);		
		if(tam > 9)
			Campo.value = '(' + vr.substr(0,2)  + ') ' + vr.substr(2,4) + '-' + vr.substr(6,4);		
	}
}

function FormataFloat(Campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(Campo.value);
	vr = vr.replace(",", "");
	vr = vr.replace(".", "");
	vr = vr.replace(" ", "");	
	vr = vr.replace("-", "");	
	tam = vr.length + 1 ;
	if(tecla != 9 && tecla !=8){
		if(tam >= 0 && tam < 2)
			Campo.value = ',' + vr.substr(tam-2, 2);
		if(tam > 2 )
			Campo.value = vr.substr(0, tam-2) + ',' + vr.substr(tam-2, 2);
	}
}

function VerificaHora(h1, teclapres){ 

  return confirm("aa".teclapres);
}

function checa_formulario(reserva){
	if (reserva.dia.value == "selecione"){
		alert("Por Favor Selecione Um Dia !!!");
		reserva.dia.focus();
	return (false);
	}
	if (reserva.mes.value == "selecione"){
		alert("Por Favor Selecione Um Mês !!!");
		reserva.mes.focus();
	return (false);
	}
	if (reserva.ano.value == "selecione"){
		alert("Por Favor Selecione Um Ano !!!");
		reserva.ano.focus();
	return (false);
	}
	return (true);
}


function checa_formulario2(reserva){
	
	if (reserva.mes.value == "selecione"){
		alert("Por Favor Selecione Um Mês !!!");
		reserva.mes.focus();
	return (false);
	}
	if (reserva.ano.value == "selecione"){
		alert("Por Favor Selecione Um Ano !!!");
		reserva.ano.focus();
	return (false);
	}
	return (true);
}

function Numero(e){
	navegador = /msie/i.test(navigator.userAgent);
	if (navegador)
		var tecla = event.keyCode;
	else
		var tecla = e.which;
   	if(tecla > 47 && tecla < 58) // numeros de 0 a 9
		return true;
	else{
		if (tecla == 8) // backspace
			return true;
		else
		 if (tecla == 0) // tab
			return true;
		else
		 return false;
	}
}
