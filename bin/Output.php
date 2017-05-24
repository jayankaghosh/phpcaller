<?php

class Output {

	private static $_status = true;
	private  static $_newLineCharacter = "\n";
	public static $ignoreDecoration = false;

	private function isCli(){
		return php_sapi_name() === "cli" && !self::$ignoreDecoration;
	}

	public static function showOutput($status = true){
		self::$_status = $status;
	}

	public static function setNewLineCharacter($newLineCharacter){
		self::$_newLineCharacter = $newLineCharacter;
	}

	public static function write($str){
		if(!self::$_status){
			return null;
		}
		self::display(self::$_newLineCharacter.$str.self::$_newLineCharacter.self::$_newLineCharacter);
	}

	public static function display($str){
		if(!self::$_status){
			return null;
		}
		echo "$str";
	}

	public static function colorString($str = null, $weight = "info"){
		if(!self::isCli()) return $str;
		if(!self::$_status){
			return null;
		}
		$colors = array(
			'error'		=>	"31",
			'success'	=>	"32",
			'attention'	=>	"33",
			'info'		=>	"34",
		);
		if(!array_key_exists($weight, $colors)){
			$colors[$weight] = $weight;
		}
		return "\033[".$colors[$weight]."m".$str."\033[0m";
	}
}