<?php
/**
 * @file Template.php
 * @class Template
 * A very basic templating class.
 */

class Template implements Interfaces_View {
  private $m_fileData;
  private $m_d = array();
  public function __construct($templateFile=null) {
    if($templateFile)
      $this->loadFile($templateFile);
  }
  
  public function loadFile($templateFile) {
    $dr = $_SERVER['DOCUMENT_ROOT'];
    $file = str_replace("_",DIRECTORY_SEPARATOR, $templateFile);
    if(file_exists("{$dr}/templates/{$file}.tpl"))
	$this->m_fileData = file_get_contents("{$dr}/templates/{$file}.tpl");
  }
  
  public function __set($k,$v) {
    $this->m_d[$k] = $v;
  }
  public function __get($k) {
    return isset($this->m_d[$k])?$this->m_d[$k]:null;
  }
  
  public function html() {
    $d = $this->m_fileData;
    foreach($this->m_d as $token=>$content) {
      $replaceWith = null;
      if($content instanceof Interfaces_View) {
	$replaceWith = $content->html();
      } else {
	$replaceWith = $content;
      }
      $this->m_fileData = str_replace("%{$token}%",$replaceWith,$d);
    }
    
    // replace anything that's left
    preg_replace("/%\w*?%/","",$d);
    return $d;
  }
}