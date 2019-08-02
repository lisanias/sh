<?php

// menu do topo e inicio do codigo html
include_once ('./inc/navbar.php');

if (isset($_SESSION['logado'])) {
	include ('./inc/mainmenu.php');
}


if (isset($msg)) { 
?>

<br>
<div class="container">
  <div class="alert <?=$msg_tipo?> fade in" align="center" >
   <a class="close" data-dismiss="alert">×</a>
   <?=$msg?>
  </div>
</div>

<?php } ?>