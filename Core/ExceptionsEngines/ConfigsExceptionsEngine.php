<?php

namespace Exceptions;

class ConfigsExceptionsEngine{
	
	function __construct($Message){
		echo 'Config Exception : <br>'.$Message;
		var_dump( debug_backtrace() );
		exit();	
	}
}