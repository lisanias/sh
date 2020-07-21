<?php
// Agrupamento das intruções e includes da parte
// antecedente ao conteudo da página

// incluir arquivo de com variáveis iniciais e contantes globais
include_once('./inc/iniciar.php');

// incluir verificação de segurança
include_once('./inc/seguranca.php');

// incluir arquivos de configuração css e scripts e codigo html "head".
include_once ('./inc/head.php');

if (isset($incluir)) {
	echo $incluir;
	include_once("./pagina/".$incluir);
}

echo "<body>";

// menu do topo e inicio do codigo html
include_once ('./inc/navbar.php');
if (isset($_SESSION['logado'])) {
	include_once ('./inc/mainmenu.php');
}

?>
<?php if (isset($msg)) { ?>
<br>
<div class="container">
  <div class="alert <?=$msg_tipo?> fade in" align="center" >
   <a class="close" data-dismiss="alert">×</a>
   <?=$msg?>
  </div>
</div>
<?php } ?>
