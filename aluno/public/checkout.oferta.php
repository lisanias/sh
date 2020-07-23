<?php
/*
 *
 * Página de pagamento de oferta ao SH pela cielo *
 */

// ini_set("display_errors", 1);
// error_reporting(E_ALL) ;

/*
 * Segurança - não precisa estar logado para fazer uma oferta!
 */

include(dirname(__DIR__).'../../i_secao.evento.default.php');

/*
 *  FIM Segurança
 */

//Cria um token
$_SESSION['token'] = md5(uniqid(rand(), true));

include(dirname(__DIR__)."../../i_funcoes.php");

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
    <title>Oferta | HOSANA</title>

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
            <p>
                <span class="small">Usuário não logado<br /></span>
                <?= $evento["descricao"] ?>
            </p>
        </div>
    </nav>

    <div class="py-5 text-center" style="padding: 15px; margin:5% 15%;">
        <img class="d-block mx-auto mb-4" src="img/logohosana_icon.svg" alt="" width="72" height="72">
        <h2>Oferta com cartão de crédito</h2>
        <p class="lead">Insira seu nome e o valor da oferta voluntária juntamente com os dados do cartão e envie a sua oferta voluntária!</p>
        <p>O valor ofertado pode ser divido em até 6 vezes!</p>
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

    <div class="row"><!-- Itens -->
        <div class="col-md-12 mb-4"><!-- Itens -->
            <div class="mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Descrição</span>
                </h4>
                <ul class="list-group mb-5">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Oferta para o Seminário Hosana</h6>
                            <small class="text-muted">Oferta voluntária</small>
                        </div>
                    </li>                    
                </ul>
            </div>

        </div><!-- Fim itens -->
    </div><!-- FIM intens -->

    <div class='row'><!-- Pagamento -->
        <div class="col-md-12"><!-- div form -->
            <form class="needs-validation" id='cielo' action='../core/oferta.cartao.php' method='POST' accept-charset='UTF-8'>

                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>" />

                <h4 class="mb-3">Dados Pessoais</h4>

                <div class="row mb-5">
                    <div class="col-md-12 mb-3">
                        <label for="customerName">Nome do doador</label>
                        <input type="text" class="form-control" name="customerName" id="customerName" placeholder="" maxlength="255" required>
                        <div class="invalid-feedback">
                        Este campo é obrigatório.
                        </div>
                    </div>
                </div><!-- /row -->

                <h4 class="mb-3">Valor</h4>

                <div class="row mb-5">
                    <div class="col-md-6 mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">R$</div>
                            <input type="text" class="form-control" name='cc-valor' id="cc-valor" required>
                        </div>
                        <div class="invalid-feedback">
                        Este campo é obrigatório.
                        </div>
                    </div>
                </div><!-- /row -->                    

                <h4 class="mb-3">Dados do Cartão de Crédito</h4>

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
                <div class="row mb-5">
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
                    <div class="col-md-3">
                        <label for="cc-parcela">Parcela</label>
                        <select class="form-control" name='cc-parcela' id="cc-parcela">
                            <option value="1" default>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                        <small id="cc-parcela" class="text-muted">
                            O valor ofertado pode ser divido em até 6 vezes!
                        </small>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups" style="width: 100%">
                        <div class="btn-group col-xs-3 col-md-5 col-sm-12" role="group" style="margin: 10px 0;">
                            <button class="btn btn-primary btn-lg" type="submit" id="btn-submit">Ofertar</button>
                        </div>
                        <div class="btn-group col-xs-3 col-md-5 col-sm-12" role="group" style="margin: 10px 0;">
                            <a class="btn btn-outline-secondary btn-lg" href="javascript:history.back(1);" role="button">Voltar</a>
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
                $("#btn-submit").html("Aguarde, comunicando...");
                return true;
            });
        });
    </script>
</body>
</html>
