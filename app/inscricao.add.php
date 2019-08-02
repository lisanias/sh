<?php 
// definir variáveis da página
$pg_titulo = "Adicionar inscrição - Hosana SiS";
$pg_nome = "incricao.add.php";
$pg_menu = "academico";

if (!isset($_GET['id'])) {
    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Para adicionar uma matricula presa ter um aluno selecionado!";
    $_SESSION['msg_tipo']="alert-warning";

    // redirecionamos a pagna para onde estava antes
    # echo $_GET['id'];
    header("location: ".$_SERVER['HTTP_REFERER']); # continuar e ver erros depois descomtentar
} else {
    $id_aluno = (int)base64_decode($_GET['id']); // pega o id da matricula
}

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

/* TODO: lista a seguir:
 * selecionar o evento
 * selecior o curso
 * confirmar se o aluno já não tem uma matricula em outro curso nesse mesmo evento
 * confirmar matricula
 * inserir conprovante de pagamento (já pronto, só inserir link)
*/

?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->

<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span8">
            
            	<div class="widget ">
                	
                    <div class="widget-header">
	      				<i class='icon-share' ></i>
	      				<h3><?=$TEXT['nova_inscricao']?></h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">

                        <form id="add_inscricao" action="aluno.acao.php?atp=<?= base64_encode('add_inscricao') ?>" class="form-horizontal" method="post"   enctype="multipart/form-data" />
                          <fieldset>

                            <!-- input escondidos -->
							<input type='hidden' value='<?= $id_aluno ?>' name='id_aluno' />
							
							<div class="control-group">
                                <label class="control-label" for="complemento"><?= $TEXT['aluno'] ?></label>
                                <div class="controls">
                                    <span class="destaque">
									<?php
										// Buscar o modulo que o aluno estára fazendo a matricula
										$sql = "SELECT * FROM alunos WHERE id_aluno = ".$id_aluno;
										
										$tabela = mysqli_query($con,$sql);
										
										while ($dados = mysqli_fetch_array($tabela)) {
											echo $dados['nome']." ".$dados['sobrenome'];
										}
										echo mysqli_error($con);
										?>
									</span> <!-- /span destaque -->
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->
							
							<!-- hidden inputs -->
                            <input type="hidden" id="id_aluno" name="id_aluno" value="<?=$id_aluno?>" />
			    
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
										$sql = "SELECT * FROM evento ORDER BY data_ini DESC";
										
										$tabela = mysqli_query($con,$sql);
										
										while ($dados = mysqli_fetch_array($tabela)) {
											echo "<option value={$dados['id_evento']} >{$dados['descricao']}</option>";
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
										$sql = "SELECT * FROM cursos;";
										
										$tabela = mysqli_query($con,$sql);
										
										while ($dados = mysqli_fetch_array($tabela)) {
											echo "<option value={$dados['id_curso']} >{$dados['nome_curso']}</option>";
										}
										?>
									</select>
								</div>
							</div>
							
                            
							
                            <div class="control-group">
                                <label class="control-label" for="complemento"><?= $TEXT['obs'] ?></label>
                                <div class="controls">
                                    <textarea name='obs' id='obs'>Inscriçao feita no Hosana em <?= date('d-m-Y') ?></textarea><br>
									<span class='dicas'>Escrever observões especiais quanto a hospedagem e quaisquer outra informação que o SH precise saber antecipadamente.</span>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <div class="controls">
                                    <input type='submit' class='btn btn-large btn-success' value='Enviar'>
                                    <a class="btn btn-primary" href="aluno.php?id=<?= base64_encode($id_aluno) ?>">Ficha</a>
                                </div> <!-- /controls -->
                            </div><!-- /control-group -->

                          </fieldset>
                        </form>
                        


                    </div><!-- /widget-content -->

                
				</div><!-- /widget -->
			
            </div> <!-- /span6 -->
	      		      	
	      	<div class="span4">	
	      		
                <div class="widget widget-box">
					
					<div class="widget-header">
	      				<h3><i  class='icon-info-sign' ></i> <?= $TEXT['modulo_cursado'] ?></h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

                    	<div class="control-group">
                        	<!-- Conteúdo aqui -->

                            <div class="contorno-fundo">
                                <ul class="unstyled">
                                    <li></li>
                                    <?php
									// pesquisar na base de dados matriculas quais cursos o aluno ja esteve matriculado
									
									$sql = "
										SELECT
											matricula.id_matricula AS id_matricula,
											matricula.status AS status,
											modulo.modulo AS modulo,
											modulo.valor AS valor_curso,
											cursos.nome_curso AS nome_curso
										FROM
											matricula
										INNER JOIN
											modulo ON modulo.id_modulo = matricula.id_modulo
										INNER JOIN
											cursos ON cursos.id_curso = modulo.id_curso
										INNER JOIN
											evento ON evento.id_evento = modulo.id_evento
										WHERE
											matricula.id_aluno = ".$id_aluno."
										ORDER BY
										    evento.data_ini ASC
										";
										
									$tabela = mysqli_query($con,$sql);
										
									while ($dados = mysqli_fetch_array($tabela)) {
										if ($dados['status']==7) {
											$stilo_tipo_matricula = "matricula_concluida";
										}
										else {
											$stilo_tipo_matricula = "matricula_inscrita";
										}
										echo "<li class='{$stilo_tipo_matricula}' ><br />".$dados["nome_curso"]." | ".$dados['modulo']." | ".fsr($dados['status'])."</li>";
									}
                                    

                                    ?>

                                </ul>
                            </div>


                        </div>
                    
					
		    </div> <!-- /span6 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>