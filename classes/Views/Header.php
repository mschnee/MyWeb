<?php
class Views_Header implements Interfaces_View {
    private $items = array('Blog','Faq','Projects');
    public function html() {
        $ret = "<div><ul>";
        foreach($this->items as $menuitem) {
            $ret .= "<li><a href=\"/{$menuitem}\">{$menuitem}</a></li>";
        }
        $ret .= "</ul></div>";
        return $ret;
    }
}