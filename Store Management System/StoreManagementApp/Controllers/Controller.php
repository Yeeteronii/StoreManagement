<?php
//cdebug(1);
//exit;

include_once 'Models/Model.php';

class Controller {
    
    function route(){
	}

    function render($controller, $view, $data = []) {
        extract($data);

        include "Views/$controller/$view.php";
    }

}




