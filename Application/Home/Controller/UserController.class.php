<?php

namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Upload;
use Think\Image;
use Org\Util\Encode;
use Org\Util\String;
use Org\Util\ImageCrop;

class UserController extends BaseController {
	
    public function login() {
    		
    	if(IS_POST) {
			try {
				
				$nick = trim(I("post.nick"));
				$pwd = trim(I("post.pwd"));
				
				if(empty($nick)) E("用户名不能为空");
				if(empty($pwd)) E("密码不能为空");
						
				$encode = new Encode();
				$pwd = $encode->encode($pwd);
				
				$map["nick"] = $nick;
				$map["pwd"] = $pwd;
				
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
					
					if($nick_count > 0) E("用户名与密码不匹配");
					else E("用户名不存在"); 
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
				
				if(empty($nick)) E("用户名不能为空");
				if(empty($pwd)) E("密码不能为空");
				if(empty($email)) E("邮箱不能为空");
				if($pwd != $re_pwd)	E("两次输入密码必须相同");
				$string = new String();
				if(!$string->isEmail($email)) E("非法的Email格式");
				
				$encode = new Encode();
				$pwd = $encode->encode($pwd);
				
				$nick_count = M("User")->where("nick='{$nick}'")->count();
				if($nick_count > 0) E("用户名已存在");
				
				$email_count = M("User")->where("email='{$email}'")->count();
				if($email_count > 0)	E("邮箱已存在");
				
				$user = D("User");
				if($user->create()) {
					
					$user->pwd = $pwd;
					$id =$user->add();
					
					$this->add_cookie($id, $nick, 'member');
					$this->redirect("/");
		       	}
				E("用户注册失败");
				
			} catch (Exception $ex) {
				
				$this->assign("nick", trim(I("post.nick")));
				$this->assign("email", trim(I("post.email")));
				$this->assign("err", $ex->getMessage());
				
				$this->display();
			}
    	} else {
    		$this->display();
    	}
		
	}

	public function details() {
		$id = I("get.id");
		$domain = I("get.domain");
		$tab = I("get.tab");
		
		if(!empty($id))
			$user = M("User")->where("id={$id}")->find();
		if(!empty($domain))
			$user = M("User")->where("domain='{$domain}'")->find();
		
		
		
		$this->assign("user", $user);
		$this->assign("tab", $tab);
		$this->display();
	}
	
	public function _before_settings() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=user/settings");
	}

	public function settings() {
		
		if(IS_POST) {
			try {
				
				$user_id = $this->uid;
				
				$domain = I("post.domain");
				$signature = I("post.signature");
				$province_code = I("post.province_code");
				$city_code = I("post.city_code");
				
				if(!empty($domain)) {
					if(strlen($domain) < 4 || strlen($domain) > 20) E("个性域名只能由4-20个字母或数字组成");
					
					$first_letter = substr($domain, 0, 1);
					if(is_numeric($first_letter)) E("个性域名第一位不能为数字");
					
					$domain_count = M("User")->where("domain='{$domain}'")->count();
					if($domain_count > 0) E("个性域名已被占用");
					
					$data['domain'] = trim($domain);
				}
				
				$data['signature'] = nl2br2(trim($signature));
				$data['province_code'] = trim($province_code);
				$data['city_code'] = trim($city_code);
				
				M("User")->where("id={$user_id}")->data($data)->save();
				
				$user = M("User")->where("id={$user_id}")->find();
				
				$province_list = M("Province")->order("id")->select();
				$this->assign("province_list", $province_list);
				
				$city = M("City")->where("code='{$user['city_code']}'")->find();
				$this->assign("city", $city);
				
				$city_list = M("City")->where("province_code='{$user['province_code']}'")->select();
				$this->assign("city_list", $city_list);
				
				$this->assign("notice", "编辑成功");
				$this->assign("user", $user);
				$this->display();
				
			} catch (Exception $ex) {
				
				$user = M("User")->where("id={$this->uid}")->find();
				
				$signature = I("post.signature");
				$province_code = I("post.province_code");
				$city_code = I("post.city_code");
				$domain = I("post.domain");
				
				if(!empty($signature))
					$user->signature = $signature;
				if(!empty($province_code))
					$user->province_code = $province_code;
				if(!empty($city_code))
					$user->city_code = $city_code;
				if(!empty($domain))
					$user->domain = $domain;
				
				$province_list = M("Province")->order("id")->select();
				$this->assign("province_list", $province_list);
				
				if($user["city_code"] != "-1") {
					$city = M("City")->where("code='{$user['city_code']}'")->find();
					$this->assign("city", $city);
				}
				
				$city_list = M("City")->where("province_code='{$user['province_code']}'")->select();
				$this->assign("city_list", $city_list);
				
				$this->assign("user", $user);
				$this->assign("err", $ex->getMessage());
				
				$this->display();
			}
		} else {
			$user = M("User")->where("id={$this->uid}")->find();
		
			$province_list = M("Province")->order("id")->select();
			
			if($user["city_code"] != "-1") {
				$city = M("City")->where("code='{$user['city_code']}'")->find();
				$this->assign("city", $city);
			}
			
			$city_list = M("City")->where("province_code='{$user['province_code']}'")->select();
			$this->assign("city_list", $city_list);
				
			$page = I("get.page");
			$this->assign("page", $page);
			
			$this->assign("user", $user);
			$this->assign("province_list", $province_list);
			
			$this->display();
		}
	}
	
	public function _before_get_city() {
		if($this->logined != true)
			redirect($this->site_url."/user/login");
	}
	
	public function get_city() {
		$province_code = I("get.province_code");
		$city_list = M("City")->where("province_code = '{$province_code}'")->select();
		echo json_encode($city_list);
	}
	
	public function _before_face() {
		if($this->logined != true)
			redirect($this->site_url."/user/login");
	}
	
	public function face() {
		
		$user_id = $this->uid;
		if(IS_POST) {
			try {
				if(!empty($_FILES["face"]) && $_FILES["face"]['size'] > 0) {
					$upload = new Upload();
					$upload->maxSize = 3145728;
					$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
					$upload->saveName = 'time';
					$upload->replace = true;
					$upload->rootPath = './';
					$upload->savePath = './upload/face/';
					
					$info = $upload->uploadOne($_FILES['face']);
						
					if(!$info) {
						E($upload->getError());
					}else{
						
						$image = new Image();
						
						$thumb_file = $info['savepath'] . $info['savename'];
                    	$m_path = $info['savepath'] . 'm' . $info['savename'];
                    	$s_path = $info['savepath'] . 's' . $info['savename'];
						
                    	$image->open($thumb_file)
                    		->thumb(300, 300, Image::IMAGE_THUMB_CENTER)
                    		->save($m_path);
						$image->open($thumb_file)
                    		->thumb(50, 50, Image::IMAGE_THUMB_CENTER)
                    		->save($s_path);
							
						$user = M("User")->where("id = {$user_id}")->find();
						
						$old_imgUrlpath = $user["face"];
						unlink(get_imgPath($old_imgUrlpath, 'm', false));
						unlink(get_imgPath($old_imgUrlpath, 's', false));
						unlink($thumb_file);
						
						$data['face'] = substr($thumb_file, 2);
						M("User")->where("id={$user_id}")->data($data)->save();
				 	}
					$this->redirect("/user/face");
				}
				E("必须上传图片文件");
			} catch (Exception $ex) {
				
				$user = M("User")->where("id={$user_id}")->find();
				
				$this->assign("face", $user["face"]);
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			
			$user = M("User")->where("id={$user_id}")->find();
			$this->assign("face", $user["face"]);
			$this->display();
		}
	}

	public function crop() {
		if(IS_POST) {
			try {
				$user_id = $this->uid;
				$user = M("User")->where("id={$user_id}")->find();
				
				$crop = new ImageCrop();
				$crop->initialize(
					get_imgPath($user['face'], 'm', false),
					get_imgPath($user['face'], 's', false),
					I("post.x"),
					I("post.y"),
					I("post.x") + I("post.w"),
					I("post.y") + I("post.h")
				);
				$filename = $crop->generate();
				$this->redirect("user/settings");
			} catch (Exception $ex) {
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		}
	}
	
	public function logout() {
		cookie(null, $this->prefix);
		$this->redirect("/");
	}

}