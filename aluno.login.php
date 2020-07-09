<?php
/*
 *
 * Ficha de inscrição para novos alunos e alunos ainda não cadastrado.
 * para ser usado por todos os alunos no primeiro modulo de uso do sistema;
 * formulário para todos os novos alunos
 */
error_reporting(E_ALL) ;
include 'i_secao.evento.default.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Área de Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
	
        <link rel="icon" href="img/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/main.css">

        <style>
            body { padding-top: 0; padding-bottom: 40px; }
        </style>
        
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- mascaras de entradas dos campos de formulário -->
	    <script type="text/javascript" src="js/jquery/jquery-1.3.2.js"></script>
        <!--<script src="js/jquery/jquery.inputmascara.js" type="text/javascript"></script>-->
        <script src="js/jquery/jquery.mask.min.js" type="text/javascript"></script>

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
                
        <div class="container">
        
        <?php include 'm_top.alunos.php'; ?> 
            
            <div class="row">
                    <div class="row-fluid" style="background-image:url(img/h48.png); background-position: left center; background-repeat:no-repeat;">
                            <h3 style="padding-left:55px">Área do Aluno</h3>
                    </div>
                    <div class="row-fluid">

                        <!-- Coluna Formulario da esquerda -->
                        <div class="span4">
                            <div class="hero-unit">
                                <div class="well well-small"><strong>Já é ou foi aluno?</strong> Faça aqui seu login e confirme sua presença no próximo módulo.</div>
                                <?php include 'aluno.form.login.php'; ?>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="hero-unit">
                                <strong>Ainda não é aluno?</strong> Faça seu cadastro e se increva em um dos cursos do SH.
                                <br /><br />
                                <div style="text-align:center;">
                                    <a href="inscricao.php" class="btn btn-large btn-primary">Criar seu cadastro</a><br>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <div style="text-align:center;">
                                	<h3 class="text-info">Data do Próximo Módulo:</br>
                                    <?= date('d', strtotime($dados['data_ini']) ) ?> 
                                    a <?= date('d', strtotime($dados['data_fim']) ) ?> 
                                    de <?= nomeDoMes(date('m', strtotime($dados['data_ini']) ) ) ?> 
                                    de <?= date('Y', strtotime($dados['data_fim']) ) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class=" ">
                                <legend><i class="icon-info-sign" ></i> Informações</legend>
                                
                                <li>A inscrição só estará efetivada após o pagamento da valor minimo (inscrição).</li>
                                <li>O valor da inscrição faz parte do valor total do módulo.</li>
                                <li>Em caso de não comparecimento na data do evento sem aviso prévio de 7 dias úteis, o aluno perde o valor da inscrição já pago.</li>

                                <?php 
                               
                                ?>


                                <span class="clearfix"></span>
                            </div>
                        </div>
                    </div>
            </div>
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
                        <abbr title="Telefone Celular">Tel:</abbr> (43) 99152-2015 <br />
                        <a href="mailto:pastorlisanias@gmail.com">pastorlisanias@gmail.com</a>
                    </address>
                </div>
            </div>

            <hr>

            <footer>
                <p><img src="img/favicon.png" alt="WebiGSiS" width="24" height="24"> 
                    &copy; WebiGSiS 2013 - 2019 | <?= exec('git log --pretty="%h" -n1 HEAD') ?>
                </p>
            </footer>
            
        </div>
        
        
        <!-- MODAL -->
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
        <script src="js/vendor/jquery-1.9.1.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        
        <!-- Mesagem de aviso que aperece por cima da pagina -->
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
