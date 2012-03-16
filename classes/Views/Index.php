<?php

/**
 * Views_Index is the only "Special" View.  All Views should be fragments loadable by ajax.
 * When a new ViewSession is started (by typing in the URL or hitting f5) the framework
 * needs to construct the HTML that all the javascript needs to run in.  Views_Index is
 * that exoskeleton.
 */
class Views_Index implements Interfaces_View {
    private $m_content = null;
    
    public function setContent(Interfaces_View $view) {
        $this->m_content = $view;
    }
    public function html() {
            $t = new Template("index");
            $t->title = "MyWeb";
            
            if($this->m_content)
                $t->body = $this->m_content;
            else
                $t->body = new Views_MainIndex();
            
            $t->header = new Views_Header();
            $t->footer = new Views_Footer();
            $t->css_files = "<style type=\"text/css\" media=\"all\">
            @import url(\"/css/MyWeb.css\");
            </style>
            ";
            $t->javascript_files = "
                <script type=\"text/javascript\" src=\"/js/jquery-1.7.1.min.js\"></script>
                <script type=\"text/javascript\" src=\"/js/jquery.history.js\"></script>
                <script type=\"text/javascript\" src=\"/js/MyWeb.js\"></script>
            ";
            
            return $t->html();
    }
  
}