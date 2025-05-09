<?php
$lang = "languages/";
// require_once $lang . "en.php";
$path = $_SERVER['SCRIPT_NAME'];
session_start();
// Language selection
if (isset($_POST['lang']) && in_array($_POST['lang'], ['en', 'fr'])) {
    $_SESSION['lang'] = $_POST['lang'];
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

require_once "languages/" . $_SESSION['lang'] . ".php";
//

$controller = (isset($_GET['controller'])) ? $_GET['controller'] : "login";


$controllerClassName = ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
$ct->route();
