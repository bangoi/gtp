<?php

namespace Home\Controller;
use Think\Controller;
use Think\Exception;

header('Content-Type: text/html; charset=utf-8');

class BaseController extends Controller {
	
	protected $uid;
	protected $logined;
	protected $role;
	
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
			$this->$role = cookie($this->prefix."role");
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
	
	protected function can_edit($item_type, $item_id) {
		
		if($this->logined == false) 
			return false;
		
		if(cookie($this->prefix."role") == "admin")
			return true;
		
		$user_id = -1;
		if($item_type == "vedio") {
			$vedio = M("Vedio")->where("id = {$item_id}")->find();
			$user_id = $vedio["user_id"];
		} else if($item_type == "gtp") {
			$gtp = M("Gtp")->where("id = {$item_id}")->find();
			$user_id = $gtp["user_id"];
		}
		return $this->uid == $user_id;
	}
	
	protected function get_now() {
		return date("Y-m-d H:i:s");
	}
	
	protected function add_cookie($id, $nick, $role) {
				
		cookie('uid', $id, $this->cookie_parm);
		cookie('nick', urlencode($nick), $this->cookie_parm);
		cookie('role', $role, $this->cookie_parm);
	}
	
	protected function render_gtp($file_name, $title) {
		$ua = $_SERVER["HTTP_USER_AGENT"];
		$encoded_filename = urlencode($file_name);
		$encoded_filename = str_replace("+", "%20", $encoded_filename);

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Component: must-revalidate, post-check=0, pre-check=0");
		header('Content-Type: application/octet-stream');

		if (preg_match("/MSIE/", $ua))	
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
		else if (preg_match("/Firefox/", $ua))	
			header('Content-Disposition: attachment; filename*="utf8\'\''.$file_name.'"');
		else	
			header('Content-Disposition: attachment; filename="'.$file_name. '"');
		
		readfile($title);
	}
	
}

?>