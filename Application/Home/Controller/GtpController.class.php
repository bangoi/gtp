<?php

namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Page;
use Think\Upload;
use Org\Util\PinYin;

class GtpController extends BaseController
{
	public function index() {
		
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		$k = trim(I("get.k"));
		$artist_name = trim(urldecode(I("get.artist_name")));
		$author = trim(urldecode(I("get.author")));
		$start = trim(I("get.start"));
		
		$map["state"] = 100;
		
		if(!empty($start) && $start == "number")	{
			
			$where = "state = 100 AND letters REGEXP '^[0-9]'";
				
			$gtp_list = M("Gtp")->where($where)->order('download_num desc')->page($p.",{$size}")->select();
			$count = M("Gtp")->where($where)->count();
			
			$this->assign("title", $start." GTP吉他谱"." 第{$p}页");
			
		} else {
			
			if(!empty($start)) {
				
				$map["letters"] = array('like', "{$start}%");
				
				$this->assign('start', $start);
				$this->assign("title", $start." GTP吉他谱"." 第{$p}页");
			}else if(!empty($k)) {
				
				$map["song_title|artist_name"] = array('like', "%{$k}%");
				
				$this->assign('k', $k);
				$this->assign("title", $k." GTP吉他谱"." 第{$p}页");
			} else if(!empty($artist_name)) {
				
				$map["artist_name"] = array('like', "%{$artist_name}%");
				
				$this->assign('artist_name', $artist_name);
				$this->assign("title", $artist_name." GTP吉他谱"." 第{$p}页");
			} else if(!empty($author)) {
				
				$map["author"] = array('like', "%{$author}%");
				
				$this->assign('author', $author);
				$this->assign("title", $author."制作 GTP吉他谱"." 第{$p}页");
			} else {
				$this->assign("title", "GTP吉他谱"." 第{$p}页");
			}
			
			$gtp_list = M("Gtp")->where($map)->order('download_num desc')->page($p.",{$size}")->select();
			$count = M("Gtp")->where($map)->count();
		}
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		//dump($gtp_list);
		
		$this->assign('gtp_list', $gtp_list);
		$this->assign('page', $page);
		$this->display();
    }

	public function search() {
		
		$p = I("get.p") ? I("get.p") : 1;
		$size = 25;
		
		$k = trim(I("get.k"));
		$map["song_title|artist_name"] = array('like', "%{$k}%");
		
		$gtp_list = M("Gtp")->where($map)->order('download_num desc')->page($p.",{$size}")->select();
		$count = M("Gtp")->where($map)->count();
		
		$Page = new Page($count, $size);
		$page = $Page->show();
		
		$this->assign('k', $k);
		$this->assign("title", $k."GTP吉他谱"." 第{$p}页");
		$this->assign('gtp_list', $gtp_list);
		$this->assign('page', $page);
		
		$this->display("index");
	}

	public function details() {
		
		$id = I("get.id");
		$size = 10;
		
		$map["state"] = 100;
		$map["id"] = $id;
		
		$gtp = M("Gtp")->where($map)->find();
		$user = M("User")->where("id={$gtp['user_id']}")->find();
		
		$song_title_gtps_map["id"] = array('neq', $id);
		$song_title_gtps_map["state"] = 100;
		$song_title_gtps_map["artist_name"] = $gtp['artist_name'];
		$song_title_gtps_map["song_title"] = $gtp['song_title'];
		
		$song_title_gtps = M("Gtp")->where($song_title_gtps_map)
			->order('download_num desc')->limit($size)->select();
			
		$artist_name_gtps_map["id"] = array('neq', $id);
		$artist_name_gtps_map["state"] = 100;
		$artist_name_gtps_map["artist_name"] = $gtp['artist_name'];
			
		$artist_name_gtps = M("Gtp")->where($artist_name_gtps_map)
			->order('download_num desc')->limit($size)->select();
		
		$vedio_map["state"] = 100;
		$vedio_map["artist_name"] = $gtp["artist_name"];
		$vedio_map["song_title"] = $gtp["song_title"];
		
		$vedioes = M("Vedio")->where($vedio_map)->order('view_num desc')->limit($size)->select();
		//dump($vedioes);
		$this->assign("gtp", $gtp);
		$this->assign("user", $user);
		$this->assign("song_title_gtps", $song_title_gtps);
		$this->assign("artist_name_gtps", $artist_name_gtps);
		$this->assign("vedioes", $vedioes);
		$this->assign("title", $gtp['artist_name'].' '.$gtp['song_title'].' GTP吉他谱下载');
		$this->assign("page_title", $gtp['artist_name'].' '.$gtp['song_title'].' GTP吉他谱下载');
		$this->assign("description", $gtp['title']. ",".$gtp['song_title'].",".$gtp['artist_name'].",".'吉他谱,Guitar-Pro吉他谱');
		$this->assign("can_edit", $this->can_edit("gtp", $gtp['id']));
		
		$this->display();
	}
	
	public function download() {
		
		$id = I("get.id");
		
		$map["state"] = 100;
		$map["id"] = $id;
		
		M("Gtp")->where($map)->setInc('download_num');
		$gtp = M("Gtp")->where($map)->find();
	
		$download_file_name = $this->get_download_file_name($gtp);
		
		$this->render_gtp($download_file_name, $gtp['file_name']);
	}
	
	private function get_download_file_name($gtp) {
		
		$extend = substr($gtp['file_name'], (strrpos($gtp['file_name'], '.') + 1 ));    
		$extend = '.'.strtolower($extend);
		$file_path = $_SERVER['DOCUMENT_ROOT']."gtp/";

		return $gtp['artist_name']."-".$gtp['song_title'].$extend;
	}

	public function _before_add() {
		if($this->logined != true)
			redirect($this->site_url."/user/login/?page=gtp/add");
	}
	
	public function add() {
		
		if(IS_POST) {
			try {
				
				$artist_name = I("post.artist_name");
				$song_title = I("post.song_title");

				if(empty($artist_name)) E("必须输入音乐人");
				if(empty($song_title)) E("必须输入音乐名称");
				if(empty($_FILES["file_name"])) E("必须上传Guitar Pro文件");
				if($_FILES["file_name"]['size'] <= 0) E("必须上传正确的Guitar Pro附件");
				
				$gtp = D("Gtp");
		        if($gtp->create()) {
		        	
		        	$gtp->user_id = $this->uid;
					$gtp->artist_name = trim($artist_name);
					$gtp->song_title = trim($song_title);
					
					$gtp->author = trim(I("post.author"));
					$gtp->source = trim(I("post.source"));
					
					// pinyin
					$pinyin = new PinYin();
					$gtp->letters = $pinyin->pinyin($gtp->song_title);
					
					if(!empty($_FILES["file_name"]) && $_FILES["file_name"]['size'] > 0) {
						
						$upload = new Upload();
						$upload->maxSize = 3145728;
						$upload->saveName = 'time';
						$upload->exts = array('gp3', 'gp4', 'gp5', 'gp6', 'gpx');
						$upload->rootPath = './';
						$upload->savePath = './upload/gtp/';
						
						$info = $upload->uploadOne($_FILES['file_name']);
						if(!$info) {
							throw new Exception($upload->getError());
						} else {
							$gtp->file_name = substr($info['savepath'].$info['savename'], 2);
							$gtp->file_size = $_FILES["file_name"]['size'];
						}
					} else {
						E("必须上传Guitar Pro附件");
					}
					
					$id = $gtp->add($data);
					$this->redirect('/gtp/'.$id);
		        } else {
		        	throw new Exception($gtp->getError());
		        }
			} catch (Exception $ex) {

				$this->assign("artist_name", I("post.artist_name"));
				$this->assign("song_title", I("post.song_title"));
				
	    		$this->assign("err", $ex->getMessage());
				$this->display();
	    	}
		} else {
			$id = I("get.id");
			$artist_name = I("get.artist_name");
			
			if(!empty($id)) {
				$map["state"] = 100;
				$map["id"] = $id;
				
				$gtp = M("Gtp")->where($map)->find();
				
				$this->assign("song_title", $gtp['song_title']);
				$this->assign("artist_name", $gtp['artist_name']);	
			} else if (!empty($artist_name)) {
				$this->assign("artist_name", $artist_name);	
			}
				
			$this->assign("title", '上传吉他谱');
			$this->assign("page_title", '上传吉他谱');
			$this->display();
		}
		
	}

	public function _before_edit() {
		
		$id = I("get.id");
		$url = $this->site_url."/user/login/?action=/gtp/edit/".$id;
		
		if($this->role != "admin") {
			if($this->logined != true)
				redirect($url);
			
			//$map["state"] = 100;
			//$map["id"] = $id;
			//$gtp = M('Gtp')->where($map)->find();
		}
	}

	public function edit() {
		
		if(IS_POST) {
			try
			{
				$artist_name = I("post.artist_name");
				$song_title = I("post.song_title");
				
				if(empty($artist_name)) E("必须输入音乐人");
				if(empty($song_title)) E("必须输入音乐名称");
				if(empty($_FILES["file_name"])) E("必须上传Guitar Pro附件");
				
				if($_FILES["file_name"]['size'] <= 0) E("必须上传正确的Guitar Pro附件");
				
				$data['artist_name'] = trim($artist_name);
				$data['song_title'] = trim($song_title);
				$data['author'] = trim(I("post.author"));
				$data['source'] = trim(I("post.source"));
				
				$pinyin = new PinYin();
				$data['letters'] = $pinyin->pinyin(trim($song_title));
				
				$id = $_POST['id'];
				
				if(!empty($_FILES["file_name"]) && $_FILES["file_name"]['size'] > 0) {
					
					$upload = new Upload();
					$upload->maxSize = 3145728;
					$upload->allowExts = array('gtp', 'gp3', 'gp4', 'gp5', 'gp6', 'gpx');
					
					$gtp = M("Gtp")->where("id={$id}")->find();
					$arr = explode(".", $gtp['file_name']);
					$upload->saveRule = $arr[0];
					$upload->rootPath = './';
					$upload->uploadReplace = true;
					$upload->savePath =  './upload/gtp/';
					
					$info = $upload->uploadOne($_FILES['file_name']);
					if(!$info) {
						throw new Exception($upload->getError());
					}else{
						$data['file_name'] = $info['savepath'].$info['savename'];
						$gtp = M("Gtp")->find($id);
						unlink($gtp["file_name"]);
			 		}
				}
				
				M("Gtp")->where("id={$id}")->data($data)->save();
				$this->redirect('/gtp/'.$id);
			}
			catch(Exception $ex) {
				
				$gtp = M("Gtp")->find(I("post.id"));
				$this->assign("gtp", $gtp);
				
	    		$this->assign("err", $ex->getMessage());
				$this->display();
	    	}
		} else  {
			
			$id = I("get.id");
			$map["id"] = $id;
			$map["state"] = 100;
			$gtp = M("Gtp")->where($map)->find();
		
			$this->assign("gtp_id", $id);
			$this->assign("gtp", $gtp);
			$this->assign("title", '编辑吉他谱');
			$this->assign("page_title", '编辑吉他谱');
			$this->display();
		}
	}
	
}