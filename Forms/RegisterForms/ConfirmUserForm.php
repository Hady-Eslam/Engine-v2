<?php

namespace Forms\RegisterForms;
use CoreForms\FormsEngine;

class ConfirmUserForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->E = FormsEngine::EmailField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Email_Len]);
		$this->T = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Token_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetEmail(){
		return $this->FILTERED_DATA['E'];
	}

	function GetToken(){
		return $this->FILTERED_DATA['T'];
	}
}