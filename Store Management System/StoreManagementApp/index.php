<?php

include_once 'Util/cdebug';


$controller = (isset($_GET['controller'])) ? $_GET['controller'] : "home";

if ($controller == "home") {
    include "Views/mainpage.php";
    exit;
}

$controllerClassName = ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
$ct->route();
