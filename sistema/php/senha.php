<?php 

	class Senha{
		//retorna 0 caso não seja permitido o cadastro
		function confSenha($senha, $login){			
			$tipo = Senha::tipoSenha($senha, $login); 
		 	switch($tipo){
				case 'baixo': return 0;
							  break;	
				case 'medio': return 0;	
							  break;
				case 'alto': return 1;	
							  break;
				case 'maximo': return 1;	
							  break;						
			}
		}
		
				
		//retorna os tipos de senha
		function tipoSenha($senha, $login){
						
			//senha com nível baixo
			
			//Baixa pelo tamanho
			if (strlen($senha) < 6){
				//echo("baixo");
				return 'baixo'; 
			}
			
			
			//Baixa pela repetição
			$cont = 1;			
			
			while ($cont <= (strlen($senha) - 3) + 1){
				$str = substr($senha, ($cont - 1), 1);
				$str1 = substr($senha, ($cont), 1);								
				$str2 = substr($senha, ($cont + 1), 1);
				//die('$str ' . $str . ' $str 1 ' . $str1 . ' $str2 ' .$str2);
				if(($str == $str1) and ($str1 == $str2)){
						//echo("baixo");
						return 'baixo'; 
				}else{
					$cont += 1;
				}
			
			}
			
			//baixa pela semelhança com login
			$cont = 1;			
			
			while ($cont <= (strlen($senha) - strlen($login)) + 1){
				//temp acumula a qtd de letras seguidas iguais
				$temp = 1;
				
				//navega pela senha
				$jSenha = 0;
				
				for ($i = $cont-1; $i < (strlen($login) + ($cont-1)); $i++){				
					//echo('S['. $i .']->' . $senha[$i] . ' L['. $jSenha .']->' . $login[$jSenha] . "<br>");
					if($senha[$i] == $login[$jSenha]){
						$temp += 1;
						$jSenha += 1;
					}else
						break;				
				}
				
				//echo("temp-> " . $temp . " strlenLogin-> " . strlen($login) . "<br>");
				
				if($temp-1 == strlen($login)){
						//echo("baixo");
						return 'baixo'; 
				}else{
					//echo("<br>" . "cont-> " . $cont . "<br>");
					$cont += 1;
				}
			
			}
			
			//baixa pela repetição de sequencia de números
			for($i = 0; $i < (strlen($senha)-2); $i ++){
				if($senha[$i] == ($senha[($i + 1)] - 1)){
					if($senha[$i+1] == ($senha[($i + 2)] - 1)){
						return 'baixo'; 
					}
				}
			}
			
			
			//baixa pela repetição de sequencia de caracteres
			for($i = 0; $i < (strlen($senha)-2); $i ++){
				if(ord($senha[$i]) == (ord($senha[($i + 1)]) - 1)){
					if(ord($senha[$i+1]) == (ord($senha[($i + 2)]) - 1)){
						return 'baixo'; 
					}
				}
			}
			
			
			//Médio 2 consecutivos identicos
			$cont = 1;			
			
			while ($cont <= (strlen($senha) - 2) + 1){
				$str = substr($senha, ($cont - 1), 1);
				$str1 = substr($senha, ($cont), 1);								
				//echo('$str[' . ($cont - 1) . ']-> ' . $str . ' $str[' . ($cont). ']->' . $str1 . "<br>");
				if(($str == $str1)){
						//echo("medio");
						return 'medio'; 
				}else{
					$cont += 1;
				}			
			}
			
			//máximo por possuir caracteres especiais
			$cont = 1;			
			$caracEspec = '|!#$%&()=.:,;*<>';
			
			for ($i = 0; $i < strlen($senha); $i++){
				for($j = 0; $j < strlen($caracEspec); $j++){
					//echo( '$senha['.$i.']-> ' . $senha[$i] . ' $caracEspec['.$j.']-> ' . $caracEspec[$j] . "<br>");
					if($senha[$i] == $caracEspec[$j]){
						//echo('maximo');
						return 'maximo';
					}
				}			
			}			
			
			
			
			//Alto pois não possui caracteres especiais
			//echo("alto");			
			return 'alto';
			
		
		}
		
		
		

	}
?>