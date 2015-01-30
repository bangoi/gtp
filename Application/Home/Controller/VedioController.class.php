<?php

namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;
use Org\Util\VideoUrlParser;

class VedioController extends BaseController {
	
	public function index() {
		
		$p = I("get.p") ? I("get.p") : 1;
		$size = 20;
		
		$order = "add_time desc";
		
		$k = urldecode(I("get.k"));
		$artist_name = urldecode(I("get.artist_name"));
		
		$map["state"] = 100;
		
		if(!empty($k)) {
			
			$map["title"] = array('like', "%{$k}%");
			
			$this->assign('k', $k);
			$this->assign("title", $k."吉他视频"." 第{$p}页");
		} else if(!empty($artist_name)) {
			
			$map["artist_name"] = array('like', "%{$artist_name}%");
			
			$this->assign('artist_name', $artist_name);
			$this->assign("title", $artist_name."吉他视频"." 第{$p}页");
		} else {
			$this->assign("title", "吉他视频"." 第{$p}页");
		}
		
		$vedio_list = M("Vedio")->where($map)->order($order)->page($p.",{$size}")->select();
		$count = M("Vedio")->where($map)->count();
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		
		$this->assign('vedio_list', $vedio_list);
		$this->assign('page', $page);
		$this->assign("channel", "vedio");
		$this->display();
	}
	
	public function search() {
		
		$p = I("get.p") ? I("get.p") : 1;
		$size = 20;
		
		$order = "add_time desc";
		
		$k = urldecode(I("get.k"));
		$artist_name = urldecode(I("get.artist_name"));
		
		$map["state"] = 100;
		
		if(!empty($k)) {
			
			$map["title"] = array('like', "%{$k}%");
			
			$this->assign('k', $k);
			$this->assign("title", $k."吉他视频"." 第{$p}页");
		}
		
		$vedio_list = M("Vedio")->where($map)->order($order)->page($p.",{$size}")->select();
		$count = M("Vedio")->where($map)->count();
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		
		$this->assign('vedio_list', $vedio_list);
		$this->assign('page', $page);
		$this->assign("channel", "vedio");
		$this->display("index");
	}

	public function details() {
		
		$id = I("get.id");
		
		$map["id"] = $id;
		$map["state"] = 100;
		
		$vedio = M("Vedio")->where($map)->find();
		$user = M("User")->where("id={$vedio['user_id']}")->find();
		//dump(M("Vedio")->getLastSql());
		M("Vedio")->where("id={$id}")->setInc('view_num');
		//M("Vedio")->where("id={$id}")->setLazyInc("view_num", 1, 60);

		$gtp_map["artist_name"] = $vedio["artist_name"];
		$gtp_map["song_title"] = $vedio["song_title"];
		$gtp_map["state"] = 100;
		 		
		$gtp_list = M("Gtp")->where($gtp_map)->order('download_num DESC')->limit(10)->select();
		
		$video_map["id"] = array('neq', $id);
		$video_map["artist_name"] = $vedio["artist_name"];
		$video_map["state"] = 100;
				
		$vedio_list = M("VedioView")	->where($video_map)->order('view_num DESC')->limit(10)->select();
				
		$this->assign("vedio", $vedio);
		$this->assign("user", $user);
		$this->assign("gtps", $gtp_list);
		$this->assign("vedioes", $vedioes);
		
		$this->assign("title", $vedio['title']);
		$this->assign("page_title", $vedio['title']);
		$this->assign("description", $vedio['title'].",".$vedio['song_title'].",".$vedio['artist_name'].",".'吉他视频');
		$this->assign("can_edit", $this->can_edit("vedio", $vedio['id']));
		$this->assign("channel", "vedio");
		$this->display();
	}
	
	public function _before_add() {
		if($this->logined != true) {
			redirect($this->site_url."/user/login/?action=/vedio/add");
		}
	}
	
	public function add(){
		
		if(IS_POST) {
				
			try {
				
				$title = I("post.title");
				$thumb_value = I("post.thumb_value");
				$code = I("post.code");
				$artist_name = I("post.artist_name");
				$song_title = I("post.song_title");
				
				if(empty($title))
					throw new Exception("必须输入视频标题");
				
				if(empty($thumb_value))
					throw new Exception("必须输入截图地址");
					
				if(empty($code))
					throw new Exception("必须输入视频swf");
					
				if(empty($artist_name))
					throw new Exception("必须输入音乐人");
					
				if(empty($song_title))
					throw new Exception("必须输入歌曲名称");
				
				$vedio = D("Vedio");
		        if($vedio->create()) {
		        	
					$vedio->user_id = $this->uid;
					
					$vedio->title = trim($title);
					$vedio->thumb = trim($thumb_value);
					$vedio->code = trim($code);
					$vedio->song_title = trim($song_title);
					$vedio->artist_name = trim($artist_name);
					$vedio->tags = trim(I("post.tags"));
					$vedio->description = trim(I("post.description"));
						
					$id = $vedio->add();
					$this->redirect('/vedio/'.$id);
			    }
				
			}catch(Exception $ex) {
				
				$this->assign("vedio_url", I("post.vedio_url"));
				$this->assign("thumb_value", I("post.thumb_value"));
						
				$this->assign("vedio_title", I("post.title"));
				$this->assign("thumb", I("post.thumb"));
				$this->assign("code", I("post.code"));
				$this->assign("artist_name", I("post.artist_name"));
				$this->assign("song_title", I("post.song_title"));
				$this->assign("tags", I("post.tags"));
				$this->assign("description", I("post.description"));
				
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			$this->assign("title", '发布吉他视频');
			$this->assign("page_title", '发布吉他视频');
			$this->assign("channel", "vedio");
			$this->display();
		}
	}
	
	public function addVedio(){
		$vedioUrl = $_REQUEST['vedioUrl'];
		//$vedioUrl = 'http://v.youku.com/v_show/id_XNTM0MjM1NDM2.html';
		$result['data'] = VideoUrlParser::parse($vedioUrl, false);
		echo json_encode($result);
	}
	
	public function _before_edit() {
		
		$id = I("get.id");
		$url = $this->site_url."/user/login/?action=/vedio/edit/".$id;
		
		if($this->logined != true)
			$this->redirect($url);
		
		$map["state"] = 100;
		$map["id"] = $id;
		$vedio = M('Vedio')->where($map)->find();
		
		if($this->uid != $vedio["user_id"])
			$this->redirect($url);
	}
	
	public function edit() {
		$vedio_id = $_GET["_URL_"][2];
		
		if(IS_POST) {
			
			$title = I("post.title");
			$code = I("post.code");
			$artist_name = I("post.artist_name");
			$song_title = I("post.song_title");
				
			if(empty($title)) E("必须输入视频标题");
			if(empty($code)) E("必须输入视频swf");
			if(empty($artist_name)) E("必须输入音乐人");
			if(empty($song_title)) E("必须输入歌曲名称");
			
			try {
				
				$data["title"] = trim($title);
				$data["code"] = trim($code);
				$data["artist_name"] = trim($artist_name);
				$data["song_title"] = trim($song_title);
				$data['thumb'] = trim(I("post.thumb_value"));				
				$data['tags'] = trim(I("post.tags"));
				$data['description'] = trim(I("post.description"));
				$id = I("post.id");
		
				M("Vedio")->where("id={$id}")->data($data)->save();
				$this->redirect('/vedio/'.$id);
				
			}catch(Exception $ex){
				
				$this->assign("vedio_title", I("post.title"));
				$this->assign("thumb", I("post.thumb"));
				$this->assign("code", I("post.code"));
				$this->assign("artist_name", I("post.artist_name"));
				$this->assign("song_title", I("post.song_title"));
				$this->assign("tags", I("post.tags"));
				$this->assign("description", I("post.description"));
				
				$this->assign("err", $ex->getMessage());
				$this->display();
			}
		} else {
			
			$map["state"] = 100;
			$map["id"] = I("get.id");
			$vedio = M('Vedio')->where($map)->find();
		
			$this->assign('vedio', $vedio);
			$this->assign("title", '编辑吉他视频 '.$vedio['title']);
			$this->assign("page_title", '编辑吉他视频 '.$vedio['title']);
			$this->assign("channel", "vedio");
			$this->display();
		}
	}

}