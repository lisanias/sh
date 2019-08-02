<?php
/**
 * LISTAR PAGAMENTOS 
 * 
 */

// permissão FINANCEIRO - id 3 
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar a base de dados e pegar ultimas incrições feitas 
// para mostrar em uma tabela
$sql_evento = "SELECT * FROM evento WHERE data_ini > NOW()";
$tabela_evento = mysqli_query($con,$sql_evento);

if (!$linhas_evento = mysqli_num_rows($tabela_evento)) { 
	echo "Ainda não existem inscrições para o próximo evento."; 
}
	else {
		while ($dados_evento = mysqli_fetch_array($tabela_evento)) {
			
			if ($dados_evento['id_evento'] <> $_SESSION['evento']) {

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
		matricula.id_evento AS id_evento
	FROM pagamento
	INNER JOIN matricula ON pagamento.id_matricula = matricula.id_matricula
	INNER JOIN alunos ON matricula.id_aluno = alunos.id_aluno
	INNER JOIN modulo ON matricula.id_modulo = modulo.id_modulo
	INNER JOIN cursos ON modulo.id_curso = cursos.id_curso
	WHERE matricula.id_evento = ". $dados_evento['id_evento'] ."
	ORDER BY data_add_pg DESC";
	
$tabela = mysqli_query($con,$sql);

?>

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
    
<?php
if (!$linhas = mysqli_num_rows($tabela)) { 
	echo "<div style='text-align:center'>Nenhum pagamento efetuado os próximos módulos</div>"; 
}
	else { "<th class='td-actions' width='40px' >".$linhas."</th>"; 
?>   
     
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Curso</th>
                    <th>Nome</th>
                    <th>Valor</th>
					<th>Status</th>
                    <th class="td-actions" width='38px' ></th>

                    
                </tr>
            </thead>
            <tbody>
<?php 

    $i= 0;
	while ($dados = mysqli_fetch_array($tabela) and $i < 10) {
		$i = $i+1;
        echo "<tr>
		<td>".date('d/m/Y', strtotime($dados['data_pg']))."</td>
		<td><abbr title='".$dados['nome_curso']."'>".$dados['abreviatura']."</abbr></td>
		<td><abbr title='".$dados['nome']." ".$dados['sobrenome']."'>".nome2($dados['nome']." ".$dados['sobrenome'])."</td>
		<td>" . number_format($dados['valor'],2,",",".") . "</td>
		<td>" . function_pg_status_icon($dados['status']) . "</td>
		<td><a class='btn btn-primary' href='pagamento.ver.comprovante.php?idpagamento=". base64_encode($dados['id_pagamento']) ."' title='Ver este comprovante de pagamento' ><i class='icon-signin'></i></ a>&nbsp;</a></td>
		</tr>";
		
	}
}
?>
            </tbody>
        </table>	


    </div> <!-- /widget-content -->
    
</div> <!-- /widget -->
<?php
				}
			}
		}
?>
<?php } // permissao FINANCEIRO ?>