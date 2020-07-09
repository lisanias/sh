<div class="navbar navbar-inverse">
  <div class="navbar-inner">
    <div class="container">
      <?= LOGO ?>
      <ul class="nav">
          <?php
          if(isset($_SESSION["usuario"])){
        ?>
          <li><a href="aluno.home.php" title="Área dos Alunos">Home</a></li>
          <?php
          } else {
        ?>
          <li><a href="index.html" title="Login na área dos alunos.">Home</a></li>
          <li><a href="inscricao.php" title="Faça a sua inscrição">Nova Inscrição</a></li>
          <li><a href="aluno.login.php" title="Faça a sua inscrição">Área do aluno</a></li>
          <?php
          }
        ?>

      </ul>
    </div>
  </div>
</div>
