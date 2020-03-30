<?php

class Database extends PDO 
{

    function __construct() {
        try{
            parent::__construct(getenv('DSN'), getenv('user'), getenv('pass'));
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

}