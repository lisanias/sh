<?php

// pesquisa sql
$sql = "SELECT * FROM matricula INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo INNER JOIN cursos ON modulo.id_curso = cursos.id_curso WHERE id_aluno = " . $idaluno . " and matricula.id_evento = " . $_SESSION['evento'];

$consulta = mysqli_query($con,$sql);

while ($dados = mysqli_fetch_array($consulta)) {
	echo "Curso: " . $dados['nome_curso'];
	echo "<br>Módulo: " . $dados['modulo'];
	echo "<br>Data de Matrícula: " . date('d/m/Y', strtotime($dados['data_matricula']));
	echo "<br>Valor do Módulo: " . $dados['valor'];
	
	$id_matricula = $dados['id_matricula'];
	$sqlsoma = " SELECT SUM(valor) AS total FROM pagamento WHERE id_matricula = ". $id_matricula;
		
	$consultasoma = mysqli_query($con,$sqlsoma);
	$dadossoma = mysqli_fetch_array($consultasoma);
	
	echo "<br>Valor pago: " . $dadossoma['total'];
	
	echo "<br>Status: " . function_pg_status_icon($dados['status']);
}
?>