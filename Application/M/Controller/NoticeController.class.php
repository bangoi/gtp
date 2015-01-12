<?php

namespace M\Controller;
use Think\Controller;
use Think\Exception;

class NoticeController extends BaseController {
	
    public function index() {
    	
		$key = trim($_GET['key']);
		
		switch ($key) {
			case 'apply':
				$this->assign("item", trim($_GET["item_id"]));
				break;
			
			default:
				break;
		}
		
		$this->assign("key", $_GET['key']);
        $this->display();
    }
	
}