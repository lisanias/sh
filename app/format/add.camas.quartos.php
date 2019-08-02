<!doctype html>
<?php
/* Adicionar as camas conforme a configuração dos quartos
 *
 */

//conectar a base de dados
$con = mysqli_connect('localhost', 'root', 'lucas#3$1', 'hosana');

// sql para buscar dados de todos os quartos
$sql = "SELECT * FROM  quarto";

$tabela = mysqli_query($con,$sql);

while ($dados = mysqli_fetch_array($tabela)) {
	$capacidade = $dados['capacidade'];
	$i=0;
	$metade = $dados['capacidade']/2;
	
	while ($i < $capacidade) {
		$cama = ($i < $metade)? "Cama de Cima": "Cama de Baixo";
		$sql_add_cama = "INSERT INTO cama (
				id_quarto,
				cama,
				tipo)
				VALUES (
				".$dados['id_quarto'].",
				'".$cama."',
				'Belixe')";
		$i = $i+1;
		//echo $cama ." - i: ".$i." metade:".$metade . "<br>";
		$inserir = mysqli_query($con, $sql_add_cama);
	}
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Format</title>
</head>

<body>
Concluido
</body>
</html>