<?php 
// definir variáveis da página
$pg_titulo = "Home - Hosana SiS";
$pg_nome = "sistema.sobre.php";
$pg_menu = "sistema";

// codigo a ser executado depois de iniciar a pagina e antes de terminar os includes
// esta função é chamada atomaticamente pelo include_once ('./inc/grupo.topo.php')
function executar () {
}

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');
?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->
<div class="main">
	<div class="main-inner">
        <div class="container">

<div class="hero-unit">
  <img src="./img/hosanasis.png" width="322" height="100" alt=""/>
  
  <p><br />Sistema administrativo do Seminário Hosana para controle de matriculas e histórico escolar dos alunos. Este programa também administra o evento em si, ajudando na atribuição da hospedagem e no controle financeiro.</p>
  <h2>Hosana.SiS <?php include("./inc/versaonumero.php"); ?> </h2>
  <br />
  	<?php include("./inc/versao.php"); ?>
  
</div>
	
	    </div> <!-- /container -->   
	</div> <!-- /main-inner -->
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>