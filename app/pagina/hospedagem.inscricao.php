<?php
// echo "id aluno:".$idaluno;
// pesquisa sql
$sql = "SELECT *
	FROM matricula
	INNER JOIN modulo
		ON matricula.id_modulo = modulo.id_modulo
	INNER JOIN cursos
		ON modulo.id_curso = cursos.id_curso
	INNER JOIN evento
		ON modulo.id_evento = evento.id_evento
	WHERE id_aluno = " . $id_aluno . " and matricula.id_evento = " . $id_evento;

$consulta = mysqli_query($con,$sql);

while ($dados = mysqli_fetch_array($consulta)) {

    $status = $dados['status'];

	//codificar o id para passar no link
	$codid = base64_encode($id_aluno);

    $id_matricula = $dados['id_matricula'];
    ?>

    <br>Status: <?= fsce($dados['status']) ?>
        
    <br><span class="clearfix"></span>Hospedagem: <?= hospedagem_cor($dados['hospedagem']) ?>
    
    <!-- Botão para alterar hospedagem -->
    <ul class="nav pull-right">
        <li class="dropdown" title="Alterar hospedagem">

            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon-edit"></i> Alterar
            </a>

            <ul class="dropdown-menu">
                <li>
                    <a href="./aluno.acao.php?atp=<?= base64_encode("hospedagem_alterar") ?>&aux=1&id=<?= base64_encode($dados['id_matricula']) ?>" title="Este aluno vai dormir nos alojamentos do SH?" >
                        Sim
                    </a>
                </li>
                <li>
                    <a href="./aluno.acao.php?atp=<?= base64_encode("hospedagem_alterar") ?>&aux=0&id=<?= base64_encode($dados['id_matricula']) ?>" title="Este aluno NÃO vai dormir no alojamento do SH?">
                        Não
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- /Botão para alterar hospedagem -->

    <span class="clearfix"></span>

    <?php
	echo "<br>Data: <span style='font-weight:bold; color:#0088cc'>" . $dados['descricao'] . "</span>";
    echo "<br>Curso: " . $dados['nome_curso'];
	echo "<br>Módulo: " . $dados['modulo'];
	echo "<br>Data de Matrícula: " . date('d/m/Y', strtotime($dados['data_matricula']));
    echo "<br>Obs: " . $dados['obs'];

	$sqlsoma = " SELECT SUM(valor) AS total FROM pagamento WHERE id_matricula = ". $id_matricula;

	$consultasoma = mysqli_query($con,$sqlsoma);
	$dadossoma = mysqli_fetch_array($consultasoma);

	$valor_restante = $dados['valor']-$dadossoma['total']-$dados['desconto'];

    if ($valor_restante == 0) {
        echo "<div class='label label-success' style='padding: 3px 10px; margin-top: 10px;'><h2>Pagamento OK</h2>
              Confirme os rebibos</div>";
    } else {
        echo "<div class='alert-error' style='padding: 3px 10px; margin-top: 10px;'><span class='destaque'>O aluno ainda não acertou o pagamento na tesouraria!</span></div>";
    }


	//mostrar o status do aluno
    //echo "<br>Status: " . fsce($dados['status']);
    //echo "<br>Hospedagem: " . hospedagem_cor($dados['hospedagem']);

?>

<?php
}
?>



