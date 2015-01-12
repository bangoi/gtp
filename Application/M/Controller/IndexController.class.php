<?php

namespace M\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends BaseController {
	
	public function _before_index() {
		//$this->permission_verifying();
	}
	
    public function index() {
    	
		$p = $_GET["p"] ? $_GET["p"] : 1;
		$size = 10;
		$p == 1 ? $size = 10 : $size = 10;
		
		$map['state'] = array('in','100, 101');
		
		$items = M("Item")->where($map)->order('add_time desc')->page($p.",{$size}")->select();
		$count = M('Item')->where($map)->count();
		
		$Page = new \Think\Page($count, $size);
		$page = $Page->show();
		
		$this->assign('page', $page);
		$this->assign('items', $items);
		
        $this->display();
    }
	
	public function _before_my_items() {
		$this->permission_verifying();
	}
	
	public function my_items() {
		$p = $_GET["p"] ? $_GET["p"] : 1;
		$size = 10;
		$p == 1 ? $size = 10 : $size = 10;
		
		$map["Item_People.people_id"] = $this->uid;
		
		$items = M("Item")
			->join(" Item_People on Item.id = Item_People.item_id ")
			->field(" Item.id as id, Item.item_code, Item.source_type, Item.tel, Item.custom_name, Item.custom_tel, Item.price, Item.address, Item.content, Item.apply_num, Item.release_num, Item.people_id, Item.guarantee_period, Item.guarantee_content, Item.add_time, Item.state , Item_People.people_id")
			->where($map)->order("add_time desc")->page($p.", {$size}")->select();
			
		$count = M('Item')
			->join(" People_Item on Item.id = People_Item.item_id ")
			->field(" Item.id as id, Item.item_code, Item.source_type, Item.tel, Item.custom_name, Item.custom_tel, Item.price, Item.address, Item.content, Item.remark, Item.apply_num, Item.release_num, Item.people_id, Item.guarantee_period, Item.guarantee_content, Item.add_time, Item.state , ItemPeople.people_id")
			->where($map)->count();
			
		$Page = new \Think\Page($count, $size);
		$page = $Page->show();
		
		
		$this->assign('page', $page);
		$this->assign('items', $items);
		
        $this->display();
	}
	
	public function load() {
		
		$p = $_GET["p"] ? $_GET["p"] : 1;
		$size = 10;
		$p == 1 ? $size = 10 : $size = 10;
		
		$people_id = $_GET["uid"];
		
		$map['state'] = array('in','100, 101');
		
		$items = M("Item")->where($map)->order('add_time desc')->page($p.",{$size}")->select();
		
		$ret_items = array();
		foreach ($items as $key => $value) {
			$item_map["item_id"] = $value["id"];
			$item_map["people_id"] = $people_id;
			$count = M("ItemPeople")->where($item_map)->count();
			if($count > 0)
				$value["applied"] = true;
			else
				$value["applied"] = false;
			
			array_push($ret_items, $value);
		}
		
		$this->assign("items", $ret_items);
		$this->assign("item_count", count($ret_items));
		$this->display('Public:list');
		//echo json_encode($ret_items);
	}
	
	public function load_my_items() {
		
		$p = $_GET["p"] ? $_GET["p"] : 1;
		$size = 10;
		$p == 1 ? $size = 10 : $size = 10;
		
		$people_id = $_GET["uid"];
		
		$map["Item_People.people_id"] = $this->uid;
		
		$items = M("Item")
			->join(" Item_People on Item.id = Item_People.item_id ")
			->field(" Item.id as id, Item.item_code, Item.source_type, Item.tel, Item.custom_name, Item.custom_tel, Item.price, Item.address, Item.content, Item.remark, Item.apply_num, Item.release_num, Item.people_id, Item.guarantee_period, Item.guarantee_content, Item.add_time, Item.state , Item_People.people_id")
			->where($map)->order("add_time desc")->page($p.", {$size}")->select();
			
			//dump(M("Item")->_sql());
		
		$ret_items = array();
		foreach ($items as $key => $value) {
			$item_map["item_id"] = $value["id"];
			$item_map["people_id"] = $people_id;
			$count = M("ItemPeople")->where($item_map)->count();
			if($count > 0)
				$value["applied"] = true;
			else
				$value["applied"] = false;
			
			array_push($ret_items, $value);
		}
		
		$this->assign("items", $ret_items);
		$this->assign("item_count", count($ret_items));
		$this->display('Public:list');
		//echo json_encode($ret_items);
	}
	
}