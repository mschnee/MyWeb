<?php

class Views_Footer implements Interfaces_View {
    public function html() {
        $t = new Template("footer");
        return $t->html();
    }
}