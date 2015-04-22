<?php
include 'RestApiCallerInterface.php';

class OsaApiCaller implements RestApiCallerInterface {
    
    private $host;
    private $privateKey;
    private $api_id;
    private $time;
    private $data;
    private $hash;
    private $headers;
    private $curl;
    
    public function __construct($host) {
        
        if (!function_exists('curl_init')) {
            throw new Exception('Curl module not installed!');
        }
        $this->host = $host;
        $this->headers = array();
        $this->privateKey = '482fe5ad77014f9506651028801ab376f141916bd26b2b3f0271b5ec2155b989';
        $this->api_id = 1;
        $this->time = time();
    }
    
    public function get($url, $data) {
            
        $this->prepareRequest($data, true); // second param true for get request
        
        $this->curlInit();
        $this->curlSetUrl("$url/$data");
        
        $this->curlSend();
    
    }
    
    public function post($url, $data) {
        
        $this->prepareRequest($data);
        
        $this->curlInit();
        $this->curlSetUrl($url);
        $this->curlSetPostfields();
        
        $this->curlSend();

    }
    
    public function put($url, $data) {
        
        $this->prepareRequest($data);
        
        $this->curlInit();
        $this->curlSetUrl($url);
        $this->curlSetPostfields();
        $this->curlSetCustomRequest('PUT');
        
        $this->curlSend();
        
    }
    
    public function delete($url, $data) {
        
        $this->prepareRequest($data);
        
        $this->curlInit();
        $this->curlSetUrl($url);
        $this->curlSetPostfields();
        $this->curlSetCustomRequest('DELETE');
        
        $this->curlSend();
    }
    
    ///// SERVICE METHODS
    
    private function prepareRequest($data, $getRequest = false) {
        
        $this->data = (!$getRequest) ? http_build_query($data, '', '&') : '';
        
        $data = (!$getRequest) ? $data : ''; // empty for get request
        
        $message = $this->time . $this->api_id . $this->data;
        $this->hash = hash_hmac('sha256', $message, $this->privateKey);
        $this->headers = ['API_ID: ' . $this->api_id, 'API_TIME: ' . $this->time, 'API_HASH: ' . $this->hash];
    }
    
    private function curlInit() {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_VERBOSE, TRUE);
        curl_setopt($this->curl, CURLOPT_HEADER, TRUE);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->curl, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
    }
    
    private function curlSetUrl($url) {
        curl_setopt($this->curl, CURLOPT_URL, $this->host . $url);
    }
    
    private function curlSetCustomRequest($request) {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $request);
    }
    
    private function curlSetPostfields() {
        curl_setopt($this->curl, CURLOPT_POST, TRUE);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->data);
    }
    
    private function curlSend() {
        
        $result = curl_exec($this->curl);
        if ($result === FALSE) {
                echo "Curl Error: " . curl_error($this->curl);
        } else {
                echo PHP_EOL;
                echo "Request: " . PHP_EOL;
                echo curl_getinfo($this->curl, CURLINFO_HEADER_OUT);	
                echo PHP_EOL;

                echo "Response:" . PHP_EOL;
                echo $result; 
                echo PHP_EOL;
        }
        
        curl_close($this->curl);
    
    }
    
}