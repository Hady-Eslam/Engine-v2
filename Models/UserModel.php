<?php

namespace Models;
use CoreModels\ModelEngine;

class UserModel extends ModelEngine{
	
	function __construct(){
		
		$this->ID = ModelEngine::PrimaryKeyField();

		$this->Name = ModelEngine::CharField(['Max_Length' => User_Name_Len, 'Null' => False ]);

		$this->Email = ModelEngine::CharField(['Max_Length' => User_Email_Len, 'Null' => False ]);

		$this->Password = ModelEngine::CharField(['Max_Length' => User_Password_Len,
				'Null' => False ]);

		$this->Created_At = ModelEngine::DateTimeField(['Auto_Fill' => True, 'Null' => False ]);

		$this->Updated_At = ModelEngine::DateTimeField(['Auto_Fill' => True, 'Null' => False ]);
	}
}