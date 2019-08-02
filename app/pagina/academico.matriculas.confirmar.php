<?php
/**
 * INCRIÇÕES
 */
// permissão secretaria - id 2 
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar a base de dados e pegar inscrições canceladas
// para mostrar em uma tabela
$sql = "SELECT * 
		FROM matricula 
		INNER JOIN modulo 
			ON matricula.id_modulo = modulo.id_modulo 
		INNER JOIN cursos 
			ON modulo.id_curso = cursos.id_curso 
		INNER JOIN alunos 
			ON matricula.id_aluno = alunos.id_aluno 
		WHERE
		    matricula.id_evento = ".$_SESSION['evento']."
		  AND
		    status = 3
		ORDER BY data_matricula DESC"; 
		
$tabela = mysqli_query($con,$sql);

?>

<div class="widget widget-table action-table">
						
    <div class="widget-header">
        <i class="icon-question-sign"></i>
        <h3>Inscriçoes esperando confirmação do "staff"</h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Curso</th>
                    <th>Nome</th>
                    <th class="td-actions">Status</th>
<?php
if ($linhas = mysqli_num_rows($tabela)) {
	echo "<th class='td-actions'  width='38px'>".$linhas."</th>";
?>
                    
                </tr>
            </thead>
            <tbody>
<?php 

    while ($dados = mysqli_fetch_array($tabela)) {
        echo "<tr><td>".date('d/m/Y', strtotime($dados['data_matricula']))."</td>";
        echo "<td><abbr title='".$dados['nome_curso']."'>".$dados['abreviatura']."</abbr></td>";
        echo "<td><abbr title='".$dados['nome']." ".$dados['sobrenome']."'>".nome2($dados['nome']." ".$dados['sobrenome'])."</td>";
        echo "<td class='td-actions'>" . fsc($dados['status'])."</td>";
		//if ($_SESSION['permissao'][2]==2) {
		echo "<td><a class='btn btn-primary' href='aluno.php?id=".base64_encode($dados['id_aluno'])."' title='Ir para ficha do aluno' ><i class='icon-signin'></i></ a>&nbsp;</td>";
		//}
		echo "</tr>";
	}
}
?>
            </tbody>
        </table>
        
    </div> <!-- /widget-content -->

</div> <!-- /widget -->
<?php } //trmina a vialização do modulo
else { echo mysqli_error($con);  } ?>