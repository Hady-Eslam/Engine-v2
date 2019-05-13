<?php

use SiteEngines\SiteRenderEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin(){
    $_SESSION['Page Name'] = 'Policy';
    return (new SiteRenderEngine())->Policy_Render();
}