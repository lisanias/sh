<?php
  //faço a conexão com o banco
  //$con = mysqli_connect('localhost', 'root', 'lucas#3$1', 'hosana');
  $con = mysqli_connect('localhost', 'sagra213_hosana', 'lucas#3$1', 'sagra213_hosana');
  
  // verificar a conexão
  if (mysqli_connect_error($con))
    {
    die("Falha ao conectar com o banco de dados, erro: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")<br>");
    }

    mysqli_set_charset( $con, 'utf8');
?>