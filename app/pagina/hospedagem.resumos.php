<?php
/**
 * RESUMOS
 */

// permissão SECRETARIA - id 2
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar e pesquisar quantidades de inscritos hoje
    $sql = "SELECT COUNT( * ) AS soma
                FROM matricula
                INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
                WHERE alunos.sexo = 'M'
                AND matricula.id_evento =".$_SESSION['evento']."
                AND matricula.status >=2
                AND matricula.hospedagem =1";
    if($result = $con->query($sql)){
        $dados = mysqli_fetch_array( $result );
        $masculino = $dados["soma"];
    } else {
        $masculino = '0';
    }

// vagas disponíveis
    $sql = "SELECT COUNT( * ) AS soma
                FROM matricula
                INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
                WHERE alunos.sexo = 'F'
                AND matricula.id_evento =".$_SESSION['evento']."
                AND matricula.status >=2
                AND matricula.hospedagem =1";
    if($result = mysqli_query($con,$sql)){
        $dados = mysqli_fetch_array( $result );
        $feminino = $dados["soma"];
    } else {
        $feminino = 0;
    }

// conectar alojados
    $sql = "SELECT COUNT(*) AS soma
            FROM  matricula
            WHERE id_evento = ". $_SESSION['evento'] . "
            AND id_cama > 0";
    if($result = $con->query($sql)){
        $dados = mysqli_fetch_array( $result );
        $alojados = $dados["soma"];
    } else {
        $alojados = 0;
    }
?>
<div class="row">

    <div class="span12">

        <div class="widget big-stats-container stacked">

            <div class="widget-content">

                <div id="big_stats" class="cf">
                    <div class="stat">
                        <h4>Masculinos</h4>
                        <span class="value"><?= $masculino ?></span>
                    </div> <!-- .stat -->

                    <div class="stat">
                        <h4>Femininos</h4>
                        <span class="value"><?= $feminino ?></span>
                    </div> <!-- .stat -->

                    <div class="stat">
                        <h4>Alojados</h4>
                        <span class="value"><?= $alojados ?></span>
                    </div> <!-- .stat -->


                </div>

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->

    </div> <!-- /span12 -->

</div> <!-- /row -->

<?php } // permissao FINANCEIRO ?>