<?php 
// definir variáveis da página
$pg_titulo = "Aluno - Hosana SiS";
$pg_nome = "aluno.php";
$pg_menu = "academico";

// Incluir informações iniciais agrupadas
include_once('./lang/pt-br.php');
include_once('./inc/iniciar.php');
include_once('./inc/seguranca.php');


if (isset($_GET['session'])) {
	$default_session_id = $_GET['session'];
} else {
	$default_session_id = $_SESSION['evento'];
}

$id_aluno = isset($_GET['id'])?base64_decode($_GET['id']):'';
$atp = isset($_GET['atp'])?base64_decode($_GET['atp']):'';

if ($atp == 'novo') { 

    $sql = "INSERT INTO audio_pendrive 
    	(id_aluno, id_evento)
    	VALUES 
    	({$id_aluno}, $default_session_id)
    	"; 

    $inserir = mysqli_query($con, $sql);
    	
    if ($inserir) {
            
            $_SESSION["msg"]= "Pedido de pendrive registrado.".mysqli_error($con);
            $_SESSION['msg_tipo']="alert-success";
            header("location: audio.pen.pedido.php?id=".base64_encode($id_aluno));
            exit;
        }
        else {
            $_SESSION["msg"] = "Não foi possível registrar o pedido de pendrive!".mysqli_error($con);
            $_SESSION['msg_tipo']="alert-error";
            header("location: aluno.php?id=".base64_encode($id_aluno));
            exit;
        }
    
}

if ( $atp == "mudar" ) {

    $pago = isset($_POST['pago'])?1:0;
    $entregue = isset($_POST['entregue'])?1:0;
    $data_entregue = ($entregue==1)?"data_entregue = '".date('Y-m-d H:i:s')."'":"data_entregue = null";
    $obs_pen = isset($_POST['obs_pen'])?$_POST['obs_pen']:' ';

    //echo '<br>pago: ', $pago, '<br>entregue: ', $entregue, '<br> aluno:', $id_aluno;
    //exit;

    $sql = "UPDATE audio_pendrive
    SET pago = '{$pago}',
        entregue =  '{$entregue}',
        obs_pen = '{$obs_pen}',
        {$data_entregue}
    WHERE id_aluno = '{$id_aluno}' ";

     //executar instrução SQL
    $atualiza = mysqli_query($con,$sql);

    if ($atualiza) {

        // adicionamos a mensagem para ecibir na próxima página
        $_SESSION['msg']= "Alteração de pedido salvo";
        $_SESSION['msg_tipo']="alert-success";

        header("location: audio.pen.pedido.php?id=".base64_encode($id_aluno));
        exit;
    }
     else {
        $_SESSION["msg"] = "Não foi possível registrar o pedido de pendrive!".mysqli_error($con);
        $_SESSION['msg_tipo']="alert-error";
        header("location: audio.pen.pedido.php?id=".base64_encode($id_aluno));
        exit;
    }
    
}


# APAGAR
if ($atp == 'del') { 

    $id_pen = base64_decode($_GET['id']);

    $sql =  "DELETE FROM audio_pendrive
            WHERE id_pen = ". $id_pen ;

    $db_acao = mysqli_query($con, $sql);
        
    if ($db_acao) {
            
            $_SESSION["msg"]= "Pedido de pendrive apagado.".mysqli_error($con);
            $_SESSION['msg_tipo']="alert-success";
        }
        else {
            $_SESSION["msg"] = "Não foi possível apagar o pedido de pendrive!".mysqli_error($con);
            $_SESSION['msg_tipo']="alert-error";
        }

    header("location: audio.pen.php");
    exit;
    
}					
