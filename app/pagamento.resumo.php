<?php 
// definir variáveis da página
$pg_titulo = "Pagamentos - Hosana SiS";
$pg_nome = "pagamento.php";
$pg_menu = "financeiro";

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

<?php // include ("./pagina/home.resumos.php") ?>

        </div>
    </div>

	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">
	      		
<?php include ("./pagina/pagamentos.resumo.php") ?>
			
            </div> <!-- /span12 -->
	      	
	      </div> <!-- /row -->

	      <div class="row">
	      	
	      	<div class="span6">
	      		
<?php include ("./pagina/pagamentos.resumo.diaini.php") ?>
			
            </div> <!-- /span6 -->

            <div class="span6">
	      		
<?php include ("./pagina/pagamentos.resumo.dia2.php") ?>
			
            </div> <!-- /span6 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>