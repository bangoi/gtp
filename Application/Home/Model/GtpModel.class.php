<?php
namespace Home\Model;
use Think\Model;

class GtpModel extends Model {

    protected $_auto = array(
    	array("download_num", 0),
    	array("digg_num", 0),
    	array("comment_num", 0),
		array("add_time", "date", 1, "function", array("Y-m-d H:i:s")),
		array("state", 100)
    );
	
}
?>