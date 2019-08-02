<?php 
// definir variáveis da página
$pg_titulo = "Pendência - Hosana SiS";
$pg_nome = "pendencia.add.php";
$pg_menu = "aluno";

// pegar id da matricula
$id = base64_decode($_GET['id']);

// incluir arquivo de com variáveis iniciais e contantes globais
include_once('./inc/iniciar.php');

// incluir verificação de segurança
include_once('./inc/seguranca.php');

if(isset($_POST['id_aluno'])) {

	// instruções para gravar na base de dados
	$date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO pendencia (
    			id_aluno, 
    			id_matricula, 
    			data_add,
    			data_update,
    			pendencia_txt
    		)
    	VALUES (
    			{$_POST['id_aluno']}, 
    			{$_POST['id_matricula']}, 
    			now(),
    			now(),
    			'{$_POST['input_pendencia']}'
    		)
    	"; 

    	//die($sql);

    $inserir = mysqli_query($con, $sql);

     if ($inserir) {
            
            $_SESSION["msg"]= "Pendencia adicionada!";
            $_SESSION['msg_tipo']="alert-success";
            header("location: aluno.php?id=".base64_encode($_POST['id_aluno']));
            exit;
        }
        else {
            $_SESSION["msg"] = "Não foi possível adicionar a pendencia, contate o administrador do sistema".mysqli_error($con);
            $_SESSION['msg_tipo']="alert-error";
           //header("location: pendencia.add.php?id=".base64_encode($id));
           //exit;
        }

} 

// incluir arquivos de configuração css e scripts e codigo html "head".
include_once ('./inc/head.php');

// incluir menu e mensagens de aviso e alerta
include_once ('./inc/menu_msg.php');



$sql = "SELECT * 
		FROM matricula 
		INNER JOIN alunos 
			ON matricula.id_aluno = alunos.id_aluno
		WHERE matricula.id_matricula = {$id}";

$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);

?>


<br />
<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
		    <div class="span12"> 

		    	<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-warning-sign"></i>
	      				<h3>Pendência</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

				    	<legend>
						    <i class="icon24" style="background-image:url(img/icon_contact_card_&24.png);"></i> <?php echo $dados['nome']." ".$dados['sobrenome'] ?>
						</legend>

						<form action="./pendencia.add.php?id=<?=base64_encode($id)?>" method="post" id="edit-profile" class="form" />

							<input type="hidden" id="id_matricula" name="id_matricula" value="<?= $id ?>">
							<input type="hidden" id="id_aluno" name="id_aluno" value="<?= $dados['id_aluno'] ?>">


							<div class="control-group">
                                <label class="control-label" for="input_pendencia">Pendência </label>
                                
                                <textarea name='input_pendencia' id='input_pendencia' style="width: 99%; height: 5em;"></textarea>                                
                            </div>


							<div class="control-group">						        
						        <button type="submit" class="btn btn-primary btn-large pull-right" id="btnenviar" > Salvar </button>

						        <button type="reset" class="btn btn-large" id="btnenviar" > Limpar </button>

						        <a type="submit" class="btn btn-large" style='margin: 0 3px;' id="btnenviar"  href="aluno.php?id=<?=base64_encode($dados['id_aluno'])?>"> Aluno </a>

						        <a type="submit" class="btn btn-large" id="btnenviar" style='margin: 0 3px;' href="pendencia_listar_all.php"> Pendencias </a>
						    </div><!-- /control-group -->

						</form>

					</div><!-- widget-content -->

				</div><!-- Widget -->

			</div><!-- Span12 -->

	      </div><!-- Row -->

	    </div><!-- Container -->

	</div><!-- Main-inner -->

</div>
