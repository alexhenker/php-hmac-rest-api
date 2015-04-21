<?php

if (!function_exists('curl_init')) {
	die('Curl module not installed!' . PHP_EOL);
}

$privateKey = '482fe5ad77014f9506651028801ab376f141916bd26b2b3f0271b5ec2155b989';

$time = time();
$id = 1;

///////////////////////
///// GET (GET) ///
$shop_id = 2332;
$getDataRaw = '';
$data = http_build_query($getDataRaw, '', '&');
$message = buildMessage($time, $id, $data);
$hash = hash_hmac('sha256', $message, $privateKey);
$headers = ['API_ID: ' . $id, 'API_TIME: ' . $time, 'API_HASH: ' . $hash];
$ch = curl_init();
curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
curl_setopt($ch, CURLOPT_URL, 'http://rest:8000/api/v1/shop/' . $shop_id );
//curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HEADER, TRUE);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);

$result = curl_exec($ch);
if ($result === FALSE) {
	echo "Curl Error: " . curl_error($ch);
} else {
	echo PHP_EOL;
	echo "Request: " . PHP_EOL;
	echo curl_getinfo($ch, CURLINFO_HEADER_OUT);	
	echo PHP_EOL;

	echo "Response:" . PHP_EOL;
	echo $result; 
	echo PHP_EOL;
}
curl_close($ch);


function buildMessage($time, $id, $data) {
	return $time . $id . $data;
}

?>
