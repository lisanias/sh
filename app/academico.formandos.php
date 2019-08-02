<?php 
// definir variáveis da página
$pg_titulo = "Acadêmico - Hosana SiS";
$pg_nome = "academico.php";
$pg_menu = "academico";

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

            <?php # include ("./pagina/academico.menu.php") ?>

        <div class="main-inner">

        <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span6">

                <?php include ("./pagina/academico.possivel.formandos.php") ?>
			
            </div> <!-- /span6 -->
	      		      	
	      	<div class="span6">

                

		    </div> <!-- /span6 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>