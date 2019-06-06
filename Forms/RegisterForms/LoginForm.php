<?php

namespace Forms\RegisterForms;

use CoreForms\FormsEngine;

class LoginForm extends FormsEngine{
	
	function __construct(...$Data){
		
		$this->Email = FormsEngine::EmailField(['Require' => True,
			'Max_Length' => User_Email_Len, 'Min_Length' => 1]);

		$this->Password = FormsEngine::TextField(['Require' => True,
			'Max_Length' => User_Password_Len, 'Min_Length' => 1]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetEmail(){
		return $this->FILTERED_DATA['Email'];
	}

	function GetPassword(){
		return $this->FILTERED_DATA['Password'];
	}
}