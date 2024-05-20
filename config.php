<?php
session_start();
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'ferreteria');
define('DB_USER','ferretero');
define('DB_PASSWORD','1234');
define('DB_PORT','3307');
Class Config {
    function getImageSize(){
        return 512000;
    }
    function getImageType(){
        return array('image/png','image/jpeg','image/gif','image/tiff','image/x-png');
    }
}
?>