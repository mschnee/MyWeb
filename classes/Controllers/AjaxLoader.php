<?php
class Controllers_AjaxLoader {

    /**
     *  Loads a controller or viewer for ajax.
     */
    public function __construct($tokens=array()) {

    }
  
    public function json() {
        return json_encode(array());
    }
}