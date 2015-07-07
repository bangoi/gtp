<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends BaseController {
	
    public function index() {
    	
		$size = 25;
		$cache_seconds = 60;
		
		$map["state"] = 100;
		$order = "add_time desc";
		
		//$vedioes = M("Vedio")->where($map)->order($order)->limit($size)->cache('index_vedioes', $cache_seconds)->select();
		$gtps = M("Gtp")->where($map)->order($order)->limit($size)->cache('index_gtps', $cache_seconds)->select();
		//$this->assign("vedio_list", $vedioes);
		$this->assign("gtp_list", $gtps);
		
		$this->assign("channel", "home");
		//$this->display();
		$this->render();
    }
	
	public function search() {
		
		$k = trim(I("get.k"));
		$this->assign('k', $k);
		
		$vedio_map["state"] = 100;
		$vedio_map["title"] = array("like", "%$k%");
		
		
		$gtp_map["state"] = 100;
		$gtp_map["song_title|artist_name"] = array('like', "%{$k}%");
		$order = "add_time desc";
		
		$vedioes = M("Vedio")->where($vedio_map)->order($order)->limit($size)->select();
		$gtps = M("Gtp")->where($gtp_map)->order($order)->limit($size)->select();
		
		$this->assign("vedio_list", $vedioes);
		$this->assign("gtp_list", $gtps);
		
		$this->assign("channel", "home");
		$this->display("index");
	}
	
}