<?php
// definir variáveis da página


// Incluir informações iniciais agrupadas
include_once('./lang/pt-br.php');
include_once('./inc/iniciar.php');
include_once('./inc/seguranca.php');

// pega as variaveis enviadas e decodifica
$acao = base64_decode($_GET['atp']); # Acao para Processar


// ALTERAR STATUS DA MATRICULA
if ($acao == "matricula_alterar_status") {

    // pegar variável aux e id para este procedimento
    $statusset = $_GET['aux'];
    $id = base64_decode($_GET['id']);

    // instrução sql
    $sql = "UPDATE matricula
    SET status = ".$statusset."
    WHERE id_matricula = ". $id;

    //executar instrução SQL
    $atualiza = mysqli_query($con,$sql);

    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']="Status da matrícula alterado";
    $_SESSION['msg_tipo']="alert-success";

    // registra quem fez a mudança
    Quem::insert($con, 'matricula', $id, 'Alterar status para '.fsr($statusset)); 

    // redirecionamos a pagna para onde estava antes
    header("location: ".$_SERVER['HTTP_REFERER']);
    exit;
}

// ALTERAR STATUS DO PAGAMENTO
if ($acao == "pagamento_alterar_status") {

    // Pegar variáveis
    $statusset = $_GET['aux'];
    $idp = base64_decode($_GET['idp']);
    $ida = base64_decode($_GET['ida']);

    // instrução sql
    $sql = "UPDATE pagamento
    SET status = $statusset
    WHERE id_pagamento = ". $idp;

    //executar instrução SQL
    $atualiza = mysqli_query($con,$sql);

    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Status do pagamento Alterado. <br />Atenção: se for preciso, altere também o status da matricula <a class='btn-link' href='aluno.php?id=".base64_encode($ida)."' >aqui</a>.";
    $_SESSION['msg_tipo']="alert-success";

    // registra quem fez a mudança
    Quem::insert($con, 'pagamento', $idp, 'Alterar status de pagamento "'.function_pg_status($statusset).'"');

    // redirecionamos a pagna para onde estava antes
    header("location: ".$_SERVER['HTTP_REFERER']."&atpr=".base64_encode($ida));
    exit;
}

// ALTERAR HOSPEDAGEM
if ($acao == "hospedagem_alterar") {

    // pegar variável aux e id para este procedimento
    $hospedagemset = $_GET['aux'];
    $id = base64_decode($_GET['id']);

    // instrução sql
    $sql = "UPDATE matricula
    SET hospedagem = ".(int)$hospedagemset."
    WHERE id_matricula = ". (int)$id;

    //executar instrução SQL
    $atualiza = mysqli_query($con,$sql);

    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']="O tipo de hospedagem do aluno foi mudado!";
    $_SESSION['msg_tipo']="alert-success";

    // registra quem fez a mudança
    Quem::insert($con, 'matricula', $id, 'Alterar hospedagem para "'. ($hospedagemset==0?'não':'sim') .'"');

    // redirecionamos a pagna para onde estava antes
    header("location: ".$_SERVER['HTTP_REFERER']);
    //echo $hospedagemset;
    exit;
}

// ALTERAR DADOS DO PAGAMENTO
if ($acao == "alterar_pagamento_dados") {

    // Pegar variáveis
    $idp = base64_decode($_GET['idp']);
    $data_pg = $_POST['data_pg'];
    $descricao = $_POST['descricao'];
    $complemento = $_POST['complemento'];
    $forma_pg = $_POST['forma_pg'];
    $refa = $_POST['refa'];
    $valor = $_POST['valor'];

    // instrução sql
    $sql = "UPDATE pagamento
    SET
    data_pg = '".implode('-',array_reverse(explode('/',$data_pg)))."',
    descricao = '".$descricao."',
    complemento = '".$complemento."',
    forma_pg = '".$forma_pg."',
    ref_a = '".$refa."',
    valor = '".valor_ok($valor)."'
    WHERE id_pagamento = ". $idp ;

    //executar instrução SQL
    $atualiza = mysqli_query($con,$sql);

    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']= "Dados de pagamento Alterado com sucesso. ".mysqli_error($con);
    $_SESSION['msg_tipo']="alert-success";

    // registra quem fez a mudança
    Quem::insert($con, 'pagamento', $idp, 'Alterar pagamento');

    // redirecionamos a pagna para onde estava antes
    header("location: ".$_SERVER['HTTP_REFERER']."&atpr=".base64_encode($idp));
    exit;
}

if ($acao == "editar_dados_do_aluno"){
    $id_aluno = $_POST['id_aluno'];
    $sql="UPDATE alunos SET
                nome='" . $_POST['inputNome'] . "',
                sobrenome='" . $_POST['inputSobrenome'] . "',
                endereco='" . $_POST['inputEndereco'] . "',
                complemento='" . $_POST['inputComplemento'] . "',
                bairro='" . $_POST['inputBairro'] . "',
                cidade='" . $_POST['inputCidade'] . "',
                uf='" . $_POST['inputUF'] . "',
                cep='" . $_POST['inputCEP'] . "',
                tres='" . $_POST['inputTres'] . "',
                tcel='" . $_POST['inputTcel'] . "',
                email='" . $_POST['inputEmail'] . "',
                sexo='" . $_POST['inputSexo'] . "',
                dnas='" . implode('-',array_reverse(explode('/',trim($_POST['inputDnas'])))) . "',
                estado_civil='" . $_POST['inputEC'] . "',
                igreja='" . $_POST['inputIgreja'] . "',
                obs='" . $_POST['inputObs'] . "'
		    WHERE id_aluno = '" . $id_aluno . "'";

    $atualiza = mysqli_query($con, $sql);
    if ($atualiza) {
        $_SESSION["msg"]="Dados alterados com sucesso";
        $_SESSION['msg_tipo']="alert-success";
        // registra quem fez a mudança
        Quem::insert($con, 'alunos', $id_aluno, 'Alterou alguma informaçao do aluno ');
        header("location: aluno.php?id=".base64_encode($id_aluno));
        exit;
    }
    else {
        $_SESSION["msg"] = "Houve algum problema com a tabela de dados.".mysqli_error($con);
        $_SESSION['msg_tipo']="alert-error";
        header("location: ".$_SERVER['HTTP_REFERER']);
    }
    exit;
}

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// inserir pagamento para uma determinada matricula

if ($acao == 'add_pagamento') {

    // pegar variáveis enviadas pelo formulário: pagamento.add.php
    $id_aluno = (int)$_POST['id_aluno'];
    $id_matricula = (int)$_POST['id_matricula'];
    $data_pg = implode('-',array_reverse(explode('/',trim( $_POST['data_pg']))));
    $descricao = $_POST['descricao'];
    $complemento = $_POST['complemento'];
    $forma_pg = $_POST['forma_pg'];
    $refa = $_POST['refa'];
    $valor = $_POST['valor'];
    $comprovante = "";

    // verifica se tem algum arquivo para fazer upload
    if ($_FILES['input_arquivo']['size']>0)
    {
        // Verificar o tipo de arquivo
        // ceita jpg gif e png
        $arquivo = $_FILES['input_arquivo'];

        if ($arquivo['type'] == "image/jpeg" || $arquivo['type']== "image/pjpeg" || $arquivo['type']== "image/png" || $arquivo['type']== "image/gif" )
        {
            // arquivo aceito - continua
        } else{
            $_SESSION["msg"] = "Arquivo inválido. É permitido somente imagem com extensão .jpg, .png e gif. ".mysqli_error($con);
            $_SESSION['msg_tipo']="alert-success";
            exit(header("location: ".$_SERVER['HTTP_REFERER']));
        }

        // verificar se o tamanho do arquivo é menor que 1Mb
        if ($arquivo['size']>1048576)
        {
            $_SESSION["msg"] = "Arquivo muito grande. Tamanho máximo permitido 1Mb. O arquivo que está tentando enviar tem ".round($arquivo['size']/1024)."Kb<br><br>";
            $_SESSION['msg_tipo']="alert-success";
            exit(header("location: ".$_SERVER['HTTP_REFERER']));
        }

        // dar um novo nome ao arquivo
        $novonome = $id_aluno . "." . md5(uniqid(time())).'.jpg';


        // envia para o servidor
        $dir = "upload/pg/" . $_SESSION['evento'] . "/";
        $dir_real = '../upload/pg/' . $_SESSION['evento'] . '/'; // Posição relativa...
        if (!file_exists($dir_real))
        {
            echo "Arquivo nao existe";
            exit;
            mkdir($dir_real, 0755);
        }
        $comprovante = $dir.$novonome;
        $caminho_real = $dir_real.$novonome;
        move_uploaded_file($arquivo['tmp_name'],$caminho_real);

        // arquivo envido

    } else {
        $comprovante = "upload/pg/pagamentolivre.jpg";
    }


    // instrução SQL
    $sql = "
    INSERT INTO
      pagamento
      (
        id_matricula,
        data_add_pg,
        data_pg,
        descricao,
        valor,
        forma_pg,
        comprovante,
        status,
        ref_a,
        complemento)
      VALUES
      (
        ".$id_matricula.",
        NOW(),
        '".$data_pg."',
        '".$descricao."',
        '".valor_ok($valor)."',
        '".$forma_pg."',
        '".$comprovante."',
        3,
        ".$refa.",
        '".$complemento."'
      )
    ";

    $inserir = mysqli_query($con, $sql);

    if ($inserir) {
        // registra quem fez a mudança
        Quem::insert($con, 'pagamento', mysqli_insert_id($con), 'Adicionou pagamento para a matricula: '.$id_matricula);

        $_SESSION["msg"]= $TEXT['msg_pag_inserido']." ".mysqli_error($con);
        $_SESSION['msg_tipo']="alert-success";
        header("location: aluno.php?id=".base64_encode($id_aluno));
        exit;
    }
    else {
        $_SESSION["msg"] = $TEXT['msg_erro_conection']."<br />".$data_pg."<br>".mysqli_error($con);
        $_SESSION['msg_tipo']="alert-error";
        header("location: ".$_SERVER['HTTP_REFERER']);
    }
    exit;
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Apagar um pagamento

if ($acao == "apagar_pagamento") {
    $id_pagamento = base64_decode($_GET['idpagamento']);
	$id_aluno = $_GET['idaluno'];

    $sql = "
        DELETE FROM pagamento
        WHERE id_pagamento = ". $id_pagamento
    ;

    //$dellid = mysqli_query($con, $sql);

    if (mysqli_query($con, $sql)) {
        // registra quem fez a mudança
        Quem::insert($con, 'pagamento', $id_pagamento, 'Apagou um pagamento');

        $_SESSION["msg"] = $TEXT['del_pagamento_msg'];
        $_SESSION['msg_tipo']="alert-success";
        header("location: aluno.php?id=".$id_aluno);
    }
    else {
        $_SESSION["msg"] = $TEXT['msg_erro_conection'] ."<br>".mysqli_error($con) ;
        $_SESSION['msg_tipo']="alert-error";
        header("location: ".$_SERVER['HTTP_REFERER']);
    }


    exit;
}

if ($acao=="add_inscricao") {
    
    // pegar vairiaveis do formulario
    $id_curso = $_POST['id_curso'];
    $id_evento = $_POST['id_evento'];
    $id_aluno = $_POST['id_aluno'];
	$hospedagem = 1;
    $obs = $_POST['obs'];

    if ( $id_curso == 6){
        $hospedagem = 0;
        $desconto = 400;
    }

    // verificar se é o curso 7 -> Escola do sobrenatural e tirar hopedagem e colocar o valor certo.
    if ($id_curso==7){
        $hospedagem = 0;

    }
    
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

    $sql = "INSERT INTO matricula (
              id_aluno,
              id_evento,
              id_modulo,
              data_matricula,
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
              4,
              '".$desconto."',
			  '".$hospedagem."',
              '".$obs."'
            )";

    $inserir = mysqli_query($con, $sql);

    $nova_matricula_id = mysqli_insert_id($con);

    if ($inserir) {
        // registra quem fez a mudança
        Quem::insert($con, 'matricula', mysqli_insert_id($con), 'Adicionou uma nova matricula para '.$id_aluno);

        $_SESSION["msg"]= $TEXT['msg_incricao_feita'];
        $_SESSION['msg_tipo']="alert-success";
        header("location: pagamento.add.php?id=".base64_encode($nova_matricula_id));
        exit;
    }
    else {
        $_SESSION["msg"] = $TEXT['msg_erro_conection']."<br />".$data_pg."<br>".mysqli_error($con);
        $_SESSION['msg_tipo']="alert-error";
        header("location: ".$_SERVER['HTTP_REFERER']);
    }

    exit;
}

// alterar dados da inscrição
if ($acao=="edit_inscricao") {
    
    // pegar vairiaveis do formulario
    $id_matricula = $_POST['id_matricula'];
	$id_aluno = $_POST['id_aluno'];
	$id_curso = $_POST['id_curso'];
    $id_evento = $_POST['id_evento'];
	$hospedagem = $_POST['hospedagem'];
    $desconto = $_POST['desconto'];
    $comprovante = implode('-',array_reverse(explode('/',trim( $_POST['comprovante'] ))));
    $obs = $_POST['obs'];
    
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

    $sql = "UPDATE matricula SET 
              id_evento = '". $id_evento . "',
	      id_modulo = '".$id_modulo."',
              hospedagem = '".$hospedagem."',
              desconto = '".valor_ok($desconto)."',
              data_comprovante = '".$comprovante."',
              obs = '".$obs."'
            WHERE
              id_matricula = '".$id_matricula."'";

    $atualizar = mysqli_query($con, $sql);
	
	/* echo "qual o erro?" . mysqli_error($con);
	echo "<br>";
	echo "matricula: " . $id_matricula . " aluno: ". $id_aluno ." curso: ". $id_curso ." evento: ". $id_evento . " hopedagem: ". $hospedagem . " osb: ".  $obs . " modulo: ". $id_modulo;
	echo "<br>";
	echo "sql: " . $sql;
	exit; */
	
    if ($atualizar) {
        // registra quem fez a mudança
        Quem::insert($con, 'matricula', $id_matricula, 'Alterou a matricula');

        $_SESSION["msg"]= "Alteração realizada com sucesso!";
        $_SESSION['msg_tipo']="alert-success";
        header("location: aluno.php?id=".base64_encode($id_aluno));
        exit;
    }
    else {
        $_SESSION["msg"] = $TEXT['msg_erro_conection']."<br />".$data_pg."<br>".mysqli_error($con);
        $_SESSION['msg_tipo']="alert-error";
        header("location: ".$_SERVER['HTTP_REFERER']);
    }

    exit;
}


// ATRIBUIR HOSPEDAGEM PARA O ALUNO - DEFINIR O QUARTO
if ($acao=='atribuir_hospedagem') {
    if (isset($_POST['quarto'])){
        $sql = "UPDATE matricula
                    SET
                    id_cama =" . $_POST['quarto'] . "
                    WHERE id_matricula = ". $_POST['id_matricula'];

        $atualizar = mysqli_query($con, $sql);

        if ($atualizar) {
            // registra quem fez a mudança
            Quem::insert($con, 'matricula', $_POST['id_matricula'], 'Hospedagem atribuido - '.$_POST['quarto']);

            $_SESSION["msg"]= "Quarto atribuido com sucesso";
            $_SESSION['msg_tipo']="alert-success";
            // header("location: aluno.php?id=".base64_encode($_POST['id_aluno']));
    		header("location: hospedagem.php");
            exit;
        }
        else {
            $_SESSION["msg"] = $TEXT['msg_erro_conection']."<br />".$data_pg."<br>".mysqli_error($con);
            $_SESSION['msg_tipo']="alert-error";
            header("location: ./hospedagem.php");
        }

    exit;
    }
}

// tirar do quarto
// zerar o campo cama (id_cama) da ficha de incrição
if ($acao=='tirar_do_quarto') {
    if (isset($_GET['id'])){
        
        $id_matricula = base64_decode($_GET['id']);
        $sql = "UPDATE matricula
                    SET
                    id_cama = 0
                    WHERE id_matricula = ".$id_matricula;

        $atualizar = mysqli_query($con, $sql);

        if ($atualizar) {

            // registra quem fez a mudança
            Quem::insert($con, 'matricula', $id_matricula, 'Tirado do quarto');

        $_SESSION["msg"]= "O aluno foi tirado do quarto em que estava";
        $_SESSION['msg_tipo']="alert-success";
        // header("location: aluno.php?id=".base64_encode($_POST['id_aluno']));
		header("location: hospedagem.quartos.php");
        exit;
    }
    else {
        $_SESSION["msg"] = $TEXT['msg_erro_conection']."<br />".$data_pg."<br>".mysqli_error($con);
        $_SESSION['msg_tipo']="alert-error";
        header("location: ./hospedagem.php");
    }

    exit;
    }
}


// Entregar apostila
// 0 ou " " (vazio) é não entregue, 1 = apostila entregue
// campo apostila em tbl inscricao
if ($acao == "entregar_apostila_ao_aluno") {

    // pegar variável aux e id para este procedimento
    $id_aluno = base64_decode($_GET['id_aluno']);
    $id = base64_decode($_GET['id']);

    // instrução sql
    $sql = "UPDATE matricula
    SET apostila = 1
    WHERE id_matricula = ". $id;

    //executar instrução SQL
    $atualiza = mysqli_query($con,$sql);

    // adicionamos a mensagem para ecibir na próxima página
    $_SESSION['msg']="Apostila entregue";
    $_SESSION['msg_tipo']="alert-success";

            // registra quem fez a mudança
            Quem::insert($con, 'matricula', $id, 'Apostila entrega para o aluno '.$id_aluno);


    // redirecionamos a pagna para onde estava antes
	header("location: aluno.php?id=".base64_encode($id_aluno));
    exit;
}

if ($acao == "pendencia_resolver") {

    // id da pendencia
    $id = base64_decode($_GET['id']);

    // instrução sql
    $sql = "UPDATE pendencia
    SET resolvido = 1
    WHERE id = ". $id;

    //executar instrução SQL
    $atualiza = mysqli_query($con,$sql);

    if($atualiza){

        // adicionamos a mensagem para ecibir na próxima página
        $_SESSION['msg']="Pendencia Resolvida";
        $_SESSION['msg_tipo']="alert-success";

        // registra quem fez a mudança
        Quem::insert($con, 'pendencia', $id, 'Resolveu a pendencia numero '.$id);


        // redirecionamos a pagna para onde estava antes
        header("location: aluno.php?id=".$_GET['id_aluno']);
        exit;
    } else {
        $_SESSION['msg']="Atenção houve algum erro! Erro:".mysqli_error($con);
        $_SESSION['msg_tipo']="alert-danger";
        header("location: aluno.php?id=".$_GET['id_aluno']);
        exit;
    }
}
echo "houve algum erro!...."

?>