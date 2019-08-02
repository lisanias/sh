<?php

//listar os quartos disponíveis
$sql = "SELECT * FROM quarto WHERE id_local = {$_SESSION['local']}";
$tabela = mysqli_query($con,$sql);

if (!$linhas = mysqli_num_rows($tabela)) {
    echo "Nenhum alojamento adicionado para eventos neste local";
}
else {
    while ($dados = mysqli_fetch_array($tabela)) {
        $sql_sub="SELECT COUNT( * ) AS soma
                FROM matricula
                INNER JOIN cama ON matricula.id_cama = cama.id_cama
                WHERE matricula.id_evento =". $_SESSION['evento'] ."
                AND cama.id_quarto =".$dados['id_quarto']."
            ";
        $tabela_sub = mysqli_query($con,$sql_sub);
        $dados_sub = mysqli_fetch_array($tabela_sub);
        if ($linhas_sub = mysqli_num_rows($tabela_sub)) {

            $ocupantes = $dados_sub['soma'];

            echo "Quarto: ".$dados['quarto']." | Sexo: ".$dados['sexo']." | ".$ocupantes."/".$dados['capacidade']."<br>";
        }
    }
}
?>