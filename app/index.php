<?php 
// definir variáveis da página
$pg_titulo = "Hosana SiS";
$pg_nome = "index.php";

// incluir arquivos de configuração css e scripts e codigo html "head".
include ('./inc/head.php');
include ('./inc/iniciar.php');

echo "<body>";

// menu do topo e inicio do codigo html
include ('./inc/navbar.php');
?>
<!-- Conteúdo da Página -->

<div class="main">
  <div class="main-inner">
	<div class="container">
	  <div class="row">
		<div class="span6" style="padding-top: 3em;"><!-- coluna da esquerda -->
			<div class="alert alert-info">
              <div class="widget account-container">
                <div class="widget-header">
                    <i class="icon-aluno"></i>
                    <h3>Área dos alunos</h3>
                </div> <!-- /widget-header -->
                <div class="widget-content">
                	<p><br /><br />Se você é aluno do Hosana e quer entrar no painel administrativo, click no botão em baixo:<br /><br />&nbsp;</p>
                    <a href="http://msm.dyndns.info/hosana/aluno.login.php" class="btn span3 btn-primary"> Área dos alunos </a><br />&nbsp;
                </div> <!-- /widget-content -->
              </div><!-- /widget account-container -->
                <br />&nbsp;
            </div><!-- /alert alert-info -->
        </div><!-- /span6 -->
        <div class="span6" style="padding-top: 3em;"><!-- coluna da direita -->
			<div class="alert alert-success" >
              <div class="widget account-container">
                <div class="widget-header">
                    <i class="icon-cog"></i>
                    <h3>Área Administrativa</h3>
                </div> <!-- /widget-header -->
                <div class="widget-content">
                	<p><br /><br />Entre na aplicativo Hosana.SiS para entrar no administrativo do Seminário Hosana.<br /><br />&nbsp;</p>
                    <a href="./login.php" class="btn span3 btn-primary btn-success"> Login sos Sistema Administrativo </a><br />&nbsp;
                </div> <!-- /widget-content -->
              </div><!-- /widget account-container -->
                <br />&nbsp;
            </div><!-- /alert alert-success -->
        </div><!-- /span6 -->
      </div><!-- /row -->
    </div><!-- /container -->
  </div><!-- /main-inner -->
</div><!-- /main -->





<?php
    include ('./inc/botton.php');
?>
