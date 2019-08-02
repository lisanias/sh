<?php
/**
 * RESUMOS
 */
echo $_SESSION['evento'];
// permissão SECRETARIA - id 2
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar e pesquisar quantidades de inscritos hoje
    $sql = "SELECT COUNT(*) AS soma
            FROM  matricula
            WHERE id_evento = ". $_SESSION['evento'] . "
			AND  date(`data_matricula`) =  CURRENT_DATE";
    if($result = $con->query($sql)){
        $dados = mysqli_fetch_array( $result );
        $hoje = $dados["soma"];
    } else {
        $hoje = '1';
		$msg = "Houve algum erro (1)";
    }

// Alunos válidos matriculados
    $sql = "SELECT COUNT(*)AS soma
            FROM  matricula
            WHERE id_evento = ". $_SESSION['evento'] . "
            AND status >= 2"  ;
    if($result = mysqli_query($con,$sql)){
        $dados = mysqli_fetch_array( $result );
        $v_preenchidas = $dados["soma"];
        $vagas = $_SESSION['vagas_web'] - $v_preenchidas;
    } else {
        $vagas = ' ';
        $v_preenchidas = "";
		$msg = "Houve algum erro (2)";
    }

// Alunos que vão ficar hospedados
    $sql = "SELECT COUNT(*) AS soma
            FROM  matricula
            WHERE id_evento = ". $_SESSION['evento'] . "
            AND status >= 2 and hospedagem = 1";
    if($result = $con->query($sql)){
        $dados = mysqli_fetch_array( $result );
        $hospedados = $dados["soma"];
    } else {
        $hospedados = '';
        $msg = "Houve algum erro (3)";
    }

 // Alunos que enviaram comprovantes ou estão confirmados
    $sql = "SELECT COUNT(*) AS soma
            FROM  matricula
            WHERE id_evento = ". $_SESSION['evento'] . "
            AND status >= 3 and hospedagem = 1";
    if($result = $con->query($sql)){
        $dados = mysqli_fetch_array( $result );
        $comprovantes = $dados["soma"];
    } else {
        $comprovantes = '';
        $msg = "Houve algum erro (4)";
    }
?>
<div class="row">

    <div class="span12">

        <div class="widget big-stats-container stacked">

            <div class="widget-content">

                <div id="big_stats" class="cf">
                    <div class="stat">
                        <h4>Incrições Hoje</h4>
                        <span class="value"><?= $hoje ?></span>
                    </div> <!-- .stat -->

                    <div class="stat">
                        <h4>Alunos inscritos</h4>
                        <span class="value"><?= $v_preenchidas ?></span>
                    </div> <!-- .stat -->

                    <div class="stat">
                        <h4>Alunos Hospedados</h4>
                        <span class="value"><?= $hospedados ?></span>
                    </div> <!-- .stat -->

                    <div class="stat">
                        <h4>Comprovantes/Conferidas</h4>
                        <span class="value"><?= $comprovantes ?></span>
                    </div> <!-- .stat -->


                </div>

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->

    </div> <!-- /span12 -->

</div> <!-- /row -->

<?php } // permissao FINANCEIRO ?>