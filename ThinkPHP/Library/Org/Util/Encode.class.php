<?php

namespace Org\Util;

class Encode {
	
	static function encode($string = '', $skey = 'gtpgtp') {
    	$strArr = str_split(base64_encode($string));
    	$strCount = count($strArr);
    	foreach (str_split($skey) as $key => $value)
        	$key < $strCount && $strArr[$key].=$value;
    	return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
 	}
	
	
	static function decode($string = '', $skey = 'gtpgtp') {
    	$strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    	$strCount = count($strArr);
    	foreach (str_split($skey) as $key => $value)
        	$key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    	return base64_decode(join('', $strArr));
 	}
	
}

?>