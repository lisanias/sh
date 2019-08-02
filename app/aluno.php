<?php 
// definir variáveis da página
$pg_titulo = "Aluno - Hosana SiS";
$pg_nome = "aluno.php";
$pg_menu = "aluno";


// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

if (isset($_GET['session'])) {
	$default_session_id = $_GET['session'];
} else {
	$default_session_id = $_SESSION['evento'];
}

?>
    
<br />
<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	    	<div class="row">
				<div class="span12">	
	      			<?php include("./pagina/pendencia_lista.php"); ?>
	      		</div>
			</div>

	       <div class="row">
	      	
	      	<div class="span8">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Dados do Aluno</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li class="active"><a href="#profile" data-toggle="tab"><?=$TEXT['ficha']?></a></li>
						  <li><a href="#editar" data-toggle="tab"><?=$TEXT['editar']?></a></li>
                          <li><a href="#cadastro" data-toggle="tab"><?=$TEXT['profile']?></a></li>
                            <li><a href="#historico" data-toggle="tab"><?=$TEXT['historico']?></a></li>
						</ul>
						
						<br />
						
							<div class="tab-content">

                                <div class="tab-pane active" id="profile">
                                    <?php include("./pagina/aluno.ficha.php"); ?>
								</div>
								
								<div class="tab-pane" id="editar">
                                    <?php include("./pagina/aluno.editar.php"); ?>
								</div>

                                <div class="tab-pane" id="cadastro">
                                    <?php include("./pagina/aluno.login.php"); ?>
                                </div>

                                <div class="tab-pane" id="historico">
                                    <?php include("./pagina/aluno.historico.php"); ?>
                                </div>
								
							</div>
						  
						  
						</div>
						
						
						
						
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->
	      		
		    </div> <!-- /span8 -->
	      	
	      	
	      	<div class="span4">

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
						ON matricula.id_evento = evento.id_evento
                    WHERE id_aluno = " . $idaluno . " and matricula.id_evento = " . $default_session_id;

                $consulta = mysqli_query($con,$sql);
                $linhas = mysqli_num_rows($consulta);

                if ($linhas>0) {

                ?>
				
				<div class="widget widget-box">
					
					<div class="widget-header">
	      				<h3>Matricula</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

						<?php include("./pagina/aluno.inscricao.php"); ?>

					</div> <!-- /widget-content -->
					
				</div> <!-- /widget-box -->
                
                <div class="widget widget-box">
					
					<div class="widget-header">
	      				<h3>Pagamentos: </h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
							
						<?php include("./pagina/aluno.pagamento.lista.individual.php"); ?>
						
					</div> <!-- /widget-content -->
					
				</div> <!-- /widget-box -->


				<div class="widget widget-box">
					
					<div class="widget-content">

						<?php
							$sql = "SELECT * 
								FROM audio_pendrive 
								WHERE id_evento = {$_SESSION['evento']}
									AND id_aluno = {$idaluno}"; 
							
							$tabela = mysqli_query($con,$sql);

							if ($linhas = mysqli_num_rows($tabela)) {
								
								echo 'Pendrive encomendado ';

								$dados = mysqli_fetch_array($tabela);

								if (is_null($dados['pago'])) {
									$checked_str = '';
								} else {
									$checked_str = ($dados['pago']==1)?'checked':'';
								}
						        echo "| <input type='checkbox' " . $checked_str . " disabled ></input> Pago ";
						        
								if (is_null($dados['entregue'])) {
									$checked_str = '';
								} else {
									$checked_str = ($dados['entregue']==1)?'checked':'';
								}
						        echo " | <input type='checkbox' " . $checked_str . " disabled ></input> Entregue | ";
						        if ($checked_str == "checked") {
						        	echo date('d/m/Y H:i', strtotime($dados['data_entregue']));
						        }
						        echo "<a class='btn btn-primary icon-signin pull-right' href='audio.pen.pedido.php?id=" . base64_encode($dados['id_aluno']) . "' title='Ir para pedido' ></a>";
							} else {
						
							echo "<a class='btn btn-primary icon-music pull-right' title='Encomendar Pendrive' href='audio.pen.add.php?id=".base64_encode($idaluno)."&atp=".base64_encode('novo')."' > Pendrive</a>";

							}
						?> 

					</div> <!-- /widget-content -->
					
				</div> <!-- /widget-box -->

                <?php				
				}
				else {
				?>
				
				<div class="widget widget-box">
					
					<div class="widget-header">
	      				<h3><?= $TEXT['inscricao_add_titulo_divmain'] ?></h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<?php echo "<a class='btn btn-block btn-mini icon-share pull-right' title={$TEXT['add_incricao']} href='inscricao.add.php?id=".base64_encode($idaluno)."&var={$idaluno}' >{$TEXT['add_incricao']}</a><br>"; ?>
						
					</div> <!-- /widget-content -->
					
				</div> <!-- /widget-box -->
				
				<?php } ?>
				
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
                        WHERE id_aluno = " . $idaluno . " AND status >= 5";

                    $consulta = mysqli_query($con,$sql);
                    $linhas = mysqli_num_rows($consulta);

                    if ($linhas>0) {
                    ?>

                    <div class="widget-header">
                        <h3>Módulos que participou ou concluiu</h3>
                    </div> <!-- /widget-header -->

                    <div class="widget-content">

                    <?php
                        while ($dados = mysqli_fetch_array($consulta)) {

                            echo $dados['nome_curso'];
                            echo " | " . $dados['descricao'];
                            echo " - " . $dados['modulo'];
                            echo "<br>";
                        }

                    echo "</div> <!-- /widget-content -->";

                    }

                    ?>

                </div> <!-- /widget-box -->

		      </div> <!-- /span4 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
    
    
    
 


    

<?php
  include ('./inc/botton.php');
?>
