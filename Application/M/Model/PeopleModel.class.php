<?php
namespace Home\Model;
use Think\Model;

class PeopleModel extends Model {

    protected $_auto = array(
    	array('apply_num', 0),
    	array('work_num', 0),
		array('add_time', 'date', 1, 'function', array('Y-m-d H:i:s')),
		array('state', 1)
    );
	
}
?>