<?php

namespace Configs;
use Configs\ConfigsCheckerEngine;

class ModelConfigsEngine extends ConfigsCheckerEngine{
	
	function __construct($ConfigsPath){
		$this->Configs = include_once $ConfigsPath;
		self::CheckConfigsValues([
			'DB_LANGUAGE',
			'DB_PORT',
			'DB_HOST',
			'DB_NAME',
			'DB_USER',
			'DB_PASSWORD'
		], $this->Configs);
	}
}
