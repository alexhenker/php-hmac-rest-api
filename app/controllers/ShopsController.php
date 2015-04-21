<?php

namespace Controllers;

use \Models\Shop as Shop;

class ShopsController extends \Phalcon\Mvc\Controller {


    public function postAction() {
        
            $request = $this->request;
            
            if ($request->isPost() == true) {
                
                $shop = new Shop();
                $shop->shop_id = (int) $request->getPost('shop_id', 'int');
                $shop->clientId = $request->getPost('clientId', 'string');
                $shop->name = $request->getPost('name', 'string');
                
                $adress = $request->getPost('adress');
                if ($adress) {
                    $shop->adress = array(
                        'street' => isset($adress['street']) ? $adress['street'] : '',
                        'city' => isset($adress['city']) ? $adress['city'] : '',
                        'region' => isset($adress['region']) ? $adress['region'] : ''
                    );
                }
                
                $osaDB = $request->getPost('osaDB');
                if ($osaDB) {
                    $shop->osaDB = array(
                        'ip' => isset($osaDB['ip']) ? $osaDB['ip'] : '',
                        'dbName' => isset($osaDB['dbName']) ? $osaDB['dbName'] : '',
                        'login' => isset($osaDB['login']) ? $osaDB['login'] : '',
                        'password' => isset($osaDB['password']) ? $osaDB['password'] : '',
                    );
                }
                
                $posdataDB = $request->getPost('posdataDB');
                if ($posdataDB) {
                    $shop->posdataDB = array(
                        'dbType' => isset($posdataDB['dbType']) ? $posdataDB['dbType'] : '',
                        'dbName' => isset($posdataDB['dbName']) ? $posdataDB['dbName'] : '',
                        'login' => isset($posdataDB['login']) ? $posdataDB['login'] : '',
                        'password' => isset($posdataDB['password']) ? $posdataDB['password'] : '',
                    );
                }
                
                $shop->isActive = (bool) $request->getPost('isActive');
                
                
                if ($shop->save() == false) {
                    echo 'Failed to insert shop into the database' . "\n";
                    foreach($shop->getMessages() as $message) {
                        echo $message . "\n";
                    }
                } else {
                    echo "Shop {$shop->shop_id} inserted!";
                }
                
            }
            
    }
    
    public function deleteAction() {
        
            $shop = Shop::findFirst();
            $shop->id = 1;
            $shop->clientid = "x5";
            $shop->name = "test shpo";
            $shop->adress = array(
                'street' => 'test street',
                'city' => 'test city',
                'region' => 'test region'
            );
            $shop->osaDB = array(
                'ip' => 'test osa ip',
                'dbName' => 'test osa dbName',
                'login' => 'test osa login',
                'password' => 'test osa password'
            );
            $shop->posdataDB = array(
                'dbType' => 'Orcale',
                'dbName' => 'test posdata dbName',
                'login' => 'test posdata login',
                'password' => 'test posdata password'
            );
            $shop->isActive = true;

            if ($shop->save() == false) {
                echo 'Failed to insert into the database' . "\n";
                foreach($shop->getMessages as $message) {
                    echo $message . "\n";
                }
            } else {
                echo 'Shop inserted!';
            }
            
    }

}
