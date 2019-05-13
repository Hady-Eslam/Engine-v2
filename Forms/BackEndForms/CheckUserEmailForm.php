<?php

namespace Forms\BackEndForms;
use CoreForms\FormsEngine;

class CheckUserEmailForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Email = FormsEngine::EmailField(['Require' => True, 'Max_Length' => Email_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}
}