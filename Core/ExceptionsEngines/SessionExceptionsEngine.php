<?php

namespace Exceptions;

class SessionExceptionsEngine{
	
	function __construct($Message){
		echo 'Session Exception : <br>'.$Message;
		var_dump( debug_backtrace() );
		exit();	
	}
}