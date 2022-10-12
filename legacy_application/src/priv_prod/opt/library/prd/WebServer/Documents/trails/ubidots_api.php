<?php

$curl = curl_init();

$ubidots = "https://industrial.api.ubidots.com/api/v1.6/";

$ubidots_resource = array(
	"datasources/",
	"devices/",
	"statistics/",
	"variables/",
	"utils/
	");


//test device{id} @ NCParks172-PIMO-Pilot-Trail - 
//$ubidots_PIMO = "variables/e00fce685407aab9a251c4b1/";
//$ubidots_PIMO = "devices/NCParks172-SP-PIMO-Pilot-Trail/";
//$ubidots_PIMO = "devices/e00fce685407aab9a251c4b1/";

$url = $ubidots . $ubidots_resource[0];
//$url = $ubidots . $ubidots_PIMO;

echo "<br/>" . $url . "<br/>";

$curl = curl_init($url);

//echo "<br/>" . $curl . "<br>";

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_PORT, 443);
curl_setopt($curl, CURLOPT_HTTPHEADER,
	['X-Auth-Token: BBFF-1IJNxMPRiNoNvccDiaTJNbaN7adnb4',
	'Content-Type: application/json'
	]
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($curl, CURLOPT_VERBOSE, 0);
//curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPGET, true);

$response_info = curl_getinfo($curl);
echo "<br/>" . $response_info . "<br/>";


$response = curl_exec($curl);
//echo "<br/> RESPONSE <br/>" . $response . "<br/>";

$decode = json_decode($response, true);

echo "<br/> DECODED JSON: <br/>";

//echo "<br/> " . $decode . "<br/>";
/*
echo "<br/> DECODE ARRAY: <br/>";
foreach ($decode as $datasources_array => $datasources_response)
{
	echo "<br/>" . $datasources_array . ": " . $datasources_response . "<br/>";
	foreach ($datasources_response as $ds_resp_array => $ds_resp_result)
	 {
		echo "<br/>" . $ds_resp_array . ": " . $ds_resp_result . "<br/>";
		foreach ($ds_resp_result as $key => $value)
		{
			echo "<br/>" . $key . ": " . $value . "<br/>";
		}
	}
}


$decode_obj = var_dump($decode);

foreach ($decode_obj as $key => $value)
{
	echo "<br/> DECODE OBJECTS: <br/>";
	echo "<br/>" . $decode_obj . "<br/>";
	echo "<br/> OBJECTS PAIRS by Line: <br/>";
	echo "<br/>" . $key	. ": " . $value . "<br/>";
}
*/
echo "count: " . $decode["count"] . "<br/>";
echo "next: " . $decode["next"] . "<br/>";
echo "previous: " . $decode["previous"] . "<br/>";
echo "results: " . $decode["results"] . "<br/>";

$next_url = $decode["next"];

curl_close($curl);

echo "<br/> next: " . $next_url . "<br/>";



?>
