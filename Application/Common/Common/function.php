<?php

function nl2br2($string) { 
	$string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string); 
	return $string;
}

function br2nl ( $string, $separator = PHP_EOL ) {
    $separator = in_array($separator, array("\n", "\r", "\r\n", "\n\r", chr(30), chr(155), PHP_EOL)) ? $separator : PHP_EOL;  // Checks if provided $separator is valid.
    return preg_replace('/\<br(\s*)?\/?\>/i', $separator, $string);
}

?>