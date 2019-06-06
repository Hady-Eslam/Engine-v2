<?php

use Core\CoreEngine;
use Core\TimerEngine;

define('START_ENGINE', microtime(true));
define('_DIR_', __DIR__);

$LazyLoader = require_once _DIR_.'/Core/CoreEngines/LazyLoaderEngine.php';

$Timer = new TimerEngine();
$Timer->Start();

$Core = new CoreEngine();

$Core->BeginRouting();
$Core->MakeDataBaseConnection();
$Core->CheckMiddleWares();
$Core->GetRequest();
$Core->BeginView();
$Core->InvokeQueries();
$Core->GenerateTemplate();
$Core->SaveSession();
$Core->FlushOutPut();

$Timer->End();
//$GLOBALS['DataBase']->ShowTime();
$Timer->ShowTime();
