<?php 
// definir variáveis da página
$pg_titulo = "Imprimir - Hosana SiS";
$pg_nome = "print.lista.presenca.php";
$pg_menu = "secretaria";

// codigo a ser executado depois de iniciar a pagina e antes de terminar os includes
// esta função é chamada atomaticamente pelo include_once ('./inc/grupo.topo.php')
function executar () {
}

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

 // registra quem fez a mudança
 Quem::insert($con, 'print', '', 'Lista de presença criada');
?>

<!-- #########     CONTEÚDO PRINCIPAL     ########## -->
<div class="main">

    <div class="main-inner">

        <div class="container">

<?php include ("./pagina/academico.resumos.php") ?>

        </div>
    </div>

	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span6">
            	<form action="./print_pdf.lista.presenca.php" target='_blank' method="post" name="prn_chamada">
                	
                    <div class="control-group">
                        <label class="control-label" for="aula">Aula</label>
                        <div class="controls">
                            <input type="text" name="aula" id="aula">
                        </div> <!-- /controls -->
                    </div> <!-- /control-group -->
                    
                    <div class="control-group">
                        <label class="control-label" for="prof">Professor</label>
                        <div class="controls">
                            <input type="text" name="prof" id="prof">
                        </div> <!-- /controls -->
                    </div> <!-- /control-group -->
                    
                    <div class="control-group">
                        <label class="control-label" for="data">Data</label>
                        <div class="controls">
                            <input type="text" name="data" id="data">
                        </div> <!-- /controls -->
                    </div> <!-- /control-group -->
                    
                    <div class="control-group">
                        <label class="control-label" for="hora">Periodo</label>
                        <div class="controls">
                            <input type="text" name="hora" id="hora"><br>
                            Ex: 10:00 - 11:30
                        </div> <!-- /controls -->
                    </div> <!-- /control-group -->
                    
                    <div class="control-group">
                        <label class="control-label" for="id_curso"><?= $TEXT['curso'] ?></label>
                        <div class="controls">
                            <select name="id_curso" id="id_curso">
                                <?php
                                // Buscar o modulo que o aluno estára fazendo a matricula
                                $sql_curso = "SELECT * FROM cursos;";
                                
                                $tabela_curso = mysqli_query($con,$sql_curso);
                                
                                while ($cursos = mysqli_fetch_array($tabela_curso)) {
                                    $selecionado = ($cursos['id_curso']==$dados['id_curso'])? "Selected": "";
                                    echo "<option value={$cursos['id_curso']} {$selecionado} >{$cursos['id_curso']} - {$cursos['nome_curso']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                    
                    <div class="control-group">
                    	<div class="controls">
                            <input type="submit">
                        </div> <!-- /controls -->
                    </div> <!-- /control-group -->
	
            	</form>
                
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