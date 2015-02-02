<?php

function toDate($time, $format='Y年m月d日 H:i:s') {
	$time = strtotime($time);
	if( empty($time)) {
		return '';
	}
    $format = str_replace('#',':',$format);
	return date($format,$time);
}

function toTime($time, $format='Y-m-d H:i') {
	$time = strtotime($time);
	if( empty($time)) {
		return '';
	}
    $format = str_replace('#',':',$format);
	return date($format,$time);
}

function getUserState($state) {
	$state_name = "正常";
	if($state == -100)
		$state_name = "已删除";
	echo $state_name;
}

?>