<?php

namespace Forms\ProfileForms;
use CoreForms\FormsEngine;

class PhoneForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Phone = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Phone_Len]);
		
		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetPhone(){
		return $this->FILTERED_DATA['Phone'];
	}
}