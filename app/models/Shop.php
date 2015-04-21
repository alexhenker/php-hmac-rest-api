<?php

namespace Models;

class Shop extends \Phalcon\Mvc\Collection {

    public function getSource()
    {
        return "shops";
    }
    
    public function beforeCreate()
    {
        // Set the creation date
        $this->created = new \MongoDate();
    }

    public function beforeUpdate()
    {
        // Set the modification date
        $this->modified = new \MongoDate();
    }
    
    // validation
    public function beforeSave()
    {
        if (!$this->shop_id) {
            echo "Shop id is required! ";
            return false;
        }
        
        if (!$this->clientId) {
            echo "Client id is required! ";
            return false;
        }
    }
}
