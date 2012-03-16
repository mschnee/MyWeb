<?php
class Controllers_AjaxLoader {
    private $m_view = null;
    /**
     *  Loads a controller or viewer for ajax.
     */
    public function __construct($tokens=array(),$arguments=array()) {
        if(empty($tokens)) {
            $tokens[0] = "MainIndex";
        }
        
        $refl = null;
        /* try loading a controller, then a view */
        
        if(!$refl) try {
            $refl = new ReflectionClass("Views_".$tokens[0]);
            
        } catch(Exception $e) {
            $refl = new ReflectionClass("Views_MainIndex");
        }
        if(!$refl) throw new Exception("oops");
        
        $this->m_view = $refl->newInstanceArgs(array_slice($tokens,1));
        if($refl->hasMethod("setArguments")) {
            $this->m_view->setArguments($arguments);
        }
    }
  
    public function json() {
        if($this->m_view) {
            if($this->m_view instanceof Interfaces_Json) {
                return json_encode($this->m_view->json());
            } else {
                $ret = array(
                    'html' => $this->m_view->html(),
                    'success' => true
                );
                return json_encode($ret);
            }
        }
        
    }
}