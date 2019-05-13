<?php

namespace Configs;
use Configs\ConfigsCheckerEngine;

class SessionConfigsEngine extends ConfigsCheckerEngine{
	
	function __construct($ConfigsPath){
		$this->Configs = include_once $ConfigsPath;
		self::CheckConfigsValues([
			'TYPE',
			'LIFE_TIME',
			'EXPIRE_ON_CLOSE',
			'ENCRYPT',
			'PROBABILITY'
		], $this->Configs);
	}
}