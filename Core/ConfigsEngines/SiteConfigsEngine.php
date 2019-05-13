<?php

namespace Configs;
use Configs\ConfigsCheckerEngine;

class SiteConfigsEngine extends ConfigsCheckerEngine{
	
	function __construct($ConfigsPath){
		$this->Configs = include_once $ConfigsPath;
	}
}
