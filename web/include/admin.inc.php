<?php

require_once('section-class.inc.php');
require_once('people-class.inc.php');
require_once('sconet-xml.php');
//require_once('mysql.inc.php');
//require_once('note-class.inc.php');

// admin view page.


function admin_view_school() {
  
  global $smarty;
  $user = $_SESSION['user'];
  $rne = $user->rne;
  $school= new school($rne);
  $title = "Gestion de l'&eacute;tablissement ".$school->rne."<br>\n";
  $title .= $school->name;

  $smarty->assign('header_title',$title);
  $smarty->assign('school',(array) $school);

  $smarty->display('admin_view_school.tpl');

}


function admin_init_menu() {

  global $smarty;
  $user = $_SESSION['user'];
  
  $lien_menu = 
    array('view_profile' => menu_link('menuform','admin','view_profile'),
	  'change_password' => menu_link('menuform','people','change_password'),
	  'view_school' => menu_link('menuform','admin','view_school'),
	  'list_sections' => menu_link('menuform','admin','list_sections'),
	  'list_pupils' => menu_link('menuform','admin','list_pupils'),
	  'list_teachers' => menu_link('menuform','admin','list_teachers'),
	  'import_pupils' => menu_link('menuform','admin','import_pupils'),
	  'reload_pupils' => menu_link('menuform','admin','reload_pupils'),
	  'import_teachers' => menu_link('menuform','admin','import_teachers'),
	  'import_sconet_pupils' => menu_link('menuform','admin','import_sconet_pupils'),
	  'note_pupils' => menu_link('menuform','admin','note_pupils'),
	  'logout'=>menu_link('menuform','logout','logout')	  
	    );
  if ($user->type == 'sadmin') {
    $lien_menu['sadmin_return'] = menu_link('menuform','admin','sadmin_return');
  }
  
  $smarty->assign('lien_menu',$lien_menu);
  
}

function admin_view_profile() {
  
  global $smarty;
  $user = $_SESSION['user'];

  $admin= new people($user->uid);

  $smarty->assign('header_title'," Donn&eacute;es personnelles ");
  $smarty->assign('admin',(array) $admin);  
  $smarty->display('admin_view_profile.tpl');
  
}

function admin_list_sections () {
  global $smarty;
  $user = $_SESSION['user'];

  $create_link=menu_link('sectioncreate','admin','create_section');
  $smarty->assign('create_link',$create_link);
  $smarty->assign('header_title','Gestion des classes');
  $sections = ldap_read_sections($user->rne);
 
  $smarty->assign('sections',$sections);
 
  $smarty->display('admin_list_sections.tpl');
}

function admin_create_section () {

  $user = $_SESSION['user'];
  $section['name']=$_POST['section'];
  $section['description']=$_POST['description'];
  $section = new section($section);
  $section->insert_into_ldap();

}

function admin_confirm_delete_section($name) {
  
  global $smarty;

  $section = new section($name);
  $smarty->assign('section',(array) $section);
  $smarty->assign('title_header',"Suppression de la classe $name");
  
  $smarty->assign('delete_link',menu_link('confirmform','admin','delete_section'));
  $smarty->assign('cancel_link',menu_link('confirmform','admin','list_sections'));
  $smarty->display('admin_confirm_delete_section.tpl');
    
}

function admin_delete_section($name) {

  $section = new section($name);
  $section->delete();

}

function admin_list_pupils($section) {
  global $smarty;
  global $current_year;

  $all_pupils=ldap_read_pupils($section);
  $pupils=$all_pupils['pupils'];
  $trashed=$all_pupils['trashed'];

  $smarty->assign('section',$section);
  $smarty->assign('header_title','Liste des &eacute;l&egrave;ves');  
  $smarty->assign('pupils',$pupils);
  $smarty->assign('trashed',$trashed);
  
  $remove_link=menu_link('pupilslist','admin','delete_selected_pupils');
  $password_link=menu_link('pupilslist','admin','reset_selected_pupils_password');
  $reload_link=menu_link('trashlist','admin','reload_selected_pupils');
  
  $smarty->assign('remove_link',$remove_link);
  $smarty->assign('password_link',$password_link);
  $smarty->assign('reload_link',$reload_link);

  $smarty->display('admin_list_pupils.tpl');
  
}

function admin_reload_pupils($section) {
  global $smarty;
  global $current_year;
  global $pupil_can_select;
  

  if ($pupil_can_select) {

    $all_pupils=ldap_read_pupils($section);
    $trashed=$all_pupils['trashed'];
    
    $smarty->assign('section',$section);
    $smarty->assign('header_title','Récupération d\'élèves');  
    $smarty->assign('trashed',$trashed);
    
    $reload_link=menu_link('trashlist','admin','reload_selected_pupils');
    
    $smarty->assign('reload_link',$reload_link);
    
    $smarty->display('admin_reload_pupils.tpl');
  } else {
    $smarty->warning( 'la période d\'inscription est close');
    admin_list_pupils($section);
  }
}

function admin_reset_pupil_password($uid) {
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

  $smarty->assign('header_title','RÃ©initialisation du mot de passe');  
  if ($error !='') $smarty->error($error);
  $smarty->assign('pupils',$pupils);
  $smarty->display('admin_reset_pupil_password.tpl');

}

function admin_reset_selected_pupils_password() {

  global $smarty;  

  foreach($_POST['pupils'] as $pupil) {
    $people = new people($pupil);

    $valid=true;
 
    if ($people->type!='pupil') {
      $error .= "l'identifiant ".$people->uid;
      $error .= " ne correspond pas &agrave; un &eacute;l&egrave;ve";
      $errot .= "<br>";
      $valid=false;
    }
    
    if ($people->rne!=$_SESSION['user']->rne) {
      $error .= " le RNE de l'&eacute;l&egrave;ve ne correspond pas";
      $error .= "<br>";
      $valid = false;
    }
    
    if ($valid) {
      $people->initiate_password();
      $peoples[$people->uid]=(array) $people;
    }
  }

  $_SESSION['pupils']=$peoples;

  $smarty->assign('header_title','Réinitialisation du mot de passe');
  $smarty->assign('pupils',$peoples);
  $smarty->display('admin_reset_pupil_password.tpl');
  
}

function admin_reset_all_pupils_password($section) {
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

  $smarty->assign('header_title','RÃ©initialisation du mot de passe');
  $smarty->assign('pupils',$pupils);
  $smarty->display('admin_reset_pupil_password.tpl');
  
}


function admin_delete_selected_pupils(){
  
  global $smarty, $pupil_can_select;

  if ($pupil_can_select) {
    //récupération des uid
    
    foreach($_POST['pupils'] as $pupil) {
      $people=new people($pupil);
      $people->delete();
    }
  } else {
    $smarty->warning('Période d\'inscription close');
  }
  admin_list_pupils($_POST['section']);
}


function admin_confirm_delete_pupil($uid) {

  global $smarty;
  
  $pupil = new people($uid);

  $smarty->assign('header_title','Suppression d\'un Ã©lÃ¨ve?');
  $smarty->assign('pupil',(array) $pupil);

  $params=array('uid'=>$uid);
  $smarty->assign('section',$_POST['section']);
  $smarty->assign('delete_link',menu_link('confirmform','admin','delete_pupil',$params));
  $smarty->assign('cancel_link',menu_link('confirmform','admin','list_pupils'));
  
  $smarty->display('admin_confirm_delete_pupil.tpl');

}

function admin_delete_pupil($uid) {

  global $smarty,$pupil_can_select;

  if ($pupil_can_select) {
   $people = new people($uid);
   $people->delete();
  } else {
    $smarty->warning('Période d\'inscription close');
  }
  admin_list_pupils($_POST['section']);

}


function admin_reload_pupil($uid) {

  global $current_year,$smarty;

  global $pupil_can_select;

  if ($pupil_can_select) {
    $people = new people($uid);
    if ($people->is_member('trash')) $people->del_from_group('trash');
    
    if (!$people->is_member('pupils')) $people->add_to_group('pupils');
    
    $section = $current_year."_".$people->rne."_".$people->section;
    
    if (!$people->is_member($section)) $people->add_to_group($section);
  } else {
       $smarty->warning('Période d\'inscription close'); 
  }
}

function admin_reload_selected_pupils() {
  global $pupil_can_select,$smarty;

  if ($pupil_can_select) {
    foreach ($_POST['trashed'] as $pupil) {
      admin_reload_pupil($pupil);
    }
  } else {
        $smarty->warning('Période d\'inscription close'); 
  }
   
}

function admin_edit_pupil($uid) {

  global $smarty;
 
  $pupil = new people($uid);

  $smarty->assign('header_title','Fiche &eacute;l&egrave;ve');
  $smarty->assign('pupil',(array) $pupil);

  $params=array('uid'=>$uid);
  $smarty->assign('valid_link',menu_link('confirmform','admin','modify_pupil',$params));
  $smarty->assign('cancel_link',menu_link('confirmform','admin','list_pupils'));
  
  $smarty->display('admin_edit_pupil.tpl');
}

function admin_import_pupils($msg='') {

  global $smarty;

  $smarty->assign('header_title','Importation des &eacute;l&egrave;ves');
  if ($error !='') $smarty->error($msg);
  $smarty->display('admin_import_pupils.tpl');

}

function admin_import_sconet_pupils($msg='') {

  global $pupil_can_import,$smarty;
  global $current_year;

  if ($pupil_can_import) {

    $smarty->assign('header_title','Importation des &eacute;l&egrave;ves &agrave; partir de SCONET');
    if ($msg != '')  {
      $smarty->error($msg);
    }
    $smarty->display('admin_import_sconet_pupils.tpl');
  } else {
    $smarty->assign('header_title','Gestion des classes');
    $smarty->warning('Import impossible, inscription closes');
    admin_list_sections();
  }

}

function admin_process_sconet_import() {
  
  global $pupil_can_import,$smarty;
  global $current_year;

  if ($pupil_can_import) {

    $rne=$_SESSION['user']->rne;
    
    $file = $_FILES['sconet_import_file']['tmp_name'];
    
    $valid=true;
    
    if (!is_uploaded_file($file)) {
      $valid = false;
      $error = "Probl&egrave;me dans le chargement du fichier";
    }
    
    if ($valid == true && filesize($file)==0){
      $valid = false;
      $error = "Votre fichier est vide!";
    }
    
    $tempdir=tempnam("/tmp","C2I");
    if ($tempdir==FALSE) {
      $valid = false;
      $error = "Cr&eacute;ation du fichier temporaire impossible";
    }
    
    unlink($tempdir);
    if (!mkdir("$tempdir")) {
      $valid = false;
      $error = "Cr&eacute;ation du fichier temporaire impossible";
    }
    
    exec("unzip $file -d $tempdir");
  
    if (file_exists("$tempdir/ElevesSansAdresses.xml")) {
      $eleves=process_sconet_xml("$tempdir/ElevesSansAdresses.xml");    
    } 
    else {
      $valid = false;
      $error = "Fichier ElevesSansAdresses.xml introuvable";
    }
    
    exec("rm -fr $tempdir");

    if ($valid == false) {
      admin_import_sconet_pupils($error);
      return (-1);
    } 
    else {
      $sections = array();
      // Creation du tableau des classes
      foreach($eleves as $eleve) {
	$sections[$eleve['section']]++;
      }
      $new_section_list=array();
      $old_section_list=array();
      foreach ($sections as $key=>$value) {
	$section=new section($key);
	$section_array=array();
	$section_array['code']=$current_year."_".$rne."_".$key;
	$section_array['name']=$key;
	if ($section->is_in_ldap()) {
	  $section_array['description']=$section->description;
	  array_push($old_section_list,$section_array);	
	} 
	else {
	  $section_array['description']="création automatiqueà l'import";
	  array_push($new_section_list,$section_array);
	}
      }
      
    // ENREGISTREMENT DES PARAMETRES DANS LA SESSION
      $_SESSION['SCONET']=$eleves;
      $_SESSION['SCONET_NEW_SECTIONS']=$new_section_list;
      
      // Affichage
    $smarty->assign('new_section_list',$new_section_list);
    $smarty->assign('old_section_list',$old_section_list);
    $smarty->assign('create_link',menu_link('confirmform','admin','process_sconet_import_create'));
    $smarty->assign('cancel_link',menu_link('confirmform','admin','import_sconet_pupils'));
    $smarty->display('admin_import_sconet_add_sections.tpl');
    
    return 0;
    } 
  } else {
    $smarty->warning('Import desactivé. Les inscriptions sont closes');
    admin_list_sections();
  }
}

function admin_process_pupils_import() {

  global $smarty;
  global $current_year;
  $rne=$_SESSION['user']->rne;
  $section_array=array();  
  $pupils=array();

  $valid=true;

  $file = $_FILES['pupils_import_file']['tmp_name'];

  if (!is_uploaded_file($file)) {
    $valid = false;
    $error = "Probl&egrave;me dans le chargement du fichier";
  }
  
  if ($valid == true && filesize($file)==0){
    $valid = false;
    $error = "Votre fichier est vide!";
  }

  if ($valid==true) {
    $handle=fopen($file,'r');
    if ($handle) {
      $header_line=trim(fgets($handle));
      // Analyse de l'entÃªte
      $header_array=explode(";",$header_line);
      foreach($header_array as $key=>$value) {
        $element=trim($value);
	$element=strtolower($element);
	if ($element!="") {
	  $column[$element]=$key;	
	}
      }

      if (!isset($column['ine'])) {
	$error .= "Colonne ine non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['nom'])) {
	$error .= "Colonne nom non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['prenom'])) {
	$error .= "Colonne prenom non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['date de naissance'])) {
	$error .= "Colonne date de naissance non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['sexe'])) {
	$error .= "Colonne sexe non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['rne'])) {
	$error .= "Colonne rne non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['division'])) {
	$error .= "Colonne division non d&eacute;finie<br>";
	$valid=false;}
      
      
      if ($valid == true) {      
	while (!feof($handle)) {	
	  $buffer = trim(fgets($handle));
	  $line = explode(";",$buffer);
	  if (count($line)>6) {
	    $pupil['ine']=trim($line[$column['ine']]);
	    $pupil['name']=trim($line[$column['nom']]);
	    $pupil['firstname']=trim($line[$column['prenom']]);
	    $pupil['rne']=trim($line[$column['rne']]);
	    $pupil['birth']=trim($line[$column['date de naissance']]);
	    $section=trim($line[$column['division']]);
	    $pupil['section']=$section;
	    $section_array[$section]='1';
	    $pupil['title']=trim($line[$column['sexe']]);
	    $pupil['type']='pupil';
	    array_push($pupils,$pupil);	  
	  }
	}
      }
      fclose($handle);
      } 
    }
    else {
      $valid=false;
      $error="Lecture du fichier $file impossible sur le serveur";
    }
    
    // Analyse du fichier
    
    if ($valid == false) {
      admin_import_pupils($error);
      exit;
    } 
    else {
      $new_section_list=array();
      $old_section_list=array();
      $create_section=false;

      $old_section_list = ldap_read_sections($rne);

      foreach ($section_array as $key=>$value) {      
	$section = new section($key);
	if (!$section->is_in_ldap()) {
	  $create_section=true;
	  $new_section['code']=$current_year."_".$rne."_".$key;
	  $new_section['name']=$key;
	  $new_section['description']="crÃ©ation automatique Ã  l'import";
	  array_push($new_section_list,$new_section);
	}	
      }
      $_SESSION['new_section_list']=$new_section_list;
      $_SESSION['pupils']=$pupils;    
      if ($create_section) {
	$smarty->assign('new_section_list',$new_section_list);
	$smarty->assign('old_section_list',$old_section_list);
	$smarty->assign('create_link',menu_link('confirmform','admin','process_import_create'));
	$smarty->assign('cancel_link',menu_link('confirmform','admin','import_pupils'));
	$smarty->display('admin_import_pupils_add_sections.tpl');
      } 
      else {
	admin_process_pupils_import_create();
      }
    } 
}

function admin_process_sconet_import_create() {
  global $smarty;
  global $current_year;
  $rne=$_SESSION['user']->rne;

  $eleves=$_SESSION['SCONET'];
  $new_section_list=$_SESSION['SCONET_NEW_SECTIONS'];
  if (isset($_POST['sections'])&&is_array($_POST['sections'])) {
    $sections=$_POST['sections'];
    foreach($sections as $section_name) {
      $section = new section($section_name);      
      $section->insert_into_ldap();      
    }
  }  

  ; 
  $sections_list = array();
  foreach ( ldap_read_sections($rne) as $section) {
    $sections_list[$section['name']]++;
  }
  
  foreach($eleves as $eleve) {
    if (isset($sections_list[strtolower($eleve['section'])])) {
      $pupil=new people($eleve);
      $pupil->insert_into_ldap();
      if (isset($pupil->pwdclear)) {
	$password_list[$pupil->uid]['uid']=$pupil->uid;
	$password_list[$pupil->uid]['cn']=$pupil->cn;
	$password_list[$pupil->uid]['password']=$pupil->pwdclear;
      } 
      else {
	$modified_list[$pupil->uid]['uid']=$pupil->uid;
	$modified_list[$pupil->uid]['cn']=$pupil->cn;	
      }
    }
  }

  $smarty->assign('header_title',"Import des eleves");
  $smarty->assign('password_list',$password_list);
  $smarty->assign('modified_list',$modified_list);
  $smarty->display('admin_import_pupils_success.tpl');

}

function admin_process_pupils_import_create() {

  global $current_year;
  global $smarty;
  $rne = $_SESSION['user']->rne;
  $new_section_list=$_SESSION['new_section_list'];
  $pupils=$_SESSION['pupils'];
  $password_list=array();

  foreach ($new_section_list as $new_section) {
    $section = new section($new_section);
    $section->insert_into_ldap();
  }

  foreach ($pupils as $new_pupil) {
    $create_pupil=true;
    $pupil= new people($new_pupil);
    if ($pupil->ine=='') {
      $error_msg.="l'Ã©lÃ¨ve ".$pupil->name." ".$pupil->firstname." n'a pas d'ine</br>\n";
      $create_pupil=false;
    } 
    else {
      //      if ($pupil->is_in_ldap()) {     
      //$error_msg.="l'Ã©lÃ¨ve ".$pupil->name." ".$pupil->firstname ." existe dÃ©jÃ  <br/>\n";
      //$create_pupil=false;
      //}
      if ($pupil->rne != $_SESSION['user']->rne) {
	$error_msg.="l'Ã©lÃ¨ve ".$pupil->name." ".$pupil->firstname."  n'a pas le bon RNE!<br/>\n";
	$create_pupil=false;	
      }
    }
    if ($create_pupil) {
      $pupil->insert_into_ldap();    
      $pupil->add_to_group($current_year."_".$rne."_".$pupil->section);     
      if (isset($pupil->pwdclear)) {
	$password_list[$pupil->uid]['uid']=$pupil->uid;
	$password_list[$pupil->uid]['cn']=$pupil->cn;
	$password_list[$pupil->uid]['password']=$pupil->pwdclear;
      } 
      else {
	$modified_list[$pupil->uid]['uid']=$pupil->uid;
	$modified_list[$pupil->uid]['cn']=$pupil->cn;	
      }
    }
  }
  
  $smarty->assign('header_title',"Import des eleves");
  if ($error !='') $smarty->error($error_msg);
  $smarty->assign('password_list',$password_list);
  $smarty->assign('modified_list',$modified_list);
  $smarty->display('admin_password_list.tpl');

}

/*fonction qui génère le formulaire de saisie des notes */
function admin_list_pupils_note($section) {
    global $smarty;
    global $current_year;
    
    $link=mysqlConnexion();
    $note=new note();
    $pupils=ldap_read_pupils($section);

    $chargement=$note->load_section($_SESSION['user']->rne,$section);
    if(!empty($chargement)){
       
        $smarty->assign('tab_load_note',$chargement);

    }else{
         foreach($pupils as $pupil){


            $chargement[$pupil['ine']]['a1']=0;
            $chargement[$pupil['ine']]['a2']=0;
             $chargement[$pupil['ine']]['b1']=0;
            $chargement[$pupil['ine']]['b2']=0;
        
          $chargement[$pupil['ine']]['b3']=0;
            $chargement[$pupil['ine']]['b4']=0;
            $chargement[$pupil['ine']]['b5']=0;
            $chargement[$pupil['ine']]['b6']=0;
            $chargement[$pupil['ine']]['b7']=0;

            $note =new note(
            $pupil['ine'],
            $pupil['name'],
            $pupil['firstname'],
            $pupil['rne'],
            $pupil['rne']."_".$section,
            $current_year,
            $chargement[$pupils['ine']]['a1'],
            $chargement[$pupils['ine']]['a2'],
            $chargement[$pupils['ine']]['b1'],
            $chargement[$pupils['ine']]['b2'],
            $chargement[$pupils['ine']]['b3'],
            $chargement[$pupils['ine']]['b4'],
            $chargement[$pupils['ine']]['b5'],
            $chargement[$pupils['ine']]['b6'],
            $chargement[$pupils['ine']]['b7']);
            $note->save();
    



            $smarty->assign('tab_load_note',$chargement);
    }
    }
    usort($pupils,"cmpTri");
    
    $smarty->assign('info',$pupils);
    $smarty->assign('section',$section);
    $smarty->assign('header_title'," Saisie des notes ");
    //$smarty->assign('info',$a_info_pupils);
   
    $smarty->assign('valid_link',menu_link('confirmform','admin','process_note_pupils'));
    $smarty->assign('cancel_link',menu_link('confirmform','admin','pupils_note'));
    $smarty->assign('export_link',menu_link('confirmform','admin','export_pupils_note'));
    $smarty->assign('import_link',menu_link('confirmform','admin','import_pupils_note'));
    $smarty->display('admin_note_pupils.tpl');


}

function admin_process_pupils_note($aa_note,$section){
    global $smarty;
    global $current_year;
    $link=mysqlConnexion();
    $a_pupils=ldap_read_pupils($section);
    
    foreach($a_pupils as $pupils){
    
    //print_r($_SESSION);
        $note =new note(
            $pupils['ine'],
            $pupils['name'],
            $pupils['firstname'],
            $pupils['rne'],
            $pupils['rne']."_".$section,
            $current_year,
            $aa_note[$pupils['ine']]['a1'],
            $aa_note[$pupils['ine']]['a2'],
            $aa_note[$pupils['ine']]['b1'],
            $aa_note[$pupils['ine']]['b2'],
            $aa_note[$pupils['ine']]['b3'],
            $aa_note[$pupils['ine']]['b4'],
            $aa_note[$pupils['ine']]['b5'],
            $aa_note[$pupils['ine']]['b6'],
            $aa_note[$pupils['ine']]['b7']);
            $note->save();
    }
       $smarty->assign('section',$section);
       $smarty->assign('header_title'," Vos notes sont enregistrÃ©es ");
       $smarty->display('admin_note_pupils_valide.tpl');
}


function admin_export_pupils_note($section){

       $pupil=new people();
       $link=mysqlConnexion();
       $note=new note();
       $aryInfoExportExcel=array();
       $chargement=$note->load_section($_SESSION['user']->rne,$section);

       if(!empty($chargement)){
           foreach($chargement as $key => $eval_pupil){
                $pupil->recover_from_ine($key);
                $aryInfoExportExcel[$key]['nom']=$pupil->name;
                $aryInfoExportExcel[$key]['prenom']=$pupil->firstname;
                $aryInfoExportExcel[$key]['b1']=$eval_pupil['b1'];
                $aryInfoExportExcel[$key]['b2']=$eval_pupil['b2'];
                $aryInfoExportExcel[$key]['b3']=$eval_pupil['b3'];
                $aryInfoExportExcel[$key]['b4']=$eval_pupil['b4'];
                $aryInfoExportExcel[$key]['b5']=$eval_pupil['b5'];
                $aryInfoExportExcel[$key]['b6']=$eval_pupil['b6'];
                $aryInfoExportExcel[$key]['b7']=$eval_pupil['b7'];
           }
       }

      // $pupil->recover_from_ine($ine);
       //print_r($chargement);
        $note->export_Excel_note_section($aryInfoExportExcel);
}

function admin_import_pupils_note($fichier,$section,$rne){
  
  $note=new note();
  $note->Import_Excel_note_section($fichier,$section,$rne);
  admin_list_pupils_note($section);
}

function admin_exportCSV($rne){

    $pupils = ldap_read_pupils();
    $pupils = $pupils['pupils'];

    header('Content-Type: application/csv-tab-delimited-table');
    header('Content-Disposition: attachment; filename="'.$rne.'_eleves.csv"');
    header('Pragma: no-cache');

    print "INE;Nom;Prenom;Login;Courriel;Naissance;RNE;Section;\n";

    foreach ($pupils as $pupil) {
	print $pupil['ine'].";";
	print $pupil['name'].";";
	print $pupil['firstname'].";";
	print $pupil['uid'].";";
	print $pupil['mail'].";";
	print $pupil['birth'].";";
	print $pupil['rne'].";";
	print $pupil['section'].";\n";	
    }  
}

function admin_export_password_CSV() {

  session_start();
  
  $pupils = $_SESSION['pupils'];
  
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="passwords.csv"');
  header('Pragma: no-cache');
  
  print "Nom;Login;Mot de passe;\n";
  
  foreach ($pupils as $pupil) {
    print $pupil['firstname']." ".$pupil['name'].";";
    print $pupil['uid'].";";
    print $pupil['pwdclear'].";\n";
  }  
   
  
}

  /*
 
 Fonctions de gestion des enseignants

   */

function admin_list_teachers() {
  global $smarty;

  $teachers=people::read_teachers($_SESSION['user']->rne);

  $smarty->assign('header_title','Liste des enseignants');
  
  $smarty->assign('teachers',$teachers);

  $smarty->assign('create_link',menu_link('list','admin','create_teacher'));

  $smarty->assign('password_link',menu_link('list','admin','reset_all_teachers_password'));

  $smarty->display('list_teachers.tpl');


}


function admin_modify_teacher($uid) {
  global $smarty;
  
  $smarty->assign('header_title','Modification d\'un enseignant');

  $teacher = new people($uid);

  admin_create_teacher((array) $teacher);

  exit;
}


function admin_create_teacher($teacher) {

  global $smarty;
  
  $smarty->assign('teacher',$teacher);
  $smarty->assign('rne',$_SESSION['user']->rne);

  $smarty->display('create_teacher.tpl');

  exit;

  
}

function admin_create_teacher_process() {
 global $smarty;

  try {
    $teacher = new people($_POST);
    
    if ($_POST['password']!="") {
      if ($_POST['password'] != $_POST['passverif']) {
	throw (new C2iException('passwords_dont_match'));
      } else {
	$teacher->pwdclear=$_POST['password']; 
      }
    }

    if ($_POST['uid']!="") {
      $teacher->modify_into_ldap();
    } else {
      $teacher->insert_into_ldap();
    }
    $teacher->synchro_teacher_SQL();
    admin_list_teachers();
  } catch (C2iException $exception) {
    $smarty->error($exception->getMessage()."<br><i>".$exception->getDetails()."</i>");    
    admin_create_teacher($_POST);
  }
}


function admin_delete_teacher($uid) {

  $people = new people($uid);
  $people->destroy();
  admin_list_teachers();

  exit;

}

function admin_delete_teacher_confirm($uid) {
  global $smarty;
  
  $smarty->assign('header_title','Suppression d\'un enseignant?');

  $teacher = new people($uid);
  
  $smarty->assign('teacher',(array) $teacher);

  $params=array('uid'=>$uid);

  $smarty->assign('delete_link',menu_link('confirmform','admin','delete_teacher',$params));
  $smarty->assign('cancel_link',menu_link('confirmform','admin','list_teachers'));
  
  $smarty->display('confirm_delete_teacher.tpl');

  exit;

}


function admin_import_teachers() {
  
  global $smarty;

  $smarty->assign('header_title','Importation des enseignants');
  $smarty->display('admin_import_teachers.tpl');

}

function admin_import_teachers_process() {
  global $smarty;
  
  $teachers=array();
  $valid=true;

  try {

    $file = $_FILES['teachers_import_file']['tmp_name'];

    if (!is_uploaded_file($file)) throw (new C2iException('no_file_upload'));
    
    if (filesize($file)==0) throw (new C2iException('empty_file_upload'));

    $handle=fopen($file,'r');
    if (!$handle) throw (new C2iException('no_file_open'));
    $header_line=trim(fgets($handle));
    // Analyse de l'entête
    $header_array=explode(";",$header_line);
    foreach($header_array as $key=>$value) {
      $element=trim($value);
      if ($element!="") {
	$column[$element]=$key;	
      }
    }
    if (!isset($column['RNE'])) {
      $error .= "Colonne RNE non d&eacute;finie<br>";
      $valid=false;}
    if (!isset($column['NOM'])) {
      $error .= "Colonne NOM non d&eacute;finie<br>";
      $valid=false;}
    if (!isset($column['PRENOM'])) {
      $error .= "Colonne PRENOM non d&eacute;finie<br>";
      $valid=false;}
    if (!isset($column['MAIL'])) {
      $error .= "Colonne MAIL non d&eacute;finie<br>";
      $valid=false;}
    if (!isset($column['SEXE'])) {
      $error .= "Colonne SEXE non d&eacute;finie<br>";
      $valid=false;}
    if ($valid == true) {      
      while (!feof($handle)) {	
	$buffer = trim(fgets($handle));
	$line = explode(";",$buffer);
	if (count($line)>4) {
	  $teacher['rne']=trim($line[$column['RNE']]);
	  $teacher['name']=trim($line[$column['NOM']]);
	  $teacher['firstname']=trim($line[$column['PRENOM']]);
	  $teacher['mail']=trim($line[$column['MAIL']]);
	  $teacher['title']=trim($line[$column['SEXE']]);
	  $teacher['type']='teacher';
	  if ($teacher['rne']!=$_SESSION['user']->rne) {
	    $error .= "l'enseignant ".$teacher['name']." ".$teacher['firstname']." a un mauvais RNE dans le fichier. Il ne sera pas incorporé <br>\n"; 
	  } else {
	    array_push($teachers,$teacher);	    
	  }
	}
      }
    } else {
      throw (new C2iException('bad_csv',$error));
    }
    fclose($handle);


    foreach($teachers as $new_teacher) {
      $teacher= new people($new_teacher);
      if ($teacher->is_in_ldap()) {
	$error .= $teacher->firstname." ".$teacher->name." est déjà enseignant de l'établissement ".$teacher->rne."<br>\n";  
      }
      else {
	$teacher->insert_into_ldap();
	$teacher->initiate_password();	
	$teacher->synchro_teacher_SQL();
	$new_teachers[$teacher->uid]=(array) $teacher;
      }
    }    
    
    $smarty->assign('header_title',"Import des enseignants");
    if ($error !='') $smarty->error($error);
    $smarty->assign('teachers',$new_teachers);
    $smarty->display('admin_reset_teacher_password.tpl');              
    
  } catch (C2iException $exception) {
    $smarty->error($exception->getMessage()."<br><i>".$exception->getDetails()."</i>");
    admin_import_teachers();
    exit;

    
  }
  
}

function admin_reset_teacher_password($uid) {
  global $smarty;

  $teacher = new people($uid);
  $valid=true;
  
  
  if ($teacher->type!='teacher') {
    $error .= "l'identifiant ".$teacher->uid;
    $error .= " ne correspond pas &agrave; un enseignant";
    $errot .= "<br>";
    $valid=false;
  }
  
  if ($valid) {
   $teacher->initiate_password();
  }

  $teachers[$teacher->uid]=(array) $teacher;

  $smarty->assign('header_title','Réinitialisation du mot de passe');  
  if ($error !='') $smarty->error($error);
  $smarty->assign('teachers',$teachers);
  $smarty->display('admin_reset_teacher_password.tpl');


}

function admin_reset_all_teachers_password() {
  global $smarty;

  $teachers_list = people::read_teachers($_SESSION['user']->rne);
  
  foreach ($teachers_list as $member) {
    $teacher=new people($member['uid']);

    $valid=true;
 
    if ($teacher->type!='teacher') {
      $error .= "l'identifiant ".$teacher->uid;
      $error .= " ne correspond pas &agrave; un enseignant";
      $errot .= "<br>";
      $valid=false;
    }
    
    if ($valid) {
      $teacher->initiate_password();
      $teachers[$teacher->uid]=(array) $teacher;
    }
  }
  
  $smarty->assign('header_title','Réinitialisation des mot de passe');
  $smarty->assign('teachers',$teachers);
  $smarty->display('admin_reset_teacher_password.tpl');

}

?>