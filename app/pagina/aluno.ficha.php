<?php
/**
 * Módulo DADOS DO ALUNO
 * 
 */
$idaluno = base64_decode($_GET["id"]);
$idaluno_code = $_GET["id"];

$sql = "SELECT * FROM alunos WHERE id_aluno = " . $idaluno;
$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);
?>

<legend>
    </i> <?php echo nome2($dados['nome']." ".$dados['sobrenome']) ?>
</legend>

<div class="contorno-fundo dpesoalcss">
	<table class="table">

<?php

echo "<tr><td class='tdd'>NOME:</td><td>" . $dados['nome'] . " " . $dados['sobrenome'] . "</td></tr>";
echo "<tr><td class='tdd'>E-MAIL:</td><td>" . $dados['email'] . "</td></tr>";
echo "<tr><td class='tdd'>LOGIN:</td><td>" . $dados['login'] . "</td></tr>";
echo "<tr><td class='tdd'>TEL. RESIDENCIAL:</td><td>" . $dados['tres'] . "</td></tr>";
echo "<tr><td class='tdd'>TEL. CELULAR:</td><td>" . $dados['tcel'] . "</td></tr>";
echo "<tr><td class='tdd'>ENDEREÇO:</td><td>" . $dados['endereco'] ." ". $dados['complemento'] ."<br>". $dados['bairro'] ."<br>". $dados['cep'] ." - ". $dados['cidade'] ." - ". $dados['uf'] ."</td></tr>";
echo "<tr><td class='tdd'>DATA NASCIMENTO:</td><td>" . implode('/',array_reverse(explode('-',$dados['dnas']))) . "</td></tr>";
echo "<tr><td class='tdd'>".$TEXT['cpf']."</td><td>" . $dados['cpf'] . "</td></tr>";
echo "<tr><td class='tdd'>ESTADO CIVIL:</td><td>" . ec($dados['estado_civil']). "</td></tr>";
echo "<tr><td class='tdd'>".$TEXT['sexo']."</td><td>" . sexo($dados['sexo']). "</td></tr>";
echo "<tr><td class='tdd'>IGREJA:</td><td>" . $dados['igreja'] . "</td></tr>";
echo "<tr><td class='tdd'>OBS</td><td>" . $dados['obs'] . "</td></tr>";
echo "</table>";

?>



	
</div>
                        