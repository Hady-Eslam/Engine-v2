<?php

namespace Forms\BackEndForms;
use CoreForms\FormsEngine;

class CheckUserPhoneForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Phone = FormsEngine::TextField(['Require' => True, 'Max_Length' => Phone_Len,
				'Min_Length' => 1]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}
}