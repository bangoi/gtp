<?php
namespace Home\Model;
use Think\Model;

class VedioModel extends Model {

    protected $_auto = array(
    	array("digg_num", 0),
    	array("view_num", 0),
    	array("comment_num", 0),
		array("add_time", "date", 1, "function", array("Y-m-d H:i:s")),
		array("state", 100)
    );
	
}
?>