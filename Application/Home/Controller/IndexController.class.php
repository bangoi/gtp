<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends BaseController {
	
    public function index() {
    	
		$size = 25;
		
		$vedioes = M('VedioView')->where("v.status = 100")->order('add_time DESC')->limit($size)->select();
		$gtps = M('GtpView')->where("g.status = 100")->order('add_time DESC')->limit($size)->select();
			
		$this->assign("vedioes", $vedioes);
		$this->assign("gtps", $gtps);
		
		$this->assign("channel", "home");
		$this->display();
		
    }
}