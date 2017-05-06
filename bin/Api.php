<?php

class Api {

	protected $_apiBaseUrl, $_debug, $_headers;

	public function __construct(){
		$this->_apiBaseUrl = "https://www.truecaller.com/api/";
		$this->_debug = false;
		$this->_headers = [];
	}

	public function debug($flag = true){
		$this->_debug = $flag;
		return $this;
	}

	public function fetch($number = null, $countryCode = 'IN'){
		$front = array(
			'type'			=>	4,
			'countryCode'	=>	$countryCode,
			'q'				=>	$number
		);
		$front = "search?".http_build_query($front);
		return $this->_sendRequest($front);
	}

	public function suggestName($number, $name){
		$payload = json_encode(array(array(
			"p"	=>	$number,
			"n"	=>	$name,
			"t"	=>	1
		)));
		return $this->_sendRequest("nameSuggestion", "POST", $payload);
	}

	protected function _sendRequest($front = null, $method = "GET", $params = [], $sendHeaders = true){
			$url = $this->_apiBaseUrl.$front;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			if($sendHeaders){
				curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
			}
			if($method === "POST"){
				curl_setopt($ch, CURLOPT_POST, 1);
				if(count($params) > 0 && is_array($params)){
					curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
				}
				else if(strlen($params) > 0){
					curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
				}
			}
			if($this->_debug){
				curl_setopt($ch, CURLOPT_VERBOSE, true);
			}
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			$server_output = array();
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$server_output['response_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$server_output['header'] = substr($response, 0, $header_size);
			$server_output['body']	 = substr($response, $header_size);
			curl_close ($ch);
			return $server_output;
	}

	public function setHeaders($headers = []){
		$this->_headers = $headers;
		return $this;
	}

	/**
	 * Returns all the headers to send as an array
	 * @return (array) Headers to be sent
	 */
	protected function getHeaders(){
		$headers = array();
		foreach ($this->_headers as $key => $value) {
			$headers[] = $key.": ".$value;
		}
		return $headers;
	}
}