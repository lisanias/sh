<?php

//timezone
date_default_timezone_set('Europe/London');

//cria sessão
session_start();

// salt para segurança das senhas com 12 caracteres!
const SALT = 'qyW2rPk59iI1';

// versão do aplicativo
const VERSAO = 'SiS 1.2.0-07.2018';

// Arquivo com o texto em PT-BR
include_once('./lang/pt-br.php');

// Arquivos de calsses
include_once('./class/Quem.class.php');

// incluir arquivo de com variáveis iniciais e contantes globais
include_once('./inc/funcoes.php');

//faço a conexão com o banco (hosr, user, password, dbase)
$con = mysqli_connect('localhost', 'sagra213_hosana', 'lucas#3$1', 'sagra213_hosana');
	// verificar a conexão
	if (mysqli_connect_error($con))
	  {
	  $_SESSION['msg'] = "Falha ao conectar com o banco de dados, erro: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")<br>";
	  $_SESSION['msg_tipo'] = "alert-error";
	  }

// transformar caracteres da conexção $con em utf8
mysqli_set_charset( $con, 'utf8');

// verificar se selecionou um outro evento como padrão para a seçao
if (isset($_GET['eventosession'])){
    $_SESSION['evento']=$_GET['eventosession'];
}
if (isset($_GET['evento_nome'])){
    $_SESSION['evento_nome']=$_GET['evento_nome'];
}
if (isset($_GET['evento_dataini'])){
    $_SESSION['dataini']=$_GET['evento_dataini'];
}

// verficar se tem alguma mensagem de erro
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

// informar o tipo da mensagem de erro para formatação
// Tipo: alert-success; alert-error; alert-info; " " (sem nada fica amarelo);
if (isset($_SESSION['msg_tipo'])) {
    $msg_tipo = $_SESSION['msg_tipo'];
    unset($_SESSION['msg_tipo']);
} else {
	$msg_tipo = "alert-error";
}

// verificar em qual evento está trabalhando no momento
/* Ele entra no evento padrão gravado na base de dados em eventos se não 
 * tiver nenhum outro evento seleciona através do aplicativo.
 * Se tiver ele verifica na session escolhida e não na Base de dados.
 */

// abrir base de dados de configuração e pegar o evento padrão
$sql = "SELECT * FROM config WHERE id_config = 1";
$consulta = mysqli_query($con,$sql);
$dados = mysqli_fetch_array($consulta);
$id_evento_padrao = $dados['evento_padrao'];

if (!isset($_SESSION['evento'])) {
    
	$sql = "SELECT * FROM evento WHERE id_evento = {$id_evento_padrao}";
	$consulta = mysqli_query($con,$sql);
	$dados = mysqli_fetch_array($consulta);
	
	if ($dados) {
		if (mysqli_num_rows($consulta) > 1) {
			$msg .= "Mais que um evento padrão - Corija a Base de Dados";
		}
		$_SESSION['evento'] = $dados['id_evento']; 
		$_SESSION['evento_nome'] = $dados['descricao'];
		$_SESSION['vagas_web'] = $dados['insc_web'];
		$_SESSION['local'] = $dados['id_local'];
		$_SESSION['dataini'] = $dados['data_ini'];
	}
}

?>