<?php
/**
 * RESUMOS
 */

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
        $hoje = '';
		$_SESSION['msg'] = "Houve algum erro";
    }
/*echo "<pre>";
var_dump($dados);
echo "</pre>";*/

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
            AND status >= 3";  // and hospedagem = 1
    if($result = $con->query($sql)){
        $dados = mysqli_fetch_array( $result );
        $comprovantes = $dados["soma"];
    } else {
        $comprovantes = '';
        $msg = "Houve algum erro (4)";
    }

    // Alunos que ja chegaram ao evento - que compareceram
    $sql = "SELECT COUNT(*)AS soma
            FROM  matricula
            WHERE id_evento = ". $_SESSION['evento'] . "
            AND status = 5" ;
    if($result = $con->query($sql)){
        $dados = mysqli_fetch_array( $result );
        $compareceu = $dados["soma"];
    } else {
        $compareceu = '';
        $msg = "Houve algum erro (5)";
    }

    $compareceu_porcentagem = 0;

    if ($compareceu == 0 or $compareceu == '' or $comprovantes == 0) {
        $compareceu_porcentagem = 0;
    } else {
        $compareceu_porcentagem = $compareceu * 100 / $comprovantes;
    }


    // contar pendencias de alunos
    $sql = "SELECT COUNT(*)AS soma
            FROM  pendencia
            WHERE resolvido = 0";

    if($result = $con->query($sql)){
        $dados = mysqli_fetch_array( $result );
        $pendencias = $dados["soma"];
    } else {
        $pendencias = '';
        $msg = "Houve algum erro (6)";
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

<!-- Compareceram -->

<div class="row">

    <div class="span10">
        <div class="alert alert-success">
            <h4>Alunos que já compareceram</h4>           
            <div class="progress progress-striped active progress-success">
                <div class="bar" style="width:<?= $compareceu_porcentagem ?>%;"></div>                      
            </div>
            <p style="text-align: right;"><span style="font-size: 26px; "><?= $compareceu ?> / <?= $comprovantes ?></span> (<?= number_format($compareceu_porcentagem, 0, ',','.') ?>%)</p>
        </div>                
    </div> <!-- /span10 -->

    <div class="span2">
        <div class="alert alert-danger" style="text-align: center;">
            <h3>Pendências</h3><br>
            <p>
            &nbsp;<a class='badge badge-important' style="font-size: 26px;" title='Ver pendências' href='pendencia_listar_all.php'> <?= $pendencias ?> </a>&nbsp;

            </p>
        </div>                
    </div> <!-- /span2 -->
     

</div> <!-- /row -->

<?php } // permissao FINANCEIRO ?>