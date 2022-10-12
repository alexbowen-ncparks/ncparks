<?php


$url = "http://industrial.api.ubidots.com/api/v1.6/devices/4a003a000251363131363432/daily/lv?token=BBFF-XLSyMQDMx0SX9VSqxnAIjmgU546uW8";

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
curl_setopt($curl, CURLOPT_POST, true);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

$response = json_decode($json_response, true);




?>
