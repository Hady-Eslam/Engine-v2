<?php

namespace Core;

class CSRFProtectionEngine{
	
	private $Valid = True;
	private $NewPerson = True;

	function __construct($Token, $Session_Tokens){
		$this->Token = $Token;
		$this->Session_Tokens = $Session_Tokens;
		$this->Result = $this->Validate();
		$this->CSRF_Token = $this->GenerateCSRFToken();
	}

	private function Validate(){
		return ( $_SERVER['REQUEST_METHOD'] == 'POST' ) ? $this->POST() : True;
	}

	private function POST(){
		return $this->AuthToken([
			'Method' => 'POST',
			'Token' => $this->Token
		]);
	}

	private function AuthToken($Data){
		
		if ( $Data['Token'] === NULL || $this->Session_Tokens === NULL )
			return False;

		else if ( array_key_exists($Data['Token'], $this->Session_Tokens) )
			//unset($this->Session_Tokens[$Data['Token']]);
			return True;
		else
			return False;
	}

	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////

	function isValid($Result){
		return ( $this->Result === True ) ? $Result : 'NotAuthorized';
	}

	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////

	function GetSessionTokens($Session){
		if ( $this->Session_Tokens !== NULL ){
			$Session['CSRF'] = $this->Session_Tokens;
			return $Session;
		}
		else
			return $Session;
	}

	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////

	private function GenerateCSRFToken(){
		return password_hash( time() . bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
	}

	function GetCSRFToken(){
		return $this->CSRF_Token;
	}
}