<?php
//cria sessão
session_start();

include 'i_mysql_conn.php';
include 'classes.php';

$sql = "SELECT * FROM config";
$tabela = mysqli_query($con,$sql);
$config = mysqli_fetch_array($tabela);

// grava a variaveis para a cessão atual
$_SESSION['evento_atual'] = $config["evento_padrao"];

$sql = "SELECT * FROM evento WHERE id_evento = {$_SESSION['evento_atual']}";
$tabela = mysqli_query($con,$sql);
$evento = mysqli_fetch_array($tabela);

// grava a variaveis para a cessão atual
$_SESSION['evento_atual_nome'] = $evento["descricao"];
$_SESSION['evento_iw'] = $evento['insc_web'];
$_SESSION['evento_data_ini'] = $evento['data_ini'];
$_SESSION['evento_data_fim'] = $evento['data_fim'];
$_SESSION['evento_id_local'] = $evento['id_local'];

// pegar mensagem de alerta enviadas para a página
# iniciar a variavel $msg
$msg='';
if (isset($_GET['msg'])) { // enquanto não está feita a transiçao para session
	$msg = base64_decode($_GET['msg']);
}
if (isset($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
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

//mysqli_close($con);

//Codigo para codificação da senha
define("SALT", "AjFqu8J8vC");
define("LOGO", "<a class='brand' href='http://www.seminariohosana.com.br'>Seminário Hosana</a>");
define("BOTTON_A", "<div class='pull-right'><small>SiS 1.2.0-07.2018</small></div><p><img src='img/favicon.png' alt='WebiGSiS' width='24' height='24'> &copy; WebiGSiS 2013 </p>");
$status = 'off';    // Define se estamos trabalhando 'on' ou 'off' line. Se estiver em hostigator vai mudar automaticamente para on.
?>