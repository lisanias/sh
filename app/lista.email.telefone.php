<?php

// definir variáveis da página
$pg_titulo = "Telefone e e-mails";
$pg_nome = "lista.email.telefone.php";
$pg_menu = "secretaria";

include_once ('./inc/grupo.topo.php');

$sql = "SELECT id_aluno, nome, sobrenome, email, tcel FROM alunos ORDER BY nome";

$consulta = mysqli_query($con,$sql);
$rows = mysqli_num_rows($consulta);

?>

<div class="container">
                
    <div class="page-header">
        <h1>Lista de alunos <small>— email e telefones</small></h1>
    </div>

    <div style="background-color: #ffffff;">
        <table class="table table-condensed">
            <thead>
                <tr>
                <th>#</th>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Celular</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    if ( $rows ) {
                        $i = 0;
                        while ( $alunos = mysqli_fetch_array($consulta) ) {
                            $i++;
                ?>

                    <tr>
                        <td>
                            <?= str_pad($i , 4 , '0' , STR_PAD_LEFT) ?>
                        </td>
                        <td>
                            <?= str_pad($alunos['id_aluno'] , 4 , '0' , STR_PAD_LEFT)?>
                        </td>
                        <td>
                            <?= $alunos['nome'] ?> <?= $alunos['sobrenome'] ?>
                        </td>
                        <td>
                            <?= $alunos['email'] ?>
                        </td>
                        <td>
                            <?= $alunos['tcel'] ?>
                        </td>
                    </tr>

                <?php
                        }
                    } else {
                echo "Nenhuma pendência!";
                } 
                ?>
            </tbody>
        </table>
    </div>
</div> <!-- / Container -->

<?php
$consulta->close();
include ('./inc/botton.php');
?>

