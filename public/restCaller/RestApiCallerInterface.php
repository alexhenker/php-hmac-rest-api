<?php

interface RestApiCallerInterface {
    
    public function get($url, $data);
    public function post($url, $data);
    public function put($url, $data);
    public function delete($url, $data);
    
}