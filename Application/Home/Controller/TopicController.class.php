<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class TopicController extends BaseController {
	
    public function index() {
    	
		$this->assign("channel", "group");
		$this->display();
    }
	
	public function details() {
		
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		$id = I("get.id");
		$topic = M("Topic")
			->join("user on user.id=topic.user_id")
			->field(" topic.id, topic.user_id, topic.group_id, topic.title, topic.content, topic.reply_num, topic.add_time, topic.state, user.nick, user.face")
			->where("topic.id={$id}")->find();
		$group = M("Group")->where("id={$topic['group_id']}")->find();
		
		$map["comment.state"] = 100;
		$map["comment.item_type"] = "topic";
		$map["comment.item_id"] = $id;

		$comment_list = M("Comment")
			->join("user on user.id=comment.user_id")
			->field("comment.id, comment.item_type, comment.item_id, comment.parent_id, comment.user_id, comment.content, comment. add_time, user.nick, user.face")
			->where($map)->order("add_time")->page($p.",{$size}")->select();
		
		$this->assign("topic", $topic);
		$this->assign("group", $group);
		$this->assign("comment_list", $comment_list);
		$this->assign("channel", "group");
		$this->display();
	}
	
	public function _before_add() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=topic/add");
	}
	
	public function add() {
		if(IS_POST) {
			$title = I("post.title");
			$content = I("post.content");
			$group_id = I("post.group_id");
			try{
				
				if(empty($title)) E("必须输标题");
				if(empty($content)) E("必须输内容");
				
				$topic = D("Topic");
		        if($topic->create()) {
		        	$topic->user_id = $this->uid;
					$topic->content = nl2br2(I("post.content"));
					$topic_id = $topic->add();
					
					$this->redirect('/topic/'.$topic_id);
		        }
			} catch (Exception $ex) {
				
				$this->assign("title", $title);
				$this->assign("content", $content);
				$this->assign("group_id", $group_id);
				
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			$group_id = I("get.group_id");
			$this->assign("group_id", $group_id);
			$this->assign("channel", "group");
			$this->display();	
		}
	}
	
	public function _before_edit() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=topic/edit/".I("get.id"));
	}
	
	public function edit() {
		if(IS_POST) {
			$title = trim(I("post.title"));
			$content = I("post.content");
			try {
				if(empty($title)) E("必须输标题");
				if(empty($content)) E("必须输内容");
				
				$id = I("post.topic_id");
				
				$data["title"] = $title;
				$data["content"] = nl2br2(I("post.content"));
				
				M("Topic")->where("id={$id}")->data($data)->save();
				
				$this->redirect('/topic/'.$id);
				
			} catch (Exception $ex) {
				$this->assign("title", $title);
				$this->assign("content", $content);
				$this->assign("group_id", $group_id);
				
				$this->assign("err", $ex->getMessage());
				$this->display();
			}		
		} else {
			$id = I("get.id");
			$topic = M("Topic")->where("id={$id}")->find();
			$this->assign("topic", $topic);
			$this->assign("channel", "group");
			$this->display();	
		}
	}
	
	public function _before_top() {
		if($this->logined != true)
			redirect($this->site_url."/user/login");
	}
	
	public function top() {
		$id = trim(I("get.id"));
		$type = trim(I("get.type"));
		$opt = trim(I("get.opt"));
		try{
			
			if(empty($id)) E("必须有话题编号");
			if(empty($type)) $type = "edit";
			
			$topic = M("Topic")->find($id);
			$data["id"] = $id;
			
			if($opt == "cancel") {
				$data["state"] = 100;
			} else {
				$data["state"] = 110;
			}
			M("Topic")->data($data)->save();
			
			$this->redirect('/group/'.$topic['group_id']);
		} catch (Exception $ex) {
			$this->error($ex->getMessage());
		}
	}
	
	public function _before_delete() {
		if($this->logined != true)
			redirect($this->site_url."/user/login");
	}
	
	public function delete() {
		$id = trim(I("get.id"));
		$type = trim(I("get.type"));
		
		try {
			
			if(empty($id)) E("必须有话题编号");
			if(empty($type)) $type = "edit";
			
			$topic = M("Topic")->find($id);
			
			if($type == "delete") {
				M("Topic")->where("id={$id}")->delete();
			} else {
				$data["id"] = $id;
				$data["state"] = -1;
				M("Topic")->data($data)->save();
			}
			$this->redirect('/group/'.$topic['group_id']);
		} catch (Exception $ex) {
			$this->error($ex->getMessage());
		}
	}
	
}