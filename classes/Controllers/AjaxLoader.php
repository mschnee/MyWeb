<?php
class Controllers_AjaxLoader {
    private $m_view = null;
    /**
     *  Loads a controller or viewer for ajax.
     */
    public function __construct($tokens=array()) {
        
        try {
            $refl = new ReflectionClass("Views_".$tokens[0]);
            $this->m_view = $refl->newInstanceArgs(array_slice($tokens,1));
        } catch(Exception $e) {
            debug($e->getMessage());
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