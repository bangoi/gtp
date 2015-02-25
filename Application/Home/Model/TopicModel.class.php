<?php
namespace Home\Model;
use Think\Model;

class TopicModel extends Model {

    protected $_auto = array(
    	array("reply_num", 0),
    	array("last_reply_time", "date", 1, "function", array("Y-m-d H:i:s")),
		array("add_time", "date", 1, "function", array("Y-m-d H:i:s")),
		array("state", 100)
    );
	
}
?>