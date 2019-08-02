<?php
include 'i_secao.evento.default.php';

// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Pegar valores digitados (login e senha)
    // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
    $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
    // Codifica senha para depois comparar o com banco de dados
    $senha = sha1(SALT.$senha);
	
	//echo $senha;
    
    // Monta a consulta para buscar os dados que serão comparados
    $sql = "SELECT * FROM alunos where login='".$usuario."' and senha='".$senha."'";
    
    $tabela = mysqli_query($con,$sql);
    $dados = mysqli_fetch_array($tabela);
    
    // se o resultado retornar uma linha é porque temos um usuário valido
    if (isset($dados)) {
        // Definimos os dois valores na sessão com os dados do usuário
        $_SESSION['usuario'] = $dados['login'];
		$_SESSION['id_aluno'] = $dados['id_aluno'];
        $_SESSION['senha'] = $dados['senha']; 
        $_SESSION['nome'] = $dados['nome'];
        $_SESSION['sobrenome'] = $dados['sobrenome'];
        $_SESSION['email'] = $dados['email'];
        $_SESSION['ultimo_acesso'] = $dados['data_ultimoacesso'];
        
		// Atualiza a data na do ultimo acesso na base de dados antes de seguir.
		$sqlUp = "UPDATE alunos SET data_ultimoacesso=now() WHERE id_aluno = ".$_SESSION['id_aluno'];
		if(!$result = $con->query($sqlUp)){
			$_SESSION['msg'] = "Houve um erro interno. Erro:[' . $con->error . ']";
			die(header("Location: aluno.login.php"));
			}
		
        header('location: aluno.home.php?');
        exit;
    }
    // e coninuamos na página
    else {
        // se não expulsa o usuáio.
        unset($_SESSION['usuario'], $_SESSION['senha']);

        $_SESSION['msg']="Usuários ou Senha incorretos, por favor faça novo login.";
        header("Location: aluno.login.php");
        exit;
    }
}
else {
    $_SESSION['msg']="Insira o login e senha para acessar o sitema Hosana.SiS";
    header("Location: aluno.login.php");
    exit;
}
$_SESSION['msg']="Não foi possivel acessar a pagina privada dos alunos, por favor tente de novo.";
header("Location: aluno.login.php");