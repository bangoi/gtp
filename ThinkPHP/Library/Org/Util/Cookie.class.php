<?php

namespace Org\Util;
	
class Cookie {
	
	private $cookie_params;
	private $prefix = "chezb_";
	
	function __construct() {
       $this->cookie_params = array('expire' => 3600 * 24 * 30, 'prefix' => $this->prefix);
   }
	
	public function add($user) {
		//dump($user);
		foreach($user as $key => $value){
			//dump("key: ".$key."   value: ".$value);
			cookie($this->prefix.$key, $user[$key], $cookie_params);
			
			//dump("added: ".cookie($key));
		}
	}
	
	public function get($key) {
		return cookie($this->prefix.$key);
	}
	
	public function clear() {
		dump($_COOKIE);	
		cookie(null, $this->prefix);
		dump($_COOKIE);
	}
	 		
}
	
?>

