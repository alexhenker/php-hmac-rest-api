<?php

require_once 'OsaApiCaller.php';
$rest = new OsaApiCaller('http://rest:8000');

$insertDataRaw = array(
        'shop_id' => '2332',
        'clientId' => "x5",
        'name' => 'test shop',
        'adress' => array(
            'street' => 'test street',
            'city' => 'test city',
            'region' => 'test region'
        ),
        'osaDB' => array(
                'ip' => 'test osa ip',
                'dbName' => 'test osa dbName',
                'login' => 'test osa login',
                'password' => 'test osa password'
        ),
        'posdataDB' => array(
                'dbType' => 'Oracle',
                'dbName' => 'test posdata dbName',
                'login' => 'test posdata login',
                'password' => 'test posdata password'
        ),
        'isActive' => true
);

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

$rest->post('/api/v1/shop', $insertDataRaw);
$rest->get('/api/v1/shop', 2332);
//$rest->put('/api/v1/shop', $updateDataRaw);
//$rest->get('/api/v1/shop', 2332);
//$rest->delete('/api/v1/shop', array('shop_id' => 2332));
//$rest->get('/api/v1/shop', 2332);