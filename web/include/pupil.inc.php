<?php

require('/etc/c2i-annu/config.php');
require_once('section-class.inc.php');
require_once('sconet-xml.php');
require_once('mysql.inc.php');
require_once('note-class.inc.php');

// pupil view page.

function pupil_init_menu() {

  global $smarty;
  $user = $_SESSION['user'];
  
  $lien_menu = array('infos' => menu_link('menuform','pupil','infos'),
		     'change_password' => menu_link('menuform','people','change_password'),
		     'validation' => menu_link('menuform','pupil','validation'),
		     'mail' => menu_link('menuform','pupil','mail'),     
		     'logout'=>menu_link('menuform','logout','logout')	  
		     );
  
  $smarty->assign('lien_menu',$lien_menu);
  
}


function pupil_infos() {
  
    global $smarty;
    $user = $_SESSION['user'];
    
    $pupil= new people($user->uid);
    
    $smarty->assign('header_title'," Donn&eacute;es personnelles ");
    $smarty->assign('pupil',(array) $pupil);  
    $smarty->display('pupil_view_profile.tpl');
    
}

function pupil_validation() {

    global $smarty;
    $user = $_SESSION['user'];
    
    $pupil= new people($user->uid);
    
    $smarty->assign('header_title'," Validation de l'examen ");
    $smarty->assign('pupil',(array) $pupil);  
    $smarty->display('pupil_validation.tpl');
  
}

function pupil_process_validation() {
  global $smarty;
  $user = $_SESSION['user'];
  
  $pupil= new people($user->uid);
  $localisation=$_POST['localisation'];
  
  if (version_compare(PHP_VERSION,'5.3.0','<')) {
    if (get_magic_quotes_gpc()) {
      $localisation=stripslashes($localisation);
    }
  }

  if (!preg_match('/^([[:alpha:]]|\s|\(|\)|\'|-)*$/',$localisation)) {
    $error_message = " La syntaxe du lieu de naissance ".htmlentities($localisation)." n'est pas correcte ";
    $smarty->assign('header_title'," Validation de l'examen ");
    $smarty->error($error_message);
    $smarty->assign('pupil',(array) $pupil);  
    $smarty->display('pupil_validation.tpl');        
  } else {	
    $pupil->localisation=$localisation;
    $pupil->mail=$mail;
    $pupil->insert_into_ldap();
    pupil_infos();
  }  
    
}

function pupil_mail() {

    global $smarty;
    $user = $_SESSION['user'];
    
    $pupil= new people($user->uid);
    
    $smarty->assign('header_title'," Validation de l'examen ");
    $smarty->assign('pupil',(array) $pupil);  
    $smarty->display('pupil_mail.tpl');
  
}

function pupil_process_mail() {
  global $smarty;
  global  $c2i_db_host,$c2i_db_database,$c2i_db_user,$c2i_db_password;
  $user = $_SESSION['user'];
  
  $pupil= new people($user->uid);
  $mail=$_POST['mail'];
  $valid=true;
  
  if (version_compare(PHP_VERSION,'5.3.0','<')) {
    if (get_magic_quotes_gpc()) {
      $mail=stripslashes($mail);
    }
  }

  if (!filter_var($mail,FILTER_VALIDATE_EMAIL)) {
    $error_message = " Adresse de courriel qui n'est pas au norme ";
    $smarty->assign('header_title'," Validation de l'examen ");
    $smarty->error($error_message);
    $smarty->assign('pupil',(array) $pupil);  
    $smarty->display('pupil_mail.tpl');    
  } else {
    $pupil->localisation=$localisation;
    $pupil->mail=$mail;
    $pupil->insert_into_ldap();
    // Au cas où l'élève est déjà dans la base C2I, synchronisation
    if (isset($c2i_db_host)) {
      try {
	$dbh = new PDO("mysql:host=$c2i_db_host;dbname=$c2i_db_database", $c2i_db_user, $c2i_db_password); 
	$query = "UPDATE c2iinscrits SET email='".$pupil->mail."' WHERE login='".$pupil->uid."';";
	//	print "REQUETE : $query <br>";
	$dbh->query($query);
	$dbh = null;
      } catch (PDOException $e) {
	print "ERREUR de connexion a la base <br>";
      }
    }
    pupil_infos();
  } 	     
}

function pupil_view_profile() {
    global $smarty;
    $user=$_SESSION['user'];
    $smarty->assign('user',(array) $user);
}
?>