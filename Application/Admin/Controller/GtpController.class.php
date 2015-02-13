<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;

class GtpController extends BaseController {
	
    public function index() {
    	
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		$map["state"] = I("get.state") ? I("get.state") : 100;
		
		$items = D("GtpView")->where($map)->order('add_time desc')->page($p.",{$size}")->select();
		$count = D("GtpView")->where($map)->count();
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		
		$this->assign('items', $items);
		$this->assign('page', $page);
		$this->assign("channel", "gtp");
		
        $this->display();
    }
	
}