<?php

namespace Org\Util;

	class Taobao{
		
		private $appKey = '12142245';
		private $appSecret = '9d766acec19cce44ecd394c41fa35116';
		private $userNick = 'bangoi';
		private $taobao_url = 'http://gw.api.taobao.com/router/rest?';
		
		public function __construct(){
			
		}
		
		static function instance(){   
			static $instance;   
			if (is_null($instance))   
			{
				$instance = new Taobao();
			}   
			return $instance;   
		}
		
		function createSign ($paramArr, $appSecret) {
			$sign = $appSecret; 
			ksort($paramArr); 
			foreach ($paramArr as $key => $val) { 
			   if ($key !='' && $val !='') { 
				   $sign .= $key.$val; 
			   } 
			} 
			dump($sign);
			$sign = strtoupper(md5($sign));  //Hmac方式
			//	$sign = strtoupper(md5($sign.$appSecret)); //Md5方式	
			dump($sign);
			return $sign; 
		}

		//组参函数 
		function createStrParam ($paramArr) { 
			$strParam = ''; 
			foreach ($paramArr as $key => $val) { 
			   if ($key != '' && $val !='') { 
				   $strParam .= $key.'='.urlencode($val).'&'; 
			   } 
			} 
			return $strParam; 
		}
		
		//解析xml函数
		function getXmlData ($strXml) {
			$pos = strpos($strXml, 'xml');
			if ($pos) {
				$xmlCode=simplexml_load_string($strXml,'SimpleXMLElement', LIBXML_NOCDATA);
				$arrayCode= $this->get_object_vars_final($xmlCode);
				return $arrayCode ;
			} else {
				return '';
			}
		}
	
		function get_object_vars_final($obj){
			if(is_object($obj)){
				$obj=get_object_vars($obj);
			}
			if(is_array($obj)){
				foreach ($obj as $key=>$value){
					$obj[$key]=$this->get_object_vars_final($value);
				}
			}
			return $obj;
		}
		
		function get_item($num_iid){
			
			$paramArr = array(
				'app_key' => $this->appKey,
		    	'method' => 'taobao.taobaoke.items.detail.get',
		    	'format' => 'json',
	     		'timestamp' => date('Y-m-d H:i:s'),
	    		'v' => '2.0',		   
				'sign_method'=> 'HmacMD5',
				'fields' => 'iid,num_iid,nick,title,cid,pic_url,price,click_url,shop_click_url', //返回字段
	      		'num_iids' => $num_iid,
		      	'nick' => $this->userNick,
			);
			
			//生成签名
			$sign = $this->createSign($paramArr, $this->appSecret);
			
			//组织参数
			$strParam = $this->createStrParam($paramArr);
			$strParam .= 'sign='.$sign;
			
			$url = $this->taobao_url.$strParam;
			
			dump($url);
			
			$result = "";
			
			try{
				//$result = $this->use_proxy($this->is_ctx, $url);
				
				$result = "";
				$cnt = 0;				
				
				while($cnt < 3 && ($result=file_get_contents($url)) === FALSE) $cnt ++;
				
				$json_result = json_decode($result);
				
				dump($json_result);
				
				// result get
				if(empty($json_result->error_response->msg))
				{
					$taobaoke_items_detail_get_response = $json_result->taobaoke_items_detail_get_response;
					$taobaoke_item_details = $taobaoke_items_detail_get_response->taobaoke_item_details;
					
					$total_results = $taobaoke_items_detail_get_response -> total_results;
			
					$taobaoke_item_detail = $taobaoke_item_details -> taobaoke_item_detail;
					
					//dump($taobaoke_item_detail[0]);
					return $taobaoke_item_detail[0];
				}
				else // error
				{
					throw new Exception($json_result->error_response->msg, 1);
				}
				
			}catch(Exception $ex){
	    		throw $ex;
	    	}
		}
		
	}
?>