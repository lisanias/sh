<?php
// Verifica primeiro se ja não está logado
// Verifica se existe os dados da sessão de login
/*if (isset($_SESSION["usuario"]) || isset($_SESSION["senha"]))
{
    // Usuário logado! Redireciona para a página de home
    header("Location: home.php");
    exit;
}*/

// Verifica se um formulário foi enviado
if (isset($_COOKIE['stringid'])) {
	
	if (strlen(trim($_COOKIE['stringid']))>0) {

			// Monta a consulta para buscar os dados que serão comparados
		$sql = "SELECT * FROM user where stringid='".$_COOKIE['stringid']."'";
		$tabela = mysqli_query($con,$sql);
		$dados = mysqli_fetch_array($tabela);
		
		// se o resultado retornar uma linha é porque temos um usuário valido
		if (isset($dados)) {
			// Definimos os dois valores na sessão com os dados do usuário
			$_SESSION['usuario'] = $dados['login'];
			$_SESSION['senha'] = $dados['senha']; 
			$_SESSION['id_user'] = $dados['id_user'];
			$_SESSION['nome'] = $dados['nome'];
			$_SESSION['email'] = $dados['email'];
			$_SESSION['logado'] = sha1($dados['id_user']);
			setcookie("user", $dados['login'], time()+2592000);
			
			// captura as permissões
			$sql = "SELECT * FROM permissoes WHERE id_user = ".$_SESSION['id_user'];
			$tabela = mysqli_query($con,$sql);
			
			if ($linhas = mysqli_num_rows($tabela)) {
				while ($dados = mysqli_fetch_array($tabela)) {
					$permissao[$dados['grupo']] = $dados['permissao'];
				}
				$_SESSION['permissao'] = $permissao;
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
	
			$msg = "Fava o login novamente.";
			setcookie('stringid');
			$default_user = $dados['login'];
			
    	}
	}
}



?>