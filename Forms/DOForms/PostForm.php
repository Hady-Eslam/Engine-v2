<?php

namespace Forms\DOForms;
use CoreForms\FormsEngine;

class PostForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Message = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Message_Len]);

		$this->MessageEmail = FormsEngine::EmailField(['Require' => False, 'Min_Length' => 1,
				'Max_Length' => Email_Len, 'Default' => 'Testing@Testing.Testing' ]);

		//////////////////////////////////////////////

		$this->File1 = FormsEngine::ImageField(['Require' => False, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->File2 = FormsEngine::ImageField(['Require' => False, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->File3 = FormsEngine::ImageField(['Require' => False, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->File4 = FormsEngine::ImageField(['Require' => False, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->File5 = FormsEngine::ImageField(['Require' => False, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetMessage(){
		return $this->FILTERED_DATA['Message'];
	}

	function GetEmail(){
		return $this->FILTERED_DATA['MessageEmail'];
	}

	function GetFile1(){
		return $this->FILTERED_DATA['File1'];
	}

	function GetFile2(){
		return $this->FILTERED_DATA['File2'];
	}

	function GetFile3(){
		return $this->FILTERED_DATA['File3'];
	}

	function GetFile4(){
		return $this->FILTERED_DATA['File4'];
	}

	function GetFile5(){
		return $this->FILTERED_DATA['File5'];
	}
}