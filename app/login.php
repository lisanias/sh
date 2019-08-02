<?php 
// definir variáveis da página
$pg_titulo = "Login - Hosana SiS";
$pg_nome = "login.php";

// incluir arquivo de com variáveis iniciais e contantes globais
include_once('./inc/iniciar.php');

// Verifica se a opção conectar automaticamente está ativa e caso esteja conecta autmaticamente
include_once ('./inc/autologin.php');

// Vrrifica o usuário e senha ao enviar formulário
include_once ('./inc/login.valida.php');

// incluir arquivos de configuração css e scripts e codigo html "head".
include_once ('./inc/head.php');

echo "<body>";

// menu do topo e inicio do codigo html
include_once ('./inc/navbar.php');

if (!isset($default_user)) {
	$default_user = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : '';
}

?>
<!-- Conteúdo da Página -->

<div class="main">

<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="login.php" method="post" />
		
			<?php echo $_SERVER['PHP_SELF']; ?>
            <h1>Entrar no Sistema</h1>		
			
			<div class="login-fields">
				
                <?php if (isset($msg)) { ?>
                <div class="alert alert-error">  
                  <a class="close" data-dismiss="alert">×</a>  
                  <strong>Atenção!</strong> <?=$msg?> 
                </div> 
                <?php } ?>
                				
                <p>Entre com a sua conta:</p>
				
				<div class="field">
					<label for="usuario">Usuário:</label>
					<input type="text" id="usuario" name="usuario" value="<?= $default_user ?>" placeholder="Usuário" class="login username-field" required />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="senha">Senha:</label>
					<input type="password" id="senha" name="senha" value="" placeholder="Senha" class="login password-field" required />
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="conectado" name="conectado" type="checkbox" class="field login-checkbox" value="s" tabindex="4" />
					<label class="choice" for="conectado">Permanecer conctado</label>
				</span>
									
				<button type="submit" class="button btn btn-warning btn-large">Entrar</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->

</div><!-- /main -->


<!-- Text Under Box 
<div class="login-extra">
	Esqueceu a <a href="#">Senha</a>?
</div> <!-- /login-extra -->


<?php
  include ('./inc/botton.php')
?>
