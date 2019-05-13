<?php

namespace Exceptions;

class CSRFExceptionsEngine{
	
	function __construct($Message){
		echo "\CSRF Exception : <br>".$Message;
		var_dump( debug_backtrace() );
		exit();	
	}
}