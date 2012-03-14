<?php
/**
 * @copyright 2012 Matthew Schnee <matthew.schnee@gmail.com>
 */


function __autoload($classname) {
  $dr = $_SERVER['DOCUMENT_ROOT'];
  $class = str_replace("_",DIRECTORY_SEPARATOR, $classname);
  if(file_exists("${dr}/classes/${class}.php"))
    include "${dr}/classes/${class}.php";
}

/* Whitelist of views */
static $known_views = array(
  "Index",
  "Login"
);