<?php

namespace Forms\BackEndForms;
use CoreForms\FormsEngine;

class CheckUserNameForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Name = FormsEngine::TextField(['Require' => True, 'Max_Length' => Name_Len,
					'Min_Length' => 1]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}
}