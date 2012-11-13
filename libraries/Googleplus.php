<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Googleplus {
	
	public function __construct() {
		
		$CI =& get_instance();
		$CI->config->load('googleplus');
				
		require APPPATH .'third_party/google-api-php-client/src/Google_Client.php';
		require APPPATH .'third_party/google-api-php-client/src/contrib/Google_PlusService.php';
		
		$cache_path = $CI->config->item('cache_path');
		$GLOBALS['apiConfig']['ioFileCache_directory'] = ($cache_path == '') ? APPPATH .'cache/' : $cache_path;
		
		$client = new Google_Client();
		$client->setApplicationName($CI->config->item('application_name', 'googleplus'));
		$client->setClientId($CI->config->item('client_id', 'googleplus'));
		$client->setClientSecret($CI->config->item('client_secret', 'googleplus'));
		$client->setRedirectUri($CI->config->item('redirect_uri', 'googleplus'));
		$client->setDeveloperKey($CI->config->item('api_key', 'googleplus'));
		
		$this->plus = new Google_PlusService($client);
		
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