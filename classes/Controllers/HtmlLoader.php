<?php

/**
 * Loads the "standard" frame and then fills the content with 
 * correct information.
 */
class Controllers_HtmlLoader {
  
  public function __construct($p) {
    $p = preg_replace("/^\//","",$p);
    $viewClass = "";
    if(!in_array($p,$GLOBALS["known_views"])) {
      $viewClass = "Views_Index";
    } else {
     $viewClass = "Views_".str_replace("/","_",$p);
    }
    $this->view = new $viewClass;
    
  }
  public function html() {
    return $this->view->html();
  }
}