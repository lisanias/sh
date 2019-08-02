<?php
		//envio o charset para evitar problemas
		  header("Content-Type: text/html; charset=utf-8");
		  
		//incluir função para verificar cpf
		include ("inc_verifica_CPF.php");

		//pegar as variáveis enviadas
		$input = $_GET['input'];
		$pesquisa = $_GET['pesquisa'];

      //faço a conexão com o banco
		$con = mysqli_connect('localhost', 'sagra213_hosana', 'lucas#3$1', 'sagra213_hosana');
		
		// verificar a conexão
		if (mysqli_connect_error($con))
		  {
		  		echo "Falha ao conectar com o banco de dados, erro: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")<br>";
		  }
        
		switch ($pesquisa){
			case 'email':
				$sql = "SELECT * FROM  alunos WHERE email = '" . $input . "'";
				if(!$result = $con->query($sql)){
					die('Ha um erro ao executar a pesquisa na base de dados [' . $con->error . ']');
				}
				
			   if( mysqli_num_rows( $result ) > 0 )//se retornar algum resultado
					{
					   echo 'ok##O email <em>'. $input .'</em><br> já consta na lista de <br>alunos do Hosana!';
					}
				break;
				
			case 'login':
				$sql = "SELECT * FROM  alunos WHERE login = '" . $input . "'";
				if(!$result = $con->query($sql)){
					die('Ha um erro ao executar a pesquisa na base de dados [' . $con->error . ']');
				}
				
			   if( mysqli_num_rows( $result ) > 0 )//se retornar algum resultado
					{
					   echo 'ok##O login <em>'. $input .'</em> não está disponível!';
					}
				break;
			
			case 'cpf':

				//verificar cpf válido				
				if (!validaCPF($input)){
					echo 'ok##CPF '. $input .' é inválido';
					break;
				}
				
				// verificar se o CPF já está cadastrado
				$sql = "SELECT * FROM  alunos WHERE cpf = '" . $input . "'";
				if(!$result = $con->query($sql)){
					die('ok##Há um erro ao executar a pesquisa na base de dados [' . $con->error . ']');
				}
				
			   if( mysqli_num_rows( $result ) > 0 )//se retornar algum resultado
					{
					   echo 'ok##O CPF digitado (<em>'. $input .'</em>) já está cadastrado.';
					}
				break;
		}
		mysqli_close($con);
?>