<?php

require_once('section-class.inc.php');
require_once('sconet-xml.php');
//require_once('mysql.inc.php');
//require_once('note-class.inc.php');

// admin view page.


function teacher_init_menu() {

  global $smarty;
  $user = $_SESSION['user'];
  
  $lien_menu = 
    array('view_profile' => menu_link('menuform','teacher','view_profile'),
	  'change_password' => menu_link('menuform','people','change_password'),
	  'view_school' => menu_link('menuform','teacher','view_school'),
	  'list_sections' => menu_link('menuform','teacher','list_sections'),
	  'list_pupils' => menu_link('menuform','teacher','list_pupils'),
	  'logout'=>menu_link('menuform','logout','logout')	  
	    );
  if ($user->type == 'sadmin') {
    $lien_menu['sadmin_return'] = menu_link('menuform','admin','sadmin_return');
  }
  
  $smarty->assign('lien_menu',$lien_menu);
  
}

function teacher_view_profile() {
  
  global $smarty;
  $user = $_SESSION['user'];

  $teacher= new people($user->uid);

  $smarty->assign('header_title'," Donn&eacute;es personnelles ");
  $smarty->assign('teacher',(array) $teacher);  
  $smarty->display('teacher_view_profile.tpl');
  
}

function teacher_view_school() {
  
  global $smarty;
  $user = $_SESSION['user'];
  $rne = $user->rne;
  $school= new school($rne);
  $title = "Gestion de l'&eacute;tablissement ".$school->rne."<br>\n";
  $title .= $school->name;

  $smarty->assign('header_title',$title);
  $smarty->assign('school',(array) $school);

  $smarty->display('teacher_view_school.tpl');

}


function teacher_list_sections () {
  global $smarty;
  $user = $_SESSION['user'];

  $smarty->assign('create_link',$create_link);
  $smarty->assign('header_title','Gestion des classes');
  $sections = ldap_read_sections($user->rne);

 
  $smarty->assign('sections',$sections);
 
  $smarty->display('teacher_list_sections.tpl');
}

function teacher_list_pupils($section) {
  global $smarty;
  global $current_year;

  $pupils=ldap_read_pupils($section);
  $pupils=$pupils['pupils']; // on ne met pas les trashed

  $smarty->assign('header_title','Liste des &eacute;l&egrave;ves');  
  $smarty->assign('pupils',$pupils);
  if (isset($section)) {
    $params=array('section'=>$section) ;
    $password_link=menu_link('pupilslist','teacher','reset_all_pupils_password',$params);
  }
  else {
    $password_link=menu_link('pupilslist','teacher','reset_all_pupils_password');
  }
  $smarty->assign('reset_all_pwd_link',$password_link);
  $smarty->display('teacher_list_pupils.tpl');
  
}

function teacher_reset_pupil_password($uid) {
  global $smarty;

  $pupil = new people($uid);
  $valid=true;
  
  
  if ($pupil->type!='pupil') {
    $error .= "l'identifiant ".$pupil->uid;
    $error .= " ne correspond pas &agrave; un &eacute;l&egrave;ve";
    $errot .= "<br>";
    $valid=false;
  }
  
  if ($pupil->rne!=$_SESSION['user']->rne) {
    $error .= " le RNE de l'&eacute;l&egrave;ve ne correspond pas";
    $error .= "<br>";
    $valid = false;
  }

  if ($valid) {
   $pupil->initiate_password();
  }

  $pupils[$pupil->uid]=(array) $pupil;

  $smarty->assign('header_title','Réinitialisation du mot de passe');  
  $smarty->error($error);
  $smarty->assign('pupils',$pupils);
  $smarty->display('teacher_reset_pupil_password.tpl');

}

function teacher_reset_all_pupils_password($section) {
  global $smarty;
  session_start();

  $pupil_list = ldap_read_pupils($section);
  
  foreach ($pupil_list as $member) {
    $pupil=new people($member['uid']);

    $valid=true;
 
    if ($pupil->type!='pupil') {
      $error .= "l'identifiant ".$pupil->uid;
      $error .= " ne correspond pas &agrave; un &eacute;l&egrave;ve";
      $errot .= "<br>";
      $valid=false;
    }
    
    if ($pupil->rne!=$_SESSION['user']->rne) {
      $error .= " le RNE de l'&eacute;l&egrave;ve ne correspond pas";
      $error .= "<br>";
      $valid = false;
    }
    
    if ($valid) {
      $pupil->initiate_password();
      $pupils[$pupil->uid]=(array) $pupil;
    }
  }

  $_SESSION['pupils']=$pupils;

  $smarty->assign('header_title','Réinitialisation du mot de passe');
  $smarty->assign('pupils',$pupils);
  $smarty->display('teacher_reset_pupil_password.tpl');
  
}

?>