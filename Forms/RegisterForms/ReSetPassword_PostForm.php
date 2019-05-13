<?php

namespace Forms\RegisterForms;
use CoreForms\FormsEngine;

class ReSetPassword_PostForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Email = FormsEngine::EmailField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Email_Len]);

		$this->Token = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Token_Len]);

		$this->Password = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Password_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetEmail(){
		return $this->FILTERED_DATA['Email'];
	}

	function GetToken(){
		return $this->FILTERED_DATA['Token'];
	}

	function GetPassword(){
		return $this->FILTERED_DATA['Password'];
	}
}