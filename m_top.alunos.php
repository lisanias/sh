<?php
// Verificar o dominio que está para inserir link de login em alunos e sistema
$link = $_SERVER['SERVER_NAME']=='aluno.seminariohosana.com.br'?'https://sis.seminariohosana.com.br':'app/login.php';
?>
<div class="navbar" style='margin-top:1em'>
  <div class="navbar-inner">
    <div class="container">
      <?= LOGO ?>
      <ul class="nav pull-right">
          <?php
            if(isset($_SESSION["usuario"])){
          ?>
          <li><a href="aluno.home.php" title="Área dos Alunos"><i class="icon-home"></i> Home</a></li>
          <?php
            } else {
          ?>
          <li><a href="aluno.login.php" title="Login na área dos alunos"><i class="icon-user"></i> Área do aluno</a></li>
          <li><a href="inscricao.php" title="Faça a sua inscrição"><i class="icon-plus"></i> Nova Inscrição</a></li>
          <?php
            }        
          ?>
          <li>						
            <a href="https://seminariohosana.com.br">
              <i class="icon-globe active"></i>
              Site
            </a>						
          </li>

          <li>						
            <a href="<?=$link?>">
              <i class="icon-cog"></i> 
              SiS.Hosana
            </a>						
          </li>
      </ul>

    </div>  
  </div>
</div>
