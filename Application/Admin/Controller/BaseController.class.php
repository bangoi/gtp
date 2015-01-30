<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class BaseController extends Controller {
	
	protected $uid;
	protected $logined;
	
	protected $prefix = "gtp_";
	
	protected $cookie_expire = 360000;
	protected $cookie_parm;
	
	protected $site_url;
	
	public function _initialize() {
		
		$this->cookie_parm = array(
			'expire' => $this->cookie_expire,
			'prefix' => $this->prefix
		);
		
		$this->uid = cookie($this->prefix."uid");
		if(!empty($this->uid)) {
			$this->logined = true;
			$this->assign("_logined", true);
			$this->assign("_uid", cookie($this->prefix."uid"));
			$this->assign("_tel", cookie($this->prefix."tel"));
		} else {
			$this->logined = false;
			$this->assign("_logined", false);
		}
		
		$this->site_url = C('TMPL_PARSE_STRING.__SITE__');
	}
	
	protected function permission_verifying() {
		if(!$this->logined) {
			$this->redirect("m/people/login");
		} else {
			$user_id = $this->uid;
			$people = M("People")->where("id={$user_id}")->find();
			if($people["state"] != 100)
				redirect(C("TMPL_PARSE_STRING.__SITE__")."/m/notice/?key=register");
		}
	}
	
}

?>