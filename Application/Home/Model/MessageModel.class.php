<?php
namespace Home\Model;
use Think\Model;

class MessageModel extends Model {
	
    protected $_auto = array(
    	array("parent_id", -1),
		array("add_time", "date", 1, "function", array("Y-m-d H:i:s")),
		array("state", 100)
    );
	
}
?>