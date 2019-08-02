<div>	<!-- este botão fica mesmo no caso de ter matricula no modulo padão atual, pois o aluno pode
			querer fazer matricula para o próximo modulo -->
	    <a class='btn btn-primary icon-plus-sign pull-right' title="<?= $TEXT['add_pagamento_title'] ?>" href='pagamento.add.php?id=<?= base64_encode('00000'.$id_matricula) ?>&valor=<?= $valor_restante ?>'  >
			<strong> <?= $TEXT['add_pagamento'] ?></strong>
	    </a><br />&nbsp;
</div>
<table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?= strtoupper($TEXT['data']) ?></th>
                    <th><?= strtoupper($TEXT['valor']) ?></th>
                    <th><?= strtoupper($TEXT['status']) ?></th>
                    <th><?= strtoupper($TEXT['acao']) ?></th>
                </tr>
<?php

$sql = "SELECT *,
	matricula.status AS status_matricula,
	pagamento.status AS status_pagamento
		FROM pagamento 
		INNER JOIN matricula
			ON pagamento.id_matricula = matricula.id_matricula
		where 
                pagamento.id_matricula = ". $id_matricula;

$consulta = mysqli_query($con,$sql);

while ($dados = mysqli_fetch_array($consulta)) {
	echo "
	<tr>
        <td style='text-align: center'>". date('d/m/Y', strtotime( $dados['data_pg'])) ."</td>
        <td style='text-align: right;'>". number_format($dados['valor'],2,',','.') ."</td>
        <td>
            ".function_pg_status_icon($dados['status_pagamento'])."
        </td>
        <td width='20px;'>
            <a href='pagamento.ver.comprovante.php?idpagamento=". base64_encode($dados['id_pagamento'])."' class='btn btn-mini btn-primary' title='".$TEXT['ver_pagamento']."'><i class='icon-share'></i></a>
			<br / >
			<a target='_new' class='btn btn-mini btn-primary' title='Imprimir recibo' href='print_pdf.recibo.pagamento.php?id=".base64_encode($dados['id_pagamento'])."' ><i class='icon-print'></i></a>
            
        </td>
	</tr>";
}

?>
</table>