<?php

namespace Exceptions;

class ViewsExceptionsEngine{
	
	function __construct($Message){
		echo 'Views Exception : <br>'.$Message;
		var_dump( debug_backtrace() );
		exit();	
	}
}