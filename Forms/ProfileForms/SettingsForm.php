<?php

namespace Forms\ProfileForms;
use CoreForms\FormsEngine;

class SettingsForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->File1 = FormsEngine::ImageField(['Require' => True, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetFile1(){
		return $this->FILTERED_DATA['File1'];
	}
}