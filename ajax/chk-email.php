<?php

/* check if email is already registered */

//conexão com o servidor
$conect = mysql_connect("localhost", "root", "lucas#3$1");

// Caso a conexão seja reprovada, exibe na tela uma mensagem de erro
if (!$conect) die ("<h1>Falha na coneco com o Banco de Dados!</h1>");

// Verificação de dados
if (!empty($_POST['email']))
{
    $email = $conect->real_escape_string($_POST['email']);
    $query = "SELECT ID FROM alunos WHERE email = '{$email}' LIMIT 1;";
    $results = $conect->query($query);
    if($results->num_rows == 0)
    {
        echo "<i class="icon-ok"></i>";  //good to register
    }
    else
    {
        echo "Login indisponivel, escolha outro por favor"; //already registered
    }
}
else
{
    echo "é necessário inserir o login"; //invalid post var
}

?>