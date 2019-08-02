<?php 
// definir variáveis da página
$pg_titulo = "Comprovante - Hosana SiS";
$pg_nome = "pagamento.ver.comprovante.php";
$pg_menu = "financeiro";

if (!isset($_GET['idpagamento'])) {
    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Selecione um pagamento";
    $_SESSION['msg_tipo']="alert-warning";

    // redirecionamos a pagna para onde estava antes
    header("location: ".$_SERVER['HTTP_REFERER']);
} else {
    $id_pagamento = base64_decode($_GET['idpagamento']);
}

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');
?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->

<?php
$sql = "SELECT 
		pagamento.data_pg AS data_pg,
		pagamento.data_add_pg AS data_add_pg,
		pagamento.valor AS valor,
		pagamento.status AS status,
		pagamento.comprovante AS comprovante,
		pagamento.descricao AS descricao,
		pagamento.complemento AS complemento,
		pagamento.ref_a AS ref_a,
		pagamento.forma_pg AS forma_pg,
		pagamento.id_pagamento AS id_pagamento,
		pagamento.id_matricula AS id_matricula,
		matricula.id_evento AS id_evento,
		matricula.status AS status_matricula,
		cursos.nome_curso AS nome_curso, 
		cursos.apelido AS apelido, 
		alunos.nome AS nome, 
		alunos.sobrenome AS sobrenome,
		alunos.id_aluno AS id_aluno
	FROM pagamento
	INNER JOIN matricula ON pagamento.id_matricula = matricula.id_matricula
	INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
	INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
	INNER JOIN cursos ON modulo.id_curso = cursos.id_curso
	WHERE pagamento.id_pagamento = ". $id_pagamento;

$tabela = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($tabela);

$id_aluno = $dados['id_aluno'];
$status = $dados["status"];
?>
<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span8">
            
            	<div class="widget ">
                	
                    <div class="widget-header">
	      				<i class='icon-barcode' ></i>
	      				<h3>Copia do Comprovante/Recibo de <?= $dados['nome'] ?></h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
	      		
<?php $imglink = "../".$dados['comprovante']; ?>

                    	<div class="control-group" style="text-align: center;">
                            <img style="max-width:730px;" src="<?= $imglink ?>"/><br/><?= $imglink ?>
                        </div>
                   
                    </div><!-- /widget-content -->

                
				</div><!-- /widget -->
			
            </div> <!-- /span6 -->
	      		      	
	      	<div class="span4">	
	      		
                <div class="widget widget-box">
					
					<div class="widget-header">
	      				<h3><i  class='icon-info-sign' ></i> Informações sobre o pagamento</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

                    	<div class="control-group">
                        	<!-- Conteúdo aqui -->

                            <?php include('./pagina/pagamento.dados.alunos.latdir.php'); ?>

                            <div class="form-actions">
                                <legend>Alterar Status do pagamento para:</legend>

                                <?php if ($status<>1) { ?>
                                    <a href="./aluno.acao.php?atp=<?= base64_encode("pagamento_alterar_status") ?>&aux=1&idp=<?= base64_encode($id_pagamento) ?>&ida=<?= base64_encode($id_aluno) ?>" class="btn btn-danger span2" title="Este pagamento não pode ser confirmada">Não confirmado</a><br />
                                <?php } ?>

                                <?php if ($status<>2) { ?>
                                    <a href="./aluno.acao.php?atp=<?= base64_encode("pagamento_alterar_status") ?>&aux=2&idp=<?= base64_encode($id_pagamento) ?>&ida=<?= base64_encode($id_aluno) ?>" class="btn btn-primary span2" title="Comprovante de pagamento enviado pelo aluno (e ainda não confirmado pela secretaria)">Comprovante Enviado</a><br />
                                <?php } ?>

                                <?php if ($status<>3) { ?>
                                    <a href="./aluno.acao.php?atp=<?= base64_encode("pagamento_alterar_status") ?>&aux=3&idp=<?= base64_encode($id_pagamento) ?>&ida=<?= base64_encode($id_matricula) ?>" class="btn btn-success span2" title="Confirmar pagamento">Confirmar</a><br />
                                <?php } ?>
                                
                                
                            </div>
                            
                        </div>

                        <div><span class="badge"><?php echo $dados["id_pagamento"]; ?></span></div>
                    
					
		    </div> <!-- /span6 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>