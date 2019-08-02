<?php
/**
 * Criado por: Lisanias Loback
 * Procurar por alunos.
 * Parte do programa hosana.sis by webig.sis
 */

// definir variáveis da página
$pg_titulo = "Procurar Alunos - Hosana SiS";
$pg_nome = "aluno.procurar.php";
$pg_menu = "aluno";

// Incluir informações iniciais agrupadas
include_once ('./inc/grupo.topo.php');

if (isset($_POST['procurar_aluno'])) {

    //pegar variavel para procurar
    $procurar = $_POST['procurar_aluno'];

    // trocar acentos
    $substituir = array(
        "a","e","i","o","u",
        "à","á","â","ã","ä",
        "è","é","ê","ë",
        "ì","í","î","ï",
        "ò","ó","ô","õ","ö",
        "ù","ú","û","ü",
        "A","E","I","O","U",
        "À","Á","Â","Ã","Ä",
        "È","É","Ê","Ë",
        "Ì","Í","Î",
        "Ò","Ó","Ô","Õ","Ö",
        "Ù","Ú","Û","Ü",
        "ç","Ç","ñ","Ñ");
    $procurar =  str_replace($substituir,"_", $procurar);
    $procurar = str_replace(" ","%",$procurar);

    //$sql = "SELECT * FROM alunos WHERE nome like  '%".$procurar."%'  or sobrenome like  '%".$procurar."%'";
    $sql = "SELECT * FROM alunos WHERE concat(nome,' ', sobrenome) like  '%".$procurar."%'";


    $tabela = mysqli_query($con,$sql);

}
?>

<div class="main">

    <div class="main-inner">

        <div class="container">

            <div class="row">

                <div class="span8">

                    <div class="widget widget-table action-table">

                        <div class="widget-header">
                            <i class="icon-search"></i>
                            <h3><?=$TEXT['procurar_alunos_titulo']?></h3>
                        </div> <!-- /widget-header -->

                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cidade</th>
                                    <th>Igreja</th>
                                    <th class="td-actions"></th>
                                </tr>
                                </thead>
                                <tbody>

<?php
    while ($dados = mysqli_fetch_array($tabela)) {
    echo "<tr><td>". $dados['nome'] ." ". $dados['sobrenome'] ."</td><td>".$dados['cidade']."</td><td>".$dados['igreja']."</td><td><a href='aluno.php?id=". base64_encode($dados['id_aluno'])."' class='btn btn-mini btn-primary'><i class='icon-user'></i></a></td></tr>";
    }
echo mysqli_error($con);
?>
                                </tbody>
                            </table>
                        </div> <!-- /widget-content -->

                    </div> <!-- /widget -->

                </div> <!-- /span8 -->


                <div class="span4">


                    <div class="widget widget-box">

                        <div class="widget-header">
                            <h3><i class="icon-info-sign"></i> Informações da pesquisa</h3>
                        </div> <!-- /widget-header -->

                        <div class="widget-content">

                            Palavra pesquisada: <strong><?=$_POST['procurar_aluno']?></strong><br />
                            Numero de de resultados:<strong>
                            <?php
                                if ($linhas = mysqli_num_rows($tabela)) {
                                    echo "<th class='td-actions'>".$linhas."</th>";
                                }
                            ?>
                            </strong><br ?>

                        </div> <!-- /widget-content -->

                    </div> <!-- /widget-box -->

                </div> <!-- /span4 -->

            </div> <!-- /row -->

        </div> <!-- /container -->

    </div> <!-- /main-inner -->

</div> <!-- /main -->








<?php
include ('./inc/botton.php');
?>
