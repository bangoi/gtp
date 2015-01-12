<?php

namespace Org\Util;

	class Tudou{
		private $appKey = '02c791b7d0e1fde1';
		private $appSecret = '9c98dcae8e8d520d0aeac9c3e35f1fef';
		private $base_url = 'http://api.tudou.com/v3/gw?';
		private $format = 'json';
		
		private $paramArr;
		
		public function __construct(){
			$this->paramArr = array(
				'appKey' => $this->appKey,
				'format' => $this->format,
			);
		}
		
		static function instance(){   
			static $instance;   
			if (is_null($instance))
				$instance = new Tudou();
			return $instance;   
		}
		
		function createStrParam ($paramArr) { 
			$strParam = ''; 
			foreach ($paramArr as $key => $val) 
			   if ($key != '' && $val !='')
				   $strParam .= $key.'='.urlencode($val).'&';
			return $strParam; 
		}
		
		function getJsonResult($url){
			try{
				$result = "";
				$cnt = 0;
				while($cnt < 3 && ($result=file_get_contents($url)) === FALSE) $cnt ++;
				return json_decode($result);
			}catch(Exception $ex){
	    		throw $ex;
	    	}
		}
		
		function item_search($kw, $pageNo, $pageSize){
			$locaoParam = array(
				'method' => 'item.search',
				'pageNo' => $pageNo,
				'pageSize' => $pageSize,
				'channelId' => '0',
				'inDays' => '30',
				'media' => 'v',
				'sort' => 's',
				'kw' => $kw
			);
			try{
				$strParam = $this->createStrParam(array_merge($this->paramArr, $locaoParam));
				$jsonResult = $this->getJsonResult($this->base_url.$strParam);
				
				if(!empty($jsonResult))
					return $jsonResult;
				
			}catch(Exception $ex){
	    		throw $ex;
	    	}
		}
		
		function item_info_get($itemCodes){
			$locaoParam = array(
				'method' => 'item.info.get',
				'itemCodes' => $itemCodes
			);
			try{
				$strParam = $this->createStrParam(array_merge($this->paramArr, $locaoParam));
				dump($this->base_url.$strParam);
				return $this->getJsonResult($this->base_url.$strParam);
			}catch(Exception $ex){
	    		throw $ex;
	    	}
		}
		
		function item_comment_get($itemCode, $pageNo, $pageSize){
			$locaoParam = array(
				'method' => 'item.comment.get',
				'itemCodes' => $itemCode,
				'pageNo' => $pageNo,
				'pageSize' => $pageSize
			);
			try{
				$strParam = $this->createStrParam(array_merge($this->paramArr, $locaoParam));
				return $this->getJsonResult($this->base_url.$strParam);
			}catch(Exception $ex){
	    		throw $ex;
	    	}
		}
	}
?>