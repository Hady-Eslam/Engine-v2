<?php

namespace Forms\RegisterForms;
use CoreForms\FormsEngine;

class SignUPForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Email = FormsEngine::EmailField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Email_Len]);
		$this->Name = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Name_Len]);
		$this->Phone = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Phone_Len]);
		$this->Password = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Password_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}
}