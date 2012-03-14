<?php

/**
 * Create's a basic display Frame.
 */
class Views_Index implements Interfaces_View {
  public function __construct() {
  
  }
  public function html() {
    $t = new Template("index");
    return $t->html();
  }
  
}