<?php
/*
 * 
 * Página de pagamento na cielo
 * 
 */

//ini_set("display_errors", 1);
//error_reporting(E_ALL) ;

/* 
 * Segurança - ver se está logado
 */

        include(dirname(__DIR__).'../../i_secao.evento.default.php');

        // Verifica se existe os dados da sessão de login
        if (!isset($_SESSION["usuario"]) || !isset($_SESSION["senha"]))
        {
            // Usuário não logado! Redireciona para a página de login
            $_SESSION['msg'] = "Você precisa estar logado para acessar esta página";
            header("Location: ../../aluno.login.php");
            exit;
        }


        // Usa a função addslashes para escapar as aspas
        $usuario = $_SESSION["usuario"];
        $senha = $_SESSION["senha"]; //senha ja codificada quando se definiu a variavel session

        // Monta uma consulta SQL para verficicar se a senha não foi mudada
        $sql = "SELECT * FROM alunos where login='".$usuario."' and senha='".$senha."'";

        $tabela = mysqli_query($con,$sql);
        $user = mysqli_fetch_array($tabela);

        if (!isset($user)) {
            $_SESSION["msg"] = "Houve algum problema com a segurança ou você alterou a sua senha e precisa fazer um novo login.";
            header("Location: aluno.login.php");
            exit;
        }
        // continua logado

/*
 *  FIM Segurança
 */

//Cria um token
$_SESSION['token'] = md5(uniqid(rand(), true));

include(dirname(__DIR__)."../../i_funcoes.php");


/*
 * Pegar dados do aluno
 */
    $sql = "SELECT * FROM alunos WHERE id_aluno = " . $_SESSION['id_aluno'];
    $consulta = mysqli_query($con,$sql);
    $aluno = mysqli_fetch_array($consulta);
/*
 *  FIM dados do aluno
 */

/*
 * Pegar curso selecionado
 */
$sql = "SELECT * FROM matricula 
		INNER JOIN 
			modulo ON matricula.id_modulo = modulo.id_modulo 
		INNER JOIN 
			cursos ON modulo.id_curso = cursos.id_curso 
		WHERE id_aluno = {$_SESSION['id_aluno']} AND matricula.id_evento = {$_SESSION['evento_atual']}";
$consulta = mysqli_query($con,$sql);
$curso = mysqli_fetch_array($consulta);
// FIM curso selecionado

// pegar dados do pagamento com cartão
if (isset($_SESSION['pg_cartao'])) {
    $pg_cartao_id = $_SESSION['pg_cartao'];
    unset($_SESSION['pg_cartao']);
} else {
    header("Location: ../../aluno.home.php");
    }
$sql = "SELECT * FROM pag_cartao WHERE id = " . $pg_cartao_id;
$consulta = mysqli_query($con,$sql);
$pag_cartao = mysqli_fetch_array($consulta);


// mensagens de erros
// verficar se tem alguma mensagem de erro
if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}
// informar o tipo da mensagem de erro para formatação
// Tipo: alert-success; alert-danger; alert-info; alert-warning;
if (isset($_SESSION['msg_tipo'])) {
    $msg_tipo = $_SESSION['msg_tipo'];
    unset($_SESSION['msg_tipo']);
} else {
	$msg_tipo = "alert-danger";
}


?>
<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v4.0.1">
        <title>Hosana - Pagamento com cartão</title>

        <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
        }
        }

        .container {
            max-width: 960px;
        }

        .lh-condensed { 
            line-height: 1.25; 
        }
    </style>


    <!-- Favicons -->
    <link rel="apple-touch-icon" href="img/icon/apple-icon-180x180.png" sizes="180x180">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" href="img/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/icon/favicon-96x96.png">
    <link rel="icon" href="img/icon/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="img/icon/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="img/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#563d7c">
    <meta name="msapplication-TileImage" content="img/icon/ms-icon-144x144.png">
    <link rel="mask-icon" href="img/logohosana_icon.svg" color="#563d7c">
    <link rel="icon" href="img/icon/favicon.ico">
    <meta name="theme-color" content="#563d7c">

  </head>
<body class="bg-light">
 <div class="container">

    <!-- Menu de Navegação - TOP Navbar -->
    <nav class="navbar navbar-light bg-light">
        <!-- Logo e Nome -->
        <a class="navbar-brand" href="#">
            <img src="img/logohosana_favicon.svg" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            HOSANA
        </a>
        <!-- Menu de info do lado direito -->
        <div class="form-inline my-2 my-lg-0">
            <?=  $_SESSION["nome"]. " " . $_SESSION["sobrenome"] ; ?>
        </div>
    </nav>
    
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-3" src="img/logohosana_icon.svg" alt="" width="72" height="72">
        <h2 class='mb-5'>Seminario Hosana</h2>
        <div class="jumbotron text-center ">
            <h1 class="display-4">Pagamento realizado com sucesso!</h1>
        </div>
    </div>

    <!-- Mensagem de erro -->
    <?php if (isset($msg)) { ?>        
        <div class="alert <?=$msg_tipo?>" align="center" role="alert">
            <?=$msg?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

        
    <div class='row mb-4'><!-- Pagamento -->
        <div class="col-md-12 mb-4 card-deck"><!-- div form -->

        <div class="card">
            <div class="card-header">Cartão</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">                            
                        <h6 class="my-0"><?= strtoupper($pag_cartao['holder']); ?></h6>
                        <small class="text-muted"><?= $pag_cartao['card_number']; ?></small>                            
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <small>Codigo do pagamento</small>
                        <strong><?= $pag_cartao['pagamento_id']; ?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <small>Código de autorização</small>
                        <strong><?= $pag_cartao['authorization_code'] ?></strong>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Pagamento</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">                            
                        <h6 class="my-0"><?= $curso['nome_curso']; ?></h6>
                        <small class="text-muted"><?= $_SESSION['evento_atual_nome'] ?></small>                            
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <small>Valor</small>
                        <div class='text-right'>
                            <strong>R$ <?= $pag_cartao['amount']/100; ?></strong>
                            <br><small>Em <?= $pag_cartao['parcelas'] ?>x no cartão</small>
                        </div>
                    </li>
                </ul>
            </div> 
        </div>

        <div class="card">
            <div class="card-header">Aluno</div>            
            <div class='card-body'>
                <address>
                    <strong><?=  $aluno['nome']; ?> <?=  $aluno["sobrenome"] ; ?></strong><br>
                    <?=  $aluno["endereco"] ; ?><br>
                    <?php $aluno["bairro"]==NULL? $aluno["bairro"] . "<BR>" : '' ; ?>
                    <?=  $aluno["cep"] ; ?> <?=  $aluno["uf"] ; ?> <?=  $aluno["pais"] ; ?>
                </address>
            </div>
        </div>
            
        </div><!-- /div form -->
    </div><!-- Row Pagamento -->

                <div class="row">
                    <div class="col-md-12 text-center">
                        <a class="btn btn-outline-success btn-lg" href="../../aluno.home.php" role="button">Continuar</a>
                    </div>
                </div>

<?php include('../core/rodape.php'); ?>
</div><!-- FIM container -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
    <script src="form-validation.js"></script>
</body>
</html>
