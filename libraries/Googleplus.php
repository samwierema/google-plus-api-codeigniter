<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Googleplus {
	
	public function __construct() {
		
		$CI =& get_instance();
		$CI->config->load('googleplus');
				
		require APPPATH .'third_party/google-api-php-client/src/apiClient.php';
		require APPPATH .'third_party/google-api-php-client/src/contrib/apiPlusService.php';
		
		$client = new apiClient();
		$client->setApplicationName($CI->config->item('application_name', 'googleplus'));
		$client->setClientId($CI->config->item('client_id', 'googleplus'));
		$client->setClientSecret($CI->config->item('client_secret', 'googleplus'));
		$client->setRedirectUri($CI->config->item('redirect_uri', 'googleplus'));
		$client->setDeveloperKey($CI->config->item('api_key', 'googleplus'));
		
		$this->plus = new apiPlusService( $client );
		
	}
	
	public function __get($name) {
		
		if(isset($this->plus->$name)) {
			return $this->plus->$name;
		}
		return false;
		
	}
	
	public function __call($name, $arguments) {
		
		if(method_exists($this->plus, $name)) {
			return call_user_func(array($this->plus, $name), $arguments);
		}
		return false;
		
	}
	
}
?>