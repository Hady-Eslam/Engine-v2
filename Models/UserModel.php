<?php

namespace Models;
use CoreModels\ModelExcutionEngine;

class UserModel{
	
	function __construct(){
		
	}

	function Insert($Data, $WHERE = ''){
		$this->Excute("INSERT INTO users() VALUES () $WHERE")
	}

	function Delete($Data){

		$this->Excute("DELETE FROM users WHERE ")
	}
}