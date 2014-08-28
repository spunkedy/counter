<?php

require_once('config.php');

class WufooGetter {
  
  private $url;
  private $config;
  
	public function __construct($url, $config) {
	  $this->url = $url;
	  $this->config = $config;
	}
	
	public function makeCall() {
		$hashArr = $this->config->hash;
		$requestURL = $this->url;
		$noInvalidHash = false;
		//Does this call include a hash value? If not, skip the check.
		if(strpos($requestURL, 'api/v3/forms/') === false && strpos($requestURL, 'api/v3/reports/') === false){
			$noInvalidHash = true;
		}
		//If so, make sure it is specified in config.php.
		else{
			//Before we get this party started, check to see if the request made was for one of the hash values specified in config.php
			foreach($hashArr as $value){
				if($noInvalidHash === false){
					$noInvalidHash = strpos($requestURL, $value);
				}
			}
		}
		//Initiate cURL authentication, but only if the above check passed, or if the array of hashes was left blank.
		if($noInvalidHash !== false || empty($hashArr)){
			$curl = curl_init('https://'.$this->config->subdomain.'.wufoo.com/'.$this->url);       
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);                     
			curl_setopt($curl, CURLOPT_USERPWD, $this->config->apiKey.':footastic');  
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);                    
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);                          
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);                           
			curl_setopt($curl, CURLOPT_USERAGENT, 'Wufoo Sample Code');            

			$response = curl_exec($curl);                                          
			$resultStatus = curl_getinfo($curl);                                  
			
			// This is fairly primitive error handling.
			// The jQuery plugin tests for the type of the response and 
			// deals with it over there.
			
			if ($resultStatus['http_code'] == 200) {                    
				echo $response;
			} else {
			  
				// Some folks may want to encode the error as JSON before 
				// outputting, so the JavaScript gets usable data no matter what.
			  
				echo 'Call Failed '.print_r($resultStatus);                        
			}
		}
		else{
			echo 'Error: Unauthorized API call. Please check the settings in your config.php file against the hash(es) used in your API call.';
		}
	}
}

$wufooGetter = new WufooGetter($_GET['url'], new jQueryConfig());
$wufooGetter->makeCall();

?>