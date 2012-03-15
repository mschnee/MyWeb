<?php

/**
 * Create's a basic display Frame.
 */
class Views_Index implements Interfaces_View {
  public function __construct() {
  
  }
  public function html() {
    $t = new Template("index");
    $t->title = "MyWeb";
    $t->body = new Views_MainIndex();
    $t->header = new Views_Header();
    $t->footer = new Views_Footer();
    $t->css_files = "<style type=\"text/css\" media=\"all\">
    @import url(\"/css/MyWeb.css\");
    </style>
    ";
    $t->javascript_files = "
        <script type=\"text/javascript\" src=\"/js/jquery-1.7.1.min.js\"></script>
        <script type=\"text/javascript\" src=\"/js/jquery.ba-hashchange.min.js\"></script>
        <script type=\"text/javascript\" src=\"/js/jquery.history.js\"></script>
        <script type=\"text/javascript\" src=\"/js/MyWeb.js\"></script>
    ";
    
    return $t->html();
  }
  
}