<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends BaseController {
	
    public function index() {
    	
		$size = 25;
		
		$map["state"] = 100;
		$order = "add_time desc";
		
		$vedioes = D("VedioView")->where($map)->order($order)->limit($size)->select();
		$gtps = D("GtpView")->where($map)->order($order)->limit($size)->select();
		
		$this->assign("vedio_list", $vedioes);
		$this->assign("gtp_list", $gtps);
		
		$this->assign("channel", "home");
		$this->display();
		
    }
}