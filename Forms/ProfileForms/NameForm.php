<?php

namespace Forms\ProfileForms;
use CoreForms\FormsEngine;

class NameForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->N = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Name_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetName(){
		return $this->FILTERED_DATA['N'];
	}
}