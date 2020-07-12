<?php
/*
 * Configurar as váriáveis iniciais
 * 
 */

$ambiente = 'production'; // sandbox = teste | production - produção
$softDescriptor = "";

if ($ambiente == 'sandbox') {
    $MerchantId = 'af24002f-f265-4fd8-af62-20b6705bbc69';
    $MerchantKey = 'FWOXBIJYXNHROAGRXHMPFKJRSBQOYVVUQKVAMLQA';
}

if ($ambiente == 'production') {
    $MerchantId = '79c2ad90-3940-4eb4-94c8-218e4c2a5edc';
    $MerchantKey = 'iZ0lsg6h9qo9M79wqpsiSFSs8v7qRbv4qtyiIeA9';  
}


