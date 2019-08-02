<?php
/**
 * LISTAR PAGAMENTOS
 */

// ver se tem alguma ordem definida
if (isset($_GET['ordem'])){
	
	switch ($_GET['ordem']) {
		case 'sobrenome':
			$campo_ordem = "SUBSTRING_INDEX(alunos.sobrenome,  ' ', -1 ) ASC";
			break;
		case 'nome':
			$campo_ordem = "alunos.nome ASC";
			break;
		case 'forma':
			$campo_ordem = "forma_pg ASC, data_add_pg DESC";
			break;
		case 'dataZA':
			$campo_ordem = "data_add_pg ASC";
			break;
		default:
			$campo_ordem = "data_add_pg DESC";
			break;
	}
} else {
	$campo_ordem = "data_add_pg DESC";
}

$tipo = (isset($_GET['tipo'])?$_GET['tipo']:3);
$data = (isset($_GET['data'])?$_GET['data']:date('Y-m-d'));

// permissão FINANCEIRO - id 3 
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar a base de dados e pegar ultimas incrições feitas 
// para mostrar em uma tabela
$sql = "SELECT 
		pagamento.data_pg AS data_pg,
		pagamento.data_add_pg AS data_add_pg,
		pagamento.valor AS valor, 
		pagamento.status AS status,
		pagamento.comprovante AS comprovante,
		pagamento.descricao AS descricao,
		pagamento.ref_a AS ref_a,
		pagamento.forma_pg AS forma_pg,
		pagamento.id_pagamento AS id_pagamento,
		pagamento.complemento AS complemento,
		cursos.nome_curso AS nome_curso,
		cursos.apelido AS apelido,
		cursos.abreviatura AS abreviatura,
		alunos.nome AS nome,
		alunos.sobrenome AS sobrenome,
		SUBSTRING_INDEX(alunos.sobrenome,  ' ', -1 ) AS ultimonome,
		alunos.cidade as cidade,
		alunos.igreja as igreja,
		alunos.id_aluno AS aluno_id,
		SUBSTRING(alunos.cep, 1, 3) AS cep_ini3,
		matricula.id_evento AS id_evento
	FROM pagamento
	INNER JOIN matricula ON pagamento.id_matricula = matricula.id_matricula
	INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
	INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
	INNER JOIN cursos ON modulo.id_curso = cursos.id_curso
	WHERE matricula.id_evento = {$_SESSION['evento']} 
		AND pagamento.forma_pg = {$tipo} 
		AND pagamento.data_pg = '{$data}'
	ORDER BY {$campo_ordem}, alunos.nome";

echo $sql;

$tabela = mysqli_query($con,$sql);

?>
<div>
	<form>
		
	</form>
</div>
<div class="widget widget-table action-table">
						
    <div class="widget-header">
        <i class="icon-barcode"></i>
        <h3>Pagamentos</h3>
    </div> <!-- /widget-header -->
    <div id="div-popover" class="hide">
        Data Pagamento<br>
        Data que enviou comprovante:<br>
        Referente à:<br>
        Forma de Pagamento:<br>
        Descrição:<br>
        Complemento:<br>
    </div>
    <div class="widget-content">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr style='height:36px;'>
                    <th></th>
                    <th style='width:80px;'>
                    	Data<br />
                    	<a href="pagamento.php?ordem=dataAZ" class="btn icon-sort-by-alphabet"></a>
                    	<a href="pagamento.php?ordem=dataZA" class="btn icon-sort-by-alphabet-alt"></a>
                    </th>
                    <th>Curso</th>
                    <th>
                    	Nome<br />
                    	<a href="pagamento.php?ordem=nome" class="btn icon-sort-by-alphabet" title="Listar pelo ultimo nome"></a>                    	
                    </th>
                    <th>
                    	Sobrenome<br />
                    	<a href="pagamento.php?ordem=sobrenome" class="btn icon-sort-by-alphabet" title="Listar pelo primeiro nome"></a>
                    </th>
                    <th>Descrição/Complento</th>
                    <th>Valor</th>
                    <th>
	                    Forma Pg <br />
	                    <a href="pagamento.php?ordem=forma" class="btn icon-sort-by-alphabet"></a>
                    </th>
					<th>Status</th>
                    <th class="td-actions" width='84px' ></th>
<?php
if (!$linhas = mysqli_num_rows($tabela)) { 
	echo "<th class='td-actions'>Nenhum pagamento efetuado para este modulo</th>"; 
}
	else { "<th class='td-actions' width='40px' >".$linhas."</th>"; 
?>
                    
                </tr>
            </thead>
            <tbody>
<?php 

    $i= 0;
    $t = 0;
	while ($dados = mysqli_fetch_array($tabela)) {
		$i = $i+1;
		$t += $dados['valor'];
        echo "<tr style='height:54px;'>
		<td>". $i . "</td>
		<td>". date('d/m/Y', strtotime($dados['data_pg'])) ."</td>
		<td><abbr title='".$dados['nome_curso']."'>".$dados['abreviatura']."</abbr></td>
		<td>". $dados['nome']."</td>
		<td><abbr title='". $dados['nome']." ".$dados['sobrenome']."'>". $dados['ultimonome'] ."</td>
		<td><small>". $dados['descricao'] ."<br>". $dados['complemento'] ."</small></td>
		<td>" . number_format($dados['valor'],2,",",".") . "</td>
		<td>". function_pg_forma($dados['forma_pg']) . "</td>
		<td>". function_pg_status_icon($dados['status']) . "</td>
		<td>
			<a class='btn btn-primary' href='pagamento.ver.comprovante.php?idpagamento=". base64_encode($dados['id_pagamento']) ."' title='Ver este comprovante de pagamento' ><i class='icon-signin'></i></ a>&nbsp;</a>
			<a class='btn btn-primary' href='aluno.php?id=". base64_encode($dados['aluno_id']) ."' title='Ver a ficha do aluno' ><i class='icon-list-alt'></i></ a>&nbsp;</a>
		</td>
		</tr>";
		
	}

	echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>', number_format($t,2,",","."), '</td></tr>';
}
?>
            </tbody>
        </table>	
    
    </div> <!-- /widget-content -->
    
</div> <!-- /widget -->
<?php } // permissao FINANCEIRO ?>