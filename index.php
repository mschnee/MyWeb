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
$tokens = explode("/",preg_replace("/^\//","",$_SERVER["REQUEST_URI"]));
if($tokens and $tokens[0]=="Ajax") {
    $c = new Controllers_AjaxLoader(array_slice($tokens,1));
    return $c->json();
} else {
    $c = new Controllers_HtmlLoader($tokens);
    echo $c->html();
}