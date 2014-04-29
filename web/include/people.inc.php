<?php

require_once('section-class.inc.php');
require_once('sconet-xml.php');
//require_once('mysql.inc.php');
//require_once('note-class.inc.php');

function people_change_password() {
  global $smarty;
  
  if ($_SESSION['user']->auth=='ldap') { 

    $smarty->assign('header_title','Changement du mot de passe');
    $smarty->display('people_change_password.tpl');

  } else {
    $smarty->error("Impossible de changer les mots de passe superadmin via l'interface");
    c2ildapadm_unauthorized();
  }

}

function people_password_process() {
  global $smarty;

  $smarty->assign('header_title','Changement de mot de passe');

  try {
    $people = new people($_SESSION['user']->uid);
    
    if ($_POST['password']!="") {
      if ($_POST['password'] != $_POST['passverif']) {
	throw (new C2iException('passwords_dont_match'));
      } else {
	$people->set_password($_POST['password']); 
	$smarty->assign('message','Changement de mot de passe réussi');
      }
    } else {
      throw (new C2iException('empty_password')) ;
    }
    
  } catch (C2iException $exception) {
    $smarty->error($exception->getMessage());
  }
    
  $smarty->display('people_change_password.tpl');

}

?>