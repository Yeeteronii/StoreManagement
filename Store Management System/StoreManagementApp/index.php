<?php
session_start();
$controller = (isset($_GET['controller'])) ? $_GET['controller'] : "login";


$controllerClassName = ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
$ct->route();

