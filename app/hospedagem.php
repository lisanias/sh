<?php 
// definir variáveis da página
$pg_titulo = "Home - Hosana SiS";
$pg_nome = "hospedagem.php";
$pg_menu = "hospedagem";

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

<?php include ("./pagina/hospedagem.resumos.php") ?>

        </div>
    </div>

	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span9">

<!-- LISTAR ALUNOS nao CONFIRMADOS, MASCULINOS E FEMININOS POR ORDEM DE CIDADE - IGREJA - ALFABÉTICO -->
<?php
// permissão secretaria - id 2 
if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar a base de dados e alunos masculinos e femininos
// que ainda não pagaram mas vão ficar alojados para listar e eventualmente atribuir quartos
$sql = "SELECT * 
        FROM matricula 
        INNER JOIN modulo 
            ON matricula.id_modulo = modulo.id_modulo 
        INNER JOIN cursos 
            ON modulo.id_curso = cursos.id_curso 
        INNER JOIN alunos 
            ON matricula.id_aluno = alunos.id_aluno
        WHERE 
            matricula.id_evento = ".$_SESSION['evento']."
                AND matricula.status = 2 
                AND matricula.hospedagem = 1
        ORDER BY 
            alunos.cidade ASC, 
            alunos.igreja ASC,
            alunos.nome ASC
        "; 
        
$tabela = mysqli_query($con,$sql);

?>

<div class="widget widget-table action-table">
                        
    <div class="widget-header">
        <i class="icon-male"></i>
        <h3>ALUNOS que ainda não confirmaram com o pagamento...</h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Igreja</th>
                    <th>Curso</th>
                    <th>Ação</th>
<?php
if ($linhas = mysqli_num_rows($tabela)) {
    echo "<th class='td-actions'>".$linhas."</th>";
?>
                    
                </tr>
            </thead>
            <tbody>
<?php 
    $n=0;
    while ($dados = mysqli_fetch_array($tabela)) {
        echo "<tr>";
        $n=$n+1;
        echo    "<td>".$n."</td>";
        echo    "<td>".nome2($dados['nome']." ".$dados['sobrenome'])."</td>";
        echo    "<td>".$dados['cidade']."</td>";
        echo    "<td>".$dados['igreja']."</td>";
        echo    "<td>".$dados['abreviatura']."</td>";
        echo    "<td width='90px' align='center'>";
        if (!$dados['id_cama']>0) {
            echo "<a class='btn btn-primary' href='hospedagem.atribuir.1.php?id=".base64_encode($dados['id_matricula'])."' title='Alojar o aluno em um quarto' ><i class='icon-key'></i></a> &nbsp";
            echo "<a class='btn btn-primary' href='aluno.php?id=".base64_encode($dados['id_aluno'])."' title='Ir para ficha do aluno' ><i class='icon-signin'></i></a> &nbsp;";
        } else {
            
            quarto_nome($dados['id_cama']);
            
        }
        echo    "</td>";
        echo    "<td>".fsc($dados['status'])."</td>";
        echo "</tr>";
    }
}
?>
            </tbody>
        </table>
        
    </div> <!-- /widget-content -->

</div> <!-- /widget -->


	      		
<!-- LISTAR ALUNOS CONFIRMADOS, MASCULINOS E FEMININOS POR ORDEM DE CIDADE - IGREJA - ALFABÉTICO -->
<?php
// permissão secretaria - id 2 
//if ($_SESSION['permissao'][2]>0) { // inicia viasualização do modulo

// conectar a base de dados e alunos masculinos (M) 
// pegar os dados dos alunos confirmados para lista-los na hospedagem
$sql = "SELECT * 
		FROM matricula 
		INNER JOIN modulo 
			ON matricula.id_modulo = modulo.id_modulo 
		INNER JOIN cursos 
			ON modulo.id_curso = cursos.id_curso 
		INNER JOIN alunos 
			ON matricula.id_aluno = alunos.id_aluno
		WHERE 
			matricula.id_evento = ".$_SESSION['evento']."
				AND alunos.sexo = 'M' 
				AND matricula.status > 2 
				AND matricula.hospedagem = 1
		ORDER BY 
			alunos.cidade ASC, 
			alunos.igreja ASC,
			alunos.nome ASC
 		"; 
		
$tabela = mysqli_query($con,$sql);

?>

<div class="widget widget-table action-table">
						
    <div class="widget-header">
        <i class="icon-male"></i>
        <h3>ALUNOS Confirmados (masculino)</h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Igreja</th>
                    <th>Curso</th>
                    <th>Ação</th>
<?php
if ($linhas = mysqli_num_rows($tabela)) {
	echo "<th class='td-actions'>".$linhas."</th>";
?>
                    
                </tr>
            </thead>
            <tbody>
<?php 
    $n=0;
	while ($dados = mysqli_fetch_array($tabela)) {
		echo "<tr>";
        $n=$n+1;
        echo 	"<td>".$n."</td>";
        echo 	"<td>".nome2($dados['nome']." ".$dados['sobrenome'])."</td>";
		echo 	"<td>".$dados['cidade']."</td>";
		echo 	"<td>".$dados['igreja']."</td>";
		echo 	"<td>".$dados['abreviatura']."</td>";
		echo 	"<td width='90px' align='center'>";
		if (!$dados['id_cama']>0) {
		    echo "<a class='btn btn-primary' href='hospedagem.atribuir.1.php?id=".base64_encode($dados['id_matricula'])."' title='Alojar o aluno em um quarto' ><i class='icon-key'></i></a> &nbsp";
		    echo "<a class='btn btn-primary' href='aluno.php?id=".base64_encode($dados['id_aluno'])."' title='Ir para ficha do aluno' ><i class='icon-signin'></i></a> &nbsp;";
        } else {
			
			quarto_nome($dados['id_cama']);
			
		}
		echo    "</td>";
		echo 	"<td>".fsc($dados['status'])."</td>";
		echo "</tr>";
	}
}
?>
            </tbody>
        </table>
        
    </div> <!-- /widget-content -->

</div> <!-- /widget -->

<?php
// conectar a base de dados e alunos (F)
// para mostrar em uma tabela
    $sql = "SELECT *
		FROM matricula
		INNER JOIN modulo
			ON matricula.id_modulo = modulo.id_modulo
		INNER JOIN cursos
			ON modulo.id_curso = cursos.id_curso
		INNER JOIN alunos
			ON matricula.id_aluno = alunos.id_aluno
		WHERE
			matricula.id_evento = ".$_SESSION['evento']." 
				AND alunos.sexo = 'F' 
				AND matricula.status > 2
				AND matricula.hospedagem = 1
		ORDER BY
			alunos.cidade ASC,
			alunos.igreja ASC,
			alunos.nome ASC
 		";

    $tabela = mysqli_query($con,$sql);

    ?>

    <div class="widget widget-table action-table">

        <div class="widget-header">
            <i class="icon-female"></i>
            <h3>ALUNAS Confirmadas (feminino)</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Igreja</th>
                    <th>Curso</th>
                    <th>Ação</th>
                    <?php
                    if ($linhas = mysqli_num_rows($tabela)) {
                    echo "<th class='td-actions'>".$linhas."</th>";
                    ?>

                </tr>
                </thead>
                <tbody>
                <?php
                $n=0;
                while ($dados = mysqli_fetch_array($tabela)) {
                    if ($dados['id_cama'] > 0) {
                        $desabilitado = "desabled";
                    }
                    echo "<tr>";
                    $n=$n+1;
                    echo 	"<td>".$n."</td>";
                    echo 	"<td>".nome2($dados['nome']." ".$dados['sobrenome'])."</td>";
                    echo 	"<td>".$dados['cidade']."</td>";
                    echo 	"<td>".$dados['igreja']."</td>";
                    echo 	"<td>".$dados['abreviatura']."</td>";
                    echo 	"<td width='90px'>";
                    if (!$dados['id_cama']>0) {		
                        #echo    "<a class='btn btn-primary' href='hospedagem.atribuir.1.php?id=".base64_encode($dados['id_matricula'])."' title='Alojar o aluno em um quarto' ><i class='icon-key'></i></ a>&nbsp;";
			echo 	"<a class='btn btn-primary' href='hospedagem.atribuir.1.php?id=".base64_encode($dados['id_matricula'])."' title='Alojar o aluno em um quarto' ><i class='icon-key'></i></a> &nbsp";
			echo 	"<a class='btn btn-primary' href='aluno.php?id=".base64_encode($dados['id_aluno'])."' title='Ir para ficha do aluno' ><i class='icon-signin'></i></a> &nbsp;";			
                    } else {
						
						quarto_nome($dados['id_cama']);
						
					}
                    echo    "</td>";
                    echo 	"<td>".fsc($dados['status'])."</td>";
					echo "</tr>";
                }
                }
                ?>
                </tbody>
            </table>

        </div> <!-- /widget-content -->

    </div> <!-- /widget -->


    <?php
               // conectar a base de dados e alunos
               // verificar se tem alunos que não colocaram nenhum sexo!!!
               $sql = "SELECT *
               FROM matricula
				   INNER JOIN modulo
					 ON matricula.id_modulo = modulo.id_modulo
				   INNER JOIN cursos
					 ON modulo.id_curso = cursos.id_curso
				   INNER JOIN alunos
					 ON matricula.id_aluno = alunos.id_aluno
               WHERE
				   matricula.id_evento = ".$_SESSION['evento']." 
					AND alunos.sexo <> 'M' 
					AND alunos.sexo <> 'F' 
					AND matricula.status >= 3
					AND matricula.hospedagem = 1
               ORDER BY
				   alunos.cidade ASC,
				   alunos.igreja ASC,
				   alunos.nome ASC
               ";

               $tabela = mysqli_query($con,$sql);

               ?>

    <div class="widget widget-table action-table">

        <div class="widget-header">
            <i class="icon-th-list"></i>
            <h3>Alunos que não definiram o sexo!</h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Igreja</th>
                    <th>Curso</th>
                    <th>Ação</th>
                    <?php
                    if ($linhas = mysqli_num_rows($tabela)) {
                    echo "<th class='td-actions'>".$linhas."</th>";
                    ?>

                </tr>
                </thead>
                <tbody>
                <?php
                $n=0;
                while ($dados = mysqli_fetch_array($tabela)) {
                    echo "<tr>";
                    $n=$n+1;
                    echo 	"<td>".$n."</td>";
                    echo 	"<td>".nome2($dados['nome']." ".$dados['sobrenome'])."</td>";
                    echo 	"<td>".$dados['cidade']."</td>";
                    echo 	"<td>".$dados['igreja']."</td>";
                    echo 	"<td>".$dados['abreviatura']."</td>";
                    echo 	"<td width='40px'><a class='btn btn-primary' href='hospedagem.atribuir.1.php?id=".base64_encode($dados['id_matricula'])."' title='Alojar o aluno em um quarto' ><i class='icon-key'></i></ a>&nbsp;</td>";
					echo 	"<td>".fsc($dados['status'])."</td>";
					echo "</tr>";
                }
                }
                ?>
                </tbody>
            </table>

        </div> <!-- /widget-content -->

    </div> <!-- /widget -->




<?php } //trmina a vialização do modulo


else { echo mysqli_error($con);  } ?>

			
            </div> <!-- /span9 -->
	      		      	
	      	<div class="span3">

            <?php include ("./pagina/hospedagem.quartos.lista.php"); ?>
					
		    </div> <!-- /span3 -->
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
<!-- /########     /contúdo principal     ########## -->

<?php
  include ('./inc/botton.php');
?>