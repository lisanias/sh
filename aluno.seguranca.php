<?php

include 'i_secao.evento.default.php';

// Verifica se existe os dados da sessão de login
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["senha"]))
{
    // Usuário não logado! Redireciona para a página de login
    $_SESSION['msg'] = "Você precisa estar logado para acessar esta página";
    header("Location: aluno.login.php");
    exit;
}


// Usa a função addslashes para escapar as aspas
$usuario = $_SESSION["usuario"];
$senha = $_SESSION["senha"]; //senha ja codificada quando se definiu a variavel session

// Monta uma consulta SQL para verficicar se a senha não foi mudada
$sql = "SELECT * FROM alunos where login='".$usuario."' and senha='".$senha."'";

$tabela = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($tabela);

if (!isset($dados)) {
     $_SESSION["msg"] = "Houve algum problema com a segurança ou você alterou a sua senha e precisa fazer um novo login.";
     header("Location: aluno.login.php");
     exit;
 }
// continua logado
?>
