<?php
/**
 * INCRIÇÕES
 */
// permissão secretaria - id 2 
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar a base de dados e pegar ultimas incrições feitas 
// para mostrar em uma tabela
$sql_datafim = date('Y-m-d', $modulodatafim);
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
		    status >= 5
		ORDER BY matricula.status DESC, modulo.id_curso DESC"; 
		
$tabela = mysqli_query($con,$sql);
?>

<div class="widget widget-table action-table">
						
    <div class="widget-header">
        <i class="icon-ok-sign"></i>
        <h3>Candidatos a Formandos</h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Curso</th>
                    <th>Nome</th>
                    <th class="td-actions">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
<?php 
    $x1 = 0;
    while ($dados = mysqli_fetch_array($tabela)) {

        $sql_consulta = "
            SELECT COUNT( DISTINCT modulo.sequencia ) AS contar
            FROM matricula
            INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
            WHERE matricula.status >=5 and matricula.id_aluno = ".$dados['id_aluno']."
                AND data_matricula <= '{$sql_datafim}'
                AND modulo.id_curso = ".$dados['id_curso']."
        ";
        $tabela_cunsulta = mysqli_query($con,$sql_consulta);
        $dados_cunsulta = mysqli_fetch_array($tabela_cunsulta);

        if ($dados_cunsulta['contar'] >= 4) { 
            $x1=$x1+1;
            echo "<tr><td>". $x1 ."</td>";
            echo "<td><abbr title='".$dados['nome_curso']."'>".$dados['abreviatura']."</abbr></td>";
            echo "<td><abbr title='".$dados['nome']." ".$dados['sobrenome']."'>".nome2($dados['nome']." ".$dados['sobrenome'])."</td>";
            echo "<td class='td-actions'>" . fsc($dados['status'])." </td>";
    		//if ($_SESSION['permissao'][2]==2) {
    		echo "<td><a class='btn btn-primary' href='aluno.php?id=".base64_encode($dados['id_aluno'])."' title='Ir para ficha do aluno' ><i class='icon-signin'></i></ a>&nbsp;</td>";
    		//}
    		echo "</tr>";
        
	   }
    }
}
?>
            <tr><td colspan="5">
                Total = <?php echo $x1; ?>
            </td></tr>
            </tbody>
        </table>
        
        
    </div> <!-- /widget-content -->

</div> <!-- /widget -->
