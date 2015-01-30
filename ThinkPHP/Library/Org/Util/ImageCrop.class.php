<?php

    namespace Org\Util;
	use Think\Exception;

	class ImageCrop {
		
		private $source_file;
		private $target_file;
		private $ext;
		private $x;
		private $y;
		private $x1;
		private $y1;
		private $width = 50;
		private $height = 50;
		private $jpeg_quality = 90;
		
		public function __construct() {
			
		}
		
		public function initialize($source_file, $target_file, $x, $y, $x1, $y1) {
			if (file_exists ($source_file)) {
				$this->source_file = $source_file;
				$this->target_file = $target_file;
				$pathinfo = pathinfo ($source_file);
				$this->ext = $pathinfo['extension'];
			} else {
				E('the file is not exists!');
			}
			$this->x = $x;
			$this->y = $y;
			$this->x1 = $x1;
			$this->y1 = $y1;
		}
		
		public function generate() {
			switch ($this->ext) {
				case 'jpg' :
					return $this->generateJpg();
					break;
				case 'png' :
					return $this->generatePng();
					break;
				case 'gif' :
					return $this->generateGif();
					break;
				default :
					return false;
			}
		}
		
		private function getFileName() {
			/*
			$pathinfo = pathinfo($this->filename);
			$fileinfo = explode('.', $pathinfo['basename']);
			$filename = 's'.$fileinfo[0] . $this->ext;
			return 'uploadfiles/'.$filename;
			 * */
			return $this->source_file;
		}
		
		private function generateJpg() {
			$img_r = imagecreatefromjpeg($this->source_file);
			$dst_r = ImageCreateTrueColor($this->width, $this->height);
			
			imagecopyresampled ($dst_r, $img_r, 0, 0, $this->x, $this->y, $this->width, $this->height, $this->x1, $this->y1);
			imagejpeg($dst_r, $this->target_file, $this->jpeg_quality);
			return $this->target_file;
		}
		
		private function generateGif() {
			$img_r = imagecreatefromgif($this->source_file);
			$dst_r = ImageCreateTrueColor($this->width, $this->height);
			
			imagecopyresampled ($dst_r, $img_r, 0, 0, $this->x, $this->y, $this->width, $this->height, $this->x1, $this->y1);
			imagegif($dst_r, $this->target_file);
			return $this->target_file;
		}
	
		private function generatePng() {
			$img_r = imagecreatefrompng($this->source_file);
			$dst_r = ImageCreateTrueColor($this->width, $this->height);
			
			imagecopyresampled ($dst_r, $img_r, 0, 0, $this->x, $this->y, $this->width, $this->height, $this->x1, $this->y1);
			imagepng($dst_r, $this->target_file);
			return $this->target_file;
		}
		
	}
?>