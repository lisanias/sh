<?php
require 'vendor/autoload.php';

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;

use Cielo\API30\Ecommerce\Request\CieloRequestException;

// Configure o ambiente
$environment = $environment = Environment::sandbox();

// Configure seu merchant
$merchant = new Merchant('af24002f-f265-4fd8-af62-20b6705bbc69', 'FWOXBIJYXNHROAGRXHMPFKJRSBQOYVVUQKVAMLQA');



// Crie o pagamento na Cielo
try {
        
    // Com o ID do pagamento, podemos fazer sua captura, se ela não tiver sido capturada ainda
    $sale = (new CieloEcommerce($merchant, $environment))->captureSale("764f8b45-80a9-4538-a157-25310992397c", 32000, 0);



    // E também podemos fazer seu cancelamento, se for o caso
    //$sale = (new CieloEcommerce($merchant, $environment))->cancelSale($paymentId, 32002);
} catch (CieloRequestException $e) {
    // Em caso de erros de integração, podemos tratar o erro aqui.
    // os códigos de erro estão todos disponíveis no manual de integração.
    $error = $e->getCieloError();
}

var_dump(http_response_code());
    echo "<hr>";
echo "<pre>";
var_dump($sale);
echo "</pre>";

