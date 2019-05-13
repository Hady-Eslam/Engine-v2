<?php

namespace Forms\ProfileForms;
use CoreForms\FormsEngine;

class AddressForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Address = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Address_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetAddress(){
		return $this->FILTERED_DATA['Address'];
	}
}