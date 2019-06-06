<?php

use SiteEngines\SiteRenderEngine;

function Begin($Request){
	return SiteRenderEngine::Not_Found_Render($Request);
}