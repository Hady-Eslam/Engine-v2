<?php

namespace Forms\BackEndForms;
use CoreForms\FormsEngine;

class DeletePostForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->ID = FormsEngine::IntegerField(['Require' => True, 'Max_Length' => ID_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetID(){
		return $this->FILTERED_DATA['ID'];
	}
}