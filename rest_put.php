<?php

if (!function_exists('curl_init')) {
	die('Curl module not installed!' . PHP_EOL);
}

$privateKey = '482fe5ad77014f9506651028801ab376f141916bd26b2b3f0271b5ec2155b989';

$time = time();
$id = 1;

$updateDataRaw = array(
        'shop_id' => '2332',
        'clientId' => "spar",
        'name' => 'test shop upd',
        'adress' => array(
            'street' => 'test street upd',
            'city' => 'test city upd',
            'region' => 'test region upd'
        ),
        'osaDB' => array(
                'ip' => 'test osa ip upd',
                'dbName' => 'test osa dbName upd',
                'login' => 'test osa login upd',
                'password' => 'test osa password upd'
        ),
        'posdataDB' => array(
                'dbType' => 'Oracle upd',
                'dbName' => 'test posdata dbName upd',
                'login' => 'test posdata login upd',
                'password' => 'test posdata password upd'
        ),
        'isActive' => false
);


///////////////////////
/// UPDATE (PUT) ///

$data = http_build_query($updateDataRaw, '', '&');
$message = buildMessage($time, $id, $data);
$hash = hash_hmac('sha256', $message, $privateKey);
$headers = ['API_ID: ' . $id, 'API_TIME: ' . $time, 'API_HASH: ' . $hash];
$ch = curl_init();
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
curl_setopt($ch, CURLOPT_URL, 'http://rest:8000/api/v1/shop');
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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
