<?php 
class Ftp{
	var $conexao;
	var $host;
	var $usuario;
	var $senha;

	function Ftp($host = "ftp.meucondominio.net",$usuario="meucondominio2",$senha="m3uc0nd0m1n10"){
		$this->host = $host;
		$this->conexao = ftp_connect($this->host);
		$this->usuario = $usuario;
		$this->senha = $senha;
		//ftp_login($this->conexao, $this->usuario, $this->senha);
	}

	function salvaAta($dir, $arquivo, $nome_arquivo){
		$diretorio = "/home/restricted/home/meucondominio2/public_html/site/sistema/reuniao/atas/$dir/";
	    $nomeArquivo =  $diretorio . $nome_arquivo;
		//echo('$nomeArquivo --> '.$nomeArquivo.'<br> $arquivo[tmp_name] --> '. $arquivo['tmp_name']);
		if(move_uploaded_file( $arquivo['tmp_name'], $nomeArquivo ))
      //  echo('aqui');
	//	else
	//	echo('ops');
    chmod($nomeArquivo, 0777);
	}
	
	function salvaReg($dir, $arquivo, $nome_arquivo){
		$diretorio = "/home/restricted/home/meucondominio2/public_html/site/sistema/regimento/arquivos/$dir/";
	    $nomeArquivo =  $diretorio . $nome_arquivo;
		//echo('$nomeArquivo --> '.$nomeArquivo.'<br> $arquivo[tmp_name] --> '. $arquivo['tmp_name']);
		if(move_uploaded_file( $arquivo['tmp_name'], $nomeArquivo ))
      //  echo('aqui');
	//	else
	//	echo('ops');
    chmod($nomeArquivo, 0777);
	}	

	function salvaAdt($dir, $arquivo, $nome_arquivo){
		$diretorio = "/home/restricted/home/meucondominio2/public_html/site/sistema/regimento/arquivos/$dir/aditivos/";
	    $nomeArquivo =  $diretorio . $nome_arquivo;
		//echo('$nomeArquivo --> '.$nomeArquivo.'<br> $arquivo[tmp_name] --> '. $arquivo['tmp_name']);
		if(move_uploaded_file( $arquivo['tmp_name'], $nomeArquivo ))
      //  echo('aqui');
	//	else
	//	echo('ops');
    chmod($nomeArquivo, 0777);
	}	

	function salvaNota($dir, $arquivo, $nome_arquivo){
		$diretorio = "/home/restricted/home/meucondominio2/public_html/site/sistema/servico_terceirizado/nota/$dir/";
		$nomeArquivo =  $diretorio . $nome_arquivo;
		if(move_uploaded_file( $arquivo['tmp_name'], $nomeArquivo )){
			chmod($nomeArquivo, 777);
			return 1;
		}else{
			return 0;
		}
		
	}

	function deletaNota($arquivo, $dir){
		$arq = "/home/restricted/home/meucondominio2/public_html/site/sistema/servico_terceirizado/nota/$dir/$arquivo";
		return unlink($arq);
	}

	function criaDirCond($diretorio){
		mkdir("/home/restricted/home/meucondominio2/public_html/site/sistema/reuniao/atas/$diretorio", 0777);
		mkdir("/home/restricted/home/meucondominio2/public_html/site/sistema/regimento/arquivos/$diretorio", 0777);
		mkdir("/home/restricted/home/meucondominio2/public_html/site/sistema/regimento/arquivos/$diretorio/aditivos", 0777);
		mkdir("/home/restricted/home/meucondominio2/public_html/site/sistema/servico_terceirizado/nota/", 0777);
	}
}
?>