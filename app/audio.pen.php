<?php 
// definir variáveis da página
$pg_titulo = "Aluno - Hosana SiS";
$pg_nome = "aluno.php";
$pg_menu = "academico";


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

	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-music"></i>
	      				<h3>Encomendas de pendrive</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

						<?php
							$sql = "SELECT * 
								FROM audio_pendrive 
								INNER JOIN alunos 
									ON audio_pendrive.id_aluno = alunos.id_aluno 
									WHERE audio_pendrive.id_evento = ".$_SESSION['evento']."
								ORDER BY alunos.nome"; 
								
							$tabela = mysqli_query($con,$sql);
						?>

						<table class="table table-striped table-bordered">
				            <thead>
				                <tr>
				                    <th>Nome</th>
				                    <th>Cidade</th>
				                    <th>Pago</th>
				                    <th>Entregue</th>
				<?php
				if ($linhas = mysqli_num_rows($tabela)) {
					echo "<th class='td-actions'  width='38px'><sapn class='label label-important'> ".$linhas." </sapn></th>";
				?>
				                   
				                </tr>
				            </thead>
				            <tbody>
				<?php 

					
				    while ( $dados = mysqli_fetch_array($tabela) ) {
						
				        echo '<tr>';
				        echo "<td><abbr title='".$dados['nome']." ".$dados['sobrenome']."'>".nome2($dados['nome']." ".$dados['sobrenome'])."</td>";

				        echo "<td>".$dados['cidade']."</td>";
				        
				        if (is_null($dados['pago'])) {
							$checked_str = '';
						} else {
							$checked_str = ($dados['pago']==1)?'checked':'';
						}
				        echo "<td class='td-actions'><input type='checkbox' " . $checked_str . " disabled ></input></td>";
				        
						if (is_null($dados['entregue'])) {
							$checked_str = '';
						} else {
							$checked_str = ($dados['entregue']==1)?'checked':'';
						}
				        echo "<td class='td-actions'><input type='checkbox' " . $checked_str . " disabled ></input> ";
				        if ($checked_str == "checked") {
				        	echo date('d/m/Y H:i', strtotime($dados['data_entregue']));
				        }
				        echo "</td>";
						
						echo "<td style='min-width: 100px'>";

						echo "<a class='btn btn-primary' href='audio.pen.pedido.php?id=".base64_encode($dados['id_aluno'])."' title='Ir para pedido' ><i class='icon-signin'></i></ a>&nbsp;";

						echo "<a class='btn btn-success' href='aluno.php?id=". base64_encode($dados['id_aluno'])."' title='Ir para ficha' ><i class='icon-user'></i></ a>&nbsp;";

						//echo "<a class='btn btn-danger' href='audio.pen.add.php?id=".base64_encode($dados['id_pen'])."&atp=".base64_encode('del')."' title='Ir para pedido' ><i class='icon-remove'></i></ a>&nbsp;";
						
						echo "</td>";
						echo "</tr>";
					}
				}
				?>
				            
				            </tbody>
				        </table>
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->

	      	</div> <!-- /span8 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
    
    
    
 


    

<?php
  include ('./inc/botton.php');
?>
