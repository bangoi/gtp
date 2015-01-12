<?php

function applied($item_id, $people_id) {
	$ip_data["item_id"] = $item_id;
	$ip_data["people_id"] = $people_id;
			
	$ip_count = M("ItemPeople")->where($ip_data)->count();
	//dump(M("ItemPeople")->_sql());
	return $ip_count > 0;
}

?>