<?php

/* renders a PagedPanel */

class Views_Faq implements Interfaces_View, Interfaces_Json {
    private $m_faqList = array();
    private $selectedPage = null;
    
    public function __construct($qid=0) {
        $dr = $_SERVER['DOCUMENT_ROOT'];
        $di = new DirectoryIterator($dr."/templates/Faq/");
        $files = array();
        
        foreach($di as $fileInfo) {
            if($fileInfo->isFile() and $fileInfo->getExtension()=="tpl") {
                $files []= substr($fileInfo->getFilename(),0,-4);
            }
        }
        
        sort($files);
        foreach($files as $f) {
            $this->m_faqList []= "Faq/".$f;
        }
        

        if(isset($this->m_faqList[$qid]))
            $this->selectedPage = $qid;
    }
    
    public function setArguments($args) {
        $this->m_args = $args;
    }
    
    /* returns the full HTML, if it doesn't already exist */
    public function html() {
        return $this->getPager().$this->getPanelContent();
    }
    
    public function getPanelContent() {
        if($this->selectedPage !== null) {
            $pager = $this->getPager();
            $t = new Template($this->m_faqList[$this->selectedPage]);
            return $t->html();
        }
    }
    public function getPager() {
        if(count($this->m_faqList) <8) {
            $ret = "<div class=PagedPanelPager><div><ul>";
            if($this->selectedPage > 0) {
                $ret .= "<li><a href=\"/Faq/0\">First</a></li>";
                $ret .= "<li><a href=\"/Faq/".($this->selectedPage-1)."\">Prev</a></li>";
            } else {
                $ret .= "<li class=no>First</li><li class=no>Prev</li>";
            }
            foreach($this->m_faqList as $i=>$item) {
                $sel = ($i==$this->selectedPage?"class=selected":"");
                $ret .= "<li $sel ><a href=\"/Faq/$i\">".($i+1)."</a></li>";
            }
            if($this->selectedPage<count($this->m_faqList)-1) {
                $ret .= "<li><a href=\"/Faq/".($this->selectedPage+1)."\">Next</a></li>";
                $ret .= "<li><a href=\"/Faq/".(count($this->m_faqList)-1)."\">Last</a></li>";
            } else {
                $ret .= "<li class=no>Next</li><li class=no>Last</li>";
            }
            $ret .="</ul></div><div style='clear:both'>&nbsp;</div></div>";
        }
        
        return $ret;
    }
    public function json() {
        $ret = array(
            'html'=>"<div class=PagedPanelPage>".$this->getPanelContent()."</div>",
            'pager'=>$this->getPager(),
            'segmentType'=>"PagedPanel",
            'success'=>true
        );
        return $ret;
    }
}