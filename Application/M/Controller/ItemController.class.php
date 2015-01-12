<?php

namespace M\Controller;
use Think\Controller;
use Think\Exception;

class ItemController extends BaseController {
	
	public function _before_apply() {
		$this->permission_verifying();
	}
	
	public function apply() {
		
		$item_id = $_GET["id"];
		$people_id = $this->uid;
		
		try {
			
			$item =  M("Item")->where("id = {$item_id}")->find();
			
			if($item["state"] == 100 || $item["state"] == 101) {
				
				$ip_data["item_id"] = $item_id;
				$ip_data["people_id"] = $people_id;
				
				$ip_count = M("ItemPeople")->where($ip_data)->count();
				//dump(M("ItemPeople")->_sql());
				if($ip_count > 0) {
					$map["add_time"] = date("Y-m-d H:i:s");
					M("ItemPeople")->where($map)->save($data);
					//dump(M("ItemPeople")->_sql());
				} else {
					$item_people = D("ItemPeople");
	
					$item_people->people_id = $people_id;
					$item_people->item_id = $item_id;
					$item_people->state = 100; // 已申请
					$item_people->add_time = date("Y-m-d H:i:s");
					//dump($item_people);
					$item_people->add();
						
					//$item_data["state"] = 101;
					//M("Item")->where("id={$item_id}")->save($item_data);
				}
				$item = M("Item")->where("id={$item_id}")->find();
				
				$item_data["apply_num"] = $item["apply_num"] + 1;
				M("Item")->where("id={$item_id}")->data($item_data)->save();
				
				$this->assign("item_id", $item_id);
				$this->assign("item", $item);
				
			} else {
				redirect($this->site_url."/m/notice/?key=item_bad&state=".$item['state']);
			}
			
			redirect($this->site_url."/m/notice/?key=apply&item_id=".$item['id']);
		} catch (Exception $ex) {
			$this->assign("err", $ex->getMessage());
			$this->display();
		}
	}
	
	public function _before_withdraw() {
		$this->permission_verifying();
	}
	
	public function withdraw() {
		
		$item_id = $_GET["id"];
		$people_id = $this->uid;
		
		$item =  M("Item")->where("id = {$item_id}")->find();
		
		if($item["state"] == 100) {
			$map["item_id"] = $item_id;
			$map["people_id"] = $people_id;
			
			M("ItemPeople")->where($map)->delete();
			
			$item_data["apply_num"] = $item["apply_num"] - 1;
			M("Item")->where("id={$item_id}")->data($item_data)->save();
			
			redirect(C("TMPL_PARSE_STRING.__SITE__")."/m#".$item_id);
		} else {
			redirect($this->site_url."/m/notice/?key=item_bad_withdraw&state=".$item['state']);
		}
	}
		
}