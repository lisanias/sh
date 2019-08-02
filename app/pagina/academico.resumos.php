<!-- RESUMOS -->

<div class="row">

    <div class="span12">

        <div class="widget big-stats-container stacked  alert alert-info" style="margin-top:15px;">
			<h3>Incriçoes Válidas</h3>
            <div class="widget-content">
				
                <div id="big_stats" class="cf">
                	
                    <?php
					$te = 10;
                    $r = ($te==10? $te="igual": $te="diferente");
                    
                    $total = 0;
					
                    // permissão SECRETARIA - id 2
                    if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo


                    // Quantos alunos válidos temos em cada curso
                    $sql = "SELECT COUNT(*)AS soma, cursos.nome_curso as curso
                        FROM  matricula
                        INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
                        INNER JOIN cursos ON cursos.id_curso = modulo.id_curso
                        WHERE matricula.id_evento = ". $_SESSION['evento'] . "
                        AND matricula.status >= 2
                        GROUP BY matricula.id_modulo";

                    if($result = mysqli_query($con,$sql)){
                        while ($dados = mysqli_fetch_array( $result )){
                            echo "<div class='stat'>";
                            echo    "<h4>".$dados['curso']."</h4>";
                            echo    "<span class='value'>".$dados['soma']."</span>";
                            echo "</div> <!-- .stat -->";
                            $total = $total + $dados['soma'];
                        }

                    } else {
                        $msg = "Houve algum erro (1)";
                    }

                    echo "<div class='stat alert alert-info'><h4>Total</h4><span class='value'>".$total."</span></div>"; 

					}
					?> <!-- /permissao -->

                </div>

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->


        <div class="widget big-stats-container stacked alert alert-success">
			<h3>Alunos que efetivamente compareceram</h3>
            <div class="widget-content ">
				
                <div id="big_stats" class="cf">
                	
                    <?php
					$te = 10;
                    $r = ($te==10? $te="igual": $te="diferente");
                    $total = 0;
					
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

                    if($result = mysqli_query($con,$sql)){
                        while ($dados = mysqli_fetch_array( $result )){
                            echo "<div class='stat'>";
                            echo    "<h4>".$dados['curso']."</h4>";
                            echo    "<span class='value'>".$dados['soma']."</span>";
                            echo "</div> <!-- .stat -->";
                            $total = $total + $dados['soma'];
                        }

                    } else {
                        $msg = "Houve algum erro (1)";
                    }                    

                    echo "<div class='stat alert alert-success'><h4>Total</h4><span class='value'>".$total."</span></div>"; 

					}
					?> <!-- /permissao -->

                </div>

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->

        <!-- ALUNOS QUE COMPARECERAM E ESTÃO HOSPEDADOS -->
        <div class="widget big-stats-container stacked alert">
			<h3>Alunos que compareceram e estão hospedados</h3>
            <div class="widget-content ">
				
                <div id="big_stats" class="cf">
                	
                    <?php
					$te = 10;
                    $r = ($te==10? $te="igual": $te="diferente");
                    $total = 0;
					
                    // permissão SECRETARIA - id 2
                    if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo


                    // Quantos alunos válidos temos em cada curso
                    $sql = "SELECT COUNT(*)AS soma, cursos.nome_curso as curso
                        FROM  matricula
                        INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
                        INNER JOIN cursos ON cursos.id_curso = modulo.id_curso
                        WHERE matricula.id_evento = ". $_SESSION['evento'] . "
                        AND matricula.status >= 5
                        AND matricula.hospedagem = 1
                        GROUP BY matricula.id_modulo";

                    if($result = mysqli_query($con,$sql)){
                        while ($dados = mysqli_fetch_array( $result )){
                            echo "<div class='stat'>";
                            echo    "<h4>".$dados['curso']."</h4>";
                            echo    "<span class='value'>".$dados['soma']."</span>";
                            echo "</div> <!-- .stat -->";
                            $total = $total + $dados['soma'];
                        }

                    } else {
                        $msg = "Houve algum erro (1)";
                    }                    

                    echo "<div class='stat alert'><h4>Total</h4><span class='value'>".$total."</span></div>"; 

					}
					?> <!-- /permissao -->

                </div>

            </div> <!-- /widget-content -->

        </div> <!-- /widget -->

    </div> <!-- /span12 -->

</div> <!-- /row -->
