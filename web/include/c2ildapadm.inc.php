<?php

require_once('/etc/c2i-annu/config.php');

require_once($smarty_full_path.'Smarty.class.php');

$c2ildapadm_root_path="/usr/share/c2i-annu/web/";
$c2ildapadm_var_path="/var/lib/c2i-annu/";

class SmartyC2I extends Smarty {

  function __construct() {
    global $DEBUG,$c2ildapadm_root_path,$c2ildapadm_var_path,$c2imaster_mail;
    // Class Constructor.
    // These automatically get set with each new instance.
    $this->Smarty();

    $this->template_dir = $c2ildapadm_root_path."templates";
    $this->config_dir = $c2ildapadm_root_path."configs";
    $this->compile_dir =$c2ildapadm_var_path."templates_c";
    $this->cache_dir =  $c2ildapadm_var_path."cache";
        
    // think twice before enabling caching, is everything really
    // ready to be cached?
    $this->caching = false;
    
    $this->assign('app_name', 'Annuaire C2I');
    $this->assign('app_version', '1.2');
    $this->assign('stylesheet', 'default');
    $this->assign('title', 'This is the default title, call ' .
		  '$smarty->assign("title", "the title") to fix it');
    
    $this->assign('c2imaster_mail',$c2imaster_mail);
    
    if ($DEBUG) {
      $this->debug_info("<hr><h3>POST</h3><hr><pre>".print_r($_POST,1)."</pre>");
      $this->debug_info("<hr><h3>SESSION</h3><hr><pre>".print_r($_SESSION,1)."</pre>");
      $this->debug_info("<hr><h3>GET</h3><hr><pre>".print_r($_GET,1)."</pre>");
    }
    
  }
  
  function info($msg) {
    if ($this->get_template_vars("infomsg")) {
      $this->append("infomsg", $msg);
    } else {
      $this->assign("infomsg", array($msg));
    }
  }
  
  function warning($msg) {
    if ($this->get_template_vars("warningmsg")) {
      $this->append("warningmsg", $msg);
    } else {
      $this->assign("warningmsg", array($msg));
    }
  }
  
  function error($msg) {
    if ($this->get_template_vars("errormsg")) {
      $this->append("errormsg", $msg);
    } else {
      $this->assign("errormsg", array($msg));
    }
  }

  function debug_info($msg) {
    if ($this->get_template_vars("debug_infomsg")) {
      $this->append("debug_infomsg", $msg);
    } else {
      $this->assign("debug_infomsg", array($msg));
    }
  }
}

$smarty = new SmartyC2I();

function c2ildapadm_unauthorized() {
  global $smarty;
  $smarty->assign('header_title','ERREUR!');
  $smarty->display('unauthorized.tpl');
}


function menu_link ($form,$page,$action,$params=NULL) {
  
  $link =" onclick=\"document.forms['$form'].page.value='$page';";
  $link .= "document.forms['$form'].action.value='$action'; ";
  if (is_array($params)) {
    foreach ($params as $key => $value) {
      $link .= "document.forms['$form'].".$key.".value='".$value."'; ";
    }
  }
  $link .= "document.forms['$form'].submit(); \"";
  
  return $link;

}

/*
BEWARE ! Magic Quotes deprecated after PHP 5.3
 */


function recursive_stripslashes($var) {
  if (is_array($var)) {
    return array_map('recursive_stripslashes',$var);
  } else {
    return stripslashes($var);
  }
}


if (version_compare(PHP_VERSION,'5.3.0')<0) {
  if (get_magic_quotes_gpc()) {
    $_GET=recursive_stripslashes($_GET);
    $_POST=recursive_stripslashes($_POST);
    $_COOKIE=recursive_stripslashes($_COOKIE);
  }
}


?>