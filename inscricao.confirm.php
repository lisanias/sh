<?php
/* 
 * Confirmação da inscrição
 * 
 * 
 * */

include 'i_secao.evento.default.php';

if (!isset($_SESSION['inscricao_situacao_cod'])){
	$_SESSION['msg'] = "Preencha os campos com seus dados. <br>(Err. inscricao.confirm.001)";
	echo header('Location: inscricao.php');
    die();
}

// Pegar variáveis passadas da página anterior
$input_nome = $_SESSION['input_nome'];
$input_sobrenome = $_SESSION['input_sobrenome'];
$curso_nome = $_SESSION['curso'];
$modulo = $_SESSION['modulo'];
$valor_modulo = $_SESSION['valor_modulo'];
$valor_pagar = $_SESSION['valor_pagar'];
$pagar_texto = $_SESSION['valor_pagar_txt'];
$situacao_code = $_SESSION['inscricao_situacao_cod'];
$data_comprovante = $_SESSION['data_comprovante'];
$igreja = $_SESSION['input_igreja'];
$inputLogin = $_SESSION['input_login'];
$inputEmail = $_SESSION['input_email'];
$evento_atual_nome = $_SESSION["evento_atual_nome"];
$hospedagem_txt = ($_SESSION['input_hospedagem'] == 1)?"Sim":"Não";

$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
		<link rel="icon" href="img/favicon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
        <!-- mascaras de entradas dos campos de formulário -->
		<script type="text/javascript" src="js/jquery/jquery-1.3.2.js"></script>
        <script src="js/jquery/jquery.inputmascara.js" type="text/javascript"></script>

        <script>
            function vermsg($msg)
            {
                if ( $msg.length > 0 ) {
                $('#myModal').modal('show');
                }
            }
        </script>

    </head>
    <body onload="vermsg('<?=$msg?>')">
        <!--[if lt IE 7]>
            <p class="chromeframe">Você está usando um <strong>navegador desatualizado</strong>. Por vavor <a href="http://browsehappy.com/">atualize seu navegador</a> ou <a href="http://www.google.com/chromeframe/?redirect=true">instale o Google Chrome</a> para uma utilização mais eficiente do sistema.</p>
        <![endif]-->

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <?= LOGO ?>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="#" title="selecione outro evento..."><?= $evento_atual_nome ?></a></li>
                            <li><a href="./aluno.login.php" title="Entrar no sistema">Login</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

 	<div class="container">            
            <div class="row">
                <div class="row-fluid" style="background-image:url(img/h48.png); background-position: left center; background-repeat:no-repeat;">
                	<h3 style="padding-left:55px">Seminario Hosana</h3>
                </div><br />
                <div class="row-fluid">
                    <div class="span6">
                      <!-- Conteúdo principal -->
                        <div class="alert alert-info">
                            <h3>Inscrição realizada com sucesso</h3>
                            <p style="text-transform:uppercase; color:#000; text-align:center;"><strong><?=$input_nome?></strong></p>
                            <p>Obrigado por se inscrever no do Seminário Hosana<br /> <strong><?= $curso_nome ?></strong>.</p>
                            
                                <?php 
                                if ($situacao_code == 2) {
                                    echo "<p>Estaremos aguardando o <strong>pagamento e o envio</strong> do respectivo comprovante, <em><strong>exclusivamente pela área do aluno do sistema on-line do Seminário Hosana</strong></em>. Para isso, acesse a área do aluno, entre com seu usuário e senha, e envie o comprovante de pagamento, lembrando que só serão válidos os comprovantes enviados dessa forma, portanto não envie nenhum comprovante por e-mail.</p><p>Se o comprovante não for enviado até <strong> $data_comprovante</strong>, sua inscrição será cancelada e a vaga liberada para outro aluno, e só poderá ser ativada novamente pela secretaria se, quando solicitado, ainda houver vagas.";
                                } else {
                                    echo 'e encontra-se em <strong>lista de espera</strong>. Se surgirem vagas, a secretaria do SH irá entrar em contato, informando-o de como proceder. Não faça nenhum depósito até que receba instruções da secretaria, disponibilizando sua vaga e liberando sua inscrição.';
                                }
                                ?></p>

                            <p>Em caso de dúvida, contatar a secretaria do hosana nos endereços indicados no rodapé desta página.</p>
						</div>
                        
                        <div class="alert">
                            <h4>
                            	<?= $input_nome ?> <?= $input_sobrenome ?>
                            </h4>
                            <p>
                            	<br>
                                Curso: <?= $curso_nome ?><br>
                                Modulo: <?= $modulo ?><br>
                                Pagar e enviar comprovante até: <?= $data_comprovante ?><br>
                                Hospedagem: <?= $hospedagem_txt ?><br>
                                E-mail: <?= $inputEmail ?><br>
                            </p>
                            <p>
                            	
                            </p>
                        </div>
                    </div>    
                    <div class="span6">
                        <div class="row-fluid">
                            <img src="img/h150.png"><br />
                            <h3>Área do Aluno</h3>
                                <?php
                                include 'aluno.form.login.php';                 
                                ?>
                        </div>
                        <div class="row-fluid">
                            <a href="inscricao.php" class="btn btn-large btn-primary">Nova Inscrição</a>
                        </div>
                    </div>
                </div><!-- Div com duas colunas informativa | opcoes -->
            </div><!-- Div Row 1 -->
            <!-- Linha com colunas para informações auxiliares  -->
            <div class="row">
                <div class="span4">
                    <address>
                      <i class="icon-home"></i><strong> Escritório Administrativo</strong><br>
                      Rua Caraíbas, nº 424<br>
                      Vila Casoni - 86026-560 - Londrina - PR<br>
                    </address>
                </div>
                <div class="span4">
                    <address>
                      <i class="icon-info-sign"></i><strong> Contato</strong><br>
                      <abbr title="Phone">Tel:</abbr> (43) 3325 1424<br>
                      <a href="mailto:secretaria@seminariohosana.com.br">secretaria@seminariohosana.com.br</a><br>
                    </address>
                </div>
                <div class="span4">
                    <address>
                    	<i class="icon-question-sign"></i><strong> Suporte Técnico</strong><br>
                    	<abbr title="Telefone Celular">Tel:</abbr> (43) 9152-2015 <br />
                        <a href="mailto:pastorlisanias@gmail.com">pastorlisanias@gmail.com</a>
                    </address>
                </div>
            </div>
            <hr>
            <footer>
                <p><img src="img/favicon.png" alt="WebiGSiS" width="24" height="24"> &copy; WebiGSiS 2013 </p>
            </footer>
        </div> <!-- /container -->

        
        <!-- MODAL -->
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
        <script src="js/vendor/jquery-1.9.1.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-3218464-2']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>

<!-- Mesagem por cima da pagina quando necessário -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Atenção</h3>
  </div>
  <div class="modal-body">
    <p><?=$msg?></p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
  </div>
</div>


    </body>
</html>
