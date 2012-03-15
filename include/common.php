<?php
/**
 * @copyright 2012 Matthew Schnee <matthew.schnee@gmail.com>
 */


function __autoload($classname) {
    $dr = $_SERVER['DOCUMENT_ROOT'];
    $class = str_replace("_",DIRECTORY_SEPARATOR, $classname);
    if(file_exists("${dr}/classes/${class}.php"))
        include "${dr}/classes/${class}.php";
    else 
        throw new Exception("Could not load $classname");
}

function debug($message) {
    if(is_array($message))
        $message = print_r($message,true);
    trigger_error($message);
}

/* Whitelist of views */
static $known_views = array(
    "Index",
    "Login",
    "Projects"
);