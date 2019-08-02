<?php 



$sql = "SELECT * FROM modulo WHERE id_evento = {$_SESSION['evento']}";

$tabela = mysqli_query($con,$sql);

?>

	<br>
	
    	<div class="hero-unit">

<?php 
	echo '<h2>', $_SESSION['evento_nome'], ' <span class="badge badge-info">', $_SESSION['evento'], '</span></h2>';

	echo "<table class='table table-condensed'><tbody>";
	while ($dados = mysqli_fetch_array($tabela)) {
		echo "<tr>";
		echo "<td>".curso_ini($dados['id_curso'])."</td>";
		echo "<td>".$dados['modulo']."</td>";
		echo "<td>".$dados['valor']."</td>";
		echo "</tr>";
	}
	echo "</tbody></table>";
?>
		</div>
    