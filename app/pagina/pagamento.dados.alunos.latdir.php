Status: <?= function_pg_status_icon($dados["status"]) ?>  <?= function_pg_status($dados["status"]) ?><br /><br />
<?php 
echo "<a class='btn pull-right btn-danger icon-remove' href='./aluno.acao.php?idpagamento=". base64_encode($dados['id_pagamento'])."&atp=".base64_encode('apagar_pagamento')."&idaluno=".base64_encode($id_aluno)."' title='". $TEXT['del_pagamento']."' > Apagar </a>";
?>
<a class='btn btn-primary icon-edit pull-right' href='pagamento.editar.comprovante.php?id=<?= base64_encode($id_pagamento) ?>' > Alterar</a>
<a class='btn btn-primary icon-user pull-right' href='aluno.php?id=<?= base64_encode($id_aluno) ?>' title='Ir para ficha do <?= $dados["nome"] ?>' >&nbsp;&nbsp;Ficha </a>
<?php 
   echo "<a target='_new' class='btn btn-mini btn-primary' title='Imprimir recibo' href='print_pdf.recibo.pagamento.php?id=".base64_encode($dados['id_pagamento'])."' ><i class='icon-print'></i></a>";
?>


<div class="contorno-fundo">
    <ul class="unstyled">
        <li></li>
        <?php
        echo "<li><br />Aluno:<br /><a class='btn-link' href='aluno.php?id=".base64_encode($id_aluno)."' ><strong>" . $dados["nome"] ." " . $dados["sobrenome"] . "</strong></a><li>";
        echo "<li><br />Descrição:<br /><strong>" . $dados["nome_curso"] . "</strong><li>";
        echo "<li><br />Data pagamento:<br /><strong>" . implode('/',array_reverse(explode('-',$dados['data_pg']))) . "</strong><li>";
        echo "<li><br />Envio do Comprovante:<br /> Data - <strong>" . date('d/m/Y', strtotime($dados['data_add_pg'])) . "</strong><br /> Hora - <strong>" . date('H:m', strtotime($dados['data_add_pg'])) . "</strong><li>";
        echo "<li><br />Descrição:<br /><strong>" . $dados["descricao"] . "</strong><li>";
        echo "<li><br />Complemento:<br /><strong>" . $dados["complemento"] . "</strong><li>";
        echo "<li><br />Forma de pagamento:<br /><strong>" . function_pg_forma($dados["forma_pg"]) . "</strong><li>";
        echo "<li><br />Referente a:<br /><strong>" . function_pg_ref($dados["ref_a"]) . "</strong><li>";
        echo "<li><br />Valor:<br /><strong>" . $dados["valor"] . "</strong><li>";
        echo "<li><br />Status:<br /><strong>". function_pg_status($dados["status"]) . "</strong><li>";

        ?>

    </ul>
</div>