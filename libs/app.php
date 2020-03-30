<?php

class App {
    function __construct() {
        if(array_key_exists('url', $_GET)) {
            $url = explode('/', rtrim($_GET['url']));
        } else {
            $url[0] = 'question';
            $url[1] = 'all';
        }

        $file = './controllers/'. $url[0] .'Controller.php';
        if(!file_exists($file)) {
            echo 'PageNotFound404';
            return false;
        }

        require($file);
        $className = ucfirst($url[0]) .'Controller';
        $controller = new $className();
        $controller->loadModel($url[0]);

        //methods($url[1]) and parameters($url[2])
        if(isset($url[1])) {
            if(method_exists($controller, $url[1])) {
                if(isset($url[2])) {
                    $controller->{$url[1]}($url[2]);
                } else {
                    $controller->{$url[1]}();
                }                
            }
        }
    }
}