<?php

namespace Core;

use Exceptions\SessionExceptionsEngine;

use \ArrayAccess;

class RequestEngine{

	public static function GetRequest(){
		$Request = new Request($_GET, $_POST, $_FILES, $_COOKIE, $_SERVER,
				getallheaders());

		self::DELETE_SUPERGLOBALS();
		return $Request;
	}

	private static function DELETE_SUPERGLOBALS(){
		unset($_GET);
		unset($_POST);
		unset($_COOKIE);
		unset($_FILES);
		unset($_SERVER);

		unset($GLOBALS['SESSION']);
		unset($GLOBALS['ENGINE_SESS_ID']);
	}
}

class Request{

	function __construct($GET, $POST, $FILES, $COOKIE, $SERVER, $HEADERS){
		$this->GET = $GET;
		$this->POST = $POST;
		$this->COOKIE = $COOKIE;
		$this->FILES = $FILES;
		$this->SERVER = $SERVER;
		$this->HEADERS = $HEADERS;

		if ( $GLOBALS['SESSION'] !== NULL )
			$this->SESSION = new RequestSession();
	}

	function isPOST(){
		return ( $this->SERVER['REQUEST_METHOD'] === 'POST' ) ? True : False ;
	}

	function isGET(){
		return ( $this->SERVER['REQUEST_METHOD'] === 'GET' ) ? True : False ;
	}

	function REQUEST_METHOD(){
		return $this->SERVER['REQUEST_METHOD'];
	}

	function REFERER_IS_SET(){
		return ( isset($this->SERVER['HTTP_REFERER']) ) ? True : False;
	}

	function GET_REFERER(){
		return ( isset($this->SERVER['HTTP_REFERER']) ) ? $this->SERVER['HTTP_REFERER'] : '';
	}

	function CHECK_REFERER($INCOMING_URL = ''){
		$REFERER = ( !isset($this->SERVER['HTTP_REFERER']) ) ? '' : $this->SERVER['HTTP_REFERER'];
		$REFERER = explode('?', $REFERER)[0];
		return ( $INCOMING_URL === $REFERER ) ? True : False;
	}

	function IN_POST(...$Keys){
		foreach ($Keys as $Key => $Value)
			if ( !isset($this->POST[$Value]) )
				return False;
		return True;
	}

	function IN_GET(...$Keys){
		foreach ($Keys as $Key => $Value)
			if ( !isset($this->GET[$Value]) )
				return False;
		return True;
	}

	function IN_FILES(...$Keys){
		foreach ($Keys as $Key => $Value)
			if ( !isset($this->FILES[$Value]) )
				return False;
		return True;
	}
}

class RequestSession implements ArrayAccess{

	private $Session = [];
	private $SessionID = NULL;

	function __construct(){
		$this->Session = $GLOBALS['SESSION'];
		$this->SessionID = $GLOBALS['ENGINE_SESS_ID'];
	}
	
	/*
		Array Access Methods
	*/
	function offsetExists($OffSet){
		return ( isset($this->Session[$OffSet]) ) ? True : False ;
	}

	function offsetGet($OffSet){
		if ( isset($this->Session[$OffSet]) )
			return $this->Session[$OffSet];
		throw new SessionExceptionsEngine("Key $OffSet Not Found");
	}

	function offsetSet($OffSet, $Value){
        $this->Session[$OffSet] = $Value;
	}

	function offsetUnset($OffSet){
		unset($this->Session[$OffSet]);
	}

	/*
		Ends Here
	*/

	function DeleteSession(){
		$this->Session = [];
	}

	function GetSessionID(){
		return $this->SessionID;
	}

	function __debugInfo(){
		return $this->Session;
	}

	function __toString(){
		return $this->Session;
	}

	function isEmpty(){
		return ( $this->Session === [] ) ? True : False;
	}

	function GetSession(){
		return $this->Session;
	}

	function GenerateKey($Key){
		$this->Session[$Key] = True;
	}
}