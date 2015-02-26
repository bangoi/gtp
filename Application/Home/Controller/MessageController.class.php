<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;


class MessageController extends BaseController {
	
	public function _before_index() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=message/");
	}
	
	public function index() {
		$user_id = $this->uid;
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		$map["message.to_id"] = $user_id;
		$map["message.state"] = array("gt", 0);
		
		$message_list = M("Message")
			->join("user on message.user_id=user.id")
			->field("user.nick, message.id, message.user_id, message.to_id, message.title, message.add_time, message.state")
			->where($map)
			->order("add_time")->page($p.",{$size}")->select();
		
		$this->assign("message_list", $message_list);
		$this->display();
	}
	
	public function mine() {
		$user_id = $this->uid;
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		$map["message.user_id"] = $user_id;
		$map["message.state"] = array("gt", 0);
		
		$message_list = M("Message")
			->join("user on message.user_id=user.id")
			->field("user.nick, message.id, message.user_id, message.to_id, message.title, message.add_time, message.state")
			->where($map)
			->order("add_time")->page($p.",{$size}")->select();
		
		$this->assign("message_list", $message_list);
		$this->assign("type", "mine");
		$this->display("index");
	}
	
	public function _before_details() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=message/");
	}
	
	public function details() {
		
		$id = I("get.id");
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		$map["message.id"] = $id;
		$message = M("Message")
			->join("user on message.user_id=user.id")
			->field("user.nick, message.id, message.user_id, message.title, message.content, message.add_time, message.state")
			->where($map)
			->find();
			
		if($this->uid != $message["user_id"]) {
			$data["state"] = 200;
			M("Message")->where($map)->data($data)->save();	
		}
		
		$message_map["message.state"] = 100;
		$message_map["message.parent_id"] = $id;
		
		$message_list = M("Message")
			->join("user on user.id=message.user_id")
			->field("message.id, message.parent_id, message.user_id, message.to_id, message.add_time, user.nick, user.face")
			->where($message_map)->order("add_time")->page($p.",{$size}")->select();
		
		$this->assign("message", $message);
		$this->assign("message_list", $message_list);
		$this->display();
	}
	
	public function add() {
		if(IS_POST) {
			
			$title = I("post.title");
			$content = I("post.content");
			
			try {
				
				if(empty($title)) E("必须输标题");
				if(empty($content)) E("必须输内容");
				
				$message = D("Message");
		        if($message->create()) {
		        	$message->user_id = $this->uid;
		        	$message->add();
		        }
			} catch (Exception $ex) {
				$this->assign("title", $title);
				$this->assign("content", $content);
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			$to_id = I("get.id");
			$user = M("User")->find($to_id);
			
			$this->assign("to_id", $to_id);
			$this->assign("user", $user);
			$this->display();
		}
	}
	
	public function reply() {
		if(IS_POST) {
			try {
				$message = D("Message");
		        if($message->create()) {
		        	$id = I("post.parent_id");
		        	$message->user_id = $this->uid;
					$message->parent_id = $id;
		        	$message->add();
					
					$this->redirect("/message/".$id);
					$this->display();
		        }
			} catch (Exception $ex) {
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		}
	}
	
	public function delete() {
		
	}
	
	public function operate() {
		
	}
	
}