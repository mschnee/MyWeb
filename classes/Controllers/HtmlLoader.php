<?php

/**
 * Loads the "standard" frame and then fills the content with 
 * correct information.
 */
class Controllers_HtmlLoader {
    private 
        $m_view = null,
        $m_content = null;
        
    public function __construct($tokens = array()) {
        if(empty($tokens)) {
            $tokens[0] = "MainIndex";
        }
        $this->m_view = new Views_Index();
        
        try {
            $refl = new ReflectionClass("Views_".$tokens[0]);
            $this->m_content = $refl->newInstanceArgs(array_slice($tokens,1));
        } catch(Exception $e) {
            $refl = new ReflectionClass("Views_MainIndex");
            $this->m_content = $refl->newInstanceArgs(array_slice($tokens,1));
        }
    
    }
    public function html() {
        $this->m_view->setContent($this->m_content);
        if($this->m_view)
            return $this->m_view->html();
    }
}