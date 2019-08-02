<?php
/**
 * Classe para calcular a data limite de envio considerando apenas os dias de semana (segunda a sexta)
 * Precisa ser passado uma data unix
 * Exemplo:
 * 	$comprovante = new comprovante();
 *	$data_comprovante_unix = $comprovante->calculadata(time());
 *	echo date("d/m/Y w", $data_comprovante_unix );
 */

class comprovante {
	public function calculadata($d_comp_unix) {
		$dias_uteis = array(1,2,3,4,5);
		$i = 1;
		while ($i <= 3) {
			$d_comp_unix = $d_comp_unix + 86400;
			if (in_array(date("w",$d_comp_unix),$dias_uteis)) {
				$i++;
			}
		}
		return $d_comp_unix;
	}
}
?>