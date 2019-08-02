<?php 
// definir variáveis da página
$pg_titulo = "Relatório - Hosana SiS";
$pg_nome = "relatorio.resumo.modulo.php";
$pg_menu = "home";

// codigo a ser executado depois de iniciar a pagina e antes de terminar os includes
// esta função é chamada atomaticamente pelo include_once ('./inc/grupo.topo.php')
function executar () {
}

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');
?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->
<div class="main">

    <div class="main-inner">

        <div class="container">

<div class="row">

    <div class="span12">

          <br>
          <h2>Por curso</h2>
               	
                    <?php
					$te = 10;
					$r = ($te==10? $te="igual": $te="diferente");
					
                    // permissão SECRETARIA - id 2
                    if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo


                    // Quantos alunos válidos temos em cada curso
                    $sql = "SELECT COUNT(*)AS soma, cursos.nome_curso as curso
                        FROM  matricula
                        INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
                        INNER JOIN cursos ON cursos.id_curso = modulo.id_curso
                        WHERE matricula.id_evento = ". $_SESSION['evento'] . "
                        AND matricula.status >= 5
                        GROUP BY matricula.id_modulo";

                    $total = 0;
					if($result = mysqli_query($con,$sql)){
                        while ($dados = mysqli_fetch_array( $result )){
                            echo "<div class='stat'>";
                            echo    $dados['curso'].": ";
                            echo    "<span class='value'>".$dados['soma']."</span>";
                            echo "</div> <!-- .stat -->";
							$total = $total+$dados['soma'];
							
							
                        }

                    } else {
                        $msg = "Houve algum erro (1)";
                    }
					echo 'TOTAL: '.$total;

					}
					?> <!-- /permissao -->


    </div> <!-- /span12 -->

</div> <!-- /row -->

<!-- Pesquisa de quantos homens e mulheres tem -->
<div class="row">

    <div class="span12">

          <br>
          <h2>Por Sexo</h2>      	
                    <?php
					$te = 10;
					$r = ($te==10? $te="igual": $te="diferente");
					
                    // permissão SECRETARIA - id 2
                    if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo


                    // table de pesquisa sql
                    $sql = "SELECT COUNT(*)AS soma, alunos.sexo AS sexo
                        FROM  matricula
                        INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
                        WHERE matricula.id_evento = ". $_SESSION['evento'] . "
                        AND matricula.status >= 5
                        GROUP BY alunos.sexo";

                    if($result = mysqli_query($con,$sql)){
                        while ($dados = mysqli_fetch_array( $result )){
                            echo "<div class='stat'>";
                            echo    ($dados['sexo']=='M'?"Homens: ":"Mulheres: ");
                            echo    "<span class='value'>".$dados['soma']."</span>";
                            echo "</div> <!-- .stat -->";
                        }

                    } else {
                        $msg = "Houve algum erro (1)";
                    }

					}
					?> <!-- /permissao -->


    </div> <!-- /span12 -->

</div> <!-- /row -->

<!-- Pesquisa por cidades -->
<div class="row">

    <div class="span12">

          <br>
          <h2>Por Cidades</h2>      	
                    <?php
					
                    // permissão SECRETARIA - id 2
                    if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo


                    // table de pesquisa sql
                    $sql = "SELECT COUNT(*)AS soma, alunos.cidade AS cidade
                        FROM  matricula
                        INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
                        WHERE matricula.id_evento = ". $_SESSION['evento'] . "
                        AND matricula.status >= 5
                        GROUP BY alunos.cidade";

                    if($result = mysqli_query($con,$sql)){
                        while ($dados = mysqli_fetch_array( $result )){
                            echo "<div class='stat'>";
                            echo    $dados['cidade'];
                            echo    ": <span class='value'>".$dados['soma']."</span>";
                            echo "</div> <!-- .stat -->";
                        }

                    } else {
                        $msg = "Houve algum erro (1)";
                    }

					}
					?> <!-- /permissao -->


    </div> <!-- /span12 -->

</div> <!-- /row -->

<!-- Pesquisa por igrejas -->
<div class="row">

    <div class="span12">

          <br>
          <h2>Por Igrejas</h2>      	
                    <?php
					
                    // permissão SECRETARIA - id 2
                    if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo


                    // table de pesquisa sql
                    $sql = "SELECT COUNT(*)AS soma, alunos.igreja AS igreja
                        FROM  matricula
                        INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
                        WHERE matricula.id_evento = ". $_SESSION['evento'] . "
                        AND matricula.status >= 5
                        GROUP BY alunos.igreja";

                    if($result = mysqli_query($con,$sql)){
                        while ($dados = mysqli_fetch_array( $result )){
                            echo "<div class='stat'>";
                            echo    $dados['igreja'];
                            echo    ": <span class='value'>".$dados['soma']."</span>";
                            echo "</div> <!-- .stat -->";
                        }

                    } else {
                        $msg = "Houve algum erro (1)";
                    }

					}
					?> <!-- /permissao -->


    </div> <!-- /span12 -->

</div> <!-- /row -->

<!-- Pesquisa por UF -->
<div class="row">

    <div class="span12">

          <br>
          <h2>Por Estado</h2>      	
                    <?php
					
                    // permissão SECRETARIA - id 2
                    if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo


                    // table de pesquisa sql
                    $sql = "SELECT COUNT(*)AS soma, alunos.uf AS uf
                        FROM  matricula
                        INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
                        WHERE matricula.id_evento = ". $_SESSION['evento'] . "
                        AND matricula.status >= 5
                        GROUP BY alunos.uf";

                    if($result = mysqli_query($con,$sql)){
                        while ($dados = mysqli_fetch_array( $result )){
                            echo "<div class='stat'>";
                            echo    $dados['uf'];
                            echo    ": <span class='value'>".$dados['soma']."</span>";
                            echo "</div> <!-- .stat -->";
                        }

                    } else {
                        $msg = "Houve algum erro (1)";
                    }

					}
					?> <!-- /permissao -->


    </div> <!-- /span12 -->

</div> <!-- /row -->

	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>
