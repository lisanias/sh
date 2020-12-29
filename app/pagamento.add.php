<?php 
// definir variáveis da página
$pg_titulo = "Adicionar pagamento - Hosana SiS";
$pg_nome = "pagamento.add.php";
$pg_menu = "financeiro";

if (!isset($_GET['id'])) {
    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Selecione um pagamento";
    $_SESSION['msg_tipo']="alert-warning";

    // redirecionamos a pagna para onde estava antes
    # echo $_GET['id'];
    header("location: ".$_SERVER['HTTP_REFERER']); # continuar e ver erros depois descomtentar
} else {
    $id_matricula = (int)base64_decode($_GET['id']); // pega o id da matricula
}

$valor_default = "";
$date_default = date('d/m/Y');

// ver se tem algum valor atribuido para o campo valor
if (isset($_GET['valor'])) {
	$valor_default = number_format($_GET['valor'],2,',','.');
	$date_default = date('d/m/Y');
}


// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

$sql = "
    SELECT
        matricula.id_matricula AS id_matricula,
        matricula.status AS status,
		matricula.desconto AS desconto,
        modulo.modulo AS modulo,
        modulo.valor AS valor_curso,
        cursos.nome_curso AS nome_curso,
        alunos.nome AS nome_aluno,
        alunos.sobrenome AS sobrenome_aluno,
        alunos.id_aluno AS id_aluno
    FROM
        matricula
    INNER JOIN
        modulo ON modulo.id_modulo = matricula.id_modulo
    INNER JOIN
        cursos ON cursos.id_curso = modulo.id_curso
    INNER JOIN
        alunos ON alunos.id_aluno = matricula.id_aluno
    WHERE
        matricula.id_matricula = ".$id_matricula."
    ";

$tabela = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($tabela);

$id_aluno = $dados['id_aluno'];
$status = $dados["status"];

?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->

<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span8">
            
            	<div class="widget ">
                	
                    <div class="widget-header">
	      				<i class='icon-barcode' ></i>
	      				<h3><?=$TEXT['pag_add_titulo_divmain']?></h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">

                        <form id="add_pagamento" action="aluno.acao.php?atp=<?= base64_encode('add_pagamento') ?>" class="form-horizontal" method="post"   enctype="multipart/form-data" />
                          <fieldset>

                            <!-- hidden inputs -->
                              <input  type="hidden" id="id_matricula" name="id_matricula" value="<?=$id_matricula?>" />
                              <input type="hidden" id="id_aluno" name="id_aluno" value="<?=$id_aluno?>" />

                            <!-- Formaulário para alterar dados do pagamento -->
                            <div class="control-group">
                                <label class="control-label" for="data_pg"><?= $TEXT['data_pagamento'] ?></label>
                                <div class="controls">
                                    <input type="text" id="data_pg" name="data_pg" class="login input-small" value="<?=$date_default?>" />
                                    <span class="input_comentarios"> (Formato dd/mm/aaaa)</span>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="descricao"><?= $TEXT['descricao'] ?></label>
                                <div class="controls">
                                     <input type="text" id="descricao" name="descricao" class="input-xlarge login" value="Incrição feita por <?= $_SESSION['nome_user'] ?> em <?= date('d/m/Y \à\s H:i:s') ?>" >
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="complemento"><?= $TEXT['obs'] ?></label>
                                <div class="controls">
                                    <input type="text" id="complemento" name="complemento" class="login"  placeholder="Insira alguma observação caso seja necessário" />
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="forma_pg"><?= $TEXT['forma_pg'] ?></label>
                                <div class="controls">
                                    <select id="forma_pg" name="forma_pg" title="<?= $TEXT['forma_pg_legenda'] ?>" required >
                                        <option value="1" selected ></option>
                                        <option value="1" ><?= $TEXT['pg1'] ?></option>
                                        <option value="2" ><?= $TEXT['pg2'] ?></option>
                                        <option value="3" ><?= $TEXT['pg3'] ?></option>
                                        <option value="4" ><?= $TEXT['pg4'] ?></option>
                                        <option value="5" ><?= $TEXT['pg5'] ?></option>
                                        <option value="6" disabled><?= $TEXT['pg6'] ?></option>
                                        <option value="9" disabled><?= $TEXT['pg9'] ?></option>
                                    </select>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                            <div class="control-group">
                                <label class="control-label" for="refa"><?= $TEXT['ref_a'] ?></label>
                                <div class="controls">
                                    <select id="refa" name="refa" title="<?= $TEXT['ref_a_legenda'] ?>" >
                                        <option value="1" selected ><?= $TEXT['ref1'] ?></option>
                                        <option value="2" ><?= $TEXT['ref2'] ?></option>
                                        <option value="3" ><?= $TEXT['ref3'] ?></option>
                    					<option value="4" ><?= $TEXT['ref4'] ?></option>
                    					<option value="9" ><?= $TEXT['ref9'] ?></option>
                                    </select>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

							<div class="control-group">
                                <label class="control-label" for="valor"><?= $TEXT['valor'] ?></label>
                                <div class="controls">
                                    <input type="text" name="valor" class="input-mini" id="valor" value="<?=$valor_default?>" style="text-align: right;" /><span class="input_comentarios"></span>
                                </div> <!-- /controls -->
                            </div> <!-- /control-group -->

                              <div class="control-group">
                                  <label class="control-label" for="input_arquivo"><?= $TEXT['comprovante'] ?></label>
                                  <div class="controls">
                                      <input type="file" id="input_arquivo" name="input_arquivo" />
                                      <p class="input_comentarios"> <?=$TEXT['comprovante_comentario']?></p>
                                  </div> <!-- /controls -->
                              </div>

                              <br>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary"><?= $TEXT['btn_adicionar'] ?></button>
                            </div> <!-- /form-actions -->

                          </fieldset>
                        </form>
                        


                    </div><!-- /widget-content -->

                
				</div><!-- /widget -->
			
            </div> <!-- /span6 -->
	      		      	
	      	<div class="span4">	
	      		
                <div class="widget widget-box">
					
					<div class="widget-header">
	      				<h3><i  class='icon-info-sign' ></i> <?= $TEXT['add_pagamento_info_curso'] ?></h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

                    	<div class="control-group">
                        	<!-- Conteúdo aqui -->

                            <a class='btn btn-block btn-mini icon-user pull-right' href='aluno.php?id=<?= base64_encode($id_aluno) ?>' > <strong> <?= $TEXT['ir_par_ficha'] ?><?= $dados["nome_aluno"] ?></strong></a>
                            <?= fsc($dados["status"]) ?>

                            <div class="contorno-fundo">
                                <ul class="unstyled">
                                    <li></li>
                                    <?php
                                    echo "<li><br />".$TEXT['aluno']."<br /><a class='btn-link' href='aluno.php?id=".base64_encode($id_aluno)."' ><strong>" . $dados["nome_aluno"] ." " . $dados["sobrenome_aluno"] . "</strong></a><li>";
                                    echo "<li><br />".$TEXT['curso']."<br /><strong>" . $dados["nome_curso"] . "</strong><li>";
                                    echo "<li><br />".$TEXT['modulo']."<br /><strong>" . $dados["modulo"] . "</strong><li>";
                                    echo "<li><br />".$TEXT['valor']."<br /><strong>" . $dados["valor_curso"] . "</strong><li>";
									echo "<li><br />".$TEXT['desconto']."<br /><strong>" . $dados["desconto"] . "</strong><li>";

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