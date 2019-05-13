<?php

namespace Forms\BackEndForms;
use CoreForms\FormsEngine;

class DeleteMessageForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->MessageID = FormsEngine::IntegerField(['Require' => True, 'Max_Length' => ID_Len]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetMessageID(){
		return $this->FILTERED_DATA['MessageID'];
	}
}