<?php

namespace Home\Controller;
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
			$this->assign("_nick", cookie($this->prefix."nick"));
			$this->assign("_role", cookie($this->prefix."role"));
		} else {
			$this->logined = false;
			$this->assign("_logined", false);
		}
		
		$this->site_url = C('TMPL_PARSE_STRING.__SITE__');
		
		//$this->authVerify($this->logined);
	}
	
	private function authVerify($logined) {
		if($logined != true) {
			if(CONTROLLER_NAME != "User" && CONTROLLER_NAME != "Index")
				$this->redirect("/user/login");
		}
	}
	
}

?>