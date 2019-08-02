<?php
/* 
 * 
 * 
 * */

    // verficar se tem alguma mensagem de erro
    if (isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    if (isset($_SESSION['recoverLink'])) {
        $recoverLink = $_SESSION['recoverLink'];
        unset($_SESSION['recoverLink']);
    }

    // informar o tipo da mensagem de erro para formatação
    // Tipo: alert-success; alert-error; alert-info; " " (sem nada fica amarelo);
    if (isset($_SESSION['msg_tipo'])) {
        $msg_tipo = $_SESSION['msg_tipo'];
        unset($_SESSION['msg_tipo']);
    } else {
        $msg_tipo = "alert-error";
    }


    include 'i_secao.evento.default.php';
    ?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Recuperar Senha</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
	
        <link rel="icon" href="img/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">

        <style>
            body { padding-top: 60px; padding-bottom: 40px; }
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
                        <?php include 'm_top.alunos.php'; ?>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">

            <?php if (isset($msg)) { ?>
            <div class="row">
                <div class="container">
                    <div class="alert <?=$msg_tipo?> fade in" align="center" >
                       <a class="close" data-dismiss="alert">×</a>
                       <?=$msg?>
                     </div>
                </div>
            </div>
            <?php } ?>

            <div class="row">

        	 	<div class="row-fluid" style="background-image:url(img/h48.png); background-position: left center; background-repeat:no-repeat;">
                        <h3 style="padding-left:55px">Link para recuperar a senha</h3>
                </div>
                <div class="row-fluid">

                    <div class="span12">
                        <div class="hero-unit">
                            <div class="well well-small">
                                Link para refazer a senha:<br>
                                <a class='btn btn-primary' title='Criar nova senha' href='<?= base64_decode($_GET['url']) ?>' 
                                    >Refazer senha
                                </a>
                            </div>
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
                        <abbr title="Telefone Celular">Tel:</abbr> (43) 9152-2015 <br />
                        <a href="mailto:pastorlisanias@gmail.com">pastorlisanias@gmail.com</a>
                    </address>
                </div>
            </div>

            <hr>

            <footer>
                <p><img src="img/favicon.png" alt="WebiGSiS" width="24" height="24"> &copy; WebiGSiS 2013 </p>
            </footer>
            
        </div><!--/.container -->
        
        
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