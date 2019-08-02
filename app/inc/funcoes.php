<?php
// função para pegar o primeiro e ultimo nome
function nome2 ($string) {
		$separa = explode(" ", $string);
		$prinome = $separa[0];
		$inverte = array_reverse(explode(" ", $string));
		$ultimonome = $inverte[0];
		
		return $prinome . " " . $ultimonome;
}


// definir o com texto o status (Função Status RESUMIDO) do aluno
function fsr ($nstatus) {
    switch ($nstatus) {
        case 0:
            return "Cancelado";
            break;
        case 1:
            return "Lista";
            break;
        case 2:
            return "Aguardando";
            break;
        case 3:
            return "Enviado";
            break;
        case 4:
            return "Confirmada";
            break;
        case 5:
            return "Compareceu";
            break;
        case 6:
            return "EAD";
            break;
        case 7:
            return "Concluído";
            break;
        default:
            return " ";
    }
}


// definir o com texto o status (Função Status Descricao) do aluno
function fsd ($nstatus) {
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
        case 6:
            return "Módulo concluído não presencial";
            break;
        case 7:
            return "Módulo concluído";
            break;
		default:
			return "Contate a secretaria do Hosana";
	}
}
// definir o status do aluno com texto e um cracha colorido (Função Status Cracha) <i class="btn-icon-only icon-remove"></i>
function fsc ($nstatus) {
	switch ($nstatus) {
		case 0:
			return "<span class='badge' title='Cancelado'><i class='btn-icon-only icon-remove'></i></span>";
			break;
		case 1:
			return "<span class='badge badge-important' title='Lista de espera'><i class='btn-icon-only icon-asterisk'></i></span>";
			break;
		case 2:
			return "<span class='badge badge-warning' title='Esperando envio do comprovante'><i class='btn-icon-only icon-pause'></i></span>";
			break;
		case 3:
			return "<span class='badge badge-info' title='Comprovante Enviado'><i class='btn-icon-only icon-picture'></i></span>";
			break;
		case 4:
			return "<span class='badge badge-success' title='Incrição Confirmada'><i class='btn-icon-only icon-ok'></i></span>";
			break;
		case 5:
			return "<span class='badge badge-inverse' title='Compareceu no evento'><i class='btn-icon-only icon-check'></i></span>";
			break;
        case 6:
            return "<span class='badge badge-info' title='Módulo Concluído não presencialmente'><i class='btn-icon-only icon-check'></i></span>";
            break;
        case 7:
            return "<span class='label label-inverse' title='Compareceu no evento'><i class='btn-icon-only icon-check'></i></span>
					<span class='label label-success' title='Módulo Concluído'><i class='btn-icon-only icon-thumbs-up'></i></span>";
            break;
		default:
			return "<span class='badge badge-important' title='Contate a secretaria do Hosana'><i class='btn-icon-only icon-question-sign'></i></span>";
	}
}

// definir o status do aluno com texto e um cracha colorido bem pequeno (Função Status Cracha Pequena) <i class="btn-icon-only icon-remove"></i>
function fsc_ok ($nstatus) {
	switch ($nstatus) {
		case 0:
			return "<i class='btn-icon-only icon-remove-sign' style='color:gray'></i>";
			break;
		case 1:
			return "<i class='btn-icon-only icon-pause' style='color:red'></i>";
			break;
		case 2:
			return "<i class='btn-icon-only icon-pause' style='color:#f89406'></i>";
			break;
		case 3:
			return "<i class='btn-icon-only icon-ok' style='color:#ddd'></i>";
			break;
		case 4:
			return "<i class='btn-icon-only icon-ok' style='color:#ccc'></i>";
			break;
		case 5:
			return "<i class='btn-icon-only icon-ok' style='color:green'></i>";
			break;
        case 6:
            return "<i class='btn-icon-only icon-ok' style='color:red'></i>";
            break;
        case 7:
            return "<i class='btn-icon-only icon-ok' style='color:black'></i>";
            break;
		default:
			return "<span class='label badge-important' title='Contate a secretaria do Hosana'><i class='btn-icon-only icon-question-sign'></i></span>";
	}
}

// a mesma que a anterior so que com descrição em texto por extenso
function fsce ($nstatus) {
    switch ($nstatus) {
        case 0:
            return "<span class='badge' title='Cancelado'>Cancelado</span>";
            break;
        case 1:
            return "<span class='badge badge-important' title='Lista de espera'>Lista de espera</i></span>";
            break;
        case 2:
            return "<span class='badge badge-warning' title='O aluno ainda não enviou o comprovante'>Esperando Comprovante</span>";
            break;
        case 3:
            return "<span class='badge badge-info' title='Comprovante Enviado pelo aluno, mas ainda não confirmada pelo staff'>Comprovante enviado</span>";
            break;
        case 4:
            return "<span class='badge badge-success' title='Incrição Confirmada - tudo ok'>Confirmado</span>";
            break;
        case 5:
            return "<span class='badge badge-inverse' title='Compareceu no módulo inscrito'>Compareceu</span>";
            break;
        case 6:
            return "<span class='badge badge-info' title='Módulo concluído não presencialmente'>Não presencial!</span>";
            break;
        case 7:
            return "<span class='badge badge-info' title='Módulo Concluído'>Módulo concluído</span>";
            break;
        default:
            return "<span class='badge badge-important' title='Contate a secretaria do Hosana'>Alguma coisa não está certa!!</span>";
    }
}

function permissoes_grupos ($nstatus) {
	switch ($nstatus) {
		case 0:
			return "Não atribuido";
			break;
		case 1:
			return "Administrador";
			break;
		case 2:
			return "Secretaria";
			break;
		case 3:
			return "Tesouraria";
			break;
		case 4:
			return "Hospedagem";
			break;
		default:
			return "Não atribuidoa";
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
function function_pg_status ($pg_status) {
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

// Status do Pagamento
function function_pg_status_icon ($pg_status) {
	switch ($pg_status) {
		case 1:
			return "<span class='badge badge-warning' title='Não confirmado".$pg_status."'><i class='btn-icon-only icon-warning-sign'></i></span>";
			break;
		case 2:
			return "<span class='badge badge-info' title='Comprovante Enviado ".$pg_status."'><i class='btn-icon-only icon-picture'></i></span>";
			break;
		case 3:
			return "<span class='badge badge-success' title='Incrição Confirmada ".$pg_status."'><i class='btn-icon-only icon-ok'></i></span>";
			break;
		default:
			return "<span class='badge badge-warning' title='Não confirmado ".$pg_status."'><i class='btn-icon-only icon-question-sign'></i></span>";
	}
}


// Forma de Pagamento
function function_pg_forma ($pg_forma) {

    global $TEXT;

	switch ($pg_forma) {
		case 1:
			return $TEXT['pg1'];
			break;
		case 2:
			return $TEXT['pg2'];
			break;
		case 3:
			return $TEXT['pg3'];
			break;
		case 4:
			return $TEXT['pg4'];
			break;
		case 5:
			return $TEXT['pg5'];
			break;
		case 6:
			return $TEXT['pg6'];
			break;
		case 9:
			return $TEXT['pg9'];
			break;
		default:
			return " ";
	}
}

// Pagamento referente a...
function function_pg_ref ($pg_ref) {
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
		case 4:
			return "Pagamento no Hosana";
			break;
		case 9:
			return "Outro";
			break;
		default:
			return " ";
	}
}

function curso_ini($cid) {
	switch ($cid) {
		case 1:
			return "CMT";
			break;
		case 2:
			return "PIJ";
			break;
		case 3:
			return "CST";
			break;
		case 4:
			return "POS";
			break;
		default:
			return " ";
	}
}

// Selecionar Sexo
function sexo($sexo) {
    global $TEXT;
    switch ($sexo) {
        case 'M':
        case 'm':
            return $TEXT['sexoM'];
            break;
        case 'F':
        case 'f':
            return $TEXT['sexoF'];
            break;
        default:
            return $TEXT['sexo_ind'];
    }
}


// Hospegem (sim ou não) modo texto:
function hospeda_txt ($hospeda) {
    global $TEXT;
    switch ($hospeda) {
        case 0:
            return "<span class='hospedanao'>".$TEXT['nao']."</span>";
            break;
        case 1:
            return "<span class='hospedasim'>".$TEXT['sim']."</span>";
            break;
    }
}

// Hospedagem (sim/não) modo grafico
function hospeda_cor ($hospeda) {
    global $TEXT;
    switch ($hospeda) {
        case 0:
            return "<span class='badge badge-success' title='{$TEXT['sem_hospedagem']}'>{$TEXT['nao']}</span>";
            break;
        case 1:
            return "<span class='badge badge-success' title='{$TEXT['com_hospedagem']}'>{$TEXT['sim']}</span>";
            break;
    }
}


// Altera os numeros para o padrão PHP e SQL
function valor_ok($num_work)
{
    if ((strpos($num_work,".") > "-1") | (strpos($num_work,",") > "-1")) {
        if ((strpos($num_work,".") > "-1") & (strpos($num_work,",") > "-1")) {
            if (strpos($num_work,".") > strpos($num_work,",")){
                return str_replace(",","",$num_work);
            } else {
                return str_replace(",",".",str_replace(".","",$num_work));
            }
        } else {
            if (strpos($num_work,".") > "-1") {
                if (strpos($num_work,".") == strrpos($num_work,".")) {
                    return $num_work;
                } else {
                    return str_replace(".","",$num_work);
                }
            } else {
                if (strpos($num_work,",") == strrpos($num_work,",")) {
                    return str_replace(",",".",$num_work);
                } else {
                    return str_replace(",","",$num_work);
                }
            } }
    } else {
        return $num_work;
    }
}


// 'legenda' de hospedagem: 1=sim 0=nao
function hospedagem($valor) {
    switch ($valor) {
        case 1:
            return "<span class='success'>Sim</span>";
            exit;
        case 0:
            return "<span class='error'>NÃO</span>";
            exit;
        default:
            return "";
            exit;
    }
}
function hospedagem_cor($valor) {
    switch ($valor) {
        case 1:
            return "<span class='badge badge-success'>SIM</span>";
            exit;
        case 0:
            return "<span class='badge badge-error'>NÃO</span>";
            exit;
        default:
            return "";
            exit;
    }
}

// função para pegar o numero do quarto
/*
 * mandar o numero da cama para retornar o nome do quarto
 */
function quarto_nome($valor) {
		
		global $con;
		
		$sql_quarto = "SELECT *
						FROM cama
						INNER JOIN quarto ON cama.id_quarto = quarto.id_quarto
						WHERE cama.id_cama = ".$valor."
			";
		
		$tabela_quarto = mysqli_query($con,$sql_quarto);
		$dados_quarto = mysqli_fetch_array($tabela_quarto);
						
		echo $dados_quarto['quarto'];
}

# função para gerar senhas aleatoriamente
function geraSenha($tamanho = 10, $maiusculas = true, $numeros = true, $simbolos = false) {
	
	// Caracteres de cada tipo
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	
	// Variáveis internas
	$retorno = '';
	$caracteres = '';
	
	// Agrupamos todos os caracteres que poderão ser utilizados
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	
	// Calculamos o total de caracteres possíveis
	$len = strlen($caracteres);
	
	for ($n = 1; $n <= $tamanho; $n++) {
	// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
	$rand = mt_rand(1, $len);
	// Concatenamos um dos caracteres na variável $retorno
	$retorno .= $caracteres[$rand-1];
	}
	
	return $retorno;
}

// definir o com texto o status (Função Status RESUMIDO) do aluno
function mesext ($nstatus) {
    switch ($nstatus) {
        case 1:
            return "Janeiro";
            break;
        case 2:
            return "Fevereiro";
            break;
        case 3:
            return "Março";
            break;
        case 4:
            return "Abril";
            break;
        case 5:
            return "Maio";
            break;
        case 6:
            return "Junho";
            break;
        case 7:
            return "Julho";
            break;
        case 8:
            return "Agosto";
            break;
        case 9:
            return "Setembro";
            break;
        case 10:
            return "Outubro";
            break;
        case 11:
            return "Novembro";
            break;
        case 12:
            return "Dezembro";
            break;
        default:
            return " ";
    }
}

// fim do arquivo
?>