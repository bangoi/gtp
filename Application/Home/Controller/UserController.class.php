<?php

namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class UserController extends BaseController {
	
    public function login() {
    		
    	if(IS_POST) {
			try {
				$nick = trim($_POST["nick"]);
				$pwd = trim($_POST["pwd"]);
				
				$map["nick"] = $nick;
				$map["pwd"] = $pwd;
				
				$user = M("User")->where($map)->find();
				//dump($user);
				if(!empty($user)) {
					
					cookie('uid', $user["id"], $this->cookie_parm);
					cookie('nick', urlencode($nick), $this->cookie_parm);
					cookie('role', $user["role"], $this->cookie_parm);

					$this->redirect("/");
				} else {
					
					$nick_count = M("User")->where("nick='{$nick}'")->count();
					//dump(M("User")->_sql());
					if($nick_count > 0)
						throw new Exception("用户名与密码不匹配");
					else	
						throw new Exception("用户名不存在"); 
				}
					
			} catch (Exception $ex) {
				//dump($ex);
				//dump($ex->getMessage());
				$this->assign("nick", $_POST["nick"]);
				$this->assign("email", $_POST["email"]);
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
			
    	} else {
    		$this->display();
    	}
    }
	
	public function register() {
			
		if(IS_POST) {
			try {
				//throw new Exception("暂未开放注册", 1);
				
				$nick = trim($_POST["nick"]);
				$pwd = trim($_POST["pwd"]);
				$re_pwd = trim($_POST["re-pwd"]);
				$email = trim($_POST["email"]);
				
				$nick_count = M("User")->where("nick='{$nick}'")->count();
				$email_count = M("User")->where("email='{$email}'")->count();
				
				if($nick_count > 0)
					throw new Exception("用户名已存在");
				if($pwd != $re_pwd)
					throw new Exception("两次输入密码必须相同");
				if($email_count > 0)
					throw new Exception("邮箱已存在");
				
				$user = D("User");
				if($user->create()) {
					$id =$user->add();
					
					//dump(M("User")->_sql());
					cookie('uid', $user["id"], $this->cookie_parm);
					cookie('nick', urlencode($nick), $this->cookie_parm);
					cookie('role', $user["role"], $this->cookie_parm);
					
					$this->redirect("/");
		       	}
				throw new Exception("用户注册失败");
				
			} catch (Exception $ex) {
				//dump($ex);
				//dump($ex->getMessage());
				$this->assign("nick", trim($_POST["nick"]));
				$this->assign("email", trim($_POST["email"]));
				$this->assign("err", $ex->getMessage());
				
				$this->display();
			}
    	} else {
    		$this->display();
    	}
		
	}
	
	public function logout() {
			
		cookie(null, $this->prefix);
		$this->redirect("/");
	}

}