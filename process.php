<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? '1';
    $amount = $_POST['amount'] ?? 'USD';
    $convertedAmount = $_POST['convertedAmount'] ?? 'BRL';
}

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.fxratesapi.com/latest?base=$amount&currencies=$convertedAmount&resolution=1d&amount=$value&places=6&format=json",
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

$data = [];
$data = json_decode($response, true);

foreach($data['rates'] as $convertedCurrencys => $value) {
    $convertedCurrency = $value;
}

$convertedCurrency = number_format($convertedCurrency, 2, ',', '.');

print_r($convertedCurrency);

if ($err) {
  echo "cURdataL Error #:" . $err;
} else {
 
}
?>
