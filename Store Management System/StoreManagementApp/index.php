<?php

include_once "Util/cdebug.php";


session_start();
$controller = (isset($_GET['controller'])) ? $_GET['controller'] : "login";

// cdebug($controller,'test');
// exit;

$controllerClassName = ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
$ct->route();

