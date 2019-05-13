<?php

namespace ErrorsHandlers;

use ErrorsHandlers\ErrorsMessageHandlerEngine;

class ErrorsHandlerEngine{

	function __construct(){
		set_error_handler(function ($Level, $Message, $File, $Line) {
			new ErrorsMessageHandlerEngine($Level, $Message, $File, $Line);
		    exit();
		});
	}
}