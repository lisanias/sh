<?php
/**
 * INCRIÇÕES
 */
// permissão secretaria - id 2 
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// abrir base de dados curso para listar todos os cursos oferecidos e listar os alunos de cada curso
    //$sql = "SELECT * FROM cursos";
    $sql = "SELECT
                    COUNT( * ) AS soma,
                    cursos.nome_curso AS nome_curso_c,
                    cursos.id_curso AS id_curso_c
                FROM matricula
                INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
                INNER JOIN cursos ON cursos.id_curso = modulo.id_curso
                WHERE matricula.id_evento = ". $_SESSION['evento'] . "
                AND matricula.status >=2
                GROUP BY matricula.id_modulo
                ORDER BY soma ASC";
    $tabela = mysqli_query($con,$sql);

    $i=0;
    while ($dados = mysqli_fetch_array($tabela)) {

        if ($i == 0) {
            echo "<div class='row'>";
        }
        echo "<div class='span6'>";

        // conectar na base de dados matriculas e listar alunos desse curso
        $sql_matricula = "SELECT *
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
                    status >= 2
                  AND
                    cursos.id_curso = ". $dados['id_curso_c'] ."
                ORDER BY nome ASC, sobrenome ASC";

        $tabela_matriculas = mysqli_query($con,$sql_matricula);

        if ($linhas = mysqli_num_rows($tabela_matriculas)) {
            echo "
                <div class='widget widget-table action-table'>
                    <div class='widget-header'>
                        <i class='icon-chevron-right'></i>
                        <h3>".$dados['nome_curso_c']."</h3>
                    </div> <!-- /widget-header -->
                    <div class='widget-content'>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th class='td-actions' width='64px'>Status</th>
                                    <th class='td-actions' width='82px'>".$linhas."</th>
                                </tr>
                            </thead>
                            <tbody>
                ";

            // linhas da tabela de alunos do curso

            while ($dados_matricula = mysqli_fetch_array($tabela_matriculas)) {
                echo "<tr>";
                echo    "<td>".$dados_matricula['nome']." ".$dados_matricula['sobrenome']."</td>";
                echo    "<td class='td-actions'>" . fsc($dados_matricula['status'])."</td>";
                echo    "<td>
					<a class='btn btn-primary' href='aluno.php?id=".base64_encode($dados_matricula['id_aluno'])."' title='Ir para ficha do aluno' ><i class='icon-signin'></i></ a>&nbsp;";
				if ($dados_matricula['status']==5) {
					echo "
					<a class='btn btn-success' href='./aluno.acao.php?atp=".base64_encode('matricula_alterar_status')."&aux=7&id=".base64_encode($dados_matricula['id_matricula'])."' title='Modulo Concluido' ><i class='icon-thumbs-up'></i></ a>&nbsp;";
				}
				echo "</td>";
                echo "</tr>";
            }
            echo "
                            </tbody>
                        </table>
                    </div> <!-- /widget-content -->
                </div> <!-- /widget -->
            ";
        }

        echo "</div>";
        if ($i == 1) {
            echo "</div>";
        }

        $i=$i+1;
        if ($i==2) { $i=0; }
    // fim do while dados do cruso...
    }
}

?>
