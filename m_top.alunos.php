<div class="navbar navbar-inverse">
  <div class="navbar-inner">
      <?= LOGO ?>
      <ul class="nav">
          <?php
          if(isset($_SESSION["usuario"])){
        ?>
          <li><a href="aluno.home.php" title="Área dos Alunos">Home</a></li>
          <?php
          } else {
        ?>
          <li><a href="app/login.php" title="Login na área dos alunos.">Admin</a></li>
          <li><a href="inscricao.php" title="Faça a sua inscrição">Nova Inscrição</a></li>
          <li><a href="aluno.login.php" title="Login na área dos alunos">Área do aluno</a></li>
          <?php
          }
        ?>

      </ul>
    
  </div>
</div>
