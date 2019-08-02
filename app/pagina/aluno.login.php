<?php
/**
 * 
 * Módulo DADOS DO ALUNO 
 * 
 */

$idaluno = base64_decode($_GET["id"]);

$sql = "SELECT * FROM alunos WHERE id_aluno = " . $idaluno;
$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);
?>

<legend xmlns="http://www.w3.org/1999/html">
    <?php echo nome2($dados['nome']." ".$dados['sobrenome']) ?>
</legend>

    <div class="control-group ">
        <label class="control-label" for="inputNome"><?=$TEXT['login']?></label>
        <div class="controls">
            <?= $dados['login'] ?>
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputEndereco"><?=$TEXT['add_em']?></label>
        <div class="controls">
            <?= $dados['data_cadastro'] ?>
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputBairro"><?=$TEXT['ultimo_acesso']?></label>
        <div class="controls">
            <?= $dados['data_ultimoacesso'] ?>
        </div>
    </div><!-- /control-group -->

    <div class="control-group">
        <label class="control-label" for="inputBairro"><?=$TEXT['id_aluno']?></label>
        <div class="controls">
            <?= $dados['id_aluno'] ?>
        </div>
    </div><!-- /control-group -->

<div class="control-group">
    <label class="control-label" for="inputBairro"><?=$TEXT['cpf']?></label>
    <div class="controls">
        <?= $dados['cpf'] ?>
    </div>
</div><!-- /control-group -->

<div class="control-group">
    <div class="controls">
        <a class="btn btn-primary" href="nova.senha.php?id=<?= base64_encode($dados['id_aluno']) ?>">ALterar Senha</a>
    </div> <!-- /controls -->
</div> <!-- /control-group -->

                        