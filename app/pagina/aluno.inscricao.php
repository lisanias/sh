<?php
// echo "id aluno:".$idaluno;


while ($dados = mysqli_fetch_array($consulta)) {

    $status = $dados['status'];

	//codificar o id para passar no link
	$codid = base64_encode($idaluno);

    $id_matricula = $dados['id_matricula'];
    ?>

    <h2 style='text-align: center'><?= $dados['descricao'] ?></h2>
    <br>Status: <?= fsce($dados['status']) ?>

    
    <!-- Botão para alterar status -->
    <ul class="nav pull-right">
        <li class="dropdown" title="Alterar status">

            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon-edit"></i> Alterar
            </a>

            <ul class="dropdown-menu">
                <?php if ($status<>1) { ?>
                    <li>
                        <a href="./aluno.acao.php?atp=<?= base64_encode("matricula_alterar_status") ?>&aux=1&id=<?= base64_encode($id_matricula) ?>" title="Aluno em lista de espera, estamos sem vagas!" >
                            Lista de espera
                        </a>
                    </li>
                <?php } ?>
                <?php if ($status<>2) { ?>
                    <li><a href="./aluno.acao.php?atp=<?= base64_encode("matricula_alterar_status") ?>&aux=2&id=<?= base64_encode($id_matricula) ?>" title="Alerar para 'Pré-inscrição', para o aluno poder enviar o comprovante de pagamento">Aguardar Pagamento</a></li>
                <?php } ?>
                <?php if ($status<>3) { ?>
                    <li><a href="./aluno.acao.php?atp=<?= base64_encode("matricula_alterar_status") ?>&aux=3&id=<?= base64_encode($id_matricula) ?>" title="Alterar para 'Comprovante Enviao', quando o aluno já enviou o comprovante mas ainda não foi verificado">Comprovante Enviado</a></li>
                <?php } ?>

                <?php if ($status<>4) { ?>
                    <li><a href="./aluno.acao.php?atp=<?= base64_encode("matricula_alterar_status") ?>&aux=4&id=<?= base64_encode($id_matricula) ?>" title="Inscrição fonfirmada pelo Staff">Inscrição Confirmado</a></li>
                <?php } ?>

                <?php if ($status<>5) { ?>
                    <li><a href="./aluno.acao.php?atp=<?= base64_encode("matricula_alterar_status") ?>&aux=5&id=<?= base64_encode($id_matricula) ?>" title="Para confirmar a participação do aluno no módulo">Compareceu</a></li>
                <?php } ?>

                <?php if ($status<>'0') { ?>
                    <li><a href="./aluno.acao.php?atp=<?= base64_encode("matricula_alterar_status") ?>&aux=0&id=<?= base64_encode($id_matricula) ?>" title="Cancelar a inscrição...">Cancelar</a></li>
                <?php } ?>

                <?php if ($status<>6) { ?>
                    <li><a href="./aluno.acao.php?atp=<?= base64_encode("matricula_alterar_status") ?>&aux=6&id=<?= base64_encode($id_matricula) ?>" title="Modulo realizado e concluído a distância">Modulo a distância</a></li>
                <?php } ?>

                <?php if ($status<>7) { ?>
                    <li><a href="./aluno.acao.php?atp=<?= base64_encode("matricula_alterar_status") ?>&aux=7&id=<?= base64_encode($id_matricula) ?>" title="O aluno foi aprovado no Módulo">Modulo Concluído</a></li>
                <?php } ?>
            </ul>
        </li>
    </ul>
	<!-- /Botão para alterar status -->
    
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

    // menu inscrição
	
        // codificar id da matricula
        $codid_matricula = base64_encode($dados['id_matricula']);
		
		// botão para impressao
        echo "<a target='_new' class='btn btn-primary icon-print pull-right' title='Imprimir informações de matricula e histórico de pagamentos' href='print_pdf.recibo.aluno.php?id={$codid_matricula}' ></a>";
        
        // botão para atribuir o quarto e a cama
        if ($dados['hospedagem'] == 1 ) {
			if (!$dados['id_cama'] > 0) {
				echo "<a class='btn btn-primary icon-key pull-right' href='hospedagem.atribuir.1.php?id={$codid_matricula}' title='Alojar o aluno em um quarto' ></a>";
			} else {
				echo "Quarto: ";
				quarto_nome($dados['id_cama']);
			}
		}

        // botão para adicionar inscrição
        echo "<a class='btn btn-primary icon-plus-sign pull-right' title='{$TEXT['add_incricao']}' href='inscricao.add.php?id={$codid}&var={$idaluno}' ></a>";


        // botão para editar inscrição
        echo "<a class='btn btn-primary icon-edit pull-right' title='Alterar Inscrição' href='inscricao.edit.php?id={$codid_matricula}' ></a>";


    // fim do menu inscrição
    echo "<br>";
    
    $texto_data_comprovante = '';
    if ($status < 3){
	$texto_data_comprovante = "<br>Enviar comprovante até: " . date('d/m/Y', strtotime($dados['data_comprovante']));
    }

    echo "<br>Curso: " . $dados['nome_curso'];
	echo "<br>Módulo: " . $dados['modulo'];
	echo "<br>Data de Matrícula: " . date('d/m/Y', strtotime($dados['data_matricula']));
	echo $texto_data_comprovante;
	echo "<br style='text-align: right;'>Valor do Módulo: " . number_format($dados['valor'],2,',','.');
	echo "<br style='text-align: right;'>Descontos: " . number_format($dados['desconto'],2,',','.');
    echo "<br>Obs: " . $dados['obs'];


	$sqlsoma = " SELECT SUM(valor) AS total FROM pagamento WHERE id_matricula = ". $id_matricula. " and status>1";

	$consultasoma = mysqli_query($con,$sqlsoma);
	$dadossoma = mysqli_fetch_array($consultasoma);

	echo "<br>Valor pago: " . number_format($dadossoma['total'],2,',','.');

    $valor_restante = $dados['valor']-$dadossoma['total']-$dados['desconto'];

    echo "";

    if ($valor_restante == 0) {
        echo "<div class='label label-success' style='padding: 3px 10px; margin-top: 10px;'>
				<h2>Pagamento OK</h2>
				Confirme os rebibos
			  </div>";
    } elseif ($valor_restante < 0 ) {
        echo "<div class='label label-important' style='padding: 3px 10px; margin-top: 10px;'>
				<h2>Verificar pagamento</h2>
				O aluno pagou ".number_format(abs($valor_restante),2,',','.')." a mais.
			  </div>";
    } else {
        echo "<a title=".$TEXT['add_pagamento_title']." href='pagamento.add.php?id=".base64_encode('00000'.$id_matricula)."&valor=".$valor_restante."'  >
				<div class='label label-warning' style='padding: 3px 10px; margin-top: 10px;'>
				<h2>Falta Pagar: " . number_format($valor_restante,2,',','.')."</h2>
			  </div></a>";
    }

	// colocar botão compareceu bem grande para agilizar o processo na data do evento
	$dataini = strtotime($dados['data_ini'])-345600;
	$datafim = strtotime($dados['data_fim']);
	if ($dataini < time () and $datafim > time() and $dados['status'] < 5 ) {
	echo "<br /><a href='./aluno.acao.php?atp=".base64_encode('matricula_alterar_status')."&aux=5&id=".base64_encode($id_matricula)."' class='btn btn-info btn-large' title='Depois de atender o aluno clique aqui.'>Compareceu</a>";
	
	}
	
	// colar opção de aluno ter ou não a apostila. 
	// aparece apenas na data do evento
	/* if($dados['status'] == 5) {
		echo "<hr />";
		if($dados['apostila']==1) {
			echo "<div class='label label-info' style='padding: 3px 10px; margin-top: 10px;'>Apostila Entregue</div>";
		}
		else {
			echo "<div class='label label-info' style='padding: 3px 10px; margin-top: 10px;'><a href='./aluno.acao.php?atp=".base64_encode('entregar_apostila_ao_aluno')."&atp1=entregar_apostila-01&id_aluno=".base64_encode($idaluno)."&id=".base64_encode($id_matricula)."' class='btn btn-info btn-large' title='Entregar apostila.'>Entregar apostila</a></div>";
		 }
	} */
    
    // Exibit o id da matricula
    echo '<div class="pull-right"><br>Matricula: <span class="badge">', $id_matricula, "</span></div>";

    // Botao para imprimir declaracao de presença
    echo "<span class='clearfix'></span><br><div>
            <a target='_new' class='btn btn-primary icon-print pull-right' title='Imprimir declaração de academico' href='print_pdf.declaracao.presenca.php?id={$codid_matricula}' > Declaração presença </a>
            <a target='_new' class='btn btn-primary icon-print pull-left' title='Imprimir declaração de academico' href='print_pdf.declaracao.cursando.php?id={$codid_matricula}' > Declaração de acadêmico </a>
        </div>";

     // Botao para pendencias
    echo "<span class='clearfix'></span><br><div>
            <a target='_new' class='btn btn-warning icon-exclamation-sign' title='Inserir alguma pendência deste aluno' href='pendencia.add.php?id={$codid_matricula}' > Adicionar pendência </a>
        </div>";

}
?>



