<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends BaseController {
	
	public function _before_index() {
		if(!$this->is_admin())
			redirect($this->site_url."/user/login/?page=admin/index/index");
	}
	
    public function index() {
        $this->display();
    }
	
}