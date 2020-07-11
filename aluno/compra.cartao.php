<?php

require 'vendor/autoload.php';
include_once dirname(__DIR__).'/i_secao.evento.default.php';
include_once 'config.ini.php';
include_once 'core/basedados.php';
require 'core/valida.php';

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;

use Cielo\API30\Ecommerce\Request\CieloRequestException;


// Captura os dados enviados pelo checkout
// Verifica se tem dados postados
$validar = validar($_POST);

// TOKEN confere se tem token de certificação de origem, captura e reseta
$token = token();

// CAPTURA DE DADOS 
// Dados do formulário
$cc_holder = $_POST['cc-holder'];   // Nome impresso no cartão
$cc_card = $_POST['cc-card'];       // Número do cartão
$cc_brand = $_POST['cc-brand'];     // Bandeira do cartão
$cc_expiration = $_POST['cc-mes'].'/'.$_POST['cc-ano'];      // Data de validade do cartão "12/2022"
$cc_cvv = $_POST['cc-cvv'];          // código de segurança do cartão CVV
$parcela = $_POST['cc-parcela'];    // Número de parcelas
$parcelado = $_POST['valor'];
$avista = $_POST['aVista'];
$matricula = $_POST['id_matricula'];

// dados da session
$aluno = $_SESSION["nome"]. " " . $_SESSION["sobrenome"] ;;    // name completo do cliente (não do cartão de crédito)

// Calcular valor a vista e parcelado e transformar em centavos.
$valor = $parcela == 1 ? $avista : $parcelado;
$valorCent = $valor * 100;


// Configure o ambiente
$environment = Environment::$ambiente();

// Configure seu merchant
$merchant = new Merchant($MerchantId, $MerchantKey);

// Crie uma instância de Sale informando o ID do pedido na loja
$sale = new Sale($matricula);

// Crie uma instância de Customer informando o nome do cliente
$customer = $sale->customer($aluno);

// Crie uma instância de Payment informando o valor do pagamento
$payment = $sale->payment($valorCent, $parcela);

// Crie uma instância dom o nome que aparece no extrato do cliente
$softd = $payment->setSoftDescriptor($softDescriptor);

// Crie uma instância de Credit Card utilizando os dados de teste
// esses dados estão disponíveis no manual de integração
$payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
        ->creditCard($cc_cvv, $cc_brand)
        ->setExpirationDate($cc_expiration)
        ->setCardNumber($cc_card)
        ->setHolder($cc_holder);  

// verificar os dados inserido
$saleStatus = $sale;

// Crie o pagamento na Cielo
try {
    // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
    $sale = (new CieloEcommerce($merchant, $environment))->createSale($sale);

    //Guardar os dados da requisição. by lisanias
    $requisicao = $sale;

    // Com a venda criada na Cielo, já temos o ID do pagamento, TID e demais
    // dados retornados pela Cielo
    $paymentId = $sale->getPayment()->getPaymentId();
    $status = $sale->getPayment()->getStatus();
    $returnMessage = $sale->getPayment()->getReturnMessage();

   

    if ($status !== 1) {
        $_SESSION["msg"] = "Pagamento não realizado. (".$ambiente.") Mensagem da operadora do cartão: ". $returnMessage;
        $_SESSION['msg_tipo'] = "alert-warning";
        // Redireciona para home a página de pagamentos
        header("Location: public/checkout.php");
        die();
    } 

    // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
    $sale = (new CieloEcommerce($merchant, $environment))->captureSale($paymentId, $valorCent, $parcela);

    //Guardar os dados da captura. by lisanias
    $captura = $sale;
    $capturaStatus = $captura->getStatus();
    $capturaMessage = $captura->getReturnMessage();
    if ($capturaStatus !== 2) {
        $_SESSION["msg"] = "COBRANÇA NÃO FINALIZADA AINDA. Mensagem da operadora do cartão: ". $capturaMessage;
        $_SESSION['msg_tipo'] = "alert-warning";
        // Redireciona para home a página de pagamentos
        header("Location: public/checkout.php");
        die();
    } 

    // E também podemos fazer seu cancelamento, se for o caso
    // $sale = (new CieloEcommerce($merchant, $environment))->cancelSale($paymentId, 15700);

} catch (CieloRequestException $e) {
    // Em caso de erros de integração, podemos tratar o erro aqui.
    // os códigos de erro estão todos disponíveis no manual de integração.
    $error = $e->getCieloError();
}

// Inserir dados nas tabelas - depois de processado os cartões

/* Tabela pagamento Atualizar status se deu certo
 * status: 1 para pendente, ou seja se não der certo e 3 para confirmado
 */

$ref_a = $parcela==1 ? '1' : '4'; // define a que se refere o pagamento (no caso se é cartão a vista ou cartão parcelado)

$sqlPagamento = ["id_matricula"=>$matricula,"valor"=>$valor, "parcela"=>$parcela, "status"=>'3', "ref_a"=>$ref_a ];
$sql = db::sqlPagamentoAdd($sqlPagamento);
$result = db::connect($sql);



$sql_pag_cartao = [
            'pagamento_id'=>$result,
            'paymentId' => $requisicao->getPayment()->getPaymentId(),
            'tid'=>$captura->getTid(), 
            'authorization_code'=>$captura->getAuthorizationCode(), 
            'card_number'=>$requisicao->getPayment()->getCreditCard()->getCardNumber(),
            'holder'=>$requisicao->getPayment()->getCreditCard()->getHolder(),
            'parcelas'=>$requisicao->getPayment()->getInstallments(),
            'customer'=>$requisicao->getCustomer()->getName(),
            'amount'=>$requisicao->getPayment()->getAmount(),
            'brand'=>$requisicao->getPayment()->getCreditCard()->getBrand(),
        ];
$sql = db::sqlPagCartaoAdd($sql_pag_cartao);
$pgCartaoResult = db::connect($sql);

$sql = "UPDATE matricula SET status = 3 WHERE id_matricula = $matricula";
$matriculaResult = db::connect($sql);

// Redireciona para a página com a confirmação

$_SESSION['pg_cartao'] = $pgCartaoResult;
header("Location: public/pagamento.realizado.php");