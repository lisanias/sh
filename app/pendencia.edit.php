<?php 
// definir variáveis da página
$pg_titulo = "Pendência - Hosana SiS";
$pg_nome = "pendencia.add.php";
$pg_menu = "aluno";

// pegar id da pendencia
$id = base64_decode($_GET['id']);

// incluir arquivo de com variáveis iniciais e contantes globais
include_once('./inc/iniciar.php');

// incluir verificação de segurança
include_once('./inc/seguranca.php');

if(isset($_POST['id'])) {

	// instruções para gravar na base de dados
    $sql = "UPDATE pendencia 
    		SET 
    			pendencia_txt = '{$_POST['input_pendencia']}',
    			data_update = now()
    		WHERE id= {$id}"; 

    	//die($sql);

    $atauliza = mysqli_query($con, $sql);

     if ($atauliza) {
            
            $_SESSION["msg"]= "Alteração salva!";
            $_SESSION['msg_tipo']="alert-success";
            header("location: pendencia.edit.php?id=".base64_encode($id));
            exit;
        }
        else {
            $_SESSION["msg"] = "Não foi possível adicionar a pendencia, contate o administrador do sistema".mysqli_error($con);
            $_SESSION['msg_tipo']="alert-error";
           header("location: pendencia.edit.php?id=".base64_encode($id));
           exit;
        }

} 

// incluir arquivos de configuração css e scripts e codigo html "head".
include_once ('./inc/head.php');


// incluir menu e mensagens de aviso e alerta
include_once ('./inc/menu_msg.php');



$sql = "SELECT * 
		FROM pendencia 
		INNER JOIN alunos 
			ON pendencia.id_aluno = alunos.id_aluno
		WHERE pendencia.id = {$id}";

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

							<legend><h3>
								<?php echo $dados['nome']." ".$dados['sobrenome'] ?>
							</h3></legend>

							<legend>
							Inserido em: <?php echo $dados['data_add']." | Atualizado em: ".$dados['data_update'] ?>
							</legend>

							<form action="./pendencia.edit.php?id=<?=base64_encode($id)?>" method="post" id="edit-profile" class="form" />

								<input type="hidden" id="id_matricula" name="id_matricula" value="<?= $dados['id_matricula'] ?>">
								<input type="hidden" id="id_aluno" name="id_aluno" value="<?= $dados['id_aluno'] ?>">
								<input type="hidden" id="id" name="id" value="<?= $dados['id'] ?>">


								<div class="control-group">
									<label class="control-label" for="input_pendencia">Pendência </label>
									
									<textarea name='input_pendencia' id='input_pendencia' style="width: 99%; height: 5em;"><?= $dados['pendencia_txt'] ?></textarea>                                
								</div>


								<div class="control-group">

									<button type="submit" class="btn btn-primary btn-large pull-right" id="btnenviar" > Salvar </button>	 

									<button type="reset" class="btn btn-large" id="btnenviar" > Limpar </button>

									<a class="btn btn-large" id="btnenviar" href="aluno.php?id=<?=base64_encode($dados['id_aluno'])?>"> Aluno </a>

									<a class="btn btn-large" id="btnenviar" style='margin: 0 3px;'  href="pendencia_listar_all.php"> Pendencias </a>&nbsp;

									<a class='btn btn-large btn-success icon-ok pull-right' style='margin: 0 3px;' title='Pendencia resolvida' href='aluno.acao.php?atp=<?=base64_encode('pendencia_resolver')?>&id=<?=base64_encode($dados['id'])?>&id_aluno=<?=base64_encode($dados['id_aluno'])?>'> Fechar Pendencia </a>        
								</div><!-- /control-group -->

							</form>

						</div><!-- widget-content -->

					</div><!-- Widget -->

				</div><!-- Span12 -->

	      	</div><!-- Row -->

	    </div><!-- Container -->

	</div><!-- Main-inner -->

</div>
<?php
  include ('./inc/botton.php');
?>