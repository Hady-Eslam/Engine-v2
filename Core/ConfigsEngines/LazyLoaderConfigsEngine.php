<?php

namespace Configs;
use Configs\ConfigsCheckerEngine;

class LazyLoaderConfigsEngine extends ConfigsCheckerEngine{
	
	function __construct($ConfigsPath){
		$this->Configs = include_once $ConfigsPath;
		self::CheckConfigsValues(['Register'], $this->Configs);
	}
}
