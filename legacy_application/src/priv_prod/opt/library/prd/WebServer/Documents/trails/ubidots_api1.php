<?php

$curl = curl_init();

curl_setopt_array($curl,[
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => 'https://industrial.api.ubidots.com',
	CURLOPT_PORT => 443,
	CURLOPT_POST => true,
	CURLOPT_HTTPHEADER => array(
		'Content-type: application/json,
		X-Auth-Token: BBFF-XLSyMQDMx0SX9VSqxnAIjmgU546uW8'
]);

$response = curl_exec($curl);

echo $response;

$resp_decode = json_decode($response);

echo $resp_decode;

?>


