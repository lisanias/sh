<?php 
// definir variáveis da página
$pg_titulo = "Comprovante - Hosana SiS";
$pg_nome = "pagamento.ver.comprovante.php";
$pg_menu = "financeiro";

if (!isset($_GET['id'])) {
    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Selecione um pagamento";
    $_SESSION['msg_tipo']="alert-warning";

    // redirecionamos a pagna para onde estava antes
    echo $_GET['id'];
    //header("location: ".$_SERVER['HTTP_REFERER']); # continuar e ver erros depois descomtentar
} else {
    $id_pagamento = base64_decode($_GET['id']);
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
	      				<h3>Alterar dados deste pagamento:</h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">

                        <form id="alterar-pagamento" action="aluno.acao.php?atp=<?= base64_encode('alterar_pagamento_dados') ?>&idp=<?= base64_encode($id_pagamento) ?>" class="form-horizontal" method="post" />
                          <fieldset>

                            <!-- Formaulário para alterar dados do pagamento -->
                            <div class="control-group">
                                <label class="control-label" for="data_pg">Data de pagamento:</label>
                                <div class="controls">
                                    <input type="text" id="data_pg" name="data_pg" value="<?= implode('/',array_reverse(explode('-',$dados['data_pg']))) ?>" class="login input-small" />
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="descricao">Descrição:</label>
                                <div class="controls">
                                     <input type="text" id="descricao" name="descricao" value="<?= $dados["descricao"] ?>" class="input-xlarge login" />
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="complemento">complemento:</label>
                                <div class="controls">
                                    <input type="text" id="complemento" name="complemento" value="<?= $dados["complemento"] ?>" class="login" />
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="forma_pg">Forma de pagamento:</label>
                                <div class="controls">
                                    <select id="forma_pg" name="forma_pg" title="Forma de Pagamento" >
                                        <option value="1" <?php if($dados["forma_pg"]==1) {echo "selected";} ?> >Crédito</option>
                                        <option value="2" <?php if($dados["forma_pg"]==2) {echo "selected";} ?> >Débito</option>
                                        <option value="3" <?php if($dados["forma_pg"]==3) {echo "selected";} ?> >Espécie</option>
                                        <option value="4" <?php if($dados["forma_pg"]==4) {echo "selected";} ?> >Depósito</option>
                                        <option value="5" <?php if($dados["forma_pg"]==5) {echo "selected";} ?> >Cheque</option>
                                        <option value="6" <?php if($dados["forma_pg"]==6) {echo "selected";} ?> disabled>Boleto</option>
                                        <option value="9" <?php if($dados["forma_pg"]==9) {echo "selected";} ?> >Outro</option>
                                    </select>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="refa">Referente à:</label>
                                <div class="controls">
                                    <select id="refa" name="refa" title="Referente à" >
                                        <option value="1" <?php if($dados["ref_a"]==1) {echo "selected";} ?> >Pagamento do valor total</option>
                                        <option value="2" <?php if($dados["ref_a"]==2) {echo "selected";} ?> >Pagamento da Inscrição</option>
                                        <option value="3" <?php if($dados["ref_a"]==3) {echo "selected";} ?> >Pagamento de uma Parcela</option>
                                    </select>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="valor">Valor:</label>
                                <div class="controls">
                                    <input type="text" name="valor" class="input-mini" id="valor" value="<?= $dados["valor"] ?>" />
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <br>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div> <!-- /form-actions -->

                          </fieldset>
                        </form>

                        <!-- Exibir imagem do comprovante flutuando do lado direito -->
                        <div class="control-group" style="text-align: center;">
                            <?php $imglink = "../".$dados['comprovante']; ?>
                            <img style="max-width:470px;" src="<?= $imglink ?>"/><br/><?= $imglink ?>
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

                            <a class='btn btn-block btn-mini icon-user pull-right' href='aluno.php?id=<?= base64_encode($id_aluno) ?>' ><strong>Ir para ficha do <?= $dados["nome"] ?></strong></a>
                            <?= function_pg_status_icon($dados["status"]) ?>

                            <div class="contorno-fundo">
                                    <ul class="unstyled">
                                        <li></li>
                                        <?php
                                        echo "<li><br />Aluno:<br /><a class='btn-link' href='aluno.php?id=".base64_encode($id_aluno)."' ><strong>" . $dados["nome"] ." " . $dados["sobrenome"] . "</strong></a><li>";
										echo "<li><br />Descrição:<br /><strong>" . $dados["nome_curso"] . "</strong><li>";
										echo "<li><br />Status:<br /><strong>". function_pg_status($dados["status"]) . "</strong><li>";

                                        ?>

                                    </ul>
                            </div>

                            <div class="form-actions" >

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
                            </div> <!-- /form-actions -->





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