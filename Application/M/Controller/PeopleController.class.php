<?php
namespace M\Controller;
use Think\Controller;
use Think\Exception;

header("Content-type: text/html; charset=utf-8");

class PeopleController extends BaseController {
	
    public function login() {
    	
    	if(IS_POST) {
			try {
				
				//$name = trim($_POST["name"]);
				$tel = trim($_POST["tel"]);
				$pwd = trim($_POST["pwd"]);
				
				if(!$this->is_tel($tel))
					throw new Exception("不是有效的手机号码");
				
				$map["tel"] = $tel;
				$map["pwd"] = $pwd;
				
				$people = M("People")->where($map)->find();
				//dump($user);
				if(!empty($people)) {
					cookie('uid', $people["id"], $this->cookie_parm);
					cookie('tel', $people["tel"], $this->cookie_parm);
					
					if($people["state"] == 100)
						$this->redirect("/m/");
					else {
						// state = 1 刚注册； state = -100 取消审核
						//$this->redirect("/m/people/login_notice");
						redirect($this->site_url."/m/notice/?key=login_notice");
					}
						
					
				} else {
					
					$tel_count = M("People")->where("tel='{$tel}'")->count();
					//dump(M("User")->_sql());
					if($tel_count > 0)
						throw new Exception("电话号码与密码不匹配");
					throw new Exception("电话号码未注册");
				}
			} catch (Exception $ex) {
				$this->assign("tel", $_POST["tel"]);
				//$this->assign("name", $_POST["name"]);
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
				$name = trim($_POST["name"]);
				$tel = trim($_POST["tel"]);
				
				//dump($_POST);
								
				if(!$this->is_tel($tel))
					throw new Exception("不是有效的手机号码");
				
				$tel_count = M("People")->where("tel='{$tel}'")->count();
				
				if($tel_count > 0)
					throw new Exception("该电话号码已被注册");
				
				$people = D("People");
				if($people->create()) {
					$people->pwd = substr($tel, -6);
					$people->state = 1;
					$people->add_time = date("Y-m-d H:i:s");;
					$id =$people->add();
					
					cookie('uid', $id, $this->cookie_parm);
					cookie('tel', $tel, $this->cookie_parm);
					
					//$this->redirect("/m/people/login_notice");
					redirect($this->site_url."/m/notice/?key=login_notice");
		       	}
				throw new Exception("用户注册失败");
				
			} catch(Exception $ex) {
				
				$this->assign("tel", $_POST["tel"]);
				$this->assign("name", $_POST["name"]);
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			$this->display();
		}
	}
	
	public function repwd()  {
		
		if(IS_POST) {
			try {
				$people_id = $this->uid;
				$pwd = trim($_POST["pwd"]);
				$pwd_new1 = trim($_POST["pwd_new1"]);
				$pwd_new2 = trim($_POST["pwd_new2"]);
				
				if($pwd_new1 != $pwd_new2)
					throw new Exception("两次输入新密码不匹配");
				
				$map["id"] = $people_id;
				$map["pwd"] = $pwd;
				
				$count = M("People")->where($map)->count();
				
				// correct
				if($count > 0) {
					$p_map["pwd"] = $pwd_new1;
					M("People")->where("id = {$people_id}")->data($p_map)->save();
					
					redirect(C("TMPL_PARSE_STRING.__SITE__")."/m", 3, "修改成功");
				}else { // incorrect
					throw new Exception("输入原密码不正确");
				} 
			} catch (Exception $ex) {
				$this->assign("tel", $_POST["tel"]);
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			$this->assign("tel", cookie($this->prefix."tel"));
			$this->display();
		}
	}
	
	public function logout() {
		cookie(null, $this->prefix);
		$this->redirect("/m/people/login");
	}

	private function is_tel($tel) {
		$is_tel = false;
		if(preg_match("/1[3458]{1}\d{9}$/", $tel))
			$is_tel = true;
		return $is_tel;
	}
	
}