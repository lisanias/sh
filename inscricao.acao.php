<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
	//cria sessão
	include 'i_secao.evento.default.php';		
		
	// ### MATRICULAS DE NOVOS ALUNOS: faz o cadastro na tabela alunos e matricula.
	// checar se é possivel fazer a matricula
	// verificar se tem vagas
	// verificar se não está cadastrado em aluno novamente
	
	//pegar variáveis hidden
	$hidden_vagas = $_POST['hidden_vagas'];
	
	//pegar as variáveis enviadas
	$input_curso = $_POST['inputCurso'];
	$input_hospedagem = $_POST['inputHospedagem'];
	
	$input_nome = $_POST['inputNome'];
	$input_sobrenome = $_POST['inputSobrenome'];
	$input_email = $_POST['inputEmail'];
	$input_login = $_POST['inputLogin'];
	$input_senha = $_POST['inputSenha'];
	$input_cpf = $_POST['inputCPF'];	
	
	$input_endereco = $_POST['inputEndereco'];
	$input_complemento = $_POST['inputComplemento'];
	$input_bairro = $_POST['inputBairro'];
	$input_cidade = $_POST['inputCidade'];
	$input_uf = $_POST['inputUF'];
	$input_cep = $_POST['inputCEP'];
	
	$input_tres = $_POST['inputTres'];
	$input_ctcel = $_POST['inputTcel'];
	
	$input_dnas = $_POST['inputDnas'];
	$input_sexo = $_POST['inputSexo'];
	$input_ec = $_POST['inputEC'];	
	$input_igreja = $_POST['inputIgreja'];
	$input_obs = $_POST['inputObs'];
	
	// colocar todas as variáveis numa session caja falte algum dado importante na chegagem dos campos
	// e precise retornar a pagina anterior
	// todo: colocar default se tiver session valida na pagina de incrição.
	
	//pegar as variáveis enviadas
	$_SESSION['input_curso'] = $input_curso;
	$_SESSION['input_hospedagem'] = $input_hospedagem;
	
	$_SESSION['input_nome'] = $input_nome;
	$_SESSION['input_sobrenome'] = $input_sobrenome;
	$_SESSION['input_email'] = $input_email;
	$_SESSION['input_login'] = $input_login;
	$_SESSION['input_senha'] = $input_senha;
	$_SESSION['input_cpf'] = $input_cpf;	
	
	$_SESSION['input_endereco'] = $input_endereco;
	$_SESSION['input_complemento'] = $input_complemento;
	$_SESSION['input_bairro'] = $input_bairro;
	$_SESSION['input_cidade'] = $input_cidade;
	$_SESSION['input_uf'] = $input_uf;
	$_SESSION['input_cep'] = $input_cep;
	
	$_SESSION['input_tres'] = $input_tres;
	$_SESSION['input_ctcel'] = $input_ctcel;
	
	$_SESSION['input_dnas'] = $input_dnas;
	$_SESSION['input_sexo'] = $input_sexo;
	$_SESSION['input_ec'] = $input_ec;	
	$_SESSION['input_igreja'] = $input_igreja;
	$_SESSION['input_obs'] = $input_obs;
	
	
	// pegar datas do sistema hosana.sis
	$evento_data_ini = implode('/',array_reverse(explode('-',$_SESSION['evento_data_ini'])));
	$evento_data_fim = implode('/',array_reverse(explode('-',$_SESSION['evento_data_fim'])));
	$evento_atual_nome = $_SESSION['evento_atual_nome'];
	
	// calcular data limite para envio do comprovante de pagamento da incrição
	$comprovante = new comprovante();
	$data_comprovante_unix = $comprovante->calculadata(time());
	$data_comprovante = date("d/m/Y",$data_comprovante_unix);
	#$data_comprovante = date("d/m/Y",time()+(3*24*60*60));
	

    // verificar os campos obrigatorios
    if ( strlen(trim($input_curso)) == 0 ) {
		$_SESSION['focus']="inputCurso";
		$_SESSION['msg_insc']="Precisa preencher um campo obrigatorio: Curso";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_hospedagem)) == 0 ) {
		$_SESSION['focus']="inputHospedagem";
        echo header('Location: inscricao.php?foco=inputHospedagem');
        die();
    }
	
	if ( strlen(trim($input_nome)) == 0 ) {
		$_SESSION['focus']="inputNome";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_sobrenome)) == 0 ) {
		$_SESSION['focus']="inputSobrenome";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_email)) == 0 ) {
		$_SESSION['focus']="inputEmail";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_login)) == 0 ) {
        $_SESSION['focus']="inputLogin";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_senha)) == 0 ) {
        $_SESSION['focus']="inputSenha";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_cpf)) == 0 ) {
        $_SESSION['focus']="inputCPF";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_dnas)) == 0 ) {
        $_SESSION['focus']="inputDnas";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_sexo)) == 0 ) {
        $_SESSION['focus']="inputSexo";
        echo header('Location: inscricao.php');
        die();
    }
	
	if ( strlen(trim($input_igreja)) == 0 ) {
        $_SESSION['focus']="inputIgreja";
        echo header('Location: inscricao.php');
        die();
    }

/*		// Verificar numeros de vagas dos matriculados
		// selecionar tablea
                                
                /* resultado direto - a base de dados tem um agendamento para mudar
                 * o status de 2 para 0 assim so teremos inscrições com estatus 2
                 * por 3 dias depois disso automaticamente muda para stutos 0 se
                 * não tiver sido mudado para 3.
                 * 
                 * status:
                 * 0 - anulado - pelo sistema, caso ultrapasse 3 dias, pelo aluno caso cancele, pelo estaff
                 * 1 - lista de espera - quando a inscrição é feita mas ja não tinha vagas
                 * 2 - Pre-iscrição feita pelo sistema, mas ainda não foi confirmada pelo envio do comprovante de pagamento
                 * 4 - Incrição confirmada pelo envio do comprovante de pagamento.
                 * 5 - Incrição confirmada e conferida pelo staff como ok
                 * 6 - Compareceu - Tudo pago e compareceu ao seminário.                         */
    
			
	// as vagas foi definida na pagina da inscrição: todas as inscrições validas (2) e confirmadas (<2) que tenham optado por hospedagem (1) 
	// [formula: modulo=jan.2014 e situação >= 2 e hospedagem = 1]
	//
	// se houver vagas a situação e em espera do comprovante(2) e a hospedagem é a escolhida pelo aluno
	// se não houver vaga a situação depende da escolha de hospedagem do aluno:
	//                se escolheu ter hospedagem (1) a situação é em fila de espera (1)
	//                se optou por não dormir (0) a situação é aguardando pagamento (2)
	
	if ($hidden_vagas > 0) {
		
        $situacao_code = 2;
		
	}
	else {
		if ($input_hospedagem == 0){
			
			$situacao_code = 2;
			
		} else {
			
			$situacao_code = 1;
			
		}
    }
	
	// verificar se tem algum desconto (por causa da hospedagem)
	if ($input_hospedagem == 0){
		if ($input_curso == 6) {
			$desconto = 400;
		} else {
			$desconto = 80;
		}
	} else {
		$desconto = 0;
	}

	// verifica se o curso é o congresso e anula qualquer desconto e tira hospedagem (na hora do cadastro pelo aluno apenas)
	if ($input_curso == 7) {
		$desconto = NULL;
		$input_hospedagem = 0;
	}
	
	// IMPORTATE
	// quem estiver na lista de espera não recebe email para enviar pagamento mas para aguardar
	
	// inserir os dados do aluno
	$sql = "INSERT INTO alunos ( 
		data_cadastro, 
		data_ultimoacesso, 
		login, 
		senha, 
		nome, 
		sobrenome, 
		cpf, 
		email,
		sexo, 
		dnas, 
		endereco, 
		complemento, 
		bairro, 
		cidade, 
		uf, 
		cep, 
		tres, 
		tcel, 
		estado_civil, 
		igreja,
		obs)

	VALUES (
		now(), 
		now(),  
		'" . $input_login . "', 
		'" . sha1(SALT.$input_senha) . "',
		'" . $input_nome . "', 
		'" . $input_sobrenome . "', 
		'" . $input_cpf . "', 
		'" . $input_email . "',
		'" . $input_sexo . "', 
		'" . implode('-',array_reverse(explode('/',$input_dnas))) . "', 
		'" . $input_endereco . "', 
		'" . $input_complemento . "', 
		'" . $input_bairro . "', 
		'" . $input_cidade . "', 
		'" . $input_uf . "', 
		'" . $input_cep . "', 
		'" . $input_tres . "', 
		'" . $input_ctcel . "', 
		'" . $input_ec . "', 
		'" . $input_igreja . "', 
		'" . $input_obs . "'
		)";

	# executa o codigo sql inserindo na base de dados (poderia ser "mysqli_query($con,$sql);" mas não verificaria o erro
	if(!$result = $con->query($sql)){
 		$_SESSION['msg'] = "Ha um erro ao executar a pesquisa na base de dados alunos: [' . $con->error . ']";
		die(header("Location: aluno.login.php"));
		}

	// Pegar o id do modulo que o aluno está fazendo a matricula
	$novo_aluno_id = mysqli_insert_id($con);
	
	// continuar colocando dados nas outras tabelas...
	// fazer a matricula
	
	// através do id_evento e do id_curso
	$sql = "SELECT * FROM modulo WHERE id_curso = '" . $input_curso . "' AND id_evento = '" . $_SESSION['evento_atual'] . "'";
	$tabela = mysqli_query($con,$sql);
	$dados = mysqli_fetch_array($tabela);
	
	$id_modulo = $dados['id_modulo'];
	$modulo = $dados['modulo'];
	$valor_modulo = $dados['valor'];
	$valor_inscricao_previa = $dados['valor_inscricao_previa'];
	$condicoes = $dados['condicoes'];
	
	// inserir os dados do matricula
	$sql = "INSERT INTO matricula (
		id_aluno, 
		id_evento, 
		id_modulo, 
		data_matricula,
		data_comprovante,
		status,
		desconto,
		hospedagem,
		obs)

	VALUES (
		'" . $novo_aluno_id . "', 
		'" . $_SESSION['evento_atual'] . "',  
		'" . $id_modulo . "',
		now(), 
		'". implode('-',array_reverse(explode('/',$data_comprovante))) ."',
		'" . $situacao_code . "',
		'" . $desconto . "',
		'" . $input_hospedagem . "',
		'" . $input_obs . "'
		)";
	
	// executa a acao adicionando os dados na base de dados e verifica os erros
	if(!$result = $con->query($sql)){
            $cmsg = base64_encode("Ha um erro ao executar a pesquisa na base de dados matricula: [' . $con->error . ']");
            die(header("Location: aluno.login.php?msg=$cmsg"));
            }
	
	$nova_matricula_id = mysqli_insert_id($con);
			
	// Pegar o nome do curso que o aluno está matriculando
	$sql = "SELECT * FROM cursos WHERE id_curso = $input_curso";
	$tabela = mysqli_query($con,$sql);
	$dados = mysqli_fetch_array($tabela);
	$curso_nome = $dados['nome_curso'];
	
	mysqli_close($con);
		
//  ++++++++++++++++++++++++++++++++++++++++++ 
//  MENSAGENS DE EMAIL PARA ALUNO E SECRETARIA 
//  ++++++++++++++++++++++++++++++++++++++++++

// Formação dos valores a apresentar em Reais
if ($desconto > 0){
	$valor_pagar = $valor_modulo - $desconto;
} else {
	$valor_pagar = $valor_modulo;
}


$valor_modulo = number_format($valor_modulo,2,",",".");
$valor_inscricao_previa = number_format($valor_inscricao_previa,2,",",".");
$valor_pagar = number_format($valor_pagar,2,",",".");
$desconto = number_format($desconto,2,",",".");

if ($desconto > 0){
	$pagar_texto = "</strong>$valor_pagar</strong> (Valor do Módulo menos o desconto da hospedagem: {$valor_modulo} - {$desconto})";
} else {
	$pagar_texto = "</strong>$valor_pagar</strong>";
}


$hospedagem_txt = ($input_hospedagem == 1)?"Sim":"Não";

// mensagem para aluno com vaga
if ( $situacao_code == 2 ) {
$email_msg_aluno = "
<html>
	<head>
		<title>Incrição do Hosana</title>
	</head>
	<body>
		<h3>Oi $input_nome $input_sobrenome,</h3>
		<p>A sua inscrição para o Seminário Hosana - $evento_atual_nome foi realizada com sucesso.</p>
		<div style='background-color: #EEE; margin: 1em 2em; padding: 1em 2em; border-radius: 4px;'>
			<p>Nome:<strong> $input_nome $input_sobrenome</strong><br />
			Curso: <strong>$curso_nome - $evento_atual_nome;</strong><br />
			Módulo: <strong>$modulo;</strong><br />
			Hospedagem: <strong>$hospedagem_txt;</strong><br />
			Valor do módulo: <strong>$valor_modulo;</strong><br />
			Valor a pagar: $pagar_texto;<br />
			Pagamento mínimo: <strong>$valor_inscricao_previa;</strong><br />
			Data: De <strong>$evento_data_ini </strong>a <strong>$evento_data_fim</strong>;<br />
			Situação: Aguardando pagamento da inscrição prévia;<br />
			Igreja: <strong>$input_igreja</strong>.</p>
			<p>Login: <strong>$input_login</strong><br />			
		</div>
	    <p><br>Ressaltamos que para a confirmação da inscrição, será necessário o <strong>pagamento e o envio</strong> do comprovante, <em><strong>exclusivamente pela área do aluno do sistema on-line do Seminário Hosana</strong></em>, até o dia $data_comprovante. Caso contrário a sua inscrição será cancelada e sua vaga será liberada para outro aluno. Não envie comprovante de pagamento por e-mail, correio, fax, etc, pois só serão considerados os comprovantes enviados pela área do aluno do sistema on-line do Seminário Hosana</p>
		<p>Para acessar área do aluno no sistema on-line do Seminário Hosana você deve entrar no site do Seminário Hosana e clicar em inscriçoes on-line e inserir seus login ($input_login) e senha.</p>
		<p>Caso tenha ocorrido o cancelamento, e você ainda deseja participar do módulo, poderá pedir à secretaria do S.H para liberar a inscrição, observando a disponibilidade de vaga.</p>
	    <table style='padding:5px; background-color: #EEE;'>
		  <tr>
			<td>Valor da Incrição Prévia (pagamento minimo para garantir vaga)</td>
			<td align='right'>$valor_inscricao_previa</td>
		  </tr>
		  <tr>
			<td colspan='2'>Pagar inscrição prévia e enviar comprovante até $data_comprovante.</td>
		  </tr>
		</table>
		<br />
		<br />
		<h3>Conta para depósito de inscrição prévia e parcelas:</h3>
		<p><span style='color:red; font-weight:bold'>BANCO BRADESCO</span><br />
		Agência: <strong>0053-1</strong> C/C: <strong>121513-2</strong></p>
		<p><br />ATT.<br /> Equipe do Hosana</p>
		<br />
		<P>CONTATOS:<br>
		Tel: (43) 3325-1424<br>
		E-mail: secretaria@seminariohosana.com.br</p>
		<br />
		<p style='font-size:small'>EMAIL ENVIADO AUTOMATICAMENTE PELO SISTEMA. Não responda este e-mail e não utilize este endereço para comunicar com o S.H. Caso tenha dúvidas entre em contato com a secretaria do S.H. pelo e-mail secretaria@seminariohosana.com.br ou pelo telefone (43) 3325-1424.</p>
		<br /><br />&nbsp;
	</body>
</html>
";
}
else {
// mensagem para aluno sem vagas diponiveis
$email_msg_aluno = "
<html>
	<head>
		<title>Incrição do Hosana</title>
        <style>
            div.dados { background-color: #EEE; margin: 1em 2em; padding: 1em 2em; border-radius: 12px; }
			span.red {color: red; font-weight: bold;}
        </style>
	</head>
	<body>
		<h3>Oi $input_nome,</h3>
		<p>Obrigado por fazer a sua pré inscrição.<br />
	Infelizmente, no momento, não há vagas disponiveis para o próximo modúlo e sua inscrição está em uma lista despera.</p>
		<p>Se surgirem vagas, a secretaria do SH irá entrar em contato, informando-o de como proceder. <strong>Não faça nenhum depósito até que receba instruções da secretaria, disponibilizando sua vaga e liberando sua inscrição</strong>.</p>
		<p>A qualquer momento poderá verificar como está a sua inscrição e até o seu histórico de participação em módulos do S.H. acessando a área do aluno no sistema on-line do Seminário Hosana com seu <em>login</em> e <em>senha</em> cadastrados.</p>
		<p>Qualquer dúvida, entre em contato com a secretaria do Hosana por telefone ou e-mail e verifique a situação das vagas.</p>
		
	<div class='dados'>
			<p>Nome:<strong> $input_nome $input_sobrenome</strong><br />
			Curso: <strong>$curso_nome - $evento_atual_nome;</strong><br />
			Módulo: <strong>$modulo;</strong><br />
			Valor: <strong>$valor_modulo;</strong><br />
			Data: De <strong>$evento_data_ini </strong>a <strong>$evento_data_fim</strong>;<br />
			Situação: Aguardando pagamento da inscrição prévia;<br />
			Igreja: <strong>$input_igreja.</strong></p>
		</div>
		
	<p><span class='red'>ATENÇÃO: NÃO FAÇA O PAGAMENTO DA INSCRIÇÃO SEM A CONFIRMAÇÃO DA SUA VAGA!</span></p>
		
		<P>CONTATOS:<br>
		Tel: (43) 3325-1424<br>
		E-mail: secretaria@seminariohosana.com.br</p>

	<p style='font-weight: bold;'>ATT.<br> Equipe do Hosana</p>
		
		<p style='font-size:xsmall'>E-mail enviado automaticamente pelo sistema on-line do Hosana. Não responder e não usar este e-mail (hosana.sis@gmail.com) para qualquer tipo de comunicação com o S.H.</p>
</body>
</html>
";
}
		
/**
 * 
 * fazer rotina para mandar email para o aluno
 * 
 * PHP Mailer 6
 *
 */
require_once ("./phpmailer/phpmailer_6/src/Exception.php");
require_once ("./phpmailer/phpmailer_6/src/PHPMailer.php");
require_once ("./phpmailer/phpmailer_6/src/SMTP.php");

//Nova instância do PHPMailer
$mail = new PHPMailer(true); //Informa que será utilizado o SMTP para envio do e-mail
try {
	//Server settings
	require_once ('i_phpmail_config.php');

	//Recipients	
	$mail->AddAddress($input_email); //E-mail para a qual o e-mail será enviado
	$mail->AddBcc('sis@webig.pro.br', 'lisanias@hotmail.com'); //cópia oculta 

	//Conteúdo do e-mail
	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	$mail->Subject  =   'Seminário Hosana - Cadastro de Alunos - NAO RESPONDER'; //Titulo do e-mail que será enviado
	$mail->MsgHTML($email_msg_aluno) ;
	$mail->AltBody = 'Seu email não suporta texto HTML';

	/**
	 * 
	 *  opçoes para enviar do localhost
	 * */
	 $mail->SMTPOptions = array(
	 	'ssl' => array(
	 		'verify_peer' => false,
	 	   	'verify_peer_name' => false,
	  		'allow_self_signed' => true
	 	)
	 );
	 

	//Dispara o e-mail
	if(!$mail->Send()) {
		// Mensagem para o usuário 

		//echo 'Contato não pode ser enviado.';
		//echo 'Erro: ' . $mail->ErrorInfo;

		$_SESSION["msg"]= "Email não enviado. Erro:".$mail->ErrorInfo;
		$_SESSION['msg_tipo']="alert-error";
	} else {
		//echo 'Contato enviado com sucesso!';
		
		// Mensagem para o usuário 
		$_SESSION["msg"]= "Email enviado!";
		$_SESSION['msg_tipo']="alert-success";
	}

} catch (Exception $e) {
	
	/*echo '<pre>';
	var_dump($mail);
	echo "<br><p>Erro:_________ {$mail->ErrorInfo}</p>";
	die();*/
	
	// Mensagem para o usuário
	$_SESSION["msg"] = "Não foi possivel enviar o e-mail com as informações da sua incrição mas a sua inscrição foi realizada.<br /> (<i> {$mail->ErrorInfo} </i>)";

}




	
// Grava as variáveis necessarias para uso posterior (apenas nesta seção)
$_SESSION['curso'] = $curso_nome;
$_SESSION['modulo'] = $modulo;
$_SESSION['valor_modulo'] = $valor_modulo;
$_SESSION['valor_pagar'] = $valor_pagar;
$_SESSION['valor_pagar_txt'] = $pagar_texto;
$_SESSION['inscricao_situacao_cod'] = $situacao_code;
$_SESSION['data_comprovante'] = $data_comprovante;

// direcionar para página de confirmação
echo header('Location: inscricao.confirm.php');