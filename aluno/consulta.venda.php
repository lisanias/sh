<?php
require 'vendor/autoload.php';

use Cielo\API30\Merchant;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;

use Cielo\API30\Ecommerce\Request\CieloRequestException;



// REALIZA A CONSULTA JUNTO A CIELO

$affiliation_number = "af24002f-f265-4fd8-af62-20b6705bbc69";
$access_key = "FWOXBIJYXNHROAGRXHMPFKJRSBQOYVVUQKVAMLQA";
$identificador_transacao = "764f8b45-80a9-4538-a157-25310992397c";

try {

	// CRIA O OBJETO MERCHANT COM AS CREDENCIAS DE ACESSO
	$objMerchant = new Merchant($affiliation_number, $access_key);
	
	 // REALIZA A CONSULTA
	$objCielo = (new CieloEcommerce($objMerchant, Environment::sandbox()))->getSale($identificador_transacao);

	// RETORNA O RESULTADO DA CONSULTA
	//return $objCielo->getPayment();
	$result = $objCielo->getPayment();

// DEFINE O ERRO PARA SER EXIBIDO
} catch(Exception $e){

	$objErro = $e->getCieloError();
	$erro = "(".$objErro->getCode().") " . $objErro->getMessage();

	return array('error'=>$erro);

}
echo "<pre>{";
var_dump($result);
echo '}</pre>';