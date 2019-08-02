<?php
include("aluno.seguranca.php"); // Inclui o arquivo com o sistema de segurança
include("i_funcoes.php"); // inserir o arquivo com a funções de rotina

// todo: criar uma verificao se o aluno ja tem alguma matricula para esse evento
// verificar a chave id_aluno . di_evento - so pode ter um
   
    // pegar vairiaveis do formulario
    $id_curso = $_POST['id_curso'];
    $id_evento = $_POST['id_evento'];
    $id_aluno = $_SESSION['id_aluno'];
	$hospedagem = $_POST['hospedagem'];
	$vagas = $_POST['vagas'];
    $obs = $_POST['obs'];
	$data_comprovante = date("d/m/Y",time()+(3*24*60*60));
	$data_comprovanteSQL = date("Y-m-d",time()+(3*24*60*60));
    
    // verficar se tem o modulo cadastrado com esse evento e curso
    $sql = "SELECT * FROM modulo WHERE id_curso = ".$id_curso." and id_evento = ".$id_evento;
        
    $tabela = mysqli_query($con,$sql);
    $linhas = mysqli_num_rows($tabela);

    if ($linhas == 0) {
        $_SESSION["msg"] = "Ainda não tem um módulo cadastrado para esse curso nessa data!
                            <br>Favor cadastrar primeiro o módulo ({$id_curso} - {$id_evento} - {$id_aluno} - linhas: {$linhas})";
        $_SESSION['msg_tipo']="alert-error";
        header("location: ".$_SERVER['HTTP_REFERER']);
        exit;
    }
    else {
        $dados = mysqli_fetch_array($tabela);
        $id_modulo = $dados['id_modulo'];
    }
	
	// verificar a situação das vagas e definir o status conforme a vaga
	// e caso não haja vaga verifica a hospedagem para definir se está 
	// em fila de espera ou é uma inscrição sem hospedagem.
	
	if($vagas > 0){
		$vagas_status = '2';
	} elseif($hospedagem == 1){
		$vagas_status = '1';
	} else {
		$vagas_status = '2';
	}
	
    // verificar se tem algum desconto (por causa da hospedagem)
	if ($hospedagem == 0){
		if ($id_curso == 6) {
			$desconto = 400;
		} else {
			$desconto = 80;
		}
	} else {
		$desconto = 0;
	}
	
	// instruções sql para guradar informações na BD

    $sql = "INSERT INTO matricula (
              id_aluno,
              id_evento,
              id_modulo,
              data_matricula,
			  data_comprovante,
              status,
			  desconto,
			  hospedagem,
              obs
            )
            VALUES (
              '".$id_aluno."',
              '".$id_evento."',
              '".$id_modulo."',
              NOW(),
			  '".$data_comprovanteSQL."', 
              '".$vagas_status."',
			  '".$desconto."',
			  '".$hospedagem."',
              '".$obs."'
            )";

    $inserir = mysqli_query($con, $sql);

    $nova_matricula_id = mysqli_insert_id($con);
	$nova_matricula_id_cod = base64_encode($nova_matricula_id);

    if ($inserir) {
        $_SESSION["msg"]= $TEXT['msg_incricao_feita'];
        $_SESSION['msg_tipo']="alert-success";
        header("location: reinscricao.comprovante.php?id={$nova_matricula_id_cod}");
        exit;
    }
    else {
        //$_SESSION["msg"] = $TEXT['msg_erro_conection']."<br />".$data_pg."<br>".mysqli_error($con);
        //$_SESSION['msg_tipo']="alert-error";
        //header("location: ".$_SERVER['HTTP_REFERER']);
		
		echo mysqli_error($con);
		echo "<br>{$data_comprovanteSQL}";
    }

    exit;


?>