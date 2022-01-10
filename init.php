<?php
function load_model($class_name){
    $path_to_file = $_SERVER['DOCUMENT_ROOT']. '/login_system/class/' . $class_name . '.php';

    if (file_exists($path_to_file)) {
        require $path_to_file;
    }
}

spl_autoload_register('load_model');
$database = new Database();
$session = new Session();
$session_message = $session->message();