<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;
use Think\Upload;
use Think\Image;
use Org\Util\ImageCrop;

class GroupController extends BaseController {
	
    public function index() {
    	
		$this->assign("channel", "gtp");
		$this->display();
    }
	
	public function details() {
		
		$id = I("get.id");
		$group = M("Group")->where("id={$id}")->find();
		
		$p = $_GET["p"] ? $_GET["p"] : 1;
		$size = 15;
		
		
		
		$k = trim(I("get.k"));
		if(!empty($k)) {
			$map["topic.title"] = array('like', "%{$k}%");
			$this->assign("k", $k);
		}
		
		$top_map["group_id"] = $id;
		$top_map["state"] = 110;
		$topic_top_list = M("Topic")->where($top_map)->select();
		
		$map["topic.group_id"] = $id;
		$map["topic.state"] = 100;
		$topic_list = M("Topic")
			->join("user on user.id=topic.user_id")
			->field(" topic.id, topic.user_id, topic.title, topic.reply_num, topic.add_time, topic.state, user.nick, user.face")
			->where($map)->order("add_time desc")->page($p.",{$size}")->select();
		$count = M('Topic')->where($map)->count();
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		
		$this->assign("topic_list", $topic_list);
		$this->assign("topic_top_list", $topic_top_list);
		$this->assign('page', $page);
		$this->assign("group", $group);
		$this->assign("channel", "group");
		$this->display();
	}
	
	public function _before_add() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=group/add");
	}
	
	public function add() {
		
		if(IS_POST) {
			try {
				
				$title = I("post.title");
				if(empty($title)) E("必须输小组名称");
				
				$group = D("Group");
		        if($group->create()) {
		        	$group->user_id = $this->uid;
					$group->content = nl2br2(I("post.content"));
					$group_id = $group->add();
					
					$userGroup = D("UserGroup");
					if($userGroup->create()) {
						$userGroup->user_id = $this->uid;
						$userGroup->group_id = $group_id;
						$userGroup->role = "owner";
						$userGroup->add();
					}
					
					$this->redirect('/group/face/'.$group_id);
		        }
			} catch (Exception $ex) {
	    		$this->assign("err", $ex->getMessage());
				$this->assign("channel", "group");
				$this->display();
			}
		} else {
			$this->assign("channel", "group");
			$this->display();	
		}
		
	}
	
	public function _before_edit() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=group/edit/".I("get.id"));
	}
	
	public function edit() {
		
		if(IS_POST) {
			try {
				
				$title = I("post.title");
				if(empty($title)) E("必须输入视频标题");
				
				$id = I("post.group_id");
				
				$data["title"] = $title;
				$data["content"] = nl2br2(I("post.content"));
				$data["tags"] = trim(I("post.tags"));
				
				M("Group")->where("id={$id}")->data($data)->save();
				
				$this->redirect('/group/'.$id);
				
			} catch(Exception $ex) {
				$this->assign("err", $ex->getMessage());
				$this->assign("channel", "group");
				$this->display();
			}			
		} else {
			$group_id = I("get.id");
			$group = M("Group")->where("id=$group_id")->find();

			$this->assign("item", $group);
			$this->assign("channel", "group");
			$this->display();	
		}
	}
	
	public function _before_face() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=group/face/".I("get.id"));
	}
	
	public function face() {
		if(IS_POST) {
			try {
				if(!empty($_FILES["face"]) && $_FILES["face"]['size'] > 0) {
					
					$face_arr = Array(
						'maxSize' => 3145728,
						'exts' => array('jpg', 'gif', 'png', 'jpeg'),
						'saveName' => 'time',
						'replace' => true,
						'rootPath' => './',
						'savePath' => './upload/group/'
					);
						
					$upload = new Upload($face_arr);
					$info = $upload->uploadOne($_FILES['face']);
					
					$group_id = I("post.group_id");
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
							
						$old_imgUrlpath = $user["face"];
						unlink(get_imgPath($old_imgUrlpath, 'm', false));
						unlink(get_imgPath($old_imgUrlpath, 's', false));
						unlink($thumb_file);
						
						$data['face'] = substr($thumb_file, 2);
						M("Group")->where("id={$group_id}")->data($data)->save();
				 	}
					$this->redirect("/group/face/".$group_id);
				}
				E("必须上传图片文件");
			} catch (Exception $ex) {
				$this->assign("err", $ex->getMessage());
				$this->assign("channel", "group");
				$this->display();
			}
		} else {
			$group_id = I("get.id");
			$group = M("Group")->where("id=$group_id")->find();
			$this->assign("group", $group);
			$this->assign("channel", "group");
			$this->display();	
		}
	}

	public function _before_crop() {
		if($this->logined != true)
			redirect($this->site_url."/user/login");
	}

	public function crop() {
		if(IS_POST) {
			try {
				$group_id = I("post.group_id");
				$group = M("Group")->where("id={$group_id}")->find();
				
				$crop = new ImageCrop();
				$crop->initialize(
					get_imgPath($group['face'], 'm', false),
					get_imgPath($group['face'], 's', false),
					I("post.x"),
					I("post.y"),
					I("post.x") + I("post.w"),
					I("post.y") + I("post.h")
				);
				$filename = $crop->generate();
				$this->redirect("group/edit/".$group_id);
			} catch (Exception $ex) {
				$this->assign("err", $ex->getMessage());
				$this->assign("channel", "group");
				$this->display();
			}
		}
	}
	
	public function _before_join() {
		if($this->logined != true)
			redirect($this->site_url."/user/login");
	}
	
	public function join() {
		$gruop_id = I("get.id");
		$type = I("get.type");
		
		if($type == "out") {
			$map["user_id"] = $this->uid;
			$map["group_id"] = $gruop_id;
			
			$ug = M("UserGroup")->where($map)->find();
			if(!empty($ug) && $ug["role"] == "member") {
				$userGroup = M("UserGroup")->where($map)->delete();
				$group = M("Group")->find($gruop_id);
				if($group["user_num"] > 0)
					M("Group")->where("id={$gruop_id}")->setDec('user_num', 1);
			}
		} else {
			$userGroup = M("UserGroup");
			$data["user_id"] = $this->uid;
			$data["group_id"] = $gruop_id;
			$data["role"] = "member";
			$data["state"] = 100;
			$data["add_time"] = $this->get_now();
				
			$userGroup->add($data);
			M("Group")->where("id={$gruop_id}")->setInc('user_num', 1); 
		}
		$this->redirect("/group/".$gruop_id);
	}
	
	public function delete() {
		
	}
	
}