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
    $dr = $_SERVER['DOCUMENT_ROOT'];
    try {
        $this->view = new $viewClass;
    } catch(Exception $e) {
        $this->view = new Views_Index;
    }
    
  }
  public function html() {
    return $this->view->html();
  }
}