<?php
/* set include pathing */
{ 
    $paths = array(
      "include",
      get_include_path()
  );
  set_include_path(implode(PATH_SEPARATOR, $paths));
}
require_once "common.php";

$c = new Controllers_AjaxLoader($_SERVER["REQUEST_URI"]);