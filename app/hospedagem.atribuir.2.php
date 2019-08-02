<?php 
// definir variáveis da página
$pg_titulo = "Atribuir Quarto - Hosana SiS";
$pg_nome = "hospedagem.atribuir.2.php";
$pg_menu = "hospedagem";

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');


/* 	Pegar informações do formulário anterior
 *	Verificar se está selecionado um quarto, se não estiver selecionado voltar para página anterior
 */
if (isset($_POST['quarto'])) {
	
	$quarto = $_POST['quarto'];
	$id_matricula = $_POST['id_matricula'];
	$id_matricula_b64 = base64_encode($id_matricula);
	if (!strlen($quarto) > 0) {
		// mensagem de erro
		$_SESSION["msg"] = "Precisa selecionar um quarto para dar continuidade";
        $_SESSION['msg_tipo']="alert-error";

        //echo '<html><head></head><body><h1>redirecionando...</h1></body></html>';
        //echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=./hospedagem.atribuir.1.php?id={$id_matricula_b64}'>";
        //header("location: ./aluno.php?id={$id_matricula_b64}");

		header("location: ./hospedagem.atribuir.1.php?id={$id_matricula_b64}");
    	exit;
	}
}

// listar variáveis usadas na pagina
	$nome = "";
	$sobrenome = "";
	$id_aluno = "";
	$sexo = "";
	$igreja = "";
	$cidade = "";
	$hospedagem = "";
	$camas = "";
	$ocupantes = "";
	
/*  Variáveis de apoio:
 *		$sql
 *		$tabela
 *		$linha
 *		$dados
 *		$sql_sub
 *		$tabela_sub
 *		$linha_sub
 *		$dados_sub
 *		$id_evento
 */

if (!isset($_POST['id_matricula'])) {
    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Para atribuir um quarto é preciso ter a matricula de um aluno selecionada";
    $_SESSION['msg_tipo']="alert-warning";

    // redirecionamos a pagna para onde estava antes
    header("location: ".$_SERVER['HTTP_REFERER']); # continuar e ver erros depois descomtentar
    exit;

} else {
    $id_matricula = (int)($_POST['id_matricula']); // pega o id da matricula
}



/* TODO: 
 * atribuir quarto ao aluno
 * 		- parte 1 selecionar o quarto (lado direito com lista de todos os quartos para o mesmo sexo)
 *		- parte 2 - em outra página - selecionar a vaga [cama] propriamente dito.
 */


// pegar dados do aluno e da matricula (nome, id, etc)
$sql = "SELECT * , matricula.obs AS obs_matricula, alunos.obs AS obs_aluno
			FROM matricula
			INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
			WHERE id_matricula = ".$id_matricula;

$tabela = mysqli_query($con,$sql);

if ($linha = mysqli_num_rows($tabela)) {
	if ($linha == 1) {
		while ($dados = mysqli_fetch_array($tabela)) {
			$nome = $dados['nome'];
			$sobrenome = $dados['sobrenome'];
			$id_aluno = $dados['id_aluno'];
			$sexo = $dados['sexo'];
			$igreja = $dados['igreja'];
			$cidade = $dados['cidade'];
			$hospedagem = $dados['hospedagem'];
			$id_evento = $dados['id_evento'];
		}
	}
}

echo mysqli_error($con);

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
	      				<h3>Selecionar quarto para o aluno</h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">

                        <form id="hospedagem_atribuir" action="./aluno.acao.php?atp=<?= base64_encode('atribuir_hospedagem') ?>" class="form-horizontal" method="post"   enctype="multipart/form-data" />
                          <fieldset>

							<div class="control-group" style="padding-top:50px;" >
                                <label class="control-label" for="complemento">Aluno:</label>
                                <div class="controls">
                                    <span class="destaque">
										<?php
											echo $nome." ".$sobrenome;
										?>
									</span> <!-- /span destaque -->
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->



                          <div class="control-group" style="padding-top:0;" >
                              <?php
                              // pegar o nome do quarto
                              $sql = "SELECT * FROM quarto WHERE id_quarto = {$_POST['quarto']}";
                              $tabela = mysqli_query($con,$sql);
                              $dados = mysqli_fetch_array($tabela);
                              $quarto = $dados['quarto'];
                              ?>
                              <label class="control-label" for="complemento">Quarto:</label>
                              <div class="controls">
                                  <span class="destaque">
                                    <?php
                                    echo $quarto;
                                    ?>
                                  </span>
                              </div> <!-- /controls -->
                          </div>

							<!-- input escondidos -->
							<input type='hidden' id='id_matricula' name='id_matricula' value='<?= $id_matricula ?>' />
                            <input type="hidden" id="id_aluno" name="id_aluno" value="<?= $id_aluno ?>" />
                            
			    			<?php if ($hospedagem==1) { ?>
							
                            <div class="control-group">
								<label class="control-label" for="quarto">Cama</label>
								<div class="controls">
									<select name="quarto" id="quarto" >
										<option value="" > </option>
										<?php
										
										/*
										 * Selecionar um quarto da lista de quarto para o sexo do aluno
										 */
										$sql = "SELECT * FROM cama WHERE id_quarto = {$_POST['quarto']}";
										$tabela = mysqli_query($con,$sql);


										$autoseleciona = 'selected';
										
										while ($dados = mysqli_fetch_array($tabela)) {
											// ver quantas pessoas estão no quarto para saber quantas vagas ainda tem
												 $sql_sub="SELECT *
														FROM matricula
														WHERE id_evento =". $_SESSION['evento'] ."
														AND id_cama =".$dados['id_cama']."
													";

												$tabela_sub = mysqli_query($con,$sql_sub);
                                                if (!$dados_sub = mysqli_fetch_array($tabela_sub)) {
                                                    echo "<option value={$dados['id_cama']} {$autoseleciona}>Cama: {$dados['tipo']} - {$dados['cama']}</option>";
													$autoseleciona = '';
												} else {
                                                    echo "<option value={$dados['id_cama']} disabled>OCUPADO: {$dados['tipo']} - {$dados['cama']}</option>";
												}
												
											}

										?>
									</select>

                                </div>
							</div>
							
                            <div class="control-group">
                                <div class="controls">
                                    <input type='submit' class='btn btn-large btn-success' value="Próximo" >
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->
                            
                            <?php 
								} // final da verificação de hospedagem 
								else {
									echo "<div class='label label-important'><h2 align='center'>Este aluno não vai ficar hospedado</h2></div>";
								}
							?>

                          </fieldset>
                        </form>
                        


                    </div><!-- /widget-content -->

                
				</div><!-- /widget -->
			
            </div> <!-- /span6 -->

	      	<div class="span4">	
	      		
                <div class="widget widget-box">
					
					<div class="widget-header">
	      				<h3><i  class='icon-info-sign' ></i>&nbsp;&nbsp; Alunos neste quarto</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

                    	<div class="control-group">
                        	<!-- Conteúdo aqui -->

                            <div class="contorno-fundo">
                                <ul class="unstyled">
                                    <li></li>
                                    <?php
										include("./pagina/hospedagem.ocupantes.php");
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