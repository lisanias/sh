<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'i_secao.evento.default.php';


$hash = hash('sha256', uniqid(mt_rand()));
$email = $_POST['email'];

$host = $_SERVER['HTTP_HOST'];

$url['work'] = 'http://localhost/hosana'; // Definir para seu servidor local de trabalho
# $url['www'] = 'http://187.18.113.233/hosana';
$url['www'] = 'https://webig.pro.br/sh';
$url['intra'] = 'http://172.16.1.2/hosana';


###########################################
#   ALETERAR AQUI ANTES DE FAZER UPLOAD   #
###########################################

# Se precisar definir o abiente de trabalho manualmente descomente a linha a seguir:
# $urlAtual = 'www';    // 'work', 'www', 'intra'

# Definir se estamos em um abiente online ou offline
# Na chacara do seminário hosana estamos normalmente offline
if($host=='webig.pro.br'){
    $status = 'on';
} 

//die($status. " -- ". $host);

# ##########################################


// Verificar em que dominio estamos
switch($host){
    case 'localhost':
        $urlAtual = 'work';
        break;
    case 'webig.pro.br':
        $urlAtual = 'www';
        break;
    default:
        $urlAtual = 'intra'; //usado no Hosana - configurar
        break;
}

// Verificar se o email existe
$sql = "SELECT * 
        FROM alunos
        WHERE email = '{$email}'";

$tabela = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($tabela);



if (!$linhas = mysqli_num_rows($tabela)) {

    $_SESSION["msg"]= "Este email não está cadastrado para nenhum dos nossos alunos";
    $_SESSION['msg_tipo']="alert-error";
    header("location: aluno.recuperar.senha.php");
    exit;

    }


else {

    // Inserir hash na base de dados para o aluno
    $sql = "UPDATE alunos
        SET recuperaSenha_hash = '{$hash}'
        WHERE email = '{$email}' ";

    $atualiza = mysqli_query($con,$sql);


    // Preparar email
    $subject = 'Recuperar senha - HOSANA';

    $message = "<html>
        <head>
            <title>Recuperação de Senha - Sistema Hosana</title>
            <style>
                div.dados { background-color: #EEE; margin: 1em 2em; padding: 1em 2em; border-radius: 12px; }
                span.red {color: red; font-weight: bold;}
            </style>
        </head>
        <body>
            <h3>Recuperar senha</h3>

            <p>Você soliciou a recuperação de sua senha. Click no link a seguir e digite uma nova senha.</p>

            <p><a title='Criar nova senha' href='{$url[$urlAtual]}/aluno.senha.reset.php?token={$hash}&email={$email}' >Refazer senha</a></p>

            <p>Ou copie e cole o link a seguir no seu navegador: {$url[$urlAtual]}/aluno.senha.reset.php?token={$hash}&email={$email}</p>

            <p class='small'>Se você não solicitou a alteração de senha, apenas ignore este e-mail, que nada alterou em sua conta.</p>
            
            
            <P>CONTATOS:<br>
            Tel: (43) 3325-1424<br>
            E-mail: secretaria@seminariohosana.com.br</p>

            <p style='font-weight: bold;'>ATT.<br> Equipe do Hosana</p>
            
            <p style='font-size:xsmall'>E-mail enviado automaticamente pelo sistema on-line do Hosana. Não responder e não usar este e-mail (hosana.sis@gmail.com) para qualquer tipo de comunicação com o S.H.</p>
        </body>
    </html>";

    if ($status == 'on') {

         /*
          * PHP Mailer 6
          *
          */
        require ("./phpmailer/phpmailer_6/src/Exception.php");
        require ("./phpmailer/phpmailer_6/src/PHPMailer.php");
        require ("./phpmailer/phpmailer_6/src/SMTP.php");


        //Nova instância do PHPMailer
        $mail = new PHPMailer(true);                        //Informa que será utilizado o SMTP para envio do e-mail
        try {
            //Server settings
            require_once ('i_phpmail_config.php');
            
            //Recipients
            $mail->AddAddress ($email);                      //E-mail para a qual o e-mail será enviado
            $mail->AddBcc("lisanias@hotmail.com");          //cópia oculta 
            
            //Content
            $mail->IsHTML(true);                            // Define que o e-mail será enviado como HTML
            $mail->Subject    = $subject;                   //Titulo do e-mail que será enviado
            $mail->MsgHTML ($message) ;
            $mail->AltBody = "Seu email não suporta texto HTML";

            /*Echo "<pre>";
            var_dump($mail);
            Echo "</pre><hr /><p>fim da variavek mail";*/
            
            // opçoes para enviar do localhost
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );;

            //Dispara o e-mail
            $mail->Send();

            // Mensagem para o usuário 
            $_SESSION["msg"]= "Email enviado!";
            $_SESSION['msg_tipo']="alert-success";

            // Envia para a página de resposta
            header("location: aluno.recuperar.senha.enviado.php");
            exit;

        } catch (Exception $e) {

            /*echo '<pre>';
            var_dump($mail);
            echo "<br><p>Erro:_________ {$mail->ErrorInfo}</p>";
            die();*/
            
            // Mensagem para o usuário
            $_SESSION["msg"] = "Não foi possivel enviar o e-mail de recuperação! <br /> (<i> {$mail->ErrorInfo} </i>)";
            
            header("location: aluno.recuperar.senha.php");
            exit;

        }
    }

    //Off-line
    else {
        $urlCode = base64_encode($url[$urlAtual].'/aluno.senha.reset.php?token='.$hash.'&email='.$email);
        header("location: aluno.recuperar.senha.off.php?url={$urlCode}");
        exit;
    }

}