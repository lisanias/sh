<ul class="nav">
    <?php
    /**if(isset($status)){
      if($status == 'on'){
        echo '<li><a href="">On Line</a></li>';
      } else {
        echo '<li>Off Line</li>';
      }
    }*/

    if(isset($_SESSION["usuario"])){
	?>
    <!--<li><a href="aluno.home.php" title="Área dos Alunos">Home</a></li>
    <li><a href="#" title="selecione outro evento..."><?= $_SESSION["evento_atual_nome"] ?></a></li>
    <li><a href="reinscricao.php" title="Faça a sua inscrição">Inscrição</a></li>-->
    <?php
		} else {
	?>
    <li><a href="index.html" title="Login na área dos alunos.">Home</a></li>
    <!--<li><a href="#" title="selecione outro evento..."><?= $_SESSION["evento_atual_nome"] ?></a></li>-->
    <li><a href="inscricao.php" title="Faça a sua inscrição">Inscrição</a></li>
    <li><a href="aluno.login.php" title="Faça a sua inscrição">Área do aluno</a></li>
    <?php
    }
	?>

</ul>
