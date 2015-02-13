<?php

namespace Org\Util;

class JsonResult{
		
	static $r_err = -1;
	static $r_common = 100;
	static $r_null = -200;
		
	static function instance() {   
		static $instance;   
		if (is_null($instance))
			$instance = new JsonResult();
		return $instance;   
	}
		
	static function error($msg) {
		$result['data'] = $msg;
		$result['code'] = JsonResult::$r_err;
		return JsonResult::encode($result);
	}
		
	static function boolean($data) {
		$result['data'] = array("result"=>$data);
		$result['code'] = JsonResult::$r_common;
		return JsonResult::encode($result);
	}
		
	static function data($data) {
		if(!empty($data) && count($data) > 0) {
			$result['data'] = $data;
			$result['code'] = JsonResult::$r_common;
			return JsonResult::encode($result);
		} else {
			$result['data'] = '';
			$result['code'] = JsonResult::$r_null;
			return JsonResult::encode($result);
		}
	}
		
	static function encode($data) {
		$json = json_encode($data);
		return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $json);
	}
		 
	static function decode($data) {
	 	return json_decode($data);
	}
}

?>