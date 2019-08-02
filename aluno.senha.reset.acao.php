<?php

include 'i_secao.evento.default.php';

$hash = $_POST['token'];
$email = $_POST['email'];

// verificar se a senha não está em branco
if (strlen($_POST['senha'])==0) {

	$_SESSION['msg']= "A senha não pode estar em branco.";
    $_SESSION['msg_tipo']="alert-warning";

    header("location: aluno.senha.reset.php?token=" . $hash . "&email=" . $email);
    exit;
}

// verificar se a senha tem pelo menos 6 digitos
if (strlen($_POST['senha'])<6) {

	$_SESSION['msg']= "A senha precisa ter mais de 6 caracteres.";
    $_SESSION['msg_tipo']="alert-warning";

    header("location: aluno.senha.reset.php?token=" . $hash . "&email=" . $email);
    exit;
}

// verificar se as senhas são iguais 
$senha = $_POST['senha'];
$conf = $_POST['senha_conf'];

if ($senha<>$conf) {
	
	$_SESSION['msg']= "As senhas digitadas não conferem, digite novamente.";
    $_SESSION['msg_tipo']="alert-warning";

    header("location: aluno.senha.reset.php?token=" . $hash . "&email=" . $email);
    exit;
} 


if ($senha==$conf) {
	
	// preparar a senha, gravar, redirecionar para login

	$senha_cod = sha1(SALT.$senha);

	$sql = "UPDATE alunos
        SET senha = '{$senha_cod}',
        recuperaSenha_hash = ''
        WHERE email = '{$email}'";

    $atualiza = mysqli_query($con,$sql);

    header("location: aluno.login.php");
    exit;

} else {

	$_SESSION['msg']= "Algo não saiu como esperado. Digite novamente ou contate a nossa secretaria.";
    $_SESSION['msg_tipo']="alert-warning";

    header("location: aluno.senha.reset.php?token=" . $hash . "&email=" . $email);
    exit;
}
