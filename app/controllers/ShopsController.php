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
        
            $request = $this->request;
            if ($request->isDelete() == true) {
                
                $inputData = $this->request->getRawBody();
                parse_str($inputData, $data);
                
                if (isset($data['shop_id'])) {
                    $shop_id = (int) $data['shop_id'];
                } 
                
                if (!$shop_id) {
                    echo 'Shop id required!' . "\n";
                } else {
                    $shop = Shop::findFirst(array('shop_id' => $shop_id));
                    if ($shop->delete() == false) {
                        echo "Sorry, we can't delete the shop right now: \n";
                        foreach ($shop->getMessages() as $message) {
                            echo $message, "\n";
                        }
                    } else {
                        echo "Shop {$shop_id} was deleted successfully!";
                    }
                }
                
            }
            
    }

}
