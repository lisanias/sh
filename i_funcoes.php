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
			return "Lista de espera.";
			break;
		case 2:
			return "<span style='color:#390;'>Pré-iscrição - Aguardando pagamento<./span>";
			break;
		case 3:
			return "Inscrição em processamento - Estamos processando o seu pagamento.";
			break;
		case 4:
			return "Incrição e pagamento confirmados.";
			break;
		case 5:
			return "Compareceu no evento.";
			break;		
		case 6:
			return "Módulo não presencial.";
			break;		
		case 7:
			return "Módulo concluído!";
			break;
		default:
			return "Contate a secretaria do Hosana.";
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
			return "Ok";
			break;
		default:
			return " ";
	}
}

// Forma de Pagamento
function pg_formaf ($pg_forma) {
	switch ($pg_forma) {
		case 1:
			return "Cartão de Crédito";
			break;
		case 2:
			return "Cartão de Débito";
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
			return "Cartão de Crédito - On Line";
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
			return "Pagamento a vista";
			break;
		case 2:
			return "Pagamento da inscriçao prévia";
			break;
		case 3:
			return "Pagamento de parcela";
			break;
		case 4:
			return "Parcelado no cartão de crédito";
			break;
		case 9:
			return "Outro";
			break;
		default:
			return " ";
	}
}

?>