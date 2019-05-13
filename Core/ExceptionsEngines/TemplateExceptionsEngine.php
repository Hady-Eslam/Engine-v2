<?php

namespace Exceptions;

class TemplateExceptionsEngine{
	
	function __construct($Message){
		echo 'Template Exception : <br>'.$Message;
		var_dump( debug_backtrace() );
		exit();	
	}
}