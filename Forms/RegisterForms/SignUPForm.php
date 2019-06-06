<?php

namespace Forms\RegisterForms;
use CoreForms\FormsEngine;

class SignUPForm extends FormsEngine{
	
	function __construct(...$Data){
		
		$this->Name = FormsEngine::TextField(['Require' => True,
			'Max_Length' => User_Name_Len, 'Min_Length' => 1 ]);

		$this->Email = FormsEngine::EmailField(['Require' => True,
			'Max_Length' => User_Email_Len, 'Min_Length' => 1]);

		$this->Password = FormsEngine::TextField(['Require' => True,
			'Max_Length' => User_Password_Len, 'Min_Length' => 1]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetName(){
		return $this->FILTERED_DATA['Name'];
	}

	function GetEmail(){
		return $this->FILTERED_DATA['Email'];
	}

	function GetPassword(){
		return $this->FILTERED_DATA['Password'];
	}
}