<?php
if (isset($_GET['idpagamento'])) {
	$id_pagamento = base64_decode($_GET['idpagamento']);
}

else if (isset($_POST['id_pagamento'])) {
	$id_pagamento = $_POST['id_pagamento'];
		if (isset($_GET['acao'])) {
			if ($_GET['acao'] == 'alterarpagamento') {
				$sqlup = "UPDATE pagamento
					SET status = 3
					WHERE id_pagamento = ". $id_pagamento;
					$atualiza = mysqli_query($con, $sqlup);
					if ($atualiza) {
						$msg = "Pagamento confirmado";
						$msg_tipo = "alert-success";
					}
					else {
						$msg = mysqli_error($con);
						$msg_tipo = "alert-error";
					}
			}
			else {$msg = "nao identf. alterar pagamento";}
		}
		else {$msg = "nao identf. id pagamento";}
}
else {
	$msg = "Nenhum pagamento selecionado";
	$msg_tipo = "alert-error";
}
?>