<?php 
// definir variáveis da página
$pg_titulo = "Home - Hosana SiS";
$pg_nome = "home.php";
$pg_menu = "home";



// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');
?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->
<div class="main">

    <div class="main-inner">

        <div class="container">

        <br>

<?php include ("./pagina/home.resumos.php") ?>


        </div>
    </div>

	<div class="main-inner">

	    <div class="container">	
	      
	      <div class="row">
	      	
	      	<div class="span6">
	      		
<?php include ("./pagina/home.matriculas.listar.php") ?>
			
            </div> <!-- /span6 -->
	      		      	
	      	<div class="span6">

<?php include ("./pagina/home.pagamentos.lista.php") ?>
					
		    </div> <!-- /span6 -->
	      	
	      </div> <!-- /row -->

          
          <div class="row">
	      	
	      	<div class="span6">
	      		
<?php include ("./pagina/home.matriculas.listar.proximo.php") ?>
			
            </div> <!-- /span6 -->
	      		      	
	      	<div class="span6">

<?php include ("./pagina/home.pagamentos.lista.proximo.php") ?>
					
		    </div> <!-- /span6 -->
	      	
	      </div>
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>