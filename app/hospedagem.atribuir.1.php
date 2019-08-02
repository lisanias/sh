<?php 
// definir variáveis da página
$pg_titulo = "Atribuir Quarto - Hosana SiS";
$pg_nome = "hospedagem.atribuir.1.php";
$pg_menu = "hospedagem";

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

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



if (!isset($_GET['id'])) {
    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Para atribuir um quarto é preciso ter a matricula de um aluno selecionada";
    $_SESSION['msg_tipo']="alert-warning";

    // redirecionamos a pagna para onde estava antes
    # echo $_GET['id'];
    header("location: ".$_SERVER['HTTP_REFERER']); # continuar e ver erros depois descomtentar
} else {
    $id_matricula = (int)base64_decode($_GET['id']); // pega o id da matricula
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
			WHERE id_matricula = ".$id_matricula."";

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
		    $obs_matricula = $dados['obs_matricula'];
		    $id_cama = $dados['id_cama'];
		}
	}
}


echo mysqli_error($con);

?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->
<pre>
<?php

?>
</pre>
<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <br><div class="row">
	      	
	      	<div class="span8">
            
            	<div class="widget ">
                	
                    <div class="widget-header">
	      				<i class='icon-share' ></i>
	      				<h3>Selecionar quarto para o aluno</h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">

                        <form id="hospedagem_atribuir" action="hospedagem.atribuir.2.php?atp=<?= base64_encode('atribuir_hospedagem') ?>" class="form-horizontal" method="post"   enctype="multipart/form-data" />
                          <fieldset>
							
			    <div class="control-group" style="padding-top:50px;" >
                                <label class="control-label" for="complemento">Aluno:</label>
                                <div class="controls">
                                    <span class="destaque">
					<?php echo $nome." ".$sobrenome; ?>
				    </span> <!-- /span destaque -->
				    </br>
				    <?= $obs_matricula ?>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->							
							<!-- input escondidos -->
							<input type='hidden' id='id_matricula' name='id_matricula' value='<?= $id_matricula ?>' />
                            <input type="hidden" id="id_aluno" name="id_aluno" value="<?= $id_aluno ?>" />
                            
			    			<?php

                            if ($hospedagem==1) {

                                if ($id_cama==0) {

                            ?>


                                    <div class="control-group">
                                        <label class="control-label" for="quarto">Quarto</label>
                                        <div class="controls">
                                            <select name="quarto" id="quarto" >
                                                <option value="" > </option>
                                                <?php

                                                /*
                                                 * Selecionar um quarto da lista de quarto para o sexo do aluno
                                                 */
                                                $sql = "SELECT * FROM quarto WHERE sexo = '{$sexo}' AND disponivel = 1 AND id_local = {$_SESSION['local']} ORDER BY quarto DESC";
                                                $tabela = mysqli_query($con,$sql);

                                                while ($dados = mysqli_fetch_array($tabela)) {
                                                    // ver quantas pessoas estão no quarto para saber quantas vagas ainda tem
                                                         $sql_sub="SELECT COUNT( * ) AS soma
                                                                FROM matricula
                                                                INNER JOIN cama ON matricula.id_cama = cama.id_cama
                                                                WHERE matricula.id_evento =". $_SESSION['evento'] ."
                                                                AND cama.id_quarto =".$dados['id_quarto']."
                                                            ";
                                                        $tabela_sub = mysqli_query($con,$sql_sub);
                                                        $dados_sub = mysqli_fetch_array($tabela_sub);
                                                        if ($linhas_sub = mysqli_num_rows($tabela_sub)) {
                                                            $ocupantes = $dados_sub['soma'];
                                                        } else {
                                                            $ocupantes = 0;
                                                        }

                                                    $camas = $dados['capacidade'];
                                                    $livre = $camas - $ocupantes ;

                                                    if ($ocupantes < $camas) {
                                                        echo "<option value={$dados['id_quarto']} >{$dados['id_quarto']} Quarto {$dados['quarto']} ({$dados['sexo']}) - Camas Livres: {$livre}</option>";
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
                                    }
                                    else {
                                        echo "<div class='label label-important'><h2 align='center'>Este aluno já está hospedado</h2></div>";
                                    }
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
	      				<h3><i  class='icon-info-sign' ></i>&nbsp;&nbsp; Matrícula</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

                    	<div class="control-group">
                        	<!-- Conteúdo aqui -->

                            <div class="contorno-fundo">
                                <ul class="unstyled">
									
                                    <?php
										include("./pagina/hospedagem.inscricao.php");
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