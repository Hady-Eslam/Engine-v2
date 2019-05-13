<?php

use SiteEngines\SiteRenderEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin(){
	return (new SiteRenderEngine())->About_US_Render();
}