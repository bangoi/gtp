<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;

class UserController extends BaseController {
	
	public function _before_index() {
		if(!$this->is_admin())
			redirect($this->site_url."/user/login/?page=admin/user/index");
	}
	
    public function index() {
    	
        $p = I("get.p") ? I("get.p") : 1;
		$size = 10;
    	
		$state = I("get.state");
		$role = I("get.role");
		
		if(!empty($state) && $state != -1) {
			$where["state"] = $state;
			$this->assign("state", $state);
		}
		
		if(!empty($role) && $role != "-1") {
			$where["role"] = $role;
			$this->assign("role", $role);
		}
		
		$user_list = M("User")->where($where)->order('regist_time desc')->page($p.",{$size}")->select();
		$count = M("User")->where($where)->count();
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		
		$this->assign('user_list', $user_list);
		$this->assign('page', $page);
		
        $this->display();
    }
	
	public function _before_edit() {
		if(!$this->is_admin())
			redirect($this->site_url."/user/login/?page=admin/user/edit/". I("get.id"));
	}
	
	public function edit() {
		if(IS_POST) {
			try {
				$role = trim(I("post.role"));
				$state = trim(I("post.state"));
				
				if($role == -1) E("必须选择用户角色");
				if($state == -1) E("必须选择用户状态");
					
				$id = I("post.id");
				$data['role'] = $role;
				$data['state'] = $state;
					
				M("User")->where("id={$id}")->data($data)->save();
				$this->redirect('/admin/user/');
			} catch (Exception $ex) {
				$id = I("post.id");
				$user = M("User")->where("id = {$user_id}")->find();
				$this->assign("item", $user);
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			$user_id = I("get.id");
			$user = M("User")->where("id = {$user_id}")->find();
			$this->assign("item", $user);
			
			$this->display();
		}
	}
	
}