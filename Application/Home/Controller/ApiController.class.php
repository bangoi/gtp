<?php

namespace Home\Controller;
use Think\Controller;
use Org\Util\JsonResult;
use Org\Util\Encode;
use Think\Upload;
use Think\Image;
use Org\Util\PinYin;

header('Content-Type: text/json; charset=utf-8');

class ApiController extends Controller {
	
    public function index() {
    	$method = I("get.method");
        if(!empty($method)) {
        	$this->http_request($method);
        } else {
        	echo JsonResult::error_msg("no such function");
        }
    }
	
	private function get_now() {
		return date("Y-m-d H:i:s");
	}
	
	private function http_request($method) {
		switch ($method) {
			case "gtp.add": 
				{
					echo $this->add_gtp();
				}
				break;
			default:
				break;
		}
	}
	
	private function add_gtp() {
		
		try {
			$artist_name = I("post.artist_name");
			$song_title = I("post.song_title");

			if(empty($artist_name)) E("必须输入音乐人");
			if(empty($song_title)) E("必须输入音乐名称");
			if(empty($_FILES["file_name"])) E("必须上传Guitar Pro文件");
			if($_FILES["file_name"]['size'] <= 0) E("必须上传正确的Guitar Pro附件");
			
			$map["artist_name"] = trim($artist_name);
			$map["song_title"] = trim($song_title);
			$map["file_size"] = $_FILES["file_name"]['size'];
			
			$count = M("Gtp")->where($map)->count();
			if($count != 0)
				return JsonResult::error_msg("existed.");
			
			$gtp = D("Gtp");
		    if($gtp->create()) {
		        	
		        $gtp->user_id = I("post.user_id");
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
						E($upload->getError());
					} else {
						$gtp->file_name = substr($info['savepath'].$info['savename'], 2);
						$gtp->file_size = $_FILES["file_name"]['size'];
					}
				} else {
					E("必须上传Guitar Pro附件");
				}
					
				$id = $gtp->add($data);
				return JsonResult::data($id);
		    } else {
		        E($gtp->getError());
		    }
			
		} catch (Exception $ex) {
			return JsonResult::error_msg($ex->getMessage());
		}
		
	}
	
}