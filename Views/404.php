<?php

use SiteEngines\SiteRenderEngine;


function Begin(){
	return (new SiteRenderEngine())->Not_Found_Page();
}