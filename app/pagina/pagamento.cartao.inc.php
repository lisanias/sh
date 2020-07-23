<?php

$sql = "SELECT * FROM pag_cartao WHERE pagamento_id = {$dados["id_pagamento"]}";

$tabelaPgCartao = mysqli_query($con,$sql);
$cartao = mysqli_fetch_array($tabelaPgCartao);

echo "<div class='hero-unit' style='text-align: left;'>";
echo "<p>ID: <strong>", $cartao["paymentId"], "</strong>";
echo "<br />TID: <strong>", $cartao["tid"], "</strong>";
echo "<br />Nº cartão: <strong>", $cartao["card_number"], "</strong>";
echo "<br />Nº parcelas: <strong>", $cartao["parcelas"], "</strong>";
echo "<br />Aluno: <strong>", $cartao["customer"], "</strong>";
echo "<br />Código de autorização: <strong>", $cartao["authorization_code"], "</strong>";
echo "<br />Valor: <strong>", $cartao["amount"]/100, "</strong>";
echo "<br />Bandeira do cartão: <strong>", $cartao["brand"], "</strong>";
echo "<br />NSU: <strong>", $cartao["captureNSU"], "</strong>";
echo "<br />Data de aprovação: <strong>", $cartao["capturedDate"], "</strong>";
echo "<br />Data de lançamento: <strong>", $cartao["created_at"], "</strong>";


echo "</div>";