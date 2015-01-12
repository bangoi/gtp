<?php
namespace Home\Model;
use Think\Model;

class UserModel extends Model {

    protected $_auto = array(
		array('add_time', 'date', 1, 'function', array('Y-m-d H:i:s')),
		array('state', 100)
    );
	
}
?>