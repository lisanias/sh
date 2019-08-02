<!-- Modulos matriculados e concluidos se existir -->
<div class="widget widget-box">

    <?php
    // verificar se o aluno tem alguma inscrição feita para o modulo ativo
    // pesquisa sql
    $sql = "SELECT *
                        FROM matricula
                        INNER JOIN modulo
                            ON matricula.id_modulo = modulo.id_modulo
                        INNER JOIN cursos
                            ON modulo.id_curso = cursos.id_curso
                        INNER JOIN evento
                            ON evento.id_evento = modulo.id_evento
                        WHERE id_aluno = " . $idaluno . " AND status >= 6";

    $consulta = mysqli_query($con,$sql);
    $linhas = mysqli_num_rows($consulta);

    if ($linhas>0) {
    ?>

    <div style="text-align:center; width:100%">Módulos Concluídos</div>

    <div class="contorno-fundo dpesoalcss">
        <table class="table">

        <?php
        while ($dados = mysqli_fetch_array($consulta)) {

            echo "<tr><td>";
            echo $dados['nome_curso'];
            echo "</td><td>";
            echo $dados['descricao'];
            echo "</td><td>";
            echo $dados['modulo'];
			echo "</td><td>";
				// codificar id da matricula
				$codid_matricula = base64_encode($dados['id_matricula']);
				$codid_aluno = base64_encode($idaluno);
				// botão para editar inscrição
				echo "<a class='btn btn-primary icon-edit pull-right' title='Alterar Inscrição' href='inscricao.edit.php?id={$codid_matricula}' ></a>";
				echo "<a class='btn btn-primary icon-share pull-right' title='Ver Inscrição' href='aluno.php?id={$codid_aluno}&session={$dados['id_evento']}' ></a><br>";
            echo "</td></tr>";
        }
        ?>

        </table>
    </div> <!-- /widget-content -->

        <?php
        }
        ?>

</div> <!-- /widget-box -->

<!-- Modulos matriculados não concluidos se existir -->
<div class="widget widget-box">

    <?php
    // verificar se o aluno tem alguma inscrição feita para o modulo ativo
    // pesquisa sql
    $sql = "SELECT *
                        FROM matricula
                        INNER JOIN modulo
                            ON matricula.id_modulo = modulo.id_modulo
                        INNER JOIN cursos
                            ON modulo.id_curso = cursos.id_curso
                        INNER JOIN evento
                            ON evento.id_evento = modulo.id_evento
                        WHERE id_aluno = " . $idaluno . " AND status < 6";

    $consulta = mysqli_query($con,$sql);
    $linhas = mysqli_num_rows($consulta);

    if ($linhas>0) {
    ?>

    <div style="text-align:center; width:100%">Módulos não Concluídos</div>

    <div class="contorno-fundo dpesoalcss">
        <table class="table">

            <?php
            while ($dados = mysqli_fetch_array($consulta)) {

                echo "<tr><td>";
                echo $dados['nome_curso'];
                echo "</td><td>";
                echo $dados['descricao'];
                echo "</td><td>";
                echo $dados['modulo'];
                echo "</td><td>";
                echo fsd($dados['status']);
				echo "</td><td>";
				// codificar id da matricula
				$codid_matricula = base64_encode($dados['id_matricula']);
				$codid_aluno = base64_encode($idaluno);
				// botão para editar inscrição
				echo "<a class='btn btn-primary icon-edit pull-right' title='Alterar Inscrição' href='inscricao.edit.php?id={$codid_matricula}' ></a>";
				echo "<a class='btn btn-primary icon-share pull-right' title='Ver Inscrição' href='aluno.php?id={$codid_aluno}&session={$dados['id_evento']}' ></a><br>";
                echo "</td></tr>";
            }

            ?>

        </table>
    </div> <!-- /widget-content -->

    <?php
    }
    ?>

</div> <!-- /widget-box -->