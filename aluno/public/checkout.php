<?php
/*
 *
 * Página de pagamento na cielo
 *
 */

ini_set("display_errors", 1);
error_reporting(E_ALL) ;

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
    <title>Hosana - Pagamento com cartão</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

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
        <img class="d-block mx-auto mb-4" src="img/logohosana_icon.svg" alt="" width="72" height="72">
        <h2>Pagamento com cartão</h2>
        <p class="lead">Confira seus dados pessoais, o valor e preencha atentamente os campos com os dados do seu cartão. Qualquer dúvida entre em contato com a gente por telefone, email ou Whatswapp.</p>
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

    <div class="row"><!-- Aluno -->
        <div class="col-md-12 mb-4"><!-- Endereço -->
            <h4 class="mb-3">Aluno</h4>
            <div class='card card-body'>
                <address>
                    <strong><?=  $aluno['nome']; ?> <?=  $aluno["sobrenome"] ; ?></strong><br>
                    <?=  $aluno["endereco"] ; ?><br>
                    <?php $aluno["bairro"]==NULL? $aluno["bairro"] . "<BR>" : '' ; ?>
                    <?=  $aluno["cep"] ; ?> <?=  $aluno["uf"] ; ?> <?=  $aluno["pais"] ; ?>
                </address>
                <div class='mb-4'>
                    <strong>E-mail</strong><br>
                    <?=  $aluno["email"] ; ?>
                </div>
                <div>
                    <strong>CPF</strong><br>
                    <?=  $aluno["cpf"] ; ?>
                </div>
            </div>
        </div><!-- FIM Endereço -->
    </div><!-- FIM Aluno -->

    <div class="row"><!-- Itens -->
        <div class="col-md-12 mb-4"><!-- Itens -->
            <div class="mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Descrição</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?= $curso['nome_curso']; ?></h6>
                            <small class="text-muted"><?= $_SESSION['evento_atual_nome'] ?></small>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Parcelado</span>
                        <strong>R$ <?= $curso['valor']; ?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Em 1x no cartão</span>
                        <strong>R$ <?= $curso['aVista']; ?></strong>
                    </li>
                </ul>
            </div>

        </div><!-- Fim itens -->
    </div><!-- FIM intens -->

    <div class='row'><!-- Pagamento -->
        <div class="col-md-12"><!-- div form -->
            <form class="needs-validation" id='cielo' action='../compra.cartao.php' method='POST' accept-charset='UTF-8'>

                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>" />
                <input type="hidden" name="id_matricula" value="<?= $curso['id_matricula'] ?>">
                <input type="hidden" name="valor" value="<?= $curso['valor'] ?>">
                <input type="hidden" name="aVista" value="<?= $curso['aVista'] ?>">

                <hr class="mb-4">

                <h4 class="mb-3">Pagamento</h4>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="cc-holder">Nome no Cartão</label>
                        <input type="text" class="form-control" name="cc-holder" id="cc-holder" placeholder="" maxlength="25" required>
                        <div class="invalid-feedback">
                        Este campo é obrigatório.
                        </div>
                    </div>
                </div><!-- /row -->
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="cc-card">Número do cartão</label>
                        <input type="text" class="form-control" name='cc-card' id="cc-card" placeholder="" required>
                        <div class="invalid-feedback">
                        Este campo é obrigatório.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="exampleFormControlSelect1">Bandeira</label>
                        <select class="form-control" name='cc-brand' id="exampleFormControlSelect1">
                        <option>Visa</option>
                        <option value="Master">Master Card</option>
                        <option>Elo</option>
                        <option value="Amex">American Express</option>
                        <option value="Diners">Diners Club</option>
                        <option>Discover</option>
                        <option>Aura</option>
                        <option>Hipercard</option>
                        <option>Hiper</option>
                        <option>JCB</option>
                        </select>
                    </div>
                </div><!-- /row -->
                <div class="row">
                    <div class="col-md-6 mb-3">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="cc-mes">Mes</label>
                                <select class="form-control" name='cc-mes' id="exampleFormControlSelect1">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cc-ano">Ano</label>
                                <select class="form-control" name='cc-ano' id="exampleFormControlSelect1">
                                <?php
                                    $ybase = intval(date('Y'));
                                    for ($i = $ybase ; $i <= $ybase+20; $i++) {
                                        echo "<option value='",$i,"'>",$i,"</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </div>

                        <div class="invalid-feedback">
                        Este campo é obrigatório.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" name='cc-cvv' id="cc-cvv" placeholder=""  maxlength="3" required>
                        <div class="invalid-feedback">
                        Este campo é obrigatório.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-parcela">Parcela</label>
                        <select class="form-control" name='cc-parcela' id="exampleFormControlSelect1">
                            <option value="1">1 x R$ <?= number_format($curso['aVista'],2,",",".") ?></option>
                            <option value="2">2 x R$ <?= number_format($curso['valor']/2,2,",",".") ?></option>
                            <option value="3">3 x R$ <?= number_format($curso['valor']/3,2,",",".") ?></option>
                            <option value="4">4 x R$ <?= number_format($curso['valor']/4,2,",",".") ?></option>
                            <option value="5">5 x R$ <?= number_format($curso['valor']/5,2,",",".") ?></option>
                            <option value="6">6 x R$ <?= number_format($curso['valor']/6,2,",",".") ?></option>
                        </select>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="row">
                    <div class="col-md-12 btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-secondary btn-lg" href="../../aluno.home.php" role="button">Cancelar</a>
                        </div>
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary btn-lg" type="submit" id="btn-submit">Finalizar o pagamento</button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /div form -->
    </div><!-- Row Pagamento -->

<?php include('../core/rodape.php'); ?>

</div><!-- FIM container -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
    <script src="form-validation.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#cielo").submit(function (e) {
                $("#btn-submit").attr("disabled", true);
                return true;
            });
        });
    </script>
</body>
</html>
