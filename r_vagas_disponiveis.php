<?php
	//resultado direto
	$sql = "SELECT * FROM  matricula WHERE id_evento = ". $_SESSION['evento_atual'] . " AND status >= 2 AND hospedagem = 1"  ;
	if(!$result = $con->query($sql)){
		die('Ha um erro ao executar a pesquisa na base de dados [' . $con->error . ']');
		}
	$vagas = $_SESSION['evento_iw'] - mysqli_num_rows( $result );
        
    mysqli_close($con);
?>