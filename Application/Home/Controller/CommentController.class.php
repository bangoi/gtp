<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;
use Org\Util\JsonResult;

class CommentController extends BaseController {
	
	public function _before_add() {
		if($this->logined != true) {
			$item_type = I("post.item_type");
			$item_id = I("post.item_id");
			
			$goto = $item_type.'/'.$item_id;
			redirect($this->site_url."/user/login/?page=".$goto);
		}
	}
	
	public function add() {
		if(IS_POST) {
			try {
				$title = I("post.content");
				if(empty($title)) E("评论内容必须填写");
				
				$item_type = I("post.item_type");
				$item_id = I("post.item_id");
				
				$comment = D("Comment");
		        if($comment->create()) {
		        	$comment->user_id = $this->uid;
					$comment->content = nl2br2(I("post.content"));
					$comment->parent_id = I("post.parent_id");
					$comment_id = $comment->add();
					
					$map["comment.id"] = $comment_id;
					$comment = M("Comment")
						->join("user on user.id = comment.user_id")
						->field("comment.id, comment.item_type, comment.item_id, comment.user_id, comment.content, comment.add_time, user.nick, user.face")
						->where($map)
						->find();
						
					if($item_type == "topic") {
						M("Topic")->where("id={$item_id}")->setInc('reply_num', 1);
						
						$data["last_reply_time"] = $this->get_now();
						M("Topic")->where("id={$item_id}")->save($data);
					}
						
					$this->assign("comment", $comment);
					$this->display("Public:comment");
		        }
			} catch (Exception $ex) {
	    		echo JsonResult::error($ex->getMessage());
			}
		}
	}
	
	public function delete() {
		
		$id = trim(I("get.id"));
		$type = trim(I("get.type"));
		
		try {
			
			if(empty($id)) E("必须有回复编号");
			if(empty($type)) $type = "edit";
			
			if($type == "delete") {
				M("Comment")->where("id={$id}")->delete();
			} else {
				$data["id"] = $id;
				$data["state"] = -1;
				M("Comment")->data($data)->save();
			}
			
			if($type == "topic") {
				$topic = M("Topic")->find($id);
				if($topic["reply_num"] > 0)
					M("Topic")->where("id={$id}")->setDec('reply_num', 1);
			}
			echo JsonResult::boolean(true);
		} catch (Exception $ex) {
			echo JsonResult::error($ex->getMessage());
		}
	}
	
}