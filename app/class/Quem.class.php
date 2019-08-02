<?php

/*
 *
 *  Registrar quem fez o que e quando

 id_quem
 user
 tabela
 id_alterado
 acao
 data

  *
  */

 class Quem {

	 public static function insert($con, $tabela, $id_alterado, $acao) {

	 	$sqlQuem = "INSERT INTO quem (user, tabela, id_alterado, acao, data) 
	 			VALUES ({$_SESSION['id_user']}, '{$tabela}', '{$id_alterado}', '{$acao}', now())";

	 	$_SESSION['teste'] = "clas quem insert - {$sqlQuem}";

	 	$query = mysqli_query($con, $sqlQuem);

	 	/*if(!$query) {

	 		        $_SESSION['teste'] .= '<br> erro na query'.mysqli_error($con);
	 		        $_SESSION["msg"]= $TEXT['Inserido em quem'];
        			$_SESSION['msg_tipo']="alert-success";
	 	} else {
	 		 $_SESSION['teste'] .= '<br> query ok - deve estar inserido';
	 	}*/


	 }
 
 }