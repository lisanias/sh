<?php 

// Conectar a base de dados pendencia...
$id_aluno = base64_decode($_GET['id']);
$sql = "SELECT * 
		FROM pendencia 
		WHERE id_aluno = {$id_aluno} and resolvido = 0";


$consulta = mysqli_query($con,$sql);
$linhas = mysqli_num_rows($consulta);

if ( $linhas ) {
?>

<div class="widget">
	<div class="widget-header">
		<h3>Pendencias</h3>
	</div>
	<div class="widget-content">				
		
		<?php
			while ( $dados = mysqli_fetch_array($consulta) ) {
				echo "<blockquote>";
				echo "<pre>", $dados['pendencia_txt'], "</pre>";
				echo "<small>Adicionada em: ", date_format(date_create($dados['data_add']), 'd/m/Y H:i'), "Alterada em: ", date_format(date_create($dados['data_update']), 'd/m/Y H:i'), ' | Matricula:', $dados['id_matricula'] , ' - Aluno:', $dados['id_aluno'] ,"</small>";
				echo "<div style='margin-top:10px;'>";
				echo "&nbsp;<a class='btn btn-primary icon-ok' title='Pendencia resolvida' href='aluno.acao.php?atp=", base64_encode('pendencia_resolver'), "&id=", base64_encode($dados['id']),"&id_aluno=", base64_encode($dados['id_aluno']),"'> Fianlizar pendência </a>";
				echo "&nbsp;<a class='btn btn-success icon-ok' title='Ver pendência' href='pendencia.edit.php?id=", base64_encode($dados['id']),"'> Ver </a>";
				echo "</div>";
				echo "</blockquote>";
			}
		?>
		
	</div>
</div>
		
	

<?php
}
?>