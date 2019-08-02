<?php
// Verifica se existe os dados da sessão de login
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["senha"]))
{
    // Usuário não logado! Redireciona para a página de login
    $_SESSION['msg'] = "Você precisa estar logado para acessar esta página";
    header("Location: login.php?origem=seguranca");
    exit;
}


$usuario = $_SESSION["usuario"];
$senha = $_SESSION["senha"]; //senha ja codificada quando se definiu a variavel session

// Monta uma consulta SQL para verficicar se a senha não foi mudada
$sql = "SELECT * FROM user where login='".$usuario."' and senha='".$senha."'";

$tabela = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($tabela);

if (!isset($dados)) {
     // desativar a secao e a o autologin
	 setcookie("stringid");
	 $_SESSION["msg"] = "Houve algum problema com a segurança ou você alterou a sua senha e precisa fazer um novo login.";
     header("Location: login.php?origem=seguranca2");
     exit;
 }


// continua logado
?>