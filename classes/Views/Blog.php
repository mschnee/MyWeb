<?php

class Views_Blog implements Interfaces_View {
    public function html() {
        return "<h1>Blog</h1><p>This panel will eventually show a blog.  Before that, I need to design a SQL driver, a database, and implement a login-session system.</p>";
    }
}