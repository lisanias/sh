<?php 
// definir variáveis da página
$pg_titulo = "Editar inscrição - Hosana SiS";
$pg_nome = "incricao.edit.php";
$pg_menu = "academico";

if (!isset($_GET['id'])) {
    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Para adicionar uma matricula presa ter um aluno selecionado!";
    $_SESSION['msg_tipo']="alert-warning";

    // redirecionamos a pagna para onde estava antes
    # echo $_GET['id'];
    header("location: ".$_SERVER['HTTP_REFERER']); # continuar e ver erros depois descomtentar
} else {
    $id_matricula = (int)base64_decode($_GET['id']); // pega o id da matricula
}

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

/* Editar uma matricula de aluno caso seja preciso alterar alguma coisa
*/

/* abrir base de dados matricula
 * 	juntar com aluno e verificar se tem alguma matricula com esse id
 */

	$sql = "SELECT *, matricula.obs as obs_matricula FROM matricula
			INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
			INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
			WHERE id_matricula = ".$id_matricula;
	
	$tabela = mysqli_query($con,$sql);
	$linhas = mysqli_num_rows($tabela);
	if (!$linhas == 1) {
		// adicionamos a mensagem para ecibir na próxima página
		$_SESSION['msg']= "<h1>Atenção</h1>Não tem nenhuma inscrição selecionada!";
		$_SESSION['msg_tipo']="alert-error";
	
		// redirecionamos a pagna para onde estava antes
		//header("location: ".$_SERVER['HTTP_REFERER']); 
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=".$_SERVER['HTTP_REFERER']."'>";
	}
$dados = mysqli_fetch_array($tabela);
?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->

<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span8">
            
            	<div class="widget ">
                	
                    <div class="widget-header">
	      				<i class='icon-edit' ></i>
	      				<h3>Editar inscrição</h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">

                        <form id="add_inscricao" action="aluno.acao.php?atp=<?= base64_encode('edit_inscricao') ?>" class="form-horizontal" method="post"   enctype="multipart/form-data" />
                          <fieldset>

                            <!-- input escondidos -->
							<input type="hidden" id="id_aluno" name="id_aluno" value="<?=$dados['id_aluno']?>" />
                            <input type="hidden" id="id_matricula" name="id_matricula" value="<?=$dados['id_matricula']?>" />
							
							<div class="control-group">
                                <label class="control-label" for="complemento"><?= $TEXT['aluno'] ?></label>
                                <div class="controls">
									<?php
										//while ($dados = mysqli_fetch_array($tabela)) {
											
											echo $dados['nome']." ".$dados['sobrenome'];
										//}
										echo mysqli_error($con);
										?>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->
                            
							<div class="control-group">
								<label class="control-label" for="id_evento"><?= $TEXT['sel_evento'] ?></label>
								<div class="controls">
									<select name="id_evento" id="id_evento" >
										<?php
										// Buscar o modulo que o aluno estára fazendo a matricula
										/*
										 * Estaremos buscando todos os eventos cadastrados, para poder criar o arquivo do aluno.
										 * Depois que todos os alunos estiverem com o histórico completo usaremos
										 * a instrução sql "SELECT * FROM evento WHERE data_fim >= NOW()".
										 *
										 * Por enquanto estaremos mostrando todos os eventos cadastrados no sistema.
										 */
										$sql_evento = "SELECT * FROM evento ORDER BY data_ini DESC";
										
										$tabela_evento = mysqli_query($con,$sql_evento);
										
										while ($evento = mysqli_fetch_array($tabela_evento)) {
											$selecionado = ($evento['id_evento']==$dados['id_evento'])? "Selected": "";
											echo "<option value={$evento['id_evento']} {$selecionado} >{$evento['descricao']}</option>";
										}
										?>
									</select> 
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="id_curso"><?= $TEXT['curso'] ?></label>
								<div class="controls">
									<select name="id_curso" id="id_curso">
										<?php
										// Buscar o modulo que o aluno estára fazendo a matricula
										$sql_curso = "SELECT * FROM cursos;";
										
										$tabela_curso = mysqli_query($con,$sql_curso);
										
										while ($cursos = mysqli_fetch_array($tabela_curso)) {
											$selecionado = ($cursos['id_curso']==$dados['id_curso'])? "Selected": "";
											echo "<option value={$cursos['id_curso']} {$selecionado} >{$cursos['id_curso']} - {$cursos['nome_curso']}</option>";
										}
										?>
									</select>
								</div>
							</div> 
                            
							<div class="control-group">
								<label class="control-label" for="hospedagem"><?= $TEXT['hospedagem'] ?></label>
								<div class="controls">
									<select name="hospedagem" id="hospedagem">
										<?php
										// Buscar o modulo que o aluno estára fazendo a matricula
										
											if ($dados['hospedagem']==1) {
												echo "<option value=1 selected >SIM</option>";
												echo "<option value=0 >Não</option>";
											}
											else {
												echo "<option value=1 >SIM</option>";
												echo "<option value=0 selected >Não</option>";
											}
										?>
									</select>
								</div>
							</div>
							
			    <div class="control-group">
				<label class="control-label" for="complemento">Data para envio do comprovante</label>
				    <div class="controls">
					<div class="input-prepend">							    
					    <?PHP
					    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') | strpos($_SERVER['HTTP_USER_AGENT'], "Trident")) {
						$data_orden = 'd/m/Y';
					    } else {
						$data_orden = 'Y-m-d';
					    }
					    ?>
					    <input type="date" style='text-align: right' class='span2 input-small' type='text' id='comprovante' name='comprovante' value='<?= date($data_orden, strtotime($dados['data_comprovante'])) ?>'> dd/mm/aaaa
					</div>
				    </div> <!-- /controls -->
				</div>
			    <div class="control-group">
							    <label class="control-label" for="complemento">Descontos</label>
							    <div class="controls">
												    <div class="input-prepend">
													    <span class="add-on">$</span>
													    <input style='text-align: right' class='span2 input-small' type='text' id='desconto' name='desconto' value='<?=number_format($dados['desconto'],2,",",".")?>'>
												    </div>
							    </div> <!-- /controls -->
                            </div>
							
                            <div class="control-group">
                                <label class="control-label" for="complemento"><?= $TEXT['obs'] ?></label>
                                <div class="controls">
                                    <textarea name='obs' id='obs'><?= $dados['obs_matricula'] ?></textarea><br>
									<span class='dicas'>Escrever observões especiais quanto a hospedagem e quaisquer outra informação que o SH precise saber antecipadamente.</span>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <div class="controls">
                                    <input type='submit' class='btn btn-large btn-success' value="Alterar" >
                                    <a class="btn btn-primary" href="aluno.php?id=<?= base64_encode($dados['id_aluno']) ?>">Ficha</a>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                          </fieldset>
                        </form>
                        <span style="color:#CCC; font-size:xx-small;" ><?= $dados['id_matricula'] ?>.<?= $dados['id_aluno'] ?></span>


                    </div><!-- /widget-content -->

                
				</div><!-- /widget -->
			
            </div> <!-- /span6 -->
	      		      	
	      	<div class="span4">	
	      		
                
					
		    </div> <!-- /span4 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>