<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;

class BlogController extends BaseController {
	
	public function _before_index() {
		if(!$this->is_admin())
			redirect($this->site_url."/user/login/?page=admin/blog/index");
	}
	
    public function index() {
    	
		$p = I("get.p") ? I("get.p") : 1;
		$size = 10;
    	
		$blog_list = D("BlogView")->where($where)->order('add_time desc')->page($p.",{$size}")->select();
		$count = D("BlogView")->where($where)->count();
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		
		$this->assign('blog_list', $blog_list);
		$this->assign('page', $page);
		
        $this->display();
    }
	
	public function _before_add() {
		if(!$this->is_admin())
			redirect($this->site_url."/user/login/?page=admin/blog/add");
	}
	
	public function add() {
		if(IS_POST) {
			try {
				$blog = D("Blog");
				if($blog->create()) {
					$blog->user_id = $this->uid;
					$blog->add();
					
					$this->redirect("/admin/blog/");
				}
			} catch (Exception $ex) {
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			$this->display();
		}
	}
	
	public function _before_edit() {
		if(!$this->is_admin())
			redirect($this->site_url."/user/login/?page=admin/blog/edit/".I("get.id"));
	}
	
	public function edit() {
		if(IS_POST) {
			try {
				
				$title = trim(I("post.title"));
				$content = trim(I("post.content"));
				
				if(empty($title)) E("必须输入标题");
				if(empty($content)) E("必须输入内容");
				
				$id = I("post.id");
				
				$data['title'] = $title;
				$data['description'] = trim(I("post.description"));
				$data['content'] = $content;
				$data['tags'] = trim(I("post.tags"));
		
				M("Blog")->where("id={$id}")->data($data)->save();
				$this->redirect('/admin/blog');
			} catch (Exception $ex) {
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			$id = I("get.id");
			$blog = M("Blog")->where("id={$id}")->find();
			$this->assign("item", $blog);
			$this->display();
		}
	}
	
}