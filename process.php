<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? '1';
    $currencyOrigin = $_POST['currencyOrigin'] ?? 'BRL';
    $convertTo = $_POST['convertTo'] ?? 'USD';
}

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.fxratesapi.com/latest?base=$currencyOrigin&currencies=$convertTo&resolution=1d&amount=$value&places=6&format=json",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET"
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo json_encode(['erro' => $err]);
    exit;
}

$data = json_decode($response, true);

if (isset($data['rates']) && is_array($data['rates'])) {
    foreach ($data['rates'] as $convertedCurrencys => $valor) {
        $convertedCurrency = number_format($valor, 2, ',', '.');
    }
    echo json_encode(['convertedAmount' => $convertedCurrency]);
} else {
    echo json_encode(['erro' => 'Resposta inválida da API']);
}

