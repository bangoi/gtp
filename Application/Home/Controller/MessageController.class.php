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
		
		$map['_logic'] = 'OR';
		$map["message.user_id"] = $user_id;
		$map["message.parent_id"] = -1;
		$map["message.state"] = array("gt", 0);
		
		$message_list = M("Message")
			->join("user on message.user_id=user.id")
			->field("user.nick, message.id, message.parent_id, message.user_id, message.to_id, message.title, message.content, message.reply_num, message.last_reply_time, message.add_time, message.state")
			->where($map)->order("last_reply_time desc")
			->page($p.",{$size}")->select();
			
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
			->field("user.nick, message.id, message.parent_id, message.user_id, message.to_id, message.title, message.content, message.add_time, message.state")
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
	
		$msg = M("Message")
			//->join("user user.id = message.user_id")
			//->field("user.nick, message.id, message.parent_id, message.user_id, message.to_id, message.title, message.content, message.add_time, message.repl_time, message.title")
			->where("message.id = $id")
			->find();
			
		if($msg["to_id"] == $this->uid) {
			$data["state"] = 200;
			$data["reply_num"] = $msg["reply_num"] + 1;
			M("Message")->where("id={$id}")->data($data)->save();
		}
			
		$this->assign("message", $msg);
		$this->assign("to_id", $msg["user_id"]);
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
				$this->redirect("/message/mine");
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
				$comment = D("Comment");
		        if($comment->create()) {
		        	$parent_id = I("post.parent_id");
		        	$message->user_id = $this->uid;
					$message->parent_id = $parent_id;
		        	$id = $message->add();
					
					$this->redirect("/message/".$parent_id);
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