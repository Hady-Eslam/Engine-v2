<?php

namespace Exceptions;

class ModelExceptionsEngine{
	
	function __construct($Message){
		echo "\nModel Exception : <br>".$Message;
		var_dump( debug_backtrace() );
		exit();	
	}
}