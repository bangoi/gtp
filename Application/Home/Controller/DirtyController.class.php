<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;
use Think\Upload;
use Think\Image;
use Org\Util\ImageCrop;

class DirtyController extends BaseController {
	
	public function GroupController() {
		$this->assign("channel", "group");
	}
	
	public function add() {
		if(IS_POST) {
			try {
				$group_id = I("post.group_id");
				$dirty = D("Dirty");
				if($dirty->create()) {
					$dirty->user_id = $this->uid;
					$id = $dirty->add();
					$this->redirect("/group/topic/".$group_id);
				}
			} catch (Exception $ex) {
				$this->error($ex->getMessage());
			}
		}
	}
	
	public function delete() {
		$id = I("get.id");
		$group_id = I("get.group_id");
		M("Dirty")->where("id= $id")->delete();
		
		$this->redirect("/group/topic/".$group_id);
	}
	
}