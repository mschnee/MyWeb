<?php

class Views_Faq implements Interfaces_View {
    private $m_qid = 0;
    private $m_q = array(1,2,3);
    public function __construct($qid=1) {
        if(!in_array($qid,$this->m_q))
            $qid=1;
        $this->m_qid=$qid;
    }
    public function html() {
        $t = new Template("Faq_{$this->m_qid}");
        return $t->html();
    }
}