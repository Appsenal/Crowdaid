<?php
namespace Util;

class API {
	private $api;
	private $key;
	private $text;
	private $apiResponse;
	
	public function __construct() {	
		$this->key='87ff95e7f3dd37c6efa4c6cc7e211a75';
		$this->text='';
	}

	public function ClassifyText($text) {
		$return=1;
		$text=str_replace(' & ', ' %26 ', $text);
		if (empty($text)) {
			$this->apiResponse='Text is empty';
		}
		else {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "http://api.meaningcloud.com/topics-2.0",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "key=".$this->key."&lang=en&txt=".$text."&tt=c&uw=y&ud=crowdaid",
				CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded"),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  $this->apiResponse="cURL Error #:" . $err;
			} 
			else {
				$this->apiResponse=$response;
				$return=0;
			}
		}
		return $return;
	}

	public function GetResponse() {
		return $this->apiResponse;
	}
}
?>