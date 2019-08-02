<?php 
// definir variáveis da página
$pg_titulo = "Pendência - Hosana SiS";
$pg_nome = "pendencia_listar_all.php";
$pg_menu = "aluno";

// incluir arquivo de com variáveis iniciais e contantes globais
include_once('./inc/iniciar.php');

// incluir verificação de segurança
include_once('./inc/seguranca.php');

// incluir arquivos de configuração css e scripts e codigo html "head".
include_once ('./inc/head.php');

// incluir menu e mensagens de aviso e alerta
include_once ('./inc/menu_msg.php');



$sql = "SELECT * 
		FROM pendencia 
		INNER JOIN alunos 
			ON pendencia.id_aluno = alunos.id_aluno
		WHERE resolvido = 0";

$consulta = mysqli_query($con,$sql);
$linhas = mysqli_num_rows($consulta);

?>
<div class="main">
    <div class="main-inner">
        <div class="container">


			<div class="row">
				<div class="span12">
					<div class="widget">
						<br>
						<div class="widget-header">
							<h3>Pendencias</h3>
						</div>
						<div class="widget-content" style='border-bottom: 3px #ccc'>	

							
						<?php
							if ( $linhas ) {
								while ( $dados = mysqli_fetch_array($consulta) ) {
						?>
							
							<blockquote style='border-bottom: 10px solid #eee;'>
								<h3><?= $dados['nome'] ?> <?= $dados['sobrenome'] ?></h3>
								<pre style='background: #FFF'><?= $dados['pendencia_txt'] ?></pre>
								<small>
									Adicionada em: 
									<?= date_format(date_create($dados['data_add']), 'd/m/Y H:i') ?> 
									Alterada em: 
									<?= date_format(date_create($dados['data_update']), 'd/m/Y H:i') ?>
									 | Matricula: 
									 <?= $dados['id_matricula'] ?>
									  - Aluno: 
									  <?= $dados['id_aluno'] ?>
								</small>
								
								<div style='margin-top:10px;'>&nbsp;
									
									<a class='btn btn-primary icon-ok' title='Pendencia resolvida' href='aluno.acao.php?atp=", base64_encode('pendencia_resolver'), "&id=", base64_encode($dados['id']),"&id_aluno=", base64_encode($dados['id_aluno']),"'> Finalizar pendência </a>&nbsp;
									
									<a class='btn btn-success icon-eye-open' title='Ver pendência' href='pendencia.edit.php?id=<?= base64_encode($dados['id'])?>'> Ver </a>

								</div>
								<br>
							</blockquote>
							<br />
						<?php
							}

							} else {
						?>

								Nenhuma pendência!

						<?php
						} 
						?>
							
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>

<?php
  include ('./inc/botton.php');
?>