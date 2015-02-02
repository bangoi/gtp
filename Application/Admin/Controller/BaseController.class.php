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
			$this->redirect("admin/user/login");
		} else {
			$user_id = $this->uid;
			$user = M("User")->where("id={$user_id}")->find();
			if($user["state"] != 100 || $user["role"] != "admin")
				redirect(C("TMPL_PARSE_STRING.__SITE__")."/admin/user/login");
		}
	}
	
	protected function is_admin() {
		$is_verified = true;
		if(!$this->logined) {
			$is_verified = false;
			echo "not logined";
		} else {
			$user_id = $this->uid;
			$user = M("User")->where("id={$user_id}")->find();
			if($user["state"] != 100 || $user["role"] != "admin") {
				echo "not 100 or is not admin";
				$is_verified = false;
			}
		}
		return $is_verified;
	}
	
}

?>