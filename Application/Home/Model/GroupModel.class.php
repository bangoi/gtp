<?php
namespace Home\Model;
use Think\Model;

class GroupModel extends Model {
	
    protected $_auto = array(
    	array("user_num", 1),
		array("add_time", "date", 1, "function", array("Y-m-d H:i:s")),
		array("state", 100)
    );
	
}
?>