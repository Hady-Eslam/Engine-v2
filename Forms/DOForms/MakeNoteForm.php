<?php

namespace Forms\DOForms;
use CoreForms\FormsEngine;

class MakeNoteForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->Title = FormsEngine::TextField(['Require' => True,
				'Max_Length' => Note_Title_Len , 'Min_Length' => 1]);

		$this->Note = FormsEngine::TextField(['Require' => True,
				'Max_Length' => Note_Body_Len , 'Min_Length' => 1]);
		
		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetTitle(){
		return $this->FILTERED_DATA['Title'];
	}

	function GetNote(){
		return $this->FILTERED_DATA['Note'];
	}
}