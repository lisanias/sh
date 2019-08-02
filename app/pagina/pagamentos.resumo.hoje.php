<?php
/**
 * LISTAR PAGAMENTOS
 */

// permissão FINANCEIRO - id 3 
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

$datahoje = date('Y-m-d');

// conectar a base de dados e pegar ultimas incrições feitas 
// para mostrar em uma tabela
$sql = "SELECT 
			COUNT( pagamento.valor ) AS qt, 
			SUM( pagamento.valor ) AS soma, 
			pagamento.forma_pg AS fpg
		FROM pagamento
		INNER JOIN matricula 
			ON pagamento.id_matricula = matricula.id_matricula
		WHERE matricula.id_evento = {$_SESSION['evento']} and pagamento.data_pg = '{$datahoje}'
		GROUP BY pagamento.forma_pg";
	
$tabela = mysqli_query($con,$sql);

?>

<div class="widget widget-table action-table">
						
    <div class="widget-header">
        <i class="icon-barcode"></i>
        <h3>Resumos - <?php echo date('d-m-Y', strtotime($datahoje)) ?></h3>
    </div> <!-- /widget-header -->
    <div id="div-popover" class="hide">
        <br>
        :<br>
        Valor:<br>
    </div>
    <div class="widget-content">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Forma de Pagamento</th>
                    <th>Quantidade de Transações</th>
                    <th>Valor Total</th>
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

	$totaldia = 0;

	while ($dados = mysqli_fetch_array($tabela)) {
		echo "<tr>
			<td>".function_pg_forma($dados['fpg'])."</td>
			<td class='right'>".$dados['qt']."</td>
			<td class='right'>".number_format($dados['soma'], 2, ',', '.')."</td>
		</tr>";

		$totaldia = $totaldia + $dados['soma'];
		
	}

	echo "<tr>
			<td>TOTAL</td>
			<td>". $modulodescricao ."</td>
			<td class='right'>". number_format($totaldia, 2, ',', '.') ."</td>
		</tr>";
}
?>
            </tbody>
        </table>	
    
    </div> <!-- /widget-content -->
    
</div> <!-- /widget -->
<?php } // permissao FINANCEIRO ?>