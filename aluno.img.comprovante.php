<?php
/*
 * 
 * Área do aluno:
 * Ver os cursos que fez, em que curso está matriculado.
 * Mandar comprovante de pagamento da iscrição e mensalidades.
 * Fazer incrição para cursos, para quem ja esta cadastrado.
 * 
 */
ini_set("display_errors", 1);
error_reporting(E_ALL) ;

include("aluno.seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("i_funcoes.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="Área do aluno, onde acompanha os modulos feitos, pagamentos, etc...">
        <meta name="viewport" content="width=device-width">
        <!--[if IE]><link rel="shortcut icon" href="img/favicon.ico"><![endif]-->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="icon" href="img/favicon.png">
        
        
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>        
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- mascaras de entradas dos campos de formulário -->
		<script src="js/jquery/jquery.inputmascara.js" type="text/javascript"></script>
        
        <script type="text/javascript" src="js/jquery/jquery-1.3.2.js"></script>
        <script>
            function vermsg($msg)
            {
                if ( $msg.length > 0 ) {
                $('#myModal').modal('show');
                }
            };
            
        </script>
<script type="text/javascript" src="js/jquery/jquery-1.3.2.js"></script>

        <style type="text/css">
			dl.dl-horizontal dt {width:100px;}
			dl.dl-horizontal dd { padding-left: 0}
		</style>
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
            <div class="row">
                <div class="row-fluid" style="background-image:url(img/h48.png); background-position: left center; background-repeat:no-repeat;">
                	<div class="span8" style="height:48px;">
                        <div style="padding-left:55px; padding-top:7px; font-size:1.5em;">Oi <?= $_SESSION["nome"]; ?></div>
                        <div style="padding-left:55px; font-size:0.7em">BEM-VINDO AO SISTEMA HOSANA.SIS (by WebiG.SiS).</div>
                    </div>
                    <div class="span4" style="text-align:right; font-size:0.8em; line-height:1em;">
                    	<small>NOME:</small> <strong><?=  $_SESSION["nome"]. " " . $_SESSION["sobrenome"] ; ?></strong><br>
                        <small>Ultimo acesso em:</small><strong> <?= date("d/m/Y H:i", strtotime($_SESSION['ultimo_acesso'])); ?></strong><br>
                        <p><a href="aluno.logout.php"><i class="icon-off"></i> SAIR</a>
                    </div>
                </div>
                <div class="row-fluid" style="padding-top: 25px;">
                	<div class="span8">
                    	<div class="control-group" style="text-align: center;">
                            <img src="<?= $_GET['linkimg'] ?>"<br/>
                        </div>
                    </div>
                    <div class="span4">
                    	<div class="control-group">
                        	<!-- Conteúdo aqui -->

                                <legend>
                                    <i  class='icon-picture' ></i>Comprovante de Pagamento
                                </legend>

                            <div class="contorno-fundo">
                                    <ul class="unstyled">
                                        <li></li>
                                        <?php
                                        echo "<li><br />Data pagamento:<br /><strong>" . $_GET["datapg"] . "</strong><li>";
                                        echo "<li><br />Descrição:<br /><strong>" . $_GET["descricao"] . "</strong><li>";
                                        echo "<li><br />Forma de pagamento:<br /><strong>" . $_GET["formapg"] . "</strong><li>";
                                        echo "<li><br />Referente a:<br /><strong>" . $_GET["ref_a"] . "</strong><li>";
                                        echo "<li><br />Valor:<br /><strong>" . $_GET["valor"] . "</strong><li>";
                                        echo "<li><br />Status:<br /><strong>" . $_GET["status"] . "</strong><li>";
                                        ?>

                                    </ul>
                            </div>
                            <div>
                                <a href="aluno.home.php" class='btn btn-success' >Voltar</a>
                            </div>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
        <div class="main-footer container">
        	<div class="row">
                <hr>
                <footer>
                    <?= BOTTON_A ?>
                </footer>
            </div>
        </div>
        
        
        <!-- MODAL -->
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
        <script src="js/vendor/jquery-1.9.1.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        
        <!-- Mensagem de aviso aos usuário tipo MODAL -->
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