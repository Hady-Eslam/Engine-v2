<?php

namespace Models;
use CoreModels\ModelEngine;

class NotesModel extends ModelEngine{
	
	function __construct(){
		
		$this->ID = ModelEngine::PrimaryKeyField();

		$this->Title = ModelEngine::CharField(['Null' => False, 'Max_Length' => Note_Title_Len]);

		$this->Body = ModelEngine::TextField(['Null' => False]);

		$this->Email = ModelEngine::CharField(['Null' => False, 'Max_Length' => User_Email_Len]);

		$this->Created_At = ModelEngine::DateTimeField(['Auto_Fill' => True, 'Null' => False]);

		$this->Updated_At = ModelEngine::DateTimeField(['Auto_Fill' => True, 'Null' => False]);
	}
}