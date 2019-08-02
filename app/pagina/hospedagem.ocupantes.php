<div class="lista_ocupantes"><ul>

<?php
/**
 * Created by Lisanias
 * Date: 07/07/13
 * Time: 02:47
 * To change this template use File | Settings | File Templates.
 */


/*
 * Selecionar um quarto da lista de quarto para o sexo do aluno
 */
$sql = "SELECT * FROM cama WHERE id_quarto = {$_POST['quarto']}";
$tabela = mysqli_query($con,$sql);


while ($dados = mysqli_fetch_array($tabela)) {
    // ver quantas pessoas estão no quarto para saber quantas vagas ainda tem
    $sql_sub="SELECT *
                FROM matricula
                INNER JOIN alunos
                ON matricula.id_aluno = alunos.id_aluno
                WHERE id_evento =". $_SESSION['evento'] ."
                AND id_cama =".$dados['id_cama']."
                ORDER BY nome
            ";

    $tabela_sub = mysqli_query($con,$sql_sub);
    if ($dados_sub = mysqli_fetch_array($tabela_sub)) {
       echo "<li>{$dados_sub['nome']} {$dados_sub['sobrenome']} <em>({$dados['tipo']} - {$dados['cama']})</em></li>";
    }

}

?>
    </ul>
</div>