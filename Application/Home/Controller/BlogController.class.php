<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;
use Think\Upload;
use Think\Image;
use Org\Util\ImageCrop;

class BlogController extends BaseController {
	
	public function details() {
		
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		$id = I("get.id");
		$blog = M("Blog")
			->join("user on blog.user_id=user.id")
			->field("user.nick, blog.id, blog.user_id, blog.title, blog.content, blog.add_time")
			->where("blog.id={$id}")
			->find();
			
		$map["comment.state"] = 100;
		$map["comment.item_type"] = "blog";
		$map["comment.item_id"] = $id;
			
		$comment_list = M("Comment")
			->join("user on user.id=comment.user_id")
			->field("comment.id, comment.item_type, comment.item_id, comment.parent_id, comment.user_id, comment.content, comment. add_time, user.nick, user.face")
			->where($map)->order("add_time")->page($p.",{$size}")->select();
			
		$map_blog["state"] = 100;
		$map_blog["id"] = array("neq", $id);
		$blog_list = M("Blog")->where($map_blog)->order("add_time desc")->limit(10)->select();

		$this->assign("blog", $blog);
		$this->assign("comment_list", $comment_list);
		$this->assign("blog_list", $blog_list);
		$this->display();
	}
	
}