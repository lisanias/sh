<?php

function validar($post)
{
    // Variável para coleta dos dados de erro
    $erro = false;

    // Verificar se tem foi recebida uma postagem e se ela está vazia
    if ( !isset( $post ) || empty( $post ) ) {
        $erro = 'POST está vazio.';
    }

    // Variáveis dinâmicas do formulário
    foreach ( $post as $chave => $valor ) {
        // Limpa todas as tags HTML
        // Limpa os espaços em branco do valor
        $$chave = trim( strip_tags( $valor ) );
        
        // Verifica se existe algum dado nulo
        if ( empty ( $valor ) ) {
        $erro = 'Existem campos em branco.';
        }
    }

    if($erro){
        $_SESSION['msg'] = $erro;
        header("Location: ../aluno.home.php");
    }

    return true;
}

function validarCvv($cvv)
{
    if(strlen(trim($cvv))!=3)
    {
        $_SESSION['msg'] = "O campo CVV não foi preenchido corretamente!";
        header("Location: public/checkout.php");
        die();
    }
    return true;
}

function token()
{
    // captura a variavem token armazenada
    $token = empty($_SESSION['token']) ? NULL : $_SESSION['token'];
    
    //limpa a session token
    unset($_SESSION['token']);

    // verfica o token
    if($_POST['token']===$token){

        return $token;
        
    } else {

        // mensagem de erro
        $_SESSION['msg'] = "Dados insconsistentes. Tente novamente por favor. #10010";

        // Redireciona para home do aluno
        header("Location: ../aluno.home.php");
    }
    return false;
}

