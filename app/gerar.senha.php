<!doctype html>
<html lang="pt">
<head>
<meta charset="utf-8">
<title>Hosana Sis - Gerar Senhas</title>

<?php
# função para gerar senhas aleatoriamente
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
// Caracteres de cada tipo
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
$simb = '!@#$%*-';

// Variáveis internas
$retorno = '';
$caracteres = '';

// Agrupamos todos os caracteres que poderão ser utilizados
$caracteres .= $lmin;
if ($maiusculas) $caracteres .= $lmai;
if ($numeros) $caracteres .= $num;
if ($simbolos) $caracteres .= $simb;

// Calculamos o total de caracteres possíveis
$len = strlen($caracteres);

for ($n = 1; $n <= $tamanho; $n++) {
// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
$rand = mt_rand(1, $len);
// Concatenamos um dos caracteres na variável $retorno
$retorno .= $caracteres[$rand-1];
}

return $retorno;
}

?>

</head>

<body>
<h2>Gerar Senhas</h2>

<form action="gerar.senha.php" method="post">
	<p>Senha: <input type="text" id='senha' name="senha"><br /></p>
    
    <p>Gerar senha aleatória <br />
      <label>
        <input type="radio" name="aleatoria" value="0" id="aleatoria_0">
        Não</label>
      <br>
      <label>
        <input type="radio" name="aleatoria" value="1" id="aleatoria_1">
        Sim</label>
      <br>
    </p>
  <input type="submit">
</form>

<?php 
# definir senha para usuários do sistema
if (isset($_POST['senha'])) { 
	if ($_POST['aleatoria'] == 1) {
		$senha = gerasenha();
	}
	else {
		$senha = $_POST['senha'];
	}
	echo "Senha: ".$senha."<br />";
	echo "Senha para Sistema Administrativo: ".sha1('qyW2rPk59iI1'.$senha);
	echo "<br />";
	echo "Senha para o aluno (área do aluno): ".sha1('AjFqu8J8vC'.$senha);
}
 
?>

</body>
</html>