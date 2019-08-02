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

$id_aluno = isset($_GET['id'])?base64_decode($_GET['id']):'';

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
	      				<h3>Pedidos de PENDRIVE</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

						<?php
							$sql = "SELECT * 
								FROM audio_pendrive 
								INNER JOIN alunos 
									ON audio_pendrive.id_aluno = alunos.id_aluno 
									WHERE audio_pendrive.id_evento = {$_SESSION['evento']}
									AND audio_pendrive.id_aluno = {$id_aluno}
								ORDER BY data_pedido DESC"; 
								
							$tabela = mysqli_query($con,$sql);

							$dados = mysqli_fetch_array($tabela);
						
						?>

						<form action='./audio.pen.add.php?id=<?= base64_encode($id_aluno) ?>&atp=<?= base64_encode('mudar') ?>' method='post' id='pedidos-pen' class='form' />

							<div class="control-group">
								<label class="control-label" for="nome">Nome</label>
								<div class="controls">
									<?= $dados['nome'] . ' ' . $dados['sobrenome'] ?>
								</div>
							</div><!-- /control-group -->

							<div class="control-group">
								<label class="control-label" for="nome">Data do Pedido</label>
								<div class="controls">
									<?= date('d/m/Y H:i', strtotime($dados['data_pedido'])) ?>
								</div>
							</div><!-- /control-group -->

							<?php 
								if (is_null($dados['pago'])) {
									$checked_str = '';
								} else {
									$checked_str = ($dados['pago']==1)?'checked':'';
								}
							
							?>
							<div class="control-group">
								<label class="control-label" for="nome">Pago</label>
								<div class="controls">
									<?php echo "<input type='checkbox' name='pago' value=1 ", $checked_str ," ></input>" ?>
								</div>
							</div><!-- /control-group -->

							<?php 
								if (is_null($dados['entregue'])) {
									$checked_str = '';
								} else {
									$checked_str = ($dados['entregue']==1)?'checked':'';
								}
							
							?>
							<div class="control-group">
								<label class="control-label" for="nome">Entregue</label>
								<div class="controls">
									<?php echo "<input type='checkbox' name='entregue' value=1 ", $checked_str ," ></input>" ?>
									<?php if (!is_null($dados['data_entregue'])) {
										echo ' Entregue em ', date('d/m/Y H:i', strtotime($dados['data_entregue']));
									}
									?>
								</div>
							</div><!-- /control-group -->

							<div class="control-group">
								<label class="control-label" for="obs_pen">Observação</label>
								<div class="controls">
									<textarea name="obs_pen" id="obs_pen" ><?= $dados['obs_pen'] ?></textarea>
								</div>
							</div><!-- /control-group -->

							<div class="controls">
								<input type="submit" min="btn_enviar" name="enviar" value="Salvar mudanças" class="btn btn-block btn-primary btn-large icon-ok-circle" />

								<?php echo "<a class='btn btn-block btn-danger icon-remove btn-small' href='audio.pen.add.php?id=".base64_encode($dados['id_pen'])."&atp=".base64_encode('del')."' title='Ir para pedido' > Cancelar pedido </ a>&nbsp;"; ?>

								<a class='btn btn-success icon-play-circle pull-right' title='Listar pedidos' href='audio.pen.php' > Lista </a>
							</div>

						</form>

				
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->

	      	</div> <!-- /span12 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
    
    
    
 


    

<?php
  include ('./inc/botton.php');
?>
