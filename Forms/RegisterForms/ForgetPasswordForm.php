<?php

namespace Forms\RegisterForms;
use CoreForms\FormsEngine;

class ForgetPasswordForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Email = FormsEngine::EmailField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Email_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetEmail(){
		return $this->FILTERED_DATA['Email'];
	}
}