<?php
class Controller {
    function __construct() {
        session_start();
        $this->view = new View();
    }

    function loadModel($modelName) {
        $modelName = ucfirst($modelName);
        $model = './models/'.$modelName.'.php';
        if(file_exists($model)) {
            require $model;
            $this->model = new $modelName();
        }
    }
}