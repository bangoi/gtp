<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;

class VedioController extends BaseController {
	
    public function index() {
    	
		$p = I("get.p") ? I("get.p") : 1;
		$size = 30;
    	
		$items = M("Vedio")->where($map)->order($order)->page($p.",{$size}")->select();
		$count = M("Vedio")->where($map)->count();
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		
		$this->assign('items', $items);
		$this->assign('page', $page);
		
        $this->display();
    }
	
}