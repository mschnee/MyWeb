<?php

/* set include pathing */
{ 
    $paths = array(
      "include",
      get_include_path()
  );
  set_include_path(implode(PATH_SEPARATOR, $paths));
}
include_once 'common.php';

/* if the first chunk of the URI is Ajax, it's an ajax request. */
$uri = "";
$args = array();

/* determine URI and arguments */
if( ($loc=strpos($_SERVER['REQUEST_URI'],'?'))!==false ) {
    $uri=substr($_SERVER['REQUEST_URI'],0,$loc);
    parse_str(substr($_SERVER['REQUEST_URI'],$loc+1),$args);
} else {
    $uri = $_SERVER['REQUEST_URI'];
}


$tokens = explode("/",preg_replace("/^\//","",$uri));
if($tokens and $tokens[0]=="Ajax") {
    $c = new Controllers_AjaxLoader(array_slice($tokens,1),$args);
    echo $c->json();
} else {
    $c = new Controllers_HtmlLoader($tokens,$args);
    echo $c->html();
}