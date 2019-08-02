<?php
/**
 * Área do aluno:
 * 
 * Ver os cursos que fez, em que curso está matriculado.
 * Mandar comprovante de pagamento da iscrição e mensalidades.
 * Fazer incrição para cursos, para quem ja esta cadastrado.
 */
ini_set("display_errors", 1);
error_reporting(E_ALL) ;

include("aluno.seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("i_funcoes.php");
include("./app/lang/pt-br.php");

$matricula_id = base64_decode($_GET['id']);

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
                        <p><a href="aluno.logout.php"><i class="icon-off"></i> SAIR</a> - <?= $_SESSION["id_aluno"]; ?>
                    </div>
                </div>
                <div class="row-fluid" style="padding-top: 25px;">
                <!-- Conteúdo da página a partir daqui -->
                	
                    <?php
						// verficar vagas
						$sql = "SELECT * FROM  matricula WHERE id_matricula = ". $matricula_id ;
						if(!$result = $con->query($sql)){
							die('Há um erro ao executar a pesquisa na base de dados [' . $con->error . ']');
						}
						while ($dados = mysqli_fetch_array($result)) {
							if($dados['id_aluno'] <> $_SESSION['id_aluno']){
								echo "HÁ UM ERRO COM A INSCRIÇÃO E O ALUNO! Contacte a secretaria do SH";
							}
							$data_vencimento = implode('/',array_reverse(explode('-',trim($dados['data_comprovante']))));
							if($dados['status']==1){
								$titulo = "<div class='alert alert-error' style='text-align:center;'>Inscrição em lista de espera!</div>";
								$mainmsg = "<br /><h4>{$_SESSION['nome']} {$_SESSION['sobrenome']},</h4>
									<p>Obrigado por fazer a sua pré inscrição.<br /></p>
									<p>Infelizmente, no momento, não há vagas disponiveis para o próximo modúlo e sua inscrição está em uma lista despera.<br />
									Qualquer dúvida, entre em contato com a secretaria do Hosana por telefone ou e-mail e verifique a situação das vagas.</p>
									
									<p style='color:red; font-weight:bold; padding:20px 0;'>ATENÇÃO: NÃO FAÇA O PAGAMENTO DA INSCRIÇÃO SEM A CONFIRMAÇÃO DA SUA VAGA!</p>
									
									<P>CONTATOS:<br>
									Tel: (43) 3325-1424<br>
									E-mail: secretaria@seminariohosana.com.br</p>
									<p style='font-weight: bold;'>ATT.<br> Equipe do Hosana</p>";
							} else {
								$titulo = "<div class='alert alert-success' style='text-align:center;'>Inscrição realizada com sucesso!</div>";
								$mainmsg = "
									<h4>{$_SESSION['nome']} {$_SESSION['sobrenome']},</h4>
									<p>Sua inscrição foi realizada com sucesso. Tendo alguma duvida, poderá entrar em contato com a secretaria do SH. Você tem até o dia {$data_vencimento} para fazer o depósito que confirmará sua isncrição. Se o depósito não for realizado até essa data a sua incrição será cancelada.</p>
									<br />
									<h4>Conta para depósito de inscrição prévia e parcelas:</h4>
									<p><span style='color:red; font-weight:bold'>BANCO BRADESCO</span><br />
									Agência: <strong>0053-1</strong> C/C: <strong>121513-2</strong></p>
									<br />
									<div class='alert alert-info'>Ressaltamos que para a confirmação da inscrição, será necessário o pagamento e o envio do comprovante até o dia {$data_vencimento}. Caso contrário a sua inscrição será cancelada.<br />
									Ocorrendo o cancelamento, se desejar fazer nova inscrição deverá verificar no site ou na secretaria do Hosana a disponibilidade de vagas.</div>
									<p><br />ATT.<br /> Equipe do Hosana</p>";
							}								
						}
						
						
					?>
                    
                    
                    
                    <div class="widget ">
                	
                    <div class="widget-header">
	      				
	      				<h3><?=$titulo?></h3>
	  				</div> <!-- /widget-header -->

					<div class="widget-content">

						<?=$mainmsg?>
                        
                        <br /><a href="./aluno.home.php" class="btn btn-primary btn-large" >Continuar</a>
                    
                    </div><!-- /widget-content -->

                
				</div><!-- /widget -->
                    
                    
                <!-- /COnteúdo -->
            	</div> 
            </div>
        </div>
        
        
        <!-- RODAPÉ E MODAL -->
        <div class="main-footer container">
        	<div class="row">
                <hr>
                <footer>
                    <?= BOTTON_A ?>
                </footer>
            </div>
        </div>
        

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