<?php
/* 
 * Confirmação da inscrição
 * 
 * 
 * */

include 'i_secao.evento.default.php';

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
        <link rel="stylesheet" href="css/main.css">
        <style>
            body {
                padding-bottom: 40px;
            }
        </style>
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

 	<div class="container">    

        <?php include 'm_top.alunos.php'; ?>
        
        <div class="row">
            <div class="row-fluid" style="background-image:url(img/logohosana_icon.svg); background-position: left center; background-repeat:no-repeat; background-size: 48px 48px">
                <h3 style="padding-left:55px">Seminario Hosana</h3>
            </div><br />
            
                <div class="span12">
                <!-- Conteúdo principal -->
                <div class="alert alert-info">
                    <h3>Inscrição realizada com sucesso</h3>
                    <p style="text-transform:uppercase; color:#000; text-align:center;"><strong><?=$input_nome?></strong></p>
                    <p>Obrigado por se inscrever no do Seminário Hosana<br /> <strong><?= $curso_nome ?></strong>.</p>
                    <p>
                        <?php $situacao_code = 2;
                        if ($situacao_code == 2) {
                            echo "Parabéns, agora você é um aluno do Seminário Hosana e certamente você vai ser muito abençoado por Deus nessa jornada. Agora, acesse a área do aluno, entre com seu usuário e senha, e faça o pagamento clicando em “pagar com cartão”.";
                        } else {
                            echo 'e encontra-se em <strong>lista de espera</strong>. Se surgirem vagas, a secretaria do SH irá entrar em contato, informando-o de como proceder. Não faça nenhum depósito até que receba instruções da secretaria, disponibilizando sua vaga e liberando sua inscrição.';
                        }
                        ?></p>
                    <p>Em caso de dúvida, contatar a secretaria do hosana nos endereços indicados no rodapé desta página.</p>
                </div>       
            </div>  
        </div>

        <div class="row">
            <div class="span3"></div>
            <div class="span6">
                <div class="hero-unit">
                    <div class="row-fluid text-center">
                        <img src="img/logohosana.svg" width="150" height="150">
                        <h3>Área do Aluno</h3>
                    </div>
                    
                        <?php
                        include 'aluno.form.login.php';                 
                        ?>
                </div>
                <div class="row-fluid">
                </div>
            </div>
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
