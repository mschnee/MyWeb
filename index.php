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
$c = new Controllers_HtmlLoader($_SERVER["REQUEST_URI"]);
echo $c->html();