<?php

namespace Exceptions;

class LazyLoaderExceptionsEngine{
	
	function __construct($Message){
		echo 'Lazy Loader Exception : <br>'.$Message;
		var_dump( debug_backtrace() );
		exit();	
	}
}