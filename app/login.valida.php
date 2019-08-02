<?php
// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Pegar valores digitados (login e senha)
    // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
    $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
	$conectado = (isset($_POST['conectado'])) ? $_POST['conectado'] : 'n';
	
    // Codifica senha para depois comparar o com banco de dados
    $senha = sha1(SALT.$senha);

    // Monta a consulta para buscar os dados que serão comparados
    $sql = "SELECT * FROM user where login='".$usuario."' and senha='".$senha."'";
    
    $tabela = mysqli_query($con,$sql);
    $dados = mysqli_fetch_array($tabela);
    
    // se o resultado retornar uma linha é porque temos um usuário valido
    if (isset($dados)) {
        // Definimos os dois valores na sessão com os dados do usuário
        $_SESSION['usuario'] = $dados['login'];
		$_SESSION['id_user'] = $dados['id_user'];
        $_SESSION['senha'] = $senha; 
        $_SESSION['nome_user'] = $dados['nome'];
        $_SESSION['email'] = $dados['email'];
		$_SESSION['logado'] = sha1($dados['id_user']);
		setcookie("user", $usuario, time()+2592000);
		
		//verfica se permanecer conetado está ativo
		if ($conectado == "s") {
			// cria um cookie unico
			$stringid = md5(uniqid(rand(), true));
			// grava um cokie com o valor conectado
			setcookie("stringid", $stringid, time()+2592000);
			// grava a nova stringid na BD do uduário
			$sql = "UPDATE user SET stringid = '" . $stringid . "' WHERE id_user = " . $_SESSION['id_user'];
			$atualiza = mysqli_query($con,$sql);
            if (!$atualiza) {
					$_SESSION["msg"] = "Houve algum problema com a tabela de dados." . mysqli_error($con);
				}
		} else {
			setcookie("stringid");
		}
		
		// verifica as permissões
		$sql = "SELECT * FROM permissoes WHERE id_user = ".$_SESSION['id_user'];
		$tabela = mysqli_query($con,$sql);
		
		//atribui as permissoes
		if ($linhas = mysqli_num_rows($tabela)) {
			while ($dados = mysqli_fetch_array($tabela)) {
				$permissao[$dados['grupo']] = $dados['permissao'];
			}
			$_SESSION['permissao'] = $permissao;
		}
		
		// passamos para a home do programa		
        header('location: home.php');
        //echo "tudo ok - ";
		//exit;
    }
    // e coninuamos na página
    else  {
        // se não expulsa o usuáio.
        unset($_SESSION['usuario'], $_SESSION['senha']);

        $msg = "Usuários ou Senha incorretos, por favor faça novo login.";
		$default_user = $usuario;
        
    }
}



?>