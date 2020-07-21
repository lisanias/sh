<?php

include_once('./inc/iniciar.php');
include_once('./inc/seguranca.php');

if (!empty($_POST)){

  $dataIni = implode('-',array_reverse(explode('/',$_POST['dataini'])));

  $sql = "INSERT INTO avisos_modulo
	(
     modulo_id,
     data_ini,
     titulo,
     conteudo,
     link,
     link_titulo,
     tipo
    )
    VALUES
    (
      '{$_POST['curso']}',
      '{$dataIni}',
      '{$_POST['title']}',
      '{$_POST['message']}',
      '{$_POST['link']}',
      '{$_POST['buttonTitle']}',
      '{$_POST['cor']}'
    )";

    $inserir = mysqli_query($con, $sql);

    if( $inserir ){
      $_SESSION['msg'] = "Aviso inserido";
      die(header("Location: avisos.php"));
    } else {
      $_SESSION['msg'] = "ATENÇÃO - Por algum motivo não foi possivel inserir na base de dados";
      die(header("Location: avisos.php"));
    }
    die("fim");

  //echo 'foi enviado!<pre>';
  //var_dump($_POST);
  //die();
}
