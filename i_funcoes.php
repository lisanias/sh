<?php
/* 
 * 
 * função que define o stutus ou situação da matricula do aluno
 * chamar função statusf ('numero status')
 * 
 * */
function statusf ($nstatus) {
	switch ($nstatus) {
		case 0:
			return "<span style='color:red;'>Cancelado</span>";
			break;
		case 1:
			return "Lista de espera";
			break;
		case 2:
			return "<span style='color:#390;'>Esperando envio do comprovante</span>";
			break;
		case 3:
			return "Comprovante Enviado";
			break;
		case 4:
			return "Incrição Confirmada";
			break;
		case 5:
			return "Compareceu no evento";
			break;
		default:
			return "Contate a secretaria do Hosana";
	}
}
// Estado civil
function ec ($ec) {
	switch ($ec) {
		case 1:
			return "Solteiro";
			break;
		case 2:
			return "Casado";
			break;
		case 3:
			return "Viuvo";
			break;
		case 4:
			return "Divorciado";
			break;
		case 9:
			return "Outro";
			break;
		default:
			return " ";
	}
}

// Status do Pagamento
function pg_statusf ($pg_status) {
	switch ($pg_status) {
		case 1:
			return "Não confirmado";
			break;
		case 2:
			return "Enviado";
			break;
		case 3:
			return "OK, Enviado e confirmado";
			break;
		default:
			return " ";
	}
}

// Forma de Pagamento
function pg_formaf ($pg_forma) {
	switch ($pg_forma) {
		case 1:
			return "Crédito";
			break;
		case 2:
			return "Débito";
			break;
		case 3:
			return "Espécie";
			break;
		case 4:
			return "Depósito";
			break;
		case 5:
			return "Cheque";
			break;
		case 6:
			return "Boleto";
			break;
		case 9:
			return "Outro";
			break;
		default:
			return " ";
	}
}

// Pagamento referente a...
function pg_reff ($pg_ref) {
	switch ($pg_ref) {
		case 1:
			return "Pagamento integral";
			break;
		case 2:
			return "Pagamento da inscriçao prévia";
			break;
		case 3:
			return "Pagamento de prestação";
			break;
		case 9:
			return "Outro";
			break;
		default:
			return " ";
	}
}

?>