<?php

namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Upload;
use Org\Util\PinYin;

class GtpController extends BaseController
{
	public function index()
	{
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		if(!empty(I("get.k")))
		{
			$k = urldecode(I("get.k"));
			
			$map["state"] = 100;
			$map["song_title"] = array('like', "%{$k}%");
			
			$gtp_list = M("GtpView")->where($map)->order('download_num desc')->page($p.",{$size}")->select();
			$count = M("GtpView")->where($map)->count();
			
			$this->assign('k', $k);
			$this->assign("title", $k."吉他谱"." 第{$p}页");
			$this->assign("page_title", $k."吉他谱"." 第{$p}页");
		}
		else if(!empty(I("get.artist_name")))
		{
			$artist_name = urldecode(I("get.artist_name"));
			
			$map["state"] = 100;
			$map["artist_name"] = array('like', "%{$artist_name}%");
			
			$gtp_list = M("GtpView")->where($map)->order('download_num desc')->page($p.",{$size}")->select();
			$count = M("GtpView")->where($map)->count();
			
			$this->assign('artist_name', $this->_get("artist_name"));
			$this->assign("title", $artist_name."吉他谱"." 第{$p}页");
			$this->assign("page_title", $artist_name."吉他谱"." 第{$p}页");
		}
		else if(!empty(I("get.author")))
		{
			$author = urldecode(I("get.author"));
			
			$map["state"] = 100;
			$map["author"] = array('like', "%{$author}%");
			
			$gtp_list = M("GtpView")->where($map)->order('download_num desc')->page($p.",{$size}")->select();
			$count = M("GtpView")->where($map)->count();
			
			$this->assign('author', $author);
			$this->assign("title", $author."制作 吉他谱"." 第{$p}页");
			$this->assign("page_title", $author."制作 吉他谱"." 第{$p}页");
		}
		else if(!empty(I("get.start")))
		{
			$start = I("get.start");
			
			$map["state"] = 100;
			
			if($start == "number") {
				$where = "state = 100 AND letters REGEXP '^[0-9]'";
				
				$gtp_list = M("GtpView")->where($where)->order('download_num desc')->page($p.",{$size}")->select();
				$count = M("GtpView")->where($where)->count();
			} else {
				$map["letters"] = array('like', "{$start}%");
				
				$gtp_list = M("GtpView")->where($map)->order('download_num desc')->page($p.",{$size}")->select();
				$count = M("GtpView")->where($map)->count();
			}
			
			$this->assign("title", $start." 吉他谱"." 第{$p}页");
			$this->assign("page_title", $start." 吉他谱"." 第{$p}页");
		}
		else
		{
			$map["state"] = 100;
			
			$gtp_list = M("GtpView")->where($map)->order('download_num desc')->page($p.",{$size}")->select();
			$count = M("GtpView")->where($map)->count();
			
			$this->assign("title", "吉他谱"." 第{$p}页");
			$this->assign("page_title", "吉他谱"." 第{$p}页");
		}
		//dump($list);

		$Page = new Page($count, $size);
		if(!empty(I("get.k")))
			$Page->parameter .= "$k=".urlencode(I("get.k"))."&";
		
		//dump($Page);
		$page = $Page->show();
		
		$this->assign('gtp_list', $gtp_list);
		$this->assign('page', $page);
		$this->assign("channel", "gtp");
		
		$this->display();
    }

	public function details(){
		
		$id = I("get.id");
		$size = 10;
		
		$map["state"] = 100;
		$map["id"] = $id;
		
		$gtp = M("GtpView")->where($map)->find();
		
		$song_title_gtps_map["id"] = array('neq', $id);
		$song_title_gtps_map["state"] = 100;
		$song_title_gtps_map["artist_name"] = $gtp['artist_name'];
		$song_title_gtps_map["song_title"] = $gtp['song_title'];
		
		$song_title_gtps = M("GtpView")->where($song_title_gtps_map)
			->order('download_num desc')->limit($size)->select();
			
		$artist_name_gtps_map["id"] = array('neq', $id);
		$artist_name_gtps_map["state"] = 100;
		$artist_name_gtps_map["artist_name"] = $gtp['artist_name'];
			
		$artist_name_gtps = M("GtpView")->where($artist_name_gtps_map)
			->order('download_num desc')->limit($size)->select();
		
		$vedio_map["state"] = 100;
		$vedio_map["artist_name"] = $gtp["artist_name"];
		$vedio_map["song_title"] = $gtp["song_title"];
		
		$vedioes = M("VedioView")->where($vedio_map)->order('view_num desc')->limit($size)->select();
		
		$this->assign("gtp", $gtp);
		$this->assign("song_title_gtps", $song_title_gtps);
		$this->assign("artist_name_gtps", $artist_name_gtps);
		$this->assign("vedioes", $vedioes);
		$this->assign("title", $gtp['artist_name'].' '.$gtp['song_title'].' 吉他谱下载');
		$this->assign("page_title", $gtp['artist_name'].' '.$gtp['song_title'].' 吉他谱下载');
		$this->assign("description", $gtp['title']. ",".$gtp['song_title'].",".$gtp['artist_name'].",".'吉他谱,Guitar-Pro吉他谱');
		
		$this->assign("channel", "gtp");
		
		$this->display();
	}
	
	public function download() {
		
		$id = I("get.id");
		
		$gtp = M('Gtp');
		
		$map["state"] = 100;
		$map["id"] = $id;
		
		$gtp->where($map)->setInc('download_num');
		$gtp = $gtp->where($map)->find();
	
		$extend = substr($gtp->file_name, (strrpos($gtp->file_name, '.') + 1 ));    
		$extend = strtolower($extend);
		
		$file_path = $_SERVER['DOCUMENT_ROOT'].'/upload/gtp/';

		//dump($file_path);
		
		$download_file_name = $gtp->artist_name."-".$gtp->song_title.$extend;
		
		$ua = $_SERVER["HTTP_USER_AGENT"];
		$encoded_filename = urlencode($download_file_name);
		$encoded_filename = str_replace("+", "%20", $encoded_filename);

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Component: must-revalidate, post-check=0, pre-check=0");
		header('Content-Type: application/octet-stream');

		if (preg_match("/MSIE/", $ua))	
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
		else if (preg_match("/Firefox/", $ua))	
			header('Content-Disposition: attachment; filename*="utf8\'\''.$download_file_name.'"');
		else	
			header('Content-Disposition: attachment; filename="'.$download_file_name. '"');
		
		readfile($file_path.$gtp->file_name);
	 }

	public function _before_add(){
		if($logined != true) {
			$this->redirect("/user/login/?page=gtp/add");
		}
	}
	
	public function add() {
		
		if(IS_POST) {
			try {
				
				if(empty(I("post.artst_name")))
					throw  new Exception("必须输入音乐人");
				
				if(empty(I("post.song_title")))
					throw new Exception("必须输入音乐名称");
				
				$gtp = D("Gtp");
		        if($gtp->create()) {
		        	
		        	$gtp->user_id = $this->uid;
					$gtp->artist_name = trim(I("post.artist_name"));
					$gtp->song_title = trim(I("post.song_title"));
					
					$gtp->author = trim(I("post.author"));
					$gtp->source = trim(I("post.source"));
					
					// pinyin
					$pinyin = new PinYin();
					$gtp->letters = $pinyin->pinyin($gtp->song_title);
					
					if(!empty($_FILES["file_name"]) && $_FILES["file_name"]['size'] > 0) {
						
						$upload = new Upload();
						
						$upload->maxSize = 3145728;
						$upload->allowExts = array('gp3', 'gp4', 'gp5', 'gp6');
						$upload->saveRule = 'time';
						$upload->savePath =  './upload/gtp/';
						
						if(!$upload->upload()) {
							$this->err($upload->getErrorMsg());
						} else {
							$info = $upload->getUploadFileInfo();
							$gtp->file_name = $info[0]["savename"];
		 				}
					} else {
						throw new Exception("必须上传Guitar Pro附件");
					}
					$id = $gtp->add($data);
					$this->redirect('/gtp/'.$id);
		        } else {
		        	throw new Exception($gtp->getError());
		        }
			} catch (Exception $ex) {

				$this->assign("artist_name", I("post.artst_name"));
				$this->assign("song_title", I("post.song_title"));
				
	    		$this->assign("err", $ex->getMessage());
				$this->display();
	    	}
		} else {
			$id = I("get.id");
			
			$map["state"] = 100;
			$map["id"] = $id;
			
			$gtp = M("Gtp")->where($map)->find();
			
			$this->assign("song_title", $gtp['song_title']);
			$this->assign("artist_name", $gtp['artist_name']);
				
			$this->assign("title", '上传吉他谱');
			$this->assign("page_title", '上传吉他谱');
			$this->assign("channel", "gtp");
			$this->display();
		}
		
	}

	public function _before_edit() {
		
		$id = I("get.id");
		$url = "/user/login/?action=/gtp/edit/".$id;
		
		if($this->logined != true)
			$this->redirect($url);
		
		$map["state"] = 100;
		$map["id"] = $id;
		$gtp = M('Gtp')->where($map)->find();
		
		if($this->uid != $gtp["user_id"])
			$this->redirect($url);
	}

	public function edit() {
		
		if(IS_POST) {
			try
			{
				if(empty(I("post.artist_name")))
					throw new Exception("必须输入音乐人");
				
				if(empty(I("post.song_title")))
					throw new Exception("必须输入音乐名称");
				
				
				$data['artist_name'] = trim(I("post.artist_name"));
				$data['song_title'] = trim(I("post.song_title"));
				$data['author'] = trim(I("post.author"));
				$data['source'] = trim(I("post.source"));
				
				$pinyin = new PinYin();
				$data['letters'] = $pinyin->pinyin(trim(I("post.song_title")));
				
				$id = $_POST['id'];
				
				if(!empty($_FILES["file_name"]) && $_FILES["file_name"]['size'] > 0) {
					
					$upload = new Upload();
					$upload->maxSize = 3145728;
					$upload->allowExts = array('gp3', 'gp4', 'gp5', 'gp6');
					
					$gtp = M("Gtp")->where("id={$id}")->find();
					$arr = explode(".", $gtp['file_name']);
					$upload->saveRule = $arr[0];
					
					$upload->uploadReplace = true;
					$upload->savePath =  './upload/gtp/';
					if(!$upload->upload()) {
						$this->err($upload->getErrorMsg());
					}else{
						$info = $upload->getUploadFileInfo();
						$data['file_name'] = $info[0]["savename"];
		 			}
				}
				
				M("Gtp")->where("id={$id}")->data($data)->save();
				$this->redirect('/gtp/'.$id);
			}
			catch(Exception $ex) {
				
				if(!empty($gtp->artist_name))
					$this->assign("artist_name", $gtp->artist_name);
				
				if(!empty($gtp->song_title))
					$this->assign("song_title", $gtp->song_title);
				
	    		$this->assign("err", $ex->getMessage());
				$this->display();
	    	}
		} else  {
			$gtp = M("Gtp")->where("id={I('get.id')}")->find();
		
			$this->assign("gtp_id", $id);
			$this->assign("gtp", $gtp);
			$this->assign("title", '编辑吉他谱');
			$this->assign("page_title", '编辑吉他谱');
			$this->display();
		}
	}
	
}