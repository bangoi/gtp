<?php

namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Org\Util\Encode;
use Org\Util\String;

class UserController extends BaseController {
	
    public function login() {
    		
    	if(IS_POST) {
			try {
				
				$nick = trim(I("post.nick"));
				$pwd = trim(I("post.pwd"));
				
				$map["nick"] = $nick;
				$map["pwd"] = $pwd;
						
				$encode = new Encode();
				$pwd = $encode->encode($pwd);
				
				$user = M("User")->where($map)->find();
				//dump($user);
				if(!empty($user)) {
					
					$data["last_login_time"] = $this->get_now();
					M("User")->where("id={$user['id']}")->data($data)->save();
					
					$this->add_cookie($user["id"], $nick, $user["role"]);
					
					$page = I("post.page");
					if(empty($page))
						$this->redirect("/");
					else
						redirect($this->site_url.'/'.$page);
				} else {
					
					$nick_count = M("User")->where("nick='{$nick}'")->count();
					//dump(M("User")->_sql());
					if($nick_count > 0)
						throw new Exception("用户名与密码不匹配");
					else	
						throw new Exception("用户名不存在"); 
				}
					
			} catch (Exception $ex) {
				
				$this->assign("nick", I("post.nick"));
				$this->assign("email", I("post.email"));
				$this->assign("page", I("post.page"));
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
			
    	} else {
    		$page = I("get.page");
			
			$this->assign("page", $page);
    		$this->display();
    	}
    }
	
	public function register() {
			
		if(IS_POST) {
			try {
				//throw new Exception("暂未开放注册", 1);
				
				$nick = trim(I("post.nick"));
				$pwd = trim(I("post.pwd"));
				$re_pwd = trim(I("post.re_pwd"));
				$email = trim(I("post.email"));
				
				if($pwd != $re_pwd)
					throw new Exception("两次输入密码必须相同");
				
				$string = new String();
				if(!$string->isEmail($email))
					throw new Exception("非法的Email格式");
				
				$encode = new Encode();
				$pwd = $encode->encode($pwd);
				
				$nick_count = M("User")->where("nick='{$nick}'")->count();
				$email_count = M("User")->where("email='{$email}'")->count();
				
				if($nick_count > 0)
					throw new Exception("用户名已存在");
				
				if($email_count > 0)
					throw new Exception("邮箱已存在");
				
				$user = D("User");
				
				if($user->create()) {
					
					$id =$user->add();
					
					$this->add_cookie($user->id, $nick, $user->role);
					$this->redirect("/");
		       	}
				throw new Exception("用户注册失败");
				
			} catch (Exception $ex) {
				
				$this->assign("nick", I("post.nick"));
				$this->assign("email", I("post.email"));
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