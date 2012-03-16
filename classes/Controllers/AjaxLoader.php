<?php
class Controllers_AjaxLoader {
    private $m_view = null;
    /**
     *  Loads a controller or viewer for ajax.
     */
    public function __construct($tokens=array()) {
        debug($tokens);
        if(empty($tokens)) {
            $tokens[0] = "MainIndex";
        }
        try {
            $refl = new ReflectionClass("Views_".$tokens[0]);
            $this->m_view = $refl->newInstanceArgs(array_slice($tokens,1));
        } catch(Exception $e) {
            $refl = new ReflectionClass("Views_MainIndex");
            $this->m_view = $refl->newInstanceArgs(array_slice($tokens,1));
        }
    }
  
    public function json() {
        if($this->m_view) {
            $ret = array(
                'html' => $this->m_view->html(),
                'success' => true
            );
            return json_encode($ret);
        }
        
    }
}