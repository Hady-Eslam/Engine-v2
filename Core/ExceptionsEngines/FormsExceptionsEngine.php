<?php

namespace Exceptions;

class FormsExceptionsEngine{
	
	function __construct($Message){
		echo "\nForms Exception : <br>".$Message;
		var_dump( debug_backtrace() );
		exit();	
	}
}