<?php
$mail->SMTPDebug  = 0;
$mail->IsSMTP(); 								//Informa que a conexão com o SMTP será autênticado

###### CONFIGURAÇÃO DO GMAIL ######
//$mail->Host       = "smtp.gmail.com"; 			//"smtp.gmail.com"; // 'mail.webig.pro.br';// sets GMAIL as the SMTP server
//$mail->Username   = "lisaniasloback@gmail.com"; //"hosana.sis@gmail.com"; // 'sis@webig.pro.br'; //Usuário para autênticação do SMTP
//$mail->Password   = 'laryssa2001'; 				//"msm@731.731"; //Senha para autênticação do SMTP

##### CONFIGURAÇÃO DO HOSTGATOR ######
$mail->Host       = "mail.webig.pro.br"; 			//"smtp.gmail.com"; // 'mail.webig.pro.br';// sets GMAIL as the SMTP server
$mail->Username   = "sis@webig.pro.br"; //"hosana.sis@gmail.com"; // 'sis@webig.pro.br'; //Usuário para autênticação do SMTP
$mail->Password   = 'lucas#3$1'; 				//"msm@731.731"; //Senha para autênticação do SMTP

$mail->SMTPAuth   = true; 						//Configura a segurança para SSL
$mail->SMTPSecure = 'ssl'; 						//Informa a porta de conexão tls/ssl
$mail->Port       = 465; 						//Informa o HOST 465, 587 
$mail->CharSet 	  = 'utf-8'; 					// Charset da mensagem (opcional)

$mail->setFrom    ("sis@webig.pro.br", "Seminário Hosana - SiS");            //Preenchimento do campo FROM do e-mail
// $mail->addReplyTo('hosana.sis@gmail.com', 'SH Sistemas');
            