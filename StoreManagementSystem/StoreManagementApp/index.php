<?php
$lang = "languages/";
<<<<<<< Updated upstream
require_once $lang . "en.php";
=======
include_once $lang . "fr.php";

>>>>>>> Stashed changes
$path = $_SERVER['SCRIPT_NAME'];
session_start();


$controller = (isset($_GET['controller'])) ? $_GET['controller'] : "login";


$controllerClassName = ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
$ct->route();
